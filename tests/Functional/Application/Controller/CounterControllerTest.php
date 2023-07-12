<?php

declare(strict_types=1);

namespace Tests\Functional\Application\Controller;

use LogAggregator\Application\Controller\CounterController;
use LogAggregator\Domain\Counter;
use PHPUnit\Framework\Attributes\CoversClass;
use Tests\Assets\TestCase\RequestTestCase;

#[CoversClass(CounterController::class)]
class CounterControllerTest extends RequestTestCase
{
    public function testRequest(): void
    {
        $this->client->request('GET', '/count');

        $expectedResult = new Counter(1);

        $this->assertsSuccessfulResponse($expectedResult);
    }

}
