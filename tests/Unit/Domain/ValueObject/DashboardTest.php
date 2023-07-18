<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\ValueObject;

use LogAggregator\Domain\ValueObject\Counter;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Counter::class)]
class DashboardTest extends TestCase
{
    public function testEntity(): void
    {
        $entity = new Counter(1);

        $this->assertInstanceOf(Counter::class, $entity);
    }

    public function testJsonSerialization(): void
    {
        $entity = new Counter(1);

        $this->assertSame('{"counter":1}', json_encode($entity));
    }
}
