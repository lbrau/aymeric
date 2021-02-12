build_docker: build up install

build:
	docker-compose build --build-arg USER=${USER} --build-arg UID=${UID} php

up:
	docker-compose up -d

down:
	docker-compose down

ssh:
	docker exec -it php_messenger bash

install: composer

start: down up build-db db-data

build-db:
	docker exec -ti sf4_api_php bash -c "bin/console doc:mig:mig --no-interaction"

db-data:
	docker exec -ti sf4_api_php bash -c "bin/console doc:fix:load --no-interaction"

full-db:  build-db db-data pop

composer:
	composer install

pop:
	docker exec -ti sf4_api_php bash -c "bin/console fos:elas:pop"
#composer:
#	docker exec -i php_messenger bash -c 'composer install --no-interaction -o'

setfacl:
	setfacl -dR -m u:"www-data":rwX -m u:$(whoami):rwX var
	setfacl -R -m u:"www-data":rwX -m u:$(whoami):rwX var

stop:
	-docker-compose stop

cache:
	docker exec -i php_messenger bash -c 'bin/console cache:clear --no-warmup && bin/console cache:warmup'

cache_all:
	docker exec -i php_messenger bash -c 'bin/console cache:clear --no-warmup --env dev && bin/console cache:warmup --env dev && bin/console cache:clear --no-warmup --env=test && bin/console cache:warmup --env=test && bin/console cache:clear --no-warmup --env prod && bin/console cache:warmup --env prod'

clean_docker:
	docker image prune --force && docker container prune --force

test_phpunit:
	docker exec -it php_factory_method bash -c 'vendor/bin/phpunit'

tests: test_phpunit test_behat

start_project:
	bin/console doc:mig:mig --no-interaction
	bin/console doc:fix:load --no-interaction

php:
	docker exec -ti sf4_api_php bash

consume:
	docker exec -ti sf4_api_php bash -c "bin/console messenger:consume -vvv"

.PHONY: build up ssh install composer setfacl database stop cache cache_all clean_docker behat phpunit tests
