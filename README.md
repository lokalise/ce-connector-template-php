# Connector Template PHP


## How to start the project

1. Make sure you have installed docker, docker-compose, make on your local machine.
2. In root project folder copy `.env` file and name it as `.env.local`.
3. Run `make init` in command line.


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
