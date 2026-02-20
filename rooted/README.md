# Rooted

Rooted is a gardening web application that helps users to plan and manage their gardens. This document will guide you through setting up and understanding the project, especially if you are new to PHP.

## Getting Started

Follow these steps to get the project running on your local machine.

### Prerequisites

Before you begin, ensure you have the following installed:
-   [PHP](https://www.php.net/manual/en/install.php)
-   [Composer](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-macos) (PHP's dependency manager)

### Installation & Setup

1.  **Install Dependencies**: This project uses Composer to manage its dependencies. Run the following command in the project's root directory to install them:
    ```shell
    composer install
    ```

2.  **Run the Application**: The project includes a convenient script to start a local development server. Use this command:
    ```shell
    composer start
    ```
    This will start a web server on `http://localhost:8080`. You can now access the application by navigating to this address in your web browser.

## How This Project Works

This project follows a common design pattern that separates concerns, making it easier to understand and maintain.

-   **Front Controller**: All web requests are first handled by a single file: `public/index.php`. This is known as the "Front Controller" pattern. This file initializes the application and passes the request to the router.

-   **Routing**: The router is responsible for deciding what code to run for a given URL. All the application's routes are defined in `configs/routes.php`. For example, a line like this:
    ```php
    $router->get("/plants", PlantController::class, "getPlants");
    ```
    ...means that a `GET` request to the `/plants` URL will be handled by the `getPlants` method inside the `PlantController` class.

-   **Controllers**: Controllers contain the main logic for handling requests. They are located in the `src/Controllers/` directory. Following the example above, the `PlantController` would be responsible for fetching plant data and preparing a response.

-   **Views**: Views are responsible for the presentation layer (the HTML that gets sent to the browser). While not fully implemented yet, they will reside in the `src/Views/` directory.

-   **Models**: Models will handle the business logic and database interactions. They will be located in the `src/Models/` directory.

## Project Status

This document outlines the current implementation status of the "Rooted" project for the second part of the "Sistemas Multimédia para a Internet" assignment.

### Implemented Features

The project currently has a solid foundation based on the MVC (Model-View-Controller) architecture.

-   **Routing**: A complete routing system is defined in `rooted/configs/routes.php`, mapping all application URLs to the corresponding controller actions.
-   **Controllers**: All necessary controller classes (`AuthenticationController`, `UserController`, and `PlantController`) have been created with placeholder methods for the required actions.
-   **Application Structure**: The structure for full CRUD (Create, Read, Update, Delete) functionality for both users and content ("plants") is in place.
-   **Authentication Flow**: A well-defined authentication flow, including user registration, login/logout, and two-factor authentication, has been mapped out in the routing and controller structure.

### To-Do / Missing Features

While the project structure is well-defined, the core logic and user-facing components are yet to be implemented.

-   **Controller Logic**: The methods within the controller classes are currently empty and need to be implemented.
-   **Views**: The user interface (UI) templates for the application's pages (e.g., login, registration, content display) need to be created.
-   **Database Integration**: A database needs to be set up, and the data access logic for all CRUD operations needs to be written.
-   **User Roles and Permissions**: The system for managing the four required user profiles (administrator, user, sympathizer, and guest) and their respective permissions must be implemented.
-   **Core Functionality**:
    -   Multimedia content uploading (images, videos, audio).
    -   Adding and editing textual descriptions for content.
    -   Assigning content to primary and secondary categories.
-   **Additional Features**:
    -   Email notifications for new content.
    -   RSS feed generation for new content.
    -   Integration with social media for content sharing.
    -   Batch uploads using ZIP files containing media and an XML metadata file.

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
