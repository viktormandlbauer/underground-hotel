<?php

function process_json_request($args = array())
{
    $data = json_decode(file_get_contents('php://input'), true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        http_response_code(400);
        throw new Exception('Invalid JSON');
        exit;
    }

    foreach ($args as $arg) {
        if (!isset($data[$arg])) {
            http_response_code(400);
            throw new Exception('Missing ' . $arg);
        }
    }

    return $data;
}
