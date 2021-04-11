<?php
declare(strict_types = 1);
namespace Com\Incoders\SampleMS\Domain\Command\SampleMS;

use Com\Incoders\Cqrs\Application\Cqs\CommandHandlerInterface;
use Com\Incoders\Cqrs\Application\Cqs\CommandInterface;
use Com\Incoders\Cqrs\Domain\Events\DomainModelEvent;
use Com\Incoders\SampleMS\Domain\Event\SampleMSWasModified;
use Psr\Container\ContainerInterface;
use Com\Incoders\Cqrs\Infrastructure\Persistence\EventStore\PDOEventStore;
use Com\Incoders\SampleMS\Infrastructure\Persistence\Repository\SampleMSRepository;

class SaveSampleMSHandler extends DomainModelEvent implements CommandHandlerInterface
{

    public $container;

    public $sample;

    private $pdo;

    public function __construct(
        ContainerInterface $container,
        SampleMSRepository $sample,
        PDOEventStore $pdo
    ) {
        $this->container = $container;
        $this->sample = $sample;
        $this->pdo = $pdo;
    }

    public function handle(CommandInterface $command): void
    {
        $this->sample->updateOrCreate(
            ["id" => $command->getSample()['id']],
            $command->getSample()
        );
        $this->recordThat(
            new SampleMSWasModified(
                new \DateTimeImmutable(),
                (new \ReflectionClass($this))->getShortName()
            )
        );

        $this->pdo->commit($this->getRecordedEvents());
        $this->clearRecordedEvents();
    }
}
