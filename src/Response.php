<?php

declare(strict_types=1);

namespace Verdient\WooCommerce;

use Verdient\http\Response as HttpResponse;
use Verdient\HttpAPI\Result;

/**
 * 响应
 * @author Verdient。
 */
class Response extends \Verdient\HttpAPI\AbstractResponse
{
    /**
     * @inheritdoc
     * @author Verdient。
     */
    protected function normailze(HttpResponse $response): Result
    {
        $result = new Result;
        $statusCode = $response->getStatusCode();
        $body = $response->getBody();
        if ($statusCode >= 200 && 300 > $statusCode) {
            $result->isOK = true;
            $result->data = $body;
        } else {
            $result->errorCode = $body['code'] ?? ($body['data']['status'] ?? $statusCode);
            $result->errorMessage = $body['message'] ?? $response->getStatusMessage();
        }
        return $result;
    }
}
