<?php

declare(strict_types=1);

namespace Tests\Integration\Application\Service;

use Exception;
use LogAggregator\Application\Message\InvalidMessageException;
use LogAggregator\Application\Message\RequestLogEntry;
use LogAggregator\Application\Service\StoreRequestLogService;
use LogAggregator\Domain\RequestLog;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use Tests\Assets\Assert\LogRequestAssert;
use Tests\Assets\DataProvider\RequestLogEntryDataProvider;
use Tests\Assets\TestCase\ApplicationTestCase;

#[CoversClass(StoreRequestLogService::class)]
class StoreRequestLogServiceTest extends ApplicationTestCase
{
    private StoreRequestLogService $service;

    /** @throws Exception */
    protected function setUp(): void
    {
        parent::setUp();
        $this->service = $this->getFromContainer(StoreRequestLogService::class);
    }

    /** @throws InvalidMessageException */
    #[DataProviderExternal(RequestLogEntryDataProvider::class, 'validMessages')]
    public function testInsertLogRequest(RequestLogEntry $requestLogEntry): void
    {
        $this->service->insert($requestLogEntry);

        $entities = $this->getEntities(RequestLog::class);
        $this->assertCount(1, $entities);

        LogRequestAssert::assertEntityMatchesMessage($requestLogEntry, $entities[0]);
    }

}
