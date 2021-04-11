<?php
declare(strict_types=1);

return [
    'eloquent' => [
        'driver'    => $_ENV['DB_DRIVER'],
        'host'      => $_ENV['DB_HOST'],
        'port'      => $_ENV['DB_PORT'],
        'database'  => $_ENV['DB_DATABASE'],
        'username'  => $_ENV['DB_USERNAME'],
        'password'  => $_ENV['DB_PASSWORD'],
        'charset'   => $_ENV['DB_CHARSET'],
        'collation' => $_ENV['DB_COLLATION'],
        'strict'=>false
    ]
];
