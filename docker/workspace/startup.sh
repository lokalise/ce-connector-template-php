#!/bin/sh

cd "$APP_CODE_PATH_CONTAINER" || exit

composer install --no-interaction

composer dump-autoload --optimize
composer check-platform-reqs
php "$APP_CODE_PATH_CONTAINER/bin/console" cache:warmup

rr serve
