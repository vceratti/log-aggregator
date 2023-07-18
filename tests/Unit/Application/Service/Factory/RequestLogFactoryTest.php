<?php

declare(strict_types=1);

namespace Tests\Unit\Application\Service\Factory;

use LogAggregator\Application\Message\InvalidMessageException;
use LogAggregator\Application\Message\Queue\RequestLogEntry;
use LogAggregator\Application\Messenger\Factory\RequestLogFactory;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use PHPUnit\Framework\TestCase;
use Tests\Assets\Assert\LogRequestAssert;
use Tests\Assets\DataProvider\RequestLogEntryDataProvider;

#[CoversClass(RequestLogFactory::class)]
class RequestLogFactoryTest extends TestCase
{
    /** @throws InvalidMessageException */
    #[DataProviderExternal(RequestLogEntryDataProvider::class, 'validMessages')]
    public function testCreateFromMessage(RequestLogEntry $requestLogEntry): void
    {
        $entity = (new RequestLogFactory())->createEntity($requestLogEntry);

        LogRequestAssert::assertEntityMatchesMessage($requestLogEntry, $entity);
    }

    /** @throws InvalidMessageException */
    #[DataProviderExternal(RequestLogEntryDataProvider::class, 'invalidMessages')]
    public function testExceptionOnInvalidDateFormat(RequestLogEntry $requestLogEntry): void
    {
        $this->expectException(InvalidMessageException::class);
        (new RequestLogFactory())->createEntity($requestLogEntry);
    }
}
