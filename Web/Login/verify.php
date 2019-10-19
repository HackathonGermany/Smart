<?php

$pdo = new PDO('mysql:host=localhost;dbname=dyingearth', 'esp', 'esp');

$hash    = $_GET["hash"];
$email = $_GET["email"];

if(!isset($hash) || !isset($email)) 
{
    header("Location: /");
}


$statement = $pdo->prepare("SELECT * FROM users WHERE email = :email");
$result = $statement->execute(array('email' => $email));
$user = $statement->fetch();
if($user['hash'] == $hash)
{
    define('DB_HOST', '127.0.0.1');
    define('DB_USERNAME', 'esp');
    define('DB_PASSWORD', 'esp');
    define('DB_NAME', 'dyingearth');
    $mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
    $query = sprintf("UPDATE users SET isv=1 WHERE email='".$email."' AND hash='".$hash."';");
    echo "verified!";
} else {
    echo "Hash or given name is invalid!";
}

?>