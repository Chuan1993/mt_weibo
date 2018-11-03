<?php
////全局常量定义

//运行环境(http://cf.meitu.com/confluence/pages/viewpage.action?pageId=19728984)
define('ENVIRONMENT_KEY', 'MY_ENV'); //环境标识key
define('ENVIRONMENT_RD_TEST', 'rd-test'); //本地或内网开发环境
define('ENVIRONMENT_RD_COMMON', 'rd-common'); //开发测试环境
define('ENVIRONMENT_PRE', 'pre'); //拟真环境
define('ENVIRONMENT_BETA', 'beta'); //Beta环境
define('ENVIRONMENT_RELEASE', 'release'); //生产环境



define('PLATFORM_ID_IOS', 1);
define('PLATFORM_ID_ANDROID', 2);

//db group name
define('DB_GROUP_MAIN', 'db.main');
define('DB_GROUP_ADMIN', 'db.admin');

//消息队列异步任务名称
define('TASK_PREFIX', 'mt_demo_task:');
define('TASK_NAME_DELETE_FILE', 'delete_file');
define('TASK_NAME_DELETE_ALBUM', 'delete_album');
define('TASK_NAME_AFTER_ADD_MEDIA', 'after_add_media');
define('TASK_NAME_AFTER_DELETE_MEDIA', 'after_delete_media');

//美图微博
define('NOW_DATE', date('Y-m-d H:i:s'));
//define('THIS_IP', $_SERVER['HTTP_CLIENT_IP']);
define('CLIENT_WEB_ID', 'mt_weibo_web');