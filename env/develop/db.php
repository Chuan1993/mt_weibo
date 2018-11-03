<?php
return [
    'main' => [
        'master' => [
            'host' => '192.168.41.162',
            'port' => 3306,
            'username' => 'root',
            'password' => '123456',
            'dbname' => 'mt_weibo',
            'charset' => 'utf8mb4'
        ],
        'slaves' => [
            [
                'host' => '192.168.41.162',
                'port' => 3306,
                'username' => 'root',
                'password' => '123456',
                'dbname' => 'mt_weibo',
                'charset' => 'utf8mb4'
            ]
        ]
    ],

    'admin' => [
        'master' => [
            'host' => '192.168.41.162',
            'port' => 3306,
            'username' => 'root',
            'password' => '123456',
            'dbname' => 'mt_weibo_admin',
            'charset' => 'utf8mb4'
        ],
        'slaves' => [
            [
                'host' => '192.168.41.162',
                'port' => 3306,
                'username' => 'root',
                'password' => '123456',
                'dbname' => 'mt_weibo_admin',
                'charset' => 'utf8mb4'
            ]
        ]
    ]
];