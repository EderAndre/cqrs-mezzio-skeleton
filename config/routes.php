<?php

declare(strict_types=1);

use Psr\Container\ContainerInterface;
use Mezzio\Application;
use Mezzio\MiddlewareFactory;
use OpenApi\Annotations as OA;

return function (Application $app, MiddlewareFactory $factory, ContainerInterface $container): void {
    $app->get('/', Com\Incoders\SampleMS\Application\Action\Home\HomePageHandler::class, 'home');
    $app->get(
        '/healthcheck',
        Com\Incoders\SampleMS\Application\Action\Healthcheck\HealthcheckHandler::class,
        'healthcheck'
    );
    $app->get('/api/ping', Com\Incoders\SampleMS\Application\Action\Ping\PingHandler::class, 'api.ping');
    $app->get(
        '/api/v1/condid/{condid:\d+}/profile/{profile}/userid[/{userid:\d+}]',
        Com\Incoders\SampleMS\Application\Action\Ping\PingHandler::class,
        'api.tping.path'
    );
    
    $app->get(
        '/api/v2/sample/get/condid/{condid:\d+}/profile/{profile}/userid[/{userid:\d+}]',
        Com\Incoders\SampleMS\Application\Action\SampleMS\SampleMSGetOneHandler::class,
        'sample.get'
        );

    $app->post(
        '/api/v2/sample/add/condid/{condid:\d+}/profile/{profile}/userid[/{userid:\d+}]',
        Com\Incoders\SampleMS\Application\Action\SampleMS\AddSampleMSHandler::class,
        'sample.add'
    );
    
    $app->post(
        '/api/file/upload',
        Com\Incoders\SampleMS\Application\Action\File\UploadFileHandler::class,
        'file.upload'
        );
    $app->get(
        '/api/directory/list',
        Com\Incoders\SampleMS\Application\Action\File\DirectoryListHandler::class,
        'directory.list'
        );
};
