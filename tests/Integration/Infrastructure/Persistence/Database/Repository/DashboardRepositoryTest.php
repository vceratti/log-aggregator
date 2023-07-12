<?php

declare(strict_types=1);

namespace Tests\Integration\Infrastructure\Persistence\Database\Repository;

use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Exception;
use LogAggregator\Application\DTO\CounterFilterDTO;
use LogAggregator\Domain\Dashboard;
use LogAggregator\Infrastructure\Persistence\Database\Repository\DashboardRepository;
use PHPUnit\Framework\Attributes\CoversClass;
use Tests\Assets\Generator\RequestLogProvider;
use Tests\Assets\TestCase\ApplicationTestCase;

#[CoversClass(DashboardRepository::class)]
#[CoversClass(Dashboard::class)]
class DashboardRepositoryTest extends ApplicationTestCase
{
    private DashboardRepository $repository;

    /** @throws Exception */
    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = self::getFromContainer(DashboardRepository::class);
    }

    /** @throws NonUniqueResultException|NoResultException */
    public function testCountRequestLogs(): void
    {
        $expectedCount = 10;
        $this->persistEntities(RequestLogProvider::validEntityCollection($expectedCount));

        $count = $this->repository->countRequestLogs(new CounterFilterDTO());

        $this->assertSame($expectedCount, $count->getCount());
    }
}
