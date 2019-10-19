<?php
$servername = "localhost";
$dbname = "dyingearth";
$username = "esp";
$password = "esp";

define('DB_HOST', '127.0.0.1');
define('DB_USERNAME', 'esp');
define('DB_PASSWORD', 'esp');
define('DB_NAME', 'dyingearth');

$mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
if(!$mysqli){
  die("Connection failed: " . $mysqli->error);
}
$query = sprintf("SELECT * FROM ralays");
$result = $mysqli->query($query);
$data = array();
foreach ($result as $row) {
  $data[] = $row;
}
echo $data["0"][relays1].$data["0"][relays2].$data["0"][relays3].$data["0"][relays4]."<br />";
$bin = $data["0"][relays1].$data["0"][relays2].$data["0"][relays3].$data["0"][relays4];
http_response_code($bin);
http_response_code(303);

// Keep this API Key value to be compatible with the ESP32 code provided in the project page. 
// If you change this value, the ESP32 sketch needs to match
$api_key_value = "tPmAT5Ab3j7F9";

$api_key= $sensor = $location = $value1 = $value2 = $value3 = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $api_key = test_input($_POST["api_key"]);
    if($api_key == $api_key_value) {
        $strom            = test_input($_POST["strom"]);
        $spannung         = test_input($_POST["spannung"]);
        $watt             = test_input($_POST["watt"]);
        $lichtstaerke     = test_input($_POST["lichtstaerke"]);
        $temperatur       = test_input($_POST["temperatur"]);
        $luftfeuchtigkeit = test_input($_POST["luftfeuchtigkeit"]);
        $status           = test_input($_POST["status"]);
        $time             = test_input($_POST["time"]);
        $datum            = test_input($_POST["datum"]);
        
        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 
        
        $sql = "INSERT INTO data (strom, spannung, watt, lichtstaerke, temperatur, luftfeuchtigkeit, status, time, datum)
        VALUES ('" . $strom . "', '" . $spannung . "', '" . $watt . "', '" . $lichtstaerke . "', '" . $temperatur . "', '" . $luftfeuchtigkeit . "', '" . $status . "', '" . $time . "', '" . $datum . "')";
        
        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } 
        else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    
        $conn->close();
    }
    else {
        echo "Wrong API Key provided.";
    }

}
else {
    echo "No data posted with HTTP POST.";
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
