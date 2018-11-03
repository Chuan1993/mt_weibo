<?php
//控制器配置
return [
    'id' => 'account',
    'name' => '后台账号管理',
    'sort_weight' => 1,
    'actions' => [
        'index' => [
            'name' => '列表',
            'is_menu' => 1
        ],
        'show' => [
            'name' => '查看账号信息',
        ],
        'add' => [
            'name' => '添加',
            'writable' => 1
        ],
        'edit' => [
            'name' => '编辑账号',
            'writable' => 1
        ],
        'del' => [
            'name' => '删除账号',
            'writable' => 1
        ],
        'show_roles' => [
            'name' => '查看分配的角色'
        ],
        'assign_roles' => [
            'name' => '分配角色',
            'writable' => 1
        ],
        'reset_pwd' => [
            'name' => '重置密码',
            'writable' => 1
        ],
        'show_ip_rules' => [
            'name' => '查看设置的IP白名单规则'
        ],
        'set_ip_rules' => [
            'name' => '设置IP白名单规则',
            'writable' => 1
        ],
    ]
];