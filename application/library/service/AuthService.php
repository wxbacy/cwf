<?php

namespace service;

use auth\Token;
use cache\TokenCache;

/**
 * 身份验证业务
 *
 * @author chenwei
 */
class AuthService
{
    // 所属端：app admin...
    private $client;

    // token有效时长，时间戳长度
    private $ttl;

    /**
     * 初始化指定client
     *
     * @param $client string app admin...
     */
    public function __construct($client)
    {
        $this->client = $client;
    }

    /**
     * 设置token有效时长
     *
     * @param $ttl number
     */
    public function setTTL($ttl)
    {
        $this->ttl = $ttl;
    }

    /**
     * 设置token类型
     *
     * @param $tokenType string access_token/refresh_token
     */
    public function setTokenType($tokenType)
    {
        $this->tokenType = $tokenType;
    }

    /**
     * 生成token
     *
     * @param $userId
     * @return bool|string
     * @throws \Exception
     */
    public function createToken($userId)
    {
        $authToken = new Token($this->client);
        $token = $authToken->create($userId);

        $tokenCache = new TokenCache($this->client, $this->tokenType, $userId);
        if (! $tokenCache->set($this->ttl, $token)) {
            return false;
        }
        return $token;
    }

    /**
     * 解析token，返回用户id
     *
     * @param $token string
     * @return \auth\用户id
     */
    public function parseToken($token)
    {
        $authToken = new Token($this->client);
        return $authToken->parse($token);
    }

    /**
     * token校验
     *
     * @param $userId 用户id
     * @param $token string
     * @return bool
     * @throws \Exception
     */
    public function validateToken($userId, $token)
    {
        $tokenCache = new TokenCache($this->client, $this->tokenType, $userId);
        return $tokenCache->isLive($token);
    }

    /**
     * 使token无效
     *
     * @param $userId 用户id
     * @return int
     * @throws \Exception
     */
    public function invalidToken($userId)
    {
        $tokenCache = new TokenCache($this->client, $this->tokenType, $userId);
        return $tokenCache->del();
    }
}
