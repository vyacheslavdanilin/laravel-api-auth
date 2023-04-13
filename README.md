## Laravel Auth API

# Run

`cp .env.example .env`

`docker-compose up -d`

`docker-compose exec php-fpm php artisan key:generate && docker-compose exec php-fpm php artisan migrate`

# Stop

`docker-compose down`