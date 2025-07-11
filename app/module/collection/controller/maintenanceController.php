<?php

use io\schupke\sanasto\core\core\controller\AbstractController;

/**
 * Maintenance handling controller for collection module.
 */
class MaintenanceController extends AbstractController {
    const TASK_UNPRIORITIZE = "unprioritize";
    const TASK_SET_UNKNOWN = "setUnknown";
    const TASK_WIPE_DB = "wipeDb";

    function __construct(ControllerManager $cm) {
        parent::__construct($cm);
    }

    /**
     * Executes one of the available maintenance tasks.
     * @param string $password Authorization password the user typed in.
     * @param string $taskType The type of action to be executed.
     */
    public function executeTask($password, $taskType) {
        global $l;

        $account = $this->rm->getAccountRepository()->findById($_SESSION["account"]["id"]);
        $providedHash = Security::makeHash($password, $account->getSalt());

        if ($providedHash != $account->getPassword()) {
            AlertHandler::addAlert(ConfigValues::ALERT_DANGER,
                $l["alert"]["collection"]["maintenance"]["danger"]["invalidPassword"]);
            return;
        }

        switch($taskType) {
            case MaintenanceController::TASK_UNPRIORITIZE:
                $this->executeUnprioritize();
                break;

            case MaintenanceController::TASK_SET_UNKNOWN:
                $this->executeSetUnknown();
                break;

            case MaintenanceController::TASK_WIPE_DB:
                $this->executeWipe();
                break;

            default:
                AlertHandler::addAlert(ConfigValues::ALERT_DANGER,
                    $l["alert"]["collection"]["maintenance"]["danger"]["invalidTask"]);
                return;
        }

        header("Location: " . Config::getInstance()->getModuleRoot()
                . ConfigValues::MOD_COLLECTION . "/maintenance");
        die();
    }

    /**
     * Sets all translations of the currently signed-in account to unprioritized.
     */
    private function executeUnprioritize() {
        global $l;

        $this->rm->getLinkRepository()->unprioritize($_SESSION["account"]["id"]);

        AlertHandler::addAlert(ConfigValues::ALERT_SUCCESS,
            $l["alert"]["collection"]["maintenance"]["success"]["unprioritize"]);
    }

    /**
     * Sets all translations of the currently signed-in account to unknown.
     */
    private function executeSetUnknown() {
        global $l;

        $this->rm->getLinkRepository()->setUnknown($_SESSION["account"]["id"]);

        AlertHandler::addAlert(ConfigValues::ALERT_SUCCESS,
            $l["alert"]["collection"]["maintenance"]["success"]["setUnknown"]);
    }

    /**
     * Removes all languages, links and words associated with the currently
     * signed-in account.
     */
    private function executeWipe() {
        global $l;

        // Removes all transitively.
        $this->rm->getLanguageRepository()->wipe($_SESSION["account"]["id"]);

        AlertHandler::addAlert(ConfigValues::ALERT_SUCCESS,
            $l["alert"]["collection"]["maintenance"]["success"]["wipe"]);
    }
}
