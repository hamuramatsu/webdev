<?php

if (isset($_GET['username']) && isset($_GET['room']) && isset($_GET['action'])) {
    $username = $_GET['username'];
    $room = $_GET['room'];
    $action = $_GET['action'];

    // Log the activity
    $logMessage = date('Y-m-d H:i:s') . " | IP:" . $_SERVER['REMOTE_ADDR'] . " | User '$username' $action in room '$room'\n";
    file_put_contents('logs.txt', $logMessage, FILE_APPEND);

    echo "Activity logged.";
}
?>
