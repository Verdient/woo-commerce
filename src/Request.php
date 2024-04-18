<?php

declare(strict_types=1);

namespace Verdient\WooCommerce;

use Hyperf\Stringable\Str;

/**
 * 请求
 * @author Verdient。
 */
class Request extends \Verdient\http\Request
{
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
     * @inheritdoc
     * @author Verdient。
     */
    public function send()
    {
        $this->withAuthorization();
        return new Response(parent::send());
    }

    /**
     * 携带授权信息
     * @author Verdient。
     */
    protected function withAuthorization()
    {
        $url = $this->getUrl();
        $parsedUrl = parse_url($url);
        if ($parsedUrl['scheme'] === 'https') {
            $this->addHeader('Authorization', 'Basic ' . base64_encode($this->key . ':' . $this->secret));
        } else {
            $query = [];
            if (isset($parsedUrl['query'])) {
                parse_str($parsedUrl['query'], $query);
            }
            $params = array_merge($query, [
                'oauth_consumer_key' => $this->key,
                'oauth_timestamp' => time(),
                'oauth_nonce' => Str::random(32),
                'oauth_signature_method' => 'HMAC-SHA256',
            ]);
            uksort($params, 'strcmp');
            $baseUrl = $parsedUrl['scheme'] . '://' . $parsedUrl['host'] . (isset($parsedUrl['port']) ? (':' . $parsedUrl['port']) : '') . $parsedUrl['path'];
            $signStr = implode('&', [$this->getMethod(), rawurlencode($baseUrl), rawurlencode(http_build_query($params))]);
            $params['oauth_signature'] = base64_encode(hash_hmac('SHA256', $signStr, $this->secret . '&', true));
            $this->addHeader('Authorization', 'OAuth ' . http_build_query($params, '', ','));
        }
    }
}
