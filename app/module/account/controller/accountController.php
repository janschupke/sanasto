<?php

use io\schupke\sanasto\core\core\controller\AbstractController;
use io\schupke\sanasto\core\exception\EmailConstructionException;

/**
 * Standard controller for account module.
 */
class AccountController extends AbstractController {
    function __construct(ControllerManager $cm) {
        parent::__construct($cm);
    }

    /**
     * Retrieves information about currently logged in account,
     * based on its id.
     * @param int $_SESSION["accountId"] id of the currently logged in account
     * @return Account account information.
     */
    public function getCurrentAccountInformation() {
        return $this->rm->getAccountRepository()->findById($_SESSION["account"]["id"]);
    }

    /**
     * Updates the information about currently logged-in account.
     * @param string $fullName full name of the account owner.
     * @param int $yearOfBirth year of birth of the account owner.
     * @param int $countryId an id of the selected country as it is in the database.
     */
    public function updateAccount($fullName, $yearOfBirth, $countryId) {
        global $l;

        $passed = true;

        $account = $this->rm->getAccountRepository()->findById($_SESSION["account"]["id"]);

        if ($fullName != $account->getFullName()) {
            $fullName = InputValidator::pacify($fullName);
        }

        // Year of birth can be left empty, but if filled in,
        // it must contain a numeric value.
        if ($yearOfBirth != $account->getYearOfBirth() and !empty($yearOfBirth)) {
            if (!InputValidator::validateNumeric($yearOfBirth)) {
                AlertHandler::addAlert(ConfigValues::ALERT_DANGER,
                    $l["alert"]["account"]["settings"]["danger"]["invalidYearOfBirth"]);
                $passed = false;
            }

            if (!Utility::isPossibleYearOfBirth($yearOfBirth)) {
                AlertHandler::addAlert(ConfigValues::ALERT_DANGER,
                    $l["alert"]["account"]["settings"]["danger"]["impossibleYearOfBirth"]);
                $passed = false;
            }
        }

        // Country id will always be filled in. Empty country name has an id of 0.
        if ($countryId != $account->getCountry()->getId()) {
            if (!InputValidator::validateNumeric($countryId)) {
                AlertHandler::addAlert(ConfigValues::ALERT_DANGER,
                    $l["alert"]["account"]["settings"]["danger"]["invalidCountry"]);
                $passed = false;
            }
        }

        if ($passed) {
            // Integer datatype, cannot be empty string.
            if (InputValidator::isEmpty($yearOfBirth)) {
                $yearOfBirth = null;
            }

            $account->setFullName($fullName);
            $account->setYearOfBirth($yearOfBirth);
            $account->getCountry()->setId($countryId);

            $this->rm->getAccountRepository()->merge($account);

            // Updates session for presentation purposes.
            $_SESSION["account"]["fullName"] = $fullName;

            AlertHandler::addAlert(ConfigValues::ALERT_SUCCESS,
                $l["alert"]["account"]["settings"]["success"]["updated"]);

            header("Location: " . Config::getInstance()->getModuleRoot()
                . ConfigValues::MOD_ACCOUNT . "/settings#settings");
            die();
        }
    }

    /**
     * Updates the password for the currently logged-in user.
     * @param string $old old (current) password.
     * @param string $new new password string.
     * @param string $new2 new password string again.
     */
    public function updatePassword($old, $new, $new2) {
        global $l;

        $account = $this->rm->getAccountRepository()->findById($_SESSION["account"]["id"]);

        if (InputValidator::isEmpty($new) or InputValidator::isEmpty($new2)) {
            AlertHandler::addAlert(ConfigValues::ALERT_DANGER,
                $l["alert"]["account"]["security"]["danger"]["empty"]);
            return;
        }

        if (!InputValidator::isStrongPassword($new)) {
            AlertHandler::addAlert(ConfigValues::ALERT_DANGER,
                $l["alert"]["account"]["security"]["danger"]["weak"]);
            return;
        }

        if ($new != $new2) {
            AlertHandler::addAlert(ConfigValues::ALERT_DANGER,
                $l["alert"]["account"]["security"]["danger"]["missmatch"]);
            return;
        }

        $providedHash = Security::makeHash($old, $account->getSalt());

        if ($providedHash != $account->getPassword()) {
            AlertHandler::addAlert(ConfigValues::ALERT_DANGER,
                $l["alert"]["account"]["security"]["danger"]["invalidOld"]);
            return;
        }

        // All good, proceeding to the password update.
        $oldSalt = $account->getSalt();
        $oldPassword = $account->getPassword();
        $newSalt = Utility::generateRandomString();
        $newPassword = Security::makeHash($new, $newSalt);

        // New password is supposed to be different from the old one.
        if (Security::makeHash($new, $oldSalt) == $oldPassword) {
            AlertHandler::addAlert(ConfigValues::ALERT_DANGER,
                $l["alert"]["account"]["security"]["danger"]["sameAsOld"]);
            return;
        }

        $account->setSalt($newSalt);
        $account->setPassword($newPassword);
        $account->setLastPasswordModificationDate(Utility::getNow());

        $this->rm->getAccountRepository()->merge($account);

        try {
            EmailDispatcher::send(
                $account->getEmail(),
                $l["email"]["account"]["security"]["passwordChanged"]["subject"],
                $l["email"]["account"]["security"]["passwordChanged"]["message"]);
        } catch (EmailConstructionException $e) {
            error_log($e->getMessage(), 0);
        }

        AlertHandler::addAlert(ConfigValues::ALERT_SUCCESS,
            $l["alert"]["account"]["security"]["success"]["updated"]);

        header("Location: " . Config::getInstance()->getModuleRoot()
            . ConfigValues::MOD_ACCOUNT . "/settings#security");
        die();
    }

    /**
     * Verifies that the provided string matches the verification
     * token in the database.
     * @param string $token the token provided by the user.
     */
    public function verifyAccount($token) {
        global $l;

        if ($_SESSION["account"]["verified"]) {
            AlertHandler::addAlert(ConfigValues::ALERT_INFO,
                $l["alert"]["account"]["verify"]["info"]["alreadyVerified"]);

            header("Location: " . Config::getInstance()->getWwwPath()
                . ConfigValues::MOD_ACCOUNT . "/overview");
            die();
        }

        $account = $this->rm->getAccountRepository()->findById($_SESSION["account"]["id"]);

        if (!InputValidator::isEmpty($token) and $token == $account->getVerificationToken()) {
            $account->setVerified(true);
            $account->setVerificationToken(null);
            $this->rm->getAccountRepository()->merge($account);

            $_SESSION["account"]["verified"] = true;

            AlertHandler::addAlert(ConfigValues::ALERT_SUCCESS,
                $l["alert"]["account"]["verify"]["success"]["verified"]);

            header("Location: " . Config::getInstance()->getWwwPath()
                . ConfigValues::MOD_ACCOUNT . "/overview");
            die();
        } else {
            AlertHandler::addAlert(ConfigValues::ALERT_DANGER,
                $l["alert"]["account"]["verify"]["danger"]["tokenMissmatch"]);

            header("Location: " . Config::getInstance()->getWwwPath()
                . ConfigValues::MOD_ACCOUNT . "/settings");
            die();
        }
    }

    /**
     * Terminates the currently logged-in account by removing it
     * from the database and killing the current session.
     * @param string $email email of the currently logged-in account for confirmation.
     * @param string $password password of the currently logged-in account for confirmation.
     */
    public function terminateAccount($email, $password) {
        global $l;

        $account = $this->rm->getAccountRepository()->findById($_SESSION["account"]["id"]);
        $providedHash = Security::makeHash($password, $account->getSalt());

        if ($email != $account->getEmail() or $providedHash != $account->getPassword()) {
            AlertHandler::addAlert(ConfigValues::ALERT_DANGER,
                $l["alert"]["account"]["terminate"]["danger"]["invalidData"]);
            return;
        }

        // Cannot terminate admin account type through account settings.
        if ($account->getAccountType()->getId() == Security::ADMIN) {
            AlertHandler::addAlert(ConfigValues::ALERT_DANGER,
                $l["alert"]["account"]["terminate"]["danger"]["adminRemoval"]);
            return;
        }

        $this->rm->getAccountRepository()->remove($account);

        $emailStatus = false;

        try {
            EmailDispatcher::send(
                $email,
                $l["email"]["account"]["terminate"]["terminated"]["subject"],
                $l["email"]["account"]["terminate"]["terminated"]["message"]);
        } catch (EmailConstructionException $e) {
            error_log($e->getMessage(), 0);
        }

        AlertHandler::addAlert(ConfigValues::ALERT_SUCCESS,
            sprintf($l["alert"]["account"]["terminate"]["success"]["terminated"],
                $email));

        header("Location: " . Config::getInstance()->getModuleRoot()
            . ConfigValues::MOD_INDEX . "/sign-out");
        die();
    }

    /**
     * Returns the amount of languages associated with this account.
     * @return int amount of languages.
     */
    public function getLanguageCount() {
        $searchCriteria["accountId"] = $_SESSION["account"]["id"];
        return $this->rm->getLanguageRepository()->findCount($searchCriteria);
    }

    /**
     * @return int total amount of language entries
     * associated with the currently signed-in account.
     */
    public function getLanguages() {
        $searchCriteria["accountId"] = $_SESSION["account"]["id"];
        return $this->rm->getLanguageRepository()->findAll(null, null, $searchCriteria);
    }

    /**
     * @return int total amount of word entries
     * associated with the currently signed-in account.
     */
    public function getWordCount() {
        $searchCriteria["accountId"] = $_SESSION["account"]["id"];
        return $this->rm->getWordRepository()->findCount($searchCriteria);
    }

    /**
     * @return int total amount of translation entries
     * associated with the currently signed-in account.
     */
    public function getLinkCount() {
        $searchCriteria["accountId"] = $_SESSION["account"]["id"];
        return $this->rm->getLinkRepository()->findCount($searchCriteria);
    }
}
