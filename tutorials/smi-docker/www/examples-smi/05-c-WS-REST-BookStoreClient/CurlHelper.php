<?php

class CurlHelper {

    // This method will perform an action/method thru HTTP/API calls
    // Parameter description:
    // Method= POST, PUT, GET etc
    // Data= array("param" => "value") ==> index.php?param=value
    public static function perform_http_request(
            $method,
            $url,
            $data = false) {

        $curl = curl_init();

        switch ($method) {
            case "POST":
                curl_setopt($curl, CURLOPT_POST, 1);

                if ($data) {
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                }
                break;

            case "PUT":
                curl_setopt($curl, CURLOPT_PUT, 1);
                break;

            default:
                if ($data) {
                    $url = sprintf("%s?%s", $url, http_build_query($data));
                }
        }

        // Optional Authentication:
        //curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        //curl_setopt($curl, CURLOPT_USERPWD, "username:password");

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($curl);

        curl_close($curl);

        return $result;
    }
}

/*
  $url = "http://localhost:9080/ServiceBookStore-REST-Tomcat-1.0.0/rest/bookstore";

  echo "Trying to reach ...\n<br>";

  echo $url . "\n<br>";

  echo "Using \"file_get_contents\"...\n<br>";

  $result1 = file_get_contents($url);
  print_r($result1);

  echo "\n<br>Using \"curl\"...\n<br>";

  $action = "GET";
  //$parameters = array("param" => "value");
  $result2 = CurlHelper::perform_http_request($action, $url, $parameters);
  echo print_r($result2);
 */
?>