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
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">        <meta lang="deDE" charset="utf-8">
        <link rel="stylesheet" type="text/css" href="../css/style.css">
        <link rel="stylesheet" href="https://stsackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
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

<div>
<!-- Modal for Strom-->
<div id="stromModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Strom - Graph</h4>
      </div>
      <div class="modal-body">
        <iframe style="float:middle;" width="100%" frameborder=0 height="300px" src="chart.php?plot=strom"></iframe> 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<!-- Modal for Spannung-->
<div id="spannungModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Spannung - Graph</h4>
      </div>
      <div class="modal-body">
        <iframe style="float:middle;" width="100%" frameborder=0 height="300px" src="chart.php?plot=spannung"></iframe> 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<!-- Modal for Watt-->
<div id="wattModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Watt - Graph</h4>
      </div>
      <div class="modal-body">
        <iframe style="float:middle;" width="100%" frameborder=0 height="300px" src="chart.php?plot=watt"></iframe> 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<!-- Modal for Lichtstärke-->
<div id="lichtstaerkeModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Lichtstärke - Graph</h4>
      </div>
      <div class="modal-body">
        <iframe style="float:middle;" width="100%" frameborder=0 height="300px" src="chart.php?plot=lichtstaerke"></iframe> 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<!-- Modal for temperature-->
<div id="temperatureModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Temperatur - Graph</h4>
      </div>
      <div class="modal-body">
        <iframe style="float:middle;" width="100%" frameborder=0 height="300px" src="chart.php?plot=temperatur"></iframe> 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<!-- Modal for luftfeuchtigkeit-->
<div id="luftfeuchtigkeitModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Leuftfeuchtigkeit - Graph</h4>
      </div>
      <div class="modal-body">
        <iframe style="float:middle;" width="100%" frameborder=0 height="300px" src="chart.php?plot=luftfeuchtigkeit"></iframe> 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<!-- Modal for state-->
<div id="statusModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Status - Graph</h4>
      </div>
      <div class="modal-body">
        <iframe style="float:middle;" width="100%" frameborder=0 height="300px" src="chart.php?plot=status"></iframe> 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
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
      <td><a data-target="#stromModal" data-toggle="modal" href="#stromModal"><?php print_r($data["0"]["Strom"]); ?></a></td>
    </tr>
    <tr>
      <td>Spannung</td>
      <td><a data-target="#spannungModal" data-toggle="modal" href="#spannungModal"><?php print_r($data["0"]["Spannung"]); ?></a></td>
    </tr>
    <tr>
      <td>Watt</td>
      <td><a data-target="#wattModal" data-toggle="modal" href="#wattModal"><?php print_r($data["0"]["Watt"]); ?></a></td>
    </tr>
    <tr>
      <td>Lichtstärke</td>
      <td><a data-target="#lichtstaerkeModal" data-toggle="modal" href="#lichtstaerkeModal"><?php print_r($data["0"]["lichtstaerke"]); ?></a></td>
     </tr>
     <tr>
      <td>Temperatur</td>
      <td><a data-target="#temperatureModal" data-toggle="modal" href="#temperatureModal"><?php print_r($data["0"]["temperatur"]); ?></a></td>
     </tr>
     <tr>
      <td>Luftfeuchtigkeit</td>
      <td><a data-target="#luftfeuchtigkeitModal" data-toggle="modal" href="#luftfeuchtigkeitModal"><?php print_r($data["0"]["luftfeuchtigkeit"]); ?></a></td>
     </tr>
     <tr>
      <td>Status</td>
      <td><a data-target="#statusModal" data-toggle="modal" href="#statusodal"><?php print_r($data["0"]["status"]); ?></a></td>
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
      <input type="radio" name="relais1" value="404"> Green<br>
      <input type="radio" name="relais1" value="101"> Blue<br>
      <input type="radio" name="relais1" value="102"> Yellow<br>
      <input type="radio" name="relais1" value="200"> Purple<br>
      <input type="radio" name="relais1" value="203"> Cyan<br>
      <input type="radio" name="relais1" value="206"> White<br>
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
    //$relais2 = $_GET["relais2"];
    //$relais3 = $_GET["relais3"];
    //$relais4 = $_GET["relais4"];

    $query = sprintf('UPDATE ralays SET relays1="'.$relais1.'" WHERE id=1;');
    $result = $mysqli->query($query);
    $data = array();
    foreach ($result as $row) {
      $data[] = $row;
    }

    /*$query = sprintf('UPDATE ralays SET relays2="'.$relais2.'" WHERE id=1;');
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