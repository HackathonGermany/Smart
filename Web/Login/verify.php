<?php

$pdo = new PDO('mysql:host=localhost;dbname=dyingearth', 'esp', 'esp');

$unsafehash    = $_GET["hash"];
$unsafevorname = $_GET["vorname"];

if(!isset($unsafehash) || !isset($unsafevorname)) 
{
    header("Location: /");
}

$hash = mysqli_real_escape_string($pdo, $unsafehash);
$vorname = mysqli_real_escape_string($pdo, $unsafevorname);

$statement = $pdo->prepare("SELECT * FROM 'users' WHERE vorname = :vorname");
$result = $statement->execute(array('vorname' => $vorname));
$user = $statement->fetch();
if($user['passwort'] == $unsafehash)
{
    echo "verified!";
} else {
    echo "Hash or given name is invalid!";
}

?>