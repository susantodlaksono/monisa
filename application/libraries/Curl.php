<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of Curl
 *
 * @author ASEP-M
 */
class Curl {
    
    public function _get_response($url, $method = 'GET', $params = NULL, $return = 'data') {
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

        $data = json_decode(curl_exec($curl), TRUE);
        $http = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        if (curl_error($curl)) {
            show_error(curl_error($curl), 500, "Error API");
        }

        curl_close($curl);
        
        switch ($return) {
            case 'http':
                return $http;
            default:
                return $data;
        }
    }
    
}
