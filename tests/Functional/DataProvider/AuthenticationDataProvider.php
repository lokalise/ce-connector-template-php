<?php

namespace App\Tests\Functional\DataProvider;

use App\Enum\AuthTypeEnum;
use App\Enum\ErrorCodeEnum;
use App\Enum\OAuthResponseParamsEnum;
use Symfony\Component\HttpFoundation\Response;

final class AuthenticationDataProvider
{
    public const API_KEY = [
        'apiKey' => 'api_key',
    ];

    public const REDIRECT_URL = 'redirect_url';

    public const AUTH_URL = 'auth_url';

    /**
     * @throws \JsonException
     */
    public static function encodedApiKey(): string
    {
        return base64_encode(
            json_encode(
                self::API_KEY,
                JSON_THROW_ON_ERROR,
            ),
        );
    }

    /**
     * @throws \JsonException
     */
    public static function encodedConnectorConfig(): string
    {
        return self::encodedApiKey();
    }

    public static function getMethodProvider(): array
    {
        return [
            'get_api_key_method' => [
                AuthTypeEnum::apiKey,
                [
                    'type' => AuthTypeEnum::apiKey->value,
                ],
            ],
            'get_oauth_method' => [
                AuthTypeEnum::OAuth,
                [
                    'type' => AuthTypeEnum::OAuth->value,
                ],
            ],
        ];
    }

    public static function authProvider(): array
    {
        return [
            'auth_by_api_key' => [
                AuthTypeEnum::apiKey,
                [],
                self::API_KEY,
            ],
            'generate_auth_utl' => [
                AuthTypeEnum::OAuth,
                [
                    'redirectUrl' => self::REDIRECT_URL,
                    'state' => 'state',
                ],
                [
                    'url' => self::AUTH_URL,
                ],
            ],
        ];
    }

    public static function authWithoutHeadersProvider(): array
    {
        return [
            [
                [
                    'statusCode' => Response::HTTP_BAD_REQUEST,
                    'payload' => [
                        'errorCode' => ErrorCodeEnum::CLIENT_ERROR->value,
                        'details' => [
                            'errors' => [
                                [
                                    'CE-Config' => ['Configuration header should not be blank'],
                                ],
                            ],
                        ],
                        'message' => 'Invalid configuration data',
                    ],
                ],
            ],
        ];
    }

    public static function authWithInvalidHeadersProvider(): array
    {
        return [
            [
                [
                    'statusCode' => Response::HTTP_BAD_REQUEST,
                    'payload' => [
                        'errorCode' => ErrorCodeEnum::CLIENT_ERROR->value,
                        'details' => [
                            'errors' => [
                                [
                                    'apiKey' => ['This value should not be blank.'],
                                ],
                            ],
                        ],
                        'message' => 'Invalid configuration data',
                    ],
                ],
            ],
        ];
    }

    public static function oAuthWithEmptyRequestProvider(): array
    {
        return [
            [
                [
                    'statusCode' => Response::HTTP_BAD_REQUEST,
                    'payload' => [
                        'errorCode' => ErrorCodeEnum::CLIENT_ERROR->value,
                        'details' => [
                            'errors' => [
                                [
                                    'redirectUrl' => ['This value should not be blank.'],
                                ],
                            ],
                        ],
                        'message' => 'Bad request',
                    ],
                ],
            ],
        ];
    }

    public static function authByOAuthProvider(): array
    {
        return [
            'auth_by_oauth_using_oauth_type_with_query_in_request' => [
                OAuthResponseParamsEnum::query,
                [
                    'query' => [
                        'code' => 'code',
                    ],
                    'redirectUrl' => self::REDIRECT_URL,
                ],
                self::API_KEY,
            ],
            'auth_by_oauth_using_oauth_type_with_body_in_request' => [
                OAuthResponseParamsEnum::body,
                [
                    'body' => [
                        'code' => 'code',
                    ],
                    'redirectUrl' => self::REDIRECT_URL,
                ],
                self::API_KEY,
            ],
        ];
    }

    public static function authByOAuthUsingApiKeyProvider(): array
    {
        return [
            'auth_by_oauth_using_api_key_type_with_query_in_request' => [
                OAuthResponseParamsEnum::query,
                [
                    'query' => [
                        'code' => 'code',
                    ],
                    'redirectUrl' => self::REDIRECT_URL,
                ],
                [
                    'statusCode' => Response::HTTP_INTERNAL_SERVER_ERROR,
                    'payload' => [
                        'errorCode' => ErrorCodeEnum::UNRECOGNIZED_ERROR->value,
                    ],
                ],
            ],
            'auth_by_oauth_using_api_key_type_with_body_in_request' => [
                OAuthResponseParamsEnum::body,
                [
                    'body' => [
                        'code' => 'code',
                    ],
                    'redirectUrl' => self::REDIRECT_URL,
                ],
                [
                    'statusCode' => Response::HTTP_INTERNAL_SERVER_ERROR,
                    'payload' => [
                        'errorCode' => ErrorCodeEnum::UNRECOGNIZED_ERROR->value,
                    ],
                ],
            ],
        ];
    }

    public static function refreshProvider(): array
    {
        return [
            'refresh_api_key' => [
                AuthTypeEnum::apiKey,
                self::API_KEY,
            ],
            'refresh_access_token' => [
                AuthTypeEnum::OAuth,
                self::API_KEY,
            ],
        ];
    }

    public static function refreshWithoutHeadersProvider(): array
    {
        return [
            [
                [
                    'statusCode' => Response::HTTP_UNAUTHORIZED,
                    'payload' => [
                        'errorCode' => ErrorCodeEnum::AUTH_FAILED_ERROR->value,
                        'details' => [
                            'error' => 'Invalid api key',
                        ],
                        'message' => 'Authorization failed',
                    ],
                ],
            ],
        ];
    }
}
