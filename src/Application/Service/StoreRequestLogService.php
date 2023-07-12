<?php

declare(strict_types=1);

namespace LogAggregator\Application\Service;

use LogAggregator\Application\DTO\RequestLogDTO;
use LogAggregator\Application\Factory\RequestLogFactory;
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

    public function insert(RequestLogDTO $requestLogDTO): void
    {
        $requestLog = $this->entityFactory->createEntity($requestLogDTO);
        $this->requestLogRepository->save($requestLog);
    }
}
