<?php require base_path("views/partials/head.php"); ?>
<?php require base_path("views/partials/nav.php"); ?>
<?php require base_path("views/partials/banner.php"); ?>

<main>
    <div class="mx-auto max-w-4xl py-6 sm:px-6 lg:px-8">
        <article class="rounded-lg border border-gray-200 bg-white p-8 shadow-sm">
            <div class="flex items-start justify-between">
                <h2 class="text-2xl font-bold text-gray-900"><?= htmlspecialchars($plant["name"]) ?></h2>
                <span class="rounded-full px-2 py-1 text-xs font-medium
                    <?= $plant["visibility"] === "public" ? "bg-green-100 text-green-800" : "bg-yellow-100 text-yellow-800" ?>">
                    <?= $plant["visibility"] ?>
                </span>
            </div>

            <?php if ($plant["body"]): ?>
                <div class="mt-4 prose text-gray-700">
                    <?= nl2br(htmlspecialchars($plant["body"])) ?>
                </div>
            <?php endif; ?>

            <div class="mt-8 flex items-center gap-4">
                <a href="/plant/edit?id=<?= $plant["id"] ?>"
                   class="rounded-md bg-gray-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-gray-700">
                    Edit
                </a>

                <form method="POST" action="/plant?id=<?= $plant["id"] ?>">
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit"
                            class="rounded-md bg-red-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-red-700"
                            onclick="return confirm('Are you sure?')">
                        Delete
                    </button>
                </form>

                <a href="/plants" class="text-sm text-indigo-600 hover:text-indigo-500">← Back to plants</a>
            </div>
        </article>
    </div>
</main>

<?php require base_path("views/partials/footer.php"); ?>
