<?php require base_path("views/partials/head.php"); ?>
<?php require base_path("views/partials/nav.php"); ?>
<?php require base_path("views/partials/banner.php"); ?>

<main>
    <div class="mx-auto max-w-lg py-10 sm:px-6 lg:px-8">
        <?php if ($_SESSION["_flash"]["success"] ?? false): ?>
            <div class="mb-4 rounded-md bg-green-50 p-4">
                <p class="text-sm font-medium text-green-800"><?= htmlspecialchars(
                    $_SESSION["_flash"]["success"],
                ) ?></p>
            </div>
        <?php endif; ?>

        <?php $fieldErrors =
            $_SESSION["_flash"]["errors"] ?? ($errors ?? []); ?>
        <?php require base_path("views/partials/errors.php"); ?>

        <p class="mb-6 text-sm text-gray-600">
            A verification code has been sent to
            <strong><?= htmlspecialchars(
                $_SESSION["user"]["email"] ?? "",
            ) ?></strong>.
            Enter it below to continue.
        </p>

        <form method="POST" action="/verify" class="space-y-6">
            <div>
                <label for="code" class="block text-sm font-medium text-gray-700">Verification Code</label>
                <input type="text" id="code" name="code" maxlength="6" inputmode="numeric" pattern="[0-9]{6}"
                       required autofocus
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm tracking-widest text-center text-lg"
                       placeholder="000000">
            </div>

            <div>
                <button type="submit"
                        class="w-full rounded-md bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    Verify
                </button>
            </div>
        </form>

        <form method="POST" action="/resend-2fa" class="mt-4 text-center">
            <button type="submit" class="text-sm text-indigo-600 hover:text-indigo-500">
                Resend code
            </button>
        </form>
    </div>
</main>

<?php require base_path("views/partials/footer.php"); ?>
