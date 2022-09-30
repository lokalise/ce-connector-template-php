# Connector Template PHP

If you have content that needs to be translated and which would be automatically transmitted to the localization system,
then [Lokalise](https://lokalise.com/) can provide you with UI to manage translations. For the system that will transmit
data to [Lokalise](https://lokalise.com/) you need to implement a connector. This repository can be used as a template
for your connector.

This Connector Template allows you to create an application that will act as a bridge between the content platform and
[Lokalise](https://lokalise.com/) content engine, and will enable users to connect both systems, select the content they
want to translate, transfer it to [Lokalise](https://lokalise.com/), see the translation status, and receive the
translated content back. Read more about the technical implementation requirements in this
[article](https://developers.lokalise.com/docs/technical-requirements-content-exchange-hosted-connector).

## Table of Contents

* [Tech stack](#tech-stack)
* [Preinstall](#preinstall)
* [How to start the project](#how-to-start-the-project)
* [Configuration settings for your connector](#configuration-settings-for-your-connector)
* [How to run tests](#how-to-run-tests)
* [How to run code fixer](#how-to-run-code-fixer)
* [How to set up Xdebug](#how-to-set-up-xdebug)
* [Short description of make commands](#short-description-of-make-commands)

## Tech stack

* PHP - 8.1
* Symfony - 6.1
* PHPUnit - 9.5
* RoadRunner - 2
* Composer - latest

## Preinstall

* Docker - latest
* Docker Compose - latest

## How to start the project

1. In root project folder copy `.env` file and name it as `.env.local`.
2. Run `make init` in command line.

## Configuration settings for your connector

1. If your connector uses _OAuth2_ authorization, then add the following parameters to the .env.local file with the
   required values:
    ```
    PLATFORM_CLIENT_ID=
    PLATFORM_CLIENT_SECRET=
    ```

2. Go to config/services.yaml file:
    - If your connector uses _apiKey_ authorization, then set the following values:
       ```yaml
        services:
          _defaults:
            bind:
              App\Enum\AuthTypeEnum $defaultAuthType: !php/const App\Enum\AuthTypeEnum::apiKey
        ```
    - If your connector uses _OAuth2_ authorization, then set the following values:
        ```yaml
        services:
          _defaults:
            bind:
              App\Enum\AuthTypeEnum $defaultAuthType: !php/const App\Enum\AuthTypeEnum::OAuth
              App\Enum\OAuthResponseParamsEnum $defaultOAuthResponseParams: !php/const App\Enum\OAuthResponseParamsEnum::query
              string $platformClientId: '%env(PLATFORM_CLIENT_ID)%'
              string $platformClientSecret: '%env(PLATFORM_CLIENT_SECRET)%'
        ```

3. Go to the [DTO](src/Integration/DTO/) folder and set the parameters you need for your connector for the classes
   listed in this folder.
4. Implement the logic of your connectors in services located in the [Service](src/Integration/Service/) folder. These
   services should implement the interfaces specified in [this](src/Interfaces/Service/) folder.

## How to run tests

Run `make tests` in command line.

## How to run code fixer

We follow Symfony coding standards. For this we use the [PHP CS Fixer](https://cs.symfony.com/) tool. To check and fix
the code run `make code-fixer` in command line.

## How to set up Xdebug

1. In `.env.local` file set value for `WORKSPACE_INSTALL_XDEBUG` to `true`.
2. Go to PHPStorm settings:
    - Go to ***PHP*** menu item:
        - CLI Interpreter:
            - press add new one (From Docker, Vagrant, ...),
            - choose *Docker Compose*,
            - set service (development_workspace),
            - press ok.
        - Path Mappings:
            - press add new one,
            - as *Local path* set project root path,
            - as *Remote path* set `/var/www`,
            - press ok.
        - Apply changes.
    - Go to ***PHP->Debug*** menu item:
        - Make sure that are the following settings are disabled:
            - Ignore external connections through unregistered server configurations.
            - Break at first line in PHP scripts.
            - Force break at first line when no path mapping specified.
            - Force break at first line when a script is outside the project.
        - Set *Debug Port* as `9003`.
        - Apply changes.
    - Go to ***PHP->Debug->DBGp Proxy*** menu item:

      Set the following values:
        ```
        IDE key = PHPSTORM
        Host = localhost 
        Port = 9003
        ```
    - Go to ***PHP->Servers*** menu item:
        - press add new one,
        - set name,
        - set Host as `localhost`,
        - set port as `8080`,
        - enable *Use path mappings*,
        - set absolut path on the server as `/var/www` for root project directory,
        - apply changes.
3. Run `make init` once again.

## Short description of make commands

* `make build` - build or rebuild services
* `make up` - create and start containers
* `make start` - start services
* `make down` - stop and remove containers, networks
* `make destroy` - stop and remove containers, networks with volumes
* `make stop` - stop services
* `make restart` - restart service containers
* `make init` - build or rebuild services and create and start containers
* `make tests` - runs tests
* `make code-fixer` - fixes code according to Symfony coding standards
* `make build-prod` - build or rebuild services for prod
* `make up-prod` - create and start containers for prod

