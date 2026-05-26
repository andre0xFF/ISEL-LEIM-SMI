<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task 4 — OpenStreetMap + 06-Forms</title>

    <!-- Leaflet CSS (v1.9.4) -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
          integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
          crossorigin="">

    <link rel="stylesheet" href="styles/map.css">
</head>
<body>

<h2>Task 4 &mdash; OpenStreetMap Integration</h2>
<p>Select a district (and optionally a county) to display its boundary on the map.</p>

<div class="layout">
    <!-- ── Left panel: form ── -->
    <div class="panel">
        <label for="district"><strong>Distrito:</strong></label>
        <select id="district" name="district">
            <option value="">— Selecione um distrito —</option>
            <?php
            $districts = [
                "Aveiro", "Beja", "Braga", "Bragança",
                "Castelo Branco", "Coimbra", "Évora", "Faro",
                "Guarda", "Leiria", "Lisboa", "Portalegre",
                "Porto", "Santarém", "Setúbal", "Viana do Castelo",
                "Vila Real", "Viseu"
            ];
            foreach ($districts as $d) {
                echo "<option value=\"$d\">$d</option>\n";
            }
            ?>
        </select>

        <label for="county"><strong>Concelho:</strong></label>
        <select id="county" name="county" disabled>
            <option value="">— Selecione primeiro um distrito —</option>
        </select>

        <div id="info" class="info-box"></div>
    </div>

    <!-- ── Right panel: map ── -->
    <div id="map"></div>
</div>

<!-- Leaflet JS (v1.9.4) -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
        crossorigin=""></script>

<script src="scripts/map.js"></script>

</body>
</html>
