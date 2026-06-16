# Запуск проекта

## Установка
```bash
composer install
php artisan key:generate
php artisan migrate --seed
```

## Запуск
```bash
php artisan serve
```

## Админ
- admin@example.com / password

## Файлы
- Обложки: `storage/app/public/covers` (через `php artisan storage:link`)
- PDF: `storage/app/private/comics` (скачивание только после покупки)
