<?php
require 'src/util/logger.php';
require 'src/models/user.php';
require 'src/config/dbaccess.php';


$logger = new Logger('logs/controller.log');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if($_SERVER['REQUEST_URI'] === '/auth/submit/registration') {
        $logger->log('Handling registration request for user: ' . $_POST['username']);
        
        if(\App\Models\User::exists($_POST['username'])){
            $logger->log('User already exists');
            header('Location: /register?error=userexists');
        }
    }
}
?>