<?php
/**
 * This file generated by Mezzio\Tooling\Factory\ConfigInjector.
 *
 * Modifications should be kept at a minimum, and restricted to adding or
 * removing factory definitions; other dependency types may be overwritten
 * when regenerating this file via mezzio-tooling commands.
 */
declare(strict_types = 1);

return [
    'dependencies' => [
        'invokables' => [
            Com\Incoders\Cqrs\Application\Cqs\ApplicationBus::class,
        ],
        'services' => [

        ],
        'factories' => [
            Com\Incoders\SampleMS\Application\Action\Home\HomePageHandler::class =>
                Com\Incoders\SampleMS\Application\Action\Home\HomePageHandlerFactory::class,

            Com\Incoders\SampleMS\Middleware\AuthenticationMiddleware::class =>
            Com\Incoders\SampleMS\Middleware\AuthenticationMiddlewareFactory::class,

            Com\Incoders\SampleMS\Application\Action\SampleMS\AddSampleMSHandler::class=>
                Com\Incoders\SampleMS\Application\Action\SampleMS\AddSampleMSHandlerFactory::class,
            Com\Incoders\SampleMS\Domain\Command\SampleMS\SaveSampleMSHandler::class=>
                Com\Incoders\SampleMS\Domain\Command\SampleMS\SaveSampleMSHandlerFactory::class,
            
            Com\Incoders\SampleMS\Application\Action\SampleMS\SampleMSGetOneHandler::class=>
                Com\Incoders\SampleMS\Application\Action\SampleMS\SampleMSGetOneHandlerFactory::class,
            Com\Incoders\SampleMS\Domain\Query\SampleMS\SampleMSGetOneHandler::class=>
                Com\Incoders\SampleMS\Domain\Query\SampleMS\SampleMSGetOneHandlerFactory::class,
            //file feature EXAMPLE
            Com\Incoders\SampleMS\Application\Action\File\UploadFileHandler::class=>
                Com\Incoders\SampleMS\Application\Action\File\UploadFileHandlerFactory::class,
            Com\Incoders\SampleMS\Domain\Command\File\UploadFileHandler::class=>
                Com\Incoders\SampleMS\Domain\Command\File\UploadFileHandlerFactory::class,
            
            Com\Incoders\SampleMS\Application\Action\File\DirectoryListHandler::class=>
                Com\Incoders\SampleMS\Application\Action\File\DirectoryListHandlerFactory::class,
            Com\Incoders\SampleMS\Domain\Query\File\ListFilesHandler::class=>
                Com\Incoders\SampleMS\Domain\Query\File\ListFilesHandlerFactory::class,
            
            Com\Incoders\SampleMS\Infrastructure\Service\CloudStorage\BucketService::class=>
                Com\Incoders\SampleMS\Infrastructure\Service\CloudStorage\BucketServiceFactory::class,

                    ]
    ]
];
