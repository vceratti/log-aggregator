<?php

declare(strict_types=1);

namespace Tests\Integration\Application\Message\Request\Factory;

use Exception;
use LogAggregator\Application\Message\InvalidMessageException;
use LogAggregator\Application\Message\Request\Factory\RequestMessageFactory;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use Symfony\Component\HttpFoundation\Request;
use Tests\Assets\DataProvider\SymfonyRequestDataProvider;
use Tests\Assets\Stub\StubMessage;
use Tests\Assets\TestCase\ApplicationTestCase;

#[CoversClass(RequestMessageFactory::class)]
class RequestMessageFactoryTest extends ApplicationTestCase
{
    private RequestMessageFactory $factory;

    /** @throws Exception */
    protected function setUp(): void
    {
        parent::setUp();
        $this->factory = $this->getFromContainer(RequestMessageFactory::class);
    }

    /** @throws InvalidMessageException */
    #[DataProviderExternal(SymfonyRequestDataProvider::class, 'validGetRequest')]
    public function testFactoryFromValidRequest(Request $request): void
    {
        $message = $this->factory->makeMessageFromRequest(StubMessage::class, $request);
        $this->assertInstanceOf(StubMessage::class, $message);
    }

    /** @throws InvalidMessageException */
    #[DataProviderExternal(SymfonyRequestDataProvider::class, 'invalidGetRequest')]
    public function testExceptionOnInvalidRequest(Request $request): void
    {
        $this->expectException(InvalidMessageException::class);
        $this->factory->makeMessageFromRequest(StubMessage::class, $request);
    }
}
