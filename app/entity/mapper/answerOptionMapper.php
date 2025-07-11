<?php

namespace io\schupke\sanasto\core\entity\mapper;

use io\schupke\sanasto\core\entity\AnswerOption;

/**
 * Provides mapping of data-array onto the AnswerOption entity.
 */
class AnswerOptionMapper extends AbstractBaseMapper {
    /**
     * Overriden from the superclass.
     * @return AnswerOption instance of the AnswerOption entity.
     */
    public function map($data) {
        $answerOption = new AnswerOption();
        $answerOption->setId($data["id"]);
        $answerOption->setValue($data["value"]);
        // Field not used yet, true by default.
        // $answerOption->setCorrect($data["correct"]);
        $answerOption->setCorrect(true);

        return $answerOption;
    }
}
