<?php

namespace io\schupke\sanasto\core\core\service;

use ConfigValues;
use AlertHandler;

/**
 * Service providing application-wide general methods.
 */
class UtilityService extends AbstractService {
    /**
     * Provides the re-captcha validation logic.
     * @return bool true if the box was successfully checked, false otherwise.
     */
    public function validateCaptcha() {
        global $l;

        $value;

        if (isset($_POST['g-recaptcha-response'])) {
            $value = $_POST['g-recaptcha-response'];
        }

        if (!$value) {
            AlertHandler::addAlert(ConfigValues::ALERT_DANGER,
                $l["alert"]["global"]["danger"]["captcha"]["unchecked"]);
            return false;
        }

        $apiRequest = "https://www.google.com/recaptcha/api/siteverify?secret="
            . ConfigValues::RECAPTCHA_SECRET
            . "&response="
            . $captcha
            . "&remoteip="
            . $_SERVER['REMOTE_ADDR'];

        $response = file_get_contents($apiRequest);

        if ($response.success == false) {
            AlertHandler::addAlert(ConfigValues::ALERT_DANGER,
                $l["alert"]["global"]["danger"]["captcha"]["bad"]);
            return false;
        }

        return true;
    }
}
