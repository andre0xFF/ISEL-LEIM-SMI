# Rooted

Rooted is a gardening web application that helps users plan and manage their gardens. This document will guide you through setting up and understanding the project, especially if you are new to PHP.

## Getting Started

### Prerequisites

- [Docker / Podman](https://docs.docker.com/get-docker/) (recommended)

Or, for running without containers:

- [PHP 8.2+](https://www.php.net/manual/en/install.php)
- [Composer](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-macos) (PHP's dependency manager)
- A MySQL 8.0 database

### Running with Docker / Podman

1.  **Install PHP dependencies:**

    ```bash
    composer install
    ```

2.  **Start the containers** (app + database):

    ```bash
    docker compose up -d
    ```

    On first start, the database is automatically populated from the SQL files in `database/`. The PHP development server starts automatically on `http://localhost:8080`.

> **Tip — resetting the database:** The SQL files only run when the
> database volume is first created.
> If you change the SQL files in `database/`, you need to destroy the volume and recreate it:
>
> ```bash
> docker compose down -v   # removes containers AND the database volume
> docker compose up -d     # recreates everything from scratch
> ```

### Running without Docker

1.  **Install dependencies:**

    ```bash
    composer install
    ```

2.  **Set up the database:** Import the SQL files from `database/` into your MySQL instance in order (`001-schema.sql`, then `002-seed.sql`, etc.).

3.  **Configure the database connection** via environment variables (or rely on the defaults in `config.php`):

    ```bash
    export DB_HOST=localhost DB_PORT=3306 DB_NAME=rooted DB_USER=root DB_PASSWORD=root
    ```

4.  **Start the development server:**
    ```bash
    composer start
    ```
    The application will be available at `http://localhost:8080`.

---

## PHP Concepts You'll See in This Project

If you're new to PHP, this section explains the key language features and patterns used throughout the codebase. Experienced PHP developers can skip to [How This Project Works](#how-this-project-works).

### Composer and Autoloading

[Composer](https://getcomposer.org/) is PHP's package manager (like `npm` for Node.js or `pip` for Python). It does two things in this project:

1.  **Dependency management** — `composer install` reads `composer.json` and downloads any required packages into the `vendor/` directory.
2.  **Autoloading** — instead of manually writing `require` for every PHP file, Composer generates an autoloader. When you `require 'vendor/autoload.php'`, PHP will automatically find and load classes based on their namespace. For example, `use Core\Router` will automatically load `Core/Router.php` because `composer.json` maps the `Core\\` namespace to the `Core/` directory:

    ```json
    "autoload": {
        "psr-4": {
            "Core\\": "Core/",
            "Http\\": "Http/"
        }
    }
    ```

    This convention is called **PSR-4** — the namespace path matches the directory/file path.

### Namespaces

PHP namespaces prevent class name collisions, much like packages in Java or modules in Python. You'll see them at the top of every class file:

```php
namespace Core;          // This file belongs to the Core namespace

class Router { ... }     // Full name is Core\Router
```

And when using a class from another namespace:

```php
use Core\Router;         // Import the class

$router = new Router();  // Now you can use the short name
```

### Superglobals

PHP provides special global arrays that are always available. This project uses several:

| Variable    | What it contains                        | Example usage in this project                         |
| ----------- | --------------------------------------- | ----------------------------------------------------- |
| `$_GET`     | URL query parameters (`?key=value`)     | Reading filter/search params                          |
| `$_POST`    | Form submission data                    | `$_POST["name"]` to read a form field                 |
| `$_SESSION` | Data persisted across requests per user | `$_SESSION["user"]` to check who is logged in         |
| `$_SERVER`  | Server and request metadata             | `$_SERVER["REQUEST_URI"]` to get the current URL path |

### PDO (PHP Data Objects)

PDO is PHP's built-in database abstraction layer. It provides a consistent interface to connect to different databases (MySQL, PostgreSQL, SQLite, etc.). In this project, `Core/Database.php` wraps PDO to keep queries simple:

```php
// Prepared statement — the :user_id placeholder prevents SQL injection
$db->query("SELECT * FROM plants WHERE user_id = :user_id", [
    "user_id" => 1,
]);
```

The `:user_id` syntax creates a **prepared statement** — the database treats the value as data, never as executable SQL, which prevents SQL injection attacks.

### Sessions

HTTP is stateless — the server doesn't inherently remember who you are between requests. PHP sessions solve this by assigning each visitor a unique ID (stored in a cookie called `PHPSESSID`). The server stores data for that ID in `$_SESSION`:

```php
session_start();                          // Resume or start a session
$_SESSION["user"] = ["id" => 1, ...];    // Store data (survives across requests)
$_SESSION["user"]["id"];                  // Read it back on the next request
```

This project uses sessions for authentication (remembering who is logged in) and for **flash messages** — one-time data like form errors that should appear once and then disappear.

---

## How This Project Works

### The Request Lifecycle

Every request follows the same path through the application:

```
Browser request (e.g. GET /plants)
  → PHP built-in server
  → public/index.php       (1. front controller)
  → bootstrap.php          (2. register services)
  → setup wizard guard     (3. redirect to /setup if no admin exists)
  → routes.php             (4. find matching route)
  → Middleware              (5. check access — auth, role, 2FA)
  → Http/controllers/      (6. execute controller)
  → views/                 (7. render HTML response)
```

### 1. Front Controller (`public/index.php`)

All web requests are handled by a single entry point: `public/index.php`. This is the **Front Controller** pattern.

How does PHP know to load that file? It comes down to the start command:

```bash
php -S 0.0.0.0:8080 -t public
```

- **`-t public`** sets `public/` as the **document root** — the only directory the web server can serve files from.
- When a request comes in (e.g. `GET /plants`), PHP looks for a matching file inside `public/`. Since there is no `plants` file, it falls back to `index.php`. This is a convention built into PHP's built-in server.
- Because `index.php` is the **only** PHP file inside `public/`, every dynamic request goes through it. All other code (controllers, views, config) lives outside `public/` and **cannot** be accessed directly via a URL — this is a security feature.

### 2. Bootstrap (`bootstrap.php`)

The front controller loads `bootstrap.php`, which registers shared services — like the database connection — so they can be retrieved from anywhere using `App::resolve()`:

```php
App::bind(Database::class, function () {
    $config = require base_path("config.php");

    return new Database(
        $config["database"],
        $config["username"],
        $config["password"],
    );
});
```

Later, any controller can retrieve the database with:

```php
$db = App::resolve(Database::class);
```

`App` is a simple static class with a `$bindings` array — `bind()` stores a factory closure under a key, and `resolve()` calls it. This avoids creating multiple database connections and keeps configuration centralized.

### 3. Setup Wizard Guard

Before routing, the front controller checks whether any admin user exists in the database. If not (e.g. on first run), every request except `/setup` is redirected to the setup wizard, which lets you create the initial admin account.

### 4. Routing (`routes.php`)

The `routes.php` file returns a closure that receives a `Router` and registers all URL + HTTP method pairs:

```php
return function (Router $router) {
    $router->get("/plants", "plants/index.php");
    $router->post("/plants", "plants/store.php")->only("auth", "role:moderator");
    $router->get("/login", "session/create.php")->only("guest");
    // ...
};
```

- `$router->get("/plants", "plants/index.php")` means: when a `GET` request hits `/plants`, execute `Http/controllers/plants/index.php`.
- `->only("auth", "role:moderator")` applies **middleware** — in this case, requiring the user to be logged in _and_ have at least the `moderator` role.
- HTML forms can only send `GET` and `POST`. For `DELETE`, `PATCH`, and `PUT` methods, a hidden form field `_method` is used to override the actual HTTP method (this is a common pattern called **method spoofing**).

### 5. Controllers (`Http/controllers/`)

Controllers are plain PHP files (not classes) organized by resource. Each file handles exactly one action:

```php
// Http/controllers/plants/index.php — List the user's plants

$db = App::resolve(Database::class);

$plants = $db->query("SELECT * FROM plants WHERE user_id = :user_id", [
    "user_id" => $_SESSION["user"]["id"],
])->get();

view("plants/index.view.php", [
    "heading" => "My Plants",
    "plants" => $plants,
]);
```

The pattern is always: **resolve dependencies → query/mutate data → render a view or redirect**.

```
Http/controllers/
├── index.php               # Home page
├── identify/
│   └── store.php           # POST   /identify       — PlantNet identification
├── map/
│   └── index.php           # GET    /map             — interactive map
├── media/
│   ├── batch-download.php  # GET    /media/batch-download
│   ├── batch-upload-form.php # GET  /media/batch-upload — show form
│   ├── batch-upload.php    # POST   /media/batch-upload — handle upload
│   └── serve.php           # GET    /media            — serve a media file
├── plants/                 # Plant CRUD
│   ├── index.php           # GET    /plants           — list
│   ├── show.php            # GET    /plant            — detail
│   ├── create.php          # GET    /plants/create    — show form
│   ├── store.php           # POST   /plants           — handle form
│   ├── edit.php            # GET    /plant/edit       — show edit form
│   ├── update.php          # PATCH  /plant            — handle edit
│   └── destroy.php         # DELETE /plant            — delete
├── profile/                # User profile
│   ├── edit.php            # GET    /profile          — show profile
│   └── update.php          # PATCH  /profile          — update profile
├── registration/           # User registration
│   ├── create.php          # GET    /register         — show form
│   └── store.php           # POST   /register         — handle form
├── rss/
│   └── feed.php            # GET    /rss              — RSS feed
├── session/                # Login / logout
│   ├── create.php          # GET    /login            — show form
│   ├── store.php           # POST   /session          — handle login
│   └── destroy.php         # DELETE /session          — logout
├── settings/               # Application settings (admin)
│   ├── edit.php            # GET    /settings         — show form
│   └── update.php          # PATCH  /settings         — update
├── setup/                  # First-run setup wizard
│   ├── index.php           # GET    /setup            — show form
│   └── store.php           # POST   /setup            — create admin
├── subscriptions/          # Tag subscriptions
│   ├── index.php           # GET    /subscriptions    — list
│   ├── store.php           # POST   /subscriptions    — subscribe
│   └── destroy.php         # DELETE /subscription     — unsubscribe
├── tags/                   # Tag CRUD
│   ├── index.php           # GET    /tags             — list
│   ├── create.php          # GET    /tags/create      — show form
│   ├── store.php           # POST   /tags             — handle form
│   ├── edit.php            # GET    /tag/edit         — show edit form
│   ├── update.php          # PATCH  /tag              — handle edit
│   └── destroy.php         # DELETE /tag              — delete
├── users/                  # User management (admin)
│   ├── index.php           # GET    /users            — list
│   ├── show.php            # GET    /user             — detail
│   ├── create.php          # GET    /users/create     — show form
│   ├── store.php           # POST   /users            — handle form
│   ├── edit.php            # GET    /user/edit        — show edit form
│   ├── update.php          # PUT    /user             — handle edit
│   └── destroy.php         # DELETE /user             — delete
└── verification/           # Two-factor authentication
    ├── show.php            # GET    /verify           — show 2FA form
    ├── store.php           # POST   /verify           — verify code
    └── resend.php          # POST   /resend-2fa       — resend code
```

### 6. Views (`views/`)

Views are PHP templates that mix HTML with PHP to render the response. They receive data from controllers via the `view()` helper:

```php
// In the controller:
view("plants/index.view.php", ["plants" => $plants]);

// In the view — $plants is now available:
<?php foreach ($plants as $plant) : ?>
    <p><?= htmlspecialchars($plant["name"]) ?></p>
<?php endforeach; ?>
```

`htmlspecialchars()` is important — it escapes HTML entities to prevent XSS (cross-site scripting) attacks. Always use it when outputting user-provided data.

Views are composed from reusable **partials** (header, navigation, footer):

```
views/
├── partials/
│   ├── head.php            # <head> tag, CSS links
│   ├── nav.php             # Navigation bar
│   ├── banner.php          # Page banner
│   ├── errors.php          # Validation error messages
│   └── footer.php          # Page footer
├── 403.php                 # Forbidden error page
├── 404.php                 # Not found error page
├── index.view.php          # Home page
├── map/
│   └── index.view.php      # Interactive map
├── media/
│   └── batch-upload.view.php # Batch upload form
├── plants/
│   ├── index.view.php      # Plant listing
│   ├── show.view.php       # Single plant detail
│   ├── create.view.php     # Create plant form
│   └── edit.view.php       # Edit plant form
├── profile/
│   └── edit.view.php       # User profile form
├── registration/
│   └── create.view.php     # Registration form
├── session/
│   └── create.view.php     # Login form
├── settings/
│   └── edit.view.php       # Application settings form
├── setup/
│   └── index.view.php      # Setup wizard form
├── subscriptions/
│   └── index.view.php      # Subscription listing
├── tags/
│   ├── index.view.php      # Tag listing
│   ├── create.view.php     # Create tag form
│   └── edit.view.php       # Edit tag form
├── users/
│   ├── index.view.php      # User listing
│   ├── show.view.php       # User detail
│   ├── create.view.php     # Create user form
│   └── edit.view.php       # Edit user form
└── verification/
    └── show.view.php       # 2FA verification form
```

### Middleware

Middleware runs _before_ a controller to guard access. This project has four:

| Key        | Class                           | Behavior                                                      |
| ---------- | ------------------------------- | ------------------------------------------------------------- |
| `auth`     | `Core\Middleware\Authenticated` | Requires the user to be logged in                             |
| `guest`    | `Core\Middleware\Guest`         | Requires the user to **not** be logged in                     |
| `role`     | `Core\Middleware\Role`          | Requires a minimum role (e.g. `role:moderator`, `role:admin`) |
| `verified` | `Core\Middleware\Verified`      | Requires 2FA verification to be completed                     |

They're applied in routes with `->only("auth")`, `->only("guest")`, or chained like `->only("auth", "role:moderator")`.

The `role` middleware uses a hierarchy: `guest < user < moderator < admin`. A route guarded with `role:moderator` will allow moderators _and_ admins, but block regular users.

### Database

SQL files live in the `database/` directory and are executed in alphabetical order on first container start:

```
database/
├── 001-schema.sql          # Table definitions
└── 002-seed.sql            # Seed data (demo users, plants, tags, etc.)
```

The schema defines these tables:

| Table           | Purpose                                                                         |
| --------------- | ------------------------------------------------------------------------------- |
| `users`         | User accounts with roles (`admin`, `moderator`, `user`, `guest`) and 2FA fields |
| `plants`        | Plant entries with name, description, and visibility (`public`/`internal`)      |
| `media`         | File attachments (image/video/audio) linked to plants                           |
| `tags`          | Taxonomy tags (`primary` or `secondary`)                                        |
| `plant_tag`     | Many-to-many relationship between plants and tags                               |
| `plant_meta`    | Key-value metadata per plant (soil type, sun, watering, GPS coordinates, etc.)  |
| `subscriptions` | Users subscribe to tags to receive notifications                                |
| `settings`      | Application-wide key-value configuration (SMTP, app name, etc.)                 |

The seed data includes several demo users. All passwords are `password`:

| Email                    | Role      | Verified |
| ------------------------ | --------- | -------- |
| `admin@rooted.local`     | admin     | ✅       |
| `moderator@rooted.local` | moderator | ✅       |
| `maria@rooted.local`     | moderator | ✅       |
| `joao@rooted.local`      | user      | ✅       |
| `ana@rooted.local`       | user      | ✅       |
| `pedro@rooted.local`     | user      | ❌       |

The database connection is configured in `config.php`, which reads from environment variables with sensible defaults.

---

## Directory Structure

```
rooted/
├── Core/                       # Framework classes
│   ├── Middleware/              # Route middleware
│   │   ├── Middleware.php       # Middleware registry/dispatcher
│   │   ├── Authenticated.php   # "auth" — requires login
│   │   ├── Guest.php           # "guest" — requires no login
│   │   ├── Role.php            # "role:X" — requires minimum role
│   │   └── Verified.php        # "verified" — requires 2FA
│   ├── App.php                 # Static service registry (bind/resolve)
│   ├── Authenticator.php       # Login, logout, and 2FA logic
│   ├── Database.php            # PDO wrapper
│   ├── Mailer.php              # Email sending via mail() with logging
│   ├── MediaService.php        # File upload, storage, and retrieval
│   ├── NotificationService.php # Email notifications for subscriptions
│   ├── PlantNetService.php     # PlantNet API integration for plant identification
│   ├── Response.php            # HTTP status code constants
│   ├── Router.php              # URL routing with middleware support
│   ├── ValidationException.php # Exception carrying validation errors and old input
│   ├── Validator.php           # Input validation helpers
│   ├── WeatherService.php      # Open-Meteo API integration for weather data
│   └── functions.php           # Global helper functions (view, redirect, abort, etc.)
├── Http/                       # HTTP layer
│   ├── controllers/            # File-based controllers (one per action)
│   └── Forms/                  # Form validation classes
├── views/                      # PHP view templates
│   └── partials/               # Reusable fragments (head, nav, footer, errors)
├── public/                     # Document root (only web-accessible directory)
│   └── index.php               # Front controller — single entry point
├── database/                   # SQL schema and seed files
├── storage/                    # Uploaded files (media, mail logs)
├── vendor/                     # Composer dependencies (git-ignored)
├── bootstrap.php               # Service registration (binds Database to App)
├── config.php                  # Database config (reads environment variables)
├── routes.php                  # All route definitions
├── compose.yaml                # Docker Compose services (app + MySQL)
├── Dockerfile                  # PHP development container
├── composer.json               # Dependencies and autoloading
└── composer.lock               # Locked dependency versions
```

## Contributing

```bash
# Install dependencies
composer install

# Start the dev server
composer start

# Regenerate the autoloader (after adding new classes)
composer dump-autoload -o
```
