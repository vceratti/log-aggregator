<?php

declare(strict_types=1);

namespace Tests\Assets\TestCase;

use Exception;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApplicationTestCase extends WebTestCase
{
    use DatabaseTransactionTrait;
    use QueueTrait;
    use ConsoleTrait;

    protected KernelBrowser $client;

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = self::createClient();
        $this->beingTransaction();
        if ($_ENV['APP_DEBUG'] === 'false') {
            self::getContainer()->set(LoggerInterface::class, new NullLogger());
        }
    }

    /**
     * @template T
     * @param class-string<T> $className
     * @return T
     * @throws Exception
     */
    public static function getFromContainer(string $className)
    {
        /** @var T $entityManager */
        $entityManager = self::getContainer()->get($className);

        return $entityManager;
    }

    protected function tearDown(): void
    {
        $this->resetQueues();
        $this->rollbackTransaction();
        parent::tearDown();
    }

}
