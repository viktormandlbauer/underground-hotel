<?php
require_once 'src/models/User.php';
require_once 'src/util/json.php';

switch ($_SERVER['REQUEST_URI']) {
    case '/auth/submit/login':          // Login Handler

        if (User::login($_POST['username'], $_POST['password'])) {

            $_SESSION['username'] = $_POST['username'];
            echo json_encode(['status' => 'success']);
        } else {
            http_response_code(401);
            echo json_encode(['status' => 'error', 'message' => 'Invalid username or password']);
        }
        break;

    case '/auth/submit/registration':       // Registration Handler

        if (User::exists_username($_POST['username'])) {

            // TODO : Set error parameter

            header('Location: /register');
        } elseif (User::exists_email($_POST['email'])) {

            // TODO : Set error parameter

            header('Location: /register');
        } else {
            if (User::register(
                $_POST['pronouns'],
                $_POST['givenname'],
                $_POST['surname'],
                $_POST['email'],
                $_POST['username'],
                $_POST['password']
            )) {

                // TODO: Handle session
                $_SESSION['username'] = $_POST['username'];

                header('Location: /');
            } else {

                // TODO: Set error parameter 
                header('Location: /register');
            }
        }

        break;
    case '/logout':                     // Logout Handler
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
