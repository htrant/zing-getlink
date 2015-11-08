<?php

require 'config.php';
require 'SplClassLoader.php';

$loader = new SplClassLoader('Aleladen', __DIR__.'/src');
$loader->register();

use Aleladen\Lib\Bootstrap;

$bootstrap = new Bootstrap();
$bootstrap->init();