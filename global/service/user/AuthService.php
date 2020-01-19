<?php

namespace service\user;

use cache\TokenCache;
use Yaf_Registry;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Key;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Parser;
use Exception;

/**
 * 身份验证
 *
 * @author chenwei
 */
class AuthService
{
    // 所属应用：app admin...
    private $application;

    // token有效时长，时间戳长度
    private $ttl;

    // Hmac signatures key
    private $key;

    public function __construct($application = '')
    {
        if ($application) {
            $this->application = $application;
        } else {
            $this->application = Yaf_Registry::get('application');
        }
        $this->key = $this->getKey();
    }

    public function setAppClient()
    {
        $this->client = 'app';
        $this->ttl = 86400 * 7;
    }

    public function setAdminClient()
    {
        $this->client = 'admin';
        $this->ttl = 3600;
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
     * 生成token
     *
     * @param $userId
     * @return bool|string
     * @throws \Exception
     */
    public function createToken($userId)
    {
        $signer = new Sha256();
        $time = time();

        $token = (new Builder())->issuedBy($this->application) // Configures the issuer (iss claim)
                                ->issuedAt($time) // Configures the time that the token was issue (iat claim)
                                ->expiresAt(-1) // Configures the expiration time of the token (exp claim)
                                ->withClaim('user_id', $userId) // Configures a new claim, called "user_id"
                                ->getToken($signer, new Key($this->key)); // Retrieves the generated token
        $token = strval($token);

        $tokenCache = new TokenCache($this->application, $userId);
        if (! $tokenCache->set($this->ttl, $token)) {
            throw new Exception('token生成失败');
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
        $tokenCache = new TokenCache($this->application, $userId);
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
        $tokenCache = new TokenCache($this->application, $userId);
        return $tokenCache->del();
    }

    /**
     * 刷新token有效期
     *
     * @param $userId
     * @return bool
     */
    public function refreshTokenExpire($userId)
    {
        $tokenCache = new TokenCache($this->application, $userId);
        $tokenCache->expire($this->ttl);
    }
}