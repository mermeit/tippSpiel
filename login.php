<?php
$host = "localhost";
$name = "tippspiel";
$user = "root";
$passwort = "";

try{
  $db = new PDO("mysql:host=$host;dbname=$name", $user, $passwort);
  ?>

  <link rel="stylesheet" href="style.css">

  <h2>Login</h2>

  <form action="" method="post">

  <label for="lbl_nickname">Nickname:</label><br>
  <input type="text" id="nickname" name="nickname"><br><br>

  <label for="lbl_vorname">Passwort:</label><br>
  <input type="password" id="password" name="password"><br>

  <a href="registrieren.php">Noch kein Konto?</a><br><br>

  <button type="submit" name="login" id="login">Einloggen</button>
  </form>

  <?php

  if(isset($_POST["login"])){
  $stmt = $db->prepare("SELECT * FROM benutzer WHERE nickname = :name"); //Überprüfen ob Nutzername bereits existiert
  $stmt->bindParam(":name", $_POST["nickname"]);
  $stmt->execute();
  $count = $stmt->rowCount();

  if($count == 1){
    //Nutzername existiert
    $row = $stmt->fetch();

    if(password_verify($_POST["password"], $row["passwort"])){
      session_start();
      $_SESSION["nickname"] = $row["nickname"];
      header("Location: tippspiel.php");

    }else{ //Passwort stimmt nicht
      echo "Der Nutzername und/oder das Passwort ist falsch";
}

}else{ //Nutzername existiert nicht
    echo "Der Nutzername und/oder das Passwort ist falsch";
}

  }
}catch(PDOException $e){
      echo "Fehler:". $e->getMessage();
    }
  ?>
