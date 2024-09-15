<?php
require 'src/util/logger.php';

$logger = new Logger('logs/controller.log');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "Register PHP-Datei wird ausgeführt";
    $logger->log('Handling registration request for user: ' . $_POST['username']);

     $anrede = $conn->real_escape_string($_POST['pronouns']);
     $vorname = $conn->real_escape_string($_POST['givenname']);
     $nachname = $conn->real_escape_string($_POST['surname']);
     $email = $conn->real_escape_string($_POST['email']);
     $username = $conn->real_escape_string($_POST['username']);
     $password = $conn->real_escape_string($_POST['password']);
     $password_confirm = $conn->real_escape_string($_POST['password_confirm']);
 
     
     if (empty($anrede) || empty($vorname) || empty($nachname) || empty($email) || empty($username) || empty($password) || empty($password_confirm)) {
         echo "Bitte füllen Sie alle Felder aus.";
         exit();
     }
 
    
     if ($password !== $password_confirm) {
         echo "Die Passwörter stimmen nicht überein.";
         exit();
     }
 
     
     if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
         echo "Ungültige E-Mail-Adresse.";
         exit();
     }
 
     
     $sql = "SELECT * FROM users WHERE username = '$username'";
     $result = $conn->query($sql);
 
     if ($result->num_rows > 0) {
         echo "Der Benutzername ist bereits vergeben.";
         exit();
     }
 

     $hashed_password = password_hash($password, PASSWORD_DEFAULT);
 
    
     $sql = "INSERT INTO users (anrede, vorname, nachname, email, username, password) 
             VALUES ('$anrede', '$vorname', '$nachname', '$email', '$username', '$hashed_password')";
 
     if ($conn->query($sql) === TRUE) {
         echo "Registrierung erfolgreich!";
     } 
     else {
         echo "Fehler: " . $conn->error;
     }
 
    
     $conn->close();    
}

?>