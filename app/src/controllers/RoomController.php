<?php
require_once 'src/models/Room.php';
require_once 'src/util/json.php';

switch ($_SERVER['REQUEST_URI']) {
    case '/search/rooms':
        try {
            $data = process_json_request(['checkin_date', 'checkout_date', 'person_count', 'price_min', 'price_max']);
        } catch (Exception $e) {
            error_log("Error: " . $e->getMessage());
            echo json_encode(['error' => $e->getMessage()]);
            exit;
        }
        
        $rooms = Room::search_free_rooms($data['checkin_date'], $data['checkout_date']);

        echo json_encode($rooms);
        break;
}