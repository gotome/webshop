<?php

namespace Log;

class Log 
{
    static public function Write(string $ip, string $action, string $userName, string $timestamp) {
        $filename = 'logs/logfile.txt';
        $strData = $ip . ' ' .  $action . ' ' . $userName . ' ' . $timestamp; 

        if (!is_writable($filename))
        echo 'Change your CHMOD permissions to ' . $filename; 

        $handle = fopen($filename, 'a+'); 

        fwrite($handle, "\r". $strData); 
        fclose($handle); 
    }


}

