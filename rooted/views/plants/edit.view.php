<?php require base_path("views/partials/head.php"); ?>
<?php require base_path("views/partials/nav.php"); ?>
<?php require base_path("views/partials/banner.php"); ?>

<main>
    <div class="mx-auto max-w-lg py-10 sm:px-6 lg:px-8">
        <?php $fieldErrors = $_SESSION["_flash"]["errors"] ?? []; ?>
        <?php require base_path("views/partials/errors.php"); ?>

        <form method="POST" action="/plant?id=<?= $plant["id"] ?>" class="space-y-6">
            <input type="hidden" name="_method" value="PATCH">

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" id="name" name="name"
                       value="<?= htmlspecialchars($plant["name"]) ?>"
                       required
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>

            <div>
                <label for="body" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea id="body" name="body" rows="5"
                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"><?= htmlspecialchars($plant["body"] ?? "") ?></textarea>
            </div>

            <div>
                <label for="visibility" class="block text-sm font-medium text-gray-700">Visibility</label>
                <select id="visibility" name="visibility"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <option value="public" <?= $plant["visibility"] === "public" ? "selected" : "" ?>>Public</option>
                    <option value="internal" <?= $plant["visibility"] === "internal" ? "selected" : "" ?>>Internal</option>
                </select>
            </div>

            <div class="flex gap-4">
                <button type="submit"
                        class="rounded-md bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    Update Plant
                </button>
                <a href="/plant?id=<?= $plant["id"] ?>" class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900">Cancel</a>
            </div>
        </form>
    </div>
</main>

<?php require base_path("views/partials/footer.php"); ?>
