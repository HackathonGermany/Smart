<?php
    function OpenCon()
     {
     $dbhost = "192.168.1.179";
     $dbuser = "dyingearth";
     $dbpass = "raspberry";
     $db = "dyingearth";
     $conn = new mysqli($dbhost, $dbuser, $dbpass,$db) or die("Verbindung fehlgeschlagen: %s\n". $conn -> error);
     $pdo = new PDO('mysql:host="'.$dbhost.'";dbname="'.$db.'", "'.$dbuser.'", ""');
     return $conn;
     }
     
    function CloseCon($conn)
     {
     $conn -> close();
     }
?>