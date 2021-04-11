<?php

declare(strict_types = 1);

namespace Com\Incoders\SampleMSTest\Middleware;

use Psr\Container\ContainerInterface;
use PHPUnit\Framework\TestCase;
use Com\Incoders\SampleMS\Middleware\AuthenticationMiddlewareFactory;
use Com\Incoders\SampleMS\Middleware\AuthenticationMiddleware;

class AuthenticationMiddlewareFactoryTest extends TestCase
{
    protected $container;

    protected function setUp()
    {
    }

    public function testFactoryReturnCorrectType()
    {
        $cont = $this->getMockBuilder(ContainerInterface::class)
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->disallowMockingUnknownTypes()
            ->getMock();
            $cont->method('get')->willReturn(['external-apis' => [
                'agenciaVirtual' => [
                    'BASE_URL' => 'https://agenciabeta.guarida.com.br',
                    'USER_INFO_URL' => '/api/index/index?token=%s',
                    'ECONOMIES_ALLOWED_URL' => '/api/imoveis?persona=%s&cpf_cnpj=%s&token=%s',
                ],
            ],

            ]);
        $factory = new AuthenticationMiddlewareFactory();

        $handler = $factory($cont);

        $this->assertInstanceOf(AuthenticationMiddlewareFactory::class, $factory);

        $this->assertInstanceOf(AuthenticationMiddleware::class, $handler);
    }
}
