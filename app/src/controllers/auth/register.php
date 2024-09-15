<?php
require 'src/util/logger.php';

$logger = new Logger('logs/controller.log');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if($_SERVER['REQUEST_URI'] === '/auth/submit/registration') {
        $logger->log('Handling registration request for user: ' . $_POST['username']);
    }
}
?>