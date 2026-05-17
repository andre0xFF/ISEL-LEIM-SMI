<?php

namespace Core\Middleware;

/**
 * Restricts access to users with a specific role (or higher).
 *
 * Roles are hierarchical — higher roles inherit all lower privileges:
 *   guest < sympathizer < user < moderator < admin
 *
 * Applied to routes via the "role:name" syntax:
 *   $router->get("/users", "users/index.php")->only("auth", "role:admin");
 *   $router->post("/plants", "plants/store.php")->only("auth", "role:moderator");
 *
 * A route requiring "role:moderator" will allow both moderators and admins.
 */
class Role
{
    /**
     * Ordered from lowest to highest privilege.
     * A user's level is their position in this array.
     */
    private const HIERARCHY = ["guest", "user", "moderator", "admin"];

    /** @var string The minimum role required to access the route. */
    private string $requiredRole;

    /**
     * @param  string $role  The minimum role name (e.g. "admin", "moderator").
     */
    public function __construct(string $role)
    {
        $this->requiredRole = $role;
    }

    /**
     * Allow the request if the user's role meets the minimum, otherwise 403.
     *
     * @return void
     */
    public function handle(): void
    {
        $userRole = $_SESSION["user"]["role"] ?? "guest";
        $userLevel = array_search($userRole, self::HIERARCHY);
        $requiredLevel = array_search($this->requiredRole, self::HIERARCHY);

        // If either role is unknown, deny access.
        if ($userLevel === false || $requiredLevel === false) {
            abort(403);
        }

        if ($userLevel < $requiredLevel) {
            abort(403);
        }
    }
}
