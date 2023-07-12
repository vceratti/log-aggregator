<?php

declare(strict_types=1);

namespace Tests\Functional\Application\Kernel;

use LogAggregator\Application\Symfony\Kernel;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use Psr\Log\NullLogger;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

#[CoversClass(Kernel::class)]
class KernelTest extends WebTestCase
{
    private KernelBrowser $client;

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = self::createClient();
    }

    /** @throws \Exception */
    #[DataProvider('invalidRequestProvider')]
    public function testHandleInvalidRequest(string $route, int $expectedResponseCode): void
    {
        self::getContainer()->set('logger', new NullLogger());

        $this->client->request('GET', $route);
        $this->assertResponseStatusCodeSame($expectedResponseCode);
    }

    /** @return array<string, array<string|int>> */
    public static function invalidRequestProvider(): array
    {
        return [
            'empty.request' => ['/', Response::HTTP_NOT_FOUND]
        ];
    }
}
