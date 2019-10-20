<?php 
session_start();
$pdo = new PDO('mysql:host=localhost;dbname=dyingearth', 'esp', 'esp');
include "mail.php";
?>
<!DOCTYPE html> 
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Registrierung</title> 

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="icon" type="image/vnd.microsoft.icon" href="../assets/media/logo.ico">

    <!-- Custom styles for this template -->
    <link href="../assets/css/register.css" rel="stylesheet">
  </head> 
<body class="text-center">
 
<?php
$showFormular = true; //Variable ob das Registrierungsformular anezeigt werden soll
 
if(isset($_GET['register'])) {
    $error = false;
    $email = $_POST['email'];
    $passwort = $_POST['passwort'];
    $passwort2 = $_POST['passwort2'];
    $vorname = $_POST['vorname'];
    $nachname = $_POST['nachname'];
    $echoerror = "";

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $echoerror = 'Bitte eine gültige E-Mail-Adresse eingeben<br>';
        $error = true;
    }     
    if(strlen($passwort) == 0) {
        $echoerror = 'Bitte ein Passwort angeben<br>';
        $error = true;
    }
    if($passwort != $passwort2) {
        $echoerror = 'Die Passwörter müssen übereinstimmen<br>';
        $error = true;
    }
    
    //Überprüfe, dass die E-Mail-Adresse noch nicht registriert wurde
    if(!$error) { 
        $statement = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $result = $statement->execute(array('email' => $email));
        $user = $statement->fetch();
        
        if($user !== false) {
            $echoerror = 'Diese E-Mail-Adresse ist bereits vergeben<br>';
            $error = true;
        }    
    }
    
    //Keine Fehler, wir können den Nutzer registrieren
    if(!$error) {    
        $passwort_hash = password_hash($passwort, PASSWORD_DEFAULT);
        $hash = md5( rand(0,1000) ); // Generate random 32 character hash and assign it to a local variable.        
        $statement = $pdo->prepare("INSERT INTO users (email, passwort, hash, vorname, nachname) VALUES (:email, :passwort, :hash, :vorname, :nachname)");
        $result = $statement->execute(array('email' => $email, 'passwort' => $passwort_hash, 'hash' => $hash, 'vorname' => $vorname, 'nachname' => $nachname));
        
        if($result) {        
            $echoerror = 'Your registration was successful. <a href="verify.php">To the loginpage';
            $link = "http://192.168.1.23/Login/verify.php?hash=$hash&email=$email";
            sendVermail($email, $vorname, $link);
            $showFormular = false;
        } else {
            $echoerror = 'Beim Abspeichern ist leider ein Fehler aufgetreten<br>';
        }
    } 
}
 
if($showFormular) {
?>
 
 <form class="form-signin" action="?register=1" method="post">
 <img class="mb-4" src="../assets/media/logo.svg" alt="" width="75" height="75">
  <h1 class="h3 mb-3 font-weight-normal">Please sign up</h1>
  <?php
  if($echoerror != "") {
      $errormsg = "<div class='alert alert-danger' role='alert'>
                    $echoerror
                  </div>";
      echo $errormsg;
  }
  ?>
  <label for="inputForename" class="sr-only">Given name</label>
  <input type="text" name="vorname" size="40" maxlength="250" id="inputForename" autofocus="" class="form-control" placeholder="Given name" required="">
  <label for="inputLastname" class="sr-only">Last name</label>
  <input type="text" id="inputLastname" size="40"  maxlength="250" name="nachname" autofocus="" class="form-control" placeholder="Last name" required="">
  <label for="inputPassword" class="sr-only">Password</label>
  <input type="password" id="inputPassword" class="form-control" size="40" maxlength="250" name="passwort" autofocus="" placeholder="Password" required="">
  <label for="inputPassword2" class="sr-only">Re-enter password</label>
  <input type="password" id="inputPassword2" class="form-control" size="40" maxlength="250" name="passwort2" autofocus="" placeholder="Re-enter password" required="">
  <label for="inputEmail" class="sr-only">Email address</label>
  <input type="email" id="inputEmail" size="40" maxlength="250" class="form-control" placeholder="Email address" required="" name="email" autofocus="">
  <br />
  <button class="btn btn-lg btn-primary btn-block" type="submit">Sign up</button>
  <br />
    <div>
      <a id="reg" href="/Login/login.php">Already have a Account?</a>
    </div>
</form>
 
<?php
} //Ende von if($showFormular)
?>
 
</body>
</html>