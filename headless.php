<?php

use io\schupke\sanasto\core\Provider;

// Always contains absolute web path to the current module root.
$currentModuleRoot = Config::getInstance()->getModuleRoot();

// Index module is not explicitly stated in the path.
if ($_SESSION["currentModule"] != ConfigValues::MOD_INDEX) {
    $currentModuleRoot .= $_SESSION["currentModule"];
}

require(Config::getInstance()->getUtilPath() . "/utilLoader.php");
require(Config::getInstance()->getEntityPath() . "/entityManager.php");
require(Config::getInstance()->getMapperPath() . "/entityMapperManager.php");
require(Config::getInstance()->getCorePath() . "/coreLoader.php");

// Cannot be in init.php; requires security.php.
// Represents default access level for any visitor.
if (!isset($_SESSION["access"])) {
    $_SESSION["access"] = Security::FREE;
}

// Contains language / translation logic.
setLanguage();

// Actual language files.
require(Config::getInstance()->getGlobalResourcePath()
    . "/locale/" . ConfigValues::DEFAULT_LANGUAGE . ".php");
require(Config::getInstance()->getGlobalResourcePath()
    . "/locale/" . $_SESSION["language"] . ".php");

// Connects to the database.
require("app/config/database.php");

// General application controller.
require(Config::getInstance()->getModulePath() . ConfigValues::MOD_CORE
    . "/controller/coreControllerManager.php");

// Module-specific controller - business logic.
require(Config::getInstance()->getModulePath()
    . $_SESSION["currentModule"] . "/controller/controllerManager.php");

require(Config::getInstance()->getRepositoryPath() . "/repositoryManager.php");
require(Config::getInstance()->getExceptionPath() . "/exceptionLoader.php");
require(Config::getInstance()->getCorePath() . "/provider.php");

// Object initialization.
$provider = new Provider($dbh);

// Assigns general event handler.
require(Config::getInstance()->getModulePath() . ConfigValues::MOD_CORE
    . "/controller/coreHandler.php");

// Assings module-specific event handler.
require(Config::getInstance()->getModulePath() . $_SESSION["currentModule"]
    . "/controller" . $_SESSION["currentModule"] . "Handler.php");

require(Config::getInstance()->getUtilPath() . "/routine/routineLoader.php");
require(Config::getInstance()->getModulePath() . "/partial/viewVars.php");
