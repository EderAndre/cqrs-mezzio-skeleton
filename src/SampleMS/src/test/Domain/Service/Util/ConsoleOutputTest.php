<?php
declare(strict_types = 1);
namespace Com\Incoders\SampleMSTest\Domain\Service\Util;

use Com\Incoders\SampleMS\Domain\Service\Util\ConsoleOutput;
use PHPUnit\Framework\TestCase;

class ConsoleOutputTest extends TestCase
{

    protected $displayRaw;

    protected $displayColor;

    protected $displayColorStripLines;

    protected function setUp()
    {
        $this->displayRaw = new ConsoleOutput(true, false);
        $this->displayColor = new ConsoleOutput(true, true);
        $this->displayColorStripLines = new ConsoleOutput(true, true);
        $this->noDisplay = new ConsoleOutput(false, false);
    }

    public function testReturnIfnoColor()
    {
        $content = 'rawTest';
        $this->displayRaw->output($content);
        $this->noDisplay->output($content);
        $content = sprintf(" \e[0m \e[0m  %s \e[0m \e[0m ", $content);
        $this->expectOutputString("\n $content");
    }

    public function testReturnIfcolorGreen()
    {
        $content = 'greenTest';
        $this->displayColor->output($content, 'GREEN');
        $content = sprintf(" \e[32m %s \e[0m ", $content);
        $content = sprintf(" \e[0m \e[0m  %s \e[0m \e[0m ", $content);
        $this->expectOutputString("\n $content");
    }

    public function testReturnIfcolorRed()
    {
        $content = 'redTest';
        $this->displayColor->output($content, 'RED');
        $content = sprintf(" \e[31m %s \e[0m ", $content);
        $content = sprintf(" \e[0m \e[0m  %s \e[0m \e[0m ", $content);
        $this->expectOutputString("\n $content");
    }

    public function testReturnIfcolorCian()
    {
        $content = 'cianTest';
        $this->displayColor->output($content, 'CIAN');
        $content = sprintf(" \e[36m %s \e[0m ", $content);
        $content = sprintf(" \e[0m \e[0m  %s \e[0m \e[0m ", $content);
        $this->expectOutputString("\n $content");
    }

    public function testReturnIfstriped()
    {
        $content = 'stripTest';
        $this->displayColorStripLines->output($content, 'CIAN', 1);
        $content = sprintf(" \e[36m %s \e[0m ", $content);
        $content = sprintf(" \e[47m \e[30m  %s \e[0m \e[0m ", $content);
        $this->expectOutputString("\n $content");
    }
}
