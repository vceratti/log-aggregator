<?php

declare(strict_types=1);

namespace Tests\Assets\DataProvider;

use Symfony\Component\HttpFoundation\Request;

class SymfonyRequest
{
    /** @return array<string, array<int, Request>> */
    public static function validGetRequest(): array
    {
        return [
            'valid.get.request' => [Request::create('http://localhost/count', 'GET', [], [], [], [])]
        ];
    }
}
