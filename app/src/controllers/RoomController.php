<?php
require_once 'src/models/Room.php';
require_once 'src/util/Image.php';
require_once 'src/util/request.php';

global $request;
global $method;

switch ([$request, $method]) {
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
        $rooms = Room::search_free_rooms($checkin, $checkout, $price_min, $price_max);

        break;
    case ['/rooms/create', 'POST']:

        if (isset($_POST['room_number']) && isset($_POST['room_name']) && isset($_POST['room_type']) && isset($_POST['room_description']) && isset($_POST['price_per_night'])) {

            $image = Image::handleImageUpload('rooms', true, 720, 480);

            $user_id = User::getUseridByUsername($_SESSION['username']);

            if ($image->uploaded) {
                $room = Room::createRoom($_POST['room_number'], $_POST['room_name'], $_POST['room_description'], $_POST['room_type'], $_POST['price_per_night'], $image->getPath());
            } else {
                $room = Room::createRoom($_POST['room_number'], $_POST['room_name'], $_POST['room_description'], $_POST['room_type'], $_POST['price_per_night'], null);
            }

            $_SESSION['flash_message'] = 'Room created successfully.';
            header('Location: /rooms');
        } else {
            $_SESSION['flash_message'] = 'Error creating rooms.';
            header('Location: /admin/manage/rooms');
        }
        break;
}
