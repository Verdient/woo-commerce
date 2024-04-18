<?php

declare(strict_types=1);

namespace Verdient\WooCommerce;

use Verdient\WooCommerce\Traits\HasList;
use Verdient\WooCommerce\Traits\HasOne;

/**
 * 订单
 * @author Verdient。
 */
class Order extends AbstractClient
{
    use HasOne;
    use HasList;

    /**
     * @inheritdoc
     * @author Verdient。
     */
    protected function resource(): string
    {
        return 'orders';
    }
}
