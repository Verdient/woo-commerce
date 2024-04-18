<?php

declare(strict_types=1);

namespace Verdient\WooCommerce;

use Verdient\WooCommerce\Traits\HasDetail;

/**
 * 系统状态
 * @author Verdient。
 */
class SystemStatus extends AbstractClient
{
    use HasDetail;

    /**
     * @inheritdoc
     * @author Verdient。
     */
    protected function resource(): string
    {
        return 'system_status';
    }
}
