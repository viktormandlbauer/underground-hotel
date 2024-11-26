<?php
require_once 'src/models/Room.php';
require_once 'src/util/request.php';

global $request;

switch ($request) {
    case '/rooms':

        // Get the request data
        $checkin = isset($_GET['checkin']) ? $_GET['checkin'] : '1900-01-01';
        $checkout = isset($_GET['checkout']) ? $_GET['checkout'] : '1900-01-01';        
        $price_min = isset($_GET['price_min']) ? $_GET['price_min'] : '0';
        $price_max = isset($_GET['price_max']) ? $_GET['price_max'] : '300';
        $person_count = isset($_GET['person_count']) ? $_GET['person_count'] : '1';

        error_log("Checkin: $checkin, Checkout: $checkout, Price min: $price_min, Price max: $price_max");

        // Search for free rooms
        $rooms = Room::search_free_rooms($checkin, $checkout, $price_min, $price_max);

        break;
}
