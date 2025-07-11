<?php

use io\schupke\sanasto\core\core\controller\AbstractCoreController;
use io\schupke\sanasto\core\exception\EmailConstructionException;

/**
 * Sign-in/out handling core controller.
 */
class SignInController extends AbstractCoreController {
    function __construct(CoreControllerManager $ccm) {
        parent::__construct($ccm);
    }

    /**
     * Validates that the provided sign-in values are safe to be processed.
     * @param string $email an e-mail address provided by the visitor
     * during the sign-in process.
     * @param string $password a password string provided by the visitor
     * during the sign-in process.
     * @return bool true if valid, false otherwise.
     */
    private function validateSignInInput($email, $password) {
        if (InputValidator::isEmpty($password)) {
            return false;
        }

        if (!InputValidator::validateEmail($email)) {
            return false;
        }

        return true;
    }

    /**
     * Validates that the provided password matches the one associated
     * with the provided e-mail address.
     * @param array $account an account information containing
     * password hash and salt from the database.
     * @param string $password provided password to be hashed and matched.
     * @return bool true if valid, false otherwise.
     */
    private function validateCredentials($account, $password) {
        if ($account == null) {
            return false;
        }

        if (Security::makeHash($password, $account->getSalt()) != $account->getPassword()) {
            return false;
        }

        return true;
    }

    /**
     * Establishes the account session based on the information from the database.
     * @param Account $account account entity received from the database.
     */
    private function setUserSession($account) {
        global $l;

        $_SESSION["access"] = $account->getAccountType()->getId();

        $_SESSION["account"]["id"] = $account->getId();
        $_SESSION["account"]["email"] = $account->getEmail();
        $_SESSION["account"]["fullName"] = $account->getFullName();
        $_SESSION["account"]["verified"] = $account->getVerified();

        AlertHandler::addAlert(ConfigValues::ALERT_SUCCESS,
            sprintf($l["alert"]["signIn"]["success"]["signedIn"], $_SESSION["account"]["email"]));
    }

    /**
     * The main sign-in function, takes care of the entire sign-in process.
     * @param string $email an e-mail address the visitor used to sign-in.
     * @param string $password password string the visitor used to sign-in.
     * @param string $redirectUrl url of the page from which the sign-in was requested,
     * used to redirect back to it. Can be null.
     */
    public function processSignIn($email, $password, $redirectUrl) {
        global $l;

        $defaultRedirect = Config::getInstance()->getModuleRoot()
            . ConfigValues::MOD_ACCOUNT . "/overview";

        // Validates that captcha was submitted correctly.
        if (FormUtils::enforceCaptcha()) {
            if (!$this->sm->getUtilityService()->validateCaptcha()) {
                return;
            }
        }

        FormUtils::trackAttempts();

        $email = InputValidator::pacify($email);
        $redirectUrl = InputValidator::pacify($redirectUrl);

        // Prevents redirects to a different server.
        if (!Utility::startsWith($redirectUrl, "/")) {
            $redirectUrl = $defaultRedirect;
        }

        // Validates input values to make sure they are safe.
        if (!$this->validateSignInInput($email, $password)) {
            AlertHandler::addAlert(ConfigValues::ALERT_DANGER,
                $l["alert"]["signIn"]["danger"]["format"]);
            return;
        }

        // Attempts to find an account.
        $account = $this->rm->getAccountRepository()->findByEmail($email);

        // Verifies that the account exists and passwords match.
        if (!$this->validateCredentials($account, $password)) {
            AlertHandler::addAlert(ConfigValues::ALERT_DANGER,
                $l["alert"]["signIn"]["danger"]["credentials"]);
            return;
        }

        // Verifies that the account is enabled.
        if (!$account->getEnabled()) {
            AlertHandler::addAlert(ConfigValues::ALERT_DANGER,
                $l["alert"]["signIn"]["danger"]["disabled"]);
            return;
        }

        $this->setUserSession($account);
        $this->rm->getAccountRepository()->updateLastSignIn($_SESSION["account"]["id"]);
        FormUtils::clearAttemptTracker();

        // Relocates to the desired page after successful sign-in.
        if (!InputValidator::isEmpty($redirectUrl)) {
            header("Location: " . $redirectUrl);
            die();
        }

        // Default redirect target if the url was not provided.
        header("Location: " . $defaultRedirect);
        die();
    }

    /**
     * Unsets account session values, resets security levels
     * and sets a toast message about a successful sign-out
     * that will be displayed to the user.
     */
    public function signOut() {
        global $l;

        // Delete all session values but alert messages.
        foreach ($_SESSION as $key => $value) {
            if ($key == "alert") {
                continue;
            }
            unset($_SESSION[$key]);
        }

        $_SESSION["access"] = Security::FREE;

        AlertHandler::addAlert(ConfigValues::ALERT_SUCCESS,
            $l["alert"]["signOut"]["success"]["loggedOut"]);

        header("Location: " . Config::getInstance()->getWwwPath());
        die();
    }

    /**
     * Sends a password-recovery confirmation email with further instructions
     * to the provided email address.
     * @param string $email the email address of the user requesting a password recovery.
     */
    public function requestPasswordRecovery($email) {
        global $l;

        // Validates that captcha was submitted correctly.
        if (FormUtils::enforceCaptcha()) {
            if (!$this->sm->getUtilityService()->validateCaptcha()) {
                return;
            }
        }

        FormUtils::trackAttempts();

        $email = InputValidator::pacify($email);

        if (InputValidator::isEmpty($email)) {
            AlertHandler::addAlert(ConfigValues::ALERT_DANGER,
                $l["alert"]["global"]["danger"]["missingEmail"]);
            return;
        }

        if (!InputValidator::validateEmail($email)) {
            AlertHandler::addAlert(ConfigValues::ALERT_DANGER,
                $l["alert"]["global"]["danger"]["invalidEmail"]);
            return;
        }

        // Checks for account existence.
        $account = $this->rm->getAccountRepository()->findByEmail($email);

        if ($account == null or $account()->getId() != $_SESSION["account"]["id"]) {
            // A dummy success alert is displayed to obscure account-existence information.
            AlertHandler::addAlert(ConfigValues::ALERT_SUCCESS,
                sprintf($l["alert"]["index"]["passwordRecovery"]["success"]["confirmationSent"],
                    $email));
        } else {
            $recoveryToken = Utility::generateRandomString(60);
            $_SESSION["passwordRecovery"]["token"] = $recoveryToken;
            $_SESSION["passwordRecovery"]["email"] = $email;

            $recoveryTargetLink = (Config::getInstance()->getWwwPath()
                . "/?passwordRecoveryToken="
                . $recoveryToken
                . "#new-password");

            $emailBody = sprintf(
                $l["email"]["index"]["passwordRecovery"]["confirmMessage"],
                $recoveryTargetLink,
                $recoveryTargetLink);

            $emailStatus = false;

            try {
                $emailStatus = EmailDispatcher::send(
                    $email,
                    $l["email"]["index"]["passwordRecovery"]["confirmSubject"],
                    $emailBody);
            } catch (EmailConstructionException $e) {
                error_log($e->getMessage(), 0);
            }

            if ($emailStatus) {
                AlertHandler::addAlert(ConfigValues::ALERT_SUCCESS,
                    sprintf($l["alert"]["index"]["passwordRecovery"]["success"]["confirmationSent"],
                        $email));
            } else {
                AlertHandler::addAlert(ConfigValues::ALERT_DANGER,
                    sprintf($l["alert"]["index"]["passwordRecovery"]["danger"]["confirmationFailed"],
                        $email));
            }
        }

        header("Location: " . Config::getInstance()->getWwwPath());
        die();
    }

    /**
     * Validates provided password string and the security token. Executes the password change.
     * @param string $token the password recovery token used to validate the request.
     * @param string $password1 new password string provided by the user.
     * @param string $password3 new password confirmation string provided by the user.
     */
    public function processPasswordRecovery($token, $password1, $password2) {
        global $l;

        $passed = true;

        if (InputValidator::isEmpty($_SESSION["passwordRecovery"]["token"])
                or $token != $_SESSION["passwordRecovery"]["token"]) {
            AlertHandler::addAlert(ConfigValues::ALERT_DANGER,
                $l["alert"]["index"]["newPassword"]["danger"]["tokenMissmatch"]);

            header("Location: " . Config::getInstance()->getWwwPath());
            die();
        }

        if (!InputValidator::isStrongPassword($password1)) {
            // Translation message taken from the account security section.
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

        if ($passed) {
            // Unsets recovery session.
            $email = $_SESSION["passwordRecovery"]["email"];
            unset($_SESSION["passwordRecovery"]);

            $newSalt = Utility::generateRandomString();
            $newPassword = Security::makeHash($password1, $newSalt);
            $modificationTimestamp = Date('Y-m-d H:i:s');

            $account = $this->rm->getAccountRepository()->findByEmail($email);
            $account->setPassword($newPassword);
            $account->setSalt($newSalt);
            $account->setLastPasswordModificationDate($modificationTimestamp);

            $this->rm->getAccountRepository()->merge($account);

            try {
                EmailDispatcher::send(
                    $email,
                    $l["email"]["index"]["passwordRecovery"]["successSubject"],
                    $l["email"]["index"]["passwordRecovery"]["successMessage"]);
            } catch (EmailConstructionException $e) {
                error_log($e->getMessage(), 0);
            }

            AlertHandler::addAlert(ConfigValues::ALERT_SUCCESS,
                sprintf($l["alert"]["index"]["newPassword"]["success"]["changed"],
                    $email));

            header("Location: " . Config::getInstance()->getWwwPath());
            die();
        } else {
            header("Location: " . Config::getInstance()->getWwwPath()
                . "?passwordRecoveryToken=" . $token . "#new-password");
            die();
        }
    }
}
