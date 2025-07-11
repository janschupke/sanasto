<?php

use io\schupke\sanasto\core\core\controller\AbstractController;

/**
 * General handling controller for collection module.
 * Contains method that did not fit elsewhere.
 */
class GeneralController extends AbstractController {
    function __construct(ControllerManager $cm) {
        parent::__construct($cm);
    }
}
