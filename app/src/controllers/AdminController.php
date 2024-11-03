<?php

require 'src/models/User.php';

switch ($_SERVER['REQUEST_URI']) {
    case '/admin/users/save':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (authenticated() && authorized("admin")) {


                
                require 'src/controllers/AdminController.php';
            } else {
                require 'src/error/401.php';
            }
        }
        break;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if ($_SERVER['REQUEST_URI'] === '/admin/users/save') {
        
        // Eingabedaten sichern und validieren
        $userId = intval($_POST['user_id'] ?? 0);
        $username = trim($_POST['username'] ?? '');
        $givenname = trim($_POST['givenname'] ?? '');
        $surname = trim($_POST['surname'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $pronouns = trim($_POST['pronouns'] ?? '');
        $role = trim($_POST['role'] ?? '');

        $user = new User($username);

        $user->save_admin($pronouns, $givenname, $username, $email, $role);

        header("Content-Type: application/json");
        echo json_encode(["success" => true]);

    }
}
