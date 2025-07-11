<?php

use io\schupke\sanasto\core\repository\RepositoryManager;
use io\schupke\sanasto\core\core\service\ServiceManager;
use io\schupke\sanasto\core\core\controller\AbstractControllerManager;

require(Config::getInstance()->getModulePath()
    . ConfigValues::MOD_COLLECTION . "/controller/importController.php");
require(Config::getInstance()->getModulePath()
    . ConfigValues::MOD_COLLECTION . "/controller/languageController.php");
require(Config::getInstance()->getModulePath()
    . ConfigValues::MOD_COLLECTION . "/controller/linkController.php");
require(Config::getInstance()->getModulePath()
    . ConfigValues::MOD_COLLECTION . "/controller/maintenanceController.php");
require(Config::getInstance()->getModulePath()
    . ConfigValues::MOD_COLLECTION . "/controller/wordController.php");
require(Config::getInstance()->getModulePath()
    . ConfigValues::MOD_COLLECTION . "/controller/generalController.php");

/**
 * Standard controller manager for account module.
 */
class ControllerManager extends AbstractControllerManager {
    private $importController;
    private $languageController;
    private $linkController;
    private $maintenanceController;
    private $wordController;
    private $generalController;

    function __construct(RepositoryManager $rm, ServiceManager $sm) {
        parent::__construct($rm, $sm);

        $this->importController = new ImportController($this);
        $this->languageController = new LanguageController($this);
        $this->linkController = new LinkController($this);
        $this->maintenanceController = new MaintenanceController($this);
        $this->wordController = new WordController($this);
        $this->generalController = new GeneralController($this);
    }

    public function getImportController() {
        return $this->importController;
    }

    public function getLanguageController() {
        return $this->languageController;
    }

    public function getLinkController() {
        return $this->linkController;
    }

    public function getMaintenanceController() {
        return $this->maintenanceController;
    }

    public function getWordController() {
        return $this->wordController;
    }

    public function getGeneralController() {
        return $this->generalController;
    }
}
