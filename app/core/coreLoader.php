<?php

require(Config::getInstance()->getCorePath()
    . "/controller/abstractController.php");
require(Config::getInstance()->getCorePath()
    . "/controller/abstractCoreController.php");
require(Config::getInstance()->getCorePath()
    . "/controller/abstractControllerManager.php");

// Service loading.
require(Config::getInstance()->getCorePath()
    . "/service/serviceManager.php");
