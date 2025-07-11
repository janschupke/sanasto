<?php

namespace io\schupke\sanasto\core\core\controller;

use io\schupke\sanasto\core\repository\RepositoryManager;
use io\schupke\sanasto\core\core\service\ServiceManager;

/**
 * Abstract superclass controller manager
 * for all application's controllers manager to inherit from.
 */
abstract class AbstractControllerManager {
    protected $rm;
    protected $sm;

    function __construct(RepositoryManager $rm, ServiceManager $sm) {
        $this->rm = $rm;
        $this->sm = $sm;
    }

    public function getRm() {
        return $this->rm;
    }

    public function getSm() {
        return $this->sm;
    }
}
