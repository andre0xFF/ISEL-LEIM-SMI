<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
        <title>Image Processing</title>

        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

        <link rel="stylesheet" typr="text/css" href="../Styles/GlobalStyle.css">
    </head>

    <body>
        <h2 align="center">Resize, Water-mark, Captcha, Graphs...</h2>

        <table border="2" width="100%">
            <tr>
                <td>
                    <b>
                        This example needs some special configurations.<br>

                        Please before install it on your computer 
                        <a target="_blank" href="https://2021moodle.isel.pt/pluginfile.php/1004188/mod_folder/content/0/10-Images-Configurations.pdf?forcedownload=1">read the supporting slides</a>, as well as, 
                        <a target="_blank" href="https://2021moodle.isel.pt/pluginfile.php/1004188/mod_folder/content/0/10-Images-DataBase.pdf?forcedownload=1">the data base configurations</a>.<br>
                        
                        <br>
                        <p>Please ensure that <code>PHP</code> extensions, <code>fileinfo</code>, <code>gd</code> and <code>exif</code> are enable:</p>
                        <p><code>extension=fileinfo</code> in <code><b>php.ini</b></code> file +/- line 924</p>
                        <p><code>extension=gd</code> in <code><b>php.ini</b></code> file +/- line 925</p>
                        <p><code>extension=exif</code> in <code><b>php.ini</b></code> file +/- line 932</p>
                    </b> 
                </td>
            </tr>    
        </table>    

        <h3 align="center">Useful links</h3>

<?php
    include_once( "links.inc" );
?>
        <br>
        <div class="visitorContainer">
            <div class="visitorText">You are visitor number:</div>
            <div><img class="visitorIcon" src="../Lib/lib-counter.php?counterId=1"></div>
        </div>
    </body>
</html>
