<?php

declare(strict_types=1);

namespace LogAggregator\Application\Service;

use LogAggregator\Application\Message\InvalidMessageException;
use LogAggregator\Application\Message\RequestLogEntry;
use LogAggregator\Application\Service\Factory\RequestLogFactory;
use LogAggregator\Infrastructure\Persistence\RequestLogRepositoryInterface;

class StoreRequestLogService
{
    private RequestLogFactory $entityFactory;
    private RequestLogRepositoryInterface $requestLogRepository;

    public function __construct(RequestLogRepositoryInterface $requestLogRepository, RequestLogFactory $entityFactory)
    {
        $this->requestLogRepository = $requestLogRepository;
        $this->entityFactory = $entityFactory;
    }

    /** @throws InvalidMessageException */
    public function insert(RequestLogEntry $requestLogEntry): void
    {
        $requestLog = $this->entityFactory->createEntity($requestLogEntry);
        $this->requestLogRepository->save($requestLog);
    }
}
