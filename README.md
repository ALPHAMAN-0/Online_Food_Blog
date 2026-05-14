# Foodly - Online Food Blog

A PHP MVC web application built for **Web Technologies Project 07**.
Visitors browse restaurants and food items, members post reviews and food
experiences, and admins manage all content.

## Tech stack
- PHP 8 (no framework, hand-rolled MVC)
- MySQL 5.7+ / MariaDB
- Vanilla JavaScript (no jQuery, no build step)
- Single CSS file with a custom "warm food vibes" theme

## Folder layout
```
MVC/
  index.php             front controller / router
  .htaccess             Apache URL rewrite
  config/               db.php, session.php, helpers.php
  models/               one PHP class per table
  controllers/
    auth/               register, login, logout
    profile/            show / update / change password
    home/               visitor home
    restaurants/        public browse + single page
    menu/               menu item detail
    admin/              admin CRUD + moderation
    foodexperience/     food experience posts
    api/                AJAX endpoints (return JSON)
  views/                PHP view templates
  public/
    css/style.css       theme
    js/                 main.js, search.js, reviews.js, foodexp.js, admin_inline.js
    uploads/menu/       menu item images
    uploads/profiles/   profile pictures
  database/
    schema.sql          shared schema (do not modify)
    seed.sql            sample data
```

## Setup

### Option A - Docker (easiest, recommended)
Make sure Docker Desktop is running, then:
```bash
docker compose up -d --build
```
Open <http://localhost:8080/>. That's it - MySQL is started, schema +
seed are loaded automatically.

To stop:
```bash
docker compose down
```
To start fresh (wipes DB volume):
```bash
docker compose down -v && docker compose up -d --build
```

### Option B - Local PHP + MySQL

#### 1. Create the database
```bash
mysql -u root -p < MVC/database/schema.sql
mysql -u root -p < MVC/database/seed.sql
```

#### 2. Configure DB credentials
Edit `MVC/config/db.php` if your local MySQL user/password is not
`root` / empty (or export `DB_HOST`, `DB_USER`, `DB_PASS` env vars).

#### 3. Run the app
**PHP built-in server**:
```bash
cd MVC
php -S localhost:8000
```
Open <http://localhost:8000/>.

**Apache (XAMPP/MAMP)**: point DocumentRoot to the `MVC/` folder so
`.htaccess` is honored.

## Default seeded accounts

| Role   | Email                | Password   |
|--------|----------------------|------------|
| admin  | admin@foodly.com     | admin123   |
| member | sara@foodly.com      | member123  |
| member | tariq@foodly.com     | member123  |

## Feature map (PDF tasks)

| Task | Student ID    | What it covers                                                                |
|------|---------------|-------------------------------------------------------------------------------|
| 1    | 23-52978-3    | Auth, register, login, Remember Me, profile, visitor home, basic browse       |
| 2    | 23-52980-3    | Admin dashboard, restaurant + menu CRUD with image upload                     |
| 3    | 23-53027-3    | AJAX search/filter, member reviews on food items (post / delete via AJAX)     |
| 4    | 24-56637-1    | Food Experience posts + comments, admin moderation (remove members/reviews/posts/comments) |

## Security
- Passwords hashed with `password_hash` (bcrypt), verified with `password_verify`
- All DB queries use PDO **prepared statements**
- Output escaped via `e()` (`htmlspecialchars`)
- Image uploads validated server-side for MIME type and ≤2MB
- Session check on all auth-gated pages
- Admin gate on `/admin/*` routes
- Member-only gate on review posting and food experience creation
