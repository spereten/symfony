up:
	php bin/console make:migration --no-interaction && php bin/console doctrine:migrations:migrate --no-interaction && php bin/console doctrine:fixtures:load --no-interaction

down:
	php fix.php && php bin/console  doctrine:migrations:migrate first --no-interaction && php -r "array_map('unlink', array_filter((array) glob('./migrations/*')));"

r: down up
