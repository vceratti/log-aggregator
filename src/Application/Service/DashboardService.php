<?php

declare(strict_types=1);

namespace LogAggregator\Application\Service;

use LogAggregator\Application\DTO\CounterFilterDTO;
use LogAggregator\Domain\Dashboard;
use LogAggregator\Infrastructure\Persistence\DashboardRepositoryInterface;

class DashboardService
{
    private DashboardRepositoryInterface $counterRepository;

    public function __construct(DashboardRepositoryInterface $counterRepository)
    {
        $this->counterRepository = $counterRepository;
    }

    public function count(CounterFilterDTO $counterFilterDTO): Dashboard
    {
        return $this->counterRepository->countRequestLogs($counterFilterDTO);
    }
}
