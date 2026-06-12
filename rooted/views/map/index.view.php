<?php require base_path("views/partials/head.php"); ?>
<?php require base_path("views/partials/nav.php"); ?>
<?php require base_path("views/partials/banner.php"); ?>

<!-- Leaflet CSS & JS (only needed on this page) -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9/dist/leaflet.js"></script>

<main>
    <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">

        <p class="mb-4 text-sm text-gray-500">
            Gardens shared by the community. Add a location to your own garden in your
            <a href="/profile" class="text-indigo-600 hover:underline">profile</a> to appear here.
        </p>

        <?php // Build a clean payload for the map: only gardens with usable coordinates,


        // and a display name derived from the email local-part (avoids exposing the full address).
        $mapGardens = [];
        foreach ($gardens as $g) {
            $emailLocal = explode("@", $g["email"])[0];
            $mapGardens[] = [
                "name" => $emailLocal,
                "latitude" => $g["latitude"],
                "longitude" => $g["longitude"],
                "plants" => array_map(
                    fn($p) => ["id" => $p["id"], "name" => $p["name"]],
                    $g["plants"],
                ),
            ];
        }
        ?>

        <?php if (empty($mapGardens)): ?>
            <p class="text-gray-500">No gardens with location data yet.</p>
        <?php else: ?>
            <div id="map" class="rounded-lg border border-gray-200" style="height: 500px;"></div>

            <script>
                (function () {
                    var gardens = <?= json_encode($mapGardens) ?>;

                    var map = L.map('map').setView([39.5, -8.0], 6);

                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                    }).addTo(map);

                    gardens.forEach(function (garden) {
                        var lat = parseFloat(garden.latitude);
                        var lng = parseFloat(garden.longitude);

                        if (isNaN(lat) || isNaN(lng)) return;

                        var owner = document.createElement('span');
                        owner.textContent = garden.name;

                        var popupContent = '<strong>' + owner.innerHTML + "'s garden</strong>";

                        if (garden.plants.length > 0) {
                            popupContent += '<br><span class="text-sm">Grows:</span><ul style="margin:4px 0 0 16px; padding:0; list-style:disc;">';
                            garden.plants.forEach(function (plant) {
                                var nameEl = document.createElement('span');
                                nameEl.textContent = plant.name;
                                popupContent += '<li><a href="/plant?id=' + encodeURIComponent(plant.id) + '" class="text-indigo-600 hover:underline">' + nameEl.innerHTML + '</a></li>';
                            });
                            popupContent += '</ul>';
                        } else {
                            popupContent += '<br><span class="text-sm text-gray-500">No plants yet.</span>';
                        }

                        L.marker([lat, lng])
                            .addTo(map)
                            .bindPopup(popupContent);
                    });
                })();
            </script>
        <?php endif; ?>
    </div>
</main>

<?php require base_path("views/partials/footer.php"); ?>
