<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
    <title>Update user profile - Forms App</title>
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    
    <link REL="stylesheet" TYPE="text/css" href="../Styles/GlobalStyle.css">

    <script type="text/javascript" src="gera.php">
    </script>
    
    <script type="text/javascript" src="scripts/forms.js?v=20260318">
    </script>
  </head>

  <body onLoad="xpto()">
    <form 
      enctype="multipart/form-data"
      action="processFormUpdateProfile.php"
      method="POST"
      onsubmit="return FormUpdateProfileValidator(this)"
      name="FormUpdateProfile">

      Alias:<br>
      <input type="text" size="15" maxlength="15" name="alias" required><br>

      Password:<br>
      <input type="password" size="15" maxlength="15" name="password" required><br>

      Hobbies:<br>
      <table>
        <tr>
          <td>Cars<input type="checkbox" name="hobbyCars"></td>
          <td>Trains<input type="checkbox" name="hobbyTrains"></td>
        </tr>
      </table>

      Age:<br>
      <input type="radio" name="age" value="R1" required> Less than 18<br>
      <input type="radio" name="age" value="R2"> More then 18 and less then 40<br>
      <input type="radio" name="age" value="R3"> More then 40 and less then 65<br>
      <input type="radio" name="age" value="R4"> More 65<br>

      Location:<br>
      <table>
        <tr>
          <td>
            <?php
                require_once( "../Lib/db.php" );
                
                dbConnect( ConfigFile );
                
                $dataBaseName = $GLOBALS['configDataBase']->db;

                mysqli_select_db( $GLOBALS['ligacao'], $dataBaseName );

                $query = "SELECT * FROM `$dataBaseName`.`forms-districts`";
                echo "Query to exec: " . $query ."\n<br>";
            ?>
            District:<br>
            <select 
              onchange="SelectDistrictChange(this)" 
              name="district" 
              id="district" 
              size="1" required>
                <?php
                $queryResult = mysqli_query( $GLOBALS['ligacao'], $query);
                
                if ($queryResult) {
                  echo "<option value=\"\"> </option>\n";
                  while ( $registo = mysqli_fetch_array( $queryResult ) ) {
                    $id = $registo['idDistrict'];
                    $district = $registo['nameDistrict'];
                    echo "                <option value=\"$id\">$district</option>\n";
                  }
                }
                else {
                  echo "                <option value=\"-1\">No districts available</option>\n";
                }
                dbDisconnect();
                ?>
            </select><br>

            County:<br>
            <select 
              onchange="SelectCountyChange(this)"
              name="county" 
              id="county" 
              size="1" required>
            </select><br>

            Zip-code:<br>
            <select 
              name="zip" 
              id="zip" 
              size="1" required>
            </select><br>            
          </td>
          <td>
            <img id="imgDistrict" height="300" src="images/distritos/0.gif">
          </td>
        </tr>
      </table>

      Comments: (Please enter 200 characters maximum.)<br>
      <textarea name="comments" rows="4" cols="50" maxlength="200"></textarea><br>
      
      <br>
      
      <?php

        require_once ("../Lib/db.php");

        dbConnect(ConfigFile);
        $dataBaseName = $GLOBALS['configDataBase']->db;
        mysqli_select_db($GLOBALS['ligacao'], $dataBaseName);

        $queryString = "SELECT `settingName`, `settingValue` FROM `$dataBaseName`.`forms-upload-settings`";

        $queryResult = mysqli_query($GLOBALS['ligacao'], $queryString);


        $MaxFileSize = 0;
        
        $MaxFileSizeUserPicture = 0;

        if($queryResult){
            while ($registo = mysqli_fetch_array($queryResult)){
                $settingName = $registo['settingName'];
                $settingValue = $registo['settingValue'];

                if($settingName == 'max_file_size_photo'){
                    $MaxFileSize = (int)$settingValue;
                }
                if($settingName == 'max_file_size_user'){
                    $MaxFileSizeUserPicture = (int)$settingValue;
                }

            }
        }
        dbDisconnect();
      ?>

      Photo (Max size <?php echo $MaxFileSize; ?>): 
      <input 
        type="hidden" 
        name="MAX_FILE_SIZE" 
        value="<?php echo $MaxFileSize; ?>">
      <input type="file" name="imagePhoto">
      <br>
	  
      Photo (Max size <?php echo $MaxFileSizeUserPicture; ?>): 
      <input 
        type="hidden" 
        name="MAX_FILE_SIZE" 
        value="<?php echo $MaxFileSizeUserPicture; ?>">
      <input type="file" name="imageUser">
      <br>
      
      <br>

      <input type="submit" name="Submit" value="Submit">
      <input type="reset" name="Reset" value="Reset"><p>
    </form>
  </body>
</html>