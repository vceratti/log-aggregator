<?php

declare(strict_types=1);

namespace LogAggregator\Domain;

use JsonSerializable;

class Counter implements JsonSerializable
{
    private int $count;

    public function __construct(int $count)
    {
        $this->count = $count;
    }

    /** @return array<string, mixed> */
    public function jsonSerialize(): array
    {
        return [
            'count' => $this->count
        ];
    }
}
