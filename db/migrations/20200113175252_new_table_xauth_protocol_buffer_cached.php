<?php
use Phinx\Migration\AbstractMigration;

class NewTableXauthProtocolBufferCached extends AbstractMigration
{

    public function up()
    {
        $table = $this->table('xauth_protocolBufferCached', [
            'id' => false,
            'primary_key' => [
                'id'
            ]
        ]);
        $table->addColumn('id', 'biginteger', [
            'identity' => true
        ])
            ->addColumn('clientApiName', 'string', [
            'limit' => 255,
            'null' => false
        ])
            ->addColumn('clientApiHashedKey', 'string', [
            'limit' => 255,
            'null' => false
        ])
            ->addColumn('userToken', 'string', [
            'limit' => 2000,
            'null' => true
        ])
            ->addColumn('userInfoCached', 'string', [
            'limit' => 5000,
            'null' => false
        ])
            ->addColumn('expiresOn', 'datetime', [
            'default' => 'CURRENT_TIMESTAMP',
            'null' => false
        ])
            ->addTimestamps('createdAt', 'updatedAt')
            ->create();
    }

    public function down()
    {
        $this->table('xauth_protocolBufferCached')
            ->drop()
            ->save();
    }

}
