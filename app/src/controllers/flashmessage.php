<?php

function set_flash_message($type, $message) {
    $_SESSION['flash_messages'][$type] = $message;
}

if (isset($_SESSION['flash_messages'])) {
    foreach ($_SESSION['flash_messages'] as $type => $message) {
        $alert_class = $type === 'success' ? 'alert-success' : 'alert-danger';
         echo  "
        <svg xmlns='http://www.w3.org/2000/svg' style='display: none;'>
            <symbol id='alert-success' fill='currentColor' viewBox='0 0 16 16'>
                <path d='M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z'/>
            </symbol>
            <symbol id='alert-danger' fill='currentColor' viewBox='0 0 16 16'>
                <path d='M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z'/>
            </symbol>
        </svg>
        <div class='alert $alert_class alert-dismissible d-flex' role='alert'>
            <svg class='bi flex-shrink-0 me-2' width='24' height='24' role='img' aria-label='" . htmlspecialchars($type) . ":'>
                <use xlink:href='#$alert_class'/>
            </svg> " . htmlspecialchars($message) . "
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
    }
    // Flash-Nachrichten löschen
    unset($_SESSION['flash_messages']);
}