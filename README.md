# LaVa

CMS on Laravel 8

## Установка

1. git clone
2. composer install
3. php artisan key:generate
4. Права на 0777 на папку storage и public/uploads
5. Прописать пароли на базу в .env
6. php artisan migrate
7. Идем в database/seeds/DatabaseSeeder.php и прописываем там наши логин и пароль в админку
8. php artisan db:seed

Вход в админку: url.com/admin_panel