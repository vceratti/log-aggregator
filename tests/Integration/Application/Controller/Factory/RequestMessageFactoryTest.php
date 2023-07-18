<?php

declare(strict_types=1);

namespace Tests\Integration\Application\Controller\Factory;

use Exception;
use LogAggregator\Application\Controller\Factory\RequestMessageFactory;
use LogAggregator\Application\Message\InvalidMessageException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use Symfony\Component\HttpFoundation\Request;
use Tests\Assets\DataProvider;
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
    #[DataProviderExternal(DataProvider\SymfonyRequestDataProvider::class, 'validGetRequest')]
    public function testMakeMessage(Request $request): void
    {
        $message = $this->factory->makeMessage(StubMessage::class, $request);
        $this->assertInstanceOf(StubMessage::class, $message);
    }
}
