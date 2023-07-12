<?php

declare(strict_types=1);

namespace Tests\Assets\Generator;

use DateTime;
use LogAggregator\Domain\RequestLog;
use Tests\Assets\Generator\Generator\EntityGenerator;

class RequestLogProvider extends EntityGenerator
{
    public static function validEntity(): RequestLog
    {
        return new RequestLog(1, '10', new DateTime('now'));
    }
}
