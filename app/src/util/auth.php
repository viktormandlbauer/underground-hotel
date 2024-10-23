<?php

function authenticated(): bool
{
    // Cheks if user is logged in
    return isset($_SESSION['username']);
}

function authorized($role): bool
{
    if(!isset($_SESSION['username'])) {
        return false;
    }
    // Checks if user has the required role
    require_once 'src/models/User.php';
    $user = new User($_SESSION['username']);
    return $user->getRole() == $role;
}
