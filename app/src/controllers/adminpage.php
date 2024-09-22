<?php

header('Content-Type: application/json');

require 'src/models/user.php';
include 'src/controllers/flashmessage.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Wenn die Daten zum Speichern kommen
    if ($_SERVER['REQUEST_URI'] === '/controllers/adminpage/save') {
        // Hole die Daten aus dem Formular
        $userId = $_POST['user_id'];
        $username = $_POST['username'];
        $givenname = $_POST['givenname'];
        $surname = $_POST['surname'];
        $email = $_POST['email'];
        $pronouns = $_POST['pronouns'];
        $role = $_POST['role'] ?? null;

        // Lade den Benutzer anhand des Benutzernamens oder der ID
        $user = new \App\Models\User($username);
        $user->load();

        // Aktualisiere die Benutzerdaten
        $user->save($givenname, $surname, $email, $pronouns, $role);

        // Setze eine Flash-Message und gebe JSON-Antwort zurück
        set_flash_message('success', 'Daten erfolgreich aktualisiert.');
        echo json_encode(['success' => true, 'message' => 'Daten erfolgreich aktualisiert.']);
        exit(); // Beende das Script nach der JSON-Antwort
    }
    
    // Wenn nur die Admin-Seite aufgerufen wird
    if ($_SERVER['REQUEST_URI'] === '/controllers/adminpage') {
        // Lade den Benutzer für die Anzeige auf der Admin-Seite
        $user = new \App\Models\User($_POST['username']);
        $user->load();
        header('Location: /adminpage'); // Weiterleitung zur Admin-Seite
        exit();
    }
}
