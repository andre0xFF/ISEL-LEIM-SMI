<nav class="bg-gray-800">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-8 w-8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" fill="none">
                        <!-- Leaf -->
                        <path d="M32 6C32 6 14 14 14 30c0 8 4 14 10 17" stroke="#818cf8" stroke-width="3" stroke-linecap="round" fill="#a5b4fc" fill-opacity="0.3"/>
                        <path d="M32 6C32 6 50 14 50 30c0 8-4 14-10 17" stroke="#818cf8" stroke-width="3" stroke-linecap="round" fill="#a5b4fc" fill-opacity="0.3"/>
                        <!-- Leaf vein / stem -->
                        <line x1="32" y1="6" x2="32" y2="44" stroke="#818cf8" stroke-width="3" stroke-linecap="round"/>
                        <!-- Roots -->
                        <path d="M32 44 C32 48 28 54 22 58" stroke="#c084fc" stroke-width="2.5" stroke-linecap="round" fill="none"/>
                        <path d="M32 44 C32 50 34 56 42 58" stroke="#c084fc" stroke-width="2.5" stroke-linecap="round" fill="none"/>
                        <path d="M32 44 C32 50 30 55 32 60" stroke="#c084fc" stroke-width="2.5" stroke-linecap="round" fill="none"/>
                        <path d="M27 50 C25 52 22 52 20 54" stroke="#c084fc" stroke-width="2" stroke-linecap="round" fill="none"/>
                        <path d="M37 52 C39 54 42 53 44 54" stroke="#c084fc" stroke-width="2" stroke-linecap="round" fill="none"/>
                    </svg>
                </div>
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-4">
                        <!-- Always visible -->
                        <a href="/"
                           class="<?= urlIs("/")
                               ? "bg-gray-900 text-white"
                               : "text-gray-300" ?> hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Home</a>
                        <a href="/plants"
                           class="<?= urlIs("/plants")
                               ? "bg-gray-900 text-white"
                               : "text-gray-300" ?> hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Plants</a>

                        <?php if ($_SESSION["user"] ?? false): ?>
                            <?php $role = $_SESSION["user"]["role"]; ?>

                            <!-- Moderator/Admin: Tags -->
                            <?php if (
                                in_array($role, ["moderator", "admin"])
                            ): ?>
                                <a href="/tags"
                                   class="<?= urlIs("/tags")
                                       ? "bg-gray-900 text-white"
                                       : "text-gray-300" ?> hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Tags</a>
                            <?php endif; ?>

                            <!-- Auth: Subscriptions -->
                            <a href="/subscriptions"
                               class="<?= urlIs("/subscriptions")
                                   ? "bg-gray-900 text-white"
                                   : "text-gray-300" ?> hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Subscriptions</a>

                            <!-- Admin only -->
                            <?php if ($role === "admin"): ?>
                                <a href="/users"
                                   class="<?= urlIs("/users")
                                       ? "bg-gray-900 text-white"
                                       : "text-gray-300" ?> hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Users</a>
                                <a href="/settings"
                                   class="<?= urlIs("/settings")
                                       ? "bg-gray-900 text-white"
                                       : "text-gray-300" ?> hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Settings</a>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="hidden md:block">
                <div class="ml-4 flex items-center md:ml-6">
                    <?php if ($_SESSION["user"] ?? false): ?>
                        <a href="/profile" class="text-gray-300 hover:text-white text-sm mr-4"><?= htmlspecialchars(
                            $_SESSION["user"]["email"],
                        ) ?></a>
                        <form method="POST" action="/session">
                            <input type="hidden" name="_method" value="DELETE"/>
                            <button class="text-white hover:text-gray-300 text-sm font-medium">Log Out</button>
                        </form>
                    <?php else: ?>
                        <a href="/register"
                           class="<?= urlIs("/register")
                               ? "bg-gray-900 text-white"
                               : "text-gray-300" ?> hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Register</a>
                        <a href="/login"
                           class="<?= urlIs("/login")
                               ? "bg-gray-900 text-white"
                               : "text-gray-300" ?> hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Log In</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</nav>
