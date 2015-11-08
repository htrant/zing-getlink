<?php

namespace Aleladen\Model;

use Aleladen\Lib\Model;
use Aleladen\Service\Http\Request;

class LadenModel extends Model {
    
    private $vipLink;

    public function __construct() {
        parent::__construct();
        $this->vipLink = "http://mp3.zing.vn/download/vip/song/";
    }
    
    public function load($url) {
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
    
    private function deCompress($url) {
        $response = Request::get($url);
        if (gzdecode($response['body']) == false) {
            return $response;
        } else {
            return array(
                'status' => $response['status'],
                'body' => gzinflate(substr($response['body'], 10, -8))
            );
        }
    }
    
    private function prepResponse($subject, $url) {
        $returnArray['status'] = 'true';
        if ($this->isAlbum($subject)) {
            $returnArray['response'] = json_encode($this->buildUrlList($subject));
        } else {
            $returnArray['response'] = json_encode($this->buildSingleUrl($url));
        }
        return json_encode($returnArray);
    }
    
    private function isAlbum($subject) {
        $pattern = "/_divPlsLite\w+/";
        if (preg_match($pattern, $subject) == 1) {
            return true;
        } else {
            return false;
        }
    }
    
    private function buildUrlList($subject) {
        $pattern = "/_divPlsLite\w+/";
        $result = array();
        preg_match_all($pattern, $subject, $result);
        $urlList = array();
        foreach ($result[0] as $item) {
            $temp = explode('sLite', $item);
            $id = end($temp);
            array_push($urlList, $this->vipLink.$id);
        }
        return $urlList;
    }
    
    private function buildSingleUrl($url) {
        $temp = explode('/', $url);
        $tempId = explode('.', end($temp));
        $id = $tempId[0];
        return array($this->vipLink.$id);
    }
    
    
    
    
    

}