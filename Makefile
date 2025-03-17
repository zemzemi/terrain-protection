# Variables
sail := ./vendor/bin/sail
service := app  # Laravel service name in docker-compose.yml

# Reusable command shortcuts
artisan = $(sail) artisan
composer = $(sail) composer
npm = $(sail) npm

.PHONY: dotenv
dotenv:
	@echo "🔍 Checking for .env file..."
	@[ ! -f .env ] && cp .env.example .env || echo "✅ .env file already exists."

.PHONY: sail-install
sail-install:
	@echo "🔍 Checking for Laravel Sail installation..."
	@if [ ! -f "vendor/bin/sail" ]; then \
		echo "Installing Laravel Sail..."; \
		docker run --rm -v $(PWD):/app composer install; \
		php artisan sail:install --no-interaction --with=none; \
		echo "Sail installation complete!"; \
	else \
		echo "Laravel Sail is already installed."; \
	fi

.PHONY: install-dependencies
install-dependencies: dotenv sail-install
	@echo "Starting Docker environment..."
	$(sail) up -d
	$(composer) install
	$(artisan) key:generate
	$(npm) install
	$(npm) run dev
	@echo "Installation complete!"

.PHONY: start
start:
	@echo "Starting containers..."
	$(sail) up -d
	$(npm) run dev

.PHONY: stop
stop:
	@echo "Stopping containers..."
	$(sail) stop

.PHONY: restart
restart:
	@echo "Restarting containers..."
	$(sail) restart

.PHONY: down
down:
	@echo "Stopping and removing containers..."
	$(sail) down

.PHONY: rm
rm:
	@echo "Removing containers and volumes..."
	$(sail) down -v

.PHONY: dev
dev:
	$(sail) npm run dev

.PHONY: bash
bash:
	@echo "Opening a shell inside the container..."
	$(sail) shell

.PHONY: tinker
tinker:
	@echo "Launching Tinker..."
	$(artisan) tinker

.PHONY: cache-clear
cache-clear:
	@echo "🧹 Clearing Laravel cache..."
	$(artisan) cache:clear
	$(artisan) config:clear
	$(artisan) view:clear
	$(artisan) route:clear
	$(artisan) config:cache

.PHONY: backend-install
backend-install:
	@echo "Installing backend dependencies..."
	$(composer) install

.PHONY: frontend-install
frontend-install:
	@echo "Installing frontend dependencies..."
	$(npm) install
	$(npm) run dev

.PHONY: frontend-clean
frontend-clean:
	@echo "🧹 Cleaning frontend dependencies..."
	rm -rf node_modules package-lock.json 2>/dev/null || true

.PHONY: clean-cache
clean-cache:
	$(sail) artisan config:cache
	$(sail) artisan view:clear
	$(sail) artisan route:clear
	$(sail) artisan config:clear

.PHONY: test
test:
	@echo "Running tests..."
	$(artisan) test

.PHONY: pint
pint:
	@echo "Running Pint (code formatting)..."
	$(composer) pint

.PHONY: logs
logs:
	@echo "Viewing real-time logs..."
	$(sail) logs -f

.PHONY: reset
reinstall:
	@echo "Resetting the entire project..."
	$(sail) down -v
	rm -rf vendor node_modules
	make install-dependencies
