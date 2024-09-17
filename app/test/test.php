<?php
# if index.php doesnt exist, we need to change the directory to the root of the project

if (!file_exists('index.php')) {
    chdir('../../');
}

echo "This is a test controller running in: " . getcwd() . "\r\n";

include 'src/util/logger.php';

$logger = new Logger('logs/test.log');
$logger->log('Test log message');

# Including database access
$logger->log('Including database access');
include 'src/config/dbaccess.php';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

# Registration

$logger->log('Testing registration');
include 'src/models/user.php';

$url = 'http://127.0.0.1/auth/submit/registration';

# Form data
$data = ['pronouns' => 'they/them', 
        'givenname' => 'Max',
        'surname' => 'Mustermann',
        'email' => 'max@mustermann.at',
        'username' => 'maxdome',
        'password' => '12345678'];

# Create http context
$options = [
    'http' => [
        'header' => "Content-type: application/x-www-form-urlencoded\r\n",
        'method' => 'POST',
        'content' => http_build_query($data),
    ],
];
$context = stream_context_create($options);
$result = file_get_contents($url, false, $context);

session_start();
echo "Current session: " . $_SESSION['username'];

$conn->close();
?>