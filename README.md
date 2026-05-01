# Workopia

A small PHP job/listings application (minimal framework + controllers/views).

## Requirements

- PHP 8+
- Composer
- MySQL (or compatible) database

## Installation

1. Install dependencies:

```bash
composer install
```

2. Configure the database at `config/db.php` (host, port, dbname, username, password).

3. Start a local server from the project root:

```bash
php -S localhost:8000 -t public
```

Then open http://localhost:8000 in your browser.

## Configuration

- Database configuration lives in `config/db.php`.
- Autoloading is PSR-4 configured in `composer.json` for the `App\` and `Framework\` namespaces.

## Routes

Defined in `routes.php` (simple list):

- `GET /` → `HomeController@index`
- `GET /listings` → `ListingController@index`
- `GET /listings/create` → `ListingController@create`
- `GET /listings/edit/{id}` → `ListingController@edit`
- `GET /listings/{id}` → `ListingController@show`
- `POST /listings` → `ListingController@store`
- `PUT /listings/{id}` → `ListingController@update`
- `DELETE /listings/{id}` → `ListingController@destroy`
- `GET /auth/register` → `UserController@create`
- `GET /auth/login` → `UserController@login`

> Note: form submissions should use the corresponding POST/PUT/DELETE methods.

## Project Structure (key files)

- `public/index.php` — front controller (router bootstrap)
- `routes.php` — route definitions
- `App/controllers/` — controller classes (`HomeController`, `ListingController`, `UserController`, `ErrorController`)
- `App/views/` — view templates and partials (head, navbar, footer)
- `Framework/` — lightweight framework utilities (Router, Database, Validation)
- `config/db.php` — DB credentials

## Notes / Troubleshooting

- If you see errors about missing `config/database.php`, the app uses `config/db.php` by default; ensure that file exists and is readable.
- Use the navbar links (`/auth/login`, `/auth/register`) to open auth pages — routes for these are defined in `routes.php`.
- To change the app base path helpers, see `helpers.php`.

## Contributing

Open a PR or file an issue with steps to reproduce and a short description.

## License

This repository includes a LICENSE file; follow its terms.
