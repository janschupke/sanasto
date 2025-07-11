<?php

namespace io\schupke\sanasto\core\repository;

use io\schupke\sanasto\core\exception\DuplicateEntryException;
use PDOException;
use PDO;
use Utility;

/**
 * Handles all database operation related to links.
 */
class LinkRepository extends AbstractRepository {

    function __construct(RepositoryManager $rm) {
        parent::__construct($rm);
    }

    /**
     * Overriden method, documented in parent.
     */
    protected function getSelect() {
        return "SELECT
            li.id,
            li.date_added,
            li.last_modification_date,
            li.streak,
            li.prioritized,
            li.known,

            w1.id AS word1_id,
            w1.value AS word1_value,
            l1.id AS language1_id,
            l1.value AS language1_value,
            l1.color AS language1_color,

            w2.id AS word2_id,
            w2.value AS word2_value,
            l2.id AS language2_id,
            l2.value AS language2_value,
            l2.color AS language2_color,

            a.id AS account_id,
            a.email AS account_email";
    }

    /**
     * Overriden method, documented in parent.
     */
    protected function getFrom() {
        return " FROM links AS li
            INNER JOIN words AS w1
                ON w1.id = li.word1_id
            INNER JOIN languages AS l1
                ON l1.id = w1.language_id
            INNER JOIN words AS w2
                ON w2.id = li.word2_id
            INNER JOIN languages AS l2
                ON l2.id = w2.language_id
            INNER JOIN accounts AS a
                ON w1.account_id = a.id AND w2.account_id = a.id";
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
            $searchCriteria["orderBy"] = "date_added";
        }

        if (empty($searchCriteria["order"])) {
            $searchCriteria["order"] = "DESC";
        }

        return (" ORDER BY li." . $searchCriteria["orderBy"] . " " . $searchCriteria["order"]);
    }

    /**
     * Overriden method, documented in parent.
     */
    protected function prepareSearchCriteria($searchCriteria) {
        if ($searchCriteria != null) {
            $paramCount = 0;
            $queryWhere = " WHERE";

            if (!empty($searchCriteria["word"])) {
                if ($paramCount > 0) {
                    $queryWhere .= " AND";
                }
                $queryWhere .= " (LOWER(w1.value) LIKE LOWER(:word1) OR LOWER(w2.value) LIKE LOWER(:word2))";
                $paramCount++;
            }

            if (!empty($searchCriteria["exactWord"])) {
                if ($paramCount > 0) {
                    $queryWhere .= " AND";
                }
                $queryWhere .= " (LOWER(w1.value) = LOWER(:exactWord1) OR LOWER(w2.value) = LOWER(:exactWord2))";
                $paramCount++;
            }

            if (!empty($searchCriteria["wordId"])) {
                if ($paramCount > 0) {
                    $queryWhere .= " AND";
                }
                $queryWhere .= " (word1_id = :word1Id OR word2_id = :word2Id)";
                $paramCount++;
            }

            if (!empty($searchCriteria["languageId"])) {
                if ($paramCount > 0) {
                    $queryWhere .= " AND";
                }
                $queryWhere .= " (l1.id = :language1Id OR l2.id = :language2Id)";
                $paramCount++;
            }

            if (!empty($searchCriteria["accountId"])) {
                if ($paramCount > 0) {
                    $queryWhere .= " AND";
                }
                $queryWhere .= " a.id = :accountId";
                $paramCount++;
            }

            if (!empty($searchCriteria["prioritized"])) {
                if ($paramCount > 0) {
                    $queryWhere .= " AND";
                }
                $queryWhere .= " prioritized = true";
                $paramCount++;
            }

            if (!empty($searchCriteria["unprioritized"])) {
                if ($paramCount > 0) {
                    $queryWhere .= " AND";
                }
                $queryWhere .= " prioritized = false";
                $paramCount++;
            }

            if (!empty($searchCriteria["phrases"])) {
                if ($paramCount > 0) {
                    $queryWhere .= " AND";
                }
                $queryWhere .= " (w1.phrase = :phrases OR w2.phrase = :phrases)";
                $paramCount++;
            }

            if (!empty($searchCriteria["known"])) {
                if ($paramCount > 0) {
                    $queryWhere .= " AND";
                }
                $queryWhere .= " known = true";
                $paramCount++;
            }

            if (!empty($searchCriteria["unknown"])) {
                if ($paramCount > 0) {
                    $queryWhere .= " AND";
                }
                $queryWhere .= " known = false";
                $paramCount++;
            }

            if (!empty($searchCriteria["enabled"])) {
                if ($paramCount > 0) {
                    $queryWhere .= " AND";
                }
                $queryWhere .= " (w1.enabled = :enabled AND w2.enabled = :enabled)";
                $paramCount++;
            }

            if (!empty($searchCriteria["languageFrom"]) && !empty($searchCriteria["languageTo"])) {
                if ($paramCount > 0) {
                    $queryWhere .= " AND";
                }
                $queryWhere .= " (
                    (l1.id = :languageFrom AND l2.id = :languageTo) OR
                    (l1.id = :languageTo AND l2.id = :languageFrom)
                )";
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
        if (!empty($searchCriteria["word"])) {
            $valueParam = '%' . $searchCriteria["word"] . '%';
            $stmt->bindParam(":word1", $valueParam);
            $stmt->bindParam(":word2", $valueParam);
        }
        if (!empty($searchCriteria["exactWord"])) {
            $valueParam = $searchCriteria["exactWord"];
            $stmt->bindParam(":exactWord1", $valueParam);
            $stmt->bindParam(":exactWord2", $valueParam);
        }
        if (!empty($searchCriteria["languageId"])) {
            $stmt->bindParam(":language1Id", $searchCriteria["languageId"], PDO::PARAM_INT);
            $stmt->bindParam(":language2Id", $searchCriteria["languageId"], PDO::PARAM_INT);
        }
        if (!empty($searchCriteria["wordId"])) {
            $stmt->bindParam(":word1Id", $searchCriteria["wordId"], PDO::PARAM_INT);
            $stmt->bindParam(":word2Id", $searchCriteria["wordId"], PDO::PARAM_INT);
        }
        if (!empty($searchCriteria["accountId"])) {
            $stmt->bindParam(":accountId", $searchCriteria["accountId"], PDO::PARAM_INT);
        }
        if (!empty($searchCriteria["phrases"])) {
            $stmt->bindParam(":phrases", $searchCriteria["phrases"], PDO::PARAM_BOOL);
        }
        if (!empty($searchCriteria["enabled"])) {
            $stmt->bindParam(":enabled", $searchCriteria["enabled"], PDO::PARAM_BOOL);
        }
        if (!empty($searchCriteria["languageFrom"]) && !empty($searchCriteria["languageTo"])) {
            $stmt->bindParam(":languageFrom", $searchCriteria["languageFrom"], PDO::PARAM_INT);
            $stmt->bindParam(":languageTo", $searchCriteria["languageTo"], PDO::PARAM_INT);
        }

        return $stmt;
    }

    /**
     * Finds all relevant entries, ignoring limits. Ugly hack for test stats update!
     * @param array $searchCriteria Search criteria constraint.
     */
    public function findTestEvalEntries($searchCriteria) {
        $query = "SELECT
            l.id,
            l.date_added,
            l.last_modification_date,
            l.streak,
            l.prioritized,
            l.known,
            w.language_id,
            w.value
            FROM links AS l
            INNER JOIN words AS w
            ON l.word1_id = w.id OR l.word2_id = w.id
            WHERE w.language_id = :languageId AND w.value = :value AND w.account_id = :accountId";

        $languageId = $searchCriteria["languageId"];
        $wordValue = $searchCriteria["exactWord"];
        $accountId = $searchCriteria["accountId"];

        $links = [];

        try {
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(":languageId", $languageId, PDO::PARAM_INT);
            $stmt->bindParam(":value", $wordValue);
            $stmt->bindParam(":accountId", $accountId, PDO::PARAM_INT);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);

            // Parses the dataset into a PHP array.
            while($row = $stmt->fetch()) {
                $link = $this->emm->getLinkMapper()->map($row);
                array_push($links, $link);
            }
        } catch (PDOException $e) {
            error_log($e->getMessage(), 0);
            Utility::gotoServerError();
        }

        return $links;
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
        $links = [];

        try {
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(":recordLimit", $recordLimit, PDO::PARAM_INT);
            $stmt->bindParam(":firstRecord", $firstRecord, PDO::PARAM_INT);
            $stmt = $this->bindSearchCriteria($stmt, $searchCriteria);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);

            // Parses the dataset into a PHP array.
            while($row = $stmt->fetch()) {
                $link = $this->emm->getLinkMapper()->map($row);
                array_push($links, $link);
            }
        } catch (PDOException $e) {
            error_log($e->getMessage(), 0);
            Utility::gotoServerError();
        }

        return $links;
    }

    /**
     * Retrieves randomly selected links that match given criteria.
     * @param int $from ID of the origin language.
     * @param int $to ID of the target language.
     * @param string $type One of the test types, as defined in the TestController.
     * @param int $amount Desired amount of translations to be generated.
     * @return array Array of links.
     */
    public function findTestLinks($recordLimit, $searchCriteria) {
        $query = $this->getSelect()
            . $this->getFrom()
            . $this->prepareSearchCriteria($searchCriteria)
            . $this->getGroupBy()
            . " ORDER BY random()"
            . " LIMIT :recordLimit";

        $links = [];

        try {
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(":recordLimit", $recordLimit, PDO::PARAM_INT);
            $stmt = $this->bindSearchCriteria($stmt, $searchCriteria);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);

            // Parses the dataset into a PHP array.
            while($row = $stmt->fetch()) {
                $link = $this->emm->getLinkMapper()->map($row);
                array_push($links, $link);
            }
        } catch (PDOException $e) {
            error_log($e->getMessage(), 0);
            Utility::gotoServerError();
        }

        return $links;
    }

    /**
     * Overriden method, documented in parent.
     */
    public function findCount($searchCriteria = null) {
        $query = "SELECT COUNT(li.id) AS rows"
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
    public function findById($linkId) {
        $query = $this->getSelect()
            . $this->getFrom()
            . " WHERE li.id = :linkId"
            . $this->getGroupBy()
            . " LIMIT 1";

        try {
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(":linkId", $linkId);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $link = $stmt->fetch();

            if (!$link) {
                return null;
            }

            $link = $this->emm->getLinkMapper()->map($link);

            return $link;
        } catch (PDOException $e) {
            error_log($e->getMessage(), 0);
            Utility::gotoServerError();
        }
    }

    /**
     * Sorts word IDs so that the word1 has lower id.
     * @param Link $link link object whose IDs have to be sorted.
     * @return Link provided link object with sorted IDs.
     */
    private function sortWordIds($link) {
        $tempId = null;

        if ($link->getWord1()->getId() > $link->getWord2()->getId()) {
            $tempId = $link->getWord1()->getId();

            $link->getWord1()->setId($link->getWord2()->getId());
            $link->getWord2()->setId($tempId);
        }

        return $link;
    }

    /**
     * Overriden method, documented in parent.
     */
    public function save($link) {
        $query = "INSERT INTO links
            (word1_id, word2_id, account_id)
            VALUES (:word1Id, :word2Id, :accountId) RETURNING id";

        try {
            $link = $this->sortWordIds($link);
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(":word1Id", $link->getWord1()->getId(), PDO::PARAM_INT);
            $stmt->bindParam(":word2Id", $link->getWord2()->getId(), PDO::PARAM_INT);
            $stmt->bindParam(":accountId", $link->getAccount()->getId(), PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchColumn();
        } catch (PDOException $e) {
            // Duplicate entry.
            if ($e->errorInfo[0] == 23505) {
                throw new DuplicateEntryException($e);
            }
            // Other type of error, default handling by redirecting to 500.
            error_log($e->getMessage(), 0);
            Utility::gotoServerError();
        }
    }

    /**
     * Overriden method, documented in parent.
     */
    public function merge($link) {
        $query = "UPDATE links SET
            streak = :streak,
            prioritized = :prioritized,
            known = :known
            WHERE id = :linkId";

        try {
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(":streak", $link->getStreak());
            $stmt->bindParam(":prioritized", $link->getPrioritized(), PDO::PARAM_BOOL);
            $stmt->bindParam(":known", $link->getKnown(), PDO::PARAM_BOOL);
            $stmt->bindParam(":linkId", $link->getId(), PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            error_log($e->getMessage(), 0);
            Utility::gotoServerError();
        }
    }

    /**
     * Overriden method, documented in parent.
     */
    public function remove($link) {
        $query = "DELETE FROM links WHERE id = :linkId";

        try {
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(":linkId", $link->getId());
            $stmt->execute();
        } catch (PDOException $e) {
            error_log($e->getMessage(), 0);
            Utility::gotoServerError();
        }
    }

    /**
     * Explicitly removes the word entries that are specified
     * in the provided Link instance. This transitively removes
     * all links these two words participate in.
     * @param Link $link instance of the Link entity to be removed.
     */
    public function removeWords($link) {
        $query = "DELETE FROM words WHERE id = :wordId";

        try {
            $this->dbh->beginTransaction();
            $stmt = $this->dbh->prepare($query);

            $stmt->bindParam(":wordId", $link->getWord1()->getId());
            $stmt->execute();

            $stmt->bindParam(":wordId", $link->getWord2()->getId());
            $stmt->execute();

            $this->dbh->commit();
        } catch (PDOException $e) {
            error_log($e->getMessage(), 0);
            Utility::gotoServerError();
        }
    }

    /**
     * Resets the priority of all links associated with the provided account ID.
     * @param int $accountId The account ID whose entries will be affected.
     */
    public function unprioritize($accountId) {
        $query = "UPDATE links SET
            prioritized = false,
            streak = 0
            WHERE account_id = :accountId";

        try {
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(":accountId", $accountId, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            error_log($e->getMessage(), 0);
            Utility::gotoServerError();
        }
    }

    /**
     * Sets all links associated with the provided account ID to unknown.
     * @param int $accountId The account ID whose entries will be affected.
     */
    public function setUnknown($accountId) {
        $query = "UPDATE links SET known = false WHERE account_id = :accountId";

        try {
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(":accountId", $accountId, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            error_log($e->getMessage(), 0);
            Utility::gotoServerError();
        }
    }
}
