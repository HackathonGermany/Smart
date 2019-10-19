<?php
    function OpenCon()
     {
     $dbhost = "localhost";
     $dbuser = "dyingearth";
     $dbpass = "raspberry";
     $db = "dyingearth";
     $conn = new mysqli($dbhost, $dbuser, $dbpass,$db) or die("Verbindung fehlgeschlagen: %s\n". $conn -> error);
     
     return $conn;
     }
     
    function CloseCon($conn)
     {
     $conn -> close();
     }
?>