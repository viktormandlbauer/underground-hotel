<?php
$db_host = getenv('DB_HOST') ?? 'host.docker.internal';
$db_name = getenv('DB_DATABASE') ?? 'hotel';
$db_user = getenv('DB_USER') ?? 'hotel';
$db_password = getenv('DB_PASSWORD') ?? 'hotel';
$db_port = getenv('DB_PORT') ?? 3306;

// Create connection
$conn = new mysqli($db_host, $db_name, $db_user, $db_password, $db_port);

// Check connection
if ($conn->connect_error) {
    exit("Connection failed: " . $conn->connect_error);
}
?>