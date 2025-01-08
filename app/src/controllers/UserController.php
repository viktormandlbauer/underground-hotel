<?php
require_once 'src/models/User.php';
require_once 'src/util/validation.php';

global $request;
global $method;

switch ([$request, $method]) {
    case ['/auth/submit/login', 'POST']:


        if (User::login($_POST['username'], $_POST['password'])) {

            if (empty($_POST['username']) || empty($_POST['password']) || !isValidArray([$_POST['username'], $_POST['password']], [ValidationTypes::username_pattern, ValidationTypes::password_pattern])) {
                $_SESSION['flash_message'] = 'Ungültige Eingabe';
                header('Location: /login');
                exit();
            }

            $_SESSION['username'] = $_POST['username'];

            $user = new User($_SESSION['username']);
            $user->load();


            header('Location: /');

        } else {

            $_SESSION['flash_message'] = 'Login fehlgeschlagen';
            header('Location: /login');

        }

        break;

    case ['/auth/submit/registration', 'POST']:

        if (
            empty($_POST['pronouns']) || empty($_POST['givenname']) ||
            empty($_POST['surname']) || empty($_POST['email']) ||
            empty($_POST['username']) || empty($_POST['password']) ||
            empty($_POST['password_confirm'])
        ) {

            $_SESSION['flash_message'] = 'Bitte füllen Sie alle Felder aus';
            header('Location: /register');
            exit();

        }

        if (User::exists_username($_POST['username'])) {

            $_SESSION['flash_message'] = 'Username existiert bereits';

            header('Location: /register');
            exit();

        } elseif (User::exists_email($_POST['email'])) {

            $_SESSION['flash_message'] = 'E-Mail existiert bereits';
            header('Location: /register');
            exit();
        }

        $data = [
            'pronouns' => $_POST['pronouns'] ?? '',
            'givenname' => $_POST['givenname'] ?? '',
            'surname' => $_POST['surname'] ?? '',
            'email' => $_POST['email'] ?? '',
            'username' => $_POST['username'] ?? '',
            'password' => $_POST['password'] ?? '',
            'password_confirm' => $_POST['password_confirm'] ?? '',
            'role' => $_POST['role'] ?? 'user',
            'state' => 'active',
        ];

        $rules = [
            'pronouns' => ValidationTypes::strict_string,
            'givenname' => ValidationTypes::strict_string,
            'surname' => ValidationTypes::strict_string,
            'email' => ValidationTypes::email,
            'username' => ValidationTypes::username_pattern,
            'password' => ValidationTypes::password_pattern,
            'password_confirm' => ValidationTypes::password_pattern,
            'role' => ValidationTypes::strict_string,
            'state' => ValidationTypes::strict_string,
        ];

        if ($data['password'] !== $data['password_confirm']) {
            $_SESSION['flash_message'] = 'Passwörter stimmen nicht überein';
            header('Location: /register');
            exit();
        }

        if (!isValidArray(array_values($data), array_values($rules))) {
            $_SESSION['flash_message'] = 'Ungültige Eingabe';
            header('Location: /register');
            exit();
        }

        $registerSuccess = User::addUser($data);

        if ($registerSuccess) {
            $_SESSION['username'] = $data['username'];
            header('Location: /');
            exit();
        } else {
            header('Location: /register');
        }

        break;


    case ['/logout', 'GET']:                     // Logout Handler
        $_SESSION = [];
        session_destroy();
        header('Location: /');
        break;
    case ['/admin/manage/users', 'GET']:
        $users = User::getAllUsersSanitized();
        break;

    case ['/admin/users/edit', 'POST']:
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
        if (isset($_POST['state'])) {
            $user->setUserState($_POST['state']);
        }
        if (isset($_POST['password'])) {
            $user->setPassword($_POST['password']);
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

            $data = [
                'pronouns' => $_POST['pronouns'],
                'givenname' => $_POST['givenname'],
                'surname' => $_POST['surname'],
                'email' => $_POST['email'],
                'username' => $_POST['username'],
                'password' => $_POST['password'],
                'role' => $_POST['role'],
                'state' => $_POST['state']
            ];

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
