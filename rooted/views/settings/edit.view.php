<?php require base_path("views/partials/head.php"); ?>
<?php require base_path("views/partials/nav.php"); ?>
<?php require base_path("views/partials/banner.php"); ?>

<main>
    <div class="mx-auto max-w-lg py-10 sm:px-6 lg:px-8">
        <?php $fieldErrors =
            $errors ?? ($_SESSION["_flash"]["errors"] ?? []); ?>
        <?php require base_path("views/partials/errors.php"); ?>

        <?php if (!empty($_SESSION["_flash"]["success"])): ?>
            <div class="mb-4 rounded-md bg-green-50 p-4">
                <p class="text-sm font-medium text-green-800"><?= htmlspecialchars(
                    $_SESSION["_flash"]["success"],
                ) ?></p>
            </div>
        <?php endif; ?>

        <form method="POST" action="/settings" class="space-y-8">
            <input type="hidden" name="_method" value="PATCH">

            <!-- SMTP Section -->
            <fieldset class="space-y-4">
                <legend class="text-lg font-semibold text-gray-900 border-b border-gray-200 pb-2 w-full">SMTP</legend>

                <div>
                    <label for="smtp_host" class="block text-sm font-medium text-gray-700">SMTP Host</label>
                    <input type="text" id="smtp_host" name="smtp_host"
                           value="<?= htmlspecialchars(
                               $settings["smtp_host"] ?? "",
                           ) ?>"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>

                <div>
                    <label for="smtp_port" class="block text-sm font-medium text-gray-700">SMTP Port</label>
                    <input type="number" id="smtp_port" name="smtp_port"
                           value="<?= htmlspecialchars(
                               $settings["smtp_port"] ?? "587",
                           ) ?>"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>

                <div>
                    <label for="smtp_user" class="block text-sm font-medium text-gray-700">SMTP User</label>
                    <input type="text" id="smtp_user" name="smtp_user"
                           value="<?= htmlspecialchars(
                               $settings["smtp_user"] ?? "",
                           ) ?>"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>

                <div>
                    <label for="smtp_password" class="block text-sm font-medium text-gray-700">SMTP Password</label>
                    <input type="password" id="smtp_password" name="smtp_password"
                           value="<?= htmlspecialchars(
                               $settings["smtp_password"] ?? "",
                           ) ?>"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>

                <div>
                    <label for="smtp_from_address" class="block text-sm font-medium text-gray-700">From Address</label>
                    <input type="email" id="smtp_from_address" name="smtp_from_address"
                           value="<?= htmlspecialchars(
                               $settings["smtp_from_address"] ?? "",
                           ) ?>"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>

                <div>
                    <label for="smtp_from_name" class="block text-sm font-medium text-gray-700">From Name</label>
                    <input type="text" id="smtp_from_name" name="smtp_from_name"
                           value="<?= htmlspecialchars(
                               $settings["smtp_from_name"] ?? "",
                           ) ?>"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>
            </fieldset>

            <!-- Application Section -->
            <fieldset class="space-y-4">
                <legend class="text-lg font-semibold text-gray-900 border-b border-gray-200 pb-2 w-full">Application</legend>

                <div>
                    <label for="app_name" class="block text-sm font-medium text-gray-700">App Name</label>
                    <input type="text" id="app_name" name="app_name"
                           value="<?= htmlspecialchars(
                               $settings["app_name"] ?? "",
                           ) ?>"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>

                <div>
                    <label for="app_url" class="block text-sm font-medium text-gray-700">App URL</label>
                    <input type="url" id="app_url" name="app_url"
                           value="<?= htmlspecialchars(
                               $settings["app_url"] ?? "",
                           ) ?>"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>
            </fieldset>

            <!-- Submit -->
            <div>
                <button type="submit"
                        class="w-full rounded-md bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    Save Settings
                </button>
            </div>
        </form>

        <!-- Database connection — separate form, validated before saving.
             Saved to storage/config.local.php, never to the settings table. -->
        <form method="POST" action="/settings/database" class="space-y-8 mt-10"
              onsubmit="return confirm('Switching the database will log you out. Continue?');">
            <input type="hidden" name="_method" value="PATCH">

            <fieldset class="space-y-4">
                <legend class="text-lg font-semibold text-gray-900 border-b border-gray-200 pb-2 w-full">Database</legend>

                <p class="text-sm text-gray-500">
                    The connection is tested before saving. On success you will be
                    logged out and the app will use the new database.
                </p>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="db_host" class="block text-sm font-medium text-gray-700">Host</label>
                        <input type="text" id="db_host" name="db_host" required
                               value="<?= htmlspecialchars(
                                   $dbValues["db_host"] ?? "",
                               ) ?>"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>
                    <div>
                        <label for="db_port" class="block text-sm font-medium text-gray-700">Port</label>
                        <input type="number" id="db_port" name="db_port" required
                               value="<?= htmlspecialchars(
                                   $dbValues["db_port"] ?? "3306",
                               ) ?>"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>
                </div>

                <div>
                    <label for="db_name" class="block text-sm font-medium text-gray-700">Database Name</label>
                    <input type="text" id="db_name" name="db_name" required
                           value="<?= htmlspecialchars(
                               $dbValues["db_name"] ?? "",
                           ) ?>"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>

                <div>
                    <label for="db_user" class="block text-sm font-medium text-gray-700">User</label>
                    <input type="text" id="db_user" name="db_user" required
                           value="<?= htmlspecialchars(
                               $dbValues["db_user"] ?? "",
                           ) ?>"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>

                <div>
                    <label for="db_password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" id="db_password" name="db_password"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>
            </fieldset>

            <div>
                <button type="submit"
                        class="w-full rounded-md bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    Test &amp; Switch Database
                </button>
            </div>
        </form>
    </div>
</main>

<?php require base_path("views/partials/footer.php"); ?>
