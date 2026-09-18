# PLN DIGI — Project Guidelines

## Project Overview
Aplikasi web PLN Digital (mirip PLN Mobile) untuk lomba PLN DIGI.

**Tech Stack:** Laravel 13 + Breeze (Blade) + Tailwind CSS + MySQL  
**PHP:** 8.4 | **Node:** 24.x

## Architecture

### Database
- `users` — role: user/admin
- `customers` — data pelanggan PLN (id_pelanggan, tarif, daya, tagihan)
- `transactions` — pembayaran tagihan & token (type: tagihan/token)
- `tariff_types` — jenis tarif untuk simulasi pasang baru

### Key Models
- `User` — `isAdmin()`, hasMany customers/transactions
- `Customer` — belongsTo user, hasMany transactions
- `Transaction` — belongsTo user & customer
- `TariffType` — standalone

### Routes
- **Public:** `/` (home), `/simulasi`, `/produk`, `/produk/tagihan`, `/produk/token`
- **Auth:** `/dashboard`, `/produk/bayar`, `/produk/konfirmasi/{transaction}`
- **Admin:** `/admin/*` (protected by `admin` middleware)

### Layouts
- `layouts.main` — custom public layout (navbar + footer)
- `layouts.app` — Breeze default (for profile pages)

### Auth
- Admin login: `admin@plndigi.com` / `password`
- User login: `hafizh@mail.com` / `password`

## Coding Rules

1. **Bahasa:** Views dan user-facing text dalam Bahasa Indonesia
2. **Blade components:** Gunakan `@extends('layouts.main')` untuk semua halaman publik
3. **CSS classes:** Pakai custom classes dari `app.css` (`btn-primary`, `card`, `form-input`, `section-title`, dll)
4. **Controllers:** Satu controller per fitur (Home, Simulasi, Produk, Dashboard, Admin)
5. **Jangan** install package tambahan tanpa persetujuan user
6. **Format uang:** Selalu `Rp {{ number_format($amount, 0, ',', '.') }}`
7. **Colors:** PLN Blue `#00529C` (blue-900) + PLN Yellow `#FDB813` (yellow-400/500)

## Quick Commands
```bash
php artisan serve                    # Run development server
php artisan migrate:fresh --seed     # Reset & seed database
npm run dev                          # Watch frontend assets
npm run build                        # Build for production
```
