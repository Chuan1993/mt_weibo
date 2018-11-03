<?php
return [
    'id' => 'group',
    'name' => '组管理',
    'actions' => [
        'index' => [
            'name' => '列表',
            'is_menu' => 1
        ],
        'show' => [
            'name' => '查看组信息',
        ],
        'store' => [
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
        ]
    ]
];