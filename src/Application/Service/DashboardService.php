<?php

declare(strict_types=1);

namespace LogAggregator\Application\Service;

use LogAggregator\Application\Message\Request\DashboardFilterRequest;
use LogAggregator\Domain\Dashboard;
use LogAggregator\Infrastructure\Persistence\DashboardRepositoryInterface;

class DashboardService
{
    private DashboardRepositoryInterface $dashboardRepository;

    public function __construct(DashboardRepositoryInterface $dashboardRepository)
    {
        $this->dashboardRepository = $dashboardRepository;
    }

    public function count(DashboardFilterRequest $dashboardFilterDTO): Dashboard
    {
        return $this->dashboardRepository->countRequestLogs($dashboardFilterDTO);
    }
}
