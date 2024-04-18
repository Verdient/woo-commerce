<?php

declare(strict_types=1);

namespace Verdient\WooCommerce\Traits;

use Verdient\WooCommerce\Response;

/**
 * 包含创建
 * @author Verdient。
 */
trait HasCreate
{
    /**
     * 创建
     * @param array $data 数据
     * @return Response
     * @author Verdient。
     */
    public function create($data = []): Response
    {
        return $this->request($this->resource())
            ->setMethod('POST')
            ->setTimeout(30)
            ->setBody($data)
            ->send();
    }
}
