<?php

namespace io\schupke\sanasto\core\repository;

/**
 * Parent of every repository class used in the application.
 * Provides the database handler instance and forces the override
 * of manadatory methods.
 */
abstract class AbstractRepository {
    protected $rm;
    protected $dbh;
    protected $emm;

    function __construct(RepositoryManager $rm) {
        $this->rm = $rm;
        $this->dbh = $rm->getDbh();
        $this->emm = $rm->getEmm();
    }

    /**
     * @return string standard select part of the query
     * in compliance with the model structure.
     */
    protected abstract function getSelect();

    /**
     * @return string standard from/join part of the query
     * for given repository.
     */
    protected abstract function getFrom();

    /**
     * @return string standard group-by part of the query
     * in compliance with the select part.
     */
    protected abstract function getGroupBy();

    /**
     * @param array $searchCriteria array of search criteria
     * based on which the string will be created.
     * Constains $searchCriteria["orderBy"] and $searchCriteria["order"] elements.
     * @return string standard order-by part of the query
     * in compliance with the select part.
     */
    protected abstract function getOrderBy($searchCriteria);

    /**
     * Prepares the WHERE clause for the PDO statement
     * based on provided search criteria.
     * @param array $searchCriteria array of search criteria
     * based on which the string will be created.
     * @return string a string representing the WHERE clause
     * or null, if there are no criteria.
     */
    protected abstract function prepareSearchCriteria($searchCriteria);

    /**
     * Executes parameter binding into the prepared query string.
     * @param PDOStatement $stmt a PDO statement containing prepared query.
     * @param array $searchCriteria criteria parameters to be bound.
     * @return PDOStatement the provided statement with bound parameters. Never null.
     */
    protected abstract function bindSearchCriteria($stmt, $searchCriteria);

    /**
     * Returns a 2D array of all elements within range.
     * Foreign key id values are replaced with respective names.
     * If not parameters are provided, default values are selected.
     * @param int $page starting page, default 1.
     * @param int $recordLimit results per page, default based on config.
     * @param array $searchCriteria an array of criteria based on which
     * to filter the query.
     * @return array array of selected entities.
     */
    public abstract function findAll($page, $recordLimit, $searchCriteria);

    /**
     * Provides total amount of elements in the database.
     * @param array $searchCriteria an array of criteria based on which
     * to filter the query.
     * @return int amount of elements in the database. Never null.
     */
    public abstract function findCount($searchCriteria = null);

    /**
     * Finds one entity record based on provided id.
     * @param int $id entry id.
     * @return E an instance of the entity if found, false otherwise.
     */
    public abstract function findById($id);

    /**
     * Creates a new record in the database.
     * @param E $entity instance of the entity to be persisted.
     * @throws DuplicateEntryException in case of any duplicate errors.
     * @return int id of the saved entry.
     */
    public abstract function save($entity);

    /**
     * Updates the database data to reflect the state of provided entity,
     * based on its id.
     * @param E $entity instance of the entity to be updated.
     */
    public abstract function merge($entity);

    /**
     * Removes the record from the database.
     * @param E $entity an instance of the entity to be removed.
     */
    public abstract function remove($entity);
}
