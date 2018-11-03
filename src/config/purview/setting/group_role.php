<?php
return [
    'id' => 'group_role',
    'name' => '组权限管理',
    'actions' => [
        'role_total' => [
            'name' => '设置可用角色页面',
        ],
        'role_base' => [
            'name' => '分配角色页面',
        ],
        'update_total' => [
            'name' => '修改可用角色',
            'writable' => 1
        ],
        'update_base' => [
            'name' => '修改启用的基础角色',
            'writable' => 1
        ],
        'update_personal' => [
            'name' => '修改组员在组中的额外角色',
            'writable' => 1
        ],
    ]
];