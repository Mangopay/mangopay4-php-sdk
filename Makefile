# Project-scoped Composer config: the Nexus mirror applies ONLY to this
# project, never to other PHP projects on the same machine.
export COMPOSER_HOME := $(CURDIR)/.composer-home

# Load local secrets/config from .env if present (gitignored). The leading `-`
# means "don't fail if the file is missing"
-include .env
export

# NEXUS_URL must be provided via .env or the environment (see .env.example)
NEXUS_URL ?=

.PHONY: composer-config install test lint

composer-config:
	@test -n "$(NEXUS_URL)" || { echo "NEXUS_URL is not set."; exit 1; }
	composer config -g repositories.packagist composer "$(NEXUS_URL)"

install: composer-config
	composer install --no-interaction --no-progress --prefer-dist

test:
	vendor/bin/phpunit

lint:
	vendor/bin/php-cs-fixer fix --dry-run --diff
