<?php

/** @noinspection PhpMultipleClassDeclarationsInspection */

declare(strict_types=1);

namespace LogAggregator\Infrastructure\Persistence\Database\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use LogAggregator\Domain\RequestLog;
use LogAggregator\Infrastructure\Persistence\RequestLogRepositoryInterface;

/** @extends ServiceEntityRepository<RequestLog> */
class RequestLogRepository extends ServiceEntityRepository implements RequestLogRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RequestLog::class);
    }

    public function save(RequestLog $request): void
    {
        $this->getEntityManager()->persist($request);
        $this->getEntityManager()->flush();
    }
}
