install:
	@make build
	@make up
	docker-compose exec app_pasanaku composer install
	docker-compose exec app_pasanaku cp .env.example .env
	docker-compose exec app_pasanaku php artisan key:generate
	docker-compose exec app_pasanaku php artisan storage:link
	docker-compose exec app_pasanaku chmod -R 777 storage bootstrap/cache
	docker-compose exec db_pasanaku cp /etc/postgresql/postgresql.conf /var/lib/postgresql/data/postgresql.conf
	@make fresh
up:
	docker-compose up -d
build:
	docker-compose build
fresh:
	docker-compose exec app_pasanaku php artisan migrate:fresh --seed
