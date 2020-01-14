<?php

namespace db;

use Medoo\Medoo;
use Exception;
use Yaf_Registry;

/**
 * 模型基类，初始化medoo实例并实现单例
 *
 * @author chenwei
 */
class BaseDB extends Medoo
{
    /**
     * 默认连接名称
     *
     * @var string
     */
    const DEFAULT_LINKNAME = 'default';

    /**
     * 初始化medoo实例并实现单例
     *
     * @throws Exception
     */
    public function __construct()
    {
        static $dbConnecter;
        if ($dbConnecter) {
            $this->pdo = $dbConnecter;
        } else {
            $linkName = $this->getLinkName();
            $dbConfig = $this->getConf($linkName);
            parent::__construct($dbConfig);
            $dbConnecter = $this->pdo;
        }
    }

    /**
     * 获取连接名称，子类有静态变量指定则用子类指定的，否则用默认连接
     *
     * @return string
     */
    private function getLinkName()
    {
        if (empty(static::$linkName)) {
            $linkName = self::DEFAULT_LINKNAME;
        } else {
            $linkName = static::$linkName;
        }
        return $linkName;
    }

    /**
     * 获取配置
     *
     * @param $linkName 连接名称
     * @return array
     * @throws Exception
     */
    private function getConf($linkName)
    {
        $dbConfig = Yaf_Registry::get('config')->database->$linkName->toArray();
        if (empty($dbConfig['database_type'])) {
            throw new Exception('database.' . $linkName . '.database_type不能为空');
        }
        if (empty($dbConfig['database_name'])) {
            throw new Exception('database.' . $linkName . '.database_name不能为空');
        }
        if (empty($dbConfig['charset'])) {
            throw new Exception('database.' . $linkName . '.charset不能为空');
        }
        if (empty($dbConfig['port'])) {
            throw new Exception('database.' . $linkName . '.port不能为空');
        }
        if (empty($dbConfig['server'])) {
            throw new Exception('database.' . $linkName . '.server不能为空');
        }
        if (empty($dbConfig['username'])) {
            throw new Exception('database.' . $linkName . '.username不能为空');
        }
        if (empty($dbConfig['password'])) {
            throw new Exception('database.' . $linkName . '.password不能为空');
        }
        return $dbConfig;
    }
}
