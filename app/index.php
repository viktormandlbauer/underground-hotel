<?php

$request = $_SERVER['REQUEST_URI'];

switch ($request) {
    case '':
    case '/':
        require 'src/views/welcome.php';
        break;
    
    case '/galerie':
        require 'src/views/galerie.php';
        break;
    
    case '/news':
        require 'src/views/news.php';
        break;

    case '/impressum':
        require 'src/views/impressum.php';
        break;

    case '/help':
        require 'src/views/help.php';
        break;

<<<<<<< HEAD

    case '/register':
        require 'src/views/auth/register.php';
        break;

    case '/login':
        require 'src/views/auth/login.php';
        break;
    

=======
    case '/auth/register':
        require 'src/views/auth/register.php';
        break;
    
    case '/auth/login':
        require 'src/views/auth/login.php';
        break;

    case '/testing':
        require 'src/controllers/test.php';
        break;
>>>>>>> 215242aa559f7136ff15cc81073670b99ff78a4d

    default:
        http_response_code(404);
        require 'src/views/404.php';
}
