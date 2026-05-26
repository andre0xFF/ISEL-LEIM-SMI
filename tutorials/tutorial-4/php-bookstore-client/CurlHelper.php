<?php

class CurlHelper {

    /**
     * Perform an HTTP request using cURL.
     *
     * @param string       $method  HTTP method: GET, POST, PUT
     * @param string       $url     Target URL
     * @param array|false  $data    Optional query/body parameters
     * @return string|false         Response body, or false on failure
     */
    public static function perform_http_request($method, $url, $data = false) {
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

            default: // GET
                if ($data) {
                    $url = sprintf("%s?%s", $url, http_build_query($data));
                }
        }

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($curl);

        curl_close($curl);

        return $result;
    }
}
?>
