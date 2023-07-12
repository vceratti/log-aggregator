<?php

declare(strict_types=1);

namespace Tests\Assets\Generator\Generator;

use LogAggregator\Domain\Shared\Entity;

abstract class EntityGenerator
{
    abstract public static function validEntity(): Entity;

    /** @return array<int, Entity> */
    public static function validEntityCollection(int $count): array
    {
        $result = [];

        for($index = 0; $index < $count; $index++) {
            $result[] = static::validEntity();
        }

        return $result;
    }
}
