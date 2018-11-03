<?php
namespace Mt\Lib;

use Fw\App;
use Fw\InstanceTrait;
use Fw\Request;
use Fw\Response;

class AdminLogger
{
    use InstanceTrait;

    public function log($accountId, $email, Request $request)
    {
        $message = [
            'url' => $request->getOriginPathInfo(),
            'get' => $_GET,
            'post' => $_POST,
        ];
        $message = json_encode($message, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_PARTIAL_OUTPUT_ON_ERROR);
        $serverIp = $request->getServerIp();
        $log = [
            date('c'),
            $accountId,
            $email,
            $serverIp,
            $request->getClientIp(),
            $request->getReqId(),
            $message
        ];
        $content = '[' . implode(']  [', $log) . ']' . "\n";
        $dir = App::getInstance()->env('app.admin_op_log_path') . '/' . date('Ymd');
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
        $filename = $dir . '/' . $serverIp . '-' . date('H') . '.log';
        return error_log($content, 3, $filename);
    }
}