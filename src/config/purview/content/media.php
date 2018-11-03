<?php
//控制器配置
return [
    'id' => 'media',
    'name' => '视频管理',
    'sort_weight' => 1,
    'actions' => [
        'high_quality' => [
            'name' => '优质视频',
            'is_menu' => 1
        ],
        'core_user' => [
            'name' => '核心用户视频',
            'is_menu' => 1
        ],
        'sensitive' => [
            'name' => '敏感视频',
            'is_menu' => 1
        ],
        'other' => [
            'name' => '其他视频',
            'is_menu' => 1
        ],
        'contribute' => [
            'name' => '投稿视频',
            'is_menu' => 1
        ],
    ]
];