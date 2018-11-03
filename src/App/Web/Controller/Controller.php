<?php
namespace Mt\App\Web\Controller;

use Mt\Lib\Config;
use Mt\Lib\Time;
use Mt\Lib\LogType;
use Fw\App;

class Controller extends \Fw\Controller
{
    protected $view;

    protected $requireLogin = true;
    protected $sessionInfo;

    //客户端类型
    protected $phoneType;

    protected $cookieToken;

    public $errorCodeFile = 'webErrorCode';

    public function before()
    {
        //TODO：判断是否需要登录等操作
    }

    public function requireLogin()
    {

    }

    public function outputJson($errorCode,$info = ''){

        $data = Config::errorLang($this->errorCodeFile.'.'.$errorCode);

        if(empty($data)){
            $data = Config::errorLang($this->errorCodeFile.'.mer_system_err');
        }

        if(!empty($info)){
            $data['data'] = $info;
        }
        $this->_req_log();

        $this->response->json($data);
    }

    /**
     * 请求日志
     */
    private function _req_log()
    {
        // todo $_REQUEST里头的敏感信息需要unset掉

        $module = $this->request->getModule() ? $this->request->getModule() : '';
        $controller = $this->request->getController();
        $action = $this->request->getAction();

        $log = [];
        $log['elapsed_time'] = Time::getInstance()->getElapsedTime();
        $log['controller'] = $controller;
        $log['action'] = $action;
        $log['request'] = json_encode($_REQUEST, JSON_UNESCAPED_UNICODE);

        $log = json_encode($log);

        $logger = App::getInstance()->getLogger();
        $logger->warn($log, LogType::PHP_EXCEPTION);
    }
}