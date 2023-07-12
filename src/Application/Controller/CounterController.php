<?php

declare(strict_types=1);

namespace LogAggregator\Application\Controller;

use LogAggregator\Application\DTO\CounterFilterDTO;
use LogAggregator\Application\Service\DashboardService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CounterController extends AbstractController
{
    private DashboardService $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    #[Route('/count', methods: ['GET'])]
    public function count(): Response
    {
        $result = $this->dashboardService->count(new CounterFilterDTO());

        return $this->json($result);
    }
}
