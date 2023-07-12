<?php

declare(strict_types=1);

namespace Tests\Assets\TestCase;

use Exception;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApplicationTestCase extends WebTestCase
{
    use DatabaseTransactionTrait;

    protected KernelBrowser $client;

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = self::createClient();
        $this->beingTransaction();
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
        $this->rollbackTransaction();
        parent::tearDown();
    }

}
