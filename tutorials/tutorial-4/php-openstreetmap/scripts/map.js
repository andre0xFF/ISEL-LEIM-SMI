// ============================================================================
//  Task 4 — OpenStreetMap integration (Leaflet + GeoAPI.pt)
// ============================================================================

const GEOAPI_BASE = "https://json.geoapi.pt";

// ── Map state ───────────────────────────────────────────────────────────────

let theMap;
let layerDistrict = null;
let layerCounty = null;

const defaultCenter = [39.5, -8.0];
const defaultZoom = 7;

// ── Initialise map ──────────────────────────────────────────────────────────

function initMap() {
    theMap = L.map("map", {
        center: defaultCenter,
        zoom: defaultZoom
    });

    L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
        maxZoom: 19
    }).addTo(theMap);
}

// ── District selected ───────────────────────────────────────────────────────

function onDistrictChange() {
    const districtName = document.getElementById("district").value;
    const countySelect = document.getElementById("county");
    const infoBox = document.getElementById("info");

    // Reset county dropdown
    countySelect.innerHTML = '<option value="">— A carregar concelhos… —</option>';
    countySelect.disabled = true;

    // Remove previous layers
    removeLayer("district");
    removeLayer("county");

    if (!districtName) {
        countySelect.innerHTML = '<option value="">— Selecione primeiro um distrito —</option>';
        infoBox.innerHTML = "";
        theMap.flyTo(defaultCenter, defaultZoom);
        return;
    }

    infoBox.innerHTML = "A carregar distrito…";

    fetch(GEOAPI_BASE + "/distrito/" + encodeURIComponent(districtName))
        .then(function (r) { return r.json(); })
        .then(function (json) {
            // ── Draw district boundary ──
            var geojson = json.geojson;
            var bbox = geojson.bbox;

            layerDistrict = L.geoJSON(geojson, { color: "red", weight: 2, fillOpacity: 0.1 });
            layerDistrict.addTo(theMap);

            theMap.flyToBounds(
                L.latLngBounds(
                    L.latLng(bbox[1], bbox[0]),
                    L.latLng(bbox[3], bbox[2])
                )
            );

            // ── Populate county dropdown ──
            var municipios = json.municipios || [];
            countySelect.innerHTML = '<option value="">— Selecione um concelho —</option>';
            municipios.sort().forEach(function (name) {
                var opt = document.createElement("option");
                opt.value = name;
                opt.textContent = name;
                countySelect.appendChild(opt);
            });
            countySelect.disabled = false;

            infoBox.innerHTML =
                "<strong>" + districtName + "</strong><br>" +
                municipios.length + " concelho(s)";
        })
        .catch(function (err) {
            console.error("GeoAPI district error:", err);
            infoBox.innerHTML = '<span style="color:red">Erro ao carregar distrito.</span>';
        });
}

// ── County selected ─────────────────────────────────────────────────────────

function onCountyChange() {
    var countyName = document.getElementById("county").value;
    var infoBox = document.getElementById("info");

    removeLayer("county");

    if (!countyName) {
        return;
    }

    infoBox.innerHTML += "<br>A carregar concelho…";

    fetch(GEOAPI_BASE + "/municipio/" + encodeURIComponent(countyName))
        .then(function (r) { return r.json(); })
        .then(function (json) {
            var geojson = json.geojsons && json.geojsons.municipio;

            if (!geojson) {
                infoBox.innerHTML += '<br><span style="color:orange">Sem GeoJSON para este concelho.</span>';
                return;
            }

            var bbox = geojson.bbox;

            layerCounty = L.geoJSON(geojson, { color: "blue", weight: 2, fillOpacity: 0.15 });
            layerCounty.addTo(theMap);

            theMap.flyToBounds(
                L.latLngBounds(
                    L.latLng(bbox[1], bbox[0]),
                    L.latLng(bbox[3], bbox[2])
                )
            );

            var districtName = document.getElementById("district").value;
            infoBox.innerHTML =
                "<strong>" + districtName + "</strong> &rarr; <strong>" + countyName + "</strong>";
        })
        .catch(function (err) {
            console.error("GeoAPI county error:", err);
            infoBox.innerHTML += '<br><span style="color:red">Erro ao carregar concelho.</span>';
        });
}

// ── Helpers ─────────────────────────────────────────────────────────────────

function removeLayer(which) {
    if (which === "district" && layerDistrict) {
        theMap.removeLayer(layerDistrict);
        layerDistrict = null;
    }
    if (which === "county" && layerCounty) {
        theMap.removeLayer(layerCounty);
        layerCounty = null;
    }
}

// ── Wire everything up ──────────────────────────────────────────────────────

document.addEventListener("DOMContentLoaded", function () {
    initMap();
    document.getElementById("district").addEventListener("change", onDistrictChange);
    document.getElementById("county").addEventListener("change", onCountyChange);
});
