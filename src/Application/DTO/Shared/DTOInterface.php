<?php

declare(strict_types=1);

namespace LogAggregator\Application\DTO\Shared;

interface DTOInterface
{
    /** @throws InvalidMessageException */
    public function validate(): void;
}
