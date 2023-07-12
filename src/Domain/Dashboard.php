<?php

declare(strict_types=1);

namespace LogAggregator\Domain;

use JsonSerializable;

class Dashboard implements JsonSerializable
{
    private int $count;

    public function __construct(int $count)
    {
        $this->count = $count;
    }

    public function getCount(): int
    {
        return $this->count;
    }

    /** @return array<string, mixed> */
    public function jsonSerialize(): array
    {
        return [
            'count' => $this->count
        ];
    }
}
