<?php

use io\schupke\sanasto\core\core\controller\AbstractController;

/**
 * General test handling controller for testing module.
 */
class TestController extends AbstractController {
    function __construct(ControllerManager $cm) {
        parent::__construct($cm);
    }

    const TEST_TYPE_STANDARD = 0;
    const TEST_TYPE_ALL = 1;
    const TEST_TYPE_KNOWN = 2;
    const TEST_TYPE_UNKNOWN = 3;
    const TEST_TYPE_PRIORITIZED = 4;
    const TEST_TYPE_PHRASES = 5;

    const TEST_ORDER_DATE = "date";
    const TEST_ORDER_ORIGIN = "origin";
    const TEST_ORDER_TARGET = "target";

    /**
     * Handles ordering requests.
     */
    public function handleOrdering() {
        global $l;

        if (empty($_GET["order"])) {
            return;
        }

        $orderRequest = $_GET["order"];
        $key = "";

        if ($orderRequest == TestController::TEST_ORDER_DATE) {
            $key = "start_date";
            if (Utility::getOrdering()[0] == $key) {
                Utility::swapOrdering();
            } else {
                Utility::setOrdering($key, "DESC");
            }
        } elseif ($orderRequest == TestController::TEST_ORDER_ORIGIN) {
            $key = "language_from";
            if (Utility::getOrdering()[0] == $key) {
                Utility::swapOrdering();
            } else {
                Utility::setOrdering($key);
            }
        } elseif ($orderRequest == TestController::TEST_ORDER_TARGET) {
            $key = "language_to";
            if (Utility::getOrdering()[0] == $key) {
                Utility::swapOrdering();
            } else {
                Utility::setOrdering($key);
            }
        } else {
            AlertHandler::addAlert(ConfigValues::ALERT_DANGER,
                $l["alert"]["global"]["danger"]["badOrdering"]);
        }

        header("Location: " . Config::getInstance()->getModuleRoot()
            . ConfigValues::MOD_TEST . "/results");
        die();
    }

    /**
     * Retrieves all tests that match the provided criteria.
     * @param array $searchCriteria stores criteria by which to filter the selection.
     * @return array an array of retrieved tests' information.
     * False if nothing was found.
     */
    public function getAllTests($page = 1,
            $recordLimit = ConfigValues::DEFAULT_PAGING_AMOUNT,
            $searchCriteria = null) {
        $searchCriteria["accountId"] = $_SESSION["account"]["id"];
        $searchCriteria["orderBy"] = Utility::getOrdering()[0];
        $searchCriteria["order"] = Utility::getOrdering()[1];
        return $this->rm->getTestRepository()->findAll($page, $recordLimit, $searchCriteria);
    }

    /**
     * Retrieves the amount of tests that match given search criteria,
     * or all tests, if no criteria are provided.
     * @param array $searchCriteria stores criteria by which to filter the selection.
     * @return int the amount of records that match the criteria.
     */
    public function getTestCount($searchCriteria = null) {
        $searchCriteria["accountId"] = $_SESSION["account"]["id"];
        return $this->rm->getTestRepository()->findCount($searchCriteria);
    }

    /**
     * Sets the search criteria for test listing.
     * @param string $startDate Starting date of the required interval.
     * @param string $endDate Ending date of the required interval.
     */
    public function filterResults($startDate, $endDate) {
        global $l;

        $passed = true;

        // TODO

        FormUtils::setSearchCriteria($criteria);

        header("Location: " . Config::getInstance()->getModuleRoot()
            . ConfigValues::MOD_TEST . "/results");
        die();
    }

    /**
     * Finds a test based on provided id.
     * @param int $id id of the searched test.
     * @return Test Instance of the Test entry if found, null otherwise.
     */
    public function getTestById($id) {
        global $l;

        $passed = true;

        if (!InputValidator::validateNumeric($id)) {
            AlertHandler::addAlert(ConfigValues::ALERT_DANGER,
                $l["alert"]["global"]["danger"]["badId"]);
            $passed = false;
        }

        $test = $this->rm->getTestRepository()->findById($id);

        if ($test == null or $test->getAccount()->getId() != $_SESSION["account"]["id"]) {
            AlertHandler::addAlert(ConfigValues::ALERT_DANGER,
                $l["alert"]["test"]["detail"]["danger"]["doesNotExist"]);
            $passed = false;
        }

        if (!$passed) {
            header("Location: " . Config::getInstance()->getModuleRoot()
                . ConfigValues::MOD_TEST . "/results");
            die();
        }

        return $test;
    }

    /**
     * Verifies that the provided value represents one of valid test types.
     * @param string $type String representation of the requested test type.
     * @return bool True if valid, false otherwise.
     */
    private function isValidTestType($type) {
        if ($type == TestController::TEST_TYPE_STANDARD ||
                $type == TestController::TEST_TYPE_ALL ||
                $type == TestController::TEST_TYPE_KNOWN ||
                $type == TestController::TEST_TYPE_UNKNOWN ||
                $type == TestController::TEST_TYPE_PRIORITIZED ||
                $type == TestController::TEST_TYPE_PHRASES) {
            return true;
        }

        return false;
    }

    /**
     * Generates a new test data based on the requested parameters.
     * @param int $from ID of the origin language.
     * @param int $to ID of the target language
     * @param string $type One of the test types, as defined in the TestController.
     * @param int $amount Desired amount of translations to be generated.
     */
    public function generateTest($from, $to, $type, $amount = ConfigValues::DEFAULT_TEST_AMOUNT) {
        global $l;

        FormUtils::setSearchCriteria(["languageFrom" => $from]);
        FormUtils::setSearchCriteria(["languageTo" => $to]);
        // These two just for form value remembering:
        FormUtils::setSearchCriteria(["amount" => $amount]);
        FormUtils::setSearchCriteria(["testType" => $type]);

        $passed = true;

        if (!InputValidator::validateNumeric($from) || $from < 1) {
            AlertHandler::addAlert(ConfigValues::ALERT_DANGER,
                $l["alert"]["test"]["new"]["danger"]["invalidFrom"]);
            $passed = false;
        }

        if (!InputValidator::validateNumeric($to) || $to < 1) {
            AlertHandler::addAlert(ConfigValues::ALERT_DANGER,
                $l["alert"]["test"]["new"]["danger"]["invalidTo"]);
            $passed = false;
        }

        if (!$this->isValidTestType($type)) {
            AlertHandler::addAlert(ConfigValues::ALERT_DANGER,
                $l["alert"]["test"]["new"]["danger"]["invalidType"]);
            $passed = false;
        }

        if (!InputValidator::validateNumeric($amount)) {
            AlertHandler::addAlert(ConfigValues::ALERT_DANGER,
                $l["alert"]["test"]["new"]["danger"]["invalidAmount"]);
            $passed = false;
        }

        if ($passed) {
            $currentTest = $this->rm->getTestRepository()->generateTest($from, $to, $type, $amount);

            if (sizeof($currentTest->getTestItems()) == 0) {
                AlertHandler::addAlert(ConfigValues::ALERT_DANGER,
                    $l["alert"]["test"]["new"]["danger"]["emptyTest"]);
                return;
            }

            $_SESSION["currentTest"] = serialize($currentTest);

            header("Location: " . Config::getInstance()->getModuleRoot()
                . ConfigValues::MOD_TEST . "/current-test");
            die();
        }
    }

    /**
     * Evaluates and persists the submitted test data.
     * @param array $words Array of user answer strings.
     */
    public function evaluateTest($words) {
        $currentTest = unserialize($_SESSION["currentTest"]);

        for ($i = 0; $i < sizeof($words); $i++) {
            $word = InputValidator::pacify($words[$i]);
            $currentTest->getTestItems()[$i]->setUserAnswer($word);

            // Sets the correctness flag.
            $currentTest->getTestItems()[$i]->setCorrect(false);
            foreach ($currentTest->getTestItems()[$i]->getAnswerOptions() as $option) {
                if ($option->getValue() == $word) {
                    $currentTest->getTestItems()[$i]->setCorrect(true);
                    break;
                }

                // If evaluation results in false, perhaps some exception could change the result.
                if ($this->handleEvaluationExceptions($option, $word)) {
                    $currentTest->getTestItems()[$i]->setCorrect(true);
                    break;
                }
            }

            // Updates stats for adaptive test generating.
            $this->rm->getTestRepository()->updateLinkStats($currentTest->getTestItems()[$i]);
        }

        $resultId = $this->rm->getTestRepository()->save($currentTest);

        unset($_SESSION["currentTest"]);

        header("Location: " . Config::getInstance()->getModuleRoot()
            . ConfigValues::MOD_TEST . "/test-detail/" . $resultId);
        die();
    }

    /**
     * Overrides standard evaluation in some specific cases.
     * @param AnswerOption option Answer option that is currently being evaluated (stored data).
     * @param Word word Word answer, that is being evaluated (user data).
     * @return bool True if answer should be considered correct, false otherwise.
     */
    public function handleEvaluationExceptions($option, $word) {
        // Tweak for english verbs, which can be answered either with the infinitive preposition
        // or without it. Both cases should be considered correct.
        if ($option->getValue() == ("to " . $word)) {
            return true;
        }

        // Same as above.
        if ($option->getValue() == ($word . "of")) {
            return true;
        }

        return false;
    }

    /**
     * Calculates the amount of correcly answered items.
     * @param array $testItems provided test items on which the calculation will be performed.
     * @return int The amount of correct answers.
     */
    public function calculateCorrect($testItems) {
        $correct = 0;

        foreach ($testItems as $item) {
            if ($item->getCorrect()) {
                $correct++;
            }
        }

        return $correct;
    }

    /**
     * Calculates the success percentage of given test.
     * @param Test Provided test instance.
     * @return int The success rate in percents.
     */
    public function calculateSuccessRate($test) {
        if (sizeof($test->getTestItems()) == 0) {
            return "0%";
        }

        $success = $this->calculateCorrect($test->getTestItems()) / sizeof($test->getTestItems());
        $success *= 100;
        $success = floor($success);

        return $success;
    }

    /**
     * Formats all provided answer options into a presentable string.
     * @param array $answerOptions a list of answer options.
     * @return string Formatted string of answer options.
     */
    public function formatAnswerOptions($answerOptions) {
        $result = "";
        $options = [];
        $skip = false;

        foreach ($answerOptions as $answerOption) {
            foreach ($options as $option) {
                if ($answerOption->getValue() == $option->getValue()) {
                    $skip = true;
                    break;
                }
            }

            if ($skip) {
                $skip = false;
                continue;
            }

            array_push($options, $answerOption);
        }

        foreach ($options as $option) {
            $result .= $option->getValue() . ', ';
        }

        $result = substr($result, 0, -2);

        return $result;
    }

    /**
     * Retrieves available languages for coloring purposes.
     * @return array An array of Language objects.
     */
    public function getAvailableLanguages() {
        $searchCriteria["accountId"] = $_SESSION["account"]["id"];
        return $this->rm->getLanguageRepository()->findAll(null, null, $searchCriteria);
    }

    /**
     * Attempts to deduce color of the language based on the names of existing language entries.
     * @param array $languages Array of all languages currently in the database, owned by the user.
     * @param string $value The name of the language as it is saved in the test entry.
     */
    public function colorTestLanguage($languages, $value) {
        // If any name matches, use its color.
        foreach ($languages as $language) {
            if ($value == $language->getValue()) {
                LabelRenderer::colorLanguage($language);
                return;
            }
        }

        // Print without coloring, if no names match.
        echo $value;
    }

    /**
     * Retrieves the last test entry this user has taken.
     */
    public function getLastTest() {
        $searchCriteria["accountId"] = $_SESSION["account"]["id"];
        $searchCriteria["orderBy"] = "start_date";
        $searchCriteria["order"] = "DESC";

        return $this->rm->getTestRepository()->findAll(1, 1, $searchCriteria)[0];
    }

    /**
     * Sets the default item amount based on prevous test, if there is any.
     */
    public function recoverDefaultItemAmount() {
        $lastTest = $this->getLastTest();
        if ($lastTest != null) {
            $searchCriteria["amount"] = sizeof($lastTest->getTestItems());
            FormUtils::setSearchCriteria($searchCriteria);
        }
    }
}
