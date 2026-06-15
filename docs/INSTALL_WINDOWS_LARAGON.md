# Установка (Windows 11 + Laragon)

## Требования
- Laragon (Apache/Nginx + MySQL)
- PHP 8.2+
- Composer 2.7+
- Node.js 20+

## Шаги
1) Клонировать репозиторий
2) Установить зависимости
   - `composer install`
   - `npm install`
3) Скопировать env
   - `copy .env.example .env`
   - настроить `DB_*`
4) Сгенерировать ключ
   - `php artisan key:generate`
5) Миграции и сиды
   - `php artisan migrate --seed`
6) Запуск
   - `php artisan serve`

## Данные администратора
- email: `admin@example.com`
- password: `password`
