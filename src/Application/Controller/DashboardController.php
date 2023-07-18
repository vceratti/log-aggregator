<?php

declare(strict_types=1);

namespace LogAggregator\Application\Controller;

use LogAggregator\Application\Controller\Factory\RequestMessageFactory;
use LogAggregator\Application\Message\DashboardFilterRequest;
use LogAggregator\Application\Message\InvalidMessageException;
use LogAggregator\Infrastructure\Persistence\DashboardRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    private DashboardRepositoryInterface $dashboardRepository;
    private RequestMessageFactory $messageFactory;

    public function __construct(DashboardRepositoryInterface $dashboardService, RequestMessageFactory $messageFactory)
    {
        $this->dashboardRepository = $dashboardService;
        $this->messageFactory = $messageFactory;
    }

    /** @throws InvalidMessageException */
    #[Route('/count', methods: ['GET'])]
    public function count(Request $request): Response
    {
        $dashboardFilter = $this->messageFactory->makeMessage(DashboardFilterRequest::class, $request);
        $result = $this->dashboardRepository->countRequestLogs($dashboardFilter);

        return $this->json($result);
    }

}
