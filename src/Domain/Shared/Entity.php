<?php

declare(strict_types=1);

namespace LogAggregator\Domain\Shared;

use Doctrine\ORM\Mapping as ORM;

abstract class Entity
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    protected ?int $id;
}
