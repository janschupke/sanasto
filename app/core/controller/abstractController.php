<?php

namespace io\schupke\sanasto\core\core\controller;

use ControllerManager;

/**
 * Abstract superclass controller for all application's controllers to inherit from.
 */
abstract class AbstractController {
    protected $cm;
    protected $rm;
    protected $sm;

    function __construct(ControllerManager $cm) {
        $this->cm = $cm;
        $this->rm = $cm->getRm();
        $this->sm = $cm->getSm();
    }
}
