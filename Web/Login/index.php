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
        <style>
        th, td {
          padding: 15px;
          text-align: left;
          border-bottom: 1px solid #ddd;
          border-right:  1px solid #ddd;
          border-left:   1px solid #ddd;
          border-top:    1px solid #ddd;
        }
        table {    
          text-align:center; 
          margin-left:auto; 
          margin-right:auto; 
          width:100px;
        }
        </style>
        <!-- <meta http-equiv="refresh" content="1; URL=/Login/"> -->
    </head>
<body>
<?php
//echo "Hallo Benutzer mit der ID: ".$userid;
?>
<button data-toggle="modal" data-target="#myModal">Click</button>
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Werte</h4>
      </div>
      <div class="modal-body">
        <p>Some text in the modal.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<div>
<table class="table table-hover table-responsive">
  <thead>
    <tr>
      <th scope="col">Name</th>
      <th scope="col">Wert</th>
    </tr>
  </thead>
  <tbody>
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
      <td>Lichtstärke</td>
      <td><a href="?plot=lichtstaerke"><?php print_r($data["0"]["lichtstaerke"]); ?></a></td>
     </tr>
     <tr>
      <td>Temperatur</td>
      <td><a href="?plot=temperatur"><?php print_r($data["0"]["temperatur"]); ?></a></td>
     </tr>
     <tr>
      <td>Luftfeuchtigkeit</td>
      <td><a href="?plot=luftfeuchtigkeit"><?php print_r($data["0"]["luftfeuchtigkeit"]); ?></a></td>
     </tr>
     <tr>
      <td>Status</td>
      <td><a href="?plot=status"><?php print_r($data["0"]["status"]); ?></a></td>
     </tr>
    </tr>
  </tbody>
</table>
</div>

    <?php if (isset($_GET["plot"]))
    {
      $test54321 = 'chart.php?plot='.$_GET["plot"].'';
    } else {
      $test54321 = 'chart.php?plot=temperatur';
    }
    ?>

    <p style="align: 'center';">
    <iframe style="float:middle;" width="600" height="300" frameborder=0 src="<?php echo $test54321 ?>"></iframe> 
    </p>

    <form formmethod="get" action="index.php">
    <table>
    <tr>
      <th>Name</th>
      <th>Farbe</th>
     </tr>
     <tr>
    <td>LED-Band</td>
    <td>
      <input type="radio" name="relais1" value="100"> Red<br>
      <input type="radio" name="relais1" value="010"> Green<br>
      <input type="radio" name="relais1" value="001"> Aus<br>
      <input type="radio" name="relais1" value="110"> Aus<br>
      <input type="radio" name="relais1" value="101"> Aus<br>
      <input type="radio" name="relais1" value="011"> Aus<br>
      <input type="radio" name="relais1" value="111"> Aus<br>
    </td>
    </tr>
    <!--<tr>
    <td>Relais 2</td>
    <td>
      <input type="radio" name="relais2" value="0"> Aus<br>
      <input type="radio" name="relais2" value="1"> An<br>
      </td>
    </tr>
    <tr>
    <td>Relais 3</td>
    <td>
      <input type="radio" name="relais3" value="0"> Aus<br>
      <input type="radio" name="relais3" value="1"> An<br>
      </td>
    </tr> -->
    <!--
    <tr>
    <td>Relais 4</td>
    <td>
      <input type="radio" name="relais4" value="0"> Aus<br>
      <input type="radio" name="relais4" value="1"> An<br>
      </td>
    </tr> 
    -->
    <tr>
    <td>Best&auml;tigung</td>
    <td>
    <input type="submit" value="Submit">
    </td>
    </tr>
    </table>
    </form>

    <?php
    $relais1 = $_GET["relais1"];
    $relais2 = $_GET["relais2"];
    $relais3 = $_GET["relais3"];
    $relais4 = $_GET["relais4"];

    $query = sprintf('UPDATE ralays SET relays1="'.$relais1.'" WHERE id=1;');
    $result = $mysqli->query($query);
    $data = array();
    foreach ($result as $row) {
      $data[] = $row;
    }

    $query = sprintf('UPDATE ralays SET relays2="'.$relais2.'" WHERE id=1;');
    $result = $mysqli->query($query);
    $data = array();
    foreach ($result as $row) {
      $data[] = $row;
    }

    $query = sprintf('UPDATE ralays SET relays3="'.$relais3.'" WHERE id=1;');
    $result = $mysqli->query($query);
    $data = array();
    foreach ($result as $row) {
      $data[] = $row;
    }

    /*$query = sprintf('UPDATE ralays SET relays4="'.$relais4.'" WHERE id=1;');
    $result = $mysqli->query($query);
    $data = array();
    foreach ($result as $row) {
      $data[] = $row;
    }*/
    ?>

</body>
</html>