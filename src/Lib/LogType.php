<?php
namespace Mt\Lib;

class LogType extends \Fw\LogType
{
    const PHP_ERROR = 'php.error';
    const PHP_SHUTDOWN = 'php.shutdown';
    const PHP_EXCEPTION = 'php.exception';

    const BEHAVIOR_ERROR = 'behavior.error';
}