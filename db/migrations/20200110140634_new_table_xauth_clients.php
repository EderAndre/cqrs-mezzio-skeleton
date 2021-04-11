<?php
use Phinx\Migration\AbstractMigration;

class NewTableXauthClients extends AbstractMigration
{

    public function up()
    {
        $table = $this->table('xauth_clients', [
            'id' => false,
            'primary_key' => [
                'name'
            ]
        ]);
        $table->addColumn('name', 'string', [
            'limit' => 45,
            'null' => false
        ])
            ->addColumn('secret', 'string', [
            'limit' => 255,
            'null' => false
        ])
            ->addColumn('require_user_token', 'boolean', [
            'default' => false,
            'null' => false
        ])
            ->addColumn('app_consumer', 'string', [
            'limit' => 45,
            'null' => true
        ])
            ->addColumn('revoked', 'boolean', [
            'default' => false,
            'null' => false
        ])
            ->addTimestamps('createdAt', 'updatedAt')
            ->addIndex([
            'secret'
        ], [
            'unique' => true
        ])
            ->create();
    }

    public function down()
    {
        $this->table('xauth_clients')
            ->drop()
            ->save();
    }

}
