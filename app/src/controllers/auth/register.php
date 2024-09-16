<?php

require 'src/util/logger.php';
require 'src/models/user.php';

$logger = new Logger('logs/auth.log');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if ($_SERVER['REQUEST_URI'] === '/auth/submit/registration') {

        $logger->log('Handling registration request for user: ' . $_POST['username']);

        if (\App\Models\User::exists_username($_POST['username'])) {

            $logger->log('User already exists');

            // TODO : Set error parameter

            header('Location: /register');

        } elseif (\App\Models\User::exists_email($_POST['email'])) {

            $logger->log('Email already exists');

            // TODO : Set error parameter

            header('Location: /register');
        } else {
            if (\App\Models\User::register(
                $_POST['pronouns'],
                $_POST['givenname'],
                $_POST['surname'],
                $_POST['email'],
                $_POST['username'],
                $_POST['password']
            )) {

                // TODO: Handle session
                $_SESSION['username'] = $_POST['username'];

                $logger->log('Registration successful for user: ' .
                    $_SESSION['username'] .
                    " with session variable: " .
                    print_r($_SESSION, true));

                header('Location: /');
            } else {

                $logger->log('Registration failed for user: ' . $_POST['username']);

                // TODO: Set error parameter 
                header('Location: /register');
            }
        }
    }
}
