DC = docker compose
COMPOSE_FILE = .devcontainer/docker-compose.yml

up:
	$(DC) -f $(COMPOSE_FILE) up -d --build

down:
	$(DC) -f $(COMPOSE_FILE) down

shell:
	$(DC) -f $(COMPOSE_FILE) exec app bash

composer-install:
	$(DC) -f $(COMPOSE_FILE) exec app composer install

composer-update:
	$(DC) -f $(COMPOSE_FILE) exec app composer update

test:
	$(DC) -f $(COMPOSE_FILE) exec app ./vendor/bin/phpunit

.PHONY: up down shell composer-install composer-update test
