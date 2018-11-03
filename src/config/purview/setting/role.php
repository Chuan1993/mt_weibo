<?php
//控制器配置
return [
    'id' => 'role',
    'name' => '角色管理',
    'actions' => [
        'index' => [
            'name' => '列表',
            'is_menu' => 1
        ],
        'add' => [
            'name' => '添加',
            'writable' => 1
        ],
        'edit' => [
            'name' => '编辑',
            'writable' => 1
        ],
        'del' => [
            'name' => '删除',
            'writable' => 1
        ],
        'show' => [
            'name' => '查看角色信息',
        ],
        'show_nodes' => [
            'name' => '查看某角色的权限',
        ],
    ]
];