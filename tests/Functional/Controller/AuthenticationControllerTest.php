<?php

namespace App\Tests\Functional\Controller;

use App\ArgumentResolver\RequestDtoResolver;
use App\Enum\AuthTypeEnum;
use App\Enum\OAuthResponseParamsEnum;
use App\Formatter\BadRequestErrorsFormatter;
use App\Renderer\AuthMethodRenderer;
use App\Renderer\JsonResponseRenderer;
use App\Service\AuthTypeService;
use App\Tests\Functional\AbstractApiTestCase;
use App\Tests\Functional\DataProvider\AuthenticationDataProvider;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AuthenticationControllerTest extends AbstractApiTestCase
{
    /**
     * @dataProvider \App\Tests\Functional\DataProvider\AuthenticationDataProvider::getMethodProvider
     *
     * @throws \Exception
     */
    public function testGetMethod(AuthTypeEnum $authType, array $response): void
    {
        $this->setAuthMethodRenderer($authType);

        static::assertRequest(
            method: Request::METHOD_GET,
            uri: '/v2/auth',
            expectedResponse: $response,
        );
    }

    /**
     * @dataProvider \App\Tests\Functional\DataProvider\AuthenticationDataProvider::authProvider
     *
     * @throws \Exception
     */
    public function testAuth(AuthTypeEnum $authType, array $request, array $response): void
    {
        $this->setRequestDtoResolver();
        $this->setAuthTypeService($authType);

        static::assertRequest(
            Request::METHOD_POST,
            '/v2/auth',
            $request,
            static::getTestConnectorConfigHeader(),
            $response,
        );
    }

    /**
     * @dataProvider \App\Tests\Functional\DataProvider\AuthenticationDataProvider::authWithoutHeadersProvider
     *
     * @throws \Exception
     */
    public function testAuthWithoutHeaders(array $response): void
    {
        static::assertRequest(
            method: Request::METHOD_POST,
            uri: '/v2/auth',
            expectedResponse: $response,
            expectedStatusCode: Response::HTTP_BAD_REQUEST,
        );
    }

    /**
     * @dataProvider \App\Tests\Functional\DataProvider\AuthenticationDataProvider::authWithInvalidHeadersProvider
     *
     * @throws \Exception
     */
    public function testAuthWithInvalidHeaders(array $response): void
    {
        static::assertRequest(
            method: Request::METHOD_POST,
            uri: '/v2/auth',
            server: [
                'HTTP_ce-config' => base64_encode(
                    json_encode([], JSON_THROW_ON_ERROR),
                ),
            ],
            expectedResponse: $response,
            expectedStatusCode: Response::HTTP_BAD_REQUEST,
        );
    }

    /**
     * @dataProvider \App\Tests\Functional\DataProvider\AuthenticationDataProvider::oAuthWithEmptyRequestProvider
     *
     * @throws \Exception
     */
    public function testOAuthWithEmptyRequest(array $response): void
    {
        $this->setRequestDtoResolver();
        $this->setAuthTypeService(AuthTypeEnum::OAuth);

        static::assertRequest(
            method: Request::METHOD_POST,
            uri: '/v2/auth',
            expectedResponse: $response,
            expectedStatusCode: Response::HTTP_BAD_REQUEST,
        );
    }

    /**
     * @dataProvider \App\Tests\Functional\DataProvider\AuthenticationDataProvider::authByOAuthProvider
     *
     * @throws \Exception
     */
    public function testAuthByOAuth(OAuthResponseParamsEnum $oAuthResponseParams, array $request, array $response): void
    {
        $this->setRequestDtoResolver($oAuthResponseParams);
        $this->setAuthTypeService(AuthTypeEnum::OAuth);

        static::assertRequest(
            Request::METHOD_POST,
            '/v2/auth/response',
            $request,
            static::getTestConnectorConfigHeader(),
            $response,
        );
    }

    /**
     * @dataProvider \App\Tests\Functional\DataProvider\AuthenticationDataProvider::authByOAuthUsingApiKeyProvider
     *
     * @throws \Exception
     */
    public function testAuthByOAuthUsingApiKey(
        OAuthResponseParamsEnum $oAuthResponseParams,
        array $request,
        array $response,
    ): void {
        $this->setRequestDtoResolver($oAuthResponseParams);
        $this->setAuthTypeService(AuthTypeEnum::apiKey);

        static::assertRequest(
            Request::METHOD_POST,
            '/v2/auth/response',
            $request,
            static::getTestConnectorConfigHeader(),
            $response,
            Response::HTTP_INTERNAL_SERVER_ERROR,
        );
    }

    /**
     * @dataProvider \App\Tests\Functional\DataProvider\AuthenticationDataProvider::refreshProvider
     *
     * @throws \Exception
     */
    public function testRefresh(AuthTypeEnum $authType, array $response): void
    {
        $this->setRequestDtoResolver();
        $this->setAuthTypeService($authType);

        static::assertRequest(
            method: Request::METHOD_POST,
            uri: '/v2/auth/refresh',
            server: static::getTestHeaders(),
            expectedResponse: $response,
        );
    }

    /**
     * @dataProvider \App\Tests\Functional\DataProvider\AuthenticationDataProvider::refreshWithoutHeadersProvider()
     */
    public function testRefreshWithoutHeaders(array $response): void
    {
        static::assertRequest(
            method: Request::METHOD_POST,
            uri: '/v2/auth/refresh',
            expectedResponse: $response,
            expectedStatusCode: Response::HTTP_UNAUTHORIZED,
        );
    }

    public function setAuthTypeService(AuthTypeEnum $authType): void
    {
        $container = static::getContainer();
        $service = new AuthTypeService($authType);

        $container->set(AuthTypeService::class, $service);
    }

    /**
     * @throws \Exception
     */
    public function setAuthMethodRenderer(AuthTypeEnum $authType): void
    {
        $container = static::getContainer();

        /** @var JsonResponseRenderer $jsonResponseRenderer */
        $jsonResponseRenderer = $container->get(JsonResponseRenderer::class);

        $authMethodRenderer = new AuthMethodRenderer($jsonResponseRenderer, $authType);

        $container->set(AuthMethodRenderer::class, $authMethodRenderer);
    }

    /**
     * @throws \Exception
     */
    public function setRequestDtoResolver(
        OAuthResponseParamsEnum $oAuthResponseParams = OAuthResponseParamsEnum::query,
    ): void {
        $container = static::getContainer();

        /** @var SerializerInterface $serializer */
        $serializer = $container->get(SerializerInterface::class);

        /** @var ValidatorInterface $validator */
        $validator = $container->get(ValidatorInterface::class);

        /** @var BadRequestErrorsFormatter $badRequestErrorsFormatter */
        $badRequestErrorsFormatter = $container->get(BadRequestErrorsFormatter::class);

        $requestDtoResolver = new RequestDtoResolver(
            $serializer,
            $validator,
            $badRequestErrorsFormatter,
            $oAuthResponseParams,
        );

        $container->set(RequestDtoResolver::class, $requestDtoResolver);
    }
}
