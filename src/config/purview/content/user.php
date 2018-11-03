<?php
//控制器配置
return [
    'id' => 'user',
    'name' => '用户管理',
    'actions' => [
        'index' => [
            'name' => '全部用户',
            'is_menu' => 1
        ],
        'core' => [
            'name' => '核心用户',
            'is_menu' => 1
        ],
        'long_video' => [
            'name' => '开通长视频的用户',
            'is_menu' => 1
        ],
        'direct_message' => [
            'name' => '开通私信的用户',
            'is_menu' => 1
        ],
    ]
];