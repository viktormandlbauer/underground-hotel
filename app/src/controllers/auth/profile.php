<?php

require 'src/util/logger.php';
require 'src/models/user.php';

// Überprüfen, ob der Benutzer eingeloggt ist
if (!isset($_SESSION['username'])) {
    header('Location: /login');
    exit();
}

// Benutzername aus der Session holen
$username = $_SESSION['username'];

global $user;
$user = new \App\Models\User($username);
$user->load();

?>