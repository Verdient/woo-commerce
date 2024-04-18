<?php

declare(strict_types=1);

namespace Verdient\WooCommerce\Traits;

use Exception;
use Iterator;
use Verdient\WooCommerce\Response;

/**
 * 包含列表
 * @author Verdient。
 */
trait HasList
{
    /**
     * 获取列表
     * @param array $query 检索条件
     * @return Response
     * @author Verdient。
     */
    public function list($query = []): Response
    {
        return $this
            ->request($this->resource())
            ->setQuery($query)
            ->send();
    }

    /**
     * 批量迭代
     * @param array $query 检索条件
     * @return Iterator
     * @author Verdient。
     */
    public function batch($query = []): Iterator
    {
        return $this->iterator($query);
    }

    /**
     * 单个迭代
     * @param array $query 检索条件
     * @return Iterator
     * @author Verdient。
     */
    public function each($query = []): Iterator
    {
        foreach ($this->iterator($query) as $rows) {
            foreach ($rows as $row) {
                yield $row;
            }
        }
    }

    /**
     * 迭代器
     * @param array $query 查询条件
     * @return Iterator
     * @author Verdient。
     */
    public function iterator($query): Iterator
    {
        $isOK = false;
        $exception = null;
        for ($i = 0; $i < 3; $i++) {
            try {
                $res = $this->list($query);
                $isOK = true;
                break;
            } catch (\Throwable $e) {
                $exception = $e;
            }
        }
        if (!$isOK) {
            throw $exception;
        }
        $continue = true;
        while ($continue) {
            $continue = false;
            if (!$res->getIsOK()) {
                throw new Exception($res->getErrorMessage());
            }
            yield $res->getData();
            $headers = $res->getResponse()->getHeaders();
            $link = $headers['link'] ?? ($headers['Link'] ?? null);
            if ($link) {
                foreach (explode(', ', $link) as $ref) {
                    $ref = explode('; ', $ref);
                    if ($ref[1] === 'rel="next"') {
                        $url = substr($ref[0], 1, -1);
                        $isOK = false;
                        for ($i = 0; $i < 3; $i++) {
                            try {
                                $res = $this->request('')->setUrl($url)->send();
                                $isOK = true;
                                break;
                            } catch (\Throwable $e) {
                                $exception = $e;
                            }
                        }
                        if (!$isOK) {
                            throw $exception;
                        }
                        $continue = true;
                        break;
                    }
                }
            }
        }
    }
}
