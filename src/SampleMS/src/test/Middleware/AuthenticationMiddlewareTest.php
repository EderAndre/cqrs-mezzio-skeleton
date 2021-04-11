<?php
declare(strict_types = 1);
namespace Com\Incoders\SampleMSTest\Middleware;

use Psr\Container\ContainerInterface;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Laminas\Diactoros\Response\JsonResponse;
use Com\Incoders\SampleMS\Middleware\AuthenticationMiddlewareFactory;
use Com\Incoders\SampleMS\Middleware\AuthenticationMiddleware;
use Com\Incoders\SampleMS\Infrastructure\Persistence\Repository\AuthClientsRepository;
use Com\Incoders\SampleMS\Infrastructure\Persistence\Repository\SyncUserInfoRepository;
use Com\Incoders\SampleMS\Infrastructure\Persistence\Repository\AuthProtocolBufferCachedRepository;
use Illuminate\Database\Capsule\Manager;
use Mezzio\Authentication\UserInterface;
use Mezzio\Router\RouteResult;
use Com\Incoders\SampleMS\Middleware\Service\ApiTools;

class AuthenticationMiddlewareTest extends TestCase
{

    protected $middleware;

    protected $apiResult;

    protected function setUp()
    {
        $this->initDb();
        $this->apiResult = $this->getMockBuilder(ApiTools::class)->getMock();
        $this->apiResult->method('consumeExternalApi')->willReturn([
            'content' => [],
            'httpCode' => 200
        ]);

        $this->middleware = new AuthenticationMiddleware([
            'BASE_URL' => 'https://agenciabeta.guarida.com.br',
            'USER_INFO_URL' => '/api/index/index?token=%s',
            'ECONOMIES_ALLOWED_URL' => '/api/imoveis?persona=%s&cpf_cnpj=%s&token=%s',
        ], $this->apiResult);
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

        $importSql = file_get_contents(__DIR__ . '/../resources/database/dump_xauthClient.sql');
        $this->db->statement($importSql);
        $importSql = file_get_contents(__DIR__ . '/../resources/database/inject_xauthClients.sql');
        $this->db->statement($importSql);
        $importSql = file_get_contents(__DIR__ . '/../resources/database/dump_xauthProtBuf.sql');
        $this->db->statement($importSql);
        $importSql = file_get_contents(__DIR__ . '/../resources/database/dump_syncUserInfo.sql');
        $this->db->statement($importSql);
    }

    public function testProcessEmpty()
    {
        $user = $this->createMock(UserInterface::class);
        $route = $this->createMock(RouteResult::class);
        $route->method('getMatchedParams')->willReturn([]);
        $request = $this->getMockBuilder(ServerRequestInterface::class)->getMock();
        $request->method('getHeaders')->willReturn([]);
        $request->method('getAttribute')->willReturn($route);
        $request->method('getAttribute')->will($this->returnValueMap([
            [
                UserInterface::class,
                $user
            ],
            [
                RouteResult::class,
                $route
            ]
        ]));

        $request->method('withAttribute')->willReturn($request);

        $handler = $this->getMockBuilder(RequestHandlerInterface::class)->getMock();
        $handler->method('handle')->willReturn($request);
        $this->assertEquals(get_class($this->middleware->process($request, $handler)), JsonResponse::class);
    }
    // @codeCoverageIgnoreStart
    public function testProcessUserToken()
    {
        $this->apiResult = $this->getMockBuilder(ApiTools::class)->getMock();
        $this->apiResult->method('consumeExternalApi')->willReturn([

            'content' => [
                'codigo_pessoa' => '1',
                'nome_pessoa' => 'Any Name',
                'email' => 'Any@domain.com',
                'email_notification' => '*',
                'push_notification' => '*',
                'sms_notification' => '*'
            ],
            'httpCode' => 200
        ]);

        $this->middleware = new AuthenticationMiddleware([
            'BASE_URL' => 'https://agenciabeta.guarida.com.br',
            'USER_INFO_URL' => '/api/index/index?token=%s',
            'ECONOMIES_ALLOWED_URL' => '/api/imoveis?persona=%s&cpf_cnpj=%s&token=%s',
        ], $this->apiResult);

        $user = $this->createMock(UserInterface::class);

        $user->method('getMatchedParams')->willReturn([]);

        $route = $this->createMock(RouteResult::class);
        $route->method('getMatchedParams')->willReturn([]);
        $request = $this->createMock(ServerRequestInterface::class);
        $request->method('getHeaders')->willReturn([
            'x-api-client' => [
                'user_logged'
            ],
            'x-user-token' => [
                'dsdsd'
            ],
            'x-api-key' => [
                'kouX3CH9PQiqoDZOJOjI44JgP5ws4Qtf3L0UdxUQe24qv'
            ]
        ]);

        $request->method('getAttribute')->will($this->returnValueMap([
            [
                UserInterface::class,
                $user
            ],
            [
                RouteResult::class,
                $route
            ]
        ]));
        $request->method('withAttribute')->willReturn($request);

        $handler = $this->createMock(RequestHandlerInterface::class);
        $handler->method('handle')->will($this->returnValue($request));
        $this->assertEquals(get_class($this->middleware->process($request, $handler)), JsonResponse::class);
    }

    public function testProcessUserTokenBuffered()
    {
        $inBuffer = new AuthProtocolBufferCachedRepository();
        $inBuffer->id = 1;
        $inBuffer->clientApiName = 'user_logged';
        $inBuffer->clientApiHashedKey = '$2y$10$OisobpgzDkJwxusRlM/2mu65MqBsPgw1RHvbTU3YsojSK7dFA8pju';
        $inBuffer->userToken = 'dsdsd';
        $inBuffer->userInfoCached = '{"
            userId":"38187",
            "details":{"
                displayName":"DAMIEN VIANA ALVES",
                "email":"vnicius@gmail.com",
                "describeRoles":{"
                    homeowner":{"
                        1234":{"
                            stakeholderName":"JANAINA AGUIAR DE SOUZA",
                            "stakeholderEmail":"janaina.souza@guarida.com.br"
                        },
                        "1578":{"
                            stakeholderName":"LIONAJA SIEBRA DOS REIS",
                            "stakeholderEmail":"lionaja.reis@guarida.com.br"
                        }
                    },
                    "syndic":{"
                        1916":{"
                            stakeholderName":"LIONAJA SIEBRA DOS REIS",
                            "stakeholderEmail":"lionaja.reis@guarida.com.br"
                        },
                        "3412":{"
                            stakeholderName":"LIONAJA SIEBRA DOS REIS",
                            "stakeholderEmail":"lionaja.reis@guarida.com.br"
                        },
                        "3111":{"
                            stakeholderName":"LIONAJA SIEBRA DOS REIS",
                            "stakeholderEmail":"lionaja.reis@guarida.com.br"
                        },
                        "1578":{"
                            stakeholderName":"LIONAJA SIEBRA DOS REIS",
                            "stakeholderEmail":"lionaja.reis@guarida.com.br"
                        },
                        "2687":{"
                            stakeholderName":"MICHELLE DOS SANTOS PINTO GONCALVES",
                            "stakeholderEmail":"michelle.santos@guarida.com.br"
                        },
                        "487":{"
                            stakeholderName":"LIONAJA SIEBRA DOS REIS",
                            "stakeholderEmail":"lionaja.reis@guarida.com.br"
                        },
                        "3652":{"
                            stakeholderName":"LIONAJA SIEBRA DOS REIS",
                            "stakeholderEmail":"lionaja.reis@guarida.com.br"
                        },
                        "2004":{"
                            stakeholderName":"LIONAJA SIEBRA DOS REIS",
                            "stakeholderEmail":"lionaja.reis@guarida.com.br"
                        }
                    }
                }
            },
            "roles":["homeowner","syndic"]
        }';
        $inBuffer->expiresOn = date('Y') . "-12-31 23:59:59.0000000";

        $this->apiResult = $this->getMockBuilder(ApiTools::class)->getMock();
        $this->apiResult->method('consumeExternalApi')->willReturn([

            'content' => [
                'codigo_pessoa' => '1',
                'nome_pessoa' => 'Any Name',
                'email' => 'Any@domain.com',
                'email_notification' => '*',
                'push_notification' => '*',
                'sms_notification' => '*'
            ],
            'httpCode' => 200
        ]);

        $this->middleware = new AuthenticationMiddleware([
            'BASE_URL' => 'https://agenciabeta.guarida.com.br',
            'USER_INFO_URL' => '/api/index/index?token=%s',
            'ECONOMIES_ALLOWED_URL' => '/api/imoveis?persona=%s&cpf_cnpj=%s&token=%s',
        ], $this->apiResult);

        $user = $this->createMock(UserInterface::class);

        $user->method('getMatchedParams')->willReturn([]);

        $route = $this->createMock(RouteResult::class);

        $request = $this->getMockBuilder(ServerRequestInterface::class)->getMock();

        $request->method('getHeaders')->willReturn([
            'x-api-client' => [
                'user_logged'
            ],
            'x-user-token' => [
                'dsdsd'
            ],
            'x-api-key' => [
                'kouX3CH9PQiqoDZOJOjI44JgP5ws4Qtf3L0UdxUQe24qv'
            ]
        ]);

        $request->method('getAttribute')->willReturn($user);
        $request->method('withAttribute')->willReturn($request);

        $handler = $this->createMock(RequestHandlerInterface::class);
        $handler->method('handle')->willReturn($request);
        $this->assertEquals(get_class($this->middleware->process($request, $handler)), JsonResponse::class);
    }

    public function testProcessClient()
    {
        $user = $this->createMock(UserInterface::class);

        $user->method('getMatchedParams')->willReturn([]);

        $route = $this->createMock(RouteResult::class);

        $request = $this->createMock(ServerRequestInterface::class);

        $request->method('getHeaders')->willReturn([
            'x-api-client' => [
                'client_test'
            ],
            'x-app-id' => [
                'APP1'
            ],
            'x-api-key' => [
                'Vd1BvuKn9lTlvAjZTAV2wT6bSbj3ZlUIpJ9I3JV0SEbb3'
            ]
        ]);
        $request->method('getAttribute')->willReturn($user);

        $request->method('withAttribute')->willReturn($request);

        $handler = $this->getMockBuilder(RequestHandlerInterface::class)->getMock();
        $handler->method('handle')->willReturn($request);
        $this->assertEquals(get_class($this->middleware->process($request, $handler)), JsonResponse::class);
    }
    // @codeCoverageIgnoreEnd
    public function testProcessClientUrlBroken()
    {
        $route = $this->createMock(RouteResult::class);
        $request = $this->getMockBuilder(ServerRequestInterface::class)->getMock();
        $request->method('getHeaders')->willReturn([
            'x-api-client' => [
                'client_test'
            ],
            'x-app-id' => [
                'APP1'
            ],
            'x-api-key' => [
                'Vd1BvuKn9lTlvAjZTAV2wT6bSbj3ZlUIpJ9I3JV0SEbb3'
            ]
        ]);
        $request->method('getAttribute')->willReturn($route);
        $request->method('getAttribute')->willReturn([]);

        $request->method('withAttribute')->willReturn($request);

        $handler = $this->getMockBuilder(RequestHandlerInterface::class)->getMock();
        $handler->method('handle')->willReturn($request);
        $this->assertEquals(get_class($this->middleware->process($request, $handler)), JsonResponse::class);
    }
}
