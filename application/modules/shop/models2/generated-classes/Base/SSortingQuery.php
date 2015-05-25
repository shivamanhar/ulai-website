<?php

namespace Base;

use \SSorting as ChildSSorting;
use \SSortingQuery as ChildSSortingQuery;
use \Exception;
use \PDO;
use Map\SSortingTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'shop_sorting' table.
 *
 *
 *
 * @method     ChildSSortingQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildSSortingQuery orderByPos($order = Criteria::ASC) Order by the pos column
 * @method     ChildSSortingQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method     ChildSSortingQuery orderByNameFront($order = Criteria::ASC) Order by the name_front column
 * @method     ChildSSortingQuery orderByTooltip($order = Criteria::ASC) Order by the tooltip column
 * @method     ChildSSortingQuery orderByGet($order = Criteria::ASC) Order by the get column
 * @method     ChildSSortingQuery orderByActive($order = Criteria::ASC) Order by the active column
 *
 * @method     ChildSSortingQuery groupById() Group by the id column
 * @method     ChildSSortingQuery groupByPos() Group by the pos column
 * @method     ChildSSortingQuery groupByName() Group by the name column
 * @method     ChildSSortingQuery groupByNameFront() Group by the name_front column
 * @method     ChildSSortingQuery groupByTooltip() Group by the tooltip column
 * @method     ChildSSortingQuery groupByGet() Group by the get column
 * @method     ChildSSortingQuery groupByActive() Group by the active column
 *
 * @method     ChildSSortingQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildSSortingQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildSSortingQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildSSorting findOne(ConnectionInterface $con = null) Return the first ChildSSorting matching the query
 * @method     ChildSSorting findOneOrCreate(ConnectionInterface $con = null) Return the first ChildSSorting matching the query, or a new ChildSSorting object populated from the query conditions when no match is found
 *
 * @method     ChildSSorting findOneById(int $id) Return the first ChildSSorting filtered by the id column
 * @method     ChildSSorting findOneByPos(int $pos) Return the first ChildSSorting filtered by the pos column
 * @method     ChildSSorting findOneByName(string $name) Return the first ChildSSorting filtered by the name column
 * @method     ChildSSorting findOneByNameFront(string $name_front) Return the first ChildSSorting filtered by the name_front column
 * @method     ChildSSorting findOneByTooltip(string $tooltip) Return the first ChildSSorting filtered by the tooltip column
 * @method     ChildSSorting findOneByGet(string $get) Return the first ChildSSorting filtered by the get column
 * @method     ChildSSorting findOneByActive(boolean $active) Return the first ChildSSorting filtered by the active column *

 * @method     ChildSSorting requirePk($key, ConnectionInterface $con = null) Return the ChildSSorting by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSSorting requireOne(ConnectionInterface $con = null) Return the first ChildSSorting matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSSorting requireOneById(int $id) Return the first ChildSSorting filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSSorting requireOneByPos(int $pos) Return the first ChildSSorting filtered by the pos column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSSorting requireOneByName(string $name) Return the first ChildSSorting filtered by the name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSSorting requireOneByNameFront(string $name_front) Return the first ChildSSorting filtered by the name_front column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSSorting requireOneByTooltip(string $tooltip) Return the first ChildSSorting filtered by the tooltip column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSSorting requireOneByGet(string $get) Return the first ChildSSorting filtered by the get column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSSorting requireOneByActive(boolean $active) Return the first ChildSSorting filtered by the active column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSSorting[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildSSorting objects based on current ModelCriteria
 * @method     ChildSSorting[]|ObjectCollection findById(int $id) Return ChildSSorting objects filtered by the id column
 * @method     ChildSSorting[]|ObjectCollection findByPos(int $pos) Return ChildSSorting objects filtered by the pos column
 * @method     ChildSSorting[]|ObjectCollection findByName(string $name) Return ChildSSorting objects filtered by the name column
 * @method     ChildSSorting[]|ObjectCollection findByNameFront(string $name_front) Return ChildSSorting objects filtered by the name_front column
 * @method     ChildSSorting[]|ObjectCollection findByTooltip(string $tooltip) Return ChildSSorting objects filtered by the tooltip column
 * @method     ChildSSorting[]|ObjectCollection findByGet(string $get) Return ChildSSorting objects filtered by the get column
 * @method     ChildSSorting[]|ObjectCollection findByActive(boolean $active) Return ChildSSorting objects filtered by the active column
 * @method     ChildSSorting[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class SSortingQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\SSortingQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'Shop', $modelName = '\\SSorting', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildSSortingQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildSSortingQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildSSortingQuery) {
            return $criteria;
        }
        $query = new ChildSSortingQuery();
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
     * @return ChildSSorting|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = SSortingTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(SSortingTableMap::DATABASE_NAME);
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
     * @return ChildSSorting A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, pos, name, name_front, tooltip, get, active FROM shop_sorting WHERE id = :p0';
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
            /** @var ChildSSorting $obj */
            $obj = new ChildSSorting();
            $obj->hydrate($row);
            SSortingTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildSSorting|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildSSortingQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(SSortingTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildSSortingQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(SSortingTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildSSortingQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(SSortingTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(SSortingTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SSortingTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the pos column
     *
     * Example usage:
     * <code>
     * $query->filterByPos(1234); // WHERE pos = 1234
     * $query->filterByPos(array(12, 34)); // WHERE pos IN (12, 34)
     * $query->filterByPos(array('min' => 12)); // WHERE pos > 12
     * </code>
     *
     * @param     mixed $pos The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSSortingQuery The current query, for fluid interface
     */
    public function filterByPos($pos = null, $comparison = null)
    {
        if (is_array($pos)) {
            $useMinMax = false;
            if (isset($pos['min'])) {
                $this->addUsingAlias(SSortingTableMap::COL_POS, $pos['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($pos['max'])) {
                $this->addUsingAlias(SSortingTableMap::COL_POS, $pos['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SSortingTableMap::COL_POS, $pos, $comparison);
    }

    /**
     * Filter the query on the name column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue');   // WHERE name = 'fooValue'
     * $query->filterByName('%fooValue%'); // WHERE name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $name The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSSortingQuery The current query, for fluid interface
     */
    public function filterByName($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $name)) {
                $name = str_replace('*', '%', $name);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SSortingTableMap::COL_NAME, $name, $comparison);
    }

    /**
     * Filter the query on the name_front column
     *
     * Example usage:
     * <code>
     * $query->filterByNameFront('fooValue');   // WHERE name_front = 'fooValue'
     * $query->filterByNameFront('%fooValue%'); // WHERE name_front LIKE '%fooValue%'
     * </code>
     *
     * @param     string $nameFront The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSSortingQuery The current query, for fluid interface
     */
    public function filterByNameFront($nameFront = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($nameFront)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $nameFront)) {
                $nameFront = str_replace('*', '%', $nameFront);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SSortingTableMap::COL_NAME_FRONT, $nameFront, $comparison);
    }

    /**
     * Filter the query on the tooltip column
     *
     * Example usage:
     * <code>
     * $query->filterByTooltip('fooValue');   // WHERE tooltip = 'fooValue'
     * $query->filterByTooltip('%fooValue%'); // WHERE tooltip LIKE '%fooValue%'
     * </code>
     *
     * @param     string $tooltip The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSSortingQuery The current query, for fluid interface
     */
    public function filterByTooltip($tooltip = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($tooltip)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $tooltip)) {
                $tooltip = str_replace('*', '%', $tooltip);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SSortingTableMap::COL_TOOLTIP, $tooltip, $comparison);
    }

    /**
     * Filter the query on the get column
     *
     * Example usage:
     * <code>
     * $query->filterByGet('fooValue');   // WHERE get = 'fooValue'
     * $query->filterByGet('%fooValue%'); // WHERE get LIKE '%fooValue%'
     * </code>
     *
     * @param     string $get The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSSortingQuery The current query, for fluid interface
     */
    public function filterByGet($get = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($get)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $get)) {
                $get = str_replace('*', '%', $get);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SSortingTableMap::COL_GET, $get, $comparison);
    }

    /**
     * Filter the query on the active column
     *
     * Example usage:
     * <code>
     * $query->filterByActive(true); // WHERE active = true
     * $query->filterByActive('yes'); // WHERE active = true
     * </code>
     *
     * @param     boolean|string $active The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSSortingQuery The current query, for fluid interface
     */
    public function filterByActive($active = null, $comparison = null)
    {
        if (is_string($active)) {
            $active = in_array(strtolower($active), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(SSortingTableMap::COL_ACTIVE, $active, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildSSorting $sSorting Object to remove from the list of results
     *
     * @return $this|ChildSSortingQuery The current query, for fluid interface
     */
    public function prune($sSorting = null)
    {
        if ($sSorting) {
            $this->addUsingAlias(SSortingTableMap::COL_ID, $sSorting->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the shop_sorting table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SSortingTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            SSortingTableMap::clearInstancePool();
            SSortingTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(SSortingTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(SSortingTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            SSortingTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            SSortingTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // SSortingQuery
