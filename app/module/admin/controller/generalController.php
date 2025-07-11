<?php

use io\schupke\sanasto\core\core\controller\AbstractController;

/**
 * General handling controller for admin module.
 * Contains method that did not fit elsewhere.
 */
class GeneralController extends AbstractController {
    function __construct(ControllerManager $cm) {
        parent::__construct($cm);
    }

    /**
     * Retrieves the total amount of words in the database.
     * @return int total amount of words.
     */
    public function getTotalWords() {
        return $this->rm->getWordRepository()->findCount();
    }

    /**
     * Retrieves the total amount of links in the database.
     * @return int total amount of links.
     */
    public function getTotalLinks() {
        return $this->rm->getLinkRepository()->findCount();
    }

    /**
     * Retrieves the total amount of languages in the database.
     * @param bool $onlyUnique if true, the retrieved number will represent
     * the amount of unique language names in the database.
     * @return int total amount of languages.
     */
    public function getTotalLanguages($onlyUnique = false) {
        if ($onlyUnique) {
            return $this->rm->getLanguageRepository()->findUniqueCount();
        }

        return $this->rm->getLanguageRepository()->findCount();
    }

    /**
     * Retrieves the total amount of tests in the database.
     * @return int total amount of tests.
     */
    public function getTotalTests() {
        return $this->rm->getTestRepository()->findCount();
    }
}
