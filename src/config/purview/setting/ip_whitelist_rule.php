<?php
//控制器配置
return [
    'id' => 'ip_whitelist_rule',
    'name' => 'IP白名单规则',
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
            'name' => '查看IP白名单规则信息',
        ],
    ]
];