<?php

namespace Aleladen\Controller;


use Aleladen\Lib\Controller;



class ResultController extends Controller
{
    public function __construct() {
        parent::__construct();
    }


    public function getResult() {
        $url = filter_var($_POST['url'], FILTER_SANITIZE_URL);
        $url = trim($url);
        $this->model = $this->loadModel('result');
        echo $this->model->getResult($url);
    }

}