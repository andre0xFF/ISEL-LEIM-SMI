<?php require base_path("views/partials/head.php"); ?>
<?php require base_path("views/partials/nav.php"); ?>
<?php require base_path("views/partials/banner.php"); ?>

<main>
    <div class="mx-auto max-w-4xl py-6 sm:px-6 lg:px-8">
        <article class="rounded-lg border border-gray-200 bg-white p-8 shadow-sm">

            <!-- Title, visibility badge, author -->
            <div class="flex items-start justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900"><?= htmlspecialchars(
                        $plant["name"],
                    ) ?></h2>
                    <p class="mt-1 text-sm text-gray-500">By <?= htmlspecialchars(
                        $plant["user_email"] ?? "unknown",
                    ) ?></p>
                </div>
                <span class="rounded-full px-2 py-1 text-xs font-medium
                    <?= $plant["visibility"] === "public"
                        ? "bg-green-100 text-green-800"
                        : "bg-yellow-100 text-yellow-800" ?>">
                    <?= htmlspecialchars($plant["visibility"]) ?>
                </span>
            </div>

            <!-- Body -->
            <?php if (!empty($plant["body"])): ?>
                <div class="mt-6 prose max-w-none text-gray-700">
                    <?= nl2br(htmlspecialchars($plant["body"])) ?>
                </div>
            <?php endif; ?>

            <!-- Media gallery -->
            <?php if (!empty($media)): ?>
                <div class="mt-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Media</h3>
                    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                        <?php foreach ($media as $item): ?>
                            <div class="rounded-lg border border-gray-200 p-2">
                                <?php if (
                                    str_starts_with(
                                        $item["mime_type"],
                                        "image/",
                                    )
                                ): ?>
                                    <img src="/media?id=<?= $item[
                                        "id"
                                    ] ?>" alt="<?= htmlspecialchars(
    $item["original_name"] ?? "media",
) ?>" class="rounded-lg max-w-full">
                                <?php elseif (
                                    str_starts_with(
                                        $item["mime_type"],
                                        "video/",
                                    )
                                ): ?>
                                    <video controls src="/media?id=<?= $item[
                                        "id"
                                    ] ?>" class="rounded-lg max-w-full"></video>
                                <?php elseif (
                                    str_starts_with(
                                        $item["mime_type"],
                                        "audio/",
                                    )
                                ): ?>
                                    <audio controls src="/media?id=<?= $item[
                                        "id"
                                    ] ?>" class="w-full"></audio>
                                <?php endif; ?>
                                <?php if (!empty($item["original_name"])): ?>
                                    <p class="mt-1 text-xs text-gray-500 truncate"><?= htmlspecialchars(
                                        $item["original_name"],
                                    ) ?></p>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Tags -->
            <?php if (!empty($tags)): ?>
                <div class="mt-6">
                    <h3 class="text-sm font-medium text-gray-500 mb-2">Tags</h3>
                    <div class="flex flex-wrap gap-2">
                        <?php foreach ($tags as $tag): ?>
                            <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-medium
                                <?= ($tag["type"] ?? "secondary") === "primary"
                                    ? "bg-purple-100 text-purple-800"
                                    : "bg-blue-100 text-blue-800" ?>">
                                <?= htmlspecialchars($tag["name"]) ?>
                            </span>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Meta-information -->
            <?php if (!empty($meta)): ?>
                <div class="mt-6">
                    <h3 class="text-sm font-medium text-gray-500 mb-2">Details</h3>
                    <table class="min-w-full divide-y divide-gray-200 border border-gray-200 rounded-md text-sm">
                        <tbody class="divide-y divide-gray-100">
                            <?php foreach ($meta as $m): ?>
                                <tr>
                                    <td class="px-4 py-2 font-medium text-gray-700 bg-gray-50 w-1/3"><?= htmlspecialchars(
                                        $m["key"],
                                    ) ?></td>
                                    <td class="px-4 py-2 text-gray-600"><?= htmlspecialchars(
                                        $m["value"],
                                    ) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>

            <!-- Weather -->
            <?php if (!empty($weather)): ?>
                <div class="mt-6">
                    <h3 class="text-sm font-medium text-gray-500 mb-2">Current Weather</h3>
                    <div class="flex items-center gap-6 rounded-md border border-gray-200 bg-gray-50 px-4 py-3">
                        <div class="text-center">
                            <span class="text-2xl font-bold text-gray-900"><?= $weather[
                                "temperature"
                            ] ?>°C</span>
                        </div>
                        <div class="text-sm text-gray-600">
                            <p>Humidity: <?= $weather["humidity"] ?>%</p>
                            <p>Conditions: <?= htmlspecialchars(
                                $weather["description"],
                            ) ?></p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Share buttons -->
            <div class="mt-6 flex items-center gap-3">
                <span class="text-sm font-medium text-gray-500">Share:</span>
                <?php
                $shareUrl = urlencode(
                    ($_ENV["APP_URL"] ?? "http://localhost") .
                        "/plant?id=" .
                        $plant["id"],
                );
                $shareTitle = urlencode($plant["name"]);
                ?>
                <a href="https://www.facebook.com/sharer/sharer.php?u=<?= $shareUrl ?>"
                   target="_blank" rel="noopener noreferrer"
                   class="inline-flex items-center gap-1 rounded-md bg-blue-600 px-3 py-1.5 text-xs font-medium text-white hover:bg-blue-700">
                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/></svg>
                    Facebook
                </a>
                <a href="https://twitter.com/intent/tweet?url=<?= $shareUrl ?>&text=<?= $shareTitle ?>"
                   target="_blank" rel="noopener noreferrer"
                   class="inline-flex items-center gap-1 rounded-md bg-sky-500 px-3 py-1.5 text-xs font-medium text-white hover:bg-sky-600">
                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z"/></svg>
                    Twitter
                </a>
            </div>

            <!-- Actions -->
            <div class="mt-8 flex items-center gap-4 border-t border-gray-200 pt-6">
                <?php if (!empty($canEdit)): ?>
                    <a href="/plant/edit?id=<?= $plant["id"] ?>"
                       class="rounded-md bg-gray-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-gray-700">
                        Edit
                    </a>
                    <form method="POST" action="/plant?id=<?= $plant["id"] ?>">
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit"
                                class="rounded-md bg-red-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-red-700"
                                onclick="return confirm('Are you sure you want to delete this plant?')">
                            Delete
                        </button>
                    </form>
                <?php endif; ?>
                <a href="/plants" class="text-sm text-indigo-600 hover:text-indigo-500">&larr; Back to plants</a>
                <?php if (!empty($canEdit) && !empty($media)): ?>
                    <button type="button" onclick="identifyPlant()" class="rounded-md bg-emerald-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-emerald-700">
                        🌿 Identify Plant
                    </button>
                    <div id="identify-results" class="hidden mt-2 text-sm text-gray-600"></div>
                <?php endif; ?>
            </div>
        </article>
    </div>
<?php
$firstImageId = null;
foreach ($media as $m) {
    if (str_starts_with($m["mime_type"], "image/")) {
        $firstImageId = $m["id"];
        break;
    }
}
?>
<?php if (!empty($canEdit) && $firstImageId): ?>
<script>
async function identifyPlant() {
    const resultsDiv = document.getElementById('identify-results');
    resultsDiv.classList.remove('hidden');
    resultsDiv.innerHTML = 'Identifying...';

    try {
        const imgResponse = await fetch('/media?id=<?= $firstImageId ?>');
        const blob = await imgResponse.blob();

        const formData = new FormData();
        formData.append('image', blob, 'plant.jpg');

        const response = await fetch('/identify', { method: 'POST', body: formData });
        const data = await response.json();

        if (data.results && data.results.length > 0) {
            let html = '<strong>Possible matches:</strong><ul class="mt-1 list-disc pl-5">';
            data.results.forEach(r => {
                html += '<li>' + r.name + ' (' + (r.score * 100).toFixed(1) + '%)</li>';
            });
            html += '</ul>';
            resultsDiv.innerHTML = html;
        } else {
            resultsDiv.innerHTML = 'Could not identify. Ensure a PlantNet API key is configured in Settings.';
        }
    } catch (e) {
        resultsDiv.innerHTML = 'Identification failed: ' + e.message;
    }
}
</script>
<?php endif; ?>
</main>

<?php require base_path("views/partials/footer.php"); ?>
