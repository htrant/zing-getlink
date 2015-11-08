<?php

define('APP_URL', 'http://localhost/aleladen/');

define('SRC', dirname(__FILE__).DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Aleladen'.DIRECTORY_SEPARATOR);
define('VIEW', SRC.'View'.DIRECTORY_SEPARATOR);

define('DB_TYPE', 'mysql');
define('DB_HOST', 'localhost');
define('DB_NAME', 'aleladen');
define('DB_DATASOURCE', DB_TYPE.':host='.DB_HOST.';dbname='.DB_NAME);
define('DB_USER', 'root');
define('DB_PASS', '');