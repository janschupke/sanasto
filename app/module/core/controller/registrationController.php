<?php

use io\schupke\sanasto\core\core\controller\AbstractCoreController;
use io\schupke\sanasto\core\exception\EmailConstructionException;
use io\schupke\sanasto\core\exception\DuplicateEntryException;
use io\schupke\sanasto\core\entity\Account;

/**
 * Registration handling core controller.
 */
class RegistrationController extends AbstractCoreController {
    function __construct(CoreControllerManager $ccm) {
        parent::__construct($ccm);
    }

    /**
     * Registers a new user account and signs it in.
     * @param string $email the email/username of the new account.
     * @param string $password1 the password string for the new account.
     * @param string $password2 the password confirmation string.
     * @param bool $conditions the flag whether the user accepts the terms of service.
     */
    public function registerAccount($email, $password1, $password2, $conditions) {
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
                    $l["alert"]["global"]["danger"]["invalidEmail"]);
                $passed = false;
            }
        }

        if (!InputValidator::isStrongPassword($password1)) {
            // Translation string taken from account security.
            AlertHandler::addAlert(ConfigValues::ALERT_DANGER,
                $l["alert"]["account"]["security"]["danger"]["weak"]);
            $passed = false;
        } else {
            // Password is strong enough, but the confirmation string is incorrect.
            if ($password1 != $password2) {
                AlertHandler::addAlert(ConfigValues::ALERT_DANGER,
                    $l["alert"]["global"]["danger"]["passwordMissmatch"]);
                $passed = false;
            }
        }

        if (!$conditions) {
            AlertHandler::addAlert(ConfigValues::ALERT_DANGER,
                $l["alert"]["index"]["registration"]["danger"]["conditions"]);
            $passed = false;
        }

        if ($passed) {
            // Values for the database.
            $salt = Utility::generateRandomString();
            $passwordHash = Security::makeHash($password1, $salt);
            $verificationToken = $this->sm->getRegistrationService()->generateVerificationToken();

            // Newly registered account instance.
            $account = new Account();
            $account->setEmail($email);
            $account->setPassword($passwordHash);
            $account->setSalt($salt);
            $account->setVerificationToken($verificationToken);
            $account->getAccountType()->setId(Security::USER);

            // Saves the accounts, checks for duplicate.
            try {
                $this->rm->getAccountRepository()->save($account);
            } catch (DuplicateEntryException $e) {
                AlertHandler::addAlert(ConfigValues::ALERT_DANGER,
                    $l["alert"]["index"]["registration"]["danger"]["accountExists"]);
                return;
            }

            // Confirmation email.
            $emailBody = sprintf(
                $l["email"]["index"]["registration"]["registeredMessage"],
                $email,
                $verificationToken);

            $emailStatus = false;

            try {
                $emailStatus = EmailDispatcher::send(
                    $email,
                    $l["email"]["index"]["registration"]["registeredSubject"],
                    $emailBody);
            } catch (EmailConstructionException $e) {
                error_log($e->getMessage(), 0);
            }

            if ($emailStatus) {
                AlertHandler::addAlert(ConfigValues::ALERT_SUCCESS,
                    sprintf($l["alert"]["index"]["registration"]["success"]["confirmationSent"],
                        $email));
            } else {
                AlertHandler::addAlert(ConfigValues::ALERT_DANGER,
                    $l["alert"]["index"]["registration"]["danger"]["confirmationNotSent"]);
            }

            // This also relocates to the account overview.
            $this->cm->getSignInController()->processSignIn($email, $password1);
        }
    }

    /**
     * Sends a new email with account verification token.
     */
    public function resendVerificationToken() {
        global $l;

        $account = $this->rm->getAccountRepository()->findById($_SESSION["account"]["id"]);

        // Prevents repeated verifications.
        if ($account->getVerified()) {
            AlertHandler::addAlert(ConfigValues::ALERT_INFO,
                $l["alert"]["account"]["verify"]["info"]["alreadyVerified"]);

            header("Location: " . Config::getInstance()->getWwwPath()
                . ConfigValues::MOD_ACCOUNT . "/overview");
            die();
        }

        $verificationToken = $this->sm->getRegistrationService()->generateVerificationToken();
        $accountEmail = $account->getEmail();

        // Saves the token into the database.
        $account->setVerificationToken($verificationToken);
        $this->rm->getAccountRepository()->merge($account);

        // Sends the token to the user via email.
        $emailStatus = false;

        try {
            $message = sprintf($l["email"]["account"]["verify"]["resend"]["message"],
                $verificationToken);

            $emailStatus = EmailDispatcher::send(
                $accountEmail,
                $l["email"]["account"]["verify"]["resend"]["subject"],
                $message);
        } catch (EmailConstructionException $e) {
            error_log($e->getMessage(), 0);
        }

        if ($emailStatus) {
            AlertHandler::addAlert(ConfigValues::ALERT_SUCCESS,
                sprintf($l["alert"]["account"]["verify"]["success"]["sent"],
                    $accountEmail));
        } else {
            AlertHandler::addAlert(ConfigValues::ALERT_DANGER,
                $l["alert"]["account"]["verify"]["danger"]["notSent"]);
        }

        header("Location: " . Config::getInstance()->getWwwPath()
            . ConfigValues::MOD_ACCOUNT . "/settings");
        die();
    }
}
