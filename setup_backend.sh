#!/bin/bash

# Move into backend directory
cd "$(dirname "$0")"

echo "=============================================="
echo "Setting up Laravel Subscription Backend..."
echo "=============================================="

# 1. Install Composer dependencies
echo "Installing PHP dependencies via Composer..."
composer install --no-interaction

# 2. Setup Environment configuration
if [ ! -f .env ]; then
    echo "Creating .env configuration..."
    copy ".env.example" ".env" 2>/dev/null || cp ".env.example" ".env"
fi

# 3. Create SQLite Database file
echo "Configuring SQLite database..."
touch database/database.sqlite

# Configure SQLite in env
if [[ "$OSTYPE" == "darwin"* ]]; then
    # MacOS compatibility for sed
    sed -i '' 's/DB_CONNECTION=mysql/DB_CONNECTION=sqlite/' .env
    sed -i '' 's/# DB_DATABASE=laravel/DB_DATABASE=database\/database.sqlite/' .env
    sed -i '' '/DB_HOST=/d' .env
    sed -i '' '/DB_PORT=/d' .env
    sed -i '' '/DB_USERNAME=/d' .env
    sed -i '' '/DB_PASSWORD=/d' .env
else
    sed -i 's/DB_CONNECTION=mysql/DB_CONNECTION=sqlite/' .env
    sed -i 's/# DB_DATABASE=laravel/DB_DATABASE=database\/database.sqlite/' .env
    sed -i '/DB_HOST=/d' .env
    sed -i '/DB_PORT=/d' .env
    sed -i '/DB_USERNAME=/d' .env
    sed -i '/DB_PASSWORD=/d' .env
fi

# 4. Generate app key
echo "Generating encryption key..."
php artisan key:generate

# 5. Run migrations & seed subscription plans
echo "Running migrations & seeding subscription database..."
php artisan migrate:fresh --seed

echo "=============================================="
echo "SETUP COMPLETED SUCCESSFULLY!"
echo "=============================================="
echo "To run the server, use: php artisan serve"
echo "Or start it now by running the following command:"
echo "php artisan serve"
echo "=============================================="
