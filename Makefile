ROOT_DIR       := $(shell dirname $(realpath $(lastword $(MAKEFILE_LIST))))
VARIABLES_FILE  = $(ROOT_DIR)/variables.env
VENDOR_FOLDER  = $(ROOT_DIR)/symfony/vendor
SHELL          := $(shell which bash)
VERSION         = 2.3.0
ARGS            = $(filter-out $@,$(MAKECMDGOALS))

.SILENT: ;               # no need for @
.ONESHELL: ;             # recipes execute in same shell
.NOTPARALLEL: ;          # wait for this target to finish
.EXPORT_ALL_VARIABLES: ; # send all vars to shell
default: help-default;   # default target
Makefile: ;              # skip prerequisite discovery

.title:
	$(info Verdict Compose)
	$(info )

help-default help: .title
	@echo "                          ====================================================================="
	@echo "                          Help & Check Menu"
	@echo "                          ====================================================================="
	@echo "                    help: Show Verdict Compose Help Menu: type: make help"
	@echo "                   check: Check required files"
	@echo "                  status: List containers status"
	@echo "                 version: Show versions"
	@echo "                          ====================================================================="
	@echo "                          Main Menu"
	@echo "                          ====================================================================="
	@echo "                      up: Create and start application in detached mode (in the background)"
	@echo "                    pull: Pull latest dependencies"
	@echo "                    stop: Stop application"
	@echo "                   root:  Login to the 'php' container as 'root' user"
	@echo "                   start: Start application"
	@echo "                   build: Build or rebuild services"
	@echo "                   reset: Reset all containers, delete all data, rebuild services and restart"
	@echo ""

build: check
	docker-compose build --no-cache

pull:
	docker pull mongo:3.2
	docker pull postgres:9.5
	docker pull mysql:5.7
	docker pull memcached:1.4
	docker pull aerospike:latest
	docker pull redis:latest
	docker pull elasticsearch:2.3
	docker pull jeroenpeeters/docker-ssh:latest
	docker pull phalconphp/beanstalkd:1.10
	docker pull phalconphp/php-apache:ubuntu-16.04

up: check
	docker-compose up -d
	make composer-install

start: check
	docker-compose start

stop:
	docker-compose stop

status:
	docker-compose ps

reset: check stop clean build up

clear-cache:
	docker exec $$(docker-compose ps -q php) php bin/console cache:clear
	docker exec $$(docker-compose ps -q php) php bin/console assets:install

doctrine-schema-create:
	docker exec $$(docker-compose ps -q php) php bin/console doctrine:schema:create

doctrine-schema-update:
	docker exec $$(docker-compose ps -q php) php bin/console doctrine:schema:update

doctrine-forse-update:
	docker exec $$(docker-compose ps -q php) php bin/console doctrine:schema:update --force

create-admin-user:
	php bin/console fos:user:create admin --super-admin

check:
ifeq ($(wildcard $(VARIABLES_FILE)),)
	$(error Failed to locate the $(VARIABLES_FILE) file.)
endif
	docker-compose config -q

composer-install:
ifeq ($(wildcard $(VENDOR_FOLDER)),)
	echo 'Installing required Symfony dependencies'
	docker exec $$(docker-compose ps -q php) composer install
	make clear-cache
	make doctrine-schema-create
endif
	docker-compose config -q

fix-permissions:
	docker exec $$(docker-compose ps -q php) HTTPDUSER=$(ps axo user,comm | grep -E '[a]pache|[h]ttpd|[_]www|[w]ww-data|[n]ginx' | grep -v root | head -1 | cut -d\  -f1)
	docker exec $$(docker-compose ps -q php) setfacl -dR -m u:"$HTTPDUSER":rwX -m u:$(whoami):rwX var
	docker exec $$(docker-compose ps -q php) setfacl -R -m u:"$HTTPDUSER":rwX -m u:$(whoami):rwX var

bash:
	docker exec -it -u 1000 $$(docker-compose ps -q php) /bin/bash

root:
	docker exec -it -u root $$(docker-compose ps -q php) /bin/bash

init-yii:
	cd $(ROOT_DIR)/symfony
	composer --no-progress --prefer-dist install
	composer update
	cd $(ROOT_DIR)
	docker exec -it -u root $$(docker-compose ps -q php) /var/www/symfony/init --env=Development --overwrite=y
	docker exec -it -u root $$(docker-compose ps -q php) /var/www/symfony/yii migrate --migrationPath=@yii/rbac/migrations --interactive=0
	docker exec -it -u root $$(docker-compose ps -q php) /var/www/symfony/yii rbac/init
	docker exec -it -u root $$(docker-compose ps -q php) /var/www/symfony/yii migrate --interactive=0

mup:
	docker exec -it -u root $$(docker-compose ps -q php) /var/www/symfony/yii migrate --interactive=0

mto:
	docker exec -it -u root $$(docker-compose ps -q php) /var/www/symfony/yii migrate/to $(ARGS)

mcreate:
	docker exec -it -u 1000 $$(docker-compose ps -q php) /var/www/symfony/yii migrate/create $(ARGS)

mdown:
	docker exec -it -u root $$(docker-compose ps -q php) /var/www/symfony/yii migrate/down $(ARGS)

clean: stop
	docker-compose down

%:
	@:
