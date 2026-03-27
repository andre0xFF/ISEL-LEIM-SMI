<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
    <title>PHP - Tags</title>
  </head>
  <body>
    <?php
      echo "This is an instruction.\n<br>\n";
      echo "This is another instruction.\n<br>";
      echo "And another instruction.\n<br>";
      echo "Hello\n";
      
      echo "Ola\n<br>";
      
      echo "ole\n<hr>";

    ?>
    
    <?php
      echo "    Using the &lt;?php ... ?&gt; tag\n<br>";
    ?>
      
    <?
      echo "    Using the &lt;? ... ?&gt; tag. Requires flag <code>short_open_tag=On</code> in \"php.ini\" file\n<br>";
    ?>
    
    <%
      echo "    Using the &lt;% ... %&gt; tag. Requires flag <code>asp_tags=On</code> on \"php.ini\" file\n<br>";
    %>
      
    <script language="php">
      echo "    <p>Using the &lt;script language=\"php\"&gt ... &lt;/script&gt tag\n<br>";
    </script>
  </body>
</html>
