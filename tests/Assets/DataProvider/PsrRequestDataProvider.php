<?php

declare(strict_types=1);

namespace Tests\Assets\DataProvider;

use GuzzleHttp\Psr7\ServerRequest;
use GuzzleHttp\Psr7\Uri;
use Psr\Http\Message\ServerRequestInterface;

class PsrRequestDataProvider
{
    private const VALID_URL = 'http://localhost/count';

    private static function validUri(): Uri
    {
        return new Uri(self::VALID_URL);
    }

    /** @return array<string, array<int, ServerRequestInterface>> */
    public static function validGetRequest(): array
    {
        $request = new ServerRequest('GET', self::validUri());

        return [
            'valid.get.request' => [$request],
            'valid.get.request.with.param' => [$request->withQueryParams(['statusCode' => 1])],
            'valid.get.request.with.dummy.param' => [$request->withQueryParams(['dummy' => 1])]
        ];
    }

    /** @return array<string, array<int, ServerRequestInterface>> */
    public static function invalidGetRequest(): array
    {
        $request = new ServerRequest('GET', self::validUri());

        return [
            'empty.route.request' => [$request->withUri(self::validUri()->withPath(''))],
            'invalid.route.request' => [$request->withUri(self::validUri()->withPath('/invalid'))],
            'invalid.method' => [$request->withMethod('INVALID')],
            'invalid.params' => [$request->withQueryParams(['statusCode' => 'invalid'])]
        ];
    }

}
