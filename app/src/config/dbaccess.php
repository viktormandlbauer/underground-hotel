<?php
$host = 'localhost';
$db_name = 'hotel';
$username = 'hotel';
$password = 'hotel';

// Create connection
$conn = new mysqli($host, $username, $password, $db_name);

// Check connection
if ($conn->connect_error) {
    exit("Connection failed: " . $conn->connect_error);
}

// Now you can use $conn to interact with the database
// TODO - Implement CRUD operations
?>