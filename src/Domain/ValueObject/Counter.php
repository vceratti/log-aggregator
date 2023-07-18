<?php

declare(strict_types=1);

namespace LogAggregator\Domain\ValueObject;

use JsonSerializable;

class Counter implements JsonSerializable
{
    private int $counter;

    public function __construct(int $count)
    {
        $this->counter = $count;
    }

    /** @return array<string, mixed> */
    public function jsonSerialize(): array
    {
        return [
            'counter' => $this->counter
        ];
    }
}
