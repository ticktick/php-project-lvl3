install:
	composer install

test-coverage:
	composer run-script phpunit tests -- --coverage-clover build/logs/clover.xml

start:
	make -C src serve

lint:
	make -C src lint

test:
	make -C src test

compose:
	docker-compose up

compose-bash:
	docker-compose run php bash

compose-setup: compose-build
	docker-compose run php make setup

compose-build:
	docker-compose build

compose-db:
	docker-compose exec db psql -U postgres

compose-down:
	docker-compose down -v
