<?php
require 'src/util/logger.php';
require 'src/models/user.php';

$logger = new Logger('logs/auth.log');

$logger->log('Logging out user: ' . $_SESSION['username']);
session_destroy();
$logger->log('User logged out');

header('Location: /');
?>