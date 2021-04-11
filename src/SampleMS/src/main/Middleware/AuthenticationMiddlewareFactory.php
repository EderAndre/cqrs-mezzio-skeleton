<?php
declare(strict_types = 1);
namespace Com\Incoders\SampleMS\Middleware;

use Psr\Container\ContainerInterface;
use Com\Incoders\SampleMS\Middleware\Service\ApiTools;

class AuthenticationMiddlewareFactory
{
    public function __invoke(ContainerInterface $container): AuthenticationMiddleware
    {
        $configs = $container->get('config')['external-apis']['agenciaVirtual'];
        $api = new ApiTools();
        return new AuthenticationMiddleware($configs, $api);
    }
}
