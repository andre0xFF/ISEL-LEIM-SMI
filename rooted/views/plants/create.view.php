<?php require base_path("views/partials/head.php"); ?>
<?php require base_path("views/partials/nav.php"); ?>
<?php require base_path("views/partials/banner.php"); ?>

<main>
    <div class="mx-auto max-w-lg py-10 sm:px-6 lg:px-8">
        <?php $fieldErrors = $errors ?? []; ?>
        <?php require base_path("views/partials/errors.php"); ?>

        <form method="POST" action="/plants" enctype="multipart/form-data" class="space-y-6">

            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" id="name" name="name" value="<?= htmlspecialchars(
                    old("name"),
                ) ?>"
                       required
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>

            <!-- Body -->
            <div>
                <label for="body" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea id="body" name="body" rows="5"
                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"><?= htmlspecialchars(
                              old("body"),
                          ) ?></textarea>
            </div>

            <!-- Visibility -->
            <div>
                <label for="visibility" class="block text-sm font-medium text-gray-700">Visibility</label>
                <select id="visibility" name="visibility"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <option value="public" <?= old("visibility") === "public"
                        ? "selected"
                        : "" ?>>Public</option>
                    <option value="internal" <?= old("visibility") ===
                    "internal"
                        ? "selected"
                        : "" ?>>Internal</option>
                </select>
            </div>

            <!-- Media upload -->
            <div>
                <label for="media" class="block text-sm font-medium text-gray-700">Media Files</label>
                <input type="file" id="media" name="media[]" multiple accept="image/*,video/*,audio/*"
                       class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:rounded-md file:border-0 file:bg-indigo-50 file:py-2 file:px-4 file:text-sm file:font-medium file:text-indigo-700 hover:file:bg-indigo-100">
                <p class="mt-1 text-xs text-gray-500">Upload images, videos, or audio files. Multiple files allowed.</p>
            </div>

            <!-- Tags -->
            <?php if (!empty($tags)): ?>
                <fieldset>
                    <legend class="block text-sm font-medium text-gray-700 mb-2">Tags</legend>

                    <?php
                    $primaryTags = array_filter(
                        $tags,
                        fn($t) => ($t["type"] ?? "secondary") === "primary",
                    );
                    $secondaryTags = array_filter(
                        $tags,
                        fn($t) => ($t["type"] ?? "secondary") === "secondary",
                    );
                    ?>

                    <?php if (!empty($primaryTags)): ?>
                        <div class="mb-3">
                            <p class="text-xs font-semibold text-purple-700 uppercase tracking-wide mb-1">Primary</p>
                            <div class="flex flex-wrap gap-3">
                                <?php foreach ($primaryTags as $tag): ?>
                                    <label class="inline-flex items-center gap-1.5">
                                        <input type="checkbox" name="tags[]" value="<?= $tag[
                                            "id"
                                        ] ?>"
                                               class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                        <span class="text-sm text-gray-700"><?= htmlspecialchars(
                                            $tag["name"],
                                        ) ?></span>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($secondaryTags)): ?>
                        <div>
                            <p class="text-xs font-semibold text-blue-700 uppercase tracking-wide mb-1">Secondary</p>
                            <div class="flex flex-wrap gap-3">
                                <?php foreach ($secondaryTags as $tag): ?>
                                    <label class="inline-flex items-center gap-1.5">
                                        <input type="checkbox" name="tags[]" value="<?= $tag[
                                            "id"
                                        ] ?>"
                                               class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                        <span class="text-sm text-gray-700"><?= htmlspecialchars(
                                            $tag["name"],
                                        ) ?></span>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </fieldset>
            <?php endif; ?>

            <!-- Meta-information -->
            <fieldset>
                <legend class="block text-sm font-medium text-gray-700 mb-2">Meta-information</legend>
                <div id="meta-fields" class="space-y-2">
                    <!-- Rows will be added via JS -->
                </div>
                <button type="button" id="add-meta-btn"
                        class="mt-2 inline-flex items-center rounded-md border border-gray-300 bg-white px-3 py-1.5 text-xs font-medium text-gray-700 shadow-sm hover:bg-gray-50">
                    + Add meta
                </button>
            </fieldset>

            <!-- Submit -->
            <div>
                <button type="submit"
                        class="w-full rounded-md bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    Create Plant
                </button>
            </div>
        </form>
    </div>
</main>

<script>
    (function () {
        const container = document.getElementById('meta-fields');
        const addBtn = document.getElementById('add-meta-btn');

        function createRow(key, value) {
            const row = document.createElement('div');
            row.className = 'flex items-center gap-2';
            row.innerHTML =
                '<input type="text" name="meta_keys[]" value="' + (key || '') + '" placeholder="Key" class="block w-1/2 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">' +
                '<input type="text" name="meta_values[]" value="' + (value || '') + '" placeholder="Value" class="block w-1/2 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">' +
                '<button type="button" class="remove-meta-btn text-red-500 hover:text-red-700 text-sm font-bold px-2">&times;</button>';
            container.appendChild(row);

            row.querySelector('.remove-meta-btn').addEventListener('click', function () {
                row.remove();
            });
        }

        addBtn.addEventListener('click', function () {
            createRow('', '');
        });
    })();
</script>

<?php require base_path("views/partials/footer.php"); ?>
