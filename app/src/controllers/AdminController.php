<?php
require_once 'src/models/User.php';

global $request;
global $method;

switch ([$request, $method]) {
    case ['/admin/manage/users', 'GET']:
        $users = User::getAllUsersSanitized();
        break;

    case ['/admin/users/save', 'POST']:
        $user = new User($_POST['username']);

        if (isset($_POST['givenname'])) {
            $user->setGivenname($_POST['givenname']);
        }
        if (isset($_POST['surname'])) {
            $user->setSurname($_POST['surname']);
        }
        if (isset($_POST['email'])) {
            $user->setEmail($_POST['email']);
        }
        if (isset($_POST['pronouns'])) {
            $user->setPronouns($_POST['pronouns']);
        }
        if (isset($_POST['role'])) {
            $user->setRole($_POST['role']);
        }


        $_SESSION['flash_message'] = 'Benutzerdaten erfolgreich aktualisiert.';
        header('Location: /admin/manage/users');
        break;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if ($_SERVER['REQUEST_URI'] === '/admin/users/save') {


    }

    if ($_SERVER['REQUEST_URI'] === '/admin/users/delete') {

        $userId = intval($_POST['user_id'] ?? 0);

        if ($userId > 0) {
            $user = new User('');
            $user->deleteById($userId);

            $_SESSION['flash_message'] = 'Benutzer erfolgreich gelöscht.';
        } else {
            $_SESSION['flash_message'] = 'Ungültige Benutzer-ID.';
        }

        header('Location: /admin');
        exit;
    }

}