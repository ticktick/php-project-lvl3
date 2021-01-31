install:
	composer install
	cp -n .env.example .env|| true
	php artisan key:gen --ansi
	php artisan migrate

serve:
	php artisan serve --host 0.0.0.0

lint:
	composer run-script phpcs -- --standard=PSR12 app tests

test:
	composer run-script phpunit tests