<?php
$servername = "192.168.1.179";
$dbname = "dyingeart";
$username = "esp";
$password = "esp";

// Keep this API Key value to be compatible with the ESP32 code provided in the project page. 
// If you change this value, the ESP32 sketch needs to match
$api_key_value = "tPmAT5Ab3j7F9";

$api_key= $sensor = $location = $value1 = $value2 = $value3 = "";

//if ($_SERVER["REQUEST_METHOD"] == "PUT") {
    $api_key = test_input($_PUT["api_key"]);
    if($api_key == $api_key_value) {
        $sensor = test_input($_PUT["sensor"]);
        $location = test_input($_PUT["location"]);
        $value1 = test_input($_PUT["value1"]);
        $value2 = test_input($_PUT["value2"]);
        $value3 = test_input($_PUT["value3"]);
        
        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 
        
        $sql = "INSERT INTO SensorData (sensor, location, value1, value2, value3)
        VALUES ('" . $sensor . "', '" . $location . "', '" . $value1 . "', '" . $value2 . "', '" . $value3 . "')";
        
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

/*}
else {
    echo "No data posted with HTTP PUT.";
}*/

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
