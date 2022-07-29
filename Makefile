build:
	docker-compose -f docker-compose.yml --env-file .env.local build $(c)
up:
	docker-compose -f docker-compose.yml --env-file .env.local up -d $(c)
start:
	docker-compose -f docker-compose.yml start $(c)
down:
	docker-compose -f docker-compose.yml down $(c)
destroy:
	docker-compose -f docker-compose.yml down -v $(c)
stop:
	docker-compose -f docker-compose.yml stop $(c)
restart:
	docker-compose -f docker-compose.yml stop $(c)
	docker-compose -f docker-compose.yml --env-file .env.local up -d $(c)
init:
	docker-compose -f docker-compose.yml --env-file .env.local up -d --build $(c)
	docker-compose -f docker-compose.yml exec workspace composer install -n $(c)

dpl ?= .env.local
include $(dpl)
export $(shell sed 's/=.*//' $(dpl))

build-prod:
	docker build --build-arg PHP_VERSION=$(PHP_VERSION) -t $(APP_NAME) .
up-prod: build-prod
	docker run -i -t --rm -p=$(NGINX_HOST_HTTP_PORT):8080 --name="$(APP_NAME)" $(APP_NAME)