<?php
declare(strict_types = 1);

return [
    'mezzio-authorization-acl' => [
        'roles' => [
            'API' => [],
            'homeowner' => [],
            'syndic' => [],
            'council' => [],
        ],
        'resources' => [
            'home',
            'healthcheck',
            'api.tping.path',
            'sample.get',
            'sample.add',
            'file.upload',
            'directory.list'
        ],
        'allow' => [
            'API' => [
            ],
            'homeowner' => [
                'home',
                'api.tping.path',
            ],
            'syndic' => [
                'home',
                'api.tping.path',
                'sample.get',
                'sample.add'
            ],
            'council' => [
                'api.tping.path'

            ],
        ],
        // 'deny'=>['syndic' => [ 'api.tping.path',],]//deny example
    ],
];
