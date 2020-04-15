#php artisan view:cache
yarn install
npm run prod
composer update --no-dev --optimize-autoloader
php artisan migrate --force
#php artisan route:cache
#php artisan config:cache