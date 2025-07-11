<?php

use io\schupke\sanasto\core\core\controller\AbstractController;
use io\schupke\sanasto\core\entity\Language;

/**
 * Language handling controller for collection module.
 */
class LanguageController extends AbstractController {
    function __construct(ControllerManager $cm) {
        parent::__construct($cm);
    }

    const DEFAULT_LANGUAGE_COLOR = "black";

    /**
     * Retrieves all languages that match the provided criteria.
     * @param array $searchCriteria stores criteria by which to filter the selection.
     * @return array an array of retrieved languages' information.
     * False if nothing was found.
     */
    public function getAllLanguages($searchCriteria = null) {
        $searchCriteria["accountId"] = $_SESSION["account"]["id"];
        return $this->rm->getLanguageRepository()->findAll(null, null, $searchCriteria);
    }

    /**
     * Retrieves the amount of languages that match given search criteria,
     * or all languages, if no criteria are provided.
     * @param array $searchCriteria stores criteria by which to filter the selection.
     * @return int the amount of records that match the criteria.
     */
    public function getLanguageCount($searchCriteria = null) {
        $searchCriteria["accountId"] = $_SESSION["account"]["id"];
        return $this->rm->getLanguageRepository()->findCount($searchCriteria);
    }

    /**
     * Creates a new Language entry associated with the currently logged-in account.
     * @param string $name name of the language that will be added.
     */
    public function createLanguage($name) {
        global $l;

        // Value must not be empty.
        if (InputValidator::isEmpty($name)) {
            AlertHandler::addAlert(ConfigValues::ALERT_DANGER,
                $l["alert"]["collection"]["addLanguage"]["danger"]["empty"]);
            return;
        }

        $name = InputValidator::pacify($name);

        // Insert attempt that catches duplicate problems of the provided name.
        try {
            $language = new Language();
            $language->setColor(LanguageController::DEFAULT_LANGUAGE_COLOR);
            $language->setValue($name);
            $language->getAccount()->setId($_SESSION["account"]["id"]);
            $this->rm->getLanguageRepository()->save($language);
        } catch (DuplicateEntryException $e) {
            AlertHandler::addAlert(ConfigValues::ALERT_DANGER,
                sprintf($l["alert"]["collection"]["addLanguage"]["danger"]["duplicate"],
                    $name));
            return;
        }

        // Finished with no errors.
        AlertHandler::addAlert(ConfigValues::ALERT_SUCCESS,
            sprintf($l["alert"]["collection"]["addLanguage"]["success"]["added"],
                $name));

        // Clears $_POST values.
        header("Location: " . Config::getInstance()->getModuleRoot()
            . ConfigValues::MOD_COLLECTION . "/languages");
        die();
    }

    /**
     * Sets the search criteria for language listing.
     */
    public function setLanguageSearchCriteria() {
        $criteria["accountId"] = $_SESSION["account"]["id"];

        FormUtils::setSearchCriteria($criteria);
    }

    /**
     * Removes language with the provided id from the database,
     * if no words are assigned to it.
     * @param int $id id of the language to be removed.
     */
    public function removeLanguage($id, $value) {
        global $l;

        // ID must be valid numeric.
        if (!InputValidator::validateNumeric($id)) {
            AlertHandler::addAlert(ConfigValues::ALERT_DANGER,
                $l["alert"]["global"]["danger"]["badId"]);
            return;
        }

        $language = $this->rm->getLanguageRepository()->findById($id);

        // The confirmation string the user entered muset reflect
        // the name of the language he is trying to remove.
        if ($language->getValue() != $value) {
            // For front-end feedback.
            $expectedValue = $language->getValue();

            AlertHandler::addAlert(ConfigValues::ALERT_DANGER,
                sprintf($l["alert"]["collection"]["removeLanguage"]["danger"]["badValue"],
                    InputValidator::pacify($value),
                    $expectedValue));
            return;
        }

        // This language does not belong to the currently logged-in user.
        // Probably attack attempt.
        if ($language->getAccount()->getId() != $_SESSION["account"]["id"]) {
            return;
        }

        // Everything is valid, removing.
        $language = new Language();
        $language->setId($id);
        $this->rm->getLanguageRepository()->remove($language);

        // Language was removed.
        AlertHandler::addAlert(ConfigValues::ALERT_SUCCESS,
            sprintf($l["alert"]["collection"]["removeLanguage"]["success"]["removed"],
                $value));

        header("Location: " . Config::getInstance()->getModuleRoot()
                . ConfigValues::MOD_COLLECTION . "/languages");
        die();
    }

    /**
     * Validates that the provided string can be used as a formal color.
     * @param string $color Provided string.
     * @return bool True if the provided string represents valid color, false otherwise.
     */
    private function validateLanguageColor($color) {
        // Named color options.
        foreach (ConfigValues::getValidColors() as $validColor) {
            if ($color == $validColor) {
                return true;
            }
        }

        // HTML hexa format validation.
        if (preg_match("/#([a-fA-F0-9]{3}){1,2}\b/", $color)) {
            return true;
        }

        return false;
    }

    /**
     * Modifies a language entry color.
     * @param int $id the id of the language to be modified.
     * @param string $color a new color for the language.
     */
    public function colorLanguage($id, $color) {
        global $l;

        // ID must be valid numeric.
        if (!InputValidator::validateNumeric($id)) {
            AlertHandler::addAlert(ConfigValues::ALERT_DANGER,
                $l["alert"]["global"]["danger"]["badId"]);
            return;
        }

        if (InputValidator::isEmpty($color)) {
            $color = LanguageController::DEFAULT_LANGUAGE_COLOR;
        }

        $color = strtolower($color);
        $color = InputValidator::pacify($color);

        if (!$this->validateLanguageColor($color)) {
            AlertHandler::addAlert(ConfigValues::ALERT_DANGER,
                sprintf($l["alert"]["collection"]["modifyLanguage"]["danger"]["color"],
                    $color));
            return;
        }

        $language = $this->rm->getLanguageRepository()->findById($id);

        // This language does not belong to the currently logged-in user.
        // Probably attack attempt.
        if ($language->getAccount()->getId() != $_SESSION["account"]["id"]) {
            return;
        }

        $language->setColor($color);
        $this->rm->getLanguageRepository()->merge($language);

        // Language was colored.
        AlertHandler::addAlert(ConfigValues::ALERT_SUCCESS,
            sprintf($l["alert"]["collection"]["modifyLanguage"]["success"]["colored"],
                $language->getValue(),
                $language->getColor()));

        header("Location: " . Config::getInstance()->getModuleRoot()
                . ConfigValues::MOD_COLLECTION . "/languages");
        die();
    }

    /**
     * Modifies a language entry.
     * @param int $id the id of the language to be modified.
     * @param string $name a new name for the language.
     */
    public function modifyLanguage($id, $name) {
        global $l;

        // ID must be valid numeric.
        if (!InputValidator::validateNumeric($id)) {
            AlertHandler::addAlert(ConfigValues::ALERT_DANGER,
                $l["alert"]["global"]["danger"]["badId"]);
            return;
        }

        if (InputValidator::isEmpty($name)) {
            AlertHandler::addAlert(ConfigValues::ALERT_DANGER,
                $l["alert"]["collection"]["modifyLanguage"]["danger"]["emptyName"]);
            return;
        }

        $language = $this->rm->getLanguageRepository()->findById($id);

        // This language does not belong to the currently logged-in user.
        // Probably attack attempt.
        if ($language->getAccount()->getId() != $_SESSION["account"]["id"]) {
            return;
        }

        // For front-end feedback.
        $oldName = $language->getValue();
        $name = InputValidator::pacify($name);

        $language->setValue($name);
        $this->rm->getLanguageRepository()->merge($language);

        // Language was modified.
        AlertHandler::addAlert(ConfigValues::ALERT_SUCCESS,
            sprintf($l["alert"]["collection"]["modifyLanguage"]["success"]["renamed"],
                $oldName,
                $name));

        header("Location: " . Config::getInstance()->getModuleRoot()
                . ConfigValues::MOD_COLLECTION . "/languages");
        die();
    }
}
