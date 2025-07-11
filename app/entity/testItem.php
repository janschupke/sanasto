<?php

namespace io\schupke\sanasto\core\entity;

/**
 * @Entity
 * @Table(name = "test_items")
 */
class TestItem extends AbstractBaseEntity {
    /**
     * @var string
     */
    private $question;

    /**
     * @var bool
     */
    private $correct;

    /**
     * @var string
     */
    private $userAnswer;

    /**
     * @var array
     */
    private $answerOptions;

    /**
     * @var int
     */
    private $linkId;

    /**
     * @var int
     */
    private $questionLanguageId;

    /**
     * @var string
     */
    private $questionWordString;

    public function getQuestion() {
        return $this->question;
    }
    public function setQuestion($question) {
        $this->question = $question;
    }

    public function getCorrect() {
        return $this->correct;
    }
    public function setCorrect($correct) {
        $this->correct = $correct;
    }

    public function getUserAnswer() {
        return $this->userAnswer;
    }
    public function setUserAnswer($userAnswer) {
        $this->userAnswer = $userAnswer;
    }

    public function getAnswerOptions() {
        return $this->answerOptions;
    }
    public function setAnswerOptions($answerOptions) {
        $this->answerOptions = $answerOptions;
    }

    // ~ Support fields, not persistent.

    public function getLinkId() {
        return $this->linkId;
    }
    public function setLinkId($linkId) {
        $this->linkId = $linkId;
    }

    public function getQuestionLanguageId() {
        return $this->questionLanguageId;
    }
    public function setQuestionLanguageId($questionLanguageId) {
        $this->questionLanguageId = $questionLanguageId;
    }

    public function getQuestionWordString() {
        return $this->questionWordString;
    }
    public function setQuestionWordString($questionWordString) {
        $this->questionWordString = $questionWordString;
    }
}
