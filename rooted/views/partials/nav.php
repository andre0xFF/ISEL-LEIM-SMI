<nav class="bg-gray-800">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <img class="h-8 w-8" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=500"
                         alt="Rooted">
                </div>
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-4">
                        <a href="/"
                           class="<?= urlIs("/")
                               ? "bg-gray-900 text-white"
                               : "text-gray-300" ?> hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Home</a>
                        <?php if ($_SESSION["user"] ?? false): ?>
                            <a href="/plants"
                               class="<?= urlIs("/plants")
                                   ? "bg-gray-900 text-white"
                                   : "text-gray-300" ?> hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Plants</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="hidden md:block">
                <div class="ml-4 flex items-center md:ml-6">
                    <?php if ($_SESSION["user"] ?? false): ?>
                        <div class="relative ml-3">
                            <span class="text-gray-300 text-sm mr-4"><?= htmlspecialchars(
                                $_SESSION["user"]["email"],
                            ) ?></span>
                        </div>

                        <div class="ml-3">
                            <form method="POST" action="/session">
                                <input type="hidden" name="_method" value="DELETE"/>
                                <button class="text-white hover:text-gray-300 text-sm font-medium">Log Out</button>
                            </form>
                        </div>
                    <?php else: ?>
                        <div class="ml-3">
                            <a href="/register"
                               class="<?= urlIs("/register")
                                   ? "bg-gray-900 text-white"
                                   : "text-gray-300" ?> hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Register</a>
                            <a href="/login"
                               class="<?= urlIs("/login")
                                   ? "bg-gray-900 text-white"
                                   : "text-gray-300" ?> hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Log In</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</nav>
