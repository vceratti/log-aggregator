<?php

/** @noinspection PhpMultipleClassDeclarationsInspection */

declare(strict_types=1);

namespace LogAggregator\Infrastructure\Persistence\Database\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use LogAggregator\Application\Message\DashboardFilterRequest;
use LogAggregator\Domain\RequestLog;
use LogAggregator\Domain\ValueObject\Counter;
use LogAggregator\Infrastructure\Persistence\DashboardRepositoryInterface;

/** @extends ServiceEntityRepository<Counter> */
class DashboardRepository extends ServiceEntityRepository implements DashboardRepositoryInterface
{
    public const ALIAS = 'r';

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RequestLog::class);
    }

    /** @throws NonUniqueResultException|NoResultException */
    public function countRequestLogs(DashboardFilterRequest $filter): Counter
    {
        $alias = self::ALIAS;
        $entity = Counter::class;

        $select = "NEW $entity(count($alias))";
        $query = $this->getEntityManager()->createQueryBuilder()
            ->select($select)
            ->from(RequestLog::class, $alias);

        $query = $this->addWhere($query, $filter);

        /** @var Counter $result */
        $result = $query->getQuery()->getSingleResult();

        return $result;
    }

    private function addWhere(QueryBuilder $query, DashboardFilterRequest $dashboardFilterRequest): QueryBuilder
    {
        if (count((array)$dashboardFilterRequest->getServiceNames()) > 0) {
            $query->andWhere($query->expr()->in(self::ALIAS . '.serviceName', ':serviceNames'))
                ->setParameter(':serviceNames', $dashboardFilterRequest->getServiceNames());
        }

        if($dashboardFilterRequest->getStatusCode()) {
            $query->andWhere($query->expr()->eq(self::ALIAS . '.statusCode', ':statusCode'))
                ->setParameter(':statusCode', $dashboardFilterRequest->getStatusCode());
        }

        if($dashboardFilterRequest->getStartDate()) {
            $query->andWhere($query->expr()->gte(self::ALIAS . '.dateTime', ':startDate'))
                ->setParameter(':startDate', $dashboardFilterRequest->getStartDate());
        }

        if($dashboardFilterRequest->getEndDate()) {
            $query->andWhere($query->expr()->lte(self::ALIAS . '.dateTime', ':endDate'))
                ->setParameter(':endDate', $dashboardFilterRequest->getEndDate());
        }

        return $query;
    }
}
