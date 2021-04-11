<?php

declare(strict_types = 1);

namespace Com\Incoders\SampleMSTest\Middleware\pb;

use Psr\Container\ContainerInterface;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Laminas\Diactoros\Response\JsonResponse;
use Com\Incoders\SampleMS\Middleware\AuthenticationMiddlewareFactory;
use Com\Incoders\SampleMS\Middleware\AuthenticationMiddleware;
use Com\Incoders\SampleMS\Infrastructure\Persistence\Repository\AuthClientsRepository;
use Illuminate\Database\Capsule\Manager;
use Com\Incoders\SampleMS\Middleware\Service\ApiTools;

class AuthenticationMiddlewarePublicMethodsTest extends TestCase
{
    protected $middleware;
    protected $apiResult;

    protected function setUp()
    {
        $this->initDb();
        $request = $this->getMockBuilder(ServerRequestInterface::class)->getMock();
        $request->method('getHeaders')->willReturn([]);
        $this->apiResult = $this->getMockBuilder(ApiTools::class)->getMock();
        $this->apiResult->method('consumeExternalApi')->willReturn([
            'content' => [],
            'httpCode' => 200

        ]);

        $handler = $this->getMockBuilder(RequestHandlerInterface::class)->getMock();

        $this->middleware = new AuthenticationMiddleware(
            [
                'BASE_URL' => 'https://agenciabeta.guarida.com.br',
                'USER_INFO_URL' => '/api/index/index?token=%s',
                'USER_COMPLEMENTARY_INFO_URL'=>'/api/index/index?token=%s',
                'ECONOMIES_ALLOWED_URL' => '/api/imoveis?persona=%s&cpf_cnpj=%s&token=%s',
                'TIME_TO_BUFFER_IN_MINUTES' => 10
            ],
            $this->apiResult
        );
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

        // loading simple DB tables creation
        $importSql = file_get_contents(__DIR__ . '/../resources/database/dump_xauthClient.sql');
        $this->db->statement($importSql);
        $importSql = file_get_contents(__DIR__ . '/../resources/database/inject_xauthClients.sql');
        $this->db->statement($importSql);
        $importSql = file_get_contents(__DIR__ . '/../resources/database/dump_xauthProtBuf.sql');
        $this->db->statement($importSql);
        $importSql = file_get_contents(__DIR__ . '/../resources/database/dump_syncUserInfo.sql');
        $this->db->statement($importSql);
    }

    public function testProcessUserAllowed()
    {
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
        $request->method('getUri')->willReturn(new class() {

            function getPath()
            {
                return '/profile/homeowner/userid/201065/condid/3003';
            }
        });
        $request->method('withAttribute')->willReturn(true);

        $handler = $this->getMockBuilder(RequestHandlerInterface::class)->getMock();
        $handler->method('handle')->willReturn(true);

        $result = $this->middleware->userAllowed([
            'userid' => '12',
            'profile' => 'homeowner',
            'condid' => '3003'
        ], [
            'userId' => '13'
        ]);
        $this->assertEquals($result['message'], 'You cannot request information from another user');

        $result = $this->middleware->userAllowed([
            'userid' => '12',
            'profile' => 'homeowner5',
            'condid' => '3003'
        ], [
            'userId' => '12',
            'roles' => [
                'homeowner'
            ],
            'details' => [
                'describeRoles'=>[
                    'homeowner' => [
                        '3003'
                    ]
                ]

            ]
        ]);
        $this->assertEquals($result['message'], 'You do not have access to this profile');

        $result = $this->middleware->userAllowed([
            'userid' => '15',
            'profile' => 'homeowner',
            'condid' => '3003'
        ], [
            'userId' => '15',
            'roles' => [
                'homeowner'
            ],
            'details' => [
                'describeRoles'=>[
                    'homeowner' => [
                        '3003'
                    ]
                ]

            ]
        ]);

        $this->assertEquals(
            $result['message'],
            'You do not have permission to view  this condominium with the profile homeowner'
        );

        $result = $this->middleware->userAllowed(
            [
                'userid' => '15',
                'profile' => 'homeowner',
                'condid' => '3003'
            ],
            [
                'userId' => '15',
                'roles' => [
                    'homeowner'
                ],
                'details' => [
                    'describeRoles'=>[
                        'homeowner' => [
                            '3007'
                        ]
                    ]
                ]
            ]
        );

        $this->assertEquals(
            $result['message'],
            'You do not have permission to view  this condominium with the profile homeowner'
        );

        $result = $this->middleware->userAllowed([], [
            'userId' => '15',
            'roles' => [
                'homeowner' => [
                    '3007'
                ]
            ]
        ]);

        $this->assertEquals(
            $result['message'],
            'Invalid URL'
        );

        $result = $this->middleware->userAllowed(
            [
                'userid' => '15',
                'profile' => 'homeowner',
                'condid' => '3003'
            ],
            [
                'userId' => '15',
                'roles' => [
                    'homeowner'
                ],
                'details' => [
                    'describeRoles'=>[
                        'homeowner' => [
                            '3003'=>['infos']
                        ]
                    ]
                ]
            ]
        );

        $this->assertEquals(
            $result['status'],
            'ALLOW'
        );
    }


    public function testBufferingUseri()
    {
        $result = $this->middleware->bufferingUser([
            'x-api-client' => [
                'user_logged'
            ],
            'x-user-token' => [
                'dsdsd'
            ],
            'x-api-key' => [
                'kouX3CH9PQiqoDZOJOjI44JgP5ws4Qtf3L0UdxUQe24qv'
            ]
        ], [
            'userId' => '13'
        ]);
        $this->assertEquals($result, true);
    }

    public function testSaveSyncUserInfo()
    {
        $this->apiResult = $this->getMockBuilder(ApiTools::class)->getMock();
        $this->apiResult->method('consumeExternalApi')->willReturn(
            [
                'content' => [
                    'codigo_pessoa' => '1',
                    'nome_pessoa' => 'Any Name',
                    'email' => 'Any@domain.com',
                    'email_notification'=>'*',
                    'push_notification'=>'*',
                    'sms_notification'=>'*'
                ],
                'httpCode' => 200
            ]
        );

        $this->middleware = new AuthenticationMiddleware(
            [
                'BASE_URL' => 'https://agenciabeta.guarida.com.br',
                'USER_INFO_URL' => '/api/index/index?token=%s',
                'USER_COMPLEMENTARY_INFO_URL'=>'/api/index/index?token=%s',
                'ECONOMIES_ALLOWED_URL' => '/api/imoveis?persona=%s&cpf_cnpj=%s&token=%s',
                'TIME_TO_BUFFER_IN_MINUTES' => 10
            ],
            $this->apiResult
        );

        $result = $this->middleware->saveSyncUserInfo('token_very_hard', 1);
        $this->assertEquals($result, true);
    }

    public function testSaveSyncUserInfoOnError()
    {
        $this->apiResult = $this->getMockBuilder(ApiTools::class)->getMock();
        $this->apiResult->method('consumeExternalApi')->willReturn(
            [
                'content' => [
                    'codigo_pessoa' => '1',
                    'nome_pessoa' => 'Any Name',
                    'email' => 'Any@domain.com',
                    'email_notification'=>'*',
                    'push_notification'=>'*',
                    'sms_notification'=>'*'
                ],
                'httpCode' => 401
            ]
        );

        $this->middleware = new AuthenticationMiddleware(
            [
                'BASE_URL' => 'https://agenciabeta.guarida.com.br',
                'USER_INFO_URL' => '/api/index/index?token=%s',
                'USER_COMPLEMENTARY_INFO_URL'=>'/api/index/index?token=%s',
                'ECONOMIES_ALLOWED_URL' => '/api/imoveis?persona=%s&cpf_cnpj=%s&token=%s',
                'TIME_TO_BUFFER_IN_MINUTES' => 10
            ],
            $this->apiResult
        );

        $result = $this->middleware->saveSyncUserInfo('token_very_hard', 1);
        $this->assertEquals($result, false);
    }

    public function testGetAllowedCond()
    {
        $apiResult = $this->getMockBuilder(ApiTools::class)->getMock();
        $apiResult->method('consumeExternalApi')->willReturn([
            'content' => [
                'data' => [
                    [
                        'codcondom' => '1',
                        'nome_consultor' => 'Any Name',
                    ],
                ]
            ],
            'httpCode' => 200
        ]);

        $this->middleware = new AuthenticationMiddleware([
            'BASE_URL' => 'https://agenciabeta.guarida.com.br',
            'USER_INFO_URL' => '/api/index/index?token=%s',
            'USER_COMPLEMENTARY_INFO_URL' => '/api/index/index?token=%s',
            'ECONOMIES_ALLOWED_URL' => '/api/imoveis?persona=%s&cpf_cnpj=%s&token=%s',
            'TIME_TO_BUFFER_IN_MINUTES' => 10
        ], $this->apiResult);

        $result = $this->middleware->getAllowedCondominiums('homeowner', '78039029015', 'token_hard', $apiResult);
        $this->assertIsArray($result);
    }

    public function testGetUserInfo()
    {
        $this->apiResult = $this->getMockBuilder(ApiTools::class)->getMock();
        $this->apiResult->method('consumeExternalApi')->willReturn([
            'content' => [
               'codigo_pessoa' => '38187',
               'nome_pessoa' => 'DAMIEN VIANA ALVES',
               'cpf_cnpj' => '78517320000',
               'email' => 'vnicius@gmail.com',
               'data_cadastro' => '2014-09-25 09:25:09',
               'telefone' => '(51) 99999-9999',
               'data_nascimento' =>'06/06/1998',
               'profissao' =>'',
               'codprofissao' => '1731',
               'tipo_parentesco' =>'',
               'email_notification' =>'',
               'push_notification' =>'',
               'sms_notification' => '*',
                'data' => [
                    [
                        'codcondom' => '1',
                        'nome_consultor' => 'Any Name',
                        'email' => 'Any@Name',
                    ],

                ],
            ],
            'httpCode' => 200
        ]);

        $apiLocal = $this->getMockBuilder(ApiTools::class)->getMock();
        $apiLocal->method('consumeExternalApi')->willReturn(
            [
                'content' => [
                    'data' => [
                        'data' => [
                            'codigo_pessoa' => '1',
                            'nome_pessoa' => 'Any Name',
                            'cpf_cnpj' => '12345678910',
                            'email' => 'Any@domain.com',
                            'email_notification'=>'*',
                            'push_notification'=>'*',
                            'sms_notification'=>'*',
                            ],
                    ],
                    'user'=> ['profiles'=>['homeowner']]
                ],
                'httpCode' => 200
            ]
        );

        $this->middleware = new AuthenticationMiddleware([
            'BASE_URL' => 'https://agenciabeta.guarida.com.br',
            'USER_INFO_URL' => '/api/index/index?token=%s',
            'USER_COMPLEMENTARY_INFO_URL' => '/api/index/index?token=%s',
            'ECONOMIES_ALLOWED_URL' => '/api/imoveis?persona=%s&cpf_cnpj=%s&token=%s',
            'TIME_TO_BUFFER_IN_MINUTES' => 10
        ], $this->apiResult);

        $result = $this->middleware->getUserInfo('token_hard', $apiLocal);
        $this->assertIsArray($result);
    }
    public function testGetUserInfoOnError()
    {
        $this->apiResult = $this->getMockBuilder(ApiTools::class)->getMock();
        $this->apiResult->method('consumeExternalApi')->willReturn([
            'content' => [
                'codigo_pessoa' => '38187',
                'nome_pessoa' => 'DAMIEN VIANA ALVES',
                'cpf_cnpj' => '78517320000',
                'email' => 'vnicius@gmail.com',
                'data_cadastro' => '2014-09-25 09:25:09',
                'telefone' => '(51) 99999-9999',
                'data_nascimento' =>'06/06/1998',
                'profissao' =>'',
                'codprofissao' => '1731',
                'tipo_parentesco' =>'',
                'email_notification' =>'',
                'push_notification' =>'',
                'sms_notification' => '*',
                'data' => [
                    [
                        'codcondom' => '1',
                        'nome_consultor' => 'Any Name',
                        'email' => 'Any@Name',
                    ],

                ],
            ],
            'httpCode' => 401
        ]);

        $apiLocal = $this->getMockBuilder(ApiTools::class)->getMock();
        $apiLocal->method('consumeExternalApi')->willReturn(
            [
                'content' => [
                    'data' => [
                        'data' => [
                            'codigo_pessoa' => '1',
                            'nome_pessoa' => 'Any Name',
                            'cpf_cnpj' => '12345678910',
                            'email' => 'Any@domain.com',
                            'email_notification'=>'*',
                            'push_notification'=>'*',
                            'sms_notification'=>'*',
                        ],
                    ],
                    'user'=> ['profiles'=>['homeowner']]
                ],
                'httpCode' => 401
            ]
        );

        $this->middleware = new AuthenticationMiddleware([
            'BASE_URL' => 'https://agenciabeta.guarida.com.br',
            'USER_INFO_URL' => '/api/index/index?token=%s',
            'USER_COMPLEMENTARY_INFO_URL' => '/api/index/index?token=%s',
            'ECONOMIES_ALLOWED_URL' => '/api/imoveis?persona=%s&cpf_cnpj=%s&token=%s',
            'TIME_TO_BUFFER_IN_MINUTES' => 10
        ], $this->apiResult);

        $result = $this->middleware->getUserInfo('token_hard', $apiLocal);
        $this->assertIsArray($result);
    }
}
