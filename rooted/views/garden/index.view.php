<?php require base_path("views/partials/head.php"); ?>
<?php require base_path("views/partials/nav.php"); ?>
<?php require base_path("views/partials/banner.php"); ?>

    <main>
        <div class="mx-auto max-w-5xl py-6 sm:px-6 lg:px-8">

            <?php if (!empty($_SESSION["_flash"]["success"])): ?>
                <div class="mb-4 rounded-md bg-green-50 p-4">
                    <p class="text-sm font-medium text-green-800">
                        <?= htmlspecialchars($_SESSION["_flash"]["success"]) ?>
                    </p>
                </div>
            <?php endif; ?>

            <?php if (empty($gardenPlants)): ?>
                <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
                    <p class="text-sm text-gray-600">Your garden is empty.</p>
                </div>
            <?php else: ?>
                <div class="grid gap-4">
                    <?php foreach ($gardenPlants as $gardenPlant): ?>
                        <article class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
                            <div class="flex items-start justify-between gap-4">
                                <div class="min-w-0 flex-1">
                                    <h2 class="text-lg font-semibold text-gray-900">
                                        <?= htmlspecialchars($gardenPlant["name"]) ?>
                                    </h2>

                                    <?php if (!empty($gardenPlant["body"])): ?>
                                        <p class="mt-2 text-sm text-gray-600">
                                            <?= htmlspecialchars($gardenPlant["body"]) ?>
                                        </p>
                                    <?php endif; ?>

                                    <?php if (!empty($gardenPlant["notes"])): ?>
                                        <div class="mt-3 rounded-md bg-gray-50 p-3">
                                            <p class="text-xs font-medium uppercase tracking-wide text-gray-500">Notes</p>
                                            <p class="mt-1 text-sm text-gray-700">
                                                <?= nl2br(htmlspecialchars($gardenPlant["notes"])) ?>
                                            </p>
                                        </div>
                                    <?php endif; ?>

                                    <div class="mt-4 flex items-center gap-4">
                                        <a href="/garden-plant?id=<?= $gardenPlant["id"] ?>"
                                           class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                                            Open garden entry
                                        </a>

                                        <a href="/plant?id=<?= $gardenPlant["plant_id"] ?>"
                                           class="text-sm font-medium text-gray-600 hover:text-gray-900">
                                            View catalog plant
                                        </a>

                                        <form method="POST" action="/garden-plant?id=<?= $gardenPlant["id"] ?>">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit"
                                                    class="text-sm font-medium text-red-600 hover:text-red-500"
                                                    onclick="return confirm('Remove this plant from your garden?')">
                                                Remove
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                <span class="rounded-full px-2 py-1 text-xs font-medium
                                <?= $gardenPlant["visibility"] === "public"
                                    ? "bg-green-100 text-green-800"
                                    : "bg-yellow-100 text-yellow-800" ?>">
                                <?= htmlspecialchars($gardenPlant["visibility"]) ?>
                            </span>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

        </div>
    </main>

<?php require base_path("views/partials/footer.php"); ?>