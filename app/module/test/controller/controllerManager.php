<?php

use io\schupke\sanasto\core\repository\RepositoryManager;
use io\schupke\sanasto\core\core\service\ServiceManager;
use io\schupke\sanasto\core\core\controller\AbstractControllerManager;

require(Config::getInstance()->getModulePath()
    . ConfigValues::MOD_TEST . "/controller/testController.php");

/**
 * Standard controller manager for account module.
 */
class ControllerManager extends AbstractControllerManager {
    private $testController;

    function __construct(RepositoryManager $rm, ServiceManager $sm) {
        parent::__construct($rm, $sm);

        $this->testController = new TestController($this);
    }

    public function getTestController() {
        return $this->testController;
    }
}
