<?php

use Phinx\Migration\AbstractMigration;

class NewTableEmailTemplate extends AbstractMigration
{
    public function up()
    {
        $table = $this->table('tb_email_template', ['id' => false, 'primary_key' => ['id']]);
        $table->addColumn('id', 'biginteger', ['identity' => true])
              ->addColumn('name', 'string', ['limit' => 80, 'null' => false])
              ->addColumn('subject', 'string', ['limit' => 80, 'null' => true])
              ->addColumn('content', 'text', ['null' => true])
              ->create();
    }

    public function down()
    {
        $this->table('tb_email_template')->drop()->save();
    }
}
