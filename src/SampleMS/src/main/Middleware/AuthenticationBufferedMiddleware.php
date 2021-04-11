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
use Com\Incoders\SampleMS\Domain\Auth\Client;
use Mezzio\Authentication\DefaultUser;
use DateTime;

class AuthenticationBufferedMiddleware implements MiddlewareInterface
{

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $headers = $request->getHeaders();
        $client = isset($headers['x-api-client'][0]) ? $headers['x-api-client'][0] : false;
        $key = isset($headers['x-api-key'][0]) ? $headers['x-api-key'][0] : false;
        $token = isset($headers['x-user-token'][0]) ? $headers['x-user-token'][0] : false;

        if ($client && $key && $token) :
            $userInBuffer = $this->userExistsInBufferAndIsValid($headers);
            if ($userInBuffer) :
                $request = $request->withAttribute(
                    UserInterface::class,
                    new DefaultUser(
                        $userInBuffer['userId'],
                        $userInBuffer['roles'],
                        $userInBuffer['details']
                    )
                );
                $response = $handler->handle($request);
            else :
                $response = $handler->handle($request);
            endif;
        else :
            $response = $handler->handle($request);
        endif;

        return $response;
    }

    public function userExistsInBufferAndIsValid($headers)
    {
        $token = isset($headers['x-user-token'][0]) ? $headers['x-user-token'][0] : false;
        $key = isset($headers['x-api-key'][0]) ? $headers['x-api-key'][0] : false;
        $clientName = isset($headers['x-api-client'][0]) ? $headers['x-api-client'][0] : false;
        $time = new DateTime();
        $sqlTimestamp = $time->format('Y-m-d H:i:s');
        $params = [
            'clientApiName' => $clientName,
            'userToken' => $token,
            'sqlTimestamp' => $sqlTimestamp
        ];
        $authBuffer = new AuthProtocolBufferCachedRepository();
        $result = $authBuffer->findUnexpiratedProtocol($params);

        if (count($result) > 0 && password_verify($key, $result['clientApiHashedKey'])) :
            return json_decode($result['userInfoCached'], true);
        endif;

        return false;
    }
}
