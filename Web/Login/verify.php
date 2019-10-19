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
    echo "verified!";

    $sql = "UPDATE users SET isv=1 WHERE email=':emaillo' AND hash=':hashlo'";

    $statement = $pdo->prepare($sql);
    $statement->bindValue(":emaillo", $email);
    $statement->bindValue(":hashlo", $hash);
    $count = $statement->execute();

} else {
    echo "Hash or given name is invalid!";
}

?>