<?php

class Logger {
    private $logFile;

    public function __construct($filePath) {
        $this->logFile = fopen($filePath, 'a');
        if (!$this->logFile) {
            throw new Exception("Could not open log file for writing.");
        }
    }

    public function log($message) {
        $timestamp = date('Y-m-d H:i:s');
        $logMessage = "[$timestamp] $message" . PHP_EOL;
        fwrite($this->logFile, $logMessage);
    }

    public function __destruct() {
        if ($this->logFile) {
            fclose($this->logFile);
        }
    }
}