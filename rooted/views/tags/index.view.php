<?php require base_path("views/partials/head.php"); ?>
<?php require base_path("views/partials/nav.php"); ?>
<?php require base_path("views/partials/banner.php"); ?>

<main>
    <div class="mx-auto max-w-4xl py-6 sm:px-6 lg:px-8">

        <!-- Header -->
        <div class="mb-6 flex items-center justify-between">
            <p class="text-sm text-gray-500"><?= count($tags) ?> tag(s)</p>
            <?php if (in_array($_SESSION["user"]["role"] ?? "", ["moderator", "admin"])): ?>
                <a href="/tags/create"
                   class="rounded-md bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700">
                    + Create Tag
                </a>
            <?php endif; ?>
        </div>

        <?php if (empty($tags)): ?>
            <p class="text-gray-500">No tags found.</p>
        <?php else: ?>
            <div class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Creator</th>
                            <th class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php
                            $currentRole = $_SESSION["user"]["role"] ?? "user";
                            $currentUserId = $_SESSION["user"]["id"] ?? 0;
                        ?>
                        <?php foreach ($tags as $tag): ?>
                            <?php
                                $canEditTag = $currentRole === "admin"
                                    || ($currentRole === "moderator" && ($tag["type"] ?? "secondary") === "secondary" && (int)($tag["user_id"] ?? 0) === (int)$currentUserId);
                            ?>
                            <tr>
                                <td class="px-6 py-4 text-sm font-medium text-gray-900"><?= htmlspecialchars($tag["name"]) ?></td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex rounded-full px-2 py-1 text-xs font-medium
                                        <?= ($tag["type"] ?? "secondary") === "primary" ? "bg-purple-100 text-purple-800" : "bg-blue-100 text-blue-800" ?>">
                                        <?= htmlspecialchars($tag["type"] ?? "secondary") ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">user #<?= (int)($tag["user_id"] ?? 0) ?></td>
                                <td class="px-6 py-4 text-right text-sm">
                                    <?php if ($canEditTag): ?>
                                        <a href="/tag/edit?id=<?= $tag["id"] ?>"
                                           class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                        <form method="POST" action="/tag?id=<?= $tag["id"] ?>" class="inline">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit"
                                                    class="text-red-600 hover:text-red-900"
                                                    onclick="return confirm('Delete this tag?')">
                                                Delete
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php require base_path("views/partials/footer.php"); ?>
