<?php

declare(strict_types=1);

namespace Tests\Unit\Domain;

use DateTime;
use LogAggregator\Domain\RequestLog;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(RequestLog::class)]
class RequestLogTest extends TestCase
{
    public function testEntity(): void
    {
        $entity = new RequestLog('service', 1, '', new Datetime());
        $this->assertInstanceOf(RequestLog::class, $entity);
    }
}
