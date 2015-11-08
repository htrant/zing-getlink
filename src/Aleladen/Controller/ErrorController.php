<?php

namespace Aleladen\Controller;

use Aleladen\Lib\Controller;

class ErrorController extends Controller {

    public function __construct() {
        parent::__construct();
        echo __FILE__;
    }
    
    public function index() {
        
    }

}
