<?php require base_path("views/partials/head.php"); ?>

<main class="flex items-center justify-center min-h-screen">
    <div class="w-full max-w-lg p-8">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Initialize Database</h1>
            <p class="mt-2 text-gray-600">
                The database <strong><?= htmlspecialchars($dbname ?? "rooted") ?></strong> is reachable
                but the schema hasn't been created yet.
            </p>
        </div>

        <!-- Error display -->
        <?php $fieldErrors = $errors ?? []; ?>
        <?php require base_path("views/partials/errors.php"); ?>

        <form method="POST" action="/install/schema" class="space-y-6 bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <p class="text-sm text-gray-600">
                This will create the database (if needed) and all required tables.
                No demo data will be added.
            </p>

            <button type="submit"
                    class="w-full rounded-md bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700">
                Create Tables
            </button>
        </form>
    </div>
</main>

<?php require base_path("views/partials/footer.php"); ?>
