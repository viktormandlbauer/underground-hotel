<?php

// phpinfo(); exit;
/*
|--------------------------------------------------------------------------
| index.php
|--------------------------------------------------------------------------
| This file serves as the entry point for the application.
| It handles routing based on the request URL and delegates control
| to the appropriate controllers or views.
|
| Features and Flow:
| 1. Captures the HTTP request method and path.
| 2. Initializes a PHP session to manage user sessions.
| 3. Implements routing logic:
|    - Routes requests to views for static pages (e.g., welcome, help).
|    - Directs dynamic actions (e.g., login, dashboard, profile updates) 
|      to appropriate controllers and views.
|    - Secures routes requiring authentication and authorization.
|    - Returns appropriate error pages (401 Unauthorized, 404 Not Found).
| 4. Integrates authentication and authorization checks:
|    - `authenticated()`: Verifies if a user is logged in.
|    - `authorized($role)`: Ensures the user has the required role 
|      (e.g., admin, user).
| 5. Handles additional application logic, such as managing bookings, 
|    rooms, and news.
*/

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

    case '/register':
        require 'src/views/auth/register.php';
        break;

    case '/dashboard':
        if (authenticated()) {
            if (authorized('admin')) {
                require 'src/views/admin/dashboard.php';
            } else {
                require 'src/views/dashboard.php';
            }
        } else {
            header('Location: /login');
        }
        break;

    case '/login':
        require 'src/views/auth/login.php';
        break;

    case '/auth/submit/login':
    case '/auth/submit/registration':
        require 'src/controllers/UserController.php';
        break;

    case '/logout':
        if (authenticated()) {
            require 'src/controllers/UserController.php';
        } else {
            require 'src/error/401.php';
        }
        break;
    
    case '/admin/manage/bookings':
    case '/admin/manage/bookings/edit':
    case '/admin/manage/bookings/add':
        if (authenticated() && authorized('admin')) {
            require 'src/controllers/BookingController.php';
            require 'src/views/admin/manage/bookings.php';
        } else {
            require 'src/error/401.php';
        }
        break;

    case '/rooms':
    case '/rooms/booking':
        require 'src/controllers/RoomController.php';
        require 'src/views/rooms.php';
        break;

    case '/bookings':
    case '/booking/cancel':
        require 'src/controllers/BookingController.php';
        require 'src/views/bookings.php';
        break;

    case '/rooms/search':
        require 'src/controllers/RoomController.php';
        break;

    case '/admin/rooms/create':
    case '/admin/rooms/delete':
    case '/admin/rooms/edit':
        if (authenticated() && authorized('admin')) {
            require 'src/controllers/RoomController.php';
        } else {
            require 'src/error/401.php';
        }
        break;

    case '/profile':
        if (authenticated()) {
            require 'src/controllers/ProfileController.php';
            require 'src/views/profile.php';
        } else {
            header('Location: /login');
        }
        break;

    case '/profile/update':
    case '/profile/changePassword':
    case '/profile/delete':
        if (authenticated()) {
            require 'src/controllers/ProfileController.php';
            require 'src/views/profile.php';
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
            require 'src/controllers/UserController.php';
            require 'src/views/admin/manage/users.php';
        } else {
            require 'src/error/401.php';
        }
        break;

    case '/admin/manage/rooms':
        if (authenticated() && authorized("admin")) {
            require "src/controllers/RoomController.php";
            require 'src/views/admin/manage/rooms.php';
        } else {
            require 'src/error/401.php';
        }
        break;

    case '/admin/manage/news':
        if (authenticated() && authorized("admin")) {
            require 'src/controllers/NewsController.php';
            require 'src/views/admin/manage/news.php';
        } else {
            require 'src/error/401.php';
        }
        break;

    case '/admin/manage/uploadnews':
        if (authenticated() && authorized("admin")) {
            require 'src/controllers/NewsController.php';
            require 'src/views/admin/manage/newsupload.php';
        } else {
            require 'src/error/401.php';
        }
        break;

    case '/admin/news/edit':
        if (authenticated() && authorized("admin")) {
            require 'src/controllers/NewsController.php';
        } else {
            require 'src/error/401.php';
        }
        break;

    case '/admin/news/delete':
        if (authenticated() && authorized("admin")) {
            require 'src/controllers/NewsController.php';
        } else {
            require 'src/error/401.php';
        }
        break;

    case '/admin/users/edit':
        if (authenticated() && authorized("admin")) {
            require 'src/controllers/UserController.php';
        } else {
            require 'src/error/401.php';
        }
        break;

    case '/admin/users/add':
        if (authenticated() && authorized("admin")) {
            require 'src/controllers/UserController.php';
        } else {
            require 'src/error/401.php';
        }
        break;

    case '/admin/users/delete':
        if (authenticated() && authorized("admin")) {
            require 'src/controllers/UserController.php';
        } else {
            require 'src/error/401.php';
        }
        break;

    case '/news':
        require 'src/controllers/NewsController.php';
        require 'src/views/news.php';
        break;

    case '/news/submit':
        if (authenticated() && authorized("admin")) {
            require 'src/controllers/NewsController.php';
        } else {
            require 'src/error/401.php';
        }
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
