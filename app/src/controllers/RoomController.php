<?php
require_once 'src/models/Room.php';
require_once 'src/util/request.php';

switch ($_SERVER['REQUEST_URI']) {
    case '/rooms/search':

        // Validate the JSON request
        try {
            $data = handle_request(['checkin_date', 'checkout_date']);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(['message' => $e->getMessage()]);
            exit;
        }

        // Search for free rooms
        $rooms = Room::search_free_rooms($data['checkin_date'], $data['checkout_date']);

        // Return the results
        if (!empty($rooms)) {
            echo json_encode($rooms);
        } else {
            http_response_code(204);
            echo json_encode(['message' => 'No rooms available']);
        }

        break;
}
