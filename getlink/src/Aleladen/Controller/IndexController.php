<?php

namespace Aleladen\Controller;

use Aleladen\Lib\Controller;

class IndexController extends Controller {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function index() {
        $this->loadView('Index/index');
    }
    
    
}