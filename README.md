# Connector Template PHP

Если у вас есть контент который необходимо перевести то локалайз может предоставить вам юай интервейс управления переводами вашего контента.
для этого вам нужно реализовать конектор. В качестве шаблона может быть использован данный репозиторий.

This Connector Template позволяет создать приложение которое will act as a bridge between the content platform and Lokalise content engine, and will enable users to connect both systems, select the content they want to translate, transfer it to Lokalise, see the translation status, and receive the translated content back. Read more about the technical implementation requirements.
Требования которые реализует данный конектор находятся в данной статье https://developers.lokalise.com/docs/technical-requirements-content-exchange-hosted-connector.
Данный темплейт конектор реализует апи https://developers.lokalise.com/docs/technical-requirements-content-exchange-hosted-connector#connector-api-beta.

##Стек технологий
php 8.1
symfony 6.1
phpunit 9.5
roadrunner 2
composer latest

preinstall
docker latest
docker-compose latest


## How to start the project

1.  In root project folder copy `.env` file and name it as `.env.local`.
2. Run `make init` in command line.

##настройка конфигураций для вашего конектора

если ваш конектор использует OAuth2 авторизацию, то в файл .env.local добавте следующие параметры с нужными значениями:
```
PLATFORM_CLIENT_ID=
PLATFORM_CLIENT_SECRET=
```
зайдите в config/services.yaml файл

если ваш конектор использует apiKey авторизацию, то задайте следующие значения:
```yaml
services:
    _defaults:
        bind:
            App\Enum\AuthTypeEnum $defaultAuthType: !php/const App\Enum\AuthTypeEnum::apiKey
```

если ваш конектор использует OAuth2 авторизацию, то задайте следующие значения:
```yaml
services:
    _defaults:
        bind:
          App\Enum\AuthTypeEnum $defaultAuthType: !php/const App\Enum\AuthTypeEnum::OAuth
          App\Enum\OAuthResponseParamsEnum $defaultOAuthResponseParams: !php/const App\Enum\OAuthResponseParamsEnum::query
          string $platformClientId: '%env(PLATFORM_CLIENT_ID)%'
          string $platformClientSecret: '%env(PLATFORM_CLIENT_SECRET)%'
```
Перейдите в папку src/Integration/DTO/ и задайте нужные для вашего конектора парметры для классов, которые перечислены в этой папке.

Реализуйте логику ваших конекторов в сервисах которые находятся в папке src/Integration/Service/. Данные сервисы должны реализовывать интерфейсы указанные в папке src/Interfaces/Service/.

## How to run tests

Run `make tests` in command line.


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
```
make build
make up
make start
make down
make destroy
make stop
make restart
make init
make tests
make build-prod
make up-prod
```
