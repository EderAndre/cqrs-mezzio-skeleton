<?php
use Phinx\Migration\AbstractMigration;

class NewTableTbSyncUserInfo extends AbstractMigration
{

    public function up()
    {
        $table = $this->table('tb_syncUserInfo', [
            'id' => false,
            'primary_key' => [
                'userId'
            ]
        ]);
        $table->addColumn('userId', 'biginteger',[
            'null' => false
        ])
            ->addColumn('displayName', 'string', [
            'limit' => 510,
            'null' => true
        ])
            ->addColumn('email', 'string', [
            'limit' => 510,
            'null' => false
        ])
            ->addColumn('emailNotification', 'string', [
            'limit' => 4,
            'null' => true
        ])
        ->addColumn('pushNotification', 'string', [
            'limit' => 4,
            'null' => true
        ])
        ->addColumn('smsNotification', 'string', [
            'limit' => 4,
            'null' => true
        ])
            ->addColumn('lastAccessOn', 'datetime', [
            'default' => 'CURRENT_TIMESTAMP',
            'null' => false
        ])
            ->addTimestamps('createdAt', 'updatedAt')
            ->create();
    }

    public function down()
    {
        $this->table('tb_syncUserInfo')
            ->drop()
            ->save();
    }

}
