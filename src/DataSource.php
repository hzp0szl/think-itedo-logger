<?php

namespace IteLog;

use think\Db;
use think\db\Connection;
use think\Hook;
use think\Request;
use think\Response;

/**
 * 处理数据源
 * Class DataSource
 * @package IteLog
 */
class DataSource
{
    // 请求类
    private $request;
    // 相应类
    private $response;
    //运行时间
    private $runtime;
    // 返回数据
    private $result = [];

    /**
     * DataSource constructor.
     */
    public function __construct()
    {
        $this->request = Request::instance();
        $this->response = new Response();
    }

    /**
     * 处理
     */
    public function assemble(): self
    {
        $this->assembleSource()
            ->assembleStartTime()
            ->assembleRequest()
            ->assembleHeaders()
            ->assembleResource()
            ->assembleStopTime()
            ->assembleDiffTime()
            ->assembleExceptions()
            ->assembleInfo()
            ->assembleError();

        return $this;
    }

    /**
     * 数据来源
     *
     * @return $this
     */
    private function assembleSource(): self
    {
        $this->result['source'] = 'think-itedo-logger';
        return $this;
    }

    /**
     * 开始时间
     *
     * @return $this
     */
    private function assembleStartTime(): self
    {
        $date = new \DateTime();
        $startTime = microtime(true);
        $this->result['startTime'] = $date->format('Y-m-d H:i:s.')
            . sprintf('%06d', ($startTime - floor($startTime)) * pow(10, 6));
        return $this;
    }

    /**
     * 结束时间
     *
     * @return $this
     */
    private function assembleStopTime(): self
    {
        $date = new \DateTime();
        $stopTime = microtime(true);
        $this->result['stopTime'] = $date->format('Y-m-d H:i:s.')
            . sprintf('%06d', ($stopTime - floor($stopTime)) * pow(10, 6));
        return $this;
    }

    /**
     * 间隔时间
     *
     * @return $this
     */
    private function assembleDiffTime(): self
    {
        $this->result['diffTime'] = number_format($this->runtime, 6) * 1000 . 'ms';
        return $this;
    }

    /**
     * 请求参数
     *
     * @return $this
     */
    private function assembleRequest(): self
    {
        $this->result['request'] = [
            'secure' => $this->request->scheme(),
            'ipPort' => $this->request->ip() . ':' . $this->request->port(),
            'methodUri' => $this->request->method() . ':' . $this->request->baseUrl(),
            'url' => $this->request->url(true),
            'param' => $this->request->get(),
        ];
        return $this;
    }

    /**
     * 请求头参数
     *
     * @return $this
     */
    private function assembleHeaders(): self
    {
        $this->result['headers'] = $this->request->header();
        $this->result['headers']['server_protocol'] = $this->request->server('SERVER_PROTOCOL');
        $this->result['headers']['request_time_float'] = $this->request->server('REQUEST_TIME_FLOAT');
        $this->result['headers']['request_time'] = date('Y-m-d H:i:s', $this->request->server('REQUEST_TIME'));
        return $this;
    }

    /**
     * 响应数据
     *
     * @return $this
     */
    private function assembleResource(): self
    {
        $pdo = new Pdo();

        $this->result['resource'] = [
            'serverInfo' => $pdo->serverInfo(),
            'connectionStatus' => $pdo->connectionStatus(),
            'serverVersion' => $pdo->serverVersion(),
            'sqlArr' => ThinkLog::getLog('sql'),
            'timeStr' => $this->timeStr(),
            'memoryStr' => $this->memoryStr(),
            'fileLoad' => $this->fileLoad(),
            'response' => $this->response->getContent(),
            'status' => $this->response->getCode(),
        ];
        return $this;
    }

    /**
     * 运行情况
     *
     * @return string
     */
    private function timeStr()
    {
        $this->runtime = round(microtime(true) - THINK_START_TIME, 10);
        $reqs = $this->runtime > 0 ? number_format(1 / $this->runtime, 2) : '∞';
        return '[运行时间：' . number_format($this->runtime, 6) . 's] [吞吐率：' . $reqs . 'req/s]';
    }

    /**
     * 内存消耗
     *
     * @return string
     */
    private function memoryStr()
    {
        $memory_use = number_format((memory_get_usage() - THINK_START_MEM) / 1024, 2);
        return ' [内存消耗：' . $memory_use . 'kb]';
    }

    /**
     * 文件加载
     *
     * @return string
     */
    private function fileLoad()
    {
        return ' [文件加载：' . count(get_included_files()) . ']';
    }

    /**
     * info 信息
     *
     * @return $this
     */
    public function assembleInfo(): self
    {
        $info = ThinkLog::getInfo();
        $this->result['info'] = $info['info'] ?? [];
        $this->result['printInfo'] = $info['printInfo'] ?? [];
        return $this;
    }

    /**
     * error 信息
     *
     * @return $this
     */
    public function assembleError(): self
    {
        $this->result['printError'] = ThinkLog::getError();
        return $this;
    }

    /**
     * error 信息
     *
     * @return $this
     */
    public function assembleExceptions(): self
    {
        $this->result['exceptions'] = ThinkLog::getLog('error');
        return $this;
    }

    /**
     * 返回结构
     *
     * @return array
     */
    public function toArray(): array
    {
        return $this->result;
    }
}