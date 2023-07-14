<?php

declare(strict_types=1);

namespace LogAggregator\Application\Service;

use LogAggregator\Application\Factory\RequestLogFactory;
use LogAggregator\Application\Message\Request\RequestLogRequest;
use LogAggregator\Infrastructure\Persistence\Database\Repository\RequestLogRepository;

class StoreRequestLogService
{
    private RequestLogFactory $entityFactory;
    private RequestLogRepository $requestLogRepository;

    public function __construct(RequestLogRepository $requestLogRepository, RequestLogFactory $entityFactory)
    {
        $this->requestLogRepository = $requestLogRepository;
        $this->entityFactory = $entityFactory;
    }

    public function insert(RequestLogRequest $requestLogDTO): void
    {
        $requestLog = $this->entityFactory->createEntity($requestLogDTO);
        $this->requestLogRepository->save($requestLog);
    }
}
