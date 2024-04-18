<?php

declare(strict_types=1);

namespace Verdient\WooCommerce;

use Verdient\WooCommerce\Traits\HasCreate;
use Verdient\WooCommerce\Traits\HasList;
use Verdient\WooCommerce\Traits\HasOne;

/**
 * 商品变体
 * @author Verdient。
 */
class ProductVariant extends AbstractClient
{
    use HasCreate;
    use HasOne;
    use HasList;

    /**
     * @var int 商品编号
     * @author Verdient。
     */
    protected $productId;

    /**
     * @param string $productId 商品编号
     * @param $endpoint 接入点
     * @param $key 访问标识
     * @param $secret 访问秘钥
     * @param $version 版本
     * @author Verdient。
     */
    public function __construct($productId, $endpoint, $key, $secret, $version = 'v3')
    {
        $this->productId = $productId;
        parent::__construct($endpoint, $key, $secret, $version);
    }

    /**
     * @inheritdoc
     * @author Verdient。
     */
    protected function resource(): string
    {
        return 'products/' . $this->productId . '/variations';
    }
}
