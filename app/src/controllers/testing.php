<?php


# if index.php doesnt exist, we need to change the directory to the root of the project

if (!file_exists('index.php')) {
    chdir('../../');
}

echo "This is a test controller running in: ";
echo getcwd();

echo "Including logging utility";
include 'src/util/logger.php';

$logger = new Logger('logs/test.log');
$logger->log('Test log message');

# Request handling
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $logger->log('Handling GET request');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $logger->log('Handling POST request');
}

# Including database access
$logger->log('Including database access');
include 'src/config/dbaccess.php';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

# SQL Routine
$logger->log('Printing all views');
$sql = "SELECT * FROM views";


$conn->close();
?>