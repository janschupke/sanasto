<?php

namespace io\schupke\sanasto\core\entity;

/**
 * @Entity
 * @Table(name = "answer_options")
 */
class AnswerOption extends AbstractBaseEntity {
    /**
     * @var string
     */
    private $value;

    /**
     * @var bool
     */
    private $correct;

    public function getValue() {
        return $this->value;
    }
    public function setValue($value) {
        $this->value = $value;
    }

    public function getCorrect() {
        return $this->correct;
    }
    public function setCorrect($correct) {
        $this->correct = $correct;
    }
}
