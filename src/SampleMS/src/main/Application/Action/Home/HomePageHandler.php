<?php
declare(strict_types = 1);
namespace Com\Incoders\SampleMS\Application\Action\Home;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Laminas\Diactoros\Response\HtmlResponse;
use Mezzio\Template\TemplateRendererInterface;

class HomePageHandler implements RequestHandlerInterface
{
    private $template;

    public function __construct(TemplateRendererInterface $template = null)
    {
        $this->template = $template;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return new HtmlResponse($this->template->render('app::home-page'));
    }
}
