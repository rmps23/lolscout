# LOLSCOUT

**Live demo:** https://lolscout.onrender.com

A platform for **League of Legends** players to find a team: verify your Riot account, show your rank and champion mastery, and search, join or manage amateur teams.

Built in 2023 as my first full PHP project and rebuilt in Laravel afterwards. The original code is kept untouched in [`legacy/`](legacy/) for reference.

## Features

- **Accounts** – sign up with email verification, log in, reset a forgotten password by email, manage profile, email and password, delete your account.
- **Riot account verification** – link a Riot ID (`Name#TAG`) and prove you own it by saving a one-time code in the League client (Settings > Verification).
- **Player profiles** – verified rank and LP (solo queue), top 3 champions by mastery, role, nation, bio and social links.
- **Teams** – create and edit a team, upload a logo, set a minimum rank, manage the roster (one player per role), share an invite link.
- **Recruiting** – search teams by name, open role and rank eligibility; apply (max. 3 pending), accept or decline applications from a notifications page.
- **Favourites** – save players you want to keep an eye on.

## Stack

PHP 8.3 · Laravel 13 · MySQL · Blade · PHPUnit · Riot Games API · Data Dragon

## Running locally

Requirements: PHP 8.3+ (with `pdo_mysql`, `mbstring`, `curl`, `intl`), Composer and MySQL 8.

```bash
composer install
cp .env.example .env
php artisan key:generate
```

Create an empty database and set `DB_DATABASE`, `DB_USERNAME` and `DB_PASSWORD` in `.env`, then:

```bash
php artisan migrate --seed
php artisan storage:link
php artisan serve
```

Open <http://localhost:8000>. The seeder loads the roles, nations and ranks.

### Riot API key

Get a key at <https://developer.riotgames.com> and put it in `.env`:

```
RIOT_API_KEY=RGAPI-...
RIOT_PLATFORM=euw1
RIOT_REGION=europe
```

Development keys expire every 24 hours, so renew yours when the Riot account page starts reporting that the API is not available. To run a public site you need a production key, which Riot grants after you register the application. `RIOT_PLATFORM` and `RIOT_REGION` must match (for example `na1` with `americas`, `kr` with `asia`). The key is only ever read on the server.

### Email

By default `MAIL_MAILER=log`, so verification and password-reset emails are written to `storage/logs/laravel.log` and you can copy the links from there. To send real email, set the `MAIL_*` variables in `.env` to any SMTP provider.

### Tests

```bash
php artisan test
```

The suite uses an in-memory SQLite database and fakes every call to Riot, so it needs no network or API key.

## Security notes

- Every query goes through Eloquent or the query builder (prepared statements); passwords are hashed; sessions are regenerated on login.
- All forms carry a CSRF token. Auth endpoints are rate limited. Password reset never reveals whether an email exists.
- Only a team's owner can edit it, change its roster or delete it (`TeamPolicy`).
- Uploaded logos are validated as real images (type, size, dimensions) and stored with generated names.
- Social links must be `https` and on the platform's own domain.
- Responses send `X-Frame-Options`, `X-Content-Type-Options`, `Referrer-Policy`, `Permissions-Policy` and, over HTTPS, HSTS. URLs are forced to HTTPS in production.
- Secrets live in `.env`, which is not committed. Never commit your real `.env`.

## Hosting on a budget

LOLSCOUT needs PHP 8.3, MySQL, Composer and a way to point the web server at the `public/` folder.

- **Small VPS (recommended).** A basic cloud server from a provider such as Hetzner or similar costs a few euros per month. Install PHP 8.3, MySQL (or MariaDB) and Caddy or nginx, clone the repo, run the commands above with `APP_ENV=production` and `APP_DEBUG=false`, and let Caddy handle the HTTPS certificate. It gives you full control and room for a cron job or queue later.
- **Shared PHP hosting.** Cheaper and simpler, but only if the plan has PHP 8.3, SSH (or a way to run Composer) and lets you set the document root to `public/`.
- Use a transactional email service (several have free tiers) instead of the server's own mail, or password resets will land in spam.

Prices and free tiers change, so check the providers' current offers. After deploying, run `php artisan config:cache route:cache view:cache` and `php artisan migrate --force`.

## Free online demo (Render + Neon)

The repo ships a `Dockerfile` and a `render.yaml` blueprint for a public, read-mostly demo. In this *showcase* mode (`APP_SHOWCASE=true`) the site loads demo data, closes sign-ups (there is no mail server) and shows a demo login. Free tiers and their limits change, so check the providers' current terms.

1. **Database.** Create a free PostgreSQL database (for example on [Neon](https://neon.tech) or Supabase) and copy its connection URL (`postgresql://user:password@host/db?sslmode=require`).
2. **Service.** In [Render](https://render.com) choose *New › Blueprint*, connect this repository and pick the `laravel-rewrite` or `main` branch. Render reads `render.yaml` and builds the Docker image.
3. **Environment variables.** Set the ones marked as secret in `render.yaml`:
   - `APP_KEY` – run `php artisan key:generate --show` locally and paste the result.
   - `APP_URL` – the service's `https://….onrender.com` address.
   - `DB_URL` – the database URL from step 1.
   - `DEMO_PASSWORD` – the password of `demo@lolscout.test`; share it with whoever you show the site to.
   - `RIOT_API_KEY` – optional; without it the Riot pages show a friendly "API not available" message.
4. **Deploy.** On start the container runs the migrations, seeds the reference data and, in showcase mode, the demo data.

Things to know: a free web service sleeps when idle and takes a few seconds to wake up; uploaded team logos live on the container's disk and disappear on redeploy; emails are only written to the log. Remove `APP_SHOWCASE` (and configure SMTP) to run it as a real site.

## Looking back

The 2023 version used string-built SQL, plain-text secrets and the old Riot endpoints. The rewrite fixes those, models the data properly (a `team_members` table instead of one column per role) and covers the important rules with tests.
