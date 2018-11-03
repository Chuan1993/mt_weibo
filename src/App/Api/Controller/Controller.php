<?php
namespace Mt\App\Api\Controller;

use Mt\Lib\Config;
use Fw\App;
use Mt\Lib\Time;
use Mt\Lib\LogType;
use Mt\Model\UserModel;

class Controller extends \Fw\Controller
{
    protected $view;

    protected $requireLogin = true;
    protected $sessionInfo;
    protected $cookieToken;

    //客户端类型
    protected $phoneType;

    protected $uid;

    public $errorCodeFile = 'apiErrorCode';

    public function before()
    {
        $suffix = $this->request->getSuffix();
        $supportedSuffixes = App::getInstance()->getSupportedSuffixes();
        if(!in_array($suffix,$supportedSuffixes)){
            $this->outputJson('need_json_request');
        }

        if ($this->requireLogin) {
            $this->requireLogin();
        }
    }

    public function requireLogin()
    {
        $cookieToken = isset($_COOKIE['__mt_access_token__']) ? $_COOKIE['__mt_access_token__'] : "";
        if (empty($cookieToken)) {
            $this->outputJson('miss_cookie');
        }

        $this->uid = $cookieToken;

        if (empty(UserModel::getInstance()->getOneByOption(['uid' => $this->uid], $this->uid))) {
            $this->outputJson('no_user');
        }
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