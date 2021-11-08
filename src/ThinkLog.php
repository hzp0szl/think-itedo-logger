<?php
namespace IteLog;

use \think\Log;

class ThinkLog extends Log
{
    /**
     * 根据类型获取数据
     *
     * @param string $type
     * @return array|string
     */
    public static function getLog($type = '')
    {
        return $type ? self::$log[$type] ?? [] : self::$log;
    }

    /**
     * 获取info
     *
     * @return array
     */
    public static function getInfo(): array
    {
        $infoArray = [];
        foreach (ThinkLog::getLog('info') as $info) {
            if(is_array($info) || !(strpos($info,' ] ') !== false)){
                $infoArray['printInfo'][] = $info;
                continue;
            }
            if(strpos($info,'ROUTE') !== false
                ||strpos($info,'HEADER') !== false
                ||strpos($info,'PARAM') !== false
                || strpos($info,'SESSION') !== false){
                continue;
            }
            $infoArray['info'][] = $info;
        }
        return $infoArray;
    }

    /**
     * 获取自定义错误信息
     *
     * @return array|string
     */
    public static function getError()
    {
        return ThinkLog::getLog('error');
    }
}