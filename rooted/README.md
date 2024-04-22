# Rooted
Rooted is a gardening web application that helps users to plan and manage their gardens.

## Contributing
This project uses composer for dependency management. To get started, run the following commands:

```shell
composer install
```

To run the tests, use the following command:

```shell
composer test
```

To run the application, use the following command:

```shell
composer start
```

To generate the autoload files, use the following command:

```shell
composer dump-autoload -o
```

### Directory Structure

```shell
rooted/
│
├── src/                        # Source code directory
│   ├── Controllers/            # Controllers handling HTTP requests
│   ├── Models/                 # Business logic and data access layers
│   ├── Views/                  # Templates and views
│   └── Middlewares/            # Middleware functions
│
├── public/                     # Publicly accessible files
│   ├── index.php               # Entry point for web requests
│   └── assets/                 # Static assets (CSS, JS, images)
│
├── vendor/                     # Composer dependencies
│
├── config/                     # Configuration files
│   ├── database.php            # Database configuration
│   └── routes.php              # Route definitions
│
├── tests/                      # Unit and integration tests
│
├── logs/                       # Log files
│
├── composer.json
└── .gitignore                  # Git ignore file
```