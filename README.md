OrderList Project
================
## Get project:
```
git clone https://github.com/eivanchenko/orders_list.git ordersApp
rm -rf ordersApp/.git
```
## Init Composer packages
```
cd ordersApp
```
To update all packages run:
```
composer update
```
This will update composer.json and composer.lock respectively. You can also run other composer commands, of course.

To install vendor  folder run:
```
composer install
```

## Build the Base Image

```
cd build/
```
In the ./build directory run:
```
docker-compose build
```
## Initial Setup
```
cd ../
cp docker-compose-example.yml docker-compose.yml
cp .env-example .env
docker-compose up -d
```
Wait some seconds to let the DB container fire up ...


When done, you can access the new app from http://localhost:8080/orders.