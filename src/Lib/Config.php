<?php
/**
 * Message:
 * User: jzc<jzc1@meitu.com>
 * Date: 2018/8/31
 * Time: 下午1:57
 * Return:
 */

namespace Mt\Lib;

use Fw\App;
use Fw\Config\PhpConfig;

class Config
{
    public static function errorLang($key){
        $app = App::getInstance();

        $rootPath = $app->getRootPath();
        $rootPath = $rootPath.'/src/config/error_lang/zh-cn';

        $config = PhpConfig::getInstance($rootPath);

        return $config->get($key);
    }
}