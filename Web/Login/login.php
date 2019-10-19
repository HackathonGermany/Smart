<?php 
session_start();
$pdo = new PDO('mysql:host=localhost;dbname=dyingearth', 'esp', 'esp');
 
if(isset($_GET['login'])) {
    $email = $_POST['email'];
    $passwort = $_POST['passwort'];
    $errorMessage = "";
    
    $statement = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $result = $statement->execute(array('email' => $email));
    $user = $statement->fetch();
        
    //Überprüfung des Passworts
    if ($user !== false && password_verify($passwort, $user['passwort'])) {
        $_SESSION['userid'] = $user['id'];
        //header("Location: index.php");
        $succmsg = 'Login erfolgreich. Weiter zu <a href="index.php">internen Bereich';
    } else {
        $errorMessage = "E-Mail oder Passwort war ungültig";
    }
    
}
?>
<!DOCTYPE html> 
<html> 
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login</title> 

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="icon" type="image/vnd.microsoft.icon" href="../assets/media/logo.ico">

    <!-- Custom styles for this template -->
    <link href="../assets/css/register.css" rel="stylesheet">
</head> 
<body class="text-center">

<form class="form-signin" action="?login=1" method="post">
 <img class="mb-4" src="../assets/media/logo.svg" alt="" width="75" height="75">
  <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
  <?php
  if($errorMessage != "") {
    $errormsg = "<div class='alert alert-danger' role='alert'>
                  $errorMessage
                </div>";
    echo $errormsg;
}

if($succmsg != "") {
      $successmsg = "<div class='alert alert-success' role='alert'>
                    $succmsg
                  </div>";
      echo $successmsg;
}
  ?>
  <label for="inputEmail" class="sr-only">Email address</label>
  <input type="email" id="inputEmail" size="40" maxlength="250" class="form-control" placeholder="Email address" required="" name="email" autofocus="">
  <label for="inputPassword" class="sr-only">Password</label>
  <input type="password" id="inputPassword" class="form-control" size="40" maxlength="250" name="passwort" autofocus="" placeholder="Password" required="">
  <br />
  <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
  <br />
    <div>
      <a id="reg" href="/Login/register.php">Don't have a Account?</a>
    </div>
</form>

</body>
</html>