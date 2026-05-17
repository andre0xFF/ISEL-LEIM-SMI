<?php require base_path("views/partials/head.php"); ?>
<?php require base_path("views/partials/nav.php"); ?>
<?php require base_path("views/partials/banner.php"); ?>

<main>
    <div class="mx-auto max-w-lg py-10 sm:px-6 lg:px-8">
        <?php $fieldErrors = $errors ?? []; ?>
        <?php require base_path("views/partials/errors.php"); ?>

        <form method="POST" action="/tags" class="space-y-6">

            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Tag Name</label>
                <input type="text" id="name" name="name" value="<?= htmlspecialchars(old('name')) ?>"
                       required
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>

            <!-- Type -->
            <?php if (($_SESSION["user"]["role"] ?? "") === "admin"): ?>
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700">Type</label>
                    <select id="type" name="type"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="primary" <?= old('type') === 'primary' ? 'selected' : '' ?>>Primary</option>
                        <option value="secondary" <?= old('type') !== 'primary' ? 'selected' : '' ?>>Secondary</option>
                    </select>
                </div>
            <?php else: ?>
                <input type="hidden" name="type" value="secondary">
            <?php endif; ?>

            <!-- Submit -->
            <div>
                <button type="submit"
                        class="w-full rounded-md bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    Create Tag
                </button>
            </div>
        </form>
    </div>
</main>

<?php require base_path("views/partials/footer.php"); ?>
