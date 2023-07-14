<?php

declare(strict_types=1);

namespace Tests\Integration\Infrastructure\Persistence\Database\Repository;

use DateInterval;
use DateTime;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Exception;
use LogAggregator\Application\Message\Request\DashboardFilterRequest;
use LogAggregator\Domain\Dashboard;
use LogAggregator\Domain\RequestLog;
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

        $count = $this->repository->countRequestLogs(new DashboardFilterRequest([]));

        $this->assertSame($expectedCount, $count->jsonSerialize()['counter']);
    }

    /** @throws NonUniqueResultException|NoResultException */
    public function testFilterByStatusCode(): void
    {
        $this->persistEntities(RequestLogProvider::validEntityCollection(10));

        $this->persistEntities(new RequestLog('', 200, '', new DateTime()));
        $this->persistEntities(new RequestLog('', 200, '', new DateTime()));

        $count = $this->repository->countRequestLogs(new DashboardFilterRequest(['statusCode' => '200']));

        $this->assertSame(2, $count->jsonSerialize()['counter']);
    }

    /** @throws NonUniqueResultException|NoResultException */
    public function testFilterByServiceName(): void
    {
        $this->persistEntities(RequestLogProvider::validEntityCollection(10));

        $this->persistEntities(new RequestLog('INCLUDED_SERVICE_1', 200, '', new DateTime()));
        $this->persistEntities(new RequestLog('INCLUDED_SERVICE_2', 200, '', new DateTime()));
        $this->persistEntities(new RequestLog('FILTERED_OUT_SERVICE', 200, '', new DateTime()));

        $count = $this->repository->countRequestLogs(new DashboardFilterRequest([
            'serviceNames' => ['INCLUDED_SERVICE_1', 'INCLUDED_SERVICE_2']
        ]));

        $this->assertSame(2, $count->jsonSerialize()['counter']);
    }

    /** @throws NonUniqueResultException|NoResultException */
    public function testFilterByDate(): void
    {
        $this->persistEntities(RequestLogProvider::validEntityCollection(10));

        $oneDay = DateInterval::createFromDateString('1 day');
        $this->persistEntities([
            new RequestLog('', 200, '', (new DateTime())->add($oneDay)),
            new RequestLog('', 300, '', (new DateTime())->add($oneDay)->add($oneDay))
        ]);

        $startDate = (new DateTime())->add(DateInterval::createFromDateString('1 hour'));

        $count = $this->repository->countRequestLogs(new DashboardFilterRequest([
            'startDate' => $startDate->format(DATE_ATOM)
        ]));

        $this->assertSame(2, $count->jsonSerialize()['counter']);

        $endDate = (new DateTime())->add($oneDay)->add($oneDay)->sub(DateInterval::createFromDateString('1 hour'));

        $count = $this->repository->countRequestLogs(new DashboardFilterRequest([
            'endDate' => $endDate->format(DATE_ATOM)
        ]));

        $this->assertSame(11, $count->jsonSerialize()['counter']);

        $filter = new DashboardFilterRequest([
            'startDate' => $startDate->format(DATE_ATOM),
            'endDate' => $endDate->format(DATE_ATOM)
        ]);

        $count = $this->repository->countRequestLogs($filter);

        $this->assertSame(1, $count->jsonSerialize()['counter']);
    }
}
