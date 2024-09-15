<?php

require 'src/config/dbaccess.php';
require 'src/util/logger.php';

session_start();



$logger = new Logger('logs/controller.log');


$valid_username = "user";
$valid_password = "password";

$temp_username = $_POST['username'];
$temp_password = $_POST['password'];

$sql = $db->query("SELECT username, password FROM users WHERE username");
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $temp_username);
$stmt->execute();
$result = $stmt->get_result();


if ($result->num_rows === 1) {
    
    $user = $result->fetch_assoc();
    if (password_verify($temp_password, $user['password'])) {
        
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        echo "Willkommen, " . htmlspecialchars($user['username']) . "!";
        echo '<br><a href="logout.php">Logout</a>';

        // Administrator-Funktion freigeben
        if ($user['role'] === 'admin') {
            echo "<br>Administrator-Funktionen freigeschaltet.";
        }
    } else {
        echo "Falsches Passwort!";
    }
} else {
    echo "Benutzername nicht gefunden!";
}

$conn->close();
?>
