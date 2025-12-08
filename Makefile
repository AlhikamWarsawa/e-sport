# Install

install:
	@echo "Starting full installation"
	docker compose up -d
	@echo "Waiting for MySQL to be ready..."
	sleep 10
	docker exec -it laravel_app bash -c "cp .env.example .env"
	docker exec -it laravel_app php artisan key:generate
	docker exec -it laravel_app php artisan migrate
	@echo "Running Laravel server..."
	docker exec -it laravel_app php artisan serve --host=0.0.0.0

# Git Shortcut (Main Push)
g:
	git pull
	git add .
	git commit -m "final news for member"
	git push -u origin main

# Docker Commands

up:
	docker compose up -d

down:
	docker compose down

restart:
	docker compose down && docker compose up -d

app:
	docker exec -it laravel_app bash

mysql:
	docker exec -it mysql_laravel mysql -u root -p

# Laravel Commands

migrate:
	docker exec -it laravel_app php artisan migrate

serve:
	docker exec -it laravel_app php artisan serve --host=0.0.0.0

start:
	docker compose up -d
	docker exec -it laravel_app php artisan serve --host=0.0.0.0
