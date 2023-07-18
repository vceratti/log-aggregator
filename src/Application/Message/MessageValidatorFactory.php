<?php

declare(strict_types=1);

namespace LogAggregator\Application\Message;

use League\OpenAPIValidation\PSR7\ServerRequestValidator;
use League\OpenAPIValidation\PSR7\ValidatorBuilder;
use Psr\Cache\CacheItemPoolInterface;

class MessageValidatorFactory
{
    public const SCHEMA_JSON = __DIR__ . '/Schema/openapi.json';
    private ValidatorBuilder $validatorBuilder;
    private CacheItemPoolInterface $cache;

    public function __construct(ValidatorBuilder $validatorBuilder, CacheItemPoolInterface $cache)
    {
        $this->validatorBuilder = $validatorBuilder;
        $this->cache = $cache;
    }

    public function getRequestValidator(): ServerRequestValidator
    {
        return $this->validatorBuilder
            ->fromJsonFile(self::SCHEMA_JSON)
            ->setCache($this->cache)
            ->getServerRequestValidator();
    }
}
