<?php

function process_json_request($args = array())
{
    $data = json_decode(file_get_contents('php://input'), true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid JSON']);
        exit;
    }

    foreach ($args as $arg) {
        if (!isset($data[$arg])) {
            throw new Exception('Missing ' . $arg);
        }
    }

    return $data;
}
