<?php
declare(strict_types = 1);
namespace Com\Incoders\SampleMS\Application\Action\File;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Laminas\Diactoros\Response\JsonResponse;
use Com\Incoders\Cqrs\Application\Cqs\ApplicationBus;
use Com\Incoders\SampleMS\Domain\Query\File\ListFilesQuery;

class DirectoryListHandler implements RequestHandlerInterface
{
    private $applicationBus;

    public function __construct(ApplicationBus $applicationBus)
    {
        $this->applicationBus = $applicationBus;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $params=['preffix'=>$request->getQueryParams()['preffix']];
        $listQuery = new ListFilesQuery();
        $listQuery->params= $params;
        $list=$this->applicationBus->executeQuery($listQuery);

        return new JsonResponse([
            'Files' => $list
        ]);
    }
}
