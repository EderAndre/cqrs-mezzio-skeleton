<?php
namespace Com\Incoders\SampleMS\Domain\Service\Util;

class ConsoleOutput
{
    protected $display=false;
    protected $color=false;

    public function __construct(bool $display, $color = false)
    {
        $this->display=$display;
        $this->color=$color;
    }

    public function output(string $content, string $color = null, $strip = 0)
    {
        if ($this->color) :
            switch ($color) :
                case 'GREEN':
                    $content=sprintf(" \e[32m %s \e[0m ", $content);
                    break;
                case 'RED':
                    $content=sprintf(" \e[31m %s \e[0m ", $content);
                    break;
                case 'CIAN':
                    $content=sprintf(" \e[36m %s \e[0m ", $content);
                    break;
            endswitch;

            $content =
            $strip == 1 ?
            sprintf(" \e[47m \e[30m  %s \e[0m \e[0m ", $content) :
            sprintf(" \e[0m \e[0m  %s \e[0m \e[0m ", $content);
        else :
            $content =sprintf(" \e[0m \e[0m  %s \e[0m \e[0m ", $content);
        endif;

        if ($this->display) :
            print_r("\n $content");
            return true;
        endif;
            return false;
    }
}
