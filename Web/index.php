<?php
include 'connect_db.php';
$conn = OpenCon();
//echo "Connected Successfully";
CloseCon($conn);
header("Location: /Login/"); 
?>

<html>

    <head>
        
    </head>
   
</html>