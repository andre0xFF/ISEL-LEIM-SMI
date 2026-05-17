<?php

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

$plants = $db->query(
    "SELECT * FROM plants WHERE visibility = 'public' ORDER BY created_at DESC LIMIT 20"
)->get();

// Load tags for each plant
foreach ($plants as &$plant) {
    $plant["tags"] = $db->query(
        "SELECT t.name FROM tags t INNER JOIN plant_tag pt ON pt.tag_id = t.id WHERE pt.plant_id = :pid",
        ["pid" => $plant["id"]],
    )->get();
}
unset($plant);

// Load app settings for channel info
$settingsRows = $db->query("SELECT `key`, value FROM settings WHERE `key` IN ('app_name', 'app_url')")->get();
$settings = [];
foreach ($settingsRows as $row) {
    $settings[$row["key"]] = $row["value"];
}

$appName = $settings["app_name"] ?? "Rooted";
$appUrl = $settings["app_url"] ?? "http://localhost";

header("Content-Type: application/rss+xml; charset=UTF-8");

echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<rss version="2.0">
  <channel>
    <title><?= htmlspecialchars($appName) ?></title>
    <link><?= htmlspecialchars($appUrl) ?></link>
    <description>Latest plants from <?= htmlspecialchars($appName) ?></description>
    <language>en</language>
<?php foreach ($plants as $plant): ?>
    <item>
      <title><?= htmlspecialchars($plant["name"]) ?></title>
      <description><?= htmlspecialchars($plant["body"]) ?></description>
      <link><?= htmlspecialchars($appUrl . "/plant?id=" . $plant["id"]) ?></link>
      <pubDate><?= date(DATE_RSS, strtotime($plant["created_at"])) ?></pubDate>
<?php foreach ($plant["tags"] as $tag): ?>
      <category><?= htmlspecialchars($tag["name"]) ?></category>
<?php endforeach; ?>
    </item>
<?php endforeach; ?>
  </channel>
</rss>
<?php
exit();
