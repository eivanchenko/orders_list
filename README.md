OrderList Project
================
How use:
```
git clone https://github.com/eivanchenko/orders_list.git ordersApp
rm -rf ordersApp/.git
cd ordersApp
cp docker-compose-example.yml docker-compose.yml
cp .env-example .env
docker-compose up -d

# Wait some seconds to let the DB container fire up ...

docker-compose exec web chgrp www-data web/assets runtime 
docker-compose exec web chmod g+rwx web/assets runtime

```
When done, you can access the new app from http://localhost:8080.
