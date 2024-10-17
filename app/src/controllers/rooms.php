<?php
require 'src/util/logger.php';
require 'src/models/room.php';
require 'src/util/json.php';

$logger = new Logger('logs/rooms.log');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_SERVER['REQUEST_URI'] == '/search/rooms') {

        try {
            $data = process_json_request(['checkin_date', 'checkout_date', 'person_count', 'price_min', 'test']);
        } catch (Exception $e) {
            error_log("Error: " . $e->getMessage());
            http_response_code(400);
            echo json_encode(['error' => $e->getMessage()]);
            exit;
        }

        $logger->log('Searching for free rooms between ' . $data['checkin_date'] . ' and ' . $data['checkout_date']);
        $rooms = \App\Models\Room::search_free_rooms($data['checkin_date'], $data['checkout_date']);
        
        $logger->log('Found rooms: ' . print_r($rooms, true));
        echo json_encode($rooms);
    }
}