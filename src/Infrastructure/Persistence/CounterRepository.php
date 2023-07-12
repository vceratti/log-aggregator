<?php

declare(strict_types=1);

namespace LogAggregator\Infrastructure\Persistence;

use LogAggregator\Application\DTO\CounterFilterDTO;
use LogAggregator\Domain\Counter;

interface CounterRepository
{
    public function countRequestLogs(CounterFilterDTO $counterFilterDTO): Counter;
}
