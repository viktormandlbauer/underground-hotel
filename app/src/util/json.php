<?php

// Function to sanitize data
function sanitizeData(&$value)
{

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

// Function to validate JSON requests
function validate_json_request($requiredKeys = []): array
{
    // Get the JSON data
    $data = json_decode(file_get_contents('php://input'), true);

    // Check if the JSON is valid
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception('Invalid JSON');
    }

    // Check if all required keys are present
    foreach ($requiredKeys as $key) {
        if (!isset($data[$key])) {
            throw new Exception('Missing ' . $key);
        } else {
            // Sanitize the data
            sanitizeData($data[$key]);
        }
    }

    return $data;
}
