<?php

namespace Aleladen\Model;

use Aleladen\Lib\Model;
use Aleladen\Service\Http\Request;


class Herunterladen {

    private $vipLink;

    public function __construct() {
        parent::__construct();
        $this->vipLink = "http://mp3.zing.vn/download/vip/song/";
    }
    
    public function herunterladen($url) {
        if ($this->isUrl($url)) {
            $response = $this->deCompress($url);
            return $this->prepResponse($response['body'], $url);
        } else {
            return json_encode(array(
                'status' => 'false',
                'response' => 'Not a valid URL'
            ));
        }
    }
    
    private function isUrl($url) {
        if (filter_var($url, FILTER_VALIDATE_URL)) {
            return true;
        } else {
            return false;
        }
    }
    
    private function prepResponse($subject, $url) {
        $returnArray = array();
        array_push($returnArray, 'true');
        if ($this->isAlbum($subject)) {
            $returnArray['response'] = json_encode($this->buildUrlList($subject));
            
        } else {            
            $returnArray['response'] = json_encode($this->buildSingleUrl($url));
        }
        return json_encode($returnArray);
    }
    
    private function deCompress($url) {
        $response = Request::get($url);
        if (gzdecode($response['body']) == false) {
            return $response;
        } else {
            return array(
                'status' => $response['status'],
                'body' => gzdecode($response['body'])
            );
        }
    }
    
    private function isAlbum($subject) {
        $pattern = "/_divPlsLite\w+/";
        if (preg_match($pattern, $subject) == 1) {
            return true;
        } else {
            return false;
        }
    }
    
    private function buildSingleUrl($url) {
        $temp = explode('/', $url);
        $tempId = explode('.', end($temp));
        $id = $tempId[0];
        $name = $temp[count($temp)-2];
        return array($name => $this->vipLink.$id);
    }
    
    private function buildUrlFromDOM($subject) {
        $dom = new \DOMDocument();
        $dom->loadHTML($subject);
        return $dom;
    }
    

}