<?php
require_once('lib/Log/logger.php'); 
use Data\Log; 

$servername = "localhost";
$username = "admin";
$password = "vivwSHXSLLF9PwGe";


try {
        $conn = new PDO("mysql:host=$servername", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "CREATE DATABASE fh_scm4_bookshop";
        // use exec() because no results are returned
        $conn->exec($sql);
        Log::Write("Database created successfully<br>"); 
    }
catch(PDOException $e)
    {
        //logfile Entry 
        Log::Write($sql . "<br>" . $e->getMessage()); 
    }

$conn = null;
