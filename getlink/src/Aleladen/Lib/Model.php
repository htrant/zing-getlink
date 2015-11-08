<?php

namespace Aleladen\Lib;


abstract class Model {
    
    protected static $db;
    
    public function __construct() {
        
    }
    
    public static function buildModel($modelName) {
        $obj = null;
        switch (strtolower($modelName)) {
            case 'laden':
                $obj = new \Aleladen\Model\LadenModel();
                break;
            case 'result':
                $obj = new \Aleladen\Model\ResultModel();
                break;
        }
        return $obj;
    }
    
    

}
