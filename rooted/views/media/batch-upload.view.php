<?php require base_path("views/partials/head.php"); ?>
<?php require base_path("views/partials/nav.php"); ?>
<?php require base_path("views/partials/banner.php"); ?>

<main>
    <div class="mx-auto max-w-lg py-10 sm:px-6 lg:px-8">
        <?php $fieldErrors = $errors ?? []; ?>
        <?php require base_path("views/partials/errors.php"); ?>

        <form method="POST" action="/media/batch-upload" enctype="multipart/form-data" class="space-y-6">

            <!-- ZIP file input -->
            <div>
                <label for="zipfile" class="block text-sm font-medium text-gray-700">ZIP File</label>
                <input type="file" id="zipfile" name="zipfile" accept=".zip" required
                       class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:rounded-md file:border-0 file:bg-indigo-50 file:py-2 file:px-4 file:text-sm file:font-medium file:text-indigo-700 hover:file:bg-indigo-100">
                <p class="mt-1 text-xs text-gray-500">Upload a .zip file containing media files and a metadata.xml file.</p>
            </div>

            <!-- Expected XML structure -->
            <div>
                <h3 class="text-sm font-medium text-gray-700 mb-2">Expected XML Structure</h3>
                <pre class="rounded-md bg-gray-50 border border-gray-200 p-4 text-xs text-gray-800 overflow-x-auto">&lt;plants&gt;
  &lt;plant&gt;
    &lt;name&gt;Plant Name&lt;/name&gt;
    &lt;body&gt;Description&lt;/body&gt;
    &lt;visibility&gt;public&lt;/visibility&gt;
    &lt;tags&gt;&lt;tag&gt;TagName&lt;/tag&gt;&lt;/tags&gt;
    &lt;meta&gt;&lt;item key=&quot;Key&quot; value=&quot;Value&quot;/&gt;&lt;/meta&gt;
    &lt;files&gt;&lt;file&gt;filename.jpg&lt;/file&gt;&lt;/files&gt;
  &lt;/plant&gt;
&lt;/plants&gt;</pre>
            </div>

            <!-- Submit -->
            <div class="flex items-center justify-between">
                <a href="/plants" class="text-sm text-gray-500 hover:text-gray-700">&larr; Back to Plants</a>
                <button type="submit"
                        class="rounded-md bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    Upload
                </button>
            </div>
        </form>
    </div>
</main>

<?php require base_path("views/partials/footer.php"); ?>
