<?php

namespace io\schupke\sanasto\core\entity\mapper;

use io\schupke\sanasto\core\entity\WordConflict;

/**
 * Provides mapping of data-array onto the Word conflicts.
 */
class WordConflictMapper extends AbstractBaseMapper {
    /**
     * Overriden from the superclass.
     * @return WordConflict instance of the WordConflict entity.
     */
    public function map($data) {
        $conflict = new WordConflict();

        $conflict->setWord($data["word"]);
        $conflict->setTranslations($data["translations"]);

        return $conflict;
    }
}
