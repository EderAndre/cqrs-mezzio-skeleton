<?php
declare(strict_types = 1);
namespace Com\Incoders\SampleMS\Application\Action\Healthcheck;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Laminas\Diactoros\Response\JsonResponse;
use Illuminate\Database\Eloquent\Model as Eloquent;

class HealthcheckHandler extends Eloquent implements RequestHandlerInterface
{

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $dbConncetionStatus = $this->testDbConnection();

        $healthCheckStatus = (
            $dbConncetionStatus == 'ok'
            ) ? 'ok' : 'fail';
        return new JsonResponse(
            [
            'healthcheck'.$healthCheckStatus => $healthCheckStatus,
            'dbConnection' => $dbConncetionStatus
            ]
        );
    }
    public function testDbConnection()
    {
        $status = $this->setTable('events')
            ->selectRaw('"ok" as result')
            ->limit(1)
            ->get()
            ->toArray()[0]['result'];
        return $status == 'ok' ? 'ok' : 'fail';
    }
}
