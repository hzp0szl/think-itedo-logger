<?php

namespace IteLog;

use PDO as ThinkPDO;

/**
 * Class Pdo
 * @package IteLog
 */
class Pdo
{
    // 实例对象
    private $pdo;

    // PDO连接参数
    protected $params = [
        ThinkPDO::ATTR_CASE => ThinkPDO::CASE_NATURAL,
        ThinkPDO::ATTR_ERRMODE => ThinkPDO::ERRMODE_EXCEPTION,
        ThinkPDO::ATTR_ORACLE_NULLS => ThinkPDO::NULL_NATURAL,
        ThinkPDO::ATTR_STRINGIFY_FETCHES => false,
        ThinkPDO::ATTR_EMULATE_PREPARES => false,
    ];

    /**
     * Pdo constructor.
     */
    public function __construct()
    {
        $database = ROOT_PATH . 'config/database.php';
        $config = \think\Config::load($database, 'database');
        // 连接参数
        if (isset($config['params']) && is_array($config['params'])) {
            $params = $config['params'] + $this->params;
        } else {
            $params = $this->params;
        }
        $this->pdo = new ThinkPDO('mysql::memory:', $config['username'], $config['password'], $params);
    }

    /**
     * 执行详情
     *
     * @return mixed
     */
    public function serverInfo()
    {
        return $this->pdo->getAttribute(ThinkPDO::ATTR_SERVER_INFO);
    }

    /**
     * 链接状态
     *
     * @return mixed
     */
    public function connectionStatus()
    {
        return $this->pdo->getAttribute(ThinkPDO::ATTR_CONNECTION_STATUS);
    }

    /**
     * 版本
     *
     * @return string
     */
    public function serverVersion()
    {
        return 'mysql: ' . $this->pdo->getAttribute(ThinkPDO::ATTR_SERVER_VERSION);
    }
}