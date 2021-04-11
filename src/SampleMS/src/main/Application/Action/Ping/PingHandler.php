<?php
declare(strict_types = 1);
namespace Com\Incoders\SampleMS\Application\Action\Ping;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Laminas\Diactoros\Response\JsonResponse;
use Mezzio\Authentication\UserInterface;
use Mezzio\Router\RouteResult;
use function time;

class PingHandler implements RequestHandlerInterface
{

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $user = $request->getAttribute(UserInterface::class)??null;
        $router=$request->getAttribute(RouteResult::class)??null;
        $pathParams=$router?$router->getMatchedParams():null;
        return new JsonResponse([
            [
                'ack' => time()
            ],
            [
                'pathParams' => $pathParams ? $pathParams : null
            ],
            [
                'identity' => $user ? $user->getIdentity() : null,
                'userDetails' => $user ? $user->getDetails() : null,
                'roles' => $user ? $user->getRoles() : null
            ]
        ]);
    }
}
