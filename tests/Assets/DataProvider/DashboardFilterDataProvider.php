<?php

declare(strict_types=1);

namespace Tests\Assets\DataProvider;

use DateTime;

class DashboardFilterDataProvider
{
    /** @return  array<string, array<int, mixed>> */
    public static function validData(): array
    {
        $dateString = (new DateTime())->format(DATE_ATOM);

        return [
            'valid.filters' => [['service-name'], $dateString, $dateString, '1'],
            'null.filters' => [null, null, null, null]
        ];
    }
}
