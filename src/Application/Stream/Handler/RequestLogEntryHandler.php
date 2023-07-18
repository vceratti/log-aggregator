<?php

declare(strict_types=1);

namespace LogAggregator\Application\Stream\Handler;

use LogAggregator\Application\Message\Factory\MessageFactory;
use LogAggregator\Application\Message\InvalidMessageException;
use LogAggregator\Application\Message\RequestLogEntry;
use LogAggregator\Application\Service\StoreRequestLogService;

class RequestLogEntryHandler implements FileContentsHandlerInterface
{
    private MessageFactory $messageFactory;
    private StoreRequestLogService $storeRequestLogService;

    public function __construct(StoreRequestLogService $storeRequestLogService, MessageFactory $messageFactory)
    {
        $this->messageFactory = $messageFactory;
        $this->storeRequestLogService = $storeRequestLogService;
    }

    /** @throws InvalidMessageException */
    public function handle(string $line): void
    {
        if(!empty($line)) {
            $requestLog = $this->messageFactory->makeMessageFromString(RequestLogEntry::class, $line);
            $this->storeRequestLogService->insert($requestLog);
        }

    }
}
