<?php

declare(strict_types=1);

namespace LogAggregator\Application\Message;

/** @template-implements  MessageInterface<DashboardFilterRequest> */
class DashboardFilterRequest implements MessageInterface
{
    /** @var ?string[] */
    private ?array $serviceNames;
    private ?string $startDate;
    private ?string $endDate;
    private ?string $statusCode;

    /** @param array{
     *     serviceNames?: ?string[],
     *     startDate?: ?string,
     *     endDate?: ?string,
     *     statusCode?: ?string
     *  } $queryParams
     */
    public function __construct(array $queryParams)
    {
        $this->serviceNames = $queryParams['serviceNames'] ?? null;
        $this->startDate = $queryParams['startDate'] ?? null;
        $this->endDate = $queryParams['endDate'] ?? null;
        $this->statusCode = $queryParams['statusCode'] ?? null;
    }

    /** @return ?string[] */
    public function getServiceNames(): ?array
    {
        return $this->serviceNames;
    }

    public function getStartDate(): ?string
    {
        return $this->startDate;
    }

    public function getEndDate(): ?string
    {
        return $this->endDate;
    }

    public function getStatusCode(): ?string
    {
        return $this->statusCode;
    }
}
