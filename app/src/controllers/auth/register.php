<?php

require 'src/util/logger.php';
require 'src/models/user.php';
require 'src/config/dbaccess.php';

$logger = new Logger('logs/controller.log');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if ($_SERVER['REQUEST_URI'] === '/auth/submit/registration') {
        
        $logger->log('Handling registration request for user: ' . $_POST['username']);

        if (\App\Models\User::exists($_POST['username'])) {

            $logger->log('User already exists');

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

                $logger->log('Registration successful for user: ' . $_POST['username']);

                // TODO: Handle session
                header('Location: /');
            } else {

                $logger->log('Registration failed for user: ' . $_POST['username']);

                // TODO: Set error parameter 
                header('Location: /register');
            }
        }
    }
}
?>