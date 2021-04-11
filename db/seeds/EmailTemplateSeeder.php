<?php


use Phinx\Seed\AbstractSeed;

class EmailTemplateSeeder extends AbstractSeed
{
    public function run()
    {
        $data = [
            [
                'id' => '1',
                'name' => 'Default Email Template Guarida',
                'subject' => 'Novo comunicado',
                'content' => 'Você possui um novo comunicado.'
            ]
        ];

        $post = $this->table('tb_email_template');

        $post->insert($data)->save();

    }
}
