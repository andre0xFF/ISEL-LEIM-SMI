        <p>Please ensure that:</p>
        <ul>
            <li>Apache Authentication modules are enable:</li>
            <ul>
                <li><code>LoadModule auth_basic_module modules/mod_auth_basic.so</code> in "httpd.conf" file +/- line 81</li>
                <li><code>LoadModule auth_digest_module modules/mod_auth_digest.so</code> in "httpd.conf" file +/- line 83</li>
            </ul>

            <br>

            <li>Paths in Apache Authentication files are updated:</li>
            <ul>
                <li><code><?php echo "" . __DIR__ . DIRECTORY_SEPARATOR . "Ver1" . DIRECTORY_SEPARATOR . ".htaccess"; ?></code></li>
                <li><code><?php echo "" . __DIR__ . DIRECTORY_SEPARATOR . "Ver2" . DIRECTORY_SEPARATOR . ".htaccess"; ?></code></li>
            </ul>

            <br>
        </ul>

        <p>If <code>UseCanonicalName On</code> update <code>ServerName</code> directive</p>
        <ul>
            <li>in "http.conf" file +/- 205</li>
            <li>in "httpd-ssl.conf" file +/- 87</li>
        </ul>
        <br>
