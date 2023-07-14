<?php

/** @noinspection PhpMultipleClassDeclarationsInspection */

declare(strict_types=1);

namespace LogAggregator\Infrastructure\Persistence\Database\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use LogAggregator\Application\Message\Request\DashboardFilterRequest;
use LogAggregator\Domain\Dashboard;
use LogAggregator\Domain\RequestLog;
use LogAggregator\Infrastructure\Persistence\DashboardRepositoryInterface;

/** @extends ServiceEntityRepository<Dashboard> */
class DashboardRepository extends ServiceEntityRepository implements DashboardRepositoryInterface
{
    public const ALIAS = 'r';

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RequestLog::class);
    }

    /** @throws NonUniqueResultException|NoResultException */
    public function countRequestLogs(DashboardFilterRequest $filter): Dashboard
    {
        $alias = self::ALIAS;
        $entity = Dashboard::class;

        $select = "NEW $entity(count($alias))";
        $query = $this->getEntityManager()->createQueryBuilder()
            ->select($select)
            ->from(RequestLog::class, $alias);

        $query = $this->addWhere($query, $filter);

        /** @var Dashboard $result */
        $result = $query->getQuery()->getSingleResult();

        return $result;
    }

    private function addWhere(QueryBuilder $query, DashboardFilterRequest $dashboardFilterDTO): QueryBuilder
    {
        if (count((array)$dashboardFilterDTO->getServiceNames()) > 0) {
            $query->andWhere($query->expr()->in(self::ALIAS . '.serviceName', ':serviceNames'))
                ->setParameter(':serviceNames', $dashboardFilterDTO->getServiceNames());
        }

        if($dashboardFilterDTO->getStatusCode()) {
            $query->andWhere($query->expr()->eq(self::ALIAS . '.statusCode', ':statusCode'))
                ->setParameter(':statusCode', $dashboardFilterDTO->getStatusCode());
        }

        if($dashboardFilterDTO->getStartDate()) {
            $query->andWhere($query->expr()->gte(self::ALIAS . '.dateTime', ':startDate'))
                ->setParameter(':startDate', $dashboardFilterDTO->getStartDate());
        }

        if($dashboardFilterDTO->getEndDate()) {
            $query->andWhere($query->expr()->lte(self::ALIAS . '.dateTime', ':endDate'))
                ->setParameter(':endDate', $dashboardFilterDTO->getEndDate());
        }

        return $query;
    }
}
