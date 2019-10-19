<?php 
session_start();
$pdo = new PDO('mysql:host=192.168.1.179;dbname=dyingearth', 'esp', 'esp');
?>
<!DOCTYPE html> 
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Registrierung</title> 

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
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

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo 'Bitte eine gültige E-Mail-Adresse eingeben<br>';
        $error = true;
    }     
    if(strlen($passwort) == 0) {
        echo 'Bitte ein Passwort angeben<br>';
        $error = true;
    }
    if($passwort != $passwort2) {
        echo 'Die Passwörter müssen übereinstimmen<br>';
        $error = true;
    }
    
    //Überprüfe, dass die E-Mail-Adresse noch nicht registriert wurde
    if(!$error) { 
        $statement = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $result = $statement->execute(array('email' => $email));
        $user = $statement->fetch();
        
        if($user !== false) {
            echo 'Diese E-Mail-Adresse ist bereits vergeben<br>';
            $error = true;
        }    
    }
    
    //Keine Fehler, wir können den Nutzer registrieren
    if(!$error) {    
        $passwort_hash = password_hash($passwort, PASSWORD_DEFAULT);
        
        $statement = $pdo->prepare("INSERT INTO users (email, passwort, vorname, nachname) VALUES (:email, :passwort, :vorname, :nachname)");
        $result = $statement->execute(array('email' => $email, 'passwort' => $passwort_hash, 'vorname' => $vorname, 'nachname' => $nachname));
        
        if($result) {        
            echo 'Du wurdest erfolgreich registriert. <a href="login.php">Zum Login</a>';
            $showFormular = false;
        } else {
            echo 'Beim Abspeichern ist leider ein Fehler aufgetreten<br>';
        }
    } 
}
 
if($showFormular) {
?>
 
 <form class="form-signin" action="?register=1" method="post">
 <img class="mb-4" src="../assets/media/logo.svg" alt="" width="75" height="75">
  <h1 class="h3 mb-3 font-weight-normal">Please sign up</h1>
  <label for="inputForename" class="sr-only">Given name</label>
  <input type="text" name="vorname" size="40" maxlength="250" id="inputForename" autofocus="" class="form-control" placeholder="Given name" required="">
  <label for="inputLastname" class="sr-only">Last name</label>
  <input type="text" id="inputLastname" size="40"  maxlength="250" name="nachname" autofocus="" class="form-control" placeholder="Last name" required="">
  <label for="inputEmail" class="sr-only">Email address</label>
  <input type="email" id="inputEmail" size="40" maxlength="250" class="form-control" placeholder="Email address" required="" name="email" autofocus="">
  <label for="inputPassword" class="sr-only">Password</label>
  <input type="password" id="inputPassword" class="form-control" size="40" maxlength="250" name="passwort" autofocus="" placeholder="Password" required="">
  <label for="inputPassword2" class="sr-only">Re-enter password</label>
  <input type="password" id="inputPassword2" class="form-control" size="40" maxlength="250" name="passwort2" autofocus="" placeholder="Re-enter password" required="">
  <div class="checkbox mb-3">
    <label>
      <input type="checkbox" value="remember-me"> Remember me
    </label>
  </div>
  <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
  <p class="mt-5 mb-3 text-muted">© 2017-2019</p>
</form>
 
<?php
} //Ende von if($showFormular)
?>
 
</body>
</html>