<?php require base_path("views/partials/head.php"); ?>
<?php require base_path("views/partials/nav.php"); ?>
<?php require base_path("views/partials/banner.php"); ?>

<main>
    <div class="mx-auto max-w-lg py-10 sm:px-6 lg:px-8">
        <?php $fieldErrors = $errors ?? []; ?>
        <?php require base_path("views/partials/errors.php"); ?>

        <form method="POST" action="/plants" class="space-y-6">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" id="name" name="name" value="<?= htmlspecialchars(old("name")) ?>"
                       required
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>

            <div>
                <label for="body" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea id="body" name="body" rows="5"
                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"><?= htmlspecialchars(old("body")) ?></textarea>
            </div>

            <div>
                <label for="visibility" class="block text-sm font-medium text-gray-700">Visibility</label>
                <select id="visibility" name="visibility"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <option value="public">Public</option>
                    <option value="internal">Internal</option>
                </select>
            </div>

            <div>
                <button type="submit"
                        class="w-full rounded-md bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    Create Plant
                </button>
            </div>
        </form>
    </div>
</main>

<?php require base_path("views/partials/footer.php"); ?>
