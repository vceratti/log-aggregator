<?php

declare(strict_types=1);

namespace Tests\Shared;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ApplicationTestCase extends KernelTestCase
{
    use DatabaseTransactionTrait;

    protected function setUp(): void
    {
        parent::setUp();
        $this->beingTransaction();
    }

    protected function tearDown(): void
    {
        $this->rollbackTransaction();
        parent::tearDown();
    }
}
