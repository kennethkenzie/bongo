# Estate Bongo Online — Laravel API

## Setup

```bash
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite   # or configure MySQL
php artisan migrate --seed
php artisan storage:link         # required for product image uploads
php artisan serve
```

## Admin console

Visit `http://localhost:8000/admin`.

Two seeded accounts (password `password`):

| Email | Role | Access |
|---|---|---|
| `demo@estatebongo.com` | `admin` | Full /admin console |
| `shopper@estatebongo.com` | `customer` | Storefront only — gets a 403 on /admin |

Promote a user from tinker:

```bash
php artisan tinker
> App\Models\User::where('email','x@x.com')->update(['role' => 'admin']);
```

### Product images

The admin product form supports uploading a file from your computer
(stored on the `public` disk under `products/`) **or** pasting a remote
image URL. Run `php artisan storage:link` once so uploaded files are
served at `/storage/products/...`.

API runs at `http://localhost:8000/api/v1`.

## Key Endpoints

### Public
- `GET /api/v1/home` — homepage payload (categories, deals, recommended, trending)
- `GET /api/v1/categories` — list categories
- `GET /api/v1/categories/{slug}` — category with paginated products
- `GET /api/v1/products` — paginated products with filters (`category`, `min_price`, `max_price`, `sort`)
- `GET /api/v1/products/flash-deals`
- `GET /api/v1/products/recommended`
- `GET /api/v1/products/trending`
- `GET /api/v1/products/search?q=...`
- `GET /api/v1/products/{id}` — product details
- `POST /api/v1/auth/register`
- `POST /api/v1/auth/login`

### Authenticated (Bearer token via Sanctum)
- `GET|POST|PATCH|DELETE /api/v1/cart[...]`
- `GET|POST|DELETE /api/v1/wishlist[...]`
- `GET|POST /api/v1/orders[...]`
- `GET /api/v1/auth/me`
- `POST /api/v1/auth/logout`

## Stack
- Laravel 11
- Sanctum (token auth)
- SQLite by default (swap to MySQL via `.env`)
