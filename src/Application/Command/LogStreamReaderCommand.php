<?php

declare(strict_types=1);

namespace LogAggregator\Application\Command;

use LogAggregator\Application\Stream\Factory\SingleLineReaderStreamFactory;
use LogAggregator\Application\Stream\FileStreamWorker;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Throwable;

#[AsCommand(name: 'log:read', description: 'Reads logfile stream', hidden: false)]
class LogStreamReaderCommand extends Command
{
    private const DEFAULT_TIMEOUT = 1;
    public const FILE_PATH_ARG = 'filePath';
    public const TIMEOUT_OPTION = 'timeout';

    public const TIMEOUT_DESCRIPTION = 'Maximum time to keep the reader looping before exiting (in seconds)';
    private FileStreamWorker $fileStreamWorker;
    private SingleLineReaderStreamFactory $fileStreamFactory;

    public function __construct(FileStreamWorker $fileStreamWorker, SingleLineReaderStreamFactory $fileStreamFactory)
    {
        parent::__construct();

        $this->addArgument(self::FILE_PATH_ARG, InputArgument::REQUIRED);
        $this->addOption(
            self::TIMEOUT_OPTION,
            null,
            InputArgument::OPTIONAL,
            self::TIMEOUT_DESCRIPTION,
            self::DEFAULT_TIMEOUT
        );

        $this->fileStreamWorker = $fileStreamWorker;
        $this->fileStreamFactory = $fileStreamFactory;
    }

    /** @throws Throwable */
    public function execute(InputInterface $input, OutputInterface $output): int
    {
        /** @var string $filePath */
        $filePath = $input->getArgument(self::FILE_PATH_ARG);
        /** @var string $timeout */
        $timeout = $input->getOption(self::TIMEOUT_OPTION);

        try {
            $this->fileStreamWorker->process($this->fileStreamFactory->makeStreamForFile($filePath), (float)$timeout);
        } catch (Throwable $exception) {
            $output->writeln((string)$exception);
        }

        return Command::SUCCESS;
    }
}
