<?php
require_once 'src/models/User.php';
require_once 'src/models/Room.php';
require_once 'src/util/Image.php';
require_once 'src/models/Booking.php';

global $request;
global $method;


switch ([$request, $method]) {

    case ['/rooms', 'GET']:
        
        error_log(implode($_GET));
        if (isset($_GET['start_date'], $_GET['end_date'], $_GET['price_min'], $_GET['price_max'], $_GET['person_count'])) {
            
            $start_date = $_GET['start_date'];
            $end_date = $_GET['end_date'];
            $price_min = $_GET['price_min'];
            $price_max = $_GET['price_max'];
            $person_count = $_GET['person_count'];

            $rooms = Room::searchFreeRooms($start_date, $end_date, $price_min, $price_max);
        } else {
            $rooms = Room::getAllRooms();
        }

        break;

    case ['/rooms/booking', 'POST']:

        $bookingData = [
            'user_id' => User::getUseridByUsername($_SESSION['username']),
            'room_number' => $_POST['room_number'],
            'check_in_date' => $_POST['arrival_date'],
            'check_out_date' => $_POST['departure_date'],
            'price_per_night' => $_POST['price_per_night'],
            'status' => 'new',
            'breakfast' => isset($_POST['with_breakfast']) ? 1 : 0,
            'parking' => isset($_POST['with_parking']) ? 1 : 0,
            'pet' => isset($_POST['with_pet']) ? 1 : 0,
            'additional_info' => $_POST['remarks']

        ];

        if (!Room::isRoomFree($bookingData['room_number'], $bookingData['check_in_date'], $bookingData['check_out_date'])) {
            header('Location: /rooms');
            $_SESSION['flash_message'] = 'Zimmer ist nicht verfügbar.';

            exit();
        }
        
        $bookingSuccess = Booking::createBooking($bookingData);

            if($bookingSuccess){
                $_SESSION['flash_message'] = 'Buchung erfolgreich.';
                header('Location: /rooms');
                exit();
            }

            else{
                $_SESSION['flash_message'] = 'Fehler bei der Buchung.';
                header('Location: /rooms');

            }

        break;

    case ['/admin/manage/rooms', 'GET']:

        // Get all rooms
        $rooms = Room::getAllRooms();

        break;

    case ['/admin/rooms/create', 'POST']:
        if (isset($_POST['room_number']) && isset($_POST['room_name']) && isset($_POST['room_type']) && isset($_POST['room_description']) && isset($_POST['price_per_night'])) {

            $image = Image::handleImageUpload('rooms', true, 720, 480);

            if ($image->uploaded) {
                $article = Room::createRoom($_POST['room_number'], $_POST['room_name'], $_POST['room_description'], $_POST['room_type'], $_POST['price_per_night'], $image->getPath());
            } else {
                $article = Room::createRoom($_POST['room_number'], $_POST['room_name'], $_POST['room_description'], $_POST['room_type'], $_POST['price_per_night'], null);
            }

            $_SESSION['flash_message'] = 'Room created successfully.';
        } else {
            $_SESSION['flash_message'] = 'Error creating rooms.';
        }
        header('Location: /admin/manage/rooms');
        break;

    case ['/admin/rooms/edit', 'POST']:

        if (isset($_POST['number'], $_POST['name'], $_POST['description'], $_POST['type'], $_POST['price_per_night'])) {

            $image = Image::handleImageUpload('rooms', true, 720, 480);

            if ($image->uploaded) {
                $imagePath = $image->getPath();
            } else {
                $imagePath = null;
            }

            Room::updateRoom(intval($_POST['number']), $_POST['name'], $_POST['description'], $_POST['type'], $_POST['price_per_night'], $imagePath);

            $_SESSION['flash_message'] = 'Zimmer erfolgreich aktualisiert.';
        } else {
            $_SESSION['flash_message'] = 'Fehler beim aktualisieren.';
        }
        header('Location: /admin/manage/rooms');
        break;

    case ['/admin/rooms/delete', 'POST']:
        if (isset($_POST['number'])) {

            Room::deleteRoom(intval($_POST['number']));

            $_SESSION['flash_message'] = 'Zimmer erfolgreich gelöscht.';
        } else {
            $_SESSION['flash_message'] = 'Fehler beim Löschen.';
        }
        header('Location: /admin/manage/rooms');
        break;
}
