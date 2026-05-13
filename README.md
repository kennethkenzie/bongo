# Estate Bongo Online

A modern AliExpress-style ecommerce marketplace.

## Structure

```
Estate/
├── frontend/   # Next.js 14 + TypeScript + Tailwind CSS
└── backend/    # Laravel 11 API
```

## Brand
- **Name**: Estate Bongo Online
- **Palette**: Purple `#7c2ae8` (primary), white, light gray `#f5f5f5`, dark text `#222`
- **Style**: Marketplace-dense, minimal rounding (2–4px), sharp/clean cards

## Frontend
```bash
cd frontend
npm install
npm run dev
```
Open http://localhost:3000

## Backend
```bash
cd backend
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```
API at http://localhost:8000/api
