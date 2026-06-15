# Техническая спецификация проекта Gomic (интернет-магазин комиксов)

## Стек
- Laravel 11, PHP 8.2+
- MySQL 8.4 LTS
- Blade UI (Bootstrap или Tailwind)

## Роли
- User
- Admin

## Сущности (БД)
### comics
- id
- title (string)
- description (text)
- price (decimal)
- cover_image_path (nullable)
- pdf_path (string) — приватное хранилище
- created_at/updated_at

### users
- стандартная таблица Laravel
- is_admin (boolean)

### carts (опционально)
Вариант А (проще): корзина в session.
Вариант B: carts + cart_items.

### orders
- id
- user_id
- status (created|paid|cancelled|completed)
- total (decimal)
- created_at/updated_at

### order_items
- id
- order_id
- comic_id
- price (decimal) — фиксируется на момент покупки
- qty (int, обычно 1)

### reviews
- id
- user_id
- comic_id
- rating (1..5)
- body (text)
- created_at/updated_at

## Ключевые правила доступа
- PDF скачивание: только auth и только если у пользователя есть PAID заказ с этим comic.
- Отзывы: создавать можно только если купил (PAID заказ с этим comic).
- Админка: middleware admin.

## Основные роуты
- / (home)
- /comics (index, поиск, фильтры, сортировка)
- /comics/{comic} (show)
- /cart (view)
- POST /cart/add/{comic}
- POST /cart/remove/{comic}
- /checkout (оформление)
- POST /orders (создать заказ)
- POST /orders/{order}/pay (имитация оплаты -> status=paid)
- GET /comics/{comic}/download (скачать PDF)
- POST /comics/{comic}/reviews (создать отзыв)

### Admin
- /admin/comics (CRUD)
- /admin/orders (list + update status)
- /admin/reviews (list + delete)
