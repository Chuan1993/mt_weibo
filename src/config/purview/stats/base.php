<?php
//控制器配置
return [
    'id' => 'base',
    'name' => '基础统计',
    'actions' => [
        'register_user' => [
            'name' => '注册用户',
            'is_menu' => 1
        ],
        'active_user' => [
            'name' => '活跃用户',
            'is_menu' => 1
        ],
        'upload' => [
            'name' => '上传活跃度',
            'is_menu' => 1
        ],
    ]
];