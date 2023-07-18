<?php

declare(strict_types=1);

namespace LogAggregator\Application\Controller\Factory;

use LogAggregator\Application\Message\Factory\MessageFactory;
use LogAggregator\Application\Message\InvalidMessageException;
use Symfony\Bridge\PsrHttpMessage\HttpMessageFactoryInterface;
use Symfony\Component\HttpFoundation\Request;

class RequestMessageFactory
{
    protected MessageFactory $messageFactory;
    protected HttpMessageFactoryInterface $psrFactory;

    public function __construct(MessageFactory $messageFactory, HttpMessageFactoryInterface $psrFactory)
    {
        $this->messageFactory = $messageFactory;
        $this->psrFactory = $psrFactory;
    }

    /**
     * @template T
     * @param class-string<T> $messageType
     * @return T
     * @throws InvalidMessageException
     */
    public function makeMessage(string $messageType, Request $request)
    {
        return $this->messageFactory->makeMessageFromRequest($messageType, $this->psrFactory->createRequest($request));
    }
}
