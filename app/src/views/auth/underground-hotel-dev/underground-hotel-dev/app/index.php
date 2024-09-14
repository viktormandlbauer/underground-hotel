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

    default:
        http_response_code(404);
        require 'src/views/404.php';
}
