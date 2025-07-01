# Backend setup (Laravel)

composer install

cp .env.example .env

php artisan migrate --seed

php artisan serve

# Meilisearch (Docker)

docker run -d --name meilisearch -p 7700:7700 getmeili/meilisearch

php artisan scout:import App\\Models\\Customers
