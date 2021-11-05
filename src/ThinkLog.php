<?php
namespace IteLog;

use \think\Log;

class ThinkLog extends Log
{
    public static function getLog($type = '')
    {
        return Log::getLog($type);
    }
}