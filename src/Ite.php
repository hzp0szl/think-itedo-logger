<?php
namespace IteLog;

use think\App;
use think\Request;

class Ite extends App
{
    public static function run(Request $request = null)
    {
        dd($request);
    }
}