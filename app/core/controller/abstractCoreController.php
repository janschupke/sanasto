<?php

namespace io\schupke\sanasto\core\core\controller;

use CoreControllerManager;

/**
 * Abstract superclass controller for all application's controllers to inherit from.
 */
abstract class AbstractCoreController extends AbstractController {
    function __construct(CoreControllerManager $ccm) {
        $this->cm = $ccm;
        $this->rm = $ccm->getRm();
        $this->sm = $ccm->getSm();
    }
}
