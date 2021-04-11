<?php

use Phinx\Migration\AbstractMigration;

class CreateTbSampleTable extends AbstractMigration
{
    public function up()
    {
        $table = $this->table('tb_sample', ['id' => false, 'primary_key' => ['id']]);
        $table->addColumn('id', 'biginteger', ['identity' => true])
              ->addColumn('name', 'string', ['limit' => 100, 'null' => false])
              ->addColumn('condid', 'string', ['limit' => 10, 'null' => false])
              ->addTimestamps('createdAt', 'updatedAt')
              ->create();
    }

    public function down()
    {
        $this->table('tb_sample')->drop()->save();
    }
