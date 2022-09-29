<?php

namespace App\Tests\Functional\Controller;

use App\ArgumentResolver\RequestDtoResolver;
use App\Enum\AuthTypeEnum;
use App\Enum\OAuthResponseParamsEnum;
use App\Exception\BadRequestHttpException;
use App\Exception\UnauthorizedHttpException;
use App\Formatter\BadRequestErrorsFormatter;
use App\Renderer\AuthMethodRenderer;
use App\Renderer\JsonResponseRenderer;
use App\Service\AuthTypeService;
use App\Tests\Functional\AbstractApiTestCase;
use Exception;
use JsonException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AuthenticationControllerTest extends AbstractApiTestCase
{
    /**
     * @dataProvider \App\Tests\Functional\DataProvider\AuthenticationDataProvider::getMethodProvider
     *
     * @throws JsonException
     * @throws Exception
     */
    public function testGetMethod(AuthTypeEnum $authType, array $response): void
    {
        $this->setAuthMethodRenderer($authType);

        static::checkRequest(
            Request::METHOD_GET,
            '/v2/auth',
            [],
            $response,
        );
    }

    /**
     * @dataProvider \App\Tests\Functional\DataProvider\AuthenticationDataProvider::authProvider
     *
     * @throws JsonException
     * @throws Exception
     */
    public function testAuth(AuthTypeEnum $authType, array $request, array $response): void
    {
        $this->setRequestDtoResolver();
        $this->setAuthTypeService($authType);

        static::checkRequest(
            Request::METHOD_POST,
            '/v2/auth',
            $request,
            $response,
        );
    }

    /**
     * @dataProvider \App\Tests\Functional\DataProvider\AuthenticationDataProvider::authProviderWithoutRequest
     *
     * @throws JsonException
     * @throws Exception
     */
    public function testAuthWithEmptyRequest(AuthTypeEnum $authType): void
    {
        $this->setRequestDtoResolver();
        $this->setAuthTypeService($authType);

        $this->expectException(BadRequestHttpException::class);

        static::checkEmptyRequest(Request::METHOD_POST, '/v2/auth', [
            'HTTP_ce-config' => null,
        ]);
    }

    /**
     * @dataProvider \App\Tests\Functional\DataProvider\AuthenticationDataProvider::authByOAuthProvider
     *
     * @throws JsonException
     * @throws Exception
     */
    public function testAuthByOAuth(OAuthResponseParamsEnum $oAuthResponseParams, array $request, array $response): void
    {
        $this->setRequestDtoResolver($oAuthResponseParams);
        $this->setAuthTypeService(AuthTypeEnum::OAuth);

        static::checkRequest(
            Request::METHOD_POST,
            '/v2/auth/response',
            $request,
            $response,
        );
    }

    /**
     * @dataProvider \App\Tests\Functional\DataProvider\AuthenticationDataProvider::authByOAuthUsingApiKeyProvider
     *
     * @throws JsonException
     * @throws Exception
     */
    public function testAuthByOAuthUsingApiKey(OAuthResponseParamsEnum $oAuthResponseParams, array $request): void
    {
        $this->setRequestDtoResolver($oAuthResponseParams);
        $this->setAuthTypeService(AuthTypeEnum::apiKey);

        $this->expectException(NotFoundHttpException::class);

        static::checkNotAuthorisedRequest(
            Request::METHOD_POST,
            '/v2/auth/response',
            $request,
        );
    }

    /**
     * @dataProvider \App\Tests\Functional\DataProvider\AuthenticationDataProvider::refreshProvider
     *
     * @throws JsonException
     * @throws Exception
     */
    public function testRefresh(AuthTypeEnum $authType, array $response): void
    {
        $this->setRequestDtoResolver();
        $this->setAuthTypeService($authType);

        static::checkRequest(
            Request::METHOD_POST,
            '/v2/auth/refresh',
            [],
            $response,
            static::getTestTokenHeader()
        );
    }

    /**
     * @throws JsonException
     * @throws Exception
     */
    public function testRefreshWithoutApiKey(): void
    {
        $this->expectException(UnauthorizedHttpException::class);

        static::checkEmptyRequest(Request::METHOD_POST, '/v2/auth/refresh', [
            'HTTP_ce-auth' => null,
        ]);
    }

    /**
     * @throws Exception
     */
    public function setAuthTypeService(AuthTypeEnum $authType): void
    {
        $container = static::getContainer();
        $service = new AuthTypeService($authType);

        $container->set(AuthTypeService::class, $service);
    }

    /**
     * @throws Exception
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
     * @throws Exception
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
