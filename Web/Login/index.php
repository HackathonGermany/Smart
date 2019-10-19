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
//echo "Hallo Benutzer mit der ID: ".$userid;
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
      <td><a href="?plot=Spannung"><?php print_r($data["0"]["Spannung"]); ?></a></td>
     </tr>
     <tr>
      <td>Watt</td>
      <td><a href="?plot=Watt"><?php print_r($data["0"]["Watt"]); ?></a></td>
     </tr>
     <tr>
      <td>lichtstaerke</td>
      <td><a href="?plot=lichtstaerke"><?php print_r($data["0"]["lichtstaerke"]); ?></a></td>
     </tr>
     <tr>
      <td>temperatur</td>
      <td><a href="?plot=temperatur"><?php print_r($data["0"]["temperatur"]); ?></a></td>
     </tr>
     <tr>
      <td>luftfeuchtigkeit</td>
      <td><a href="?plot=luftfeuchtigkeit"><?php print_r($data["0"]["luftfeuchtigkeit"]); ?></a></td>
     </tr>
     <tr>
      <td>status</td>
      <td><a href="?plot=status"><?php print_r($data["0"]["status"]); ?></a></td>
     </tr>
    </table>

    <form formmethod="get" action="index.php">
    <p>Relais 1:</p>
      <input type="radio" name="relais1" value="0"> Aus<br>
      <input type="radio" name="relais1" value="1"> An<br>

    <p>Relais 2:</p>
      <input type="radio" name="relais2" value="0"> Aus<br>
      <input type="radio" name="relais2" value="1"> An<br>

    <p>Relais 3:</p>
      <input type="radio" name="relais3" value="0"> Aus<br>
      <input type="radio" name="relais3" value="1"> An<br>

    <p>Relais 4:</p>
      <input type="radio" name="relais4" value="0"> Aus<br>
      <input type="radio" name="relais4" value="1"> An<br>

    <input type="submit" value="Submit">
    </form>

    <?php
    $relais1 = $_GET["relais1"];
    $relais2 = $_GET["relais2"];
    $relais3 = $_GET["relais3"];
    $relais4 = $_GET["relais4"];

    $query = sprintf('UPDATE ralais SET relais1="'.$relais1.'" WHERE id=1;');
    $result = $mysqli->query($query);
    $data = array();
    foreach ($result as $row) {
      $data[] = $row;
    }

    $query = sprintf('UPDATE ralais SET relais2="'.$relais2.'" WHERE id=1;');
    $result = $mysqli->query($query);
    $data = array();
    foreach ($result as $row) {
      $data[] = $row;
    }

    $query = sprintf('UPDATE ralais SET relais3="'.$relais3.'" WHERE id=1;');
    $result = $mysqli->query($query);
    $data = array();
    foreach ($result as $row) {
      $data[] = $row;
    }

    $query = sprintf('UPDATE ralais SET relais4="'.$relais4.'" WHERE id=1;');
    $result = $mysqli->query($query);
    $data = array();
    foreach ($result as $row) {
      $data[] = $row;
    }
    ?>

    <?php $test54321 = 'chart.php?plot='.$_GET["plot"].''?>
    <iframe style="float:middle;" width="600" height="300" frameborder=0 src="<?php echo $test54321 ?>"></iframe> 

    </body>
</html>