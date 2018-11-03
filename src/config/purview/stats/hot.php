<?php
//控制器配置
return [
    'id' => 'hot',
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
];