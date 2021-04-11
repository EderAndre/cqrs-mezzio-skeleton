<?php
declare(strict_types = 1);

namespace Com\Incoders\SampleMS\Application\Action\SampleMS;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Laminas\Diactoros\Response\JsonResponse;
use Com\Incoders\Cqrs\Application\Cqs\ApplicationBus;
use Com\Incoders\SampleMS\Domain\Command\SampleMS\SaveSampleMSCommand;
use Mezzio\Router\RouteResult;

class AddSampleMSHandler implements RequestHandlerInterface
{
    private $applicationBus;

    public function __construct(ApplicationBus $applicationBus)
    {
        $this->applicationBus = $applicationBus;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $router=$request->getAttribute(RouteResult::class);
        $pathParams=$router->getMatchedParams();
        $params = $request->getQueryParams();
        $params['condid'] = str_pad($pathParams['condid'], 5, "0", STR_PAD_LEFT);
        $addCmd = new SaveSampleMSCommand(get_class(), $params);
        $this->applicationBus->executeCommand($addCmd);

        return new JsonResponse([
            'Status' => 'success'
        ]);
    }
}
