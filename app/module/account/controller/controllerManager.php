<?php

use io\schupke\sanasto\core\repository\RepositoryManager;
use io\schupke\sanasto\core\core\service\ServiceManager;
use io\schupke\sanasto\core\core\controller\AbstractControllerManager;

require(Config::getInstance()->getModulePath()
    . ConfigValues::MOD_ACCOUNT . "/controller/accountController.php");
require(Config::getInstance()->getModulePath()
    . ConfigValues::MOD_COLLECTION . "/controller/linkController.php");
require(Config::getInstance()->getModulePath()
    . ConfigValues::MOD_TEST . "/controller/testController.php");

/**
 * Standard controller manager for account module.
 */
class ControllerManager extends AbstractControllerManager {
    private $accountController;
    private $linkController;
    private $testController;

    function __construct(RepositoryManager $rm, ServiceManager $sm) {
        parent::__construct($rm, $sm);

        $this->accountController = new AccountController($this);
        $this->linkController = new LinkController($this);
        $this->testController = new TestController($this);
    }

    public function getAccountController() {
        return $this->accountController;
    }
    public function getLinkController() {
        return $this->linkController;
    }
    public function getTestController() {
        return $this->testController;
    }
}
