<?php
declare(strict_types = 1);
namespace Com\Incoders\SampleMS\Middleware;

use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseInterface;
use Mezzio\Authentication\UserInterface;
use Laminas\Diactoros\Response\JsonResponse;
use Laminas\Diactoros\Response\RedirectResponse;
use Laminas\Diactoros\Response;
use Com\Incoders\SampleMS\Infrastructure\Persistence\Repository\AuthClientsRepository;
use Com\Incoders\SampleMS\Infrastructure\Persistence\Repository\AuthProtocolBufferCachedRepository;
use Com\Incoders\SampleMS\Infrastructure\Persistence\Repository\SyncUserInfoRepository;
use Com\Incoders\SampleMS\Domain\Auth\Client;
use Mezzio\Authentication\DefaultUser;
use Mezzio\Router\RouteResult;
use DateTime;
use DateInterval;
use Com\Incoders\SampleMS\Middleware\Service\ApiTools;

class AuthenticationMiddleware implements MiddlewareInterface
{

    protected $configs;
    protected $api;

    public function __construct(array $configs, ApiTools $api)
    {
        $this->configs = $configs;
        $this->api = $api;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $response = new JsonResponse('Access Denied', 403);
        $headers = $request->getHeaders();
        $token = isset($headers['x-user-token'][0]) ? $headers['x-user-token'][0] : false;
        $router = $request->getAttribute(RouteResult::class);
        $pathParams = $router->getMatchedParams();
        $client = $this->authenticate($headers);
        $userInBuffer = $request->getAttribute(UserInterface::class);

        if (!$client->authenticated) :
            $response = new JsonResponse($client->message, 401);
        elseif ($client->authenticated && ! $client->requestUserToken) :
            $apiClient = new DefaultUser($headers['x-app-id'][0], [
                'API'
            ], [
                'API CLient'
            ]);
            $request = $request->withAttribute(UserInterface::class, $apiClient);
            $response = $handler->handle($request);
        elseif (isset($userInBuffer) && $client->authenticated && $client->requestUserToken) :
            $user['userId'] = $userInBuffer->getIdentity();
            $user['roles'] = $userInBuffer->getRoles();
            $user['details'] = $userInBuffer->getDetails();
            $params = $pathParams;
            $authorization = $this->userAllowed($params, $user);
            $request = $request->withAttribute('pathParams', (object) $params);
            if ($authorization['status'] == 'ALLOW') :
                $request = $request->withAttribute(UserInterface::class, $userInBuffer);
                $response = $handler->handle($request);
            else :
                $response = new JsonResponse($authorization, 401);
            endif;
        elseif ($client->authenticated && $client->requestUserToken) :
            $user = $this->getUserInfo($token);
            $authorization = $this->userAllowed($pathParams, $user);

            if ($authorization['status'] == 'ALLOW') :
                $this->bufferingUser($headers, $user);
                $user = new DefaultUser($user['userId'], $user['roles'], $user['details']);
                $request = $request->withAttribute(UserInterface::class, $user);
                $response = $handler->handle($request);
            else :
                $response = new JsonResponse($authorization);
            endif;
        else :
            $response = new JsonResponse('Invalid APi Key', 403);
        endif;

        return $response;
    }

    public function userAllowed(array $urlParams, array $user)
    {
        $result['status'] = 'DENY';
        $result['message'] = '-';

        if (count($urlParams) == 0) :
            $result['message'] = 'Invalid URL';
        elseif (isset($user['userId']) && $user['userId'] != $urlParams['userid']) :
            $result['message'] = 'You cannot request information from another user';
        elseif (empty($user['details']['describeRoles'][$urlParams['profile']])) :
            $result['message'] = 'You do not have access to this profile';
        elseif (array_key_exists($urlParams['condid'], $user['details']['describeRoles'][$urlParams['profile']])) :
            $result['status'] = 'ALLOW';
            return $result;
        else :
            $result['message'] = "You do not have permission to view  this condominium with the profile " .
                $urlParams['profile'];
        endif;
        return $result;
    }

    private function authenticate(array $headers): Client
    {
        $consumer = isset($headers['x-app-id'][0]) ? $headers['x-app-id'][0] : false;
        $key = isset($headers['x-api-key'][0]) ? $headers['x-api-key'][0] : false;
        $clientName = isset($headers['x-api-client'][0]) ? $headers['x-api-client'][0] : false;
        $clientRequireUserToken = false;
        $clientAuthenticated = false;
        $message = 'Authentication Failed - check your api key and client name';
        $status = 'ERROR';
        if ($key && $clientName) :
            $client = new AuthClientsRepository();

            $clientRepository = $client->findByClientName($clientName);
            if (count($clientRepository) > 0) :
                $hashed = $clientRepository['secret'];
                $clientRequireUserToken = $clientRepository['require_user_token'] == 1 ? true : false;

                if ($clientRequireUserToken) :
                    $clientAuthenticated = password_verify($key, $hashed) && isset($headers['x-user-token'][0]);
                    $message = $clientAuthenticated ? 'Client Looged' : 'Authentication Failed';
                    $status = $clientAuthenticated ? 'SUCCESS' : 'ERROR';
                else :
                    $clientAuthenticated = password_verify($key, $hashed) &&
                        $clientRepository['app_consumer'] == $consumer;
                    $message = $clientAuthenticated ? 'Client Looged' : 'Authentication Failed';
                    $status = $clientAuthenticated ? 'SUCCESS' : 'ERROR';
                endif;
            endif;
        endif;


        return new Client($clientAuthenticated, $clientRequireUserToken, $status, $message);
    }

    public function getUserInfo($token, $api = null)
    {
        $api = $api ?? $this->api;
        $url = $this->configs['BASE_URL'] . sprintf($this->configs['USER_INFO_URL'], $token);
        $response = $api->consumeExternalApi($url);
        if ($response['httpCode'] == 200) :
            $result = $response['content'];
            $userData = $result['data'];
            $userRoles = $result['user']['profiles'];
            $user['userId'] = $userData['data']['codigo_pessoa'];
            $user['details']['displayName'] = $userData['data']['nome_pessoa'];
            $user['details']['email'] = $userData['data']['email'];
            $user['details']['describeRoles'] = [];
            $user['roles'] = $userRoles;
            foreach ($userRoles as $k => $roles) :
                $user['details']['describeRoles'][$roles] = $this->getAllowedCondominiums(
                    $roles,
                    $userData['data']['cpf_cnpj'],
                    $token
                );
            endforeach
            ;
            $this->saveSyncUserInfo($token, $user['userId']);
            $response = $user;
        else :
            $response = [
                'Agencia virtual: Server request error' => $response['httpCode']
            ];
        endif;
        return $response;
    }

    public function saveSyncUserInfo($token, $userId, $api = null)
    {
        $api = $api ?? $this->api;
        $url = $this->configs['BASE_URL'] . sprintf($this->configs['USER_COMPLEMENTARY_INFO_URL'], $token, $userId);
        $response = $api->consumeExternalApi($url);
        if ($response['httpCode'] == 200) :
            $result = $response['content'];

            $syncUser = new SyncUserInfoRepository();
            $syncUser = $syncUser->firstOrNew([
                'userId' => $result['codigo_pessoa']
            ]);

            $syncUser->displayName = $result['nome_pessoa'];
            $syncUser->email = $result['email'];
            $syncUser->emailNotification = $result['email_notification'];
            $syncUser->pushNotification = $result['push_notification'];
            $syncUser->smsNotification = $result['sms_notification'];

            $time = new DateTime();
            $syncUser->lastAccessOn = $time->format('Y-m-d H:i');

            $response = $syncUser->save();
        else :
            $response = false;
        endif;
        return $response;
    }

    public function getAllowedCondominiums(string $profile, string $cpf, string $token, $api = null)
    {
        $api = $api ?? $this->api;
        $url = $this->configs['BASE_URL'] . sprintf($this->configs['ECONOMIES_ALLOWED_URL'], $profile, $cpf, $token);
        $response = $api->consumeExternalApi($url);
        $result = $response['content']['data'];
        $temp = [];
        foreach ($result as $re) {
            $temp[$re['codcondom']] = [
                'stakeholderName' => !empty($re['nome_consultor'])?$re['nome_consultor']:null,
                'stakeholderEmail' => !empty($re['email'])?$re['email']:null
            ];
        }
        return $temp;
    }

    public function bufferingUser($headers, $user)
    {
        $token = isset($headers['x-user-token'][0]) ? $headers['x-user-token'][0] : false;
        $key = isset($headers['x-api-key'][0]) ? $headers['x-api-key'][0] : false;
        $clientName = isset($headers['x-api-client'][0]) ? $headers['x-api-client'][0] : false;
        $authBuffer = new AuthProtocolBufferCachedRepository();
        $authBuffer->clientApiName = $clientName;
        $authBuffer->clientApiHashedKey = password_hash($key, PASSWORD_DEFAULT);
        $authBuffer->userToken = $token;
        $time = new DateTime();
        $time->add(new DateInterval('PT' . $this->configs['TIME_TO_BUFFER_IN_MINUTES'] . 'M'));
        $authBuffer->expiresOn = $time->format('Y-m-d H:i');
        $authBuffer->userInfoCached = json_encode($user);
        return $authBuffer->save();
    }
}
