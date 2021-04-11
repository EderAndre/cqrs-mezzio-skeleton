<?php
declare(strict_types=1);

namespace Com\Incoders\Cqrs\Infrastructure\Persistence\EventStore;

use Com\Incoders\Cqrs\Domain\Events\DomainEvents;
use Com\Incoders\Cqrs\Infrastructure\Persistence\EventStore\EventStoreInterface;
use Illuminate\Database\Eloquent\Model as EloquentModel;

class PDOEventStore extends EloquentModel implements EventStoreInterface
{
    protected $table = 'events';

    protected $primaryKey = 'id';

    public $timestamps = false;

    /**
     * @param DomainEvents $events
     * @return void
     */
    public function commit(DomainEvents $events)
    {

        foreach ($events as $event) {
            $newPdoEventStore=new PDOEventStore();
            $newPdoEventStore->type  = get_class($event);
            $newPdoEventStore->created_at  = $event->getOcurredOn();
            $newPdoEventStore->data  = $event->jsonSerialize();
            $newPdoEventStore->save();
        }
    }

    public function commitBatch(DomainEvents $events)
    {
        $batch = [];
        foreach ($events as $event) :
            $batch[] = [
                'type' => get_class($event),
                'created_at' => $event->getOcurredOn(),
                'data' => $event->jsonSerialize(),
            ];
        endforeach;

        $this->insert($batch);
    }
}
