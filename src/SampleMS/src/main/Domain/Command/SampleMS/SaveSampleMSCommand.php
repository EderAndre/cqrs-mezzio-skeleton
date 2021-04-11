<?php
declare(strict_types = 1);
namespace Com\Incoders\SampleMS\Domain\Command\SampleMS;

use Com\Incoders\Cqrs\Application\Cqs\CommandInterface;

class SaveSampleMSCommand implements CommandInterface
{

    private $name;

    private $sample;

    public function __construct($name, array $sample)
    {
        $this->name = $name;
        $this->sample = $sample;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getSample()
    {
        if (!isset($this->sample['id'])) {
            $this->sample['id'] = null;
        }

        return $this->sample;
    }
}
