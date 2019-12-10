<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of Curl
 *
 * @author ASEP-M
 */
class Curl {
    
    public function _get_response($url, $method = 'GET', $params = NULL) {
        set_time_limit(0);
        $curl = curl_init($url);

        // Set curl options
        curl_setopt($curl, CURLOPT_HEADER, false);
        switch ($method) {
            case "GET":

                break;
            case "POST":
                if ($params) {
                    curl_setopt($curl, CURLOPT_POST, TRUE);
                    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($params));
                }
                break;
            case "DELETE":
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
                break;
            case "JSON":
                if ($params) {
                    curl_setopt($curl, CURLOPT_POST, TRUE);
                    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($params));
                    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                        'Content-Type: application/json',
                        'Content-Length: ' . strlen(json_encode($params))
                    ));
                }
                break;
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT_MS, 120000);

        $data = curl_exec($curl);
        $http = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $error = curl_error($curl);

        if ($error) {
            show_error($error, 500, "Error API");
        }

        curl_close($curl);
        
        return array(
            'data' => $data,
            'http' => $http,
            'error' => $error
        );
    }
    
}
