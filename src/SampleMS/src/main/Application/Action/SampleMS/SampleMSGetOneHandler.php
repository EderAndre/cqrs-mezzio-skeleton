<?php

declare(strict_types = 1);

namespace Com\Incoders\SampleMS\Application\Action\SampleMS;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Laminas\Diactoros\Response\JsonResponse;
use Com\Incoders\Cqrs\Application\Cqs\ApplicationBus;
use Com\Incoders\SampleMS\Domain\Query\SampleMS\SampleMSGetOneQuery;

class SampleMSGetOneHandler implements RequestHandlerInterface
{
    private $applicationBus;

    public function __construct(ApplicationBus $applicationBus)
    {
        $this->applicationBus = $applicationBus;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $params = $request->getQueryParams();
        $findSpaceBookingCmd = new SampleMSGetOneQuery(get_class(), $params);

        $findSpaceBookingCmd->params = $params;

        return new JsonResponse([
            'SampleMS' => $this->applicationBus->executeQuery($findSpaceBookingCmd)
        ]);
    }
}
