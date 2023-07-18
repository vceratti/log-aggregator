<?php

declare(strict_types=1);

namespace Tests\Assets\DataProvider;

use Symfony\Component\HttpFoundation\Request;

class SymfonyRequestDataProvider
{
    private const VALID_URL = 'http://localhost/count';

    /** @return array<string, array<int, Request>> */
    public static function validGetRequest(): array
    {

        return [
            'valid.get.request' => [Request::create(self::VALID_URL)],
            'valid.get.request.with.param' => [Request::create(self::VALID_URL, 'GET', ['statusCode' => 1])],
            'valid.get.request.with.dummy.param' => [Request::create(self::VALID_URL, 'GET', ['dummy' => 1])]
        ];
    }

    /** @return array<string, array<int, Request>> */
    public static function invalidGetRequest(): array
    {
        return [
            'empty.route.request' => [Request::create('')],
            'invalid.route.request' => [Request::create('/invalid')],
            'invalid.method' => [Request::create(self::VALID_URL, 'INVALID')],
            'invalid.params' => [Request::create(self::VALID_URL, 'GET', ['statusCode' => 'invalid'])]
        ];
    }
}
