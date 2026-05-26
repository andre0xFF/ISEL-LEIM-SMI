<html>
    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
        <title>Get Elements By</title>

        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

        <link REL="stylesheet" TYPE="text/css" href="../../Styles/GlobalStyle.css">

        <script type="text/javascript">
        <!--        
            function elementById() {
                document.getElementById("fieldWithID").innerHTML = "Acess uing ID";
            }
            function elementByName() {
                var fields;
                fields = document.getElementsByName("fieldWithName");

                for (var idxCurrentField = 0; idxCurrentField < fields.length; idxCurrentField++) {
                    var currentField;
                    currentField = fields[ idxCurrentField ];

                    currentField.innerHTML = "Acess using name - " + (idxCurrentField+10);
                }
            }
            // -->
        </script>
    </head>
  
    <body>
        <h1 align="center">getElementById & getElementsByName</h1>

        <p id="fieldWithID">Nothing</p>

        <p name="fieldWithName"> </p>

        <p name="fieldWithName"> </p>
    
        <script type="text/javascript">
        <!--
            elementById();

            elementByName();
        // -->
        </script>    

    </body>

</html>