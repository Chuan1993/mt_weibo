<?php
//配置后台管理系统的权限、菜单
//第一级key为module,module下的controllers的key为controller,controller下的actions的key为action
//key采用小写下划线命名方法,与url的path_info一样
return [
    //默认模块
    'index' => [
        'name' => '默认模块',
        'icon' => 'icon-home',
        'controllers' => [
            'index' => [
                'name' => '首页',
                'actions' => [
                    'index' => [
                        'name' => '首页'
                    ]
                ]
            ],
            'login' => [
                'name' => '登录',
                'actions' => [
                    'index' => [
                        'name' => '登录页面'
                    ],
                    'check' => [
                        'name' => '登录验证'
                    ],
                    'oa' => [
                        'name' => 'OA账号登录页面'
                    ],
                    'oa_callback' => [
                        'name' => 'OA账号登录验证'
                    ],
                ]
            ],
            'logout' => [
                'name' => '退出',
                'actions' => [
                    'index' => [
                        'name' => '退出'
                    ]
                ]
            ],
        ]
    ],

    //内容模块
    'content' => [
        'name' => '内容管理',
        'icon' => 'icon-stack',
        'controllers' => [
            'media' => [
                'name' => '视频管理',
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
            ],
            'search' => [
                'name' => '搜索',
                'actions' => [
                    'index' => [
                        'name' => '搜索',
                        'is_menu' => 1
                    ]
                ]
            ],
            'topic' => [
                'name' => '话题管理',
                'actions' => [
                    'index' => [
                        'name' => '列表',
                        'is_menu' => 1
                    ]
                ]
            ],
            'user' => [
                'name' => '用户管理',
                'actions' => [
                    'index' => [
                        'name' => '全部用户',
                        'is_menu' => 1
                    ],
                    'core' => [
                        'name' => '核心用户',
                        'is_menu' => 1
                    ],
                    'long_video' => [
                        'name' => '开通长视频的用户',
                        'is_menu' => 1
                    ],
                    'direct_message' => [
                        'name' => '开通私信的用户',
                        'is_menu' => 1
                    ],
                ]
            ],
        ]
    ],

    //统计模块
    'stats' => [
        'name' => '统计分析',
        'icon' => 'icon-bar-chart',
        'controllers' => [
            'base' => [
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
            ],
            'hot' => [
                'name' => '热门统计',
                'actions' => [
                    'tail_uid' => [
                        'name' => '分UID尾数用户活跃度',
                        'is_menu' => 1
                    ],
                    'from_hot' => [
                        'name' => '来自热门统计',
                        'is_menu' => 1
                    ],
                    'topic_snowball' => [
                        'name' => '话题滚雪球数据统计',
                        'is_menu' => 1
                    ],
                ]
            ],
        ]
    ],

    //设置模块
    'setting' => [
        'name' => '设置',
        'icon' => 'icon-cog',
        'controllers' => [
            'account' => [
                'name' => '后台账号管理',
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
            ],
            'config' => [
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
            ],
            'privilege' => [
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
            ],
            'role' => [
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
            ],
            'ip_whitelist_rule' => [
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
            ],
            'task' => [
                'name' => '后台异步任务',
                'actions' => [
                    'index' => [
                        'name' => '任务处理列表',
                        'is_menu' => 1
                    ],
                    'restart_daemon' => [
                        'name' => '重启守护进程',
                        'writable' => 1
                    ],
                    'restart_task' => [
                        'name' => '重启指定任务处理进程',
                        'writable' => 1
                    ],
                    'restart_all_tasks' => [
                        'name' => '重启所有任务处理进程',
                        'writable' => 1
                    ],
                    'set_task_running_switch' => [
                        'name' => '设置指定任务是否启动',
                        'writable' => 1
                    ],
                    'set_all_tasks_running_switch' => [
                        'name' => '设置所有任务是否启动',
                        'writable' => 1
                    ],
                    'set_worker_num' => [
                        'name' => '设置指定任务处理进程数',
                        'writable' => 1
                    ],
                ]
            ],
        ]
    ],
];