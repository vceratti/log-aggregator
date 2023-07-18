<?php

declare(strict_types=1);

namespace Tests\Integration\Application\Message\Request;

use Exception;
use LogAggregator\Application\Message\Factory\MessageFactory;
use LogAggregator\Application\Message\InvalidMessageException;
use LogAggregator\Application\Message\RequestLogEntry;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use Psr\Http\Message\ServerRequestInterface;
use Tests\Assets\DataProvider\PsrRequestDataProvider;
use Tests\Assets\DataProvider\RequestLogEntryDataProvider;
use Tests\Assets\Stub\StubMessage;
use Tests\Assets\TestCase\ApplicationTestCase;

#[CoversClass(MessageFactory::class)]
class MessageFactoryTest extends ApplicationTestCase
{
    private MessageFactory $factory;

    /** @throws Exception */
    protected function setUp(): void
    {
        parent::setUp();
        $this->factory = $this->getFromContainer(MessageFactory::class);
    }

    /** @throws InvalidMessageException */
    #[DataProviderExternal(PsrRequestDataProvider::class, 'validGetRequest')]
    public function testFactoryFromValidRequest(ServerRequestInterface $request): void
    {
        $message = $this->factory->makeMessageFromRequest(StubMessage::class, $request);
        $this->assertInstanceOf(StubMessage::class, $message);
    }

    /** @throws InvalidMessageException */
    #[DataProviderExternal(PsrRequestDataProvider::class, 'invalidGetRequest')]
    public function testExceptionOnInvalidRequest(ServerRequestInterface $request): void
    {
        $this->expectException(InvalidMessageException::class);
        $this->factory->makeMessageFromRequest(StubMessage::class, $request);
    }

    /** @throws InvalidMessageException */
    #[DataProviderExternal(RequestLogEntryDataProvider::class, 'validMessages')]
    public function testMakeMessageFromString(RequestLogEntry $requestLogEntry, string $inputString): void
    {
        $message = $this->factory->makeMessageFromString(RequestLogEntry::class, $inputString);
        $this->assertInstanceOf(RequestLogEntry::class, $message);
    }

    /** @throws InvalidMessageException */
    public function testExceptionOnInvalidString(): void
    {
        $this->expectException(InvalidMessageException::class);
        $this->factory->makeMessageFromString(RequestLogEntry::class, 'invalid');
    }
}
