<?php

function process_json_request($args = []): array
{

    $data = json_decode(file_get_contents('php://input'), true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        http_response_code(400);
        throw new Exception('Invalid JSON');
    }

    // Recursive function to sanitize each value
    function sanitizeData(&$value) {
        if (is_array($value)) {
            // If it's an array, loop through each element
            foreach ($value as &$subValue) {
                sanitizeData($subValue);
            }
        } else {
            // Sanitize individual value
            $value = htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
        }
    }

    foreach ($args as $arg) {
        if (isset($arg)) {
            $arg = sanitizeData($data[$arg]);   
        }
    }

    return $data;
}
