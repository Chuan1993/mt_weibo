<?php
//控制器配置
return [
    'id' => 'login',
    'name' => '登录',
    'sort_weight' => 1,
    'actions' => [
        'index' => [
            'name' => '登录页面'
        ],
        'check' => [
            'name' => '登录验证',
            'sort_weight' => -1,
        ],
        'oa' => [
            'name' => 'OA账号登录页面'
        ],
        'oa_callback' => [
            'name' => 'OA账号登录验证',
            'sort_weight' => -2,
        ],
    ]
];