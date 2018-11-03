<?php
//控制器配置
return [
    'id' => 'config',
    'name' => '参数设置',
    'actions' => [
        'system_switch' => [
            'name' => '系统开关',
            'is_menu' => 1
        ],
        'update_system_switch' => [
            'name' => '修改系统开关',
            'writable' => 1
        ],
    ]
];