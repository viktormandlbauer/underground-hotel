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
function handle_request($requiredKeys = []): array
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        // Handle POST request with JSON data
        if (json_validate(file_get_contents('php://input'))) {

            // Get the JSON data
            $data = json_decode(file_get_contents('php://input'), true);

            // Check if the required keys are present
            foreach ($requiredKeys as $key) {
                if (!isset($data[$key])) {
                    throw new Exception('Missing key in JSON: "' . $key . '"');
                } else {
                    // Sanitize the data
                    sanitizeData($data[$key]);
                }
            }
            return $data;
        }

        // Handle POST request
        foreach ($requiredKeys as $key) {
            if (!isset($_POST[$key])) {
                throw new Exception('Missing key in POST request: "' . $key . '"');
            } else {
                // Sanitize the data
                sanitizeData($_POST[$key]);
            }
        }
        $data = $_POST;
    } else if ($_SERVER['REQUEST_METHOD'] === 'GET') {

        // Handle GET request
        foreach ($requiredKeys as $key) {
            if (!isset($_GET[$key])) {
                throw new Exception('Missing key in GET request: "' . $key . '"');
            } else {
                // Sanitize the data
                sanitizeData($_GET[$key]);
            }
        }
        $data = $_GET;
    } else {
        throw new Exception('Invalid request method');
    }


    return $data;
}
