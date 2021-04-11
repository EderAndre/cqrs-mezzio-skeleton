<?php
declare(strict_types = 1);
namespace Com\Incoders\SampleMS\Infrastructure\Service\CloudStorage;

use Com\Incoders\Cqrs\Domain\Events\DomainModelEvent;
use Com\Incoders\SampleMS\Domain\Event\FileUploaded;
use Com\Incoders\SampleMS\Domain\Event\FileDeleted;
use Com\Incoders\Cqrs\Infrastructure\Persistence\EventStore\PDOEventStore;
use Google\Cloud\Storage\StorageClient;
use Com\Incoders\SampleMS\Infrastructure\Service\ServiceInterface;

class BucketService extends DomainModelEvent implements ServiceInterface
{

    private $bucket;

    private PDOEventStore $pdo;

    private $bucketName;

    public function __construct(StorageClient $client, string $bucketName, PDOEventStore $pdo)
    {
        $this->bucket = $client->bucket($bucketName);
        $this->pdo = $pdo;
        $this->bucketName=$bucketName;
    }

    public function upload($fileStream, $objectName)
    {
        try {
            $this->bucket->upload($fileStream, [
                'name' => $objectName
            ]);
            $result= $objectName;
            $resultEvent= sprintf('gs://%s/%s', $this->bucketName, $objectName);
        } catch (\Exception $e) {
            $result= '_ERROR_:'. $e->getMessage();
            $resultEvent=$result;
        }
                $this->recordThat(
                    new FileUploaded(
                        new \DateTimeImmutable(),
                        $resultEvent
                    )
                );

                $this->pdo->commit($this->getRecordedEvents());
                $this->clearRecordedEvents();

                return $result;
    }
    public function delete($objectName, $options = []): string
    {
        $object = $this->bucket->object($objectName);
        $object->delete();
        $event=sprintf('Deleted gs://%s/%s', $this->bucketName, $objectName);

        $this->recordThat(
            new FileDeleted(
                new \DateTimeImmutable(),
                "$event"
            )
        );

        $this->pdo->commit($this->getRecordedEvents());
        $this->clearRecordedEvents();
        return $event;
    }

    public function downloadFile($objectName)
    {
        $object = $this->bucket->object($objectName);
        $stream=$object->downloadAsStream();
        return $stream->getContents();
    }

    public function getFileList($directoryPrefix): ?Array
    {
        $options = ['prefix' => $directoryPrefix];
        $fileList=[];

        foreach ($this->bucket->objects($options) as $object) {
            $fileList[]=  $object->name();
        }

        return $fileList;
    }
}
