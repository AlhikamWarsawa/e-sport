# Install

copy:
	cp .env.example .env

install:
	@echo "Starting full installation"
	docker compose up -d
	@echo "Waiting for containers..."
	sleep 5

	@echo "Installing PHP dependencies"
	docker exec -it laravel_app composer install

	@echo "Generating app key"
	docker exec -it laravel_app php artisan key:generate

	@echo "Running migrations"
	docker exec -it laravel_app php artisan migrate --force

	@echo "Installation complete"

# Git Shortcut (Main Push)
g:
	git pull
	git add .
	git commit -m "Email Automation"
	git push -u origin main

# CMD Laravel Pake Ini
app:
	docker exec -it laravel_app bash

# Docker Commands

up:
	docker compose up -d

down:
	docker compose down

restart:
	docker compose down && docker compose up -d

mysql:
	docker exec -it mysql_laravel mysql -u root -p

# Laravel Commands

migrate:
	docker exec -it laravel_app php artisan migrate:fresh
	docker exec -it laravel_app php artisan migrate

serve:
	docker exec -it laravel_app php artisan serve --host=0.0.0.0 --port=8000

start:
	docker compose up -d
	docker exec -it laravel_app php artisan serve --host=0.0.0.0 --port=8000

refresh:
	docker exec -it laravel_app php artisan optimize:clear

tinker:
	docker exec -it laravel_app php artisan tinker

tunnel:
	ngrok start web1
