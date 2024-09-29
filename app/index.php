<?php

$request = $_SERVER['REQUEST_URI'];
$stage = getenv('STAGE') ?: 'development';

session_start();

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

    case '/rooms':
        require 'src/views/rooms.php';
        break;
    
    case '/search/rooms':
        require 'src/controllers/rooms.php';
        break;

    case '/profile':
        require 'src/views/profile.php';
        break;
        
    case '/register':
        require 'src/views/auth/register.php';
        break;
    
    case '/auth/submit/registration':
        require 'src/controllers/auth/register.php';
        break;
        
    case '/login':
        require 'src/views/auth/login.php';
        break;

    case '/auth/submit/login':
        require 'src/controllers/auth/login.php';
        break;

    case '/logout':
        require 'src/controllers/auth/logout.php';
        break;
    
    case '/auth/submit/profile_action':
        require 'src/controllers/auth/profile.php';
        break;

    case '/admin':
        require 'src/views/admin.php';
        break;

    case '/admin/users':
        require 'src/controllers/admin.php';
        break;

    case '/admin/users/save':
        require 'src/controllers/admin.php';
        break;
    
    case '/test':
        header('Content-type: text/plain');
        echo "This is " .  $stage . "!\r\n";
        if($stage === 'development') {
            require 'src/controllers/test.php';
        }
        break;
    
    default:
        http_response_code(404);
        require 'src/views/404.php';
}
