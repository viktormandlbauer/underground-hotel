<?php
require_once 'src/models/User.php';
require_once 'src/util/validation.php';

global $request;
global $method;

switch ([$request, $method]) {
    case ['/auth/submit/login', 'POST']:

      
        if (User::login($_POST['username'], $_POST['password'])) {

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
                'pronouns' =>$_POST['pronouns'] ?? '', 
                'givenname' => $_POST['givenname'] ?? '',
                'surname' => $_POST['surname'] ?? '',
                'email' => $_POST['email'] ?? '',
                'username' => $_POST['username'] ?? '',
                'password' => $_POST['password'] ?? '',
                'password_confirm' => $_POST['password_confirm'] ?? '',
                'role' => $_POST['role'] ?? 'user'
            ];

            $registerSuccess = User::addUser($data);

            if($registerSuccess){
                $_SESSION['username'] = $data['username'];
                header('Location: /');
                exit();
            }

            else{
                header('Location: /register');
            }

        break;


    case ['/logout', 'GET']:                     // Logout Handler
        $_SESSION = [];
        session_destroy();
        header('Location: /');
        break;

    case '/profile/load':               // Load profile data
        $user = new User($_SESSION['username']);
        $user->loadProfile();
        echo json_encode($user->toArray());
        break;

    case '/profile/edit':               // Profile Handler
        try {
            $data = handle_request();
        } catch (Exception $e) {
            error_log("Error: " . $e->getMessage());
            echo json_encode(['error' => $e->getMessage()]);
            exit;
        }

        if (!isset($data['username'])) {
            $user = new User($_SESSION['username']);
        } else {
            if (!authorized('admin')) {
                echo json_encode(['error' => 'Unauthorized']);
                exit;
            } else {
                $user = new User($data['username']);
            }
        }

        foreach ($data as $key => $value) {
            $user->$key = $value;
            switch ($key) {
                case 'pronouns':
                    $user->setPronouns($value);
                    break;
                case 'givenname':
                    $user->setGivenname($value);
                    break;
                case 'surname':
                    $user->setSurname($value);
                    break;
                case 'email':
                    $user->setEmail($value);
                    break;
                case 'telephone':
                    $user->setTelephone($value);
                    break;
                case 'counrty':
                    $user->setCountry($value);
                    break;
                case 'postal_code':
                    $user->setPostalCode($value);
                    break;
                case 'city':
                    $user->setCity($value);
                    break;
                case 'street':
                    $user->setStreet($value);
                    break;
                case 'house_number':
                    $user->setHouseNumber($value);
                    break;
                case 'new_password':
                    if (isset($data['old_password'])) {
                        if (User::login($user->username, $data['old_password'])) {
                            $user->changePassword($data['new_password']);
                        } else {
                            echo json_encode(['error' => 'Invalid password']);
                            exit;
                        }
                    } else if (authorized('admin')) {
                        $user->changePassword($data['new_password']);
                    } else {
                        include 'src/errors/403.php';
                        exit;
                    }
            }
        }

        break;

    case '/profile/delete':
        //TODO
        break;
}
