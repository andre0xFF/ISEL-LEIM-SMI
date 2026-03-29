<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
        <title>Process login - Forms App</title>
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        
        <link rel="stylesheet" type="text/css" href="../Styles/GlobalStyle.css">


    </head>

    <body>  
    <?php
    require_once("regex.php");

    $method = $_SERVER[ 'REQUEST_METHOD' ];
  
    if ( $method=='POST') {
      $_INPUT_METHOD = INPUT_POST;
	  $_ARGS = $_POST;
    } elseif ( $method=='GET' ) {
      $_INPUT_METHOD = INPUT_GET;
	  $_ARGS = $_GET;
    }
    else {
      echo "Invalid HTTP method (" . $method . ")";
      exit();
    }

    $refreshtime = 5;
    
    $flags[] = FILTER_NULL_ON_FAILURE;
    //$nameFilter = '/^[a-zA-ZÀ-ÿ\s]{1,50}$/u';

    $name = filter_input( $_INPUT_METHOD, 'name', FILTER_UNSAFE_RAW, $flags);
    $email = filter_input( $_INPUT_METHOD, 'email', FILTER_SANITIZE_EMAIL, $flags);

    $name = trim((string)$name);
    $email = trim((string)$email);

    $errors = array();
    

    if($name === "" || !preg_match(toPhpRegex(NAME_REGEX, 'u'), $name)){
        $errors[] = "Name must contain 1 to 50 characters";
    }

    if(!filter_var( $email, FILTER_VALIDATE_EMAIL )){
        $errors[] = "Invalid email format";
    }

      if(!empty($errors)) {

          echo "<html>\n";
          echo "  <head>\n";
          echo "    <meta http-equiv=\"REFRESH\" content=\"$refreshtime;url=formLogin.php\">\n";
          echo "    <title>Forms - PHP App</title>\n";
          echo "  </head>\n";
          echo "  <body>\n";
          echo "    <p> Invalid data!";

              foreach ($errors as $error){
                  echo $error . "<br>\n";
              }

          echo "    <p> You will be redirected to the login page in $refreshtime seconds\n";
          echo "  </body>\n";
          echo "</html>";
        } else {
          echo "<html>\n";
          echo "  <head>\n";
          echo "    <title>Forms - PHP App</title>\n";
          echo "  </head>\n";
          echo "  <body>\n";
          echo "    <p>Hello $name, your e-mail is $email\n<br>";
          echo "    <p><a href=\"formUpdateProfile.php\">Update profile</a>";
          echo "  </body>\n";
          echo "</html>";
          exit();
        }
    ?>
  </body>
</html>
