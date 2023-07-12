<?php

/** @noinspection PhpMultipleClassDeclarationsInspection */

declare(strict_types=1);

namespace LogAggregator\Infrastructure\Persistence\Database\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;
use LogAggregator\Application\DTO\CounterFilterDTO;
use LogAggregator\Domain\Dashboard;
use LogAggregator\Domain\RequestLog;
use LogAggregator\Infrastructure\Persistence\DashboardRepositoryInterface;

/** @extends ServiceEntityRepository<Dashboard> */
class DashboardRepository extends ServiceEntityRepository implements DashboardRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RequestLog::class);
    }

    /** @throws NonUniqueResultException|NoResultException */
    public function countRequestLogs(CounterFilterDTO $counterFilterDTO): Dashboard
    {
        /** @var Dashboard $result */
        $result = $this->getEntityManager()->createQueryBuilder()
            ->select('NEW ' . Dashboard::class . '(count(a))')
            ->from(RequestLog::class, 'a')
            ->getQuery()
            ->getSingleResult();

        return $result;
    }
}
