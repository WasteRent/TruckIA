yarn install
npm run prod
composer install --no-dev && composer update --no-dev
php artisan migrate --force
php artisan route:cache
php artisan config:cache
php artisan view:cache
composer dump --optimize