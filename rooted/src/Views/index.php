<?php

require "../src/Views/partials/head.php";
require "../src/Views/partials/nav.php";
require "../src/Views/partials/banner.php";

?>

<main>
    <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
        <p>Hello, <?= $_SESSION['user']['email'] ?? 'Guest' ?>. Welcome to the home page.</p>
    </div>
</main>

<?php

require "../src/Views/partials/footer.php";

?>
