<?php
declare(strict_types=1);
error_reporting(E_ALL); 
ini_set('display_errors', 'On');

spl_autoload_register(function ($class) {
   $filename = __DIR__ . '/../lib/' . str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
    if (file_exists($filename)) {
        include($filename);
    }
});

// create session context
Webshop\SessionContext::create();

/* switch different DataManagers */
$class = '';
require_once(__DIR__ .'/../lib/Data/DataManager'  . $class . '.php');