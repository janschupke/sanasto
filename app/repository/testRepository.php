<?php

namespace io\schupke\sanasto\core\repository;

use PDOException;
use PDO;
use Utility;
use ConfigValues;
use TestController;

/**
 * Handles all database operation related to tests.
 */
class TestRepository extends AbstractRepository {

    function __construct(RepositoryManager $rm) {
        parent::__construct($rm);
    }

    /**
     * Overriden method, documented in parent.
     */
    protected function getSelect() {
        return "SELECT
            t.id,
            t.test_type,
            t.start_date,
            t.language_from,
            t.language_to,
            a.id AS account_id";
    }

    /**
     * Overriden method, documented in parent.
     */
    protected function getFrom() {
        return " FROM tests AS t
            INNER JOIN accounts AS a
                ON t.account_id = a.id";
    }

    /**
     * Overriden method, documented in parent.
     */
    protected function getGroupBy() {
        return "";
    }

    /**
     * Overriden method, documented in parent.
     */
    protected function getOrderBy($searchCriteria) {
        if (empty($searchCriteria["orderBy"])) {
            $searchCriteria["orderBy"] = "start_date";
        }

        if (empty($searchCriteria["order"])) {
            $searchCriteria["order"] = "DESC";
        }

        return (" ORDER BY t." . $searchCriteria["orderBy"] . " " . $searchCriteria["order"]);
    }

    /**
     * Overriden method, documented in parent.
     */
    protected function prepareSearchCriteria($searchCriteria) {
        if ($searchCriteria != null) {
            $paramCount = 0;
            $queryWhere = " WHERE";

            if (!empty($searchCriteria["accountId"])) {
                if ($paramCount > 0) {
                    $queryWhere .= " AND";
                }
                $queryWhere .= " a.id = :accountId";
                $paramCount++;
            }

            if ($queryWhere == " WHERE") {
                $queryWhere = "";
            }

            return $queryWhere;
        }

        return "";
    }

    /**
     * Overriden method, documented in parent.
     */
    protected function bindSearchCriteria($stmt, $searchCriteria) {
        if (!empty($searchCriteria["accountId"])) {
            $stmt->bindParam(":accountId", $searchCriteria["accountId"], PDO::PARAM_INT);
        }

        return $stmt;
    }

    /**
     * Overriden method, documented in parent.
     */
    public function findAll($page, $recordLimit, $searchCriteria) {
        $query = $this->getSelect()
            . $this->getFrom()
            . $this->prepareSearchCriteria($searchCriteria)
            . $this->getGroupBy()
            . $this->getOrderBy($searchCriteria)
            . " LIMIT :recordLimit OFFSET :firstRecord";

        $firstRecord = ($page - 1) * $recordLimit;
        $tests = [];

        try {
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(":recordLimit", $recordLimit, PDO::PARAM_INT);
            $stmt->bindParam(":firstRecord", $firstRecord, PDO::PARAM_INT);
            $stmt = $this->bindSearchCriteria($stmt, $searchCriteria);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);

            // Parses the dataset into a PHP array.
            while($row = $stmt->fetch()) {
                $test = $this->emm->getTestMapper()->map($row);
                $test->setTestItems($this->findTestItems($test->getId()));
                array_push($tests, $test);
            }
        } catch (PDOException $e) {
            error_log($e->getMessage(), 0);
            Utility::gotoServerError();
        }

        return $tests;
    }

    /**
     * Retrieves an array of TestItems associated with given test.
     * @param int $testId ID of the test that is being fetched.
     * @return array Array of TestItems.
     */
    private function findTestItems($testId) {
        $query = "SELECT * FROM test_items WHERE test_id = :testId";

        $testItems = [];

        try {
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(":testId", $testId, PDO::PARAM_INT);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);

            // Parses the dataset into a PHP array.
            while($row = $stmt->fetch()) {
                $testItem = $this->emm->getTestItemMapper()->map($row);
                $testItem->setAnswerOptions($this->findAnswerOptions($testItem->getId()));
                array_push($testItems, $testItem);
            }
        } catch (PDOException $e) {
            error_log($e->getMessage(), 0);
            Utility::gotoServerError();
        }

        return $testItems;
    }

    /**
     * Retrieves an array of AnswerOptions associated with given TestItem.
     * @param int $testItemId ID of the test item that is being fetched.
     * @return array Array of AnswerOptions.
     */
    private function findAnswerOptions($testItemId) {
        $query = "SELECT * FROM answer_options WHERE test_item_id = :testItemId";

        $answerOptions = [];

        try {
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(":testItemId", $testItemId, PDO::PARAM_INT);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);

            // Parses the dataset into a PHP array.
            while($row = $stmt->fetch()) {
                $answerOption = $this->emm->getAnswerOptionMapper()->map($row);
                array_push($answerOptions, $answerOption);
            }
        } catch (PDOException $e) {
            error_log($e->getMessage(), 0);
            Utility::gotoServerError();
        }

        return $answerOptions;
    }

    /**
     * Overriden method, documented in parent.
     */
    public function findCount($searchCriteria = null) {
        $query = "SELECT COUNT(t.id) AS rows"
            . $this->getFrom()
            . $this->prepareSearchCriteria($searchCriteria)
            . $this->getGroupBy();

        try {
            $stmt = $this->dbh->prepare($query);
            $stmt = $this->bindSearchCriteria($stmt, $searchCriteria);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $rows = $stmt->fetch();

            return $rows["rows"];
        } catch (PDOException $e) {
            error_log($e->getMessage(), 0);
            Utility::gotoServerError();
        }
    }

    /**
     * Overriden method, documented in parent.
     */
    public function findById($testId) {
        $query = $this->getSelect()
            . $this->getFrom()
            . " WHERE t.id = :testId"
            . $this->getGroupBy()
            . " LIMIT 1";

        try {
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(":testId", $testId);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $test = $stmt->fetch();

            if (!$test) {
                return null;
            }

            $test = $this->emm->getTestMapper()->map($test);
            $test->setTestItems($this->findTestItems($test->getId()));

            return $test;
        } catch (PDOException $e) {
            error_log($e->getMessage(), 0);
            Utility::gotoServerError();
        }
    }

    /**
     * Finds translation entries suitable for a new test
     * described by the provided parameters.
     * @param int $from ID of the origin language.
     * @param int $to ID of the target language.
     * @param string $type One of the test types, as defined in the TestController.
     * @param int $amount Desired amount of translations to be generated.
     * @return Test Instance of the new test.
     */
    public function generateTest($from, $to, $type, $amount) {
        $test["start_date"] = Utility::getNow();
        $test["test_type"] = Utility::resolveTestTypeName($type);
        $test["language_from"] = $this->rm->getLanguageRepository()->findById($from)->getValue();
        $test["language_to"] = $this->rm->getLanguageRepository()->findById($to)->getValue();
        $test["account_id"] = $_SESSION["account"]["id"];
        $test["account_email"] = $_SESSION["account"]["email"];
        $test["test_items"] = $this->processTestItemRequirements($from, $to, $type, $amount);

        $test = $this->emm->getTestMapper()->map($test);

        return $test;
    }

    /**
     * Processes the test requirements bades on requested test type.
     * Delegates test item generating itself on another method, to which it provides
     * more specific constraints based on processed test type.
     * @param int $from ID of the origin language.
     * @param int $to ID of the target language.
     * @param string $type One of the test types, as defined in the TestController.
     * @param int $amount Desired amount of translations to be generated.
     * @return array Array of test items.
     */
    private function processTestItemRequirements($from, $to, $type, $amount) {
        $searchCriteria = [];
        $testItems = [];

        switch ($type) {
            case TestController::TEST_TYPE_STANDARD:
                $fullAmount = $amount;
                $remainingAmount = $amount;

                // Searches for prioritized words first.
                $searchCriteria["prioritized"] = true;
                $testItems = $this->generateTestItems($from, $to, $fullAmount, $searchCriteria);

                // If there is not enough prioritized entries, fallback to random selection.
                if (sizeof($testItems) < ConfigValues::PRIORITIZED_SELECT_THRESHOLD) {
                    if (sizeof($testItems) < $fullAmount) {
                        $searchCriteria = [];
                        $testItems = $this->generateTestItems($from, $to, $fullAmount, $searchCriteria);
                    }
                } else {
                    // Fills remaining spots with non-prioritized + known.
                    if (sizeof($testItems) < $fullAmount) {
                        $remainingAmount = $fullAmount - sizeof($testItems);
                        $searchCriteria = [];
                        $searchCriteria["unprioritized"] = true;
                        $searchCriteria["known"] = true;
                        $complementItems = $this->generateTestItems($from, $to, $remainingAmount, $searchCriteria);
                        $testItems = array_merge($testItems, $complementItems);
                    }

                    // Fills remaining spots with non-prioritized entries.
                    if (sizeof($testItems) < $fullAmount) {
                        $remainingAmount = $fullAmount - sizeof($testItems);
                        $searchCriteria = [];
                        $searchCriteria["unprioritized"] = true;
                        $searchCriteria["unknown"] = true;
                        $complementItems = $this->generateTestItems($from, $to, $remainingAmount, $searchCriteria);
                        $testItems = array_merge($testItems, $complementItems);
                    }
                }

                return $testItems;
                break;

            case TestController::TEST_TYPE_ALL:
                // No constraints.
                break;

            case TestController::TEST_TYPE_KNOWN:
                $searchCriteria["known"] = true;
                break;

            case TestController::TEST_TYPE_UNKNOWN:
                $searchCriteria["unknown"] = true;
                break;

            case TestController::TEST_TYPE_PRIORITIZED:
                $searchCriteria["prioritized"] = true;
                break;

            case TestController::TEST_TYPE_PHRASES:
                $searchCriteria["phrases"] = true;
                break;

            default:
                // Should never be reached.
                break;
        }

        $testItems = $this->generateTestItems($from, $to, $amount, $searchCriteria);

        return $testItems;
    }

    /**
     * Fetches test items based on provided criteria.
     * @param int $from ID of the origin language.
     * @param int $to ID of the target language.
     * @param int $amount Desired amount of translations to be generated.
     * @param array $searchCriteria TestType-specific search criteria provided by the caller,
     * or null in case of no constraints.
     * @return array Array of test items.
     */
    private function generateTestItems($from, $to, $amount, $searchCriteria = null) {
        $searchCriteria["accountId"] = $_SESSION["account"]["id"];
        $searchCriteria["enabled"] = true;
        $searchCriteria["languageFrom"] = $from;
        $searchCriteria["languageTo"] = $to;
        $links = $this->rm->getLinkRepository()->findTestLinks($amount, $searchCriteria);

        $testItems = [];

        foreach ($links as $link) {
            $questionWord = null;
            $answerWord = null;

            // Figuring out on which side of the link the question resides, in its troubled slumber.
            if ($link->getWord1()->getLanguage()->getId() == $from) {
                $questionWord = $link->getWord1();
                $answerWord = $link->getWord2();
            } else {
                $questionWord = $link->getWord2();
                $answerWord = $link->getWord1();
            }

            // Recovering the question.
            $question = $this->rm->getWordRepository()->findById($questionWord->getId());
            $question = $question->getValue();

            // Digging for the mighty answers.
            // Question word == Links with the same value on the 'from' side qualify as answer options.
            $answerOptions = $this->getAnswerOptions($question, [
                "exactWord" => $questionWord->getValue(),
                "languageFrom" => $from,
                "languageTo" => $to]);

            $item["question"] = $question;
            $item["answer_options"] = $answerOptions;

            // Support data for evaluation persistence.
            $item["link_id"] = $link->getId();
            $item["question_language_id"] = $from;
            $item["question_word_string"] = $questionWord->getValue();

            $testItem = $this->emm->getTestItemMapper()->map($item);
            array_push($testItems, $testItem);
        }

        return $testItems;
    }

    /**
     * Fetches all possible answer options for given question.
     * @param string $question Original test item question.
     * @param array $searchCriteria Search criterie based on which to select.
     * @return array An array of answer options.
     */
    private function getAnswerOptions($question, $searchCriteria) {
        $optionLinks = $this->rm->getLinkRepository()->findAll(null, null, $searchCriteria);

        $answerOptions = [];

        foreach ($optionLinks as $optionLink) {
            $option = [];

            // Decide on which side of the link is the answer.
            if ($optionLink->getWord1()->getLanguage()->getId() == $searchCriteria["languageTo"]) {
                $option["value"] = $optionLink->getWord1()->getValue();
            } else if ($optionLink->getWord2()->getLanguage()->getId() == $searchCriteria["languageTo"]) {
                $option["value"] = $optionLink->getWord2()->getValue();
            }

            // No point...
            // FIXME: This should not happen though?
            if ($option["value"] == $question) {
                continue;
            }

            $answerOption = $this->emm->getAnswerOptionMapper()->map($option);
            array_push($answerOptions, $answerOption);
        }

        return $answerOptions;
    }

    /**
     * Updates link stats based on the completed test.
     * @param TestItem $testItem Item, containing the question word string based on which links
     * will be updated.
     */
    public function updateLinkStats($testItem) {
        $highestStreak = 0;

        $searchCriteria["accountId"] = $_SESSION["account"]["id"];
        $searchCriteria["languageId"] = $testItem->getQuestionLanguageId();
        $searchCriteria["exactWord"] = $testItem->getQuestion();
        $links = $this->rm->getLinkRepository()->findTestEvalEntries($searchCriteria);

        if ($testItem->getCorrect()) {
            // Streak gets incremented for all entries with the same question string and language.
            foreach ($links as $link) {
                $this->incrementStreak($link);
                $highestStreak = max($highestStreak, $link->getStreak());
            }

            // Streak and priority gets cleared for all entries upon reaching the threshold.
            if ($highestStreak >= ConfigValues::LINK_UNPRIORITIZE_THRESHOLD) {
                foreach ($links as $link) {
                    $this->setPriority($link, false);
                }
            }

            // Known flag is set to true only for this specific link entry.
            $link = $this->rm->getLinkRepository()->findById($testItem->getLinkId());
            $this->setKnown($link, true);

        } else {
            // Prioritizes all links containing the question string.
            // Also resets the streak before saving.
            foreach ($links as $link) {
                $link->setStreak(0);
                $this->setPriority($link, true);
            }
        }
    }

    /**
     * Increments the streak of provided link.
     * @param Link $link Link instance to be modified.
     */
    private function incrementStreak($link) {
        $link->setStreak($link->getStreak() + 1);
        $this->rm->getLinkRepository()->merge($link);
    }

    /**
     * Sets the priority of provided link to requested value.
     * @param Link $link Link instance to be modified.
     * @param boolean $state Requested state.
     */
    private function setPriority($link, $state) {
        $link->setPrioritized($state);
        $this->rm->getLinkRepository()->merge($link);
    }

    /**
     * Sets the known flag to true for the requested link.
     * @param Link $link Link to be flagged as known.
     * @param boolean $state Requested state.
     */
    private function setKnown($link, $state) {
        $link->setKnown($state);
        $this->rm->getLinkRepository()->merge($link);
    }

    /**
     * Overriden method, documented in parent.
     */
    public function save($test) {
        $query = "INSERT INTO tests
            (test_type, start_date, language_from, language_to, account_id)
            VALUES (:testType, :startDate, :languageFrom, :languageTo, :accountId) RETURNING id";

        try {
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(":testType", $test->getTestType());
            $stmt->bindParam(":startDate", $test->getStartDate());
            $stmt->bindParam(":languageFrom", $test->getLanguageFrom());
            $stmt->bindParam(":languageTo", $test->getLanguageTo());
            $stmt->bindParam(":accountId", $test->getAccount()->getId(), PDO::PARAM_INT);
            $stmt->execute();

            $testId = $stmt->fetchColumn();
            $this->saveTestItems($testId, $test->getTestItems());

            return $testId;
        } catch (PDOException $e) {
            error_log($e->getMessage(), 0);
            Utility::gotoServerError();
        }
    }

    /**
     * Saves individual test items.
     * @param int $testId id of the associated test.
     * @param array $testItems all test items that are to be saved.
     */
    private function saveTestItems($testId, $testItems) {
        $query = "INSERT INTO test_items
            (question, user_answer, correct, test_id)
            VALUES (:question, :userAnswer, :correct, :testId) RETURNING id";

        try {
            foreach ($testItems as $testItem) {
                $stmt = $this->dbh->prepare($query);
                $stmt->bindParam(":question", $testItem->getQuestion());
                $stmt->bindParam(":userAnswer", $testItem->getUserAnswer());
                $stmt->bindParam(":correct", $testItem->getCorrect(), PDO::PARAM_BOOL);
                $stmt->bindParam(":testId", $testId, PDO::PARAM_INT);
                $stmt->execute();

                $testItemId = $stmt->fetchColumn();
                $this->saveAnswerOptions($testItemId, $testItem->getAnswerOptions());
            }
        } catch (PDOException $e) {
            error_log($e->getMessage(), 0);
            Utility::gotoServerError();
        }
    }

    /**
     * Saves all answer options for each test item.
     * @param int $testItemId ID of the particular test item.
     * @param array $answerOptions all available answer options.
     */
    private function saveAnswerOptions($testItemId, $answerOptions) {
        $query = "INSERT INTO answer_options
            (value, correct, test_item_id)
            VALUES (:value, :correct, :testItemId)";

        try {
            foreach ($answerOptions as $answerOption) {
                $stmt = $this->dbh->prepare($query);
                $stmt->bindParam(":value", $answerOption->getValue());
                $stmt->bindParam(":correct", $answerOption->getCorrect(), PDO::PARAM_BOOL);
                $stmt->bindParam(":testItemId", $testItemId, PDO::PARAM_INT);
                $stmt->execute();
            }
        } catch (PDOException $e) {
            error_log($e->getMessage(), 0);
            Utility::gotoServerError();
        }
    }

    /**
     * Overriden method, documented in parent.
     */
    public function merge($test) {
        // Will not be implemented.
    }

    /**
     * Overriden method, documented in parent.
     */
    public function remove($test) {
        // Will not be implemented.
    }
}
