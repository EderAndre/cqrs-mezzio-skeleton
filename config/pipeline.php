<?php

declare(strict_types=1);

use Psr\Container\ContainerInterface;
use Mezzio\Application;
use Mezzio\Handler\NotFoundHandler;
use Mezzio\Helper\ServerUrlMiddleware;
use Mezzio\Helper\UrlHelperMiddleware;
use Psr\Http\Server\MiddlewareInterface;
use Mezzio\MiddlewareFactory;
use Mezzio\Router\Middleware\DispatchMiddleware;
use Mezzio\Router\Middleware\ImplicitHeadMiddleware;
use Mezzio\Router\Middleware\ImplicitOptionsMiddleware;
use Mezzio\Router\Middleware\MethodNotAllowedMiddleware;
use Mezzio\Router\Middleware\RouteMiddleware;
use Laminas\Stratigility\Middleware\ErrorHandler;
use Mezzio\Authentication\AuthenticationMiddleware;
use function Laminas\Stratigility\path;

return function (Application $app, MiddlewareFactory $factory, ContainerInterface $container) : void {

    $app->pipe(ErrorHandler::class);
    $app->pipe(ServerUrlMiddleware::class);

    $app->pipe(RouteMiddleware::class);
    $app->pipe(ImplicitHeadMiddleware::class);
    $app->pipe(ImplicitOptionsMiddleware::class);
    $app->pipe(MethodNotAllowedMiddleware::class);
    $app->pipe(UrlHelperMiddleware::class);

    $app->pipe(path('/api/v1', $factory->pipeline([
        Com\Incoders\SampleMS\Middleware\AuthenticationMiddleware::class,
        Mezzio\Authorization\AuthorizationMiddleware::class
        ])));

    $app->pipe(path('/api/v2', $factory->pipeline([
        Com\Incoders\SampleMS\Middleware\AuthenticationBufferedMiddleware::class,
        Com\Incoders\SampleMS\Middleware\AuthenticationMiddleware::class,
        Mezzio\Authorization\AuthorizationMiddleware::class
    ])));


    $app->pipe(DispatchMiddleware::class);
    $app->pipe(NotFoundHandler::class);
};
