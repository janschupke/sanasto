<?php

namespace io\schupke\sanasto\core\repository;

/**
 * Handles all database operation related to word conflicts.
 */
class WordConflictRepository extends AbstractRepository {

    function __construct(RepositoryManager $rm) {
        parent::__construct($rm);
    }

    /**
     * Overriden method, documented in parent.
     */
    protected function getSelect() {
        // Will not be implemented.
    }

    /**
     * Overriden method, documented in parent.
     */
    protected function getFrom() {
        // Will not be implemented.
    }

    /**
     * Overriden method, documented in parent.
     */
    protected function getGroupBy() {
        // Will not be implemented.

        return "";
    }

    /**
     * Overriden method, documented in parent.
     */
    protected function getOrderBy($searchCriteria) {
        return "";
    }

    /**
     * Overriden method, documented in parent.
     */
    protected function prepareSearchCriteria($searchCriteria) {
        // Will not be implemented.
    }

    /**
     * Overriden method, documented in parent.
     */
    protected function bindSearchCriteria($stmt, $searchCriteria) {
        // Will not be implemented.
    }

    /**
     * Finds all translations to the provided conflicting words.
     * @param array $words provided conflicting words.
     * @return array an array of Conflict instances.
     */
    public function findConflicts($words) {
        $conflicts = [];

        foreach ($words as $word) {
            $conflict = $this->findConflict($word);
            array_push($conflicts, $conflict);
        }

        return $conflicts;
    }

    /**
     * Finds translations of the provided conflicting word.
     * @param Word $word provided conflicting word.
     * @return Conflict an instance of Conflict entity.
     */
    private function findConflict($word) {
        $searchCriteria["wordId"] = $word->getId();
        $links = $this->rm->getLinkRepository()->findAll(null, null, $searchCriteria);
        $wordIds = $this->getWordIds($links, $word);
        $words = $this->getWords($wordIds);

        $conflictData["word"] = $word;
        $conflictData["translations"] = $words;

        $conflict = $this->emm->getWordConflictMapper()->map($conflictData);

        return $conflict;
    }

    /**
     * Extracts word IDs from the array of link objects, excluding
     * IDs of the provided word.
     * @param array $links array of Link instances.
     * @param Word $word provided Word instance.
     * @return array an array of word IDs.
     */
    private function getWordIds($links, $word) {
        $ids = [];

        foreach($links as $link) {
            if ($link->getWord1()->getId() != $word->getId()) {
                array_push($ids, $link->getWord1()->getId());
            }
            if ($link->getWord2()->getId() != $word->getId()) {
                array_push($ids, $link->getWord2()->getId());
            }
        }

        $ids = array_unique($ids);

        return $ids;
    }

    /**
     * Searches the database for all words whose ID is within
     * the provided array of IDs.
     * @param array $ids array of word IDs.
     * @return array an array of Word objects.
     */
    private function getWords($ids) {
        $words = [];

        // FIXME: inefficient, many queries.
        foreach ($ids as $id) {
            $word = $this->rm->getWordRepository()->findById($id);
            array_push($words, $word);
        }

        return $words;
    }

    /**
     * Overriden method, documented in parent.
     */
    public function findAll($page, $recordLimit, $searchCriteria) {
        // Will not be implemented.
    }

    /**
     * Overriden method, documented in parent.
     */
    public function findCount($searchCriteria = null) {
        // Will not be implemented.
    }

    /**
     * Overriden method, documented in parent.
     */
    public function findById($wordId) {
        // Will not be implemented.
    }

    /**
     * Overriden method, documented in parent.
     */
    public function save($wordConflict) {
        // Will not be implemented.
    }

    /**
     * Overriden method, documented in parent.
     */
    public function merge($wordConflict) {
        // Will not be implemented.
    }

    /**
     * Overriden method, documented in parent.
     */
    public function remove($wordConflict) {
        // Will not be implemented.
    }
}
