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


    case ['/admin/manage/bookings/edit', 'POST']:
        $booking = new Booking($_POST['booking_id']);

        if (isset($_POST['editUserId'])) {
            $booking->setUserId($_POST['editUserId']);
        }
        if (isset($_POST['editRoomNumber'])) {
            $booking->setRoomNumber($_POST['editRoomNumber']);
        }
        if (isset($_POST['checkInDate'])) {
            $booking->setCheckIn($_POST['editCheckInDate']);
        }
        if (isset($_POST['checkOutDate'])) {
            $booking->setCheckOut($_POST['editCheckOutDate']);
        }
        if (isset($_POST['editStatus'])) {
            $booking->setStatus($_POST['editStatus']);
        }
        if (isset($_POST['editBreakfast'])) {
            $booking->setBreakfast($_POST['editBreakfast']);
        }
        if (isset($_POST['editParking'])) {
            $booking->setParking($_POST['editParking']);
        }
        if (isset($_POST['editPet'])) {
            $booking->setPet($_POST['editPet']);
        }
        if (isset($_POST['editRemarks'])) {
            $booking->setAdditionalInfo($_POST['editRemarks']);
        }
        $_SESSION['flash_message'] = 'Buchung erfolgreich aktualisiert.';

        header('Location: /admin/manage/bookings');

        break;

    default:
        $_SESSION['flash_message'] = 'Fehler beim aktualisieren der Buchung.';
        header ('Location: /admin/manage/bookings');
        break;
}
