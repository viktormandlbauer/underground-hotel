<?php

function set_flash_message($type, $message) {
    $_SESSION['flash_messages'][$type] = $message;
}

if (isset($_SESSION['flash_messages'])) {
    foreach ($_SESSION['flash_messages'] as $type => $message) {
        $alert_class = $type === 'success' ? 'alert-success' : 'alert-danger';
         echo "<div class='alert $alert_class' role='alert'>" . htmlspecialchars($message) . "</div>";
    }
    // Flash-Nachrichten löschen
    unset($_SESSION['flash_messages']);
}
    
?>