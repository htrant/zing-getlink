<?php

namespace Aleladen\Lib;


abstract class Controller {
    
    protected $model;
    protected $view;
    
    public function __construct() {}
        
    public static function buildController($controllerName) {
        $objName = '\\Aleladen\\Controller\\' . ucfirst($controllerName) . 'Controller';
        $obj = new $objName();
        return $obj;
    }
    
    public function loadView($viewName) {
        $this->view = View::render($viewName);
    }    
    
    public function loadModel($modelName) {
        $this->model = Model::buildModel($modelName);
        return $this->model;
    }
    
    
    public function viewError() {
        
    }
    
    
    
    
    
}