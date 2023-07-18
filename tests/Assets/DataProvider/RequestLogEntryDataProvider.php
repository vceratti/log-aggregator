<?php

declare(strict_types=1);

namespace Tests\Assets\DataProvider;

use LogAggregator\Application\Message\InvalidMessageException;
use LogAggregator\Application\Message\RequestLogEntry;

class RequestLogEntryDataProvider
{
    /** @return array<string, array<int, int|string>> */
    public static function validLogEntries(): array
    {
        return [
            'valid.request.log' => ['USER-SERVICE', '17/Aug/2018:09:21:53 +0000', 'POST /users HTTP/1.1', 201],
            'valid.request.log1' => ['INVOICE-SERVICE', '17/Aug/2018:09:21:55 +0000', 'POST /invoices HTTP/1.1', 201],
            'valid.request.log2' => ['USER-SERVICE', '17/Aug/2018:09:23:54 +0000', 'POST /users HTTP/1.1', 400]
        ];
    }

    /** @return array<string, array<int, int|string>> */
    public static function invalidLogDateFormatEntries(): array
    {
        return [
            'invalid.request.date.format' => ['USER-SERVICE', '17/08/18:09:21:53 +0000', 'POST /users HTTP/1.1', 201]
        ];
    }

    /** @return array<string, array<int, string|array<int, RequestLogEntry>>>
     * @throws InvalidMessageException
     */
    public static function validLogString(): array
    {
        $fileString = '';
        $requestLogs = [];
        foreach (static::validLogEntries() as $data) {
            $logString = static::makeLogString($data);
            $requestLogs[] = new RequestLogEntry($logString);
            $fileString .= $logString . PHP_EOL;
        }

        return ['valid.log.string' => [$fileString, $requestLogs]];
    }

    /** @param array<int, int|string> $data */
    public static function makeLogString(array $data): string
    {
        return "$data[0] - - [$data[1]] \"$data[2]\" $data[3]";
    }

    /**
     * @return  array<string, array<int, RequestLogEntry|string>>
     * @throws InvalidMessageException
     */
    public static function validMessages(): array
    {
        $messages = [];
        foreach (static::validLogEntries() as $name => $data) {
            $string = static::makeLogString($data);
            $messages[$name] = [new RequestLogEntry(static::makeLogString($data)), $string];
        }

        return $messages;
    }

    /**
     * @return  array<string, array<int, RequestLogEntry|string>>
     * @throws InvalidMessageException
     */
    public static function invalidMessages(): array
    {
        $messages = [];
        foreach (static::invalidLogDateFormatEntries() as $name => $data) {
            $string = static::makeLogString($data);
            $messages[$name] = [new RequestLogEntry(static::makeLogString($data))];
        }

        return $messages;
    }
}
