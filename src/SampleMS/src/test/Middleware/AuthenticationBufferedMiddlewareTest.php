<?php
declare(strict_types = 1);
namespace Com\Incoders\SampleMSTest\Middleware;

use Psr\Container\ContainerInterface;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Com\Incoders\SampleMS\Middleware\AuthenticationBufferedMiddleware;
use Com\Incoders\SampleMS\Infrastructure\Persistence\Repository\AuthProtocolBufferCachedRepository;
use Illuminate\Database\Capsule\Manager;
use Mezzio\Authentication\UserInterface;
use Mezzio\Router\RouteResult;
use DateTime;
use DateInterval;

class AuthenticationBufferedMiddlewareTest extends TestCase
{

    protected $middleware;

    protected function setUp()
    {
        $this->middleware = new AuthenticationBufferedMiddleware();
        $this->initDb();
        $request = $this->getMockBuilder(ServerRequestInterface::class)->getMock();
        $request->method('getHeaders')->willReturn([]);
        $handler = $this->getMockBuilder(RequestHandlerInterface::class)->getMock();
    }

    protected function initDb()
    {
        $capsule = new Manager();
        $capsule->addConnection([
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
        $capsule->setAsGlobal();
        $capsule->bootEloquent();
        $this->db = $capsule->getDatabaseManager();

        $importSql = file_get_contents(__DIR__ . '/../resources/database/dump_xauthProtBuf.sql');
        $this->db->statement($importSql);

        $userBuffered = new AuthProtocolBufferCachedRepository();
        $userBuffered->id = 1;
        $userBuffered->clientApiName = 'user_logged';
        $userBuffered->clientApiHashedKey = password_hash('secret', PASSWORD_DEFAULT);
        $userBuffered->userToken = '1';
        $userBuffered->userInfoCached = json_encode([
            'userId' => '552',
            'details' => [
                'displayName' => 'name',
                'email' => 'test@test.com'
            ],
            'roles' => [
                'homeowner' => [
                    '5524' => null
                ]
            ]
        ]);

        $time = new DateTime();
        $time->add(new DateInterval('PT10M'));

        $userBuffered->expiresOn = $time;
        $userBuffered->save();
    }

    public function testProcessUserToken()
    {
        $request = $this->getMockBuilder(ServerRequestInterface::class)->getMock();
        $request->method('getHeaders')->willReturn([
            'x-api-client' => [
                'user_logged'
            ],
            'x-user-token' => [
                '1'
            ],
            'x-api-key' => [
                'secret'
            ]
        ]);
        $request->method('getUri')->willReturn(new class() {

            // @codeCoverageIgnoreStart
            function getPath()
            {
                return '/profile/homeowner/userid/552/condomid/5524';
            }
        });
        $request->method('getAttribute')->willReturn(new class() {

            function getIdentity()
            {
                return '552';
            }

            function getDetails()
            {
                return [];
            }

            function getRoles()
            {
                return [
                    'homeowner' => [
                        '5524' => null
                    ]
                ];
            }
            function getMatchedParams()
            {
                return [
                    'profile' => 'homeowner',
                        'condid'=>'5524',
                    'userId'=>'552'
                ];
            }
            // @codeCoverageIgnoreEnd
        });
        $request->method('withAttribute')->willReturn($request);

        $handler = $this->getMockBuilder(RequestHandlerInterface::class)->getMock();
        $resp = $this->getMockBuilder(ResponseInterface::class)->getMock();
        $handler->method('handle')->willReturn($resp);


        $req = $this->middleware->process($request, $handler);

        $this->assertIsObject($request->getAttribute(UserInterface::class));
    }

    public function testProcessUserTokenFail()
    {
        $request = $this->getMockBuilder(ServerRequestInterface::class)->getMock();
        $request->method('getHeaders')->willReturn([
            'x-api-client' => [
                'user_logged'
            ],

            'x-api-key' => [
                'secret'
            ]
        ]);
        $request->method('getUri')->willReturn(new class() {

            // @codeCoverageIgnoreStart
            function getPath()
            {
                return '/profile/homeowner/userid/552/condomid/5524';
            }
        });

        $request->method('getAttribute')->willReturn(new class() {

            function getIdentity()
            {
                return '552';
            }

            function getDetails()
            {
                return [];
            }

            function getRoles()
            {
                return [
                    'homeowner' => [
                        '5524' => null
                    ]
                ];
            }

            // @codeCoverageIgnoreEnd
        });
        $request->method('withAttribute')->willReturn($request);

        $handler = $this->getMockBuilder(RequestHandlerInterface::class)->getMock();
        $resp = $this->getMockBuilder(ResponseInterface::class)->getMock();
        $handler->method('handle')->willReturn($resp);
        $req = $this->middleware->process($request, $handler);
        $this->assertIsObject($request->getAttribute(UserInterface::class));
    }
    public function testUserExistsReturnFalse()
    {
        $req = $this->middleware->userExistsInBufferAndIsValid([]);
        $this->assertFalse($req);
    }
}
