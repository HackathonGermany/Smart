<?php
session_start();
if(!isset($_SESSION['userid'])) {
    #die('Bitte zuerst <a href="login.php">einloggen</a>');
    header("Location: login.php"); 
}
 
//Abfrage der Nutzer ID vom Login
$userid = $_SESSION['userid'];
 
echo "Hallo User: ".$userid;
?>

<html>
    <head>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <meta lang="deDE" charset="utf-8">
        <link rel="stylesheet" type="text/css" href="../css/style.css">
        <link rel="stylesheet" href="https://stsackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link rel="icon" type="image/vnd.microsoft.icon" href="assets/media/logo.ico">
        <!-- <meta http-equiv="refresh" content="1; URL=/Login/"> -->
    </head>
<body>
        <div class="Haus">
            <div class="data" id="Strom">
            </div>

            <div class="data" id="Spannung">
            </div>

            <div class="data" id="Watt">
            </div>

            <div class="data" id="Lichtstärke">
            </div>

            <div class="data" id="Temperatur">
            </div>
            
            <div class="data" id="Luftfeuchtigkeit">
            </div>

            <div class="data" id="Status">
            </div>

            <div class="data" id="Zeit">
            </div>
        
        </div>
    </body>
</html>