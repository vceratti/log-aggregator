<?php

declare(strict_types=1);

namespace LogAggregator\Infrastructure\Persistence\Database\Repository;

use LogAggregator\Application\DTO\CounterFilterDTO;
use LogAggregator\Domain\Counter;
use LogAggregator\Infrastructure\Persistence\CounterRepository as CounterRepositoryInterface;

class CounterRepository implements CounterRepositoryInterface
{
    public function countRequestLogs(CounterFilterDTO $counterFilterDTO): Counter
    {
        return new Counter(0);
    }
}
