<?php

declare(strict_types=1);

namespace LogAggregator\Application\Message\Request\Factory;

use League\OpenAPIValidation\PSR7\ServerRequestValidator;
use LogAggregator\Application\Message\InvalidMessageException;
use LogAggregator\Application\Message\MessageValidatorFactory;
use Symfony\Bridge\PsrHttpMessage\HttpMessageFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Throwable;

class RequestMessageFactory
{
    public ServerRequestValidator $requestValidator;
    private HttpMessageFactoryInterface $psrFactory;

    public function __construct(
        MessageValidatorFactory     $validatorFactory,
        HttpMessageFactoryInterface $psrFactory
    ) {

        $this->requestValidator = $validatorFactory->getRequestValidator();
        $this->psrFactory = $psrFactory;
    }

    /**
     * @template T
     * @param class-string<T> $messageClass
     * @return T
     * @throws InvalidMessageException
     */
    public function makeMessageFromRequest(string $messageClass, Request $request)
    {
        $psrRequest = $this->psrFactory->createRequest($request);

        try {
            $this->requestValidator->validate($psrRequest);

            return new $messageClass($psrRequest->getQueryParams());
        } catch (Throwable $exception) {
            throw new InvalidMessageException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }
}
