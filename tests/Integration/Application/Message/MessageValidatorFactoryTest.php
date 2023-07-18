<?php

declare(strict_types=1);

namespace Tests\Integration\Application\Message;

use Exception;
use League\OpenAPIValidation\PSR7\ServerRequestValidator;
use LogAggregator\Application\Message\MessageValidatorFactory;
use PHPUnit\Framework\Attributes\CoversClass;
use Tests\Assets\TestCase\ApplicationTestCase;

#[CoversClass(MessageValidatorFactory::class)]
class MessageValidatorFactoryTest extends ApplicationTestCase
{
    private MessageValidatorFactory $factory;

    /** @throws Exception */
    protected function setUp(): void
    {
        parent::setUp();
        $this->factory = $this->getFromContainer(MessageValidatorFactory::class);
    }

    public function testGetRequestValidator(): void
    {
        $this->assertInstanceOf(ServerRequestValidator::class, $this->factory->getRequestValidator());
    }
}
