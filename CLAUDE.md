---
tags: [Online_Food_Blog]
---
## Run
- Dev (Docker): `docker compose up -d --build` -> http://localhost:8080/ — README.md L44-47
- Dev (PHP built-in server): `cd MVC && php -S localhost:8000` -> http://localhost:8000/ — README.md L73-76
- DB setup (local): `mysql -u root -p < MVC/database/schema.sql` then `... < MVC/database/seed.sql` — README.md L61-65

No build, test, or lint scripts found (no package.json/composer.json in this repo).

## Rules
- `MVC/database/schema.sql` is the shared schema — do not modify — README.md L36

## Read first
- MVC/index.php — front controller / router, all routes defined here
- README.md — folder layout, setup, seeded accounts
- MVC/config/db.php — DB connection config (env-overridable: DB_HOST/DB_USER/DB_PASS per README.md L69)

Architecture: see ARCHITECTURE.md — read before structural changes
