<?php

namespace io\schupke\sanasto\core\entity;

/**
 * @Entity
 * Virtual entity, not in DB.
 */
class WordConflict extends AbstractBaseEntity {
    /**
     * @var Word
     */
    private $word;

    /**
     * @var array
     */
    private $translations;

    function __construct() {
        $this->word = new Word();
        $this->translations = [];
    }

    public function getWord() {
        return $this->word;
    }
    public function setWord($word) {
        $this->word = $word;
    }

    public function getTranslations() {
        return $this->translations;
    }
    public function setTranslations($translations) {
        $this->translations = $translations;
    }
}
