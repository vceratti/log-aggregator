<?php

declare(strict_types=1);

namespace LogAggregator\Application\Controller;

use LogAggregator\Domain\Counter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CounterController extends AbstractController
{
    #[Route('/count', methods: ['GET'])]
    public function count(): Response
    {
        $counter = new Counter(1);

        return $this->json($counter);
    }
}
