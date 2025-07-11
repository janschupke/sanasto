<?php

namespace io\schupke\sanasto\core\entity\mapper;

use io\schupke\sanasto\core\entity\TestItem;

/**
 * Provides mapping of data-array onto the TestItem entity.
 */
class TestItemMapper extends AbstractBaseMapper {
    /**
     * Overriden from the superclass.
     * @return TestItem instance of the TestItem entity.
     */
    public function map($data) {
        $testItem = new TestItem();
        $testItem->setId($data["id"]);
        $testItem->setQuestion($data["question"]);
        $testItem->setUserAnswer($data["user_answer"]);
        $testItem->setCorrect($data["correct"]);

        $testItem->setLinkId($data["link_id"]);
        $testItem->setQuestionLanguageId($data["question_language_id"]);
        $testItem->setQuestionWordString($data["question_word_string"]);

        $testItem->setAnswerOptions($data["answer_options"]);

        return $testItem;
    }
}
