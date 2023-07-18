<?php

declare(strict_types=1);

namespace LogAggregator\Infrastructure\Persistence;

use LogAggregator\Application\Message\Request\DashboardFilterRequest;
use LogAggregator\Domain\ValueObject\Counter;

interface DashboardRepositoryInterface
{
    public function countRequestLogs(DashboardFilterRequest $filter): Counter;
}
