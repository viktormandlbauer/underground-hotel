<?php

require_once 'src/models/User.php';
require_once 'src/models/Booking.php';
require_once 'src/models/Room.php';

global $request;
global $method;

switch ([$request, $method]) {
    case ['/admin/manage/bookings', 'GET']:
        $rooms = Room::getAllRooms();
        $users = User::getAllUsers();
        $bookings = Booking::getAllBookings();
        break;

    case ['/bookings', 'GET']:
        $bookings = Booking::getMyBookings(User::getUseridByUsername($_SESSION['username']));
        break;

    }
