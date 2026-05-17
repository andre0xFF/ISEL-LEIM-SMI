<?php require base_path("views/partials/head.php"); ?>
<?php require base_path("views/partials/nav.php"); ?>
<?php require base_path("views/partials/banner.php"); ?>

<main>
    <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">

        <!-- Search bar -->
        <form method="GET" action="/plants" class="mb-6">
            <div class="flex items-center gap-3">
                <input type="text" name="q" value="<?= htmlspecialchars(
                    $q ?? "",
                ) ?>"
                       placeholder="Search plants..."
                       class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                <button type="submit"
                        class="rounded-md bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700">
                    Search
                </button>
                <?php if (!empty($q) || !empty($tagFilter)): ?>
                    <a href="/plants" class="text-sm text-gray-500 hover:text-gray-700 whitespace-nowrap">Clear</a>
                <?php endif; ?>
            </div>
        </form>

        <!-- Tag filter pills -->
        <?php if (!empty($tags)): ?>
            <div class="mb-6 flex flex-wrap items-center gap-2">
                <span class="text-sm font-medium text-gray-500">Filter by tag:</span>
                <a href="/plants<?= !empty($q) ? "?q=" . urlencode($q) : "" ?>"
                   class="inline-flex items-center rounded-full px-3 py-1 text-xs font-medium <?= empty(
                       $tagFilter
                   )
                       ? "bg-indigo-600 text-white"
                       : "bg-gray-100 text-gray-700 hover:bg-gray-200" ?>">
                    All
                </a>
                <?php foreach ($tags as $tag): ?>
                    <a href="/plants?tag=<?= $tag["id"] .
                        (!empty($q) ? "&q=" . urlencode($q) : "") ?>"
                       class="inline-flex items-center rounded-full px-3 py-1 text-xs font-medium <?= (int) ($tagFilter ??
                           0) === (int) $tag["id"]
                           ? "bg-indigo-600 text-white"
                           : "bg-gray-100 text-gray-700 hover:bg-gray-200" ?>">
                        <?= htmlspecialchars($tag["name"]) ?>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <!-- Header row: count + new button -->
        <div class="mb-6 flex items-center justify-between">
            <p class="text-sm text-gray-500"><?= count($plants) ?> plant(s)</p>
            <?php if (
                in_array($_SESSION["user"]["role"] ?? "", [
                    "moderator",
                    "admin",
                ])
            ): ?>
                <a href="/plants/create"
                   class="rounded-md bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700">
                    + New Plant
                </a>
            <?php endif; ?>
        </div>

        <!-- Plant grid -->
        <?php if (empty($plants)): ?>
            <p class="text-gray-500">No plants found.</p>
        <?php else: ?>
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                <?php foreach ($plants as $plant): ?>
                    <a href="/plant?id=<?= $plant["id"] ?>"
                       class="block rounded-lg border border-gray-200 bg-white p-6 shadow-sm hover:shadow-md transition-shadow">
                        <h3 class="text-lg font-semibold text-gray-900"><?= htmlspecialchars(
                            $plant["name"],
                        ) ?></h3>
                        <?php if (!empty($plant["body"])): ?>
                            <p class="mt-2 text-sm text-gray-600 line-clamp-3"><?= htmlspecialchars(
                                $plant["body"],
                            ) ?></p>
                        <?php endif; ?>
                        <span class="mt-3 inline-block rounded-full px-2 py-1 text-xs font-medium
                            <?= $plant["visibility"] === "public"
                                ? "bg-green-100 text-green-800"
                                : "bg-yellow-100 text-yellow-800" ?>">
                            <?= htmlspecialchars($plant["visibility"]) ?>
                        </span>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php require base_path("views/partials/footer.php"); ?>
