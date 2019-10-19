<?php
session_start();
if(!isset($_SESSION['userid'])) {
    die('Bitte zuerst <a href="login.php">einloggen</a>');
    header("Location: /Login/login.php"); 
}
 
//Abfrage der Nutzer ID vom Login
$userid = $_SESSION['userid'];
 
echo "Hallo User: ".$userid;
?>

<html>
<head>
    <link rel="icon" type="image/vnd.microsoft.icon" href="../assets/media/logo.ico">
</head>
<body>

</body>
</html>