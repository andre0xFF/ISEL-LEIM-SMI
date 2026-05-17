<?php if (!empty($fieldErrors)): ?>
    <div class="mb-4 rounded-md bg-red-50 p-4">
        <div class="flex">
            <div class="ml-3">
                <h3 class="text-sm font-medium text-red-800">There were errors with your submission:</h3>
                <div class="mt-2 text-sm text-red-700">
                    <ul class="list-disc space-y-1 pl-5">
                        <?php foreach ($fieldErrors as $error): ?>
                            <li><?= htmlspecialchars($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
