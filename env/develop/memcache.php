<?php
return [
    'default' => [
        'servers' => [
            ['host' => 'memcache.dev', 'port' => 11211, 'weight' => 0],
        ],
        'connect_timeout' => 1000, //ms
        'binary_protocol' => true,
    ],
];