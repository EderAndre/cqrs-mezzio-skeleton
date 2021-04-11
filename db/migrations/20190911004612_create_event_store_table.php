<?php

use Phinx\Migration\AbstractMigration;

class CreateEventStoreTable extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('events');
        $table->addColumn('created_at', 'datetime')
              ->addColumn('data', 'text', ['null' => true])
              ->addColumn('type', 'string', ['limit' => 100])
              ->create();
    }
}
