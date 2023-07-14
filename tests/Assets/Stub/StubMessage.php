<?php

declare(strict_types=1);

namespace Tests\Assets\Stub;

use LogAggregator\Application\Message\MessageInterface;

/** @template-implements MessageInterface<StubMessage> */
class StubMessage implements MessageInterface
{
}
