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

    case ['/admin/users/add', 'POST']:

        if (User::exists_username($_POST['username'])) {
            $_SESSION['flash_message'] = 'Benutzername existiert bereits.';
            header('Location: /admin/manage/users');
            exit;

        } elseif (User::exists_email($_POST['email'])) {
            $_SESSION['flash_message'] = 'E-Mail-Adresse existiert bereits.';
            header('Location: /admin/manage/users');
            exit;

        } else {

            $data =  [$_POST['pronouns'], $_POST['givenname'], $_POST['surname'], $_POST['email'], $_POST['username'], $_POST['password'], $_POST['role']];

            if (User::addUser($data)) {
                $_SESSION['flash_message'] = 'Neuer Benutzer erfolgreich angelegt.';
                exit();

            } else {
                $_SESSION['flash_message'] = 'Benutzer konnte nicht angelegt werden.';
            }
            header('Location: /admin/manage/users');
        }
        break;

    case ['/admin/users/delete', 'POST']:

        if (isset($_POST['deleteUserId'])) {
            $userId = intval($_POST['deleteUserId']);
            $user = new User($userId);
            $user->delete();
            $_SESSION['flash_message'] = 'Benutzer ' . $user->username . ' erfolgreich gelöscht.';
            $users = User::getAllUsersSanitized();
        }
        header('Location: /admin/manage/users');
        break;
}