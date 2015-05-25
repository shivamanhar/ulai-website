<?php

namespace Base;

use \ShopComulativ as ChildShopComulativ;
use \ShopComulativQuery as ChildShopComulativQuery;
use \Exception;
use \PDO;
use Map\ShopComulativTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'shop_comulativ_discount' table.
 *
 *
 *
 * @method     ChildShopComulativQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildShopComulativQuery orderByDescription($order = Criteria::ASC) Order by the description column
 * @method     ChildShopComulativQuery orderByDiscount($order = Criteria::ASC) Order by the discount column
 * @method     ChildShopComulativQuery orderByActive($order = Criteria::ASC) Order by the active column
 * @method     ChildShopComulativQuery orderByDate($order = Criteria::ASC) Order by the date column
 * @method     ChildShopComulativQuery orderByTotal($order = Criteria::ASC) Order by the total column
 * @method     ChildShopComulativQuery orderByTotalA($order = Criteria::ASC) Order by the total_a column
 *
 * @method     ChildShopComulativQuery groupById() Group by the id column
 * @method     ChildShopComulativQuery groupByDescription() Group by the description column
 * @method     ChildShopComulativQuery groupByDiscount() Group by the discount column
 * @method     ChildShopComulativQuery groupByActive() Group by the active column
 * @method     ChildShopComulativQuery groupByDate() Group by the date column
 * @method     ChildShopComulativQuery groupByTotal() Group by the total column
 * @method     ChildShopComulativQuery groupByTotalA() Group by the total_a column
 *
 * @method     ChildShopComulativQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildShopComulativQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildShopComulativQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildShopComulativ findOne(ConnectionInterface $con = null) Return the first ChildShopComulativ matching the query
 * @method     ChildShopComulativ findOneOrCreate(ConnectionInterface $con = null) Return the first ChildShopComulativ matching the query, or a new ChildShopComulativ object populated from the query conditions when no match is found
 *
 * @method     ChildShopComulativ findOneById(int $id) Return the first ChildShopComulativ filtered by the id column
 * @method     ChildShopComulativ findOneByDescription(string $description) Return the first ChildShopComulativ filtered by the description column
 * @method     ChildShopComulativ findOneByDiscount(int $discount) Return the first ChildShopComulativ filtered by the discount column
 * @method     ChildShopComulativ findOneByActive(int $active) Return the first ChildShopComulativ filtered by the active column
 * @method     ChildShopComulativ findOneByDate(int $date) Return the first ChildShopComulativ filtered by the date column
 * @method     ChildShopComulativ findOneByTotal(int $total) Return the first ChildShopComulativ filtered by the total column
 * @method     ChildShopComulativ findOneByTotalA(int $total_a) Return the first ChildShopComulativ filtered by the total_a column *

 * @method     ChildShopComulativ requirePk($key, ConnectionInterface $con = null) Return the ChildShopComulativ by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildShopComulativ requireOne(ConnectionInterface $con = null) Return the first ChildShopComulativ matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildShopComulativ requireOneById(int $id) Return the first ChildShopComulativ filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildShopComulativ requireOneByDescription(string $description) Return the first ChildShopComulativ filtered by the description column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildShopComulativ requireOneByDiscount(int $discount) Return the first ChildShopComulativ filtered by the discount column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildShopComulativ requireOneByActive(int $active) Return the first ChildShopComulativ filtered by the active column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildShopComulativ requireOneByDate(int $date) Return the first ChildShopComulativ filtered by the date column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildShopComulativ requireOneByTotal(int $total) Return the first ChildShopComulativ filtered by the total column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildShopComulativ requireOneByTotalA(int $total_a) Return the first ChildShopComulativ filtered by the total_a column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildShopComulativ[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildShopComulativ objects based on current ModelCriteria
 * @method     ChildShopComulativ[]|ObjectCollection findById(int $id) Return ChildShopComulativ objects filtered by the id column
 * @method     ChildShopComulativ[]|ObjectCollection findByDescription(string $description) Return ChildShopComulativ objects filtered by the description column
 * @method     ChildShopComulativ[]|ObjectCollection findByDiscount(int $discount) Return ChildShopComulativ objects filtered by the discount column
 * @method     ChildShopComulativ[]|ObjectCollection findByActive(int $active) Return ChildShopComulativ objects filtered by the active column
 * @method     ChildShopComulativ[]|ObjectCollection findByDate(int $date) Return ChildShopComulativ objects filtered by the date column
 * @method     ChildShopComulativ[]|ObjectCollection findByTotal(int $total) Return ChildShopComulativ objects filtered by the total column
 * @method     ChildShopComulativ[]|ObjectCollection findByTotalA(int $total_a) Return ChildShopComulativ objects filtered by the total_a column
 * @method     ChildShopComulativ[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class ShopComulativQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\ShopComulativQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'Shop', $modelName = '\\ShopComulativ', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildShopComulativQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildShopComulativQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildShopComulativQuery) {
            return $criteria;
        }
        $query = new ChildShopComulativQuery();
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
     * @return ChildShopComulativ|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ShopComulativTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ShopComulativTableMap::DATABASE_NAME);
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
     * @return ChildShopComulativ A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, description, discount, active, date, total, total_a FROM shop_comulativ_discount WHERE id = :p0';
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
            /** @var ChildShopComulativ $obj */
            $obj = new ChildShopComulativ();
            $obj->hydrate($row);
            ShopComulativTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildShopComulativ|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildShopComulativQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ShopComulativTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildShopComulativQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ShopComulativTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildShopComulativQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(ShopComulativTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(ShopComulativTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ShopComulativTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the description column
     *
     * Example usage:
     * <code>
     * $query->filterByDescription('fooValue');   // WHERE description = 'fooValue'
     * $query->filterByDescription('%fooValue%'); // WHERE description LIKE '%fooValue%'
     * </code>
     *
     * @param     string $description The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildShopComulativQuery The current query, for fluid interface
     */
    public function filterByDescription($description = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($description)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $description)) {
                $description = str_replace('*', '%', $description);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ShopComulativTableMap::COL_DESCRIPTION, $description, $comparison);
    }

    /**
     * Filter the query on the discount column
     *
     * Example usage:
     * <code>
     * $query->filterByDiscount(1234); // WHERE discount = 1234
     * $query->filterByDiscount(array(12, 34)); // WHERE discount IN (12, 34)
     * $query->filterByDiscount(array('min' => 12)); // WHERE discount > 12
     * </code>
     *
     * @param     mixed $discount The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildShopComulativQuery The current query, for fluid interface
     */
    public function filterByDiscount($discount = null, $comparison = null)
    {
        if (is_array($discount)) {
            $useMinMax = false;
            if (isset($discount['min'])) {
                $this->addUsingAlias(ShopComulativTableMap::COL_DISCOUNT, $discount['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($discount['max'])) {
                $this->addUsingAlias(ShopComulativTableMap::COL_DISCOUNT, $discount['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ShopComulativTableMap::COL_DISCOUNT, $discount, $comparison);
    }

    /**
     * Filter the query on the active column
     *
     * Example usage:
     * <code>
     * $query->filterByActive(1234); // WHERE active = 1234
     * $query->filterByActive(array(12, 34)); // WHERE active IN (12, 34)
     * $query->filterByActive(array('min' => 12)); // WHERE active > 12
     * </code>
     *
     * @param     mixed $active The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildShopComulativQuery The current query, for fluid interface
     */
    public function filterByActive($active = null, $comparison = null)
    {
        if (is_array($active)) {
            $useMinMax = false;
            if (isset($active['min'])) {
                $this->addUsingAlias(ShopComulativTableMap::COL_ACTIVE, $active['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($active['max'])) {
                $this->addUsingAlias(ShopComulativTableMap::COL_ACTIVE, $active['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ShopComulativTableMap::COL_ACTIVE, $active, $comparison);
    }

    /**
     * Filter the query on the date column
     *
     * Example usage:
     * <code>
     * $query->filterByDate(1234); // WHERE date = 1234
     * $query->filterByDate(array(12, 34)); // WHERE date IN (12, 34)
     * $query->filterByDate(array('min' => 12)); // WHERE date > 12
     * </code>
     *
     * @param     mixed $date The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildShopComulativQuery The current query, for fluid interface
     */
    public function filterByDate($date = null, $comparison = null)
    {
        if (is_array($date)) {
            $useMinMax = false;
            if (isset($date['min'])) {
                $this->addUsingAlias(ShopComulativTableMap::COL_DATE, $date['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($date['max'])) {
                $this->addUsingAlias(ShopComulativTableMap::COL_DATE, $date['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ShopComulativTableMap::COL_DATE, $date, $comparison);
    }

    /**
     * Filter the query on the total column
     *
     * Example usage:
     * <code>
     * $query->filterByTotal(1234); // WHERE total = 1234
     * $query->filterByTotal(array(12, 34)); // WHERE total IN (12, 34)
     * $query->filterByTotal(array('min' => 12)); // WHERE total > 12
     * </code>
     *
     * @param     mixed $total The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildShopComulativQuery The current query, for fluid interface
     */
    public function filterByTotal($total = null, $comparison = null)
    {
        if (is_array($total)) {
            $useMinMax = false;
            if (isset($total['min'])) {
                $this->addUsingAlias(ShopComulativTableMap::COL_TOTAL, $total['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($total['max'])) {
                $this->addUsingAlias(ShopComulativTableMap::COL_TOTAL, $total['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ShopComulativTableMap::COL_TOTAL, $total, $comparison);
    }

    /**
     * Filter the query on the total_a column
     *
     * Example usage:
     * <code>
     * $query->filterByTotalA(1234); // WHERE total_a = 1234
     * $query->filterByTotalA(array(12, 34)); // WHERE total_a IN (12, 34)
     * $query->filterByTotalA(array('min' => 12)); // WHERE total_a > 12
     * </code>
     *
     * @param     mixed $totalA The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildShopComulativQuery The current query, for fluid interface
     */
    public function filterByTotalA($totalA = null, $comparison = null)
    {
        if (is_array($totalA)) {
            $useMinMax = false;
            if (isset($totalA['min'])) {
                $this->addUsingAlias(ShopComulativTableMap::COL_TOTAL_A, $totalA['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($totalA['max'])) {
                $this->addUsingAlias(ShopComulativTableMap::COL_TOTAL_A, $totalA['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ShopComulativTableMap::COL_TOTAL_A, $totalA, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildShopComulativ $shopComulativ Object to remove from the list of results
     *
     * @return $this|ChildShopComulativQuery The current query, for fluid interface
     */
    public function prune($shopComulativ = null)
    {
        if ($shopComulativ) {
            $this->addUsingAlias(ShopComulativTableMap::COL_ID, $shopComulativ->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the shop_comulativ_discount table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ShopComulativTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ShopComulativTableMap::clearInstancePool();
            ShopComulativTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(ShopComulativTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ShopComulativTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            ShopComulativTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            ShopComulativTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // ShopComulativQuery
