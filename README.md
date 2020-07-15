PHP fpm basic configuration with a very simple DDD architecture sample

- Create file .env with your ip address based on .env.dist
- docker-compose up
- docker exec -i -t miquel.php-fpm composer install
- docker exec -i -t miquel.php-fpm vendor/bin/behat
- docker exec -i -t miquel.php-fpm vendor/bin/phpunit
- php /app/bin/console user:create miquel
