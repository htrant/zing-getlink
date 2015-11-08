<?php

namespace Aleladen\Lib;


abstract class View {
    
    public static function render($viewName, $notInclude = false) {
        $view = explode('/', $viewName);
        if ($notInclude) {           
            require VIEW . $view[0] . DIRECTORY_SEPARATOR . $view[1] . '.php';
        } else {
            require VIEW . DIRECTORY_SEPARATOR . 'Template' . DIRECTORY_SEPARATOR . 'header.php';
            require VIEW . $view[0] . DIRECTORY_SEPARATOR . $view[1] . '.php';
            require VIEW . DIRECTORY_SEPARATOR . 'Template' . DIRECTORY_SEPARATOR . 'footer.php';
        }
    }
    
    

}