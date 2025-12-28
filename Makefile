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
	docker exec -it laravel_app php artisan db:seed --class=SettingsSeeder

	@echo "Installation complete"

# Git Shortcut (Main Push)
g:
	git pull
	git add .
	git commit -m "Documentation + Terraform"
	git push -u origin main

# Use Command
app:
	docker exec -it laravel_app bash

# Other
tunnel:
	ngrok start web1
