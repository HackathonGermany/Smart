<?php

$pdo = new PDO('mysql:host=localhost;dbname=dyingearth', 'esp', 'esp');

$unsafehash    = $_GET["hash"];
$unsafevorname = $_GET["vorname"];

if(!isset($unsafehash) || !isset($unsafevorname)) 
{
    header("Location: /");
}

//$hash = mysqli_real_escape_string($pdo, $unsafehash);
//$vorname = mysqli_real_escape_string($pdo, $unsafevorname);

$statement = $pdo->prepare("SELECT * FROM 'users' WHERE vorname = :vorname");
$result = $statement->execute(array('vorname' => $unsafevorname));
$user = $statement->fetch();
echo $user['hash'];
echo "<br />"
echo $unsafehash;
echo "<br />"
if($user['hash'] == $unsafehash)
{
    echo "verified!";
} else {
    echo "Hash or given name is invalid!";
}

?>