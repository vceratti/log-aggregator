<?php

declare(strict_types=1);

namespace Tests\Assets\TestCase;

use Exception;
use JsonSerializable;
use League\OpenAPIValidation\PSR7\Exception\ValidationFailed as ValidationFailedAlias;
use League\OpenAPIValidation\PSR7\OperationAddress;
use League\OpenAPIValidation\PSR7\ResponseValidator;
use League\OpenAPIValidation\PSR7\ValidatorBuilder;
use LogAggregator\Application\Message\Factory\MessageFactory;
use Symfony\Bridge\PsrHttpMessage\HttpMessageFactoryInterface;

class RequestTestCase extends ApplicationTestCase
{
    private ResponseValidator $responseValidator;
    private HttpMessageFactoryInterface $psrResponseFactory;

    /** @throws Exception */
    protected function setUp(): void
    {
        parent::setUp();
        $this->psrResponseFactory = $this->getFromContainer(HttpMessageFactoryInterface::class);
        $this->responseValidator = $this->getFromContainer(ValidatorBuilder::class)
            ->fromJsonFile(MessageFactory::SCHEMA_JSON)
            ->getResponseValidator();
    }

    /** @throws ValidationFailedAlias */
    protected function assertsSuccessfulResponse(JsonSerializable $expectedData): void
    {
        $operation = new OperationAddress(
            $this->client->getRequest()->getPathInfo(),
            strtolower($this->client->getRequest()->getMethod())
        );

        $response = $this->psrResponseFactory->createResponse($this->client->getResponse());

        $this->responseValidator->validate($operation, $response);
        $responseData = json_decode((string)$this->client->getResponse()->getContent(), true);

        $this->assertSame($expectedData->jsonSerialize(), $responseData);
    }

}
