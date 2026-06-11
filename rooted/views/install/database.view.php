<?php require base_path("views/partials/head.php"); ?>

<main class="flex items-center justify-center min-h-screen">
    <div class="w-full max-w-lg p-8">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Database Connection</h1>
            <p class="mt-2 text-gray-600">Rooted couldn't reach a database. Enter your MySQL connection details to continue.</p>
        </div>

        <!-- Error display -->
        <?php $fieldErrors = $errors ?? []; ?>
        <?php require base_path("views/partials/errors.php"); ?>

        <form method="POST" action="/install/database" class="space-y-6 bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="db_host" class="block text-sm font-medium text-gray-700">Host</label>
                    <input type="text" id="db_host" name="db_host" required
                           value="<?= htmlspecialchars($values["db_host"] ?? "") ?>"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>
                <div>
                    <label for="db_port" class="block text-sm font-medium text-gray-700">Port</label>
                    <input type="text" id="db_port" name="db_port" required
                           value="<?= htmlspecialchars($values["db_port"] ?? "3306") ?>"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>
            </div>
            <div>
                <label for="db_name" class="block text-sm font-medium text-gray-700">Database Name</label>
                <input type="text" id="db_name" name="db_name" required
                       value="<?= htmlspecialchars($values["db_name"] ?? "rooted") ?>"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                <p class="mt-1 text-xs text-gray-500">Created automatically in the next step if it doesn't exist yet.</p>
            </div>
            <div>
                <label for="db_user" class="block text-sm font-medium text-gray-700">User</label>
                <input type="text" id="db_user" name="db_user" required
                       value="<?= htmlspecialchars($values["db_user"] ?? "") ?>"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>
            <div>
                <label for="db_password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" id="db_password" name="db_password"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>

            <button type="submit"
                    class="w-full rounded-md bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700">
                Test &amp; Save Connection
            </button>
        </form>
    </div>
</main>

<?php require base_path("views/partials/footer.php"); ?>
