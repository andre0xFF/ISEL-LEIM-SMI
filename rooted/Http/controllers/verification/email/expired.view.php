<?php require base_path("views/partials/head.php"); ?>
<?php require base_path("views/partials/nav.php"); ?>
<?php require base_path("views/partials/banner.php"); ?>

    <main>
        <div class="mx-auto max-w-lg py-10 sm:px-6 lg:px-8">
            <div class="rounded-md bg-yellow-50 p-4 mb-6">
                <p class="text-sm font-medium text-yellow-800">
                    This verification link is no longer valid. You can request a new one below.
                </p>
            </div>

            <form method="POST" action="/verify/resend" class="space-y-4">
                <input
                    type="hidden"
                    name="email"
                    value="<?= htmlspecialchars($email) ?>"
                >

                <button
                    type="submit"
                    class="w-full rounded-md bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                >
                    Send new verification email
                </button>
            </form>
        </div>
    </main>

<?php require base_path("views/partials/footer.php"); ?>