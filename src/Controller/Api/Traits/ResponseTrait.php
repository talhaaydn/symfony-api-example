<?php

namespace App\Controller\Api\Traits;

use FOS\RestBundle\View\View;

trait ResponseTrait
{
    /**
     * @param array $result
     * @param bool $isSuccess
     * @param int $statusCode
     * @param null $error
     * @return View
     */
    public function response(array $result, bool $isSuccess, int $statusCode, $error = null): View
    {
        return View::create(
            [
                'error' => $error,
                'isSuccess' => $isSuccess,
                'result' => $result,
                'statusCode' => $statusCode
            ],
            $statusCode
        );
    }
}