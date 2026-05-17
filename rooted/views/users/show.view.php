<?php require base_path("views/partials/head.php"); ?>
<?php require base_path("views/partials/nav.php"); ?>
<?php require base_path("views/partials/banner.php"); ?>

<main>
    <div class="mx-auto max-w-2xl py-6 sm:px-6 lg:px-8">
        <div class="rounded-lg border border-gray-200 bg-white p-8 shadow-sm">
            <dl class="divide-y divide-gray-200">
                <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                    <dt class="text-sm font-medium text-gray-500">ID</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:col-span-2"><?= $user["id"] ?></dd>
                </div>
                <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                    <dt class="text-sm font-medium text-gray-500">Email</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:col-span-2"><?= htmlspecialchars($user["email"]) ?></dd>
                </div>
                <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                    <dt class="text-sm font-medium text-gray-500">Role</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:col-span-2"><?= $user["role"] ?></dd>
                </div>
                <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                    <dt class="text-sm font-medium text-gray-500">Email verified</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:col-span-2"><?= $user["email_verified"] ? "Yes" : "No" ?></dd>
                </div>
                <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                    <dt class="text-sm font-medium text-gray-500">Created</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:col-span-2"><?= $user["created_at"] ?></dd>
                </div>
            </dl>

            <div class="mt-6">
                <a href="/users" class="text-sm text-indigo-600 hover:text-indigo-500">← Back to users</a>
            </div>
        </div>
    </div>
</main>

<?php require base_path("views/partials/footer.php"); ?>
