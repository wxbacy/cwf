<?php

namespace auth;

use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Key;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Parser;
use Yaf_Registry;

/**
 * Token的各种操作，access_token,refresh_token，过期机制，刷新token等，多端共存，单端互斥
 *
 * @author chenwei
 */
class Token
{
    /**
     * 用户端类型，枚举：app admin...
     *
     * @var string
     */
    private $client;

    /**
     * Hmac signatures key
     *
     * @var string
     */
    private $key;

    /**
     * Token constructor.
     *
     * @param $client string 用户端类型，枚举：app admin...
     * @return void
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
     * 生成token
     *
     * @param $userId
     * @return string
     */
    public function create($userId)
    {
        $signer = new Sha256();
        $time = time();

        $token = (new Builder())->issuedBy($this->client) // Configures the issuer (iss claim)
                                ->issuedAt($time) // Configures the time that the token was issue (iat claim)
                                ->expiresAt(-1) // Configures the expiration time of the token (exp claim)
                                ->withClaim('user_id', $userId) // Configures a new claim, called "user_id"
                                ->getToken($signer, new Key($this->key)); // Retrieves the generated token
        return strval($token);
    }

    /**
     * 解析token
     *
     * @param $token string
     * @return 用户id
     */
    public function parse($token)
    {
        $token = (new Parser())->parse((string) $token); // Parses from a string
        return $token->getClaim('user_id');
    }
}
