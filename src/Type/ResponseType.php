<?php

namespace App\Type;

class ResponseType
{
    public array $error;

    public bool $isSuccess;

    public array $result;

    public int $statusCode;
}