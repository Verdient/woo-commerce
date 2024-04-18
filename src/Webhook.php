<?php

declare(strict_types=1);

namespace Verdient\WooCommerce;

use Verdient\WooCommerce\Traits\HasCreate;
use Verdient\WooCommerce\Traits\HasDelete;
use Verdient\WooCommerce\Traits\HasList;

/**
 * 网络钩子
 * @author Verdient。
 */
class Webhook extends AbstractClient
{
    use HasCreate;
    use HasDelete;
    use HasList;

    /**
     * @inheritdoc
     * @author Verdient。
     */
    protected function resource(): string
    {
        return 'webhooks';
    }
}
