up: docker-up

stop: docker-stop

init: docker-clean docker-up php-composer-install php-migrate docker-prune

init-local: docker-clean docker-up-local php-composer-install php-migrate docker-prune

docker-clean:
	docker-compose down --remove-orphans

# Удаляет временные изображения, чистит кэши
# Из-за пересборки фронт сервера забивается место
docker-prune:
	docker system prune -f

docker-up:
	docker-compose up --build -d php-fpm postgres nginx redis workspace laravel-horizon swagger-ui mysql

docker-up-local:
	docker-compose up -d frontend-server
	docker-compose up --build -d php-fpm postgres nginx redis workspace laravel-horizon swagger-ui mysql

frontend-rebuild:
	docker-compose exec frontend_server npm install
	docker-compose exec frontend_server npm run build

docker-stop:
	docker-compose stop

php-composer-install:
	docker-compose exec --user=laradock workspace composer install

php-migrate:
	docker-compose exec --user=laradock workspace php artisan migrate

php-migrate-force:
	docker-compose exec --user=laradock workspace php artisan migrate --force

# Накатывает миграции эластика (создание индексов)
php-elastic-migrate:
	docker-compose exec --user=laradock workspace php artisan elastic:migrate

php-elastic-migrate-force:
	docker-compose exec --user=laradock workspace php artisan elastic:migrate --force

phpcs:
	docker-compose exec --user=laradock workspace vendor/bin/phpcs -n -s -p

# Проверка кода линтерами
php-lint: phpcs

php-ide-helper-generate:
	docker-compose exec workspace composer ide-helpers

workspace-connect:
	docker exec --user=laradock -it immunitet_workspace_1 bash

# Полная очистка кэша и перезапуск воркеров horizon
laravel-cache-clear:
	docker-compose exec --user=laradock workspace /bin/bash -c 'php artisan cache\:clear && php artisan view\:clear'
	docker-compose exec --user=laradock laravel-horizon /bin/sh -c 'php /var/www/artisan horizon\:terminate'

frontend-server-start:
	docker-compose up --build -d frontend-server

frontend-server-stop:
	docker-compose stop frontend-server

frontend-dev-server-start:
	docker-compose up --build -d frontend-dev-server

frontend-dev-server-stop:
	docker-compose stop frontend-dev-server

# Деплой на сервер
deploy: php-composer-install php-migrate-force php-elastic-migrate-force laravel-cache-clear frontend-server-start restart-swagger docker-prune

restart-swagger:
	docker-compose restart swagger-ui

# Создание кэша конфига (запускать на проде)
config-cache:
	docker-compose exec workspace php artisan config:cache

# Запуск тестов
test:
	docker-compose exec workspace php artisan test

# Обновление миграций и заполнение БД тестовыми данными
seed:
	docker-compose exec workspace /bin/bash -c 'php artisan migrate:fresh && php artisan db:seed'

# Файл дампа /root/.laradock/data/postgres/immunitet.dump
db-dump:
	docker-compose exec postgres /bin/bash -c 'pg_dump  --dbname=immunitet --host=postgres --port=5432 --user=immunitet --format=custom --file=/var/lib/postgresql/data/immunitet.dump'

# Залить дамп БД
# Файл кинуть в /root/.laradock/data/postgres/immunitet.dump (либо postgres12)
db-restore:
	docker-compose exec postgres /bin/bash -c 'pg_restore --clean --if-exists  --dbname=immunitet --host=postgres --port=5432 --user=immunitet /var/lib/postgresql/data/immunitet.dump'

# Reset to Dev
rd:
	git reset --hard HEAD
	git clean -d -f ../
	git checkout dev
	git pull origin dev
