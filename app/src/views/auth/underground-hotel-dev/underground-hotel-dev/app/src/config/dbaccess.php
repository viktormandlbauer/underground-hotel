<?php
$host = getenv('DB_HOST');
$db_name = getenv('DB_DATABASE');
$username = getenv('DB_USER');
$password = getenv('DB_PASSWORD');

// Create connection
$conn = new mysqli($host, $username, $password, $db_name);

// Check connection
if ($conn->connect_error) {
    exit("Connection failed: " . $conn->connect_error);
}

// Now you can use $conn to interact with the database
?>