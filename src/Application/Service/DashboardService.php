<?php

declare(strict_types=1);

namespace LogAggregator\Application\Service;

use LogAggregator\Application\DTO\CounterFilterDTO;
use LogAggregator\Domain\Counter;
use LogAggregator\Infrastructure\Persistence\CounterRepository;

class DashboardService
{
    private CounterRepository $counterRepository;

    public function __construct(CounterRepository $counterRepository)
    {
        $this->counterRepository = $counterRepository;
    }

    public function count(CounterFilterDTO $counterFilterDTO): Counter
    {
        return $this->counterRepository->countRequestLogs($counterFilterDTO);
    }
}
