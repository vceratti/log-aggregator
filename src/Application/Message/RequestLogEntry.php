<?php

declare(strict_types=1);

namespace LogAggregator\Application\Message;

use Throwable;

/** @template-implements MessageInterface<RequestLogEntry> */
class RequestLogEntry implements MessageInterface
{
    public const LOG_DATE_FORMAT = 'd/M/Y:H:i:s O';
    private string $serviceName;
    private string $query;
    private int $statusCode;
    private string $dateTime;

    // "USER-SERVICE - - [18/Aug/2018:10:33:59 +0000] "POST /users HTTP/1.1" 201";

    /** @throws InvalidMessageException */
    public function __construct(string $logEntry)
    {
        try {
            $data = $this->parseInput($logEntry);
            $this->serviceName = $data['serviceName'];
            $this->query = $data['query'];
            $this->statusCode = (int)$data['statusCode'];
            $this->dateTime = $data['dateTime'];
        } catch (Throwable $throwable) {
            $message = "Cannot build Message from Input: $logEntry";
            throw new InvalidMessageException($message, $throwable->getCode(), $throwable);
        }

    }

    /** @return string[] */
    private function parseInput(string $input): array
    {
        $matches = [];

        $serviceName = '(?P<serviceName>[\w|\-]+)';
        $dateTime = '\[(?P<dateTime>.*\s[\+|\-]\d{4})\]';
        $query = '"(?P<query>\w+\s\/[\w|\-]+.+)"';
        $statusCode = '(?P<statusCode>\d{3})';

        $pattern = "$serviceName.*$dateTime.*$query.*$statusCode";

        $pattern = "/$pattern/s";

        preg_match($pattern, $input, $matches);

        return $matches;
    }

    public function getServiceName(): string
    {
        return $this->serviceName;
    }

    public function getQuery(): string
    {
        return $this->query;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getDateTime(): string
    {
        return $this->dateTime;
    }
}
