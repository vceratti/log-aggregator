<?php

declare(strict_types=1);

namespace Tests\Functional\Application\Controller;

use League\OpenAPIValidation\PSR7\Exception\ValidationFailed;
use LogAggregator\Application\Controller\DashboardController;
use LogAggregator\Domain\Dashboard;
use PHPUnit\Framework\Attributes\CoversClass;
use Tests\Assets\TestCase\RequestTestCase;

#[CoversClass(DashboardController::class)]
class DashboardControllerTest extends RequestTestCase
{
    /** @throws ValidationFailed */
    public function testRequest(): void
    {
        $this->client->request('GET', '/count', ['statusCode' => 1]);

        $expectedResult = new Dashboard(0);

        $this->assertsSuccessfulResponse($expectedResult);
    }

}
