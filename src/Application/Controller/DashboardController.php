<?php

declare(strict_types=1);

namespace LogAggregator\Application\Controller;

use LogAggregator\Application\Controller\Factory\RequestMessageFactory;
use LogAggregator\Application\Message\InvalidMessageException;
use LogAggregator\Application\Message\Request\DashboardFilterRequest;
use LogAggregator\Application\Service\DashboardService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    private DashboardService $dashboardService;
    private RequestMessageFactory $messageFactory;

    public function __construct(DashboardService $dashboardService, RequestMessageFactory $messageFactory)
    {
        $this->dashboardService = $dashboardService;
        $this->messageFactory = $messageFactory;
    }

    /** @throws InvalidMessageException */
    #[Route('/count', methods: ['GET'])]
    public function count(Request $request): Response
    {
        $dashboardFilter = $this->messageFactory->makeMessage(DashboardFilterRequest::class, $request);
        $result = $this->dashboardService->count($dashboardFilter);

        return $this->json($result);
    }

}
