# Executables (local)
DOCKER_COMP_DEV = docker compose -f docker-compose.yml -f docker-compose.override.yml
DOCKER_COMP_PROD = sudo docker-compose -f docker-compose.yml -f docker-compose.prod.yml -f docker-compose.backup.yml

# Docker containers
PHP_CONT = $(DOCKER_COMP_DEV) exec php

# Executables
PHP      = $(PHP_CONT) php
COMPOSER = $(PHP_CONT) composer
SYMFONY  = $(PHP_CONT) bin/console

# Misc
.DEFAULT_GOAL = help
.PHONY        = help build up start down logs sh composer vendor sf cc backup

## —— 🎵 🐳 The Symfony Docker Makefile 🐳 🎵 ——————————————————————————————————
help: ## Outputs this help screen
	@grep -E '(^[a-zA-Z0-9_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}{printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'

## —— Docker 🐳 ————————————————————————————————————————————————————————————————
build: ## Builds the Docker images
	@$(DOCKER_COMP_DEV) build --pull #--no-cache

up: ## Start the docker hub in detached mode (no logs)
	@$(DOCKER_COMP_DEV) up --detach

start: build up ## Build and start the containers

down: ## Stop the docker hub
	@$(DOCKER_COMP_DEV) down --remove-orphans

logs: ## Show live logs
	@$(DOCKER_COMP_DEV) logs --tail=10 --follow

sh: ## Connect to the PHP FPM container
	@$(PHP_CONT) sh

## —— Composer 🧙 ——————————————————————————————————————————————————————————————
composer: ## Run composer, pass the parameter "c=" to run a given command, example: make composer c='req symfony/orm-pack'
	@$(eval c ?=)
	@$(COMPOSER) $(c)

vendor: ## Install vendors according to the current composer.lock file
vendor: c=install --prefer-dist --no-dev --no-progress --no-scripts --no-interaction
vendor: composer

## —— Symfony 🎵 ———————————————————————————————————————————————————————————————
sf: ## List all Symfony commands or pass the parameter "c=" to run a given command, example: make sf c=about
	@$(eval c ?=)
	@$(SYMFONY) $(c)

cc: c=c:c ## Clear the cache
cc: sf


## —— Prod ——————————————————————————————————————————————————————————————
backup: ## Backup prod db
	$(DOCKER_COMP_PROD)  exec backup ./backup.sh
git-pull:
	git pull
start-prod: ## Prod docker up -d
	$(DOCKER_COMP_PROD)  up --build -d
update-prod: backup git-pull start-prod ## Backup, git pull & docker up



check: lint-container ecs phpstan
lint-container:
	bin/console lint:container
ecs:
	vendor/bin/ecs --fix || true
phpstan:
	vendor/bin/phpstan --memory-limit=256M
