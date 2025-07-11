<?php

use io\schupke\sanasto\core\repository\RepositoryManager;
use io\schupke\sanasto\core\core\service\ServiceManager;
use io\schupke\sanasto\core\core\controller\AbstractControllerManager;

/**
 * Standard controller for index module.
 */
class ControllerManager extends AbstractControllerManager {
    function __construct(RepositoryManager $rm, ServiceManager $sm) {
        parent::__construct($rm, $sm);
    }

    // No logic should be here. Index module is meant
    // to consist of static pages only.
}
