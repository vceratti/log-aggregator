<?php

declare(strict_types=1);

namespace Tests\Assets\TestCase;

use Doctrine\ORM\EntityManagerInterface;
use Exception;
use LogAggregator\Application\Symfony\Kernel;
use RuntimeException;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\ConsoleOutputInterface;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Throwable;

class TestDatabase
{
    public const MAX_TRIES = 30;
    public const DB_SLEEP_TIME_MS = 100;
    private Kernel $kernel;
    private EntityManagerInterface $entityManager;
    private OutputInterface $output;

    public function __construct(Kernel $kernel, EntityManagerInterface $entityManager, ConsoleOutputInterface $output)
    {
        $this->kernel = $kernel;
        $this->entityManager = $entityManager;
        $this->output = $output;
        $this->output->setDecorated(true);
    }

    /** @throws Throwable */
    public function healthCheck(): void
    {
        $this->output->write('> Connecting to database... ');
        $this->waitForConnection();
    }

    /** @throws Throwable */
    private function waitForConnection(int $tries = 0): bool
    {
        self::checkTimeout($tries);

        try {
            return $this->entityManager->getConnection()->connect();
        } catch (Throwable $e) {
            if (str_contains($e->getMessage(), 'Connection refused')) {
                $this->sleepWait();

                return self::waitForConnection($tries + 1);
            }
            throw $e;
        }
    }

    private static function checkTimeout(int $tries): void
    {
        if ($tries > self::MAX_TRIES) {
            throw new RuntimeException('Database service not working');
        }
    }

    /** @throws Exception */
    public function migrate(): void
    {

        $this->output->write('Resetting database... ');
        $this->console()->run(new StringInput('doctrine:schema:drop --full-database --force'), new NullOutput());
        $this->output->write('Running database migrations... ');
        $this->console()->run(new StringInput('doctrine:migrations:migrate --all-or-nothing -n'), new NullOutput());
        $this->output->writeln('<fg=green> Database ready!<fg=green></>' . PHP_EOL);
        $this->sleepWait();
    }

    public function console(): Application
    {
        $console = new Application($this->kernel);
        $console->setCatchExceptions(true);
        $console->setAutoExit(false);

        return $console;
    }

    private function sleepWait(): void
    {
        usleep(self::DB_SLEEP_TIME_MS * 1000);
    }

}
