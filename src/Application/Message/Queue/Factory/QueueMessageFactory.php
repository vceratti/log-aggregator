<?php

declare(strict_types=1);

namespace LogAggregator\Application\Message\Queue\Factory;

use LogAggregator\Application\Message\InvalidMessageException;
use Throwable;

class QueueMessageFactory
{
    /**
     * @template T
     * @param class-string<T> $messageClass
     * @return T
     * @throws InvalidMessageException
     */
    public function makeMessageFromString(string $messageClass, string $string)
    {
        try {
            return new $messageClass($string);
        } catch (Throwable $exception) {
            throw new InvalidMessageException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }
}
