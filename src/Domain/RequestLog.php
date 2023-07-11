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
    private string $query;

    #[ORM\Column]
    private int $statusCode;

    #[ORM\Column]
    private DateTime $dateTime;

    public function __construct(int $statusCode, string $query, DateTime $datetime)
    {
        $this->statusCode = $statusCode;
        $this->query = $query;
        $this->dateTime = $datetime;
    }
}
