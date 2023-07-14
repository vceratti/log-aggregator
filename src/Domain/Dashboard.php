<?php

declare(strict_types=1);

namespace LogAggregator\Domain;

use JsonSerializable;

class Dashboard implements JsonSerializable
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
