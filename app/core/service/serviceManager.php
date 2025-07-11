<?php

namespace io\schupke\sanasto\core\core\service;

use Config;

require(Config::getInstance()->getCorePath()
    . "/service/abstractService.php");
require(Config::getInstance()->getCorePath()
    . "/service/registrationService.php");
require(Config::getInstance()->getCorePath()
    . "/service/utilityService.php");

/**
 * Standard service manager for the application.
 */
class ServiceManager {
    private $registrationService;
    private $utilityService;

    function __construct() {
        $this->registrationService = new RegistrationService();
        $this->utilityService = new UtilityService();
    }

    public function getRegistrationService() {
        return $this->registrationService;
    }

    public function getUtilityService() {
        return $this->utilityService;
    }
}
