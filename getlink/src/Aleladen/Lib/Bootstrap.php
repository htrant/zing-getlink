<?php

namespace Aleladen\Lib;

use Aleladen\Controller\IndexController;
use Aleladen\Controller\ErrorController;
use Aleladen\Lib\Controller;

class Bootstrap {
	
	private $url;
        private $params;
	private $controller;
	
        
	public function __construct() {
            $this->url = null;
            $this->params = null;
            $this->controller = null;
	}
        
        
	public function init() {
            $this->params = $this->getParams();
            $this->url = $this->getUrl();
                        
            if (empty($this->url[0])) {
                $this->loadDefaultController();
            } else {
                $this->loadExistingController();
                $this->callControllerMethod();
            }
	}
	
        
        private function getUrl() {
            if (isset($_GET['url'])) {
                $url = filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL);
                return explode('/', $url);
            } else {
                return null;
            }
	}
        
        
        private function getParams() {
            $params = $_GET;
            unset($params['url']);
            return $params;             
        }
	
        
	private function loadDefaultController() {
            $this->controller = Controller::buildController('index');            
            $this->controller->index();
	}
	
        
	private function loadExistingController() {            
            $this->controller = Controller::buildController(strtolower($this->url[0]));
	}
	
	
	/**
	 * If a method is passed in GET url parameter
  	 * eg url: http://URL/controller/method/(param)/(param)/(param)
	 * url[0] = Controller
	 * url[1] = Method
	 * url[2] = param
	 * url[3] = param
	 * url[4] = param
	 */
	private function callControllerMethod(){
            $urlLength = count($this->url);
            
            if ($urlLength > 1) {
                if (!method_exists($this->controller, $this->url[1])) {
                    $this->doError();
                }
            }
            
            switch ($urlLength) {
                case 5:                    
                    $this->controller->{$this->url[1]}($this->url[2], $this->url[3], $this->url[4]);
                    break;
                case 4:
                    $this->controller->{$this->url[1]}($this->url[2], $this->url[3]);
                    break;
                case 3:
                    $this->controller->{$this->url[1]}($this->url[2]);
                    break;
                case 2:
                    $this->controller->{$this->url[1]}();
                    break;
                default:                    
                    //print_r($this->url);
                    $this->controller->index();
                    break;
            }
	}
		
	
	private function doError() {
            $this->controller = Controller::buildController('error');
            $this->controller->index();
            exit;
	}
	
}