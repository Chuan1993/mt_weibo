<?php
namespace Mt\App\Api\Controller;

use Fw\App;
use Fw\Exception\ErrorHandlerException;
use Fw\Exception\NotFoundException;
use Fw\Exception\ShutdownException;
use Fw\Exception\WarningHandlerException;
use Fw\Logger;
use Mt\Lib\LogType;

class Error extends Controller
{
    /**
     * @param \Exception $e
     */
    public function main($e)
    {
        //write log
        $logger = App::getInstance()->getLogger();
        $message = $e->getMessage();
        $logInfo = [
            'code' => $e->getCode(),
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine()
        ];
        $logInfo = json_encode($logInfo);

        if ($e instanceof ShutdownException) {
            $logger->error($logInfo, LogType::PHP_SHUTDOWN);
        } elseif ($e instanceof ErrorHandlerException) {
            $logger->error($logInfo, LogType::PHP_ERROR);
        } elseif ($e instanceof WarningHandlerException) {
            //警告类的错误异常仅记录日志,不进行页面展示
            $logger->warn($logInfo, LogType::PHP_ERROR);
            return;
        } elseif ($e instanceof NotFoundException) {
            $message = '404 NOT FOUND (' . $message . ')';
        } else {
            $logger->warn($logInfo, LogType::PHP_EXCEPTION);
        }
    }
}