<?php

// Needs to be initialized as an array beforehand
if (!isset($_SESSION["alert"]) or $_SESSION["alert"] == null) {
    $_SESSION["alert"] = [];
}

/**
 * Takes care of adding new alerts to the queue.
 */
class AlertHandler {
    /**
     * Adds an alert to the session queue.
     * @param string $type type of the alert, should represend one of Bootstrap's alert classes.
     * @param string $message message to be displayed as the alert.
     * @return null.
     */
    public static function addAlert($type, $message) {
        array_push($_SESSION["alert"], array($type, $message));
    }
}
