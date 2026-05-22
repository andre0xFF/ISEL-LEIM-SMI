<?php require base_path("views/partials/head.php"); ?>
<?php require base_path("views/partials/nav.php"); ?>
<?php require base_path("views/partials/banner.php"); ?>

    <main>
        <div class="mx-auto max-w-5xl py-6 sm:px-6 lg:px-8">
            <?php if (!empty($_SESSION["_flash"]["success"])): ?>
                <div class="mb-4 rounded-md bg-green-50 p-4">
                    <p class="text-sm font-medium text-green-800">
                        <?= htmlspecialchars($_SESSION["_flash"]["success"]) ?>
                    </p>
                </div>
            <?php endif; ?>

            <?php $fieldErrors = $_SESSION["_flash"]["errors"] ?? []; ?>
            <?php require base_path("views/partials/errors.php"); ?>
            <article class="rounded-lg border border-gray-200 bg-white p-8 shadow-sm">

                <div class="flex items-start justify-between gap-4">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">
                            <?= htmlspecialchars($gardenPlant["name"]) ?>
                        </h2>

                        <p class="mt-1 text-sm text-gray-500">
                            Added to your garden on <?= htmlspecialchars($gardenPlant["garden_created_at"]) ?>
                        </p>
                    </div>

                    <span class="rounded-full px-2 py-1 text-xs font-medium
                    <?= $gardenPlant["visibility"] === "public"
                        ? "bg-green-100 text-green-800"
                        : "bg-yellow-100 text-yellow-800" ?>">
                    <?= htmlspecialchars($gardenPlant["visibility"]) ?>
                </span>
                </div>

                <?php if (!empty($gardenPlant["body"])): ?>
                    <div class="mt-6 text-gray-700">
                        <?= nl2br(htmlspecialchars($gardenPlant["body"])) ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($gardenPlant["notes"])): ?>
                    <div class="mt-6 rounded-md bg-gray-50 p-4">
                        <h3 class="text-sm font-medium text-gray-900">Notes</h3>
                        <p class="mt-2 text-sm text-gray-700">
                            <?= nl2br(htmlspecialchars($gardenPlant["notes"])) ?>
                        </p>
                    </div>
                <?php endif; ?>

                <div class="mt-8">
                    <h3 class="text-lg font-semibold text-gray-900">My Garden Album</h3>

                    <form method="POST" action="/garden-media" enctype="multipart/form-data" class="mt-4 space-y-4">
                        <input type="hidden" name="garden_plant_id" value="<?= $gardenPlant["id"] ?>">

                        <div>
                            <label for="media" class="block text-sm font-medium text-gray-700">Upload media</label>
                            <input
                                    type="file"
                                    id="media"
                                    name="media"
                                    accept="image/*,video/*,audio/*"
                                    required
                                    class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:rounded-md file:border-0 file:bg-indigo-50 file:py-2 file:px-4 file:text-sm file:font-medium file:text-indigo-700 hover:file:bg-indigo-100"
                            >
                        </div>

                        <div>
                            <button
                                    type="submit"
                                    class="rounded-md bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700"
                            >
                                Upload to Album
                            </button>
                        </div>
                    </form>


                    <?php if (empty($media)): ?>
                        <p class="mt-2 text-sm text-gray-600">
                            No personal media uploaded yet.
                        </p>
                    <?php else: ?>
                        <div class="mt-4 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                            <?php foreach ($media as $item): ?>
                                <div class="rounded-lg border border-gray-200 p-3">
                                    <?php if (str_starts_with($item["mime_type"], "image/")): ?>
                                        <img
                                                src="/garden-media?id=<?= $item["id"] ?>"
                                                alt="<?= htmlspecialchars($item["filename"]) ?>"
                                                class="rounded-lg max-w-full"
                                        >
                                    <?php elseif (str_starts_with($item["mime_type"], "video/")): ?>
                                        <video
                                                controls
                                                src="/garden-media?id=<?= $item["id"] ?>"
                                                class="rounded-lg max-w-full"
                                        ></video>
                                    <?php elseif (str_starts_with($item["mime_type"], "audio/")): ?>
                                        <audio
                                                controls
                                                src="/garden-media?id=<?= $item["id"] ?>"
                                                class="w-full"
                                        ></audio>
                                    <?php endif; ?>

                                    <p class="mt-2 text-xs text-gray-500 truncate">
                                        <?= htmlspecialchars($item["filename"]) ?>
                                    </p>

                                    <form method="POST" action="/garden-media?id=<?= $item["id"] ?>" class="mt-3">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button
                                                type="submit"
                                                class="text-sm font-medium text-red-600 hover:text-red-500"
                                                onclick="return confirm('Remove this media from your garden album?')"
                                        >
                                            Remove media
                                        </button>
                                    </form>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="mt-8 flex items-center gap-4 border-t border-gray-200 pt-6">
                    <a href="/plant?id=<?= $gardenPlant["plant_id"] ?>"
                       class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                        View catalog plant
                    </a>

                    <a href="/my-garden"
                       class="text-sm font-medium text-gray-600 hover:text-gray-900">
                        &larr; Back to My Garden
                    </a>
                </div>
            </article>
        </div>
    </main>

<?php require base_path("views/partials/footer.php"); ?>