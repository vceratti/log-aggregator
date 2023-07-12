<?php

declare(strict_types=1);

namespace Tests\Assets\TestCase;

use Exception;
use JsonSerializable;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RequestTestCase extends WebTestCase
{
    use DatabaseTransactionTrait;

    protected KernelBrowser $client;

    /** @throws Exception */
    protected function setUp(): void
    {
        parent::setUp();
        $this->client = self::createClient();
        $this->beingTransaction();
    }

    protected function assertsSuccessfulResponse(JsonSerializable $expectedData): void
    {
        $responseData = json_decode((string)$this->client->getResponse()->getContent(), true);

        $this->assertSame($responseData, $expectedData->jsonSerialize());
    }

    protected function tearDown(): void
    {
        $this->rollbackTransaction();
        parent::tearDown();
    }
}
