<?php
declare(strict_types = 1);
namespace Com\Incoders\SampleMS\Application\Action\Home;

use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Mezzio\Template\TemplateRendererInterface;
use function get_class;

class HomePageHandlerFactory
{

    public function __invoke(ContainerInterface $container): RequestHandlerInterface
    {
        $template = $container
            ->has(TemplateRendererInterface::class) ? $container->get(TemplateRendererInterface::class) : null;

        return new HomePageHandler($template);
    }
}
