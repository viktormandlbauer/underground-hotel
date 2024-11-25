<?php
require_once 'src/models/Room.php';
require_once 'src/util/request.php';

global $request;

switch ($request) {
    case '/rooms':

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
}
