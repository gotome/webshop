<?php

namespace Log; 
use Webshop\AuthenticationManager;

class Logger 
{
    public static function Write(string $action) {
        $filename = 'logs/logfile.txt';
        $userName = AuthenticationManager::getAuthenticatedUser()->getUserName(); 
        $strData = $_SERVER['REMOTE_ADDR'] . ' ' . $action . ' ' .  $userName . ' ' . gmdate('Y-m-d H:i:s'); 

        if (!is_writable($filename))
        echo 'Change your CHMOD permissions to ' . $filename; 

        $handle = fopen($filename, 'a+'); 

        fwrite($handle, "\r". $strData); 
        fclose($handle); 
    }


}

