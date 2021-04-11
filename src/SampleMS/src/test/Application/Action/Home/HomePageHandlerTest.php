<?php
declare(strict_types = 1);
namespace Com\Incoders\SampleMSTest\Application\Action\Home;

use Com\Incoders\SampleMS\Application\Action\Home\HomePageHandler;
use Laminas\Diactoros\Response\HtmlResponse;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Laminas\Diactoros\Response\JsonResponse;
use Mezzio\Router\RouterInterface;
use Mezzio\Template\TemplateRendererInterface;

class HomePageHandlerTest extends TestCase
{
    /** @var ContainerInterface|ObjectProphecy */
    protected $container;

    /** @var RouterInterface|ObjectProphecy */
    protected $router;

    protected function setUp()
    {
        $this->container = $this->prophesize(ContainerInterface::class);
        $this->router    = $this->prophesize(RouterInterface::class);
    }
    public function testReturnsSessionTrueProvided()
    {
        $req= $this->getMockBuilder(ServerRequestInterface::class)
        ->disableOriginalConstructor()
        ->getMock();
        $req->method('getAttribute')->willReturn(
            new class
            {
                public function get()
                {
                    return true;
                }
            }
        );

        $renderer= $this->getMockBuilder(TemplateRendererInterface::class)
        ->disableOriginalConstructor()
        ->getMock();

        $homePage = new HomePageHandler($renderer);
        $response = $homePage->handle(
            $req
        );

        $this->assertInstanceOf(HtmlResponse::class, $response);
    }
}
