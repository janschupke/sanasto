<?php

use io\schupke\sanasto\core\repository\RepositoryManager;
use io\schupke\sanasto\core\core\service\ServiceManager;
use io\schupke\sanasto\core\core\controller\AbstractControllerManager;

require(Config::getInstance()->getModulePath()
    . ConfigValues::MOD_ADMIN . "/controller/accountController.php");
require(Config::getInstance()->getModulePath()
    . ConfigValues::MOD_ADMIN . "/controller/backupController.php");
require(Config::getInstance()->getModulePath()
    . ConfigValues::MOD_ADMIN . "/controller/feedbackController.php");
require(Config::getInstance()->getModulePath()
    . ConfigValues::MOD_ADMIN . "/controller/generalController.php");

/**
 * Standard controller manager for account module.
 */
class ControllerManager extends AbstractControllerManager {
    private $accountController;
    private $backupController;
    private $feedbackController;
    private $generalController;

    function __construct(RepositoryManager $rm, ServiceManager $sm) {
        parent::__construct($rm, $sm);

        $this->accountController = new AccountController($this);
        $this->backupController = new BackupController($this);
        $this->feedbackController = new FeedbackController($this);
        $this->generalController = new GeneralController($this);
    }

    public function getAccountController() {
        return $this->accountController;
    }

    public function getBackupController() {
        return $this->backupController;
    }

    public function getFeedbackController() {
        return $this->feedbackController;
    }

    public function getGeneralController() {
        return $this->generalController;
    }
}
