<?php

namespace Data;

class Log 
{
    static public function Write($strData) {
        $filename = 'logs/logfile.txt';
        if (!is_writable($filename))
        echo 'Change your CHMOD permissions to ' . $filename; 

        $handle = fopen($filename, 'a+'); 

        fwrite($handle, "\r". $strData); 
        fclose($handle); 
    }
}


