<?php
    function OpenCon()
     {
     $dbhost = "localhost";
     $dbuser = "dyingearth";
     $dbpass = "raspberry";
     $db = "dyingearth";
     $conn = new mysqli($dbhost, $dbuser, $dbpass,$db) or die("Verbindung fehlgeschlagen: %s\n". $conn -> error);
     #$pdo = new PDO('mysql:host="'.$dbhost.'";dbname="'.$db.'", "'.$dbuser.'", ""');
     $value1 = "'".'mysql:host='.$dbhost.';dbname='.$db.''."'";
     echo $value1;
     #$pdo = new PDO($value1, $dbuser, $dbpass);
     $pdo = new PDO('mysql:host='.$dbhost.';dbname='.$db.'', 'root', '');
     return $conn;
     }
     
    function CloseCon($conn)
     {
     $conn -> close();
     }
?>