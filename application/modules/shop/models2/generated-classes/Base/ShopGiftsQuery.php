<?php

namespace Base;

use \ShopGifts as ChildShopGifts;
use \ShopGiftsQuery as ChildShopGiftsQuery;
use \Exception;
use \PDO;
use Map\ShopGiftsTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'shop_gifts' table.
 *
 *
 *
 * @method     ChildShopGiftsQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildShopGiftsQuery orderByKey($order = Criteria::ASC) Order by the gift_key column
 * @method     ChildShopGiftsQuery orderByActive($order = Criteria::ASC) Order by the active column
 * @method     ChildShopGiftsQuery orderByPrice($order = Criteria::ASC) Order by the price column
 * @method     ChildShopGiftsQuery orderByCreated($order = Criteria::ASC) Order by the created column
 * @method     ChildShopGiftsQuery orderByEspdate($order = Criteria::ASC) Order by the espdate column
 *
 * @method     ChildShopGiftsQuery groupById() Group by the id column
 * @method     ChildShopGiftsQuery groupByKey() Group by the gift_key column
 * @method     ChildShopGiftsQuery groupByActive() Group by the active column
 * @method     ChildShopGiftsQuery groupByPrice() Group by the price column
 * @method     ChildShopGiftsQuery groupByCreated() Group by the created column
 * @method     ChildShopGiftsQuery groupByEspdate() Group by the espdate column
 *
 * @method     ChildShopGiftsQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildShopGiftsQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildShopGiftsQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildShopGifts findOne(ConnectionInterface $con = null) Return the first ChildShopGifts matching the query
 * @method     ChildShopGifts findOneOrCreate(ConnectionInterface $con = null) Return the first ChildShopGifts matching the query, or a new ChildShopGifts object populated from the query conditions when no match is found
 *
 * @method     ChildShopGifts findOneById(int $id) Return the first ChildShopGifts filtered by the id column
 * @method     ChildShopGifts findOneByKey(string $gift_key) Return the first ChildShopGifts filtered by the gift_key column
 * @method     ChildShopGifts findOneByActive(int $active) Return the first ChildShopGifts filtered by the active column
 * @method     ChildShopGifts findOneByPrice(int $price) Return the first ChildShopGifts filtered by the price column
 * @method     ChildShopGifts findOneByCreated(int $created) Return the first ChildShopGifts filtered by the created column
 * @method     ChildShopGifts findOneByEspdate(int $espdate) Return the first ChildShopGifts filtered by the espdate column *

 * @method     ChildShopGifts requirePk($key, ConnectionInterface $con = null) Return the ChildShopGifts by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildShopGifts requireOne(ConnectionInterface $con = null) Return the first ChildShopGifts matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildShopGifts requireOneById(int $id) Return the first ChildShopGifts filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildShopGifts requireOneByKey(string $gift_key) Return the first ChildShopGifts filtered by the gift_key column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildShopGifts requireOneByActive(int $active) Return the first ChildShopGifts filtered by the active column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildShopGifts requireOneByPrice(int $price) Return the first ChildShopGifts filtered by the price column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildShopGifts requireOneByCreated(int $created) Return the first ChildShopGifts filtered by the created column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildShopGifts requireOneByEspdate(int $espdate) Return the first ChildShopGifts filtered by the espdate column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildShopGifts[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildShopGifts objects based on current ModelCriteria
 * @method     ChildShopGifts[]|ObjectCollection findById(int $id) Return ChildShopGifts objects filtered by the id column
 * @method     ChildShopGifts[]|ObjectCollection findByKey(string $gift_key) Return ChildShopGifts objects filtered by the gift_key column
 * @method     ChildShopGifts[]|ObjectCollection findByActive(int $active) Return ChildShopGifts objects filtered by the active column
 * @method     ChildShopGifts[]|ObjectCollection findByPrice(int $price) Return ChildShopGifts objects filtered by the price column
 * @method     ChildShopGifts[]|ObjectCollection findByCreated(int $created) Return ChildShopGifts objects filtered by the created column
 * @method     ChildShopGifts[]|ObjectCollection findByEspdate(int $espdate) Return ChildShopGifts objects filtered by the espdate column
 * @method     ChildShopGifts[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class ShopGiftsQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\ShopGiftsQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'Shop', $modelName = '\\ShopGifts', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildShopGiftsQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildShopGiftsQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildShopGiftsQuery) {
            return $criteria;
        }
        $query = new ChildShopGiftsQuery();
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
     * @return ChildShopGifts|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ShopGiftsTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ShopGiftsTableMap::DATABASE_NAME);
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
     * @return ChildShopGifts A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, gift_key, active, price, created, espdate FROM shop_gifts WHERE id = :p0';
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
            /** @var ChildShopGifts $obj */
            $obj = new ChildShopGifts();
            $obj->hydrate($row);
            ShopGiftsTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildShopGifts|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildShopGiftsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ShopGiftsTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildShopGiftsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ShopGiftsTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildShopGiftsQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(ShopGiftsTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(ShopGiftsTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ShopGiftsTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the gift_key column
     *
     * Example usage:
     * <code>
     * $query->filterByKey('fooValue');   // WHERE gift_key = 'fooValue'
     * $query->filterByKey('%fooValue%'); // WHERE gift_key LIKE '%fooValue%'
     * </code>
     *
     * @param     string $key The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildShopGiftsQuery The current query, for fluid interface
     */
    public function filterByKey($key = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($key)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $key)) {
                $key = str_replace('*', '%', $key);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ShopGiftsTableMap::COL_GIFT_KEY, $key, $comparison);
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
     * @return $this|ChildShopGiftsQuery The current query, for fluid interface
     */
    public function filterByActive($active = null, $comparison = null)
    {
        if (is_array($active)) {
            $useMinMax = false;
            if (isset($active['min'])) {
                $this->addUsingAlias(ShopGiftsTableMap::COL_ACTIVE, $active['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($active['max'])) {
                $this->addUsingAlias(ShopGiftsTableMap::COL_ACTIVE, $active['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ShopGiftsTableMap::COL_ACTIVE, $active, $comparison);
    }

    /**
     * Filter the query on the price column
     *
     * Example usage:
     * <code>
     * $query->filterByPrice(1234); // WHERE price = 1234
     * $query->filterByPrice(array(12, 34)); // WHERE price IN (12, 34)
     * $query->filterByPrice(array('min' => 12)); // WHERE price > 12
     * </code>
     *
     * @param     mixed $price The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildShopGiftsQuery The current query, for fluid interface
     */
    public function filterByPrice($price = null, $comparison = null)
    {
        if (is_array($price)) {
            $useMinMax = false;
            if (isset($price['min'])) {
                $this->addUsingAlias(ShopGiftsTableMap::COL_PRICE, $price['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($price['max'])) {
                $this->addUsingAlias(ShopGiftsTableMap::COL_PRICE, $price['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ShopGiftsTableMap::COL_PRICE, $price, $comparison);
    }

    /**
     * Filter the query on the created column
     *
     * Example usage:
     * <code>
     * $query->filterByCreated(1234); // WHERE created = 1234
     * $query->filterByCreated(array(12, 34)); // WHERE created IN (12, 34)
     * $query->filterByCreated(array('min' => 12)); // WHERE created > 12
     * </code>
     *
     * @param     mixed $created The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildShopGiftsQuery The current query, for fluid interface
     */
    public function filterByCreated($created = null, $comparison = null)
    {
        if (is_array($created)) {
            $useMinMax = false;
            if (isset($created['min'])) {
                $this->addUsingAlias(ShopGiftsTableMap::COL_CREATED, $created['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($created['max'])) {
                $this->addUsingAlias(ShopGiftsTableMap::COL_CREATED, $created['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ShopGiftsTableMap::COL_CREATED, $created, $comparison);
    }

    /**
     * Filter the query on the espdate column
     *
     * Example usage:
     * <code>
     * $query->filterByEspdate(1234); // WHERE espdate = 1234
     * $query->filterByEspdate(array(12, 34)); // WHERE espdate IN (12, 34)
     * $query->filterByEspdate(array('min' => 12)); // WHERE espdate > 12
     * </code>
     *
     * @param     mixed $espdate The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildShopGiftsQuery The current query, for fluid interface
     */
    public function filterByEspdate($espdate = null, $comparison = null)
    {
        if (is_array($espdate)) {
            $useMinMax = false;
            if (isset($espdate['min'])) {
                $this->addUsingAlias(ShopGiftsTableMap::COL_ESPDATE, $espdate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($espdate['max'])) {
                $this->addUsingAlias(ShopGiftsTableMap::COL_ESPDATE, $espdate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ShopGiftsTableMap::COL_ESPDATE, $espdate, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildShopGifts $shopGifts Object to remove from the list of results
     *
     * @return $this|ChildShopGiftsQuery The current query, for fluid interface
     */
    public function prune($shopGifts = null)
    {
        if ($shopGifts) {
            $this->addUsingAlias(ShopGiftsTableMap::COL_ID, $shopGifts->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the shop_gifts table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ShopGiftsTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ShopGiftsTableMap::clearInstancePool();
            ShopGiftsTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(ShopGiftsTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ShopGiftsTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            ShopGiftsTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            ShopGiftsTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // ShopGiftsQuery
