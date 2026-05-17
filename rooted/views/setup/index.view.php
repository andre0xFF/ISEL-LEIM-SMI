<?php require base_path("views/partials/head.php"); ?>

<main class="flex items-center justify-center min-h-screen">
    <div class="w-full max-w-lg p-8">
        <div class="text-center mb-8">
            <svg class="h-16 w-16 mx-auto" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" fill="none">
                <path d="M32 6C32 6 14 14 14 30c0 8 4 14 10 17" stroke="#818cf8" stroke-width="3" stroke-linecap="round" fill="#a5b4fc" fill-opacity="0.3"/>
                <path d="M32 6C32 6 50 14 50 30c0 8-4 14-10 17" stroke="#818cf8" stroke-width="3" stroke-linecap="round" fill="#a5b4fc" fill-opacity="0.3"/>
                <line x1="32" y1="6" x2="32" y2="44" stroke="#818cf8" stroke-width="3" stroke-linecap="round"/>
                <path d="M32 44 C32 48 28 54 22 58" stroke="#c084fc" stroke-width="2.5" stroke-linecap="round" fill="none"/>
                <path d="M32 44 C32 50 34 56 42 58" stroke="#c084fc" stroke-width="2.5" stroke-linecap="round" fill="none"/>
                <path d="M32 44 C32 50 30 55 32 60" stroke="#c084fc" stroke-width="2.5" stroke-linecap="round" fill="none"/>
            </svg>
            <h1 class="mt-4 text-3xl font-bold text-gray-900">Welcome to Rooted</h1>
            <p class="mt-2 text-gray-600">Let's set up your installation.</p>
        </div>

        <!-- Error display -->
        <?php $fieldErrors = $errors ?? []; ?>
        <?php require base_path("views/partials/errors.php"); ?>

        <form method="POST" action="/setup" class="space-y-6 bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900">Administrator Account</h2>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" id="email" name="email" required
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" id="password" name="password" required
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>

            <h2 class="text-lg font-semibold text-gray-900 pt-4 border-t">SMTP Configuration (optional)</h2>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="smtp_host" class="block text-sm font-medium text-gray-700">SMTP Host</label>
                    <input type="text" id="smtp_host" name="smtp_host" placeholder="smtp.example.com"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>
                <div>
                    <label for="smtp_port" class="block text-sm font-medium text-gray-700">SMTP Port</label>
                    <input type="text" id="smtp_port" name="smtp_port" placeholder="587"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>
            </div>
            <div>
                <label for="smtp_user" class="block text-sm font-medium text-gray-700">SMTP User</label>
                <input type="text" id="smtp_user" name="smtp_user"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>
            <div>
                <label for="smtp_password" class="block text-sm font-medium text-gray-700">SMTP Password</label>
                <input type="password" id="smtp_password" name="smtp_password"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>

            <button type="submit"
                    class="w-full rounded-md bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700">
                Complete Setup
            </button>
        </form>
    </div>
</main>

<?php require base_path("views/partials/footer.php"); ?>
