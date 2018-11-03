<?php
return [
    'id' => 'group_member',
    'name' => '组成员管理',
    'actions' => [
        'index' => [
            'name' => '列表',
        ],
        'store' => [
            'name' => '添加组成员',
            'writable' => 1
        ],
        'update' => [
            'name' => '修改组员信息(等级)',
            'writable' => 1
        ],
        'destroy' => [
            'name' => '移除组员',
            'writable' => 1
        ]
    ]
];