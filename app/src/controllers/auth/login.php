<?php
require 'src/util/logger.php';
require 'src/models/user.php';
require 'src/config/dbaccess.php';

$logger = new Logger('logs/controller.log');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if ($_SERVER['REQUEST_URI'] === '/auth/submit/login') {
        $logger->log('Handling login request for user: ' . $_POST['username']);

        if (\App\Models\User::login($_POST['username'], $_POST['password'])) {
            $logger->log('Login successful for user: ' . $_POST['username']);            

            // TODO: Handle session

            // Redirect to home page
            header('Location: /');

        } else {

            // TODO: Set error parameter

            header('Location: /login');
        }
    }
}
