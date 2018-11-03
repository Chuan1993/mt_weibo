<?php
//配置路由重写规则
return [
    '/index/(:num)' => '/index/index/$1',
    '/(:num)' => '/setting/task/index/$1',
];