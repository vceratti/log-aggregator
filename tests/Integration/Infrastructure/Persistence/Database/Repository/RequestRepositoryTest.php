<?php

declare(strict_types=1);

namespace Tests\Integration\Infrastructure\Persistence\Database\Repository;

use DateTime;
use Exception;
use LogAggregator\Domain\RequestLog;
use LogAggregator\Infrastructure\Persistence\Database\Repository\RequestLogRepository;
use PHPUnit\Framework\Attributes\CoversClass;
use Tests\Assets\TestCase\ApplicationTestCase;

#[CoversClass(RequestLogRepository::class)]
class RequestRepositoryTest extends ApplicationTestCase
{
    private RequestLogRepository $repository;

    /** @throws Exception */
    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = self::getContainer()->get(RequestLogRepository::class);
    }

    public function testSave(): void
    {
        $request = new RequestLog(1, 'test', new DateTime('now'));

        $this->repository->save($request);

        $stored = $this->getEntities(RequestLog::class);

        $this->assertcount(1, $stored);
        $this->assertSame($request, $stored[0]);
    }
}
