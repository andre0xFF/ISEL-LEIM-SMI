<?php require base_path("views/partials/head.php"); ?>
<?php require base_path("views/partials/nav.php"); ?>
<?php require base_path("views/partials/banner.php"); ?>

<main>
    <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
        <div class="overflow-hidden rounded-lg border border-gray-200 shadow-sm">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Role</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Verified</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Created</th>
                        <th class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500"><?= $user["id"] ?></td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900"><?= htmlspecialchars($user["email"]) ?></td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm">
                                <span class="inline-flex rounded-full px-2 text-xs font-semibold leading-5
                                    <?= match($user["role"]) {
                                        "admin" => "bg-purple-100 text-purple-800",
                                        "moderator" => "bg-blue-100 text-blue-800",
                                        default => "bg-gray-100 text-gray-800",
                                    } ?>">
                                    <?= $user["role"] ?>
                                </span>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500"><?= $user["email_verified"] ? "✓" : "✗" ?></td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500"><?= $user["created_at"] ?></td>
                            <td class="whitespace-nowrap px-6 py-4 text-right text-sm">
                                <a href="/user?id=<?= $user["id"] ?>" class="text-indigo-600 hover:text-indigo-500">View</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<?php require base_path("views/partials/footer.php"); ?>
