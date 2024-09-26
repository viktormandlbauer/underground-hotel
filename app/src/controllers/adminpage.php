<?php

header('Content-Type: application/json');

require 'src/models/user.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if ($_SERVER['REQUEST_URI'] === '/controllers/adminpage/save') {
        
        $userId = $_POST['user_id'];
        $username = $_POST['username'];
        $givenname = $_POST['givenname'];
        $surname = $_POST['surname'];
        $email = $_POST['email'];
        $pronouns = $_POST['pronouns'];
        $role = $_POST['role'] ?? null;


        $user = new \App\Models\User($username);
        $user->load();

        $user->save($givenname, $surname, $email);

        echo json_encode(['success' => true]);

        exit(); 
    }
    

    if ($_SERVER['REQUEST_URI'] === '/controllers/adminpage') {

        $user = new \App\Models\User($_POST['username']);
        $user->load();
        header('Location: /adminpage'); 
        exit();
    }
}
