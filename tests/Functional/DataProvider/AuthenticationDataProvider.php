<?php

namespace App\Tests\Functional\DataProvider;

use App\Enum\AuthTypeEnum;
use App\Enum\OAuthResponseParamsEnum;
use JsonException;

final class AuthenticationDataProvider
{
    public const API_KEY = 'api_key';

    public const FAILED_API_KEY = 'failed_api_key';

    public const REDIRECT_URL = 'redirect_url';

    public const AUTH_URL = 'auth_url';

    public const ACCESS_TOKEN = 'access_token';

    public const REFRESH_TOKEN = 'refresh_token';

    public const EXPIRES_IN = 3600;

    public const ACCESS_CREDENTIALS = [
        'accessToken' => self::ACCESS_TOKEN,
        'refreshToken' => self::REFRESH_TOKEN,
        'expiresIn' => self::EXPIRES_IN,
    ];

    private static function encoding(array $data): string
    {
        return base64_encode(
            json_encode(
                $data,
                JSON_THROW_ON_ERROR
            )
        );
    }

    /**
     * @throws JsonException
     */
    public static function encodedApiKey(): string
    {
        return self::encoding(
            array_merge(
                [
                    'apiKey' => self::API_KEY,
                ],
                self::ACCESS_CREDENTIALS
            )
        );
    }

    /**
     * @throws JsonException
     */
    public static function encodedConnectorConfig(): string
    {
        return self::encodedApiKey();
    }

    private static function encodedConnectorConfigHeaderWithoutApiKey(): array
    {
        return [
            'HTTP_ce-config' => self::encoding(self::ACCESS_CREDENTIALS),
        ];
    }

    public static function encodedConnectorConfigWithoutApiKey(): array
    {
        return [
            [
                self::encodedConnectorConfigHeaderWithoutApiKey(),
            ],
        ];
    }

    public static function encodedConnectorConfigWithFailedRefreshToken(): array
    {
        return [
            [
                [
                    'HTTP_ce-config' => self::encoding(
                        array_merge(
                            [
                                'apiKey' => AuthenticationDataProvider::FAILED_API_KEY,
                            ],
                            self::ACCESS_CREDENTIALS
                        )
                    ),
                ],
            ],
        ];
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
                [
                    'key' => self::API_KEY,
                ],
                [
                    'apiKey' => self::API_KEY,
                ],
            ],
            'generate_auth_utl' => [
                AuthTypeEnum::OAuth,
                [
                    'redirectUrl' => self::REDIRECT_URL,
                ],
                [
                    'url' => self::AUTH_URL,
                ],
            ],
        ];
    }

    public static function authProviderWithConnectorConfigWithoutApiKey(): array
    {
        return [
            'auth_by_api_key' => [
                AuthTypeEnum::apiKey,
                self::encodedConnectorConfigHeaderWithoutApiKey(),
            ],
            'generate_auth_utl' => [
                AuthTypeEnum::OAuth,
                self::encodedConnectorConfigHeaderWithoutApiKey(),
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
                [
                    'accessToken' => self::ACCESS_TOKEN,
                    'refreshToken' => self::REFRESH_TOKEN,
                    'expiresIn' => self::EXPIRES_IN,
                ],
            ],
            'auth_by_oauth_using_oauth_type_with_body_in_request' => [
                OAuthResponseParamsEnum::body,
                [
                    'body' => [
                        'code' => 'code',
                    ],
                    'redirectUrl' => self::REDIRECT_URL,
                ],
                [
                    'accessToken' => self::ACCESS_TOKEN,
                    'refreshToken' => self::REFRESH_TOKEN,
                    'expiresIn' => self::EXPIRES_IN,
                ],
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
            ],
            'auth_by_oauth_using_api_key_type_with_body_in_request' => [
                OAuthResponseParamsEnum::body,
                [
                    'body' => [
                        'code' => 'code',
                    ],
                    'redirectUrl' => self::REDIRECT_URL,
                ],
            ],
        ];
    }

    public static function refreshProvider(): array
    {
        return [
            'refresh_api_key' => [
                AuthTypeEnum::apiKey,
                [
                    'apiKey' => self::API_KEY,
                ],
                [
                    'apiKey' => self::API_KEY,
                ],
            ],
            'refresh_access_token' => [
                AuthTypeEnum::OAuth,
                [
                    'accessToken' => self::ACCESS_TOKEN,
                    'refreshToken' => self::REFRESH_TOKEN,
                    'expiresIn' => self::EXPIRES_IN,
                ],
                [
                    'accessToken' => self::ACCESS_TOKEN,
                    'refreshToken' => self::REFRESH_TOKEN,
                    'expiresIn' => self::EXPIRES_IN,
                ],
            ],
        ];
    }
}
