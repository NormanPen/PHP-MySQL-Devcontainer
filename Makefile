DC = docker compose
COMPOSE_FILE = docker-compose.yml

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

testdox:
	$(DC) -f $(COMPOSE_FILE) exec app ./vendor/bin/phpunit --testdox

db-init:
	$(DC) -f $(COMPOSE_FILE) exec app php scripts/db-init.php

db-tables:
	$(DC) -f $(COMPOSE_FILE) exec app php scripts/db-tables.php

db-add-user:
	$(DC) -f $(COMPOSE_FILE) exec -it app php scripts/db-add-user.php

db-list-users:
	$(DC) -f $(COMPOSE_FILE) exec app php scripts/db-list-users.php

.PHONY: up down shell composer-install composer-update test testdox db-init db-tables db-add-user db-list-users
