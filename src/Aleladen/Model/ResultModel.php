<?php


namespace Aleladen\Model;


use Aleladen\Lib\Model;


class ResultModel extends Model
{

    private $url;
    private $result;
    private $pattern = '/data-xml=\"(.*?)\"/';
    private $xmlResource = 'http://mp3.zing.vn/xml/';
    private $songPattern = 'song-xml';
    private $albumPattern = 'album-xml';
    private $videoPattern = 'video-xml';


    public function __construct()
    {
        parent::__construct();
        $this->result = array(
            'message'   => '',
            'type'      => '',
            'data'      => ''
        );
    }


    public function getResult($url)
    {
        $content = $this->getPageSource($url);
        preg_match($this->pattern, $content, $matches);

        if (isset($matches[1]) && (substr($matches[1], 0, 23) === $this->xmlResource)) {
            $link = $matches[1];
            $type = $this->getLinkType($link);

            if ($type === $this->songPattern || $type === $this->albumPattern) {
                $link = str_replace('/xml/', '/html5xml/', $link);
                $this->result['type'] = $type;
                $this->result['data'] = $this->handleResult($this->getPageSource($link)); //handle result
            } elseif ($type === $this->videoPattern) {
                $this->result['type'] = $type;
                $this->result['data'] = $this->getPageSource($link . '?format=json');
            }
        } else {
            $this->result['message'] = "Invalid given URL";
        }

        return json_encode($this->result);
    }


    private function handleResult($pageSource)
    {
        $data = json_decode($pageSource, true)['data'];
        //print_r($data);
        $songs = array();

        for ($i = 0; $i < count($data); $i++) {
            $song['name'] = $data[$i]['name'];
            $song['artist'] = $data[$i]['artist'];
            $downloads = array();

            for ($j = 0; $j < count($data[$i]['source_list']); $j++) {
                $download['quality'] = $data[$i]['qualities'][$j];
                $download['link'] = $data[$i]['source_base'] . '/' . $data[$i]['source_list'][$j];
                array_push($downloads, $download);
            }

            $song['download'] = json_encode($downloads);
            array_push($songs, $song);
        }

        return json_encode($songs);
    }


    private function isUrl($url)
    {
        if (filter_var($url, FILTER_VALIDATE_URL)) {
            return true;
        } else {
            return false;
        }
    }


    private function getPageSource($url)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
        curl_setopt($ch, CURLOPT_ENCODING, 'gzip');
        $content = curl_exec($ch);
        curl_close($ch);
        return $content;
    }


    private function getLinkType($link)
    {
        $arr = explode('/', $link);
        return $arr[4];
    }


}