<?php
//控制器配置
return [
    'id' => 'privilege',
    'name' => '权限管理',
    'actions' => [
        'index' => [
            'name' => '列表',
            'is_menu' => 1
        ],
        'flush_cache' => [
            'name' => '刷新列表缓存',
        ],
    ]
];