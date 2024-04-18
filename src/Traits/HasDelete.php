<?php

declare(strict_types=1);

namespace Verdient\WooCommerce\Traits;

use Verdient\WooCommerce\Response;

/**
 * 包含删除
 * @author Verdient。
 */
trait HasDelete
{
    /**
     * 删除
     * @param int $id 编号
     * @return Response
     * @author Verdient。
     */
    public function delete($id): Response
    {
        return $this->request($this->resource() . '/' . $id)
            ->setBody(['force' => true])
            ->setMethod('DELETE')
            ->send();
    }
}
