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

        if (isset($_POST['user_id'])) {
            $booking->setUserId($_POST['user_id']);
        }
        if (isset($_POST['room_number'])) {
            $booking->setRoomNumber($_POST['room_number']);
        }
        if (isset($_POST['check_in_date'])) {
            $booking->setCheckIn($_POST['check_in_date']);
        }
        if (isset($_POST['check_out_date'])) {
            $booking->setCheckOut($_POST['check_out_date']);
        }
        if (isset($_POST['status'])) {
            $booking->setStatus($_POST['status']);
        }

        $booking->setBreakfast($_POST['with_breakfast'] ?? 0);

        $booking->setParking($_POST['with_parking'] ?? 0);

        $booking->setPet($_POST['with_pet'] ?? 0);

        if (isset($_POST['remarks'])) {
            $booking->setAdditionalInfo($_POST['remarks']);
        }
        $_SESSION['flash_message'] = 'Buchung erfolgreich aktualisiert.';

        header('Location: /admin/manage/bookings');

        break;

    default:
        $_SESSION['flash_message'] = 'Fehler beim aktualisieren der Buchung.';
        header('Location: /admin/manage/bookings');
        break;


    case ['/admin/manage/bookings/add', 'POST']:
        $bookingData = [
            'user_id' => $_POST['user_id'],
            'room_number' => intval($_POST['room_number']),
            'check_in_date' => $_POST['check_in_date'],
            'check_out_date' => $_POST['check_out_date'],
            'status' => 'new',
            'breakfast' => $_POST['with_breakfast'] ?? 0,
            'parking' => $_POST['with_parking'] ?? 0,
            'pet' => $_POST['with_pet'] ?? 0,
            'additional_info' => $_POST['remarks'],
            'price_per_night' => $_POST['price_per_night']
        ];

        if (!Room::isRoomFree($bookingData['room_number'], $bookingData['check_in_date'], $bookingData['check_out_date'])) {
            $_SESSION['flash_message'] = 'Raum ist in diesem Zeitraum nicht verfügbar.';
            header('Location: /admin/manage/bookings');
            exit();
        }

        $bookingSuccess = Booking::createBooking($bookingData);

        if ($bookingSuccess) {
            $_SESSION['flash_message'] = 'Buchung erfolgreich hinzugefügt.';
            header('Location: /admin/manage/bookings');
            exit();
        } else {
            $_SESSION['flash_message'] = 'Fehler beim Hinzufügen der Buchung.';
            header('Location: /admin/manage/bookings');
        }

        break;

}
