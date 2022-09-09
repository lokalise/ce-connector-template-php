<?php

namespace App\Tests\Functional\Controller;

use App\ArgumentResolver\RequestDtoResolver;
use App\Controller\AuthenticationController;
use App\Enum\AuthTypeEnum;
use App\Enum\OAuthResponseParamsEnum;
use App\Interfaces\Renderer\AuthMethodRendererInterface;
use App\Interfaces\Renderer\AuthRendererInterface;
use App\Interfaces\Renderer\RefreshRendererInterface;
use App\Interfaces\Service\AuthenticationServiceInterface;
use App\Tests\Functional\AbstractApiTestCase;
use App\Tests\Functional\DataProvider\AuthenticationDataProvider;
use Exception;
use JsonException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
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
        $this->setAuthenticationController($authType);

        static::checkRequest(
            Request::METHOD_GET,
            '/auth',
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
        $this->setRequestDtoResolver($authType);
        $this->setAuthenticationController($authType);

        static::checkRequest(
            Request::METHOD_POST,
            '/auth',
            $request,
            $response,
        );
    }

    /**
     * @throws JsonException
     * @throws Exception
     */
    public function testAuthByFailedApiKey(): void
    {
        $this->setRequestDtoResolver(AuthTypeEnum::apiKey);
        $this->setAuthenticationController(AuthTypeEnum::apiKey);

        $this->expectException(AccessDeniedHttpException::class);

        static::checkNotAuthorisedRequest(
            Request::METHOD_POST,
            '/auth',
            [
                'key' => AuthenticationDataProvider::FAILED_API_KEY,
            ],
        );
    }

    /**
     * @dataProvider \App\Tests\Functional\DataProvider\AuthenticationDataProvider::authProvider
     *
     * @throws JsonException
     * @throws Exception
     */
    public function testAuthWithEmptyRequest(AuthTypeEnum $authType): void
    {
        $this->setRequestDtoResolver($authType);
        $this->setAuthenticationController($authType);

        $this->expectException(BadRequestHttpException::class);

        static::checkEmptyRequest(
            Request::METHOD_POST,
            '/auth'
        );
    }

    /**
     * @dataProvider \App\Tests\Functional\DataProvider\AuthenticationDataProvider::authByOAuthProvider
     *
     * @throws JsonException
     * @throws Exception
     */
    public function testAuthByOAuth(OAuthResponseParamsEnum $oAuthResponseParams, array $request, array $response): void
    {
        $this->setRequestDtoResolver(AuthTypeEnum::OAuth, $oAuthResponseParams);
        $this->setAuthenticationController(AuthTypeEnum::OAuth);

        static::checkRequest(
            Request::METHOD_POST,
            '/auth/response',
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
        $this->setRequestDtoResolver(AuthTypeEnum::apiKey, $oAuthResponseParams);
        $this->setAuthenticationController(AuthTypeEnum::apiKey);

        $this->expectException(AccessDeniedHttpException::class);

        static::checkNotAuthorisedRequest(
            Request::METHOD_POST,
            '/auth/response',
            $request,
        );
    }

    /**
     * @dataProvider \App\Tests\Functional\DataProvider\AuthenticationDataProvider::refreshProvider
     *
     * @throws JsonException
     * @throws Exception
     */
    public function testRefresh(AuthTypeEnum $authType, array $request, array $response): void
    {
        $this->setRequestDtoResolver($authType);
        $this->setAuthenticationController($authType);

        static::checkRequest(
            Request::METHOD_POST,
            '/auth/refresh',
            $request,
            $response,
        );
    }

    /**
     * @throws JsonException
     * @throws Exception
     */
    public function testRefreshWithFailedRefreshToken(): void
    {
        $this->setAuthenticationController(AuthTypeEnum::apiKey);

        $this->expectException(AccessDeniedHttpException::class);

        static::checkNotAuthorisedRequest(
            Request::METHOD_POST,
            '/auth/refresh',
            [
                'apiKey' => AuthenticationDataProvider::FAILED_API_KEY,
            ],
        );
    }

    /**
     * @throws JsonException
     */
    public function testRefreshEmptyRequest(): void
    {
        $this->expectException(BadRequestHttpException::class);

        static::checkEmptyRequest(
            Request::METHOD_POST,
            '/auth/refresh'
        );
    }

    /**
     * @throws Exception
     */
    public function setAuthenticationController(AuthTypeEnum $authType): void
    {
        $container = static::getContainer();

        /** @var AuthenticationServiceInterface $authenticationService */
        $authenticationService = $container->get(AuthenticationServiceInterface::class);

        /** @var AuthMethodRendererInterface $authMethodRenderer */
        $authMethodRenderer = $container->get(AuthMethodRendererInterface::class);

        /** @var AuthRendererInterface $authRenderer */
        $authRenderer = $container->get(AuthRendererInterface::class);

        /** @var RefreshRendererInterface $refreshRenderer */
        $refreshRenderer = $container->get(RefreshRendererInterface::class);

        $controller = new AuthenticationController(
            $authenticationService,
            $authMethodRenderer,
            $authRenderer,
            $refreshRenderer,
            $authType,
        );
        $controller->setContainer($container);

        $container->set(AuthenticationController::class, $controller);
    }

    /**
     * @throws Exception
     */
    public function setRequestDtoResolver(
        AuthTypeEnum $authType,
        OAuthResponseParamsEnum $oAuthResponseParams = OAuthResponseParamsEnum::query,
    ): void {
        $container = static::getContainer();

        /** @var SerializerInterface $serializer */
        $serializer = $container->get(SerializerInterface::class);

        /** @var ValidatorInterface $validator */
        $validator = $container->get(ValidatorInterface::class);

        $requestDtoResolver = new RequestDtoResolver($serializer, $validator, $authType, $oAuthResponseParams);

        $container->set(RequestDtoResolver::class, $requestDtoResolver);
    }
}
