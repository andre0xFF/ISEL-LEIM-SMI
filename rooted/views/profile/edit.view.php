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

        <form method="POST" action="/profile" class="space-y-6">
            <input type="hidden" name="_method" value="PATCH">

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" id="email" name="email"
                       value="<?= htmlspecialchars($user["email"] ?? "") ?>"
                       required
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>

            <!-- Current Password -->
            <div>
                <label for="current_password" class="block text-sm font-medium text-gray-700">Current Password</label>
                <input type="password" id="current_password" name="current_password"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                <p class="mt-1 text-xs text-gray-500">Required to save changes.</p>
            </div>

            <!-- New Password -->
            <div>
                <label for="new_password" class="block text-sm font-medium text-gray-700">New Password</label>
                <input type="password" id="new_password" name="new_password"
                       minlength="7" maxlength="255" pattern="<?= htmlspecialchars(
                           Core\Validator::STRONG_PASSWORD_PATTERN,
                       ) ?>"
                       title="Password must include at least one letter, one number and one special character."
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                <p class="mt-1 text-xs text-gray-500">Leave blank to keep current password.</p>
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm New Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation"
                       minlength="7"
                       maxlength="255"
                       pattern="<?= htmlspecialchars(
                           Core\Validator::STRONG_PASSWORD_PATTERN,
                       ) ?>"
                       title="Password must include at least one letter, one number and one special character."
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>

            <!-- Garden location (optional) -->
            <fieldset class="border-t border-gray-200 pt-4">
                <legend class="text-sm font-medium text-gray-700">Garden location <span class="text-gray-400">(optional)</span></legend>
                <p class="mt-1 text-xs text-gray-500">Set the coordinates of your garden to appear on the community Garden Map. Leave both blank to stay off the map.</p>
                <div class="mt-3 grid grid-cols-2 gap-4">
                    <div>
                        <label for="latitude" class="block text-sm font-medium text-gray-700">Latitude</label>
                        <input type="number" step="any" min="-90" max="90" id="latitude" name="latitude"
                               value="<?= htmlspecialchars(
                                   $user["latitude"] ?? "",
                               ) ?>"
                               placeholder="38.7223"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>
                    <div>
                        <label for="longitude" class="block text-sm font-medium text-gray-700">Longitude</label>
                        <input type="number" step="any" min="-180" max="180" id="longitude" name="longitude"
                               value="<?= htmlspecialchars(
                                   $user["longitude"] ?? "",
                               ) ?>"
                               placeholder="-9.1393"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>
                </div>
            </fieldset>

            <!-- Submit -->
            <div>
                <button type="submit"
                        class="w-full rounded-md bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    Update Profile
                </button>
            </div>
        </form>
    </div>
</main>

<?php require base_path("views/partials/footer.php"); ?>
