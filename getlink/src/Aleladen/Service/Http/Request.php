<?php

namespace Aleladen\Service\Http;


abstract class Request {
    
    public static function post($url, $params = array()) {
        return self::handleRequest($url, $params, 'POST');
    }
    
    public static function get($url, $params = array()) {
        return self::handleRequest($url, $params, 'GET');
    }
    
    public static function getHtml($url) {
        $response = self::post($url);
        if ($response['status'] == 200) {
            $dom = new \DOMDocument();
            @$dom->loadHTML($url);
            return array(
                'status' => $response['status'],
                'body' => $dom
            );
        } else {
            return array(
                'status' => $response['status']
            );
        }
    }
    
    private static function handleRequest($url, $params, $httpVerb) {
        $curl = curl_init();
        $options = array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_BINARYTRANSFER => 1,
            CURLOPT_POSTFIELDS => $params,
            CURLOPT_CUSTOMREQUEST => $httpVerb
        );
        curl_setopt_array($curl, $options);
        $response = curl_exec($curl);
        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);        
        return array(
            'status' => $status,
            'body'  => $response
        );
    }
    
    
    
}