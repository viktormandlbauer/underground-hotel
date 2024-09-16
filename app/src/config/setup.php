<?php

require 'src/util/logger.php';

# Create log folder if it does not exist
if (!file_exists('logs')) {
    mkdir('logs');
}

$logger = new Logger('logs/test.log');

?>