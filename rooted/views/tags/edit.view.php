<?php require base_path("views/partials/head.php"); ?>
<?php require base_path("views/partials/nav.php"); ?>
<?php require base_path("views/partials/banner.php"); ?>

<main>
    <div class="mx-auto max-w-lg py-10 sm:px-6 lg:px-8">
        <?php $fieldErrors = $errors ?? $_SESSION["_flash"]["errors"] ?? []; ?>
        <?php require base_path("views/partials/errors.php"); ?>

        <form method="POST" action="/tag?id=<?= $tag['id'] ?>" class="space-y-6">
            <input type="hidden" name="_method" value="PATCH">

            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Tag Name</label>
                <input type="text" id="name" name="name"
                       value="<?= htmlspecialchars($tag['name']) ?>"
                       required
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>

            <!-- Type -->
            <?php if (($_SESSION["user"]["role"] ?? "") === "admin"): ?>
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700">Type</label>
                    <select id="type" name="type"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="primary" <?= ($tag['type'] ?? 'secondary') === 'primary' ? 'selected' : '' ?>>Primary</option>
                        <option value="secondary" <?= ($tag['type'] ?? 'secondary') === 'secondary' ? 'selected' : '' ?>>Secondary</option>
                    </select>
                </div>
            <?php else: ?>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Type</label>
                    <p class="mt-1 text-sm text-gray-600">
                        <span class="inline-flex rounded-full px-2 py-1 text-xs font-medium
                            <?= ($tag['type'] ?? 'secondary') === 'primary' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' ?>">
                            <?= htmlspecialchars($tag['type'] ?? 'secondary') ?>
                        </span>
                    </p>
                </div>
            <?php endif; ?>

            <!-- Actions -->
            <div class="flex gap-4">
                <button type="submit"
                        class="rounded-md bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    Update Tag
                </button>
                <a href="/tags" class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900">Cancel</a>
            </div>
        </form>
    </div>
</main>

<?php require base_path("views/partials/footer.php"); ?>
