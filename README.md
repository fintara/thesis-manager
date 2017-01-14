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

## Pull
0. `git pull`
1. `php bin/console assets:install`
2. `php bin/console assetic:dump`
3. `php bin/console doctrine:migrations:migrate`

## Contribution
0. Create new branch from `develop`: `git checkout -b feature-name`
1. Implement it, `commit`ing the more important checkpoints.
2. Push it to github `git push -u origin feature-name`
3. Repeat 1. and 2. as many times as needed.
4. When finished, create a Pull request with base `develop` and your branch.

## Load data
0. `bin/console doctrine:fixtures:load [--append]` 

