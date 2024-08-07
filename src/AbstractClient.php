<?php

declare(strict_types=1);

namespace Verdient\WooCommerce;

use Verdient\http\serializer\query\KeepNameSerializer;

/**
 * 抽象客户端
 * @author Verdient。
 */
abstract class AbstractClient
{
    /**
     * @var string 接入点
     * @author Verdient。
     */
    protected $endpoint;

    /**
     * @var string 访问标识
     * @author Verdient。
     */
    protected $key;

    /**
     * @var string 访问秘钥
     * @author Verdient。
     */
    protected $secret;

    /**
     * @var string 版本
     * @author Verdient。
     */
    protected $version = 'v3';

    /**
     * @var string 代理地址
     * @author Verdient。
     */
    protected $proxyHost = null;

    /**
     * @var int 代理端口
     * @author Verdient。
     */
    protected $proxyPort = null;

    /**
     * @param $endpoint 接入点
     * @param $key 访问标识
     * @param $secret 访问秘钥
     * @param $version 版本
     * @author Verdient。
     */
    public function __construct($endpoint, $key, $secret, $version = 'v3')
    {
        $this->endpoint = $endpoint;
        $this->key = $key;
        $this->secret = $secret;
        $this->version = $version;
    }

    /**
     * 请求
     * @param string $path 请求路径
     * @return Request
     * @author Verdient。
     */
    public function request($path): Request
    {
        $request = (new Request([
            'key' => $this->key,
            'secret' => $this->secret
        ]))
            ->setUrl($this->endpoint . '/wp-json/wc/' . $this->version . '/' . $path);
        // ->setQuerySerializer(KeepNameSerializer::class);

        if ($this->proxyHost) {
            $request->setProxy($this->proxyHost, $this->proxyPort);
        }

        return $request;
    }

    /**
     * 设置代理
     * @param string $host 地址
     * @param int $port 端口
     * @return static
     * @author Verdient。
     */
    public function setProxy($host, $port)
    {
        $this->proxyHost = $host;
        $this->proxyPort = $port;
        return $this;
    }

    /**
     * 资源
     * @return string
     * @author Verdient。
     */
    abstract protected function resource(): string;
}
