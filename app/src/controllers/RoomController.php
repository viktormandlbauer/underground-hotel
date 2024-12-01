<?php
require_once 'src/models/Room.php';
require_once 'src/util/Image.php';

global $request;
global $method;

switch ([$request, $method]) {

    case ['/admin/manage/rooms', 'GET']:

        // Get all rooms
        $rooms = Room::getAllRooms();


        break;

    case ['/rooms', 'GET']:

        // Get all request data
        $params = filter_input_array(INPUT_GET, [
            'checkin' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            'checkout' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            'price_min' => FILTER_SANITIZE_NUMBER_INT,
            'price_max' => FILTER_SANITIZE_NUMBER_INT,
            'person_count' => FILTER_SANITIZE_NUMBER_INT
        ]);

        $checkin = $params['checkin'] ?? '1900-01-01';
        $checkout = $params['checkout'] ?? '1900-01-01';
        $price_min = $params['price_min'] ?? '0';
        $price_max = $params['price_max'] ?? '300';
        $person_count = $params['person_count'] ?? '1';

        // Search for free rooms
        $rooms = Room::searchFreeRooms($checkin, $checkout, $price_min, $price_max);

        break;

    case ['/rooms/search', 'GET']:

        // Get all request data
        $params = filter_input_array(INPUT_GET, [
            'checkin' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            'checkout' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            'price_min' => FILTER_SANITIZE_NUMBER_INT,
            'price_max' => FILTER_SANITIZE_NUMBER_INT,
            'person_count' => FILTER_SANITIZE_NUMBER_INT
        ]);

        $checkin = $params['checkin'] ?? '1900-01-01';
        $checkout = $params['checkout'] ?? '1900-01-01';
        $price_min = $params['price_min'] ?? '0';
        $price_max = $params['price_max'] ?? '300';
        $person_count = $params['person_count'] ?? '1';

        // Search for free rooms
        $rooms = Room::search_free_rooms($checkin, $checkout, $price_min, $price_max);

        break;
    case ['/admin/rooms/create', 'POST']:
        if (isset($_POST['room_number']) && isset($_POST['room_name']) && isset($_POST['room_type']) && isset($_POST['room_description']) && isset($_POST['price_per_night'])) {

            $image = Image::handleImageUpload('rooms', true, 720, 480);

            if ($image->uploaded) {
                $room = Room::createRoom($_POST['room_number'], $_POST['room_name'], $_POST['room_description'], $_POST['room_type'], $_POST['price_per_night'], $image->getPath());
            } else {
                $room = Room::createRoom($_POST['room_number'], $_POST['room_name'], $_POST['room_description'], $_POST['room_type'], $_POST['price_per_night'], null);
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
