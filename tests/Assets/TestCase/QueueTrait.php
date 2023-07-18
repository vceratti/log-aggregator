<?php

declare(strict_types=1);

namespace Tests\Assets\TestCase;

use Generator;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Transport\TransportInterface;

trait QueueTrait
{
    private TransportInterface $transport;

    protected function transport(): TransportInterface
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        return self::getContainer()->get('messenger.transport.log.queue');
    }

    private function resetQueues(): void
    {
        self::getAllMessages();
    }

    /** @return array<int, Envelope> */
    protected function getAllMessages(): array
    {
        $messages = [];
        while ($message = $this->getMessage()) {
            $messages[] = $message;
            self::transport()->ack($message);
        }

        return $messages;
    }

    public function getMessage(): ?Envelope
    {
        /** @var Generator $generator */
        $generator = self::transport()->get();

        /** @var Envelope $envelope */
        $envelope = $generator->current();

        return $envelope;
    }
}
