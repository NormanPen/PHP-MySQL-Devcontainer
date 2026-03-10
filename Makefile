DC = docker compose
COMPOSE_FILE = .devcontainer/docker-compose.yml

up:
	$(DC) -f $(COMPOSE_FILE) up -d --build

down:
	$(DC) -f $(COMPOSE_FILE) down

.PHONY: up down
