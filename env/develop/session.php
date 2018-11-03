<?php
//session配置
return [
    'save_handler' => 'files',
    'save_path' => '/tmp',
    'name' => 'MUSID',
    'gc_maxlifetime' => 86400,
    'cookie_lifetime' => 86400,
    'cookie_path' => '/',
//    'cookie_domain' => '',
    'cookie_secure' => false,
    'cookie_httponly' => true,
];