<?php

$pdo = new PDO('mysql:host=localhost;dbname=dyingearth', 'esp', 'esp');

$hash    = $_GET["hash"];
$vorname = $_GET["vorname"];

if(!isset($hash) || !isset($vorname)) 
{
    header("Location: /");
}

$statement = $pdo->prepare("SELECT * FROM 'users' WHERE vorname = :vorname");
$result = $statement->execute(array('vorname' => $vorname));
$user = $statement->fetch();
if($user['hash'] == $hash)
{
    echo "verified!";
} else {
    echo "Hash or given name is invalid!";
}

?>