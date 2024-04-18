<?php

declare(strict_types=1);

namespace Verdient\WooCommerce;

use Verdient\WooCommerce\Traits\HasCreate;
use Verdient\WooCommerce\Traits\HasList;
use Verdient\WooCommerce\Traits\HasOne;

/**
 * 商品
 * @author Verdient。
 */
class Product extends AbstractClient
{
    use HasCreate;
    use HasOne;
    use HasList;

    /**
     * @inheritdoc
     * @author Verdient。
     */
    protected function resource(): string
    {
        return 'products';
    }
}
