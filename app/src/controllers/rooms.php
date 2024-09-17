<?php
require 'src/util/logger.php';
require 'src/models/room.php';

$logger = new Logger('logs/rooms.log');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_SERVER['REQUEST_URI'] == '/search/rooms') {

        $data = json_decode(file_get_contents('php://input'), true);

        $logger->log('Received data: ' . print_r($data, true));

        if (json_last_error() !== JSON_ERROR_NONE) {
            $logger->log('Invalid JSON');
            http_response_code(400);
            echo json_encode(['error' => 'Invalid JSON']);
            exit;
        }

        if (!isset($data['checkin_date']) || !isset($data['checkout_date'])) {
            $logger->log('Invalid data');
            http_response_code(400);
            echo json_encode(['error' => 'Invalid data']);
            exit;
        }

        $logger->log('Searching for free rooms between ' . $data['checkin_date'] . ' and ' . $data['checkout_date']);
        $rooms = \App\Models\Room::search_free_rooms($data['checkin_date'], $data['checkout_date']);
        $logger->log('Found rooms: ' . print_r($rooms, true));
        echo json_encode($rooms);
    }
}
