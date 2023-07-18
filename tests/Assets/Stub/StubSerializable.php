<?php

declare(strict_types=1);

namespace Tests\Assets\Stub;

use JsonSerializable;

class StubSerializable implements JsonSerializable
{
    /** @var mixed[] */
    private array $data;

    /** @param mixed[] $data */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /** @return mixed[] */
    public function jsonSerialize(): mixed
    {
        return $this->data;
    }
}
