<?php
//控制器配置
return [
    'id' => 'task',
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
];