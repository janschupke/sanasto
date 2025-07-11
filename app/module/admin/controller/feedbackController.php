<?php

use io\schupke\sanasto\core\core\controller\AbstractController;

/**
 * Feedback handling controller for admin module.
 */
class FeedbackController extends AbstractController {
    function __construct(ControllerManager $cm) {
        parent::__construct($cm);
    }

    /**
     * Retrieves all feedback entries that match the provided criteria.
     * @param int $page indicates which page should be selected if the amount
     * of records is higher that the page limit.
     * @param int $recordLimit indicates how many records should be retrieved.
     * @param array $searchCriteria stores criteria by which to filter the selection.
     * @return array an array of retrieved Feedback instances.
     * Empty array if nothing was found.
     */
    public function getAllFeedbacks($page = 1,
            $recordLimit = ConfigValues::DEFAULT_PAGING_AMOUNT,
            $searchCriteria = null) {
        return $this->rm->getFeedbackRepository()->findAll($page, $recordLimit, $searchCriteria);
    }

    /**
     * Retrieves the amount of feedback entries that match given search criteria,
     * or all entries, if no criteria are provided.
     * @param array $searchCriteria stores criteria by which to filter the selection.
     * @return int the amount of records that match the criteria.
     */
    public function getFeedbackCount($searchCriteria = null) {
        return $this->rm->getFeedbackRepository()->findCount($searchCriteria);
    }

    /**
     * Retrieves information about a specific feedback entry.
     * @param int $id the feedback entry id based on which the information should be retrieved.
     * @return Feedback an Feedback instance that matches the provided id,
     * or false, if nothing was found.
     */
    public function getFeedbackInformation($id) {
        global $l;

        if (InputValidator::validateNumeric($id)) {
            return $this->rm->getFeedbackRepository()->findById($id);
        }

        AlertHandler::addAlert(ConfigValues::ALERT_DANGER,
            $l["alert"]["global"]["danger"]["badId"]);

        header("Location: " . Config::getInstance()->getModuleRoot()
            . ConfigValues::MOD_ADMIN . "/feedback");
        die();
    }

    /**
     * Sets the search criteria for feedback listing.
     * @param string $email email search criteria.
     */
    public function filterFeedback($email) {
        global $l;

        $passed = true;

        // User is informed in case of any error.
        if (!$passed) {
            AlertHandler::addAlert(ConfigValues::ALERT_DANGER,
                $l["alert"]["global"]["danger"]["searchCriteria"]["invalid"]);
            return;
        }

        // Sanitizing.
        $email = InputValidator::pacify($email);

        // Criteria setup.
        $criteria["email"] = $email;

        FormUtils::setSearchCriteria($criteria);

        header("Location: " . Config::getInstance()->getModuleRoot()
            . ConfigValues::MOD_ADMIN . "/feedback");
        die();
    }

    /**
     * Removes a feedback entry with the provided id.
     * @param int $id the id of the entry to be removed.
     */
    public function removeFeedback($id) {
        global $l;

        if (!InputValidator::validateNumeric($id)) {
            AlertHandler::addAlert(ConfigValues::ALERT_DANGER,
                $l["alert"]["global"]["danger"]["badId"]);
            return;
        }

        $feedback = $this->rm->getFeedbackRepository()->findById($id);

        if ($feedback == null) {
            AlertHandler::addAlert(ConfigValues::ALERT_DANGER,
                $l["alert"]["admin"]["feedback"]["remove"]["danger"]["doesNotExist"]);
            return;
        }

        $this->rm->getFeedbackRepository()->remove($feedback);

        AlertHandler::addAlert(ConfigValues::ALERT_SUCCESS,
            sprintf($l["alert"]["admin"]["feedback"]["remove"]["success"]["removed"],
                $feedback->getAccount()->getEmail()));

        header("Location: " . Config::getInstance()->getModuleRoot()
            . ConfigValues::MOD_ADMIN . "/feedback");
        die();
    }
}
