<?php

use io\schupke\sanasto\core\exception\DuplicateEntryException;
use io\schupke\sanasto\core\core\controller\AbstractController;
use io\schupke\sanasto\core\entity\Word;
use io\schupke\sanasto\core\entity\Link;

/**
 * Link handling controller for collection module.
 */
class LinkController extends AbstractController {
    function __construct(ControllerManager $cm) {
        parent::__construct($cm);
    }

    const LINK_CONSTRAINT_NO = "";
    const LINK_CONSTRAINT_PHRASES = "phrases";
    const LINK_CONSTRAINT_KNOWN = "known";
    const LINK_CONSTRAINT_PRIORITIZED = "prioritized";

    /**
     * Retrieves all links that match the provided criteria.
     * @param array $searchCriteria stores criteria by which to filter the selection.
     * @return array an array of retrieved links' information.
     * False if nothing was found.
     */
    public function getAllLinks($page = 1,
            $recordLimit = ConfigValues::DEFAULT_PAGING_AMOUNT,
            $searchCriteria = null) {
        $searchCriteria["accountId"] = $_SESSION["account"]["id"];
        return $this->rm->getLinkRepository()->findAll($page, $recordLimit, $searchCriteria);
    }

    /**
     * Retrieves the amount of links that match given search criteria,
     * or all links, if no criteria are provided.
     * @param array $searchCriteria stores criteria by which to filter the selection.
     * @return int the amount of records that match the criteria.
     */
    public function getLinkCount($searchCriteria = null) {
        $searchCriteria["accountId"] = $_SESSION["account"]["id"];
        return $this->rm->getLinkRepository()->findCount($searchCriteria);
    }

    /**
     * Sets the search criteria for translation listing.
     * @param string $word word value search criteria.
     * @param int $languageId language id search criteria.
     * @param int $constraint additional constraint.
     */
    public function filterTranslations($word, $languageId, $constraint) {
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

        if ($constraint == LinkController::LINK_CONSTRAINT_NO) {
            $searchCriteria["constraint"] = $constraint;
        }

        if ($constraint == LinkController::LINK_CONSTRAINT_PHRASES) {
            $searchCriteria["phrases"] = true;
            $searchCriteria["constraint"] = $constraint;
        } else {
            $searchCriteria["phrases"] = "";
        }

        if ($constraint == LinkController::LINK_CONSTRAINT_KNOWN) {
            $searchCriteria["known"] = true;
            $searchCriteria["constraint"] = $constraint;
        } else {
            $searchCriteria["known"] = "";
        }

        if ($constraint == LinkController::LINK_CONSTRAINT_PRIORITIZED) {
            $searchCriteria["prioritized"] = true;
            $searchCriteria["constraint"] = $constraint;
        } else {
            $searchCriteria["prioritized"] = "";
        }

        // Sanitizing.
        $word = InputValidator::pacify($word);

        // Criteria setup.
        $searchCriteria["word"] = $word;
        $searchCriteria["languageId"] = $languageId;

        FormUtils::setSearchCriteria($searchCriteria);

        header("Location: " . Config::getInstance()->getModuleRoot()
            . ConfigValues::MOD_COLLECTION . "/translations");
        die();
    }

    /**
     * Validates that the provided values are correct.
     * @param bool $passed boolean value that indicates
     * whether there have been any errors so far.
     * @param string $word word value to be validated.
     * @param int $languageId an id of the language to be validated.
     * @param int $side the side of the translation, used to translation keys.
     * Can either be 1 or 2.
     * @return bool same as input param in case of no errors, false otherwise.
     */
    private function validateWord($passed, $word, $languageId, $side) {
        global $l;

        if (InputValidator::isEmpty($word)) {
            $key = "emptyValue" . $side;
            AlertHandler::addAlert(ConfigValues::ALERT_DANGER,
                $l["alert"]["collection"]["translations"]["create"]["danger"][$key]);
            $passed = false;
        }

        if (!InputValidator::validateNumeric($languageId)) {
            $key = "badLanguage" . $side;
            AlertHandler::addAlert(ConfigValues::ALERT_DANGER,
                $l["alert"]["collection"]["translations"]["create"]["danger"][$key]);
            $passed = false;
        }

        return $passed;
    }

    /**
     * Validates that both languages exist and are owned by this account.
     * @param bool $passed boolean value that indicates
     * whether there have been any errors so far.
     * @param int $languageId an id of the language to be validated.
     * @param int $side the side of the translation, used to translation keys.
     * Can either be 1 or 2.
     * @return bool same as input param in case of no errors, false otherwise.
     */
    private function validateLanguage($passed, $languageId, $side) {
        global $l;

        $language = $this->rm->getLanguageRepository()->findById($languageId);
        if ($language == null || $language->getAccount()->getId() != $_SESSION["account"]["id"]) {
            $key = "illegalLanguage" . $side;
            AlertHandler::addAlert(ConfigValues::ALERT_DANGER,
                $l["alert"]["collection"]["translations"]["create"]["danger"][$key]);
            $passed = false;
        }

        return $passed;
    }

    /**
     * Searches for potential conflicting entries that would cause duplicate values.
     * @param string $word1 new word1 value.
     * @param int $language1Id id of the new word1's language.
     * @param string $word2 new word2 value.
     * @param int $language2Id id of the new word2's language.
     * @return array an array of arrays of WordConflict instances, or null
     * in case of no conflicts or invalid input data. First array index represents
     * word1 conflicts, the other one represents word2 conflicts.
     */
    public function searchTranslations($word1, $word1Phrase, $language1Id,
            $word2, $word2Phrase, $language2Id) {
        global $l;

        $passed = true;

        $passed = $this->validateWord($passed, $word1, $language1Id, 1);
        $passed = $this->validateWord($passed, $word2, $language2Id, 2);

        $passed = $this->validateLanguage($passed, $language1Id, 1);
        $passed = $this->validateLanguage($passed, $language2Id, 2);

        // Sanitizing.
        $word1 = InputValidator::pacify($word1);
        $word2 = InputValidator::pacify($word2);

        $word1Phrase = Utility::makeBoolean($word1Phrase);
        $word2Phrase = Utility::makeBoolean($word2Phrase);

        if (!$passed) {
            return null;
        }

        $conflicts[0] = $this->cm->getWordController()->getWordConflicts($word1, $language1Id);
        $conflicts[1] = $this->cm->getWordController()->getWordConflicts($word2, $language2Id);

        // No conflicts, creating word entries and a link entry.
        if (empty($conflicts[0]) and empty($conflicts[1])) {
            $this->createTranslation(0, $word1, $word1Phrase, $language1Id,
                    0, $word2, $word2Phrase, $language2Id, true);
        }

        // Used to make the conflict list persist through invalid submissions.
        $_SESSION["wordConflicts"] = serialize($conflicts);

        return $conflicts;
    }

    /**
     * Adds a new word entry into the database. Returns its ID.
     * @param string $value word value to be added.
     * @param bool $phrase Indicator whether the entry is a simple word or phrase.
     * @param int $languageId an id of the word's language to be added.
     * @return int id of the added word entry.
     */
    private function createWordEntry($value, $phrase, $languageId) {
        $word = new Word();
        $word->setValue($value);
        $word->setEnabled(true);
        $word->setPhrase($phrase);
        $word->getLanguage()->setId($languageId);
        $word->getAccount()->setId($_SESSION["account"]["id"]);

        $wordId = $this->rm->getWordRepository()->save($word);

        return $wordId;
    }

    /**
     * Extracts IDs of words that are linked to the word identified by the provided ID.
     * @param array $conflicts list of word translations / conflicts.
     * @param int $wordId an ID of the provided linked word.
     * @return array an array of IDs of words that are linked to the provided word.
     */
    private function extractTranslationIds($conflicts, $wordId) {
        $ids = [];

        array_push($ids, $wordId);

        if (empty($conflicts)) {
            return $ids;
        }

        foreach ($conflicts as $conflict) {
            if ($conflict->getWord()->getId() == $wordId) {
                foreach ($conflict->getTranslations() as $translation) {
                    array_push($ids, $translation->getId());
                }

                break;
            }
        }

        return $ids;
    }

    /**
     * Transitively links all words that are linked to the original ends
     * of the new translation.
     * @param array $conflicts list of conflicts for both sides of the link.
     * @param int $leftWordId id of the word on the left hand side of the link.
     * 2param int $rightWordId id of the word on the right hand side of the link.
     * @throws DuplicateEntryException if a link already exists.
     */
    private function linkTransitively($conflicts, $leftWordId, $rightWordId) {
        $leftIdList = $this->extractTranslationIds($conflicts[0], $leftWordId);
        $rightIdList = $this->extractTranslationIds($conflicts[1], $rightWordId);

        // Transitive linking requires words on both sides.
        if (empty($leftIdList) or empty($rightIdList)) {
            $this->rm->getLinkRepository()->save($link);
            return;
        }

        foreach ($leftIdList as $leftId) {
            foreach ($rightIdList as $rightId) {
                $link = new Link();
                $link->getWord1()->setId($leftId);
                $link->getWord2()->setId($rightId);
                $link->getAccount()->setId($_SESSION["account"]["id"]);

                $this->rm->getLinkRepository()->save($link);
            }
        }
    }

    /**
     * Makes a new Link entry and potentially new Word entries
     * based on the provided parameters objects.
     * @param int $word1Id first word's id if exists, 0 if new word creation is requested.
     * @param string $word1Value first word's value.
     * @param int $language1Id first word's language id.
     * @param int $word2Id second word's id if exists, 0 if new word creation is requested.
     * @param string $word2Value second word's value.
     * @param int $language2Id second word's language id.
     * @param bool $transitively a flag that indicates whether to link transitively or not.
     * @return array an array of WordConflict instances in case of any error,
     * nothing  otherwise (redirect).
     */
    public function createTranslation($word1Id, $word1Value, $word1Phrase, $language1Id,
            $word2Id, $word2Value, $word2Phrase, $language2Id, $transitively = true) {
        global $l;

        FormUtils::setSearchCriteria(["language1Id" => $language1Id]);
        FormUtils::setSearchCriteria(["language2Id" => $language2Id]);

        $passed = true;

        $newLeftEntry = false;
        $newRightEntry = false;

        $leftWordId = $word1Id;
        $rightWordId = $word2Id;

        if (!InputValidator::validateNumeric($word1Id) || $word1Id < 0) {
            AlertHandler::addAlert(ConfigValues::ALERT_DANGER,
                $l["alert"]["collection"]["translations"]["create"]["danger"]["badWord1Id"]);
            $passed = false;
        }

        if (!InputValidator::validateNumeric($word2Id) || $word2Id < 0) {
            AlertHandler::addAlert(ConfigValues::ALERT_DANGER,
                $l["alert"]["collection"]["translations"]["create"]["danger"]["badWord2Id"]);
            $passed = false;
        }

        // Adding new entry for the left side.
        if ($word1Id == 0) {
            $passed = $this->validateWord($passed, $word1Value, $language1Id, 1);
            $newLeftEntry = true;
        }

        // Adding new entry for the right side.
        if ($word2Id == 0) {
            $passed = $this->validateWord($passed, $word2Value, $language2Id, 2);
            $newRightEntry = true;
        }

        $passed = $this->validateLanguage($passed, $language1Id, 1);
        $passed = $this->validateLanguage($passed, $language2Id, 2);

        if (!$passed) {
            // Used to make the conflict list persist through invalid submissions.
            return unserialize($_SESSION["wordConflicts"]);
        }

        // Sanitizing.
        $word1Value = InputValidator::pacify($word1Value);
        $word2Value = InputValidator::pacify($word2Value);

        $word1Phrase = Utility::makeBoolean($word1Phrase);
        $word2Phrase = Utility::makeBoolean($word2Phrase);

        if ($newLeftEntry) {
            $leftWordId = $this->createWordEntry($word1Value, $word1Phrase, $language1Id);
        }

        if ($newRightEntry) {
            $rightWordId = $this->createWordEntry($word2Value, $word2Phrase, $language2Id);
        }

        $transitively = Utility::makeBoolean($transitively);

        try {
            if (!$transitively) {
                $link = new Link();
                $link->getWord1()->setId($leftWordId);
                $link->getWord2()->setId($rightWordId);
                $link->getAccount()->setId($_SESSION["account"]["id"]);

                $this->rm->getLinkRepository()->save($link);
            } else {
                $conflicts = unserialize($_SESSION["wordConflicts"]);
                $this->linkTransitively($conflicts, $leftWordId, $rightWordId);
            }
        } catch (DuplicateEntryException $e) {
            AlertHandler::addAlert(ConfigValues::ALERT_DANGER,
                $l["alert"]["collection"]["translations"]["create"]["danger"]["duplicate"]);
            return unserialize($_SESSION["wordConflicts"]);
        }

        // Used to make the conflict list persist through invalid submissions.
        unset($_SESSION["wordConflicts"]);

        AlertHandler::addAlert(ConfigValues::ALERT_SUCCESS,
            sprintf($l["alert"]["collection"]["translations"]["create"]["success"],
                $word1Value, $word2Value));

        header("Location: " . Config::getInstance()->getModuleRoot()
            . ConfigValues::MOD_COLLECTION . "/create-translation");
        die();
    }

    /**
     * Removes a link entry with the provided id.
     * @param int $id the id of the entry to be removed.
     */
    public function removeLink($id) {
        global $l;

        if (!InputValidator::validateNumeric($id)) {
            AlertHandler::addAlert(ConfigValues::ALERT_DANGER,
                $l["alert"]["global"]["danger"]["badId"]);
            return;
        }

        $link = $this->rm->getLinkRepository()->findById($id);

        if ($link == null or $link->getAccount()->getId() != $_SESSION["account"]["id"]) {
            AlertHandler::addAlert(ConfigValues::ALERT_DANGER,
                $l["alert"]["collection"]["translations"]["unlink"]["danger"]["doesNotExist"]);
            return;
        }

        $this->rm->getLinkRepository()->remove($link);

        AlertHandler::addAlert(ConfigValues::ALERT_SUCCESS,
            sprintf($l["alert"]["collection"]["translations"]["unlink"]["success"]["removed"],
                $link->getWord1()->getValue(),
                $link->getWord2()->getValue()));

        header("Location: " . Config::getInstance()->getModuleRoot()
            . ConfigValues::MOD_COLLECTION . "/translations");
        die();
    }

    /**
     * Removes the words that are on the ends of the link with this id.
     * This will transitively remove that link as well.
     * @param int $id the id of the link whose words are being removed.
     */
    public function removeTranslation($id) {
        global $l;

        if (!InputValidator::validateNumeric($id)) {
            AlertHandler::addAlert(ConfigValues::ALERT_DANGER,
                $l["alert"]["global"]["danger"]["badId"]);
            return;
        }

        $link = $this->rm->getLinkRepository()->findById($id);

        if ($link == null or $link->getAccount()->getId() != $_SESSION["account"]["id"]) {
            AlertHandler::addAlert(ConfigValues::ALERT_DANGER,
                $l["alert"]["collection"]["translations"]["remove"]["danger"]["doesNotExist"]);
            return;
        }

        $this->rm->getLinkRepository()->removeWords($link);

        AlertHandler::addAlert(ConfigValues::ALERT_SUCCESS,
            sprintf($l["alert"]["collection"]["translations"]["remove"]["success"]["removed"],
                $link->getWord1()->getValue(),
                $link->getWord2()->getValue()));

        header("Location: " . Config::getInstance()->getModuleRoot()
            . ConfigValues::MOD_COLLECTION . "/translations");
        die();
    }
}
