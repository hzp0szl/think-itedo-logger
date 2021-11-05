<?php
namespace IteLog;

use think\App;
use think\Config;
use think\Log;
use think\Request;

class Logger
{
    private $request;
    public function __construct()
    {
        $this->request = Request::instance();
    }

    public function run()
    {
        $debug = ThinkLog::getLog();
        dd($debug);
    }
}