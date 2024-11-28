<?php

// phpinfo(); exit;

error_reporting(E_ALL);
ini_set('ignore_repeated_errors', TRUE);
ini_set('display_errors', value: TRUE); // Change to FALSE in production
ini_set('log_errors', TRUE);
ini_set('error_log', '/dev/stdout');

require_once 'src/util/auth.php';

global $request;
global $method;

$method = $_SERVER['REQUEST_METHOD'];
$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

session_start();

switch ($request) {
    case '':
    case '/':
        require 'src/views/welcome.php';
        break;

    case '/galerie':
        require 'src/views/galerie.php';
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

    case '/rooms/search':
        require 'src/controllers/RoomController.php';
        break;

    case '/register':
        require 'src/views/auth/register.php';
        break;

    case '/auth/submit/registration':
        require 'src/controllers/UserController.php';
        break;

    case '/login':
        require 'src/views/auth/login.php';
        break;

    case '/auth/submit/login':
        require 'src/controllers/UserController.php';
        break;

    case '/logout':
        require 'src/controllers/UserController.php';
        break;

    case '/profile':
        if (authenticated()) {
            require 'src/views/profile.php';
        } else {
            header('Location: /login');
        }
        break;

    case '/profile/edit':
        if (authenticated()) {
            require 'src/controllers/UserController.php';
        } else {
            require 'src/error/401.php';
        }
        break;
    case '/profile/load':
        if (authenticated()) {
            require 'src/controllers/UserController.php';
        } else {
            require 'src/error/401.php';
        }
        break;

    case '/admin/dashboard':
        if (authenticated() && authorized('admin')) {
            require 'src/views/admin/dashboard.php';
        } else {
            require 'src/error/401.php';
        }
        break;

    case '/admin/manage/users':
        if (authenticated() && authorized("admin")) {
            require 'src/views/admin/manage/users.php';
        } else {
            require 'src/error/401.php';
        }
        break;

    case '/admin/manage/rooms':
        if (authenticated() && authorized("admin")) {
            require 'src/views/admin/manage/rooms.php';
        } else {
            require 'src/error/401.php';
        }
        break;

    case '/admin/manage/news':
        if (authenticated() && authorized("admin")) {
            require 'src/views/admin/manage/news.php';
        } else {
            require 'src/error/401.php';
        }
        break;

    case '/admin/manage/bookings':
        if (authenticated() && authorized("admin")) {
            require 'src/views/admin/manage/bookings.php';
        } else {
            require 'src/error/401.php';
        }
        break;

    case '/admin/users/save':
        if (authenticated() && authorized("admin")) {
            require 'src/controllers/AdminController.php';
        } else {
            require 'src/error/401.php';
        }
        break;

    case '/news':
        require 'src/views/news.php';
        break;

    case '/news/submit':
        require 'src/controllers/NewsController.php';
        break;

    case '/news/detail':
        require 'src/views/newsdetail.php';
        break;

    case '/news/get':
        require 'src/controllers/NewsController.php';
        break;

    case '/news/get/count':
        require 'src/controllers/NewsController.php';
        break;


    default:
        require 'src/error/404.php';
}
