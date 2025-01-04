<?php

$timeout_duration = 20;



if (isset($_SESSION['last_activity'])) {
    $time_elapsed = time() - $_SESSION['last_activity'];
    if ($time_elapsed > $timeout_duration) {
        session_unset();  
        session_destroy(); 
        header("Location: /login");
        exit();
    }
}

$_SESSION['last_activity'] = time();