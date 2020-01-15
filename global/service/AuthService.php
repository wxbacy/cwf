<?php

namespace service;

use cache\TokenCache;
use Yaf_Registry;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Key;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Parser;

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

    // Hmac signatures key
    private $key;

    /**
     * 初始化指定client
     *
     * @param $client string app admin...
     */
    public function __construct($client)
    {
        $this->client = $client;
        $this->key = $this->getKey();
    }

    /**
     * 获取jwt签名密钥
     *
     * @return string
     */
    private function getKey()
    {
        return Yaf_Registry::get('config')->JWT->key;
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
    private function createToken($userId)
    {
        $signer = new Sha256();
        $time = time();

        $token = (new Builder())->issuedBy($this->client) // Configures the issuer (iss claim)
                                ->issuedAt($time) // Configures the time that the token was issue (iat claim)
                                ->expiresAt(-1) // Configures the expiration time of the token (exp claim)
                                ->withClaim('user_id', $userId) // Configures a new claim, called "user_id"
                                ->getToken($signer, new Key($this->key)); // Retrieves the generated token
        $token = strval($token);

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
        $token = (new Parser())->parse((string) $token); // Parses from a string
        return $token->getClaim('user_id');
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
