# PHP Template for a Lokalise Content Engine Connector

Lokalise **content exchange apps** facilitate the exchange of translatable content between Lokalise and third party content platforms. Users interact with them to connect both systems, select the content they want to translate, transfer it to Lokalise, see the translation status, and send the translations back to the content platform. 

You can build and publish **your own content exchange app** by building a connector for the Lokalise content engine. The **content engine** will take care of the UI and handle the standard install, config and content management flows, while the **connector** will act as a bridge between the content platform and Lokalise content engine.

```
 ------------------     -------------------------     ----------------
| Your content app | = | Lokalise content engine | + | Your connector |
 ------------------     -------------------------     ----------------  
```

In this repository you will find **PHP code that you can use as a template** for your Lokalise content exchange connector. 

- The technical requirements of a connector are detailed on [Lokalise Developer Hub](https://developers.lokalise.com/docs/technical-requirements-content-exchange-hosted-connector).
- The [OpenAPI schema](schema.yaml) describes the endpoints that must be served by a connector. 



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

1. If your connector uses _OAuth2_ authorization, then add the following parameters to the `.env.local` file with the
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
    
    In response all DateTime fields from [CacheItemFields](src/Integration/DTO/CacheItemFields.php) DTO should be converted in format `yyyy-mm-dd`
4. Implement the logic of your connectors in services located in the [Service](src/Integration/Service/) folder. These
   services should implement the interfaces specified in [this](src/Interfaces/Service/) folder.

## How to run tests

Run `make tests` in command line.

## How to run code fixer

We follow Symfony coding standards. For this we use the [PHP CS Fixer](https://cs.symfony.com/) tool. To check and fix
the code run `make format` in command line.

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
* `make format` - fixes code according to Symfony coding standards
* `make build-prod` - build or rebuild services for prod
* `make up-prod` - create and start containers for prod

