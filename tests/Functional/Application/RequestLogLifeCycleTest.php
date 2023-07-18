<?php

declare(strict_types=1);

namespace Tests\Functional\Application;

use Exception;
use League\OpenAPIValidation\PSR7\Exception\ValidationFailed;
use PHPUnit\Framework\Attributes\CoversNothing;
use Symfony\Component\Console\Command\Command;
use Tests\Assets\Stub\StubSerializable;
use Tests\Assets\TestCase\RequestTestCase;

#[CoversNothing]
class RequestLogLifeCycleTest extends RequestTestCase
{
    public const TEST_FILE_PATH = __DIR__ . '/test.log';

    /** @throws ValidationFailed|Exception */
    public function testLogProcessing(): void
    {
        $result = $this->consoleRun('log:read --timeout=1 ' . self::TEST_FILE_PATH);
        $this->assertSame(Command::SUCCESS, $result);
        $result = $this->consoleRun('messenger:consume log.queue -vv --time-limit=1');
        $this->assertSame(Command::SUCCESS, $result);
        $this->client->request('GET', '/count');

        $this->assertsSuccessfulResponse(new StubSerializable(['counter' => 20]));
    }
}
