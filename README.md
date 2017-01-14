Thesis Manager 2000
=

A Symfony project created on December 23, 2016, 10:23 am.

## Install
1. clone this repo
2. `composer install`
3. `php bin/console assetic:dump`
3. `php bin/console server:start`
4. open `127.0.0.1:8080` in your browser

## Migrations
0. `bin/console doctrine:schema:update --dump-sql` make sure everything is ok
1. `bin/console doctrine:migrations:diff`
2. `bin/console doctrine:migrations:migrate`

## Load data
0. `bin/console doctrine:fixtures:load [--append]` 

