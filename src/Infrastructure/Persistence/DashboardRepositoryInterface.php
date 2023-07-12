<?php

declare(strict_types=1);

namespace LogAggregator\Infrastructure\Persistence;

use LogAggregator\Application\DTO\CounterFilterDTO;
use LogAggregator\Domain\Dashboard;

interface DashboardRepositoryInterface
{
    public function countRequestLogs(CounterFilterDTO $counterFilterDTO): Dashboard;
}
