<?php

declare(strict_types=1);

namespace LogAggregator\Application\Messenger;

use LogAggregator\Application\Message\InvalidMessageException;
use LogAggregator\Application\Message\Queue\RequestLogEntry;
use LogAggregator\Application\Messenger\Factory\RequestLogFactory;
use LogAggregator\Infrastructure\Persistence\RequestLogRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class RequestLogEntryMessageHandler
{
    private RequestLogFactory $entityFactory;
    private RequestLogRepositoryInterface $requestLogRepository;

    public function __construct(RequestLogRepositoryInterface $requestLogRepository, RequestLogFactory $entityFactory)
    {
        $this->requestLogRepository = $requestLogRepository;
        $this->entityFactory = $entityFactory;
    }

    /** @throws InvalidMessageException */
    public function __invoke(RequestLogEntry $requestLogEntry): void
    {
        $requestLog = $this->entityFactory->createEntity($requestLogEntry);
        $this->requestLogRepository->save($requestLog);
    }
}
