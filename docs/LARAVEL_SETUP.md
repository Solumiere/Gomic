# Поднятие проекта Laravel (Gomic)

> В репозитории лежит прикладной код (модели/контроллеры/миграции/Blade), но **vendor не коммитится**.

## Вариант A (рекомендуется): установить как обычный Laravel-проект

### 1) Склонировать репозиторий

### 2) Установить зависимости
```bash
composer install
npm install
```

Если `composer install` ругается, что нет `artisan`/`bootstrap` — значит в корне ещё нет базового Laravel skeleton.
Тогда используй Вариант B.

## Вариант B: создать Laravel skeleton и наложить код
1) В пустой папке:
```bash
composer create-project laravel/laravel gomic
```
2) Скопировать содержимое этого репозитория поверх (с заменой файлов в папках `app/`, `database/`, `routes/`, `resources/`).
3) Настроить `.env` и выполнить:
```bash
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
```

## Admin
- `admin@example.com` / `password`

## Правила доступа
- PDF скачивание и отзывы доступны только после покупки (paid-заказ содержит этот комикс).
