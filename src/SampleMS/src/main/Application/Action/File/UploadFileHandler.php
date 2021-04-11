<?php
declare(strict_types = 1);
namespace Com\Incoders\SampleMS\Application\Action\File;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Laminas\Diactoros\Response\JsonResponse;
use Com\Incoders\Cqrs\Application\Cqs\ApplicationBus;
use Com\Incoders\SampleMS\Domain\Command\File\UploadFileCommand;

class UploadFileHandler implements RequestHandlerInterface
{
    private $applicationBus;

    public function __construct(ApplicationBus $applicationBus)
    {
        $this->applicationBus = $applicationBus;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $payload=$request->getUploadedFiles();
        $fileStream=$payload['file']->getStream();
        $directory="test/";
        $objectName=$directory.date('YmdHis_').$payload['file']->getClientFilename();
        $addCmd = new UploadFileCommand($objectName, $fileStream);
        $this->applicationBus->executeCommand($addCmd);

        return new JsonResponse([
            'Status Upload' => 'sended'
        ]);
    }
}
