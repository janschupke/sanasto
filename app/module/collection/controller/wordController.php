<?php

use io\schupke\sanasto\core\core\controller\AbstractController;
use io\schupke\sanasto\core\entity\Word;

/**
 * Word handling controller for collection module.
 */
class WordController extends AbstractController {
    function __construct(ControllerManager $cm) {
        parent::__construct($cm);
    }

    const WORD_ORDER_VALUE = "value";
    const WORD_ORDER_DATE = "date";
    const WORD_ORDER_PHRASE = "phrase";
    const WORD_ORDER_ENABLED = "enabled";

    const WORD_CONSTRAINT_NO = "";
    const WORD_CONSTRAINT_PHRASES = "phrases";
    const WORD_CONSTRAINT_DISABLED = "disabled";

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

        if ($orderRequest == WordController::WORD_ORDER_VALUE) {
            $key = "value";
            if (Utility::getOrdering()[0] == $key) {
                Utility::swapOrdering();
            } else {
                Utility::setOrdering($key);
            }
        } elseif ($orderRequest == WordController::WORD_ORDER_DATE) {
            $key = "date_added";
            if (Utility::getOrdering()[0] == $key) {
                Utility::swapOrdering();
            } else {
                Utility::setOrdering($key, "DESC");
            }
        } elseif ($orderRequest == WordController::WORD_ORDER_PHRASE) {
            $key = "phrase";
            if (Utility::getOrdering()[0] == $key) {
                Utility::swapOrdering();
            } else {
                Utility::setOrdering($key, "DESC");
            }
        } elseif ($orderRequest == WordController::WORD_ORDER_ENABLED) {
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
            . ConfigValues::MOD_COLLECTION . "/words");
        die();
    }

    /**
     * Retrieves all words that match the provided criteria.
     * @param array $searchCriteria stores criteria by which to filter the selection.
     * @return array an array of retrieved words' information.
     * False if nothing was found.
     */
    public function getAllWords($page = 1,
            $recordLimit = ConfigValues::DEFAULT_PAGING_AMOUNT,
            $searchCriteria = null) {
        $searchCriteria["accountId"] = $_SESSION["account"]["id"];
        return $this->rm->getWordRepository()->findAll($page, $recordLimit, $searchCriteria);
    }

    /**
     * Retrieves the amount of words that match given search criteria,
     * or all words, if no criteria are provided.
     * @param array $searchCriteria stores criteria by which to filter the selection.
     * @return int the amount of records that match the criteria.
     */
    public function getWordCount($searchCriteria = null) {
        $searchCriteria["accountId"] = $_SESSION["account"]["id"];
        return $this->rm->getWordRepository()->findCount($searchCriteria);
    }

    /**
     * Sets the search criteria for word listing.
     * @param string $word word value search criteria.
     * @param int $languageId language id search criteria.
     * @param int $constraint additional constraint.
     */
    public function filterWords($word, $languageId, $constraint) {
        global $l;

        $passed = true;

        // ID has to always be numeric.
        if (!InputValidator::validateNumeric($languageId)) {
            $passed = false;
        }

        // User is informed in case of any error.
        if (!$passed) {
            AlertHandler::addAlert(ConfigValues::ALERT_DANGER,
                $l["alert"]["global"]["danger"]["searchCriteria"]["invalid"]);
            return;
        }

        $searchCriteria = [];

        if ($constraint == WordController::WORD_CONSTRAINT_NO) {
            $searchCriteria["constraint"] = $constraint;
        }

        if ($constraint == WordController::WORD_CONSTRAINT_PHRASES) {
            $searchCriteria["phrase"] = true;
            $searchCriteria["constraint"] = $constraint;
        } else {
            $searchCriteria["phrase"] = "";
        }

        if ($constraint == WordController::WORD_CONSTRAINT_DISABLED) {
            $searchCriteria["disabled"] = true;
            $searchCriteria["constraint"] = $constraint;
        } else {
            $searchCriteria["disabled"] = "";
        }

        // Sanitizing.
        $word = InputValidator::pacify($word);

        // Criteria setup.
        $searchCriteria["word"] = $word;
        $searchCriteria["languageId"] = $languageId;

        FormUtils::setSearchCriteria($searchCriteria);

        header("Location: " . Config::getInstance()->getModuleRoot()
            . ConfigValues::MOD_COLLECTION . "/words");
        die();
    }

    /**
     * Finds a word based on provided id.
     * @param int $id id of the searched word.
     * @return Word instance of the Word entry if found, null otherwise.
     */
    public function getWordById($id) {
        global $l;

        $passed = true;

        if (!InputValidator::validateNumeric($id)) {
            AlertHandler::addAlert(ConfigValues::ALERT_DANGER,
                $l["alert"]["global"]["danger"]["badId"]);
            $passed = false;
        }

        $word = $this->rm->getWordRepository()->findById($id);

        if ($word == null or $word->getAccount()->getId() != $_SESSION["account"]["id"]) {
            AlertHandler::addAlert(ConfigValues::ALERT_DANGER,
                $l["alert"]["collection"]["words"]["modify"]["danger"]["doesNotExist"]);
            $passed = false;
        }

        if (!$passed) {
            header("Location: " . Config::getInstance()->getModuleRoot()
                . ConfigValues::MOD_COLLECTION . "/words");
            die();
        }

        return $word;
    }

    /**
     * Validates that the provided values are correct.
     * @param bool $passed boolean value that indicates
     * whether there have been any errors so far.
     * @param string $word word value to be validated.
     * @param int $languageId an id of the language to be validated.
     * @return bool same as input param in case of no errors, false otherwise.
     */
    private function validateWord($passed, $word, $languageId) {
        global $l;

        if (InputValidator::isEmpty($word)) {
            AlertHandler::addAlert(ConfigValues::ALERT_DANGER,
                $l["alert"]["collection"]["words"]["create"]["danger"]["emptyValue"]);
            $passed = false;
        }

        if (!InputValidator::validateNumeric($languageId)) {
            AlertHandler::addAlert(ConfigValues::ALERT_DANGER,
                $l["alert"]["collection"]["words"]["create"]["danger"]["badLanguage"]);
            $passed = false;
        }

        return $passed;
    }

    /**
     * Validates that the language exists and is owned by this account.
     * @param bool $passed boolean value that indicates
     * whether there have been any errors so far.
     * @param int $languageId an id of the language to be validated.
     * @return bool same as input param in case of no errors, false otherwise.
     */
    private function validateLanguage($passed, $languageId) {
        global $l;

        $language = $this->rm->getLanguageRepository()->findById($languageId);
        if ($language == null || $language->getAccount()->getId() != $_SESSION["account"]["id"]) {
            AlertHandler::addAlert(ConfigValues::ALERT_DANGER,
                $l["alert"]["collection"]["words"]["create"]["danger"]["illegalLanguage"]);
            $passed = false;
        }

        return $passed;
    }

    /**
     * Retrieves all conflicting words and their translations.
     * @param string $word word value.
     * @param int $languageId id of the word's language.
     * @param int $wordId id of specific word to look for. If provided, and it's the only conflict,
     * entry with this id is excluded, since word cannot be conflicting with itself.
     * Id should only be provided from within word modification methods, not translation modification.
     * @return array an array of Conflict instances, or null in case of no conflicts.
     */
    public function getWordConflicts($word, $languageId, $wordId = null) {
        $searchCriteria["word"] = $word;
        $searchCriteria["languageId"] = $languageId;
        $searchCriteria["accountId"] = $_SESSION["account"]["id"];

        $words = [];
        $words = $this->rm->getWordRepository()->findAll(null, null, $searchCriteria);

        if ($wordId != null and sizeof($words) == 1 and $words[0]->getId() == $wordId) {
            return null;
        }

        $conflicts = $this->rm->getWordConflictRepository()->findConflicts($words);

        return $conflicts;
    }

    /**
     * Retrieves a list of existing translations relevant to the provided word.
     * @param string $word word value.
     * @param int $languageId id of the word's language.
     * @param int $wordId id of specific word to look for.
     * @return array an array of Conflict instances, representing existing translations.
     */
    public function getExistingTranslations($word, $languageId, $wordId) {
        $searchCriteria["word"] = $word;
        $searchCriteria["languageId"] = $languageId;
        $searchCriteria["accountId"] = $_SESSION["account"]["id"];

        $words = [];
        array_push($words, $this->rm->getWordRepository()->findById($wordId));
        $translations = $this->rm->getWordConflictRepository()->findConflicts($words);

        return $translations;
    }

    /**
     * Searches for conflicting entries and returns them,
     * or adds the word into the database in case of no conflicts.
     * @param int $id Word id. If not null, modification is requested. Creation otherwise.
     * @param string $value New word value.
     * @param string $phonetic Phonetic value of the word.
     * @param int $languageId id of the new word's language.
     * @param bool $enabled Enabled flag.
     * @param bool $phrase Indicator whether the entry is word or phrase.
     * @return array an array of WordConflict instances, or null
     * in case of no conflicts or invalid input data.
     */
    public function searchWords($id, $value, $phonetic, $languageId, $enabled, $phrase) {
        global $l;

        $passed = true;

        $passed = $this->validateWord($passed, $value, $languageId);
        $passed = $this->validateLanguage($passed, $languageId);

        if (!$passed) {
            return null;
        }

        $value = Utility::normalizeWord($value);

        $conflicts = $this->getWordConflicts($value, $languageId, $id);

        if (empty($conflicts)) {
            if (InputValidator::validateNumeric($id)) {
                $this->modifyWord($id, $value, $phonetic, $languageId, $enabled, $phrase);
            } else {
                $this->createWord($value, $phonetic, $languageId, $enabled, $phrase);
            }
        }

        return $conflicts;
    }

    /**
     * Adds a new word entry into the database.
     * @param string $value New word value.
     * @param string $phonetic Phonetic value of the word.
     * @param int $languageId id of the new word's language.
     * @param bool $enabled Enabled flag.
     * @param bool $phrase Indicator whether the entry is word or phrase.
     */
    public function createWord($value, $phonetic, $languageId, $enabled, $phrase) {
        global $l;

        FormUtils::setSearchCriteria(["language" => $languageId]);

        $passed = true;

        $passed = $this->validateWord($passed, $value, $languageId);
        $passed = $this->validateLanguage($passed, $languageId);

        $value = InputValidator::pacify($value);
        $phonetic = InputValidator::pacify($phonetic);

        $enabled = Utility::makeBoolean($enabled);
        $phrase = Utility::makeBoolean($phrase);

        if ($passed) {
            $word = new Word();
            $word->setValue($value);
            $word->setPhonetic($phonetic);
            $word->setEnabled($enabled);
            $word->setPhrase($phrase);
            $word->getLanguage()->setId($languageId);
            $word->getAccount()->setId($_SESSION["account"]["id"]);

            $this->rm->getWordRepository()->save($word);

            AlertHandler::addAlert(ConfigValues::ALERT_SUCCESS,
                sprintf($l["alert"]["collection"]["words"]["create"]["success"],
                    $value));

            header("Location: " . Config::getInstance()->getModuleRoot()
                . ConfigValues::MOD_COLLECTION . "/words");
            die();
        }
    }

    /**
     * Updates the Word entry with provided values.
     * @param int $id id of the word to be updated.
     * @param string $phonetic Phonetic value of the word.
     * @param string $value value of the word to be updated.
     * @param int $languageId id of the new language for this word to be put in.
     * @param bool $enabled flag that indicates whether this entry is enabled for use.
     * @param bool $phrase Indicator whether the entry is word or phrase.
     */
    public function modifyWord($id, $value, $phonetic, $languageId, $enabled, $phrase) {
        global $l;

        if (!InputValidator::validateNumeric($id)) {
            AlertHandler::addAlert(ConfigValues::ALERT_DANGER,
                $l["alert"]["global"]["danger"]["badId"]);
            return;
        }

        if (InputValidator::isEmpty($value)) {
            AlertHandler::addAlert(ConfigValues::ALERT_DANGER,
                $l["alert"]["collection"]["words"]["modify"]["danger"]["empty"]);
            return;
        }

        if (!InputValidator::validateNumeric($languageId)) {
            AlertHandler::addAlert(ConfigValues::ALERT_DANGER,
                $l["alert"]["collection"]["words"]["modify"]["danger"]["badLanguage"]);
            return;
        }

        $word = $this->rm->getWordRepository()->findById($id);

        if ($word == null or $word->getAccount()->getId() != $_SESSION["account"]["id"]) {
            AlertHandler::addAlert(ConfigValues::ALERT_DANGER,
                $l["alert"]["collection"]["words"]["modify"]["danger"]["doesNotExist"]);
            return;
        }

        $value = InputValidator::pacify($value);
        $phonetic = InputValidator::pacify($phonetic);
        $enabled = Utility::makeBoolean($enabled);
        $phrase = Utility::makeBoolean($phrase);

        $word->setValue($value);
        $word->setPhonetic($phonetic);
        $word->getLanguage()->setId($languageId);
        $word->setEnabled($enabled);
        $word->setPhrase($phrase);

        $this->rm->getWordRepository()->merge($word);

        AlertHandler::addAlert(ConfigValues::ALERT_SUCCESS,
            sprintf($l["alert"]["collection"]["words"]["modify"]["success"]["modified"],
                $word->getValue()));

        header("Location: " . Config::getInstance()->getModuleRoot()
            . ConfigValues::MOD_COLLECTION . "/words");
        die();
    }

    /**
     * Removes a word entry with the provided id.
     * @param int $id the id of the entry to be removed.
     */
    public function removeWord($id) {
        global $l;

        if (!InputValidator::validateNumeric($id)) {
            AlertHandler::addAlert(ConfigValues::ALERT_DANGER,
                $l["alert"]["global"]["danger"]["badId"]);
            return;
        }

        $word = $this->rm->getWordRepository()->findById($id);

        if ($word == null or $word->getAccount()->getId() != $_SESSION["account"]["id"]) {
            AlertHandler::addAlert(ConfigValues::ALERT_DANGER,
                $l["alert"]["collection"]["words"]["remove"]["danger"]["doesNotExist"]);
            return;
        }

        $this->rm->getWordRepository()->remove($word);

        AlertHandler::addAlert(ConfigValues::ALERT_SUCCESS,
            sprintf($l["alert"]["collection"]["words"]["remove"]["success"]["removed"],
                $word->getValue()));

        header("Location: " . Config::getInstance()->getModuleRoot()
            . ConfigValues::MOD_COLLECTION . "/words");
        die();
    }
}
