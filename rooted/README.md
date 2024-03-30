# Rooted

## Contributing

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