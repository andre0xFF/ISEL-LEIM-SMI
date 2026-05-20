<?php require base_path("views/partials/head.php"); ?>
<?php require base_path("views/partials/nav.php"); ?>
<?php require base_path("views/partials/banner.php"); ?>

<main>
    <div class="mx-auto max-w-lg py-10 sm:px-6 lg:px-8">
        <?php $fieldErrors = $errors ?? []; ?>
        <?php require base_path("views/partials/errors.php"); ?>

        <form method="POST" action="/register" class="space-y-6">
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" id="email" name="email" autocomplete="email" value="<?= htmlspecialchars(old("email")) ?>"
                       required maxlength="255"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" id="password" name="password"
                       required minlength="7" maxlength="255" autocomplete="new-password"
                       pattern="<?= htmlspecialchars(Core\Validator::STRONG_PASSWORD_PATTERN) ?>"
                       title="Password must include at least one letter, one number and one special character."
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>

            <div>
                <button type="submit"
                        class="w-full rounded-md bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    Register
                </button>
            </div>
        </form>
    </div>
</main>

<?php require base_path("views/partials/footer.php"); ?>
