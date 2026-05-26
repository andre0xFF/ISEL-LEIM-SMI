<?php
    require_once( "../Lib/db.php" );

    $pathConfigFile = ConfigFile;
?>
            <p><b>Notes 1:</b></p>
            <p>Data base settings are located at:</p>
            <p><?php echo $pathConfigFile;?></p>
            <p>Before run this example update your settings (host/port/database name/username/password).</p>
            <p>Please ensure that <code>PHP</code> extensions for <code>mysql</code> are enable:</p>
            <p><code>extension=mysqli</code> in <code><b>php.ini</b></code> file +/- line 898</p>
            <p>Also note that the maximum allowed size for uploaded files is configured by the settings:</p>
            <p><code>upload_max_filesize</code> in <code><b>php.ini</b></code> file +/- line 798</p>
            <p><code>post_max_size</code> in <code><b>php.ini</b></code> file +/- line 646<p>

            <p><b>Notes 2:</b></p>
            <p><a href="https://leafletjs.com/reference.html" target="_blank">OpenStreet Maps API - An open-source JavaScript library for mobile-friendly interactive maps</a></p>
            <p><a href="https://geoapi.pt/docs/" target="_blank">GEO API - Dados gratuitos de Portugal sobre regiões administrativas oficiais, georreferenciação, censos e códigos postais</a></p>