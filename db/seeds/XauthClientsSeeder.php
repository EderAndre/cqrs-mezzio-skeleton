<?php


use Phinx\Seed\AbstractSeed;

class XauthClientsSeeder extends AbstractSeed
{
    public function run()
    {
        $data = [
            [
                'name' => 'client_test',
                'secret' => '$2y$10$9YUZYAxPaAznOgkUworQUODh3LGGVEobHRgwut5fJ3EXrcG7j.I3G',
                'require_user_token' => '0',
                'app_consumer' => 'APP1',
                'revoked' => 0
            ],
            [
                'name' => 'user_logged',
                'secret' => '$2y$10$OisobpgzDkJwxusRlM/2mu65MqBsPgw1RHvbTU3YsojSK7dFA8pju',
                'require_user_token' => '1',
                'app_consumer' => null,
                'revoked' => 0
            ]
        ];

        $post = $this->table('xauth_clients');

        $post->insert($data)->save();

    }
}
