.DEFAULT_GOAL := up

build:
	docker-compose -f docker-compose.yml --env-file .env.local build development_workspace $(c)
up:
	docker-compose -f docker-compose.yml --env-file .env.local up -d development_workspace $(c)
start:
	docker-compose -f docker-compose.yml start $(c)
down:
	docker-compose -f docker-compose.yml down --remove-orphans $(c)
destroy:
	docker-compose -f docker-compose.yml down --remove-orphans -v $(c)
stop:
	docker-compose -f docker-compose.yml stop $(c)
restart: stop up
init: build up

build-prod:
	docker-compose -f docker-compose.yml --env-file .env.local build production_workspace $(c)
up-prod: build-prod
	docker-compose -f docker-compose.yml --env-file .env.local up -d production_workspace $(c)