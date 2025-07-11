<?php

use io\schupke\sanasto\core\core\controller\AbstractCoreController;
use io\schupke\sanasto\core\exception\EmailConstructionException;
use io\schupke\sanasto\core\entity\Feedback;

/**
 * General operation handling application-wide controller.
 */
class CoreController extends AbstractCoreController {
    function __construct(CoreControllerManager $ccm) {
        parent::__construct($ccm);
    }

    /**
     * Changes the global setting of the amount of records
     * displayed per page based on submitted value.
     * @param int $paging amount of records to be displayed per page.
     */
    public function setPaging($paging) {
        if (!InputValidator::validateNumeric($paging)) {
            return;
        }

        $_SESSION["recordsPerPage"] = $paging;
    }

    /**
     * Retrieves all languages available
     * to the currently logged-in account.
     * @return array array of Language entities, never null.
     */
    public function getLanguageOptions() {
        return $this->rm->getLanguageRepository()->findLanguageOptions($_SESSION["account"]["id"]);
    }

    /**
     * Retrieves information about available account types.
     * @return array an array of all AccountType entries. Never null.
     */
    public function getAccountTypes() {
        return $this->rm->getAccountTypeRepository()->findAll(null, null, null);
    }

    /**
     * Retrieves information about available countries.
     * @return array an array of all Country entries. Never null.
     */
    public function getCountryOptions() {
        return $this->rm->getCountryRepository()->findAll(null, null, null);
    }

    /**
     * Sends a contact message to the specified (in config) recipient.
     * Also sends a copy to the sender.
     * @param string $email sender's email address.
     * @param string $subject message subject.
     * @param string $message email body.
     */
    public function processContactMessage($email, $subject, $message) {
        global $l;

        $passed = true;

        if (!$this->sm->getUtilityService()->validateCaptcha()) {
            $passed = false;
        }

        $email = InputValidator::pacify($email);

        if (InputValidator::isEmpty($email)) {
            AlertHandler::addAlert(ConfigValues::ALERT_DANGER,
                $l["alert"]["global"]["danger"]["missingEmail"]);
            $passed = false;
        } else {
            // Email was provided, but is not valid.
            if (!InputValidator::validateEmail($email)) {
                AlertHandler::addAlert(ConfigValues::ALERT_DANGER,
                    $l["alert"]["index"]["contact"]["danger"]["badEmail"]);
                $passed = false;
            }
        }

        if (InputValidator::isEmpty($subject)) {
            AlertHandler::addAlert(ConfigValues::ALERT_DANGER,
                $l["alert"]["index"]["contact"]["danger"]["emptySubject"]);
            $passed = false;
        }

        if (InputValidator::isEmpty($message)) {
            AlertHandler::addAlert(ConfigValues::ALERT_DANGER,
                $l["alert"]["index"]["contact"]["danger"]["emptyMessage"]);
            $passed = false;
        }

        if ($passed) {
            $subject = InputValidator::pacify($subject);
            $message = InputValidator::pacify($message);

            $emailStatus = false;

            try {
                $emailStatus = EmailDispatcher::send(
                    ConfigValues::CONTACT_EMAIL,
                    $subject,
                    $message,
                    $_SESSION["account"]["email"]);
            } catch (EmailConstructionException $e) {
                error_log($e->getMessage(), 0);
            }

            if ($emailStatus) {
                // Also send a notification to the sender.
                $messageForSender = ($l["email"]["index"]["contact"]["senderNote"]
                    . "<br /><br />"
                    . $message);

                try {
                    EmailDispatcher::send(
                        $email,
                        $l["email"]["index"]["contact"]["subject"],
                        $messageForSender);
                } catch (EmailConstructionException $e) {
                    error_log($e->getMessage(), 0);
                }

                AlertHandler::addAlert(ConfigValues::ALERT_SUCCESS,
                    $l["alert"]["index"]["contact"]["success"]["sent"]);
            } else {
                AlertHandler::addAlert(ConfigValues::ALERT_DANGER,
                    $l["alert"]["index"]["contact"]["danger"]["failed"]);
            }

            header("Location: " . $_SERVER["SCRIPT_NAME"]);
            die();
        } else {
            AlertHandler::addAlert(ConfigValues::ALERT_INFO,
                $l["alert"]["index"]["contact"]["info"]["reOpen"]);
        }
    }

    /**
     * Processes the creation of a new feedback entry.
     * @param string $subject message subject.
     * @param string $message feedback message.
     * @param string $origin path to the page where the user was
     * before requesting the feedback form.
     */
    public function processFeedback($subject, $message, $origin) {
        global $l;

        $passed = true;

        if (!$this->sm->getUtilityService()->validateCaptcha()) {
            $passed = false;
        }

        if (InputValidator::isEmpty($subject)) {
            AlertHandler::addAlert(ConfigValues::ALERT_DANGER,
                $l["alert"]["index"]["feedback"]["danger"]["emptySubject"]);
            $passed = false;
        }

        if (InputValidator::isEmpty($message)) {
            AlertHandler::addAlert(ConfigValues::ALERT_DANGER,
                $l["alert"]["index"]["feedback"]["danger"]["emptyMessage"]);
            $passed = false;
        }

        if ($passed) {
            $subject = InputValidator::pacify($subject);
            $message = InputValidator::pacify($message);
            $message = str_replace(PHP_EOL, '<br />', $message);
            $origin = InputValidator::pacify($origin);

            $accountId = $_SESSION["account"]["id"];
            $accountEmail = $_SESSION["account"]["email"];

            // New Feedback entry into db.
            $feedback = new Feedback();
            $feedback->setSubject($subject);
            $feedback->setMessage($message);
            $feedback->setOrigin($origin);
            $feedback->getAccount()->setId($accountId);

            $this->rm->getFeedbackRepository()->save($feedback);

            try {
                $emailBody = $l["email"]["index"]["feedback"]["message"]
                    . "<br /><br />"
                    . $message;

                EmailDispatcher::send(
                    $accountEmail,
                    $l["email"]["index"]["feedback"]["subject"],
                    $emailBody);
            } catch (EmailConstructionException $e) {
                error_log($e->getMessage(), 0);
            }

            AlertHandler::addAlert(ConfigValues::ALERT_SUCCESS,
                $l["alert"]["index"]["feedback"]["success"]["submitted"]);

            header("Location: " . $_SERVER["SCRIPT_NAME"]);
            die();
        } else {
            AlertHandler::addAlert(ConfigValues::ALERT_INFO,
                $l["alert"]["index"]["feedback"]["info"]["reOpen"]);
        }
    }
}
