<?php

declare(strict_types=1);

namespace LogAggregator\Application\Message\Request\Factory;

use League\OpenAPIValidation\PSR7\ServerRequestValidator;
use League\OpenAPIValidation\PSR7\ValidatorBuilder;
use LogAggregator\Application\Message\InvalidMessageException;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Http\Message\ServerRequestInterface;
use Throwable;

class MessageFactory
{
    public const SCHEMA_JSON = __DIR__ . '/../../Schema/openapi.json';
    public ServerRequestValidator $requestValidator;

    public function __construct(ValidatorBuilder $validatorBuilder, CacheItemPoolInterface $cache)
    {
        $this->requestValidator = $validatorBuilder
            ->fromJsonFile(self::SCHEMA_JSON)
            ->setCache($cache)
            ->getServerRequestValidator();
    }

    /**
     * @template T
     * @param class-string<T> $messageClass
     * @return T
     * @throws InvalidMessageException
     */
    public function makeMessageFromRequest(string $messageClass, ServerRequestInterface $request)
    {
        try {
            $this->requestValidator->validate($request);

            return new $messageClass($request->getQueryParams());
        } catch (Throwable $exception) {
            throw new InvalidMessageException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }
}
