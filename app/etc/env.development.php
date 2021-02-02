<?php
return [
    'backend' => [
        'frontName' => 'admin'
    ],
    'crypt' => [
        'key' => '38b37811e43cb35943925fd015a56a82'
    ],
    'db' => [
        'table_prefix' => 'm2_',
        'connection' => [
            'default' => [
                'host' => 'mysql',
                'dbname' => 'iurii_stepanenko_local_dev',
                'username' => 'iurii_stepanenko_local_dev',
                'password' => 'fgdsfhshtreh3453@#$fgdgddfg',
                'model' => 'mysql4',
                'engine' => 'innodb',
                'initStatements' => 'SET NAMES utf8;',
                'active' => '1'
            ]
        ]
    ],
    'resource' => [
        'default_setup' => [
            'connection' => 'default'
        ]
    ],
    'x-frame-options' => 'SAMEORIGIN',
    'MAGE_MODE' => 'developer',
    'session' => [
        'save' => 'redis',
        'redis' => [
            'host' => 'redis',
            'port' => '6379',
            'password' => '',
            'timeout' => '2.5',
            'persistent_identifier' => '',
            'database' => '2',
            'compression_threshold' => '2048',
            'compression_library' => 'gzip',
            'log_level' => '3',
            'max_concurrency' => '6',
            'break_after_frontend' => '5',
            'break_after_adminhtml' => '30',
            'first_lifetime' => '600',
            'bot_first_lifetime' => '60',
            'bot_lifetime' => '7200',
            'disable_locking' => '1',
            'min_lifetime' => '60',
            'max_lifetime' => '2592000'
        ]
    ],
    'cache' => [
        'frontend' => [
            'default' => [
                'id_prefix' => '40d_'
            ],
            'page_cache' => [
                'id_prefix' => '40d_'
            ]
        ]
    ],
    'lock' => [
        'provider' => 'db',
        'config' => [
            'prefix' => null
        ]
    ],
    'cache_types' => [
        'config' => 1,
        'layout' => 1,
        'block_html' => 1,
        'collections' => 1,
        'reflection' => 1,
        'db_ddl' => 1,
        'compiled_config' => 1,
        'eav' => 1,
        'customer_notification' => 1,
        'config_integration' => 1,
        'config_integration_api' => 1,
        'full_page' => 1,
        'config_webservice' => 1,
        'translate' => 1,
        'vertex' => 1
    ],
    'install' => [
        'date' => 'Wed, 09 Oct 2019 16:54:42 +0000'
    ],
    'downloadable_domains' => [
        'iurii-stepanenko-dev.local',
        'iurii-sky-dev.local'
    ],
    'system' => [
        'default' => [
            'web' => [
                'unsecure' => [
                    'base_url' => 'https://iurii-stepanenko-dev.local/',
                    'base_link_url' => '{{unsecure_base_url}}',
                    'base_static_url' => 'https://iurii-stepanenko-dev.local/static/',
                    'base_media_url' => 'https://iurii-stepanenko-dev.local/media/'
                ],
                'secure' => [
                    'base_url' => 'https://iurii-stepanenko.local/',
                    'base_link_url' => '{{secure_base_url}}',
                    'base_static_url' => 'https://iurii-stepanenko-dev.local/static/',
                    'base_media_url' => 'https://iurii-stepanenko-dev.local/media/'
                ],
            ],
        ],

        'websites' => [
            'additional_website' => [
                'web' => [
                    'unsecure' => [
                        'base_url' => 'https://iurii-sky.local/',
                        'base_static_url' => 'https://iurii-sky-dev.local/static/',
                        'base_media_url' => 'https://iurii-sky-dev.local/media/'
                    ],
                    'secure' => [
                        'base_url' => 'https://iurii-sky.local/',
                        'base_static_url' => 'https://iurii-sky-dev.local/static/',
                        'base_media_url' => 'https://iurii-sky-dev.local/media/'
                    ]
                ]
            ]
        ]

    ]
];
