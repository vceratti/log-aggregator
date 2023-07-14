<?php

declare(strict_types=1);

namespace Tests\Integration\Application\Message\Request;

use Exception;
use LogAggregator\Application\Message\InvalidMessageException;
use LogAggregator\Application\Message\Request\Factory\MessageFactory;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use Psr\Http\Message\ServerRequestInterface;
use Tests\Assets\DataProvider\PsrRequest;
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
    #[DataProviderExternal(PsrRequest::class, 'validGetRequest')]
    public function testFactoryFromValidRequest(ServerRequestInterface $request): void
    {
        $dto = $this->factory->makeMessageFromRequest(StubMessage::class, $request);
        $this->assertInstanceOf(StubMessage::class, $dto);
    }

    /** @throws InvalidMessageException */
    #[DataProviderExternal(PsrRequest::class, 'invalidGetRequest')]
    public function testExceptionOnInvalidRequest(ServerRequestInterface $request): void
    {
        $this->expectException(InvalidMessageException::class);
        $dto = $this->factory->makeMessageFromRequest(StubMessage::class, $request);
        $this->assertInstanceOf(StubMessage::class, $dto);
    }
}
