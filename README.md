## Как пользоваться

```
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
```
Авторизация сделана на сессиях в файлах `SESSION_DRIVER=file`

БД - SqlLite

### Запуск веб сервера и фронта
```
php artisan serve

npm install
npm run dev
```

### Создание пользователя
```
php artisan user:add user1 user@test.ru 12345678
```

### Добавление транзакции
```
php artisan transaction:perform user@test.ru 10 test
# Для отрицательных числел добавляем --
php artisan transaction:perform user@test.ru -- -11 test
```

### Обработка транзакций через очередь
```
php artisan queue:work --queue=transactions
```
