<?php

namespace Base;

use \CustomFieldsData as ChildCustomFieldsData;
use \CustomFieldsDataQuery as ChildCustomFieldsDataQuery;
use \Exception;
use \PDO;
use Map\CustomFieldsDataTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'custom_fields_data' table.
 *
 *
 *
 * @method     ChildCustomFieldsDataQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildCustomFieldsDataQuery orderByLocale($order = Criteria::ASC) Order by the locale column
 * @method     ChildCustomFieldsDataQuery orderByfieldId($order = Criteria::ASC) Order by the field_id column
 * @method     ChildCustomFieldsDataQuery orderByentityId($order = Criteria::ASC) Order by the entity_id column
 * @method     ChildCustomFieldsDataQuery orderBydata($order = Criteria::ASC) Order by the field_data column
 *
 * @method     ChildCustomFieldsDataQuery groupById() Group by the id column
 * @method     ChildCustomFieldsDataQuery groupByLocale() Group by the locale column
 * @method     ChildCustomFieldsDataQuery groupByfieldId() Group by the field_id column
 * @method     ChildCustomFieldsDataQuery groupByentityId() Group by the entity_id column
 * @method     ChildCustomFieldsDataQuery groupBydata() Group by the field_data column
 *
 * @method     ChildCustomFieldsDataQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildCustomFieldsDataQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildCustomFieldsDataQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildCustomFieldsData findOne(ConnectionInterface $con = null) Return the first ChildCustomFieldsData matching the query
 * @method     ChildCustomFieldsData findOneOrCreate(ConnectionInterface $con = null) Return the first ChildCustomFieldsData matching the query, or a new ChildCustomFieldsData object populated from the query conditions when no match is found
 *
 * @method     ChildCustomFieldsData findOneById(int $id) Return the first ChildCustomFieldsData filtered by the id column
 * @method     ChildCustomFieldsData findOneByLocale(string $locale) Return the first ChildCustomFieldsData filtered by the locale column
 * @method     ChildCustomFieldsData findOneByfieldId(int $field_id) Return the first ChildCustomFieldsData filtered by the field_id column
 * @method     ChildCustomFieldsData findOneByentityId(int $entity_id) Return the first ChildCustomFieldsData filtered by the entity_id column
 * @method     ChildCustomFieldsData findOneBydata(string $field_data) Return the first ChildCustomFieldsData filtered by the field_data column *

 * @method     ChildCustomFieldsData requirePk($key, ConnectionInterface $con = null) Return the ChildCustomFieldsData by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCustomFieldsData requireOne(ConnectionInterface $con = null) Return the first ChildCustomFieldsData matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildCustomFieldsData requireOneById(int $id) Return the first ChildCustomFieldsData filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCustomFieldsData requireOneByLocale(string $locale) Return the first ChildCustomFieldsData filtered by the locale column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCustomFieldsData requireOneByfieldId(int $field_id) Return the first ChildCustomFieldsData filtered by the field_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCustomFieldsData requireOneByentityId(int $entity_id) Return the first ChildCustomFieldsData filtered by the entity_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCustomFieldsData requireOneBydata(string $field_data) Return the first ChildCustomFieldsData filtered by the field_data column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildCustomFieldsData[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildCustomFieldsData objects based on current ModelCriteria
 * @method     ChildCustomFieldsData[]|ObjectCollection findById(int $id) Return ChildCustomFieldsData objects filtered by the id column
 * @method     ChildCustomFieldsData[]|ObjectCollection findByLocale(string $locale) Return ChildCustomFieldsData objects filtered by the locale column
 * @method     ChildCustomFieldsData[]|ObjectCollection findByfieldId(int $field_id) Return ChildCustomFieldsData objects filtered by the field_id column
 * @method     ChildCustomFieldsData[]|ObjectCollection findByentityId(int $entity_id) Return ChildCustomFieldsData objects filtered by the entity_id column
 * @method     ChildCustomFieldsData[]|ObjectCollection findBydata(string $field_data) Return ChildCustomFieldsData objects filtered by the field_data column
 * @method     ChildCustomFieldsData[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class CustomFieldsDataQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\CustomFieldsDataQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'Shop', $modelName = '\\CustomFieldsData', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildCustomFieldsDataQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildCustomFieldsDataQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildCustomFieldsDataQuery) {
            return $criteria;
        }
        $query = new ChildCustomFieldsDataQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildCustomFieldsData|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = CustomFieldsDataTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(CustomFieldsDataTableMap::DATABASE_NAME);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildCustomFieldsData A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, locale, field_id, entity_id, field_data FROM custom_fields_data WHERE id = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildCustomFieldsData $obj */
            $obj = new ChildCustomFieldsData();
            $obj->hydrate($row);
            CustomFieldsDataTableMap::addInstanceToPool($obj, (string) $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildCustomFieldsData|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, ConnectionInterface $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return $this|ChildCustomFieldsDataQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(CustomFieldsDataTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildCustomFieldsDataQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(CustomFieldsDataTableMap::COL_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id > 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCustomFieldsDataQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(CustomFieldsDataTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(CustomFieldsDataTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CustomFieldsDataTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the locale column
     *
     * Example usage:
     * <code>
     * $query->filterByLocale('fooValue');   // WHERE locale = 'fooValue'
     * $query->filterByLocale('%fooValue%'); // WHERE locale LIKE '%fooValue%'
     * </code>
     *
     * @param     string $locale The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCustomFieldsDataQuery The current query, for fluid interface
     */
    public function filterByLocale($locale = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($locale)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $locale)) {
                $locale = str_replace('*', '%', $locale);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CustomFieldsDataTableMap::COL_LOCALE, $locale, $comparison);
    }

    /**
     * Filter the query on the field_id column
     *
     * Example usage:
     * <code>
     * $query->filterByfieldId(1234); // WHERE field_id = 1234
     * $query->filterByfieldId(array(12, 34)); // WHERE field_id IN (12, 34)
     * $query->filterByfieldId(array('min' => 12)); // WHERE field_id > 12
     * </code>
     *
     * @param     mixed $fieldId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCustomFieldsDataQuery The current query, for fluid interface
     */
    public function filterByfieldId($fieldId = null, $comparison = null)
    {
        if (is_array($fieldId)) {
            $useMinMax = false;
            if (isset($fieldId['min'])) {
                $this->addUsingAlias(CustomFieldsDataTableMap::COL_FIELD_ID, $fieldId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($fieldId['max'])) {
                $this->addUsingAlias(CustomFieldsDataTableMap::COL_FIELD_ID, $fieldId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CustomFieldsDataTableMap::COL_FIELD_ID, $fieldId, $comparison);
    }

    /**
     * Filter the query on the entity_id column
     *
     * Example usage:
     * <code>
     * $query->filterByentityId(1234); // WHERE entity_id = 1234
     * $query->filterByentityId(array(12, 34)); // WHERE entity_id IN (12, 34)
     * $query->filterByentityId(array('min' => 12)); // WHERE entity_id > 12
     * </code>
     *
     * @param     mixed $entityId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCustomFieldsDataQuery The current query, for fluid interface
     */
    public function filterByentityId($entityId = null, $comparison = null)
    {
        if (is_array($entityId)) {
            $useMinMax = false;
            if (isset($entityId['min'])) {
                $this->addUsingAlias(CustomFieldsDataTableMap::COL_ENTITY_ID, $entityId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($entityId['max'])) {
                $this->addUsingAlias(CustomFieldsDataTableMap::COL_ENTITY_ID, $entityId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CustomFieldsDataTableMap::COL_ENTITY_ID, $entityId, $comparison);
    }

    /**
     * Filter the query on the field_data column
     *
     * Example usage:
     * <code>
     * $query->filterBydata('fooValue');   // WHERE field_data = 'fooValue'
     * $query->filterBydata('%fooValue%'); // WHERE field_data LIKE '%fooValue%'
     * </code>
     *
     * @param     string $data The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCustomFieldsDataQuery The current query, for fluid interface
     */
    public function filterBydata($data = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($data)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $data)) {
                $data = str_replace('*', '%', $data);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CustomFieldsDataTableMap::COL_FIELD_DATA, $data, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildCustomFieldsData $customFieldsData Object to remove from the list of results
     *
     * @return $this|ChildCustomFieldsDataQuery The current query, for fluid interface
     */
    public function prune($customFieldsData = null)
    {
        if ($customFieldsData) {
            $this->addUsingAlias(CustomFieldsDataTableMap::COL_ID, $customFieldsData->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the custom_fields_data table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CustomFieldsDataTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            CustomFieldsDataTableMap::clearInstancePool();
            CustomFieldsDataTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * Performs a DELETE on the database based on the current ModelCriteria
     *
     * @param ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public function delete(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CustomFieldsDataTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(CustomFieldsDataTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            CustomFieldsDataTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            CustomFieldsDataTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // CustomFieldsDataQuery
