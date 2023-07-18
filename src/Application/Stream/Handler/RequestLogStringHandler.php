<?php

declare(strict_types=1);

namespace LogAggregator\Application\Stream\Handler;

use LogAggregator\Application\Message\InvalidMessageException;
use LogAggregator\Application\Message\Queue\Factory\QueueMessageFactory;
use LogAggregator\Application\Message\Queue\RequestLogEntry;
use Symfony\Component\Messenger\MessageBusInterface;

class RequestLogStringHandler implements FileContentsHandlerInterface
{
    private MessageBusInterface $messageBus;
    private QueueMessageFactory $messageFactory;

    public function __construct(MessageBusInterface $messageBus, QueueMessageFactory $messageFactory)
    {
        $this->messageFactory = $messageFactory;
        $this->messageBus = $messageBus;
    }

    /** @throws InvalidMessageException */
    public function handle(string $line): void
    {
        if(!empty($line)) {
            $requestLog = $this->messageFactory->makeMessageFromString(RequestLogEntry::class, $line);
            $this->messageBus->dispatch($requestLog);
        }
    }
}
