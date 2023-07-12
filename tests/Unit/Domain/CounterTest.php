<?php

declare(strict_types=1);

namespace Tests\Unit\Domain;

use LogAggregator\Domain\Dashboard;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Dashboard::class)]
class CounterTest extends TestCase
{
    public function testEntity(): void
    {
        $entity = new Dashboard(1);

        $this->assertInstanceOf(Dashboard::class, $entity);
    }

    public function testJsonSerialization(): void
    {
        $entity = new Dashboard(1);

        $this->assertSame('{"count":1}', json_encode($entity));
    }
}
