<?php

declare(strict_types=1);

namespace Tests\Assets\DataProvider;

use Nyholm\Psr7\ServerRequest;
use Nyholm\Psr7\Uri;
use Psr\Http\Message\ServerRequestInterface;

class PsrRequest
{
    private const VALID_URL = 'http://localhost/count';

    private static function validUri(): Uri
    {
        return new Uri(self::VALID_URL);
    }

    /** @return array<string, array<int, ServerRequestInterface>> */
    public static function validGetRequest(): array
    {
        return [
            'valid.get.request' => [new ServerRequest('GET', self::validUri())],
            'valid.get.request.with.param' => [
                new ServerRequest('GET', self::validUri()->withQuery('statusCode=1'))
            ],
            'valid.get.request.with.dummy.param' => [
                new ServerRequest('GET', self::validUri()->withQuery('dummy=1'))
            ]
        ];
    }

    /** @return array<string, array<int, ServerRequestInterface>> */
    public static function invalidGetRequest(): array
    {

        return [
            'empty.route.request' => [new ServerRequest('GET', self::validUri()->withPath(''))],
            'invalid.route.request' => [new ServerRequest('GET', self::validUri()->withPath('/invalid'))],
            'empty.method.request' => [new ServerRequest('', self::validUri())],
            'invalid.method' => [new ServerRequest('INVALID', self::validUri())],
            'invalid.params' => [new ServerRequest('GET', self::validUri()->withQuery('statusCode=invalid'))]
        ];
    }

}
