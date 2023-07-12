<?php

declare(strict_types=1);

namespace Tests\Assets\TestCase;

use JsonSerializable;

class RequestTestCase extends ApplicationTestCase
{
    protected function assertsSuccessfulResponse(JsonSerializable $expectedData): void
    {
        $responseData = json_decode((string)$this->client->getResponse()->getContent(), true);

        $this->assertSame($responseData, $expectedData->jsonSerialize());
    }
}
