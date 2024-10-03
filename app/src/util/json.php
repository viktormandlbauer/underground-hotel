<?php

function json_request($params = [])
{
    global $logger;

    // Check if request method is POST
    if($_SERVER['REQUEST_METHOD'] !== 'POST') {
        $logger->log('Invalid request method');
        http_response_code(405);
        echo json_encode(['error' => 'Invalid request method']);
        exit();
    }

    // Read input data
    $data = json_decode(file_get_contents('php://input'), true);

    // Check if JSON is valid
    if (json_last_error() !== JSON_ERROR_NONE) {
        $logger->log('Invalid JSON');
        http_response_code(400);
        echo json_encode(['error' => 'Invalid JSON']);
        exit();
    }

    // Check if all required parameters are set
    if(!empty($params)) {
        foreach($params as $param) {
            if(!isset($data[$param])) {
                $logger->log('Missing parameter: ' . $param);
                http_response_code(400);
                echo json_encode(['error' => 'Missing parameter: ' . $param]);
                exit();
            }
        }
    }

    return $data;
}
