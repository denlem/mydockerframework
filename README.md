### Запуск проекта

```php
cp .env.test .env
docker-compose up --build -d
cd myframework
# cp .env.test .env
```

Чтобы войти в любой из контейнеров, делаем следующее:
```php
docker exec -it <container_name> bash
docker exec -it myframework-app-php-cli bash
```

Посмотреть запущенные контейнеры:
```php
docker ps
```

Логи контейнера:
```php
docker logs <container_name>
```

Настройки композера:
```php
composer require symfony/http-foundation
composer require symfony/routing
composer require symfony/http-kernel
```

Ссылка для запуска проекта:
```php
http://localhost:8083/is_leap_year/2222
```

Изменение прав папок:
```php
1. Изменение пользователя папки и файлов
   sudo chown -R denis:denis /var/www/darix
   sudo chown -R user:group /home/user/dir/
2. Изменение прав папки и файлов
   sudo chmod -R 777 /var/www/darix/serv
```