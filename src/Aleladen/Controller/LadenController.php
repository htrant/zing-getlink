<?php

namespace Aleladen\Controller;

use Aleladen\Lib\Controller;

class LadenController extends Controller {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function load() {
        $url = filter_var($_POST['url'], FILTER_SANITIZE_URL);
        $this->model = $this->loadModel('laden');
        echo $this->model->load($url);
    }
    
    public function herunterladen() {
        $url = filter_var($_POST['url'], FILTER_SANITIZE_URL);
        $this->model = $this->loadModel('herunterladen');
        
    }
    
    
    
    
}