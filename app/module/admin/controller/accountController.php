<?php

use io\schupke\sanasto\core\core\controller\AbstractController;
use io\schupke\sanasto\core\exception\EmailConstructionException;
use io\schupke\sanasto\core\entity\Account;

/**
 * Account handling controller for admin module.
 */
class AccountController extends AbstractController {
    function __construct(ControllerManager $cm) {
        parent::__construct($cm);
    }

    const ACCOUNT_ORDER_EMAIL = "email";
    const ACCOUNT_ORDER_DATE = "date";
    const ACCOUNT_ORDER_VERIFIED = "verified";
    const ACCOUNT_ORDER_ENABLED = "enabled";

    /**
     * Handles ordering requests.
     */
    public function handleOrdering() {
        global $l;

        if (empty($_GET["order"])) {
            return;
        }

        $orderRequest = $_GET["order"];
        $key = "";

        if ($orderRequest == AccountController::ACCOUNT_ORDER_EMAIL) {
            $key = "email";
            if (Utility::getOrdering()[0] == $key) {
                Utility::swapOrdering();
            } else {
                Utility::setOrdering($key);
            }
        } elseif ($orderRequest == AccountController::ACCOUNT_ORDER_DATE) {
            $key = "registration_date";
            if (Utility::getOrdering()[0] == $key) {
                Utility::swapOrdering();
            } else {
                Utility::setOrdering($key, "DESC");
            }
        } elseif ($orderRequest == AccountController::ACCOUNT_ORDER_VERIFIED) {
            $key = "verified";
            if (Utility::getOrdering()[0] == $key) {
                Utility::swapOrdering();
            } else {
                Utility::setOrdering($key, "DESC");
            }
        } elseif ($orderRequest == AccountController::ACCOUNT_ORDER_ENABLED) {
            $key = "enabled";
            if (Utility::getOrdering()[0] == $key) {
                Utility::swapOrdering();
            } else {
                Utility::setOrdering($key, "DESC");
            }
        } else {
            AlertHandler::addAlert(ConfigValues::ALERT_DANGER,
                $l["alert"]["global"]["danger"]["badOrdering"]);
        }

        header("Location: " . Config::getInstance()->getModuleRoot()
            . ConfigValues::MOD_ADMIN . "/accounts");
        die();
    }

    /**
     * Retrieves all accounts that match the provided criteria.
     * @param int $page indicates which page should be selected if the amount
     * of records is higher that the page limit.
     * @param int $recordLimit indicates how many records should be retrieved.
     * @param array $searchCriteria stores criteria by which to filter the selection.
     * @return array an array of retrieved Account instances.
     * Empty array if nothing was found.
     */
    public function getAllAccounts($page = 1,
            $recordLimit = ConfigValues::DEFAULT_PAGING_AMOUNT,
            $searchCriteria = null) {
        return $this->rm->getAccountRepository()->findAll($page, $recordLimit, $searchCriteria);
    }

    /**
     * Retrieves the amount of accounts that match given search criteria,
     * or all accounts, if no criteria are provided.
     * @param array $searchCriteria stores criteria by which to filter the selection.
     * @return int the amount of records that match the criteria.
     */
    public function getAccountCount($searchCriteria = null) {
        return $this->rm->getAccountRepository()->findCount($searchCriteria);
    }

    /**
     * Retrieves information about a specific account.
     * @param int $id the account id based on which the information should be retrieved.
     * @return Account an Account instance that matches the provided id,
     * or null, if nothing was found.
     */
    public function getAccountInformation($id) {
        global $l;

        $passed = true;

        if (!InputValidator::validateNumeric($id)) {
            AlertHandler::addAlert(ConfigValues::ALERT_DANGER,
                $l["alert"]["global"]["danger"]["badId"]);
            $passed = false;
        }

        $account = $this->rm->getAccountRepository()->findById($id);

        if ($account == null) {
            AlertHandler::addAlert(ConfigValues::ALERT_DANGER,
                $l["alert"]["admin"]["accounts"]["modify"]["danger"]["doesNotExist"]);
            $passed = false;
        }

        if (!$passed) {
            header("Location: " . Config::getInstance()->getModuleRoot()
                . ConfigValues::MOD_ADMIN . "/accounts");
            die();
        }

        return $account;
    }

    /**
     * Sets the search criteria for account listing.
     * @param string $email email search criteria.
     * @param int $typeId type id search criteria.
     */
    public function filterAccounts($email, $typeId) {
        global $l;

        $passed = true;

        // ID has to always be numeric, not checking for valid type, since it can be 0.
        if (!InputValidator::validateNumeric($typeId)) {
            $passed = false;
        }

        // User is informed in case of any error.
        if (!$passed) {
            AlertHandler::addAlert(ConfigValues::ALERT_DANGER,
                $l["alert"]["global"]["danger"]["searchCriteria"]["invalid"]);
            return;
        }

        // Sanitizing.
        $email = InputValidator::pacify($email);

        // Criteria setup.
        $searchCriteria["email"] = $email;
        $searchCriteria["accountType"] = $typeId;

        FormUtils::setSearchCriteria($searchCriteria);

        header("Location: " . Config::getInstance()->getModuleRoot()
            . ConfigValues::MOD_ADMIN . "/accounts");
        die();
    }

    /**
     * Administratively creates a new account and email the new owner.
     * @param string $email email address/username of the new account.
     * @param string $password1 new password string for the account.
     * @param string $password2 confirmation of the new password.
     * @param bool $randomPassword flag that indicates whether to disregard password
     * parameters and rather generate random password.
     * @param int $typeId type id for the new account.
     * @param bool $enabled flag that indicates whether the account will be enabled.
     * @param bool $verified flag that indicates whether the account will be marked as verified.
     */
    public function createAccount($email, $password1, $password2,
            $randomPassword, $typeId, $enabled, $verified) {
        global $l;

        $email = InputValidator::pacify($email);

        if (InputValidator::isEmpty($email)) {
            AlertHandler::addAlert(ConfigValues::ALERT_DANGER,
                $l["alert"]["global"]["danger"]["missingEmail"]);
            return;
        }

        if (!InputValidator::validateEmail($email)) {
            AlertHandler::addAlert(ConfigValues::ALERT_DANGER,
                sprintf($l["alert"]["admin"]["accounts"]["create"]["danger"]["email"],
                    $email));
            return;
        }

        if (!InputValidator::isValidAccountTypeId($typeId)) {
            AlertHandler::addAlert(ConfigValues::ALERT_DANGER,
                $l["alert"]["admin"]["accounts"]["create"]["danger"]["type"]);
        }

        $randomPassword = Utility::makeBoolean($randomPassword);
        $password = "";

        if ($randomPassword) {
            $password = Utility::generateRandomString(8);
        } else {
            // Password input validation.
            if (!InputValidator::isStrongPassword($password1)) {
                // Translation string taken from account security module.
                AlertHandler::addAlert(ConfigValues::ALERT_DANGER,
                    $l["alert"]["account"]["security"]["danger"]["weak"]);
                    return;
            }

            if ($password1 != $password2) {
                AlertHandler::addAlert(ConfigValues::ALERT_DANGER,
                    $l["alert"]["global"]["danger"]["passwordMissmatch"]);
                return;
            }

            $password = $password1;
        }

        $enabled = Utility::makeBoolean($enabled);
        $verified = Utility::makeBoolean($verified);

        $salt = Utility::generateRandomString();
        $hash = Security::makeHash($password, $salt);

        $email = Utility::normalizeWord($email);

        $account = new Account();
        $account->setEmail($email);
        $account->setPassword($hash);
        $account->setSalt($salt);
        $account->getAccountType()->setId($typeId);
        $account->setEnabled($enabled);
        $account->setVerified($verified);

        $verificationToken = "";

        if (!$verified) {
            $verificationToken = $this->sm->getRegistrationService()->generateVerificationToken();
            $account->setVerificationToken($verificationToken);
        }

        $this->rm->getAccountRepository()->save($account);

        $emailBody = sprintf($l["email"]["admin"]["accounts"]["created"]["message"],
            $email,
            $password);

        if (!$verified) {
            $emailBody .= "<br />";
            $emailBody .= sprintf($l["email"]["admin"]["accounts"]["created"]["verification"],
                $verificationToken);
        }

        try {
            EmailDispatcher::send(
                $email,
                $l["email"]["admin"]["accounts"]["created"]["subject"],
                $emailBody);
        } catch (EmailConstructionException $e) {
            error_log($e->getMessage(), 0);
        }

        AlertHandler::addAlert(ConfigValues::ALERT_SUCCESS,
            sprintf($l["alert"]["admin"]["accounts"]["create"]["success"]["created"],
                $email));

        header("Location: " . Config::getInstance()->getModuleRoot()
            . ConfigValues::MOD_ADMIN . "/accounts");
        die();
    }

    /**
     * Administratively modifies user account.
     * @param int $id the id of the account to be modified.
     * @param bool $verified new verified status of the account.
     * @param bool $enabled new enabled status of the account.
     * @param int $typeId new type id of the account.
     */
    public function modifyAccount($id, $verified, $enabled, $typeId) {
        global $l;

        if (!InputValidator::validateNumeric($id)) {
            AlertHandler::addAlert(ConfigValues::ALERT_DANGER,
                $l["alert"]["global"]["danger"]["badId"]);
            return;
        }

        $account = $this->rm->getAccountRepository()->findById($id);

        if ($account == null) {
            AlertHandler::addAlert(ConfigValues::ALERT_DANGER,
                $l["alert"]["admin"]["accounts"]["modify"]["danger"]["doesNotExist"]);
            return;
        }

        if (!InputValidator::isValidAccountTypeId($typeId)) {
            AlertHandler::addAlert(ConfigValues::ALERT_DANGER,
                $l["alert"]["admin"]["accounts"]["modify"]["danger"]["invalidTypeId"]);
            return;
        }

        // Unchecked inputs have null values, db expects booleans.
        $enabled = Utility::makeBoolean($enabled);
        $verified = Utility::makeBoolean($verified);

        $originallyEnabled = $account->getEnabled();

        $account->setVerified($verified);
        $account->setEnabled($enabled);
        $account->getAccountType()->setId($typeId);

        $this->rm->getAccountRepository()->merge($account);

        try {
            // If the account enabled state has been modified, specific message is sent.
            if ($originallyEnabled != $enabled) {
                // Account has been disabled.
                if (!$enabled) {
                    EmailDispatcher::send(
                        $account->getEmail(),
                        $l["email"]["admin"]["accounts"]["disabled"]["subject"],
                        $l["email"]["admin"]["accounts"]["disabled"]["message"]);
                // Account has been re-enabled.
                } else {
                    EmailDispatcher::send(
                        $account->getEmail(),
                        $l["email"]["admin"]["accounts"]["reEnabled"]["subject"],
                        $l["email"]["admin"]["accounts"]["reEnabled"]["message"]);
                }
            // Otherwise send a generic modification notification.
            } else {
                EmailDispatcher::send(
                    $account->getEmail(),
                    $l["email"]["admin"]["accounts"]["changed"]["subject"],
                    $l["email"]["admin"]["accounts"]["changed"]["message"]);
            }
        } catch (EmailConstructionException $e) {
            error_log($e->getMessage(), 0);
        }

        AlertHandler::addAlert(ConfigValues::ALERT_SUCCESS,
            sprintf($l["alert"]["admin"]["accounts"]["modify"]["success"]["updated"],
                $account->getEmail()));

        header("Location: " . Config::getInstance()->getModuleRoot()
            . ConfigValues::MOD_ADMIN . "/accounts");
        die();
    }

    /**
     * Administratively removes the account with the provided id.
     * @param int $id the id of the account to be removed.
     * @param string $value confirmation value provided by the user.
     */
    public function removeAccount($id, $value) {
        global $l;

        if (!InputValidator::validateNumeric($id)) {
            AlertHandler::addAlert(ConfigValues::ALERT_DANGER,
                $l["alert"]["global"]["danger"]["badId"]);
            return;
        }

        // Admin cannot remove himself.
        if ($id == $_SESSION["account"]["id"]) {
            AlertHandler::addAlert(ConfigValues::ALERT_DANGER,
                $l["alert"]["admin"]["accounts"]["remove"]["danger"]["sameId"]);
            return;
        }

        // Default accounts cannot be removed.
        if (InputValidator::isFactoryAccountId($id)) {
            AlertHandler::addAlert(ConfigValues::ALERT_DANGER,
                $l["alert"]["admin"]["accounts"]["remove"]["danger"]["defaultId"]);
            return;
        }

        $account = $this->rm->getAccountRepository()->findById($id);

        if ($account == null) {
            AlertHandler::addAlert(ConfigValues::ALERT_DANGER,
                $l["alert"]["admin"]["accounts"]["remove"]["danger"]["doesNotExist"]);
            return;
        }

        // Verification value is expected to match the removed account email address.
        if ($value != $account->getEmail()) {
            AlertHandler::addAlert(ConfigValues::ALERT_DANGER,
                sprintf($l["alert"]["admin"]["accounts"]["remove"]["danger"]["incorrectConfirm"],
                    InputValidator::pacify($value),
                    $account->getEmail()));
            return;
        }

        $this->rm->getAccountRepository()->remove($account);

        try {
            EmailDispatcher::send(
                $account->getEmail(),
                $l["email"]["admin"]["accounts"]["removed"]["subject"],
                $l["email"]["admin"]["accounts"]["removed"]["message"]);
        } catch (EmailConstructionException $e) {
            error_log($e->getMessage(), 0);
        }

        AlertHandler::addAlert(ConfigValues::ALERT_SUCCESS,
            sprintf($l["alert"]["admin"]["accounts"]["remove"]["success"]["removed"],
                $account->getEmail()));

        header("Location: " . Config::getInstance()->getModuleRoot()
            . ConfigValues::MOD_ADMIN . "/accounts");
        die();
    }

    /**
     * Retrieves the total amount of extended accounts.
     * @return int total amount of extended accounts.
     */
    public function getTotalExtendedAccounts() {
        $searchCriteria["accountType"] = Security::EXTENDED;
        return $this->rm->getAccountRepository()->findCount($searchCriteria);
    }

    /**
     * Retrieves the total amount of immortal accounts.
     * @return int total amount of immortal accounts.
     */
    public function getTotalImmortalAccounts() {
        $searchCriteria["accountType"] = Security::IMMORTAL;
        return $this->rm->getAccountRepository()->findCount($searchCriteria);
    }

    /**
     * Retrieves the total amount of admin accounts.
     * @return int total amount of admin accounts.
     */
    public function getTotalAdminAccounts() {
        $searchCriteria["accountType"] = Security::ADMIN;
        return $this->rm->getAccountRepository()->findCount($searchCriteria);
    }

    /**
     * Retrieves the newest account entry.
     * @return Account instance of the newest Account.
     */
    public function getNewestAccount() {
        return $this->rm->getAccountRepository()->findNewest();
    }

    /**
     * Returns the amount of languages associated with this account.
     * @param int $accountId id of account in question.
     * @return int amount of languages.
     */
    public function getLanguageCount($accountId) {
        $searchCriteria["accountId"] = $accountId;
        return $this->rm->getLanguageRepository()->findCount($searchCriteria);
    }

    /**
     * @return int total amount of word entries
     * @param int $accountId id of account in question.
     * associated with the currently signed-in account.
     */
    public function getWordCount($accountId) {
        $searchCriteria["accountId"] = $accountId;
        return $this->rm->getWordRepository()->findCount($searchCriteria);
    }

    /**
     * @return int total amount of translation entries
     * @param int $accountId id of account in question.
     * associated with the currently signed-in account.
     */
    public function getLinkCount($accountId) {
        $searchCriteria["accountId"] = $accountId;
        return $this->rm->getLinkRepository()->findCount($searchCriteria);
    }
}
