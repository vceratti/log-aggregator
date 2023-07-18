<?php

declare(strict_types=1);

namespace Tests\Unit\Application\Message;

use LogAggregator\Application\Message\DashboardFilterRequest;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use PHPUnit\Framework\TestCase;
use Tests\Assets\DataProvider\DashboardFilterDataProvider;

#[CoversClass(DashboardFilterRequest::class)]
class DashboardFilterRequestTest extends TestCase
{
    /** @param string[] $serviceNames */
    #[DataProviderExternal(DashboardFilterDataProvider::class, 'validData')]
    public function testMessageFromRequest(
        ?array  $serviceNames,
        ?string $startDate,
        ?string $endDate,
        ?string $statusCode
    ): void {
        $message = new DashboardFilterRequest([
            'serviceNames' => $serviceNames,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'statusCode' => $statusCode
        ]);

        $this->assertSame($serviceNames, $message->getServiceNames());
        $this->assertSame($startDate, $message->getStartDate());
        $this->assertSame($endDate, $message->getEndDate());
        $this->assertSame($statusCode, $message->getStatusCode());
    }
}
