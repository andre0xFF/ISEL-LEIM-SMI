<?php require base_path("views/partials/head.php"); ?>
<?php require base_path("views/partials/nav.php"); ?>
<?php require base_path("views/partials/banner.php"); ?>

<main>
    <div class="mx-auto max-w-4xl py-6 sm:px-6 lg:px-8">

        <?php if (empty($tags)): ?>
            <p class="text-gray-500">No tags available for subscription.</p>
        <?php else: ?>
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                <?php foreach ($tags as $tag): ?>
                    <?php $isSubscribed = in_array((int)$tag["id"], $subscribedTagIds ?? [], true); ?>
                    <div class="flex items-center justify-between rounded-lg border border-gray-200 bg-white p-4 shadow-sm">
                        <div>
                            <h3 class="text-sm font-semibold text-gray-900"><?= htmlspecialchars($tag["name"]) ?></h3>
                            <span class="inline-flex rounded-full px-2 py-0.5 text-xs font-medium mt-1
                                <?= ($tag["type"] ?? "secondary") === "primary" ? "bg-purple-100 text-purple-800" : "bg-blue-100 text-blue-800" ?>">
                                <?= htmlspecialchars($tag["type"] ?? "secondary") ?>
                            </span>
                        </div>
                        <div>
                            <?php if ($isSubscribed): ?>
                                <form method="POST" action="/subscription?id=<?= $tag["id"] ?>">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit"
                                            class="rounded-md bg-red-100 px-3 py-1.5 text-xs font-medium text-red-700 hover:bg-red-200">
                                        Unsubscribe
                                    </button>
                                </form>
                            <?php else: ?>
                                <form method="POST" action="/subscriptions">
                                    <input type="hidden" name="tag_id" value="<?= $tag["id"] ?>">
                                    <button type="submit"
                                            class="rounded-md bg-indigo-100 px-3 py-1.5 text-xs font-medium text-indigo-700 hover:bg-indigo-200">
                                        Subscribe
                                    </button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php require base_path("views/partials/footer.php"); ?>
