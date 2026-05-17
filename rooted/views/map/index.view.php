<?php require base_path("views/partials/head.php"); ?>
<?php require base_path("views/partials/nav.php"); ?>
<?php require base_path("views/partials/banner.php"); ?>

<!-- Leaflet CSS & JS (only needed on this page) -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9/dist/leaflet.js"></script>

<main>
    <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">

        <?php
        $geoPlants = array_filter($plants, function ($p) {
            return !empty($p['latitude']) && !empty($p['longitude']);
        });
        ?>

        <?php if (empty($geoPlants)): ?>
            <p class="text-gray-500">No plants with location data found.</p>
        <?php else: ?>
            <div id="map" class="rounded-lg border border-gray-200" style="height: 500px;"></div>

            <script>
                (function () {
                    var plants = <?= json_encode(array_values($geoPlants)) ?>;

                    var map = L.map('map').setView([39.5, -8.0], 6);

                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                    }).addTo(map);

                    plants.forEach(function (plant) {
                        var lat = parseFloat(plant.latitude);
                        var lng = parseFloat(plant.longitude);

                        if (isNaN(lat) || isNaN(lng)) return;

                        var name = document.createElement('span');
                        name.textContent = plant.name;

                        var body = plant.body || '';
                        var truncated = body.length > 100 ? body.substring(0, 100) + '…' : body;

                        var popupContent = '<strong>' + name.textContent + '</strong>';
                        if (truncated) {
                            var bodyEl = document.createElement('span');
                            bodyEl.textContent = truncated;
                            popupContent += '<br>' + bodyEl.innerHTML;
                        }
                        popupContent += '<br><a href="/plant?id=' + encodeURIComponent(plant.id) + '" class="text-indigo-600 hover:underline text-sm">View plant &rarr;</a>';

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
