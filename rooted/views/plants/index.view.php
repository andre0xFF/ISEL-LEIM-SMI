<?php require base_path("views/partials/head.php"); ?>
<?php require base_path("views/partials/nav.php"); ?>
<?php require base_path("views/partials/banner.php"); ?>

<main>
    <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
        <div class="mb-6 flex items-center justify-between">
            <p class="text-sm text-gray-500"><?= count($plants) ?> plant(s)</p>
            <?php if (in_array($_SESSION["user"]["role"] ?? "", ["moderator", "admin"])): ?>
                <a href="/plants/create" class="rounded-md bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700">
                    + New Plant
                </a>
            <?php endif; ?>
        </div>

        <?php if (empty($plants)): ?>
            <p class="text-gray-500">No plants found.</p>
        <?php else: ?>
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                <?php foreach ($plants as $plant): ?>
                    <a href="/plant?id=<?= $plant["id"] ?>"
                       class="block rounded-lg border border-gray-200 bg-white p-6 shadow-sm hover:shadow-md transition-shadow">
                        <h3 class="text-lg font-semibold text-gray-900"><?= htmlspecialchars($plant["name"]) ?></h3>
                        <?php if ($plant["body"]): ?>
                            <p class="mt-2 text-sm text-gray-600 line-clamp-3"><?= htmlspecialchars($plant["body"]) ?></p>
                        <?php endif; ?>
                        <span class="mt-3 inline-block rounded-full px-2 py-1 text-xs font-medium
                            <?= $plant["visibility"] === "public" ? "bg-green-100 text-green-800" : "bg-yellow-100 text-yellow-800" ?>">
                            <?= $plant["visibility"] ?>
                        </span>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php require base_path("views/partials/footer.php"); ?>
