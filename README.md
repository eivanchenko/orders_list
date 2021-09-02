OrderList Project
================
How use:
```
git clone https://github.com/eivanchenko/orders_list.git ordersApp
rm -rf ordersApp/.git
```
# Init Composer packages
```
cd ordersApp/build
```
To add a package run:
```
docker-compose run --rm composer require some/library
```
To update all packages run:
```
docker-compose run --rm composer update
```
This will update composer.json and composer.lock respectively. You can also run other composer commands, of course.

# Build the Base Image
```
# In the ./build directory run:

docker-compose run --rm composer install
```
Then you can build the base image:
```
docker-compose build
```
# Initial Setup
```
cd ordersApp
cp docker-compose-example.yml docker-compose.yml
cp .env-example .env
docker-compose up -d
```
Wait some seconds to let the DB container fire up ... and run:

# Adds the vendor folder
```
docker-compose exec web cp -rf /var/www/vendor ./

docker-compose exec web chgrp www-data web/assets runtime 
docker-compose exec web chmod g+rwx web/assets runtime

```
When done, you can access the new app from http://localhost:8080/orders.
