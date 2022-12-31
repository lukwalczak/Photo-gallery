<?php

namespace Core;

class Response
{
    public $statusCode;
    public $data;

    public function __construct($statusCode = 200, $data = [])
    {
        $this->statusCode = $statusCode;
        $this->data = $data;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function setStatusCode(int $statusCode): void
    {
        $this->statusCode = $statusCode;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function setData(array $data): void
    {
        $this->data = $data;
    }

}