<?php

declare(strict_types=1);

namespace LogAggregator\Domain;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use LogAggregator\Domain\Shared\Entity;
use LogAggregator\Infrastructure\Persistence\Database\Repository\RequestLogRepository;

#[ORM\Entity(repositoryClass: RequestLogRepository::class)]
class RequestLog extends Entity
{
    #[ORM\Column]
    private string $serviceName;

    #[ORM\Column]
    private string $query;

    #[ORM\Column]
    private int $statusCode;
    #[ORM\Column]
    private DateTime $dateTime;

    public function __construct(string $serviceName, int $statusCode, string $query, DateTime $datetime)
    {
        $this->statusCode = $statusCode;
        $this->query = $query;
        $this->dateTime = $datetime;
        $this->serviceName = $serviceName;
    }

    public function getServiceName(): string
    {
        return $this->serviceName;
    }

    public function getQuery(): string
    {
        return $this->query;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getDateTime(): DateTime
    {
        return $this->dateTime;
    }

}
