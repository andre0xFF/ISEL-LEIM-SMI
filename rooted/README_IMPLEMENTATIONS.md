# README_IMPLEMENTATIONS

## Personal Garden Feature Specification

This document reframes the current application model and defines a delivery-oriented plan for adding personal gardens for normal users.

## 1. Current application model

The current system behaves as a shared plant catalog:

- `plants` stores global plant entries
- `plants.user_id` identifies the creator of the shared entry
- `moderator` and `admin` users manage shared plant content
- normal `user` accounts consume content, subscribe to tags, and manage their own profile

This means the app currently supports:

- shared plant browsing
- shared metadata and media
- tag subscriptions and notifications

It does **not** currently support:

- personal user gardens
- user-owned plant instances
- personal garden albums
- following another user's garden

## 2. Product goal

Allow a normal authenticated user to:

- add an existing plant from the shared catalog to their personal garden
- view a "My Garden" page listing their saved plants
- optionally attach personal photos to their own garden entries

This preserves the current shared catalog while adding a personal ownership layer on top of it.

## 3. Domain model distinction

The design should separate:

- **catalog plants**: shared plant definitions managed by privileged users
- **garden plants**: a user's personal association with a catalog plant

Example:

- catalog plant: `Rosa Trepadeira`
- user A adds it to their garden
- user B also adds it to their garden

Both users refer to the same catalog plant, but each has their own garden entry.

## 4. Recommended delivery phases

### Phase 1: Minimum viable personal garden

Deliver:

- a `garden_plants` table
- add/remove plant from personal garden
- `My Garden` page
- navbar entry for authenticated users

This is the smallest useful feature set.

### Phase 2: Personal garden album

Deliver:

- `garden_media` table
- upload personal photos for a garden entry
- display personal garden album

### Phase 3: Social garden discovery

Deliver:

- browse another user's garden
- search gardens
- follow/subscribe gardens
- optional notifications

## 5. SQL table drafts

### 5.1 `garden_plants`

Purpose:

- store which catalog plants a user has in their personal garden

Draft SQL:

```sql
CREATE TABLE IF NOT EXISTS garden_plants (
    `id`          INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id`     INT UNSIGNED NOT NULL,
    `plant_id`    INT UNSIGNED NOT NULL,
    `notes`       TEXT DEFAULT NULL,
    `created_at`  TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,

    PRIMARY KEY (`id`),
    UNIQUE KEY `uk_garden_plants_user_plant` (`user_id`, `plant_id`),
    KEY `idx_garden_plants_user_id` (`user_id`),
    KEY `idx_garden_plants_plant_id` (`plant_id`),

    CONSTRAINT `fk_garden_plants_user`
        FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_garden_plants_plant`
        FOREIGN KEY (`plant_id`) REFERENCES `plants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

Notes:

- `UNIQUE (user_id, plant_id)` prevents the same user from adding the same plant twice
- `notes` is optional but useful and cheap to include from the start

### 5.2 `garden_media`

Purpose:

- store personal photos/media uploaded by a user for their garden entry

Draft SQL:

```sql
CREATE TABLE IF NOT EXISTS garden_media (
    `id`               INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `garden_plant_id`  INT UNSIGNED NOT NULL,
    `type`             ENUM('image', 'video', 'audio') NOT NULL DEFAULT 'image',
    `path`             VARCHAR(255) NOT NULL,
    `filename`         VARCHAR(255) NOT NULL,
    `mime_type`        VARCHAR(100) NOT NULL,
    `created_at`       TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,

    PRIMARY KEY (`id`),
    KEY `idx_garden_media_garden_plant_id` (`garden_plant_id`),

    CONSTRAINT `fk_garden_media_garden_plant`
        FOREIGN KEY (`garden_plant_id`) REFERENCES `garden_plants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

Notes:

- this should stay separate from existing `media`
- existing `media` belongs to shared catalog plants
- `garden_media` belongs to a user's personal garden entry

### 5.3 Optional future table: `garden_subscriptions`

Purpose:

- follow another user's garden

Draft SQL:

```sql
CREATE TABLE IF NOT EXISTS garden_subscriptions (
    `id`                 INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `subscriber_user_id` INT UNSIGNED NOT NULL,
    `garden_user_id`     INT UNSIGNED NOT NULL,
    `created_at`         TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,

    PRIMARY KEY (`id`),
    UNIQUE KEY `uk_garden_subscriptions_pair` (`subscriber_user_id`, `garden_user_id`),
    KEY `idx_garden_subscriptions_subscriber` (`subscriber_user_id`),
    KEY `idx_garden_subscriptions_garden_user` (`garden_user_id`),

    CONSTRAINT `fk_garden_subscriptions_subscriber`
        FOREIGN KEY (`subscriber_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_garden_subscriptions_garden_user`
        FOREIGN KEY (`garden_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

This table is **not** necessary for the MVP.

## 6. Recommended route surface

### Phase 1 routes

```php
$router->get("/my-garden", "garden/index.php")->only("auth");
$router->post("/my-garden", "garden/store.php")->only("auth");
$router->delete("/garden-plant", "garden/destroy.php")->only("auth");
```

Suggested intent:

- `GET /my-garden`
  - list current user's garden entries
- `POST /my-garden`
  - add catalog plant to garden
- `DELETE /garden-plant`
  - remove a plant from garden

### Phase 2 routes

```php
$router->get("/garden-plant", "garden/show.php")->only("auth");
$router->post("/garden-media", "garden/media/store.php")->only("auth");
$router->delete("/garden-media", "garden/media/destroy.php")->only("auth");
```

## 7. Controller responsibilities

### `garden/index.php`

Should:

- load current user's `garden_plants`
- join to `plants` so the page shows plant names and catalog info
- optionally load cover image / media preview later

### `garden/store.php`

Should:

- accept `plant_id`
- validate the plant exists
- insert into `garden_plants`
- prevent duplicates
- redirect back with flash message

### `garden/destroy.php`

Should:

- validate that the `garden_plants` row belongs to the current user
- delete it
- redirect back with flash message

### `garden/show.php`

Should:

- load one specific garden entry
- validate ownership
- show catalog plant data plus personal media

## 8. Suggested view surface

### MVP views

- `views/garden/index.view.php`

This page should show:

- plant name
- short description
- link back to the catalog plant page
- remove action

### Entry points in the UI

Add:

- `My Garden` nav item for authenticated users
- `Add to My Garden` button on plant detail pages

Optional:

- add the same action on plant listing cards later

## 9. Ownership and authorization rules

Recommended rules:

- any authenticated user can add a catalog plant to their own garden
- users can view and manage only their own garden in MVP
- moderators/admins continue to manage the shared plant catalog

This preserves the current role separation:

- catalog curation remains privileged
- personal collection becomes available to normal users

## 10. Why this model fits the current project

This approach avoids overloading the existing `plants` table.

It preserves:

- shared catalog entries
- shared metadata
- shared tags
- shared notifications by tag

while adding:

- user-specific ownership
- user-specific media

This is cleaner than making normal users direct editors of the shared catalog.

## 11. Estimated complexity

### MVP: `garden_plants` only

Complexity: low to medium

Expected work:

- 1 schema addition
- 3 routes
- 3 controllers
- 1 main view
- small nav and plant-page integration

Estimated effort:

- roughly half a day to one day

### Garden album

Complexity: medium

Expected work:

- second schema addition
- file upload flow
- ownership checks
- media display and deletion

Estimated effort:

- another half day to one day

### Social/follow features

Complexity: medium to high

Expected work:

- discovery UI
- follow/subscription model
- more visibility/permissions decisions
- optional notifications

Estimated effort:

- at least one additional day

## 12. Recommended MVP decision

If this feature is implemented under time pressure, the best scoped delivery is:

1. create `garden_plants`
2. add `My Garden`
3. add `Add to My Garden`
4. add remove-from-garden

Defer:

- garden media
- garden subscriptions
- public garden browsing

This gives normal users meaningful ownership without destabilizing the current shared catalog architecture.
