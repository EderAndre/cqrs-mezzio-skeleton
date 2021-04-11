<?php
declare(strict_types=1);

return [
    'external-apis' => [
        'agenciaVirtual' => [
            'BASE_URL' => $_ENV['EXTERNAL_API_AG_VIRTUAL_BASE_URL'],
            'USER_INFO_URL' => $_ENV['EXTERNAL_API_AG_VIRTUAL_USER_INFO_URL'],
            'USER_COMPLEMENTARY_INFO_URL' => $_ENV['EXTERNAL_API_AG_VIRTUAL_USER_COMPLEMENTARY_INFO_URL'],
            'ECONOMIES_ALLOWED_URL' => $_ENV['EXTERNAL_API_AG_VIRTUAL_ECONOMIES_ALLOWED_URL'],
            'TIME_TO_BUFFER_IN_MINUTES'=>$_ENV['EXTERNAL_API_AG_VIRTUAL_TIME_TO_BUFFER_IN_MINUTES'],
            'API_TOKEN' => $_ENV['EXTERNAL_API_AG_VIRTUAL_API_TOKEN'],
            'APP_ENV' => $_ENV['APP_ENV'],
        ]
    ],
    'google-cloud-storage' => [
        'CLOUD_STORAGE_BUCKET' => $_ENV['CLOUD_STORAGE_BUCKET']
    ]
];
