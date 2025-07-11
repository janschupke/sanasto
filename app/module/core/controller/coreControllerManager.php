<?php

use io\schupke\sanasto\core\repository\RepositoryManager;
use io\schupke\sanasto\core\core\service\ServiceManager;
use io\schupke\sanasto\core\core\controller\AbstractControllerManager;

require(Config::getInstance()->getModulePath()
    . ConfigValues::MOD_CORE . "/controller/coreController.php");
require(Config::getInstance()->getModulePath()
    . ConfigValues::MOD_CORE . "/controller/signInController.php");
require(Config::getInstance()->getModulePath()
    . ConfigValues::MOD_CORE . "/controller/registrationController.php");

/**
 * Standard controller manager for core controllers.
 */
class CoreControllerManager extends AbstractControllerManager {
    private $coreController;
    private $signInController;
    private $registrationController;

    function __construct(RepositoryManager $rm, ServiceManager $sm) {
        parent::__construct($rm, $sm);

        $this->coreController = new CoreController($this);
        $this->signInController = new SignInController($this);
        $this->registrationController = new RegistrationController($this);
    }

    public function getCoreController() {
        return $this->coreController;
    }

    public function getSignInController() {
        return $this->signInController;
    }

    public function getRegistrationController() {
        return $this->registrationController;
    }
}
