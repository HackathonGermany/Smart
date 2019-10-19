<?php
session_start();
if(!isset($_SESSION['userid'])) {
    #die('Bitte zuerst <a href="login.php">einloggen</a>');
    header("Location: login.php"); 
}
 
//Abfrage der Nutzer ID vom Login
$userid = $_SESSION['userid'];

//database
define('DB_HOST', '127.0.0.1');
define('DB_USERNAME', 'esp');
define('DB_PASSWORD', 'esp');
define('DB_NAME', 'dyingearth');

//get connection
$mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

$query = sprintf("SELECT MAX(time) FROM data");
$result = $mysqli->query($query);

//loop through the returned data
$data = array();
foreach ($result as $row) {
  $data[] = $row;
}

$test1234 = $data["0"]["MAX(time)"];
$sql = "select * from data where time = '".$test1234."'";
$query = sprintf($sql);
$result = $mysqli->query($query);

$data = array();
foreach ($result as $row) {
  $data[] = $row;
}

#echo '<pre>'; print_r($data["0"]); echo '</pre>';


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
<?php
echo "Hallo Benutzer mit der ID: ".$userid;
?>

    <table>
     <tr>
      <th>Name</th>
      <th>Wert</th>
     </tr>
     <tr>
      <td>Strom</td>
      <td><a href="?plot=Strom"><?php print_r($data["0"]["Strom"]); ?></a></td>
     </tr>
     <tr>
      <td>Spannung</td>
      <td><?php print_r($data["0"]["Spannung"]); ?></td>
     </tr>
     <tr>
      <td>Watt</td>
      <td><?php print_r($data["0"]["Watt"]); ?></td>
     </tr>
     <tr>
      <td>lichtstaerke</td>
      <td><?php print_r($data["0"]["lichtstaerke"]); ?></td>
     </tr>
     <tr>
      <td>temperatur</td>
      <td><?php print_r($data["0"]["temperatur"]); ?></td>
     </tr>
     <tr>
      <td>luftfeuchtigkeit</td>
      <td><?php print_r($data["0"]["luftfeuchtigkeit"]); ?></td>
     </tr>
     <tr>
      <td>status</td>
      <td><?php print_r($data["0"]["status"]); ?></td>
     </tr>
    </table>

    <?php echo 'chart.php?plot=$_GET["plot"]'; $test54321 = 'chart.php?plot=$_GET["plot"]'?>
    <iframe style="float:middle;" width="600" height="300" frameborder=0 src="<?php echo $test54321 ?>"></iframe> 

    </body>
</html>