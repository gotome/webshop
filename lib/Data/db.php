<?php
use Log\ConsoleWrite; 

$servername = "localhost";
$username = "fh_2020_scm4";
$password = "fh_2020_scm4";


try {
        $conn = new PDO('mysql:host=localhost;dbname=fh_2020_scm4_S1810307037', $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM role ORDER BY id DESC";
        foreach ($conn->query($sql) as $row) {
           echo $row['name']."<br />";
           echo $row['bitCode']."<br />";
        }        
    
    }
catch(PDOException $e)
    {
        //logfile Entry 
        ConsoleWrite::writeToConsole($sql . "<br>" . $e->getMessage()); 
    }

$conn = null;
