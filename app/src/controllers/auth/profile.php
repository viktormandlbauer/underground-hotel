<?php
require 'src/models/user.php';
require 'src/controllers/flashmessage.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = new \App\Models\User($_SESSION['username']);

if (isset($_POST['update_profile'])) {

     if (isset($_POST['givenname'], $_POST['surname'], $_POST['email'])) {

        $givenname = trim($_POST['givenname']);
        $surname = trim($_POST['surname']);
        $email = trim($_POST['email']);

        if (!\App\Models\User::exists_email($email) || $email == $user->getEmail()) {
            $user->save($givenname, $surname, $email);
            $user->load();
            $_SESSION['user_data'] = serialize($user);
            
            header('Location: /profile');
            set_flash_message('success', 'Daten erfolgreich geändert');
            exit();

        } else {
            header('Location: /profile');
            set_flash_message('error', 'Diese E-Mail wird bereits verwendet.');
            exit();
        }
    }
}


    if (isset($_POST['change_password'])) {
        if (isset($_POST['old_password'], $_POST['new_password'], $_POST['confirm_password'])) {
            
            if (\App\Models\User::login($_SESSION['username'], $_POST['old_password'])) {

                if ($_POST['new_password'] === $_POST['confirm_password']) {
                    $user->changePassword($_POST['new_password']);
                    set_flash_message('success', 'Passwort wurde erfolgreich geändert.');
                    exit();

                } else {
                    header('Location: /profile');
                    set_flash_message('error', 'Die neuen Passwörter stimmen nicht überein.');
                    exit();
                }} else {
                    header('Location: /profile');
                    set_flash_message('error', 'Das alte Passwort ist falsch.');
                    exit();
                }
            }
        }
    }


?>