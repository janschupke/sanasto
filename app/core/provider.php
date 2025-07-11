<?php

namespace io\schupke\sanasto\core;

use io\schupke\sanasto\core\core\service\ServiceManager;
use io\schupke\sanasto\core\entity\mapper\EntityMapperManager;
use io\schupke\sanasto\core\repository\RepositoryManager;
use CoreControllerManager;
use ControllerManager;

/**
 * Instantiates managers of business and data tier objects.
 * Provides access to controller managers.
 */
class Provider {
    private $sm;
    private $emm;
    private $rm;
    private $cm;
    private $ccm;

    function __construct(\PDO $dbh) {
        $this->sm = new ServiceManager();
        $this->emm = new EntityMapperManager();
        $this->rm = new RepositoryManager($dbh, $this->emm);
        $this->cm = new ControllerManager($this->rm, $this->sm);
        $this->ccm = new CoreControllerManager($this->rm, $this->sm);
    }

    public function getCm() {
        return $this->cm;
    }

    public function getCcm() {
        return $this->ccm;
    }
}
