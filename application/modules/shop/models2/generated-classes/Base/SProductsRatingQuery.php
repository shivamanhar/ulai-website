<?php

namespace Base;

use \SProductsRating as ChildSProductsRating;
use \SProductsRatingQuery as ChildSProductsRatingQuery;
use \Exception;
use \PDO;
use Map\SProductsRatingTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'shop_products_rating' table.
 *
 *
 *
 * @method     ChildSProductsRatingQuery orderByProductId($order = Criteria::ASC) Order by the product_id column
 * @method     ChildSProductsRatingQuery orderByVotes($order = Criteria::ASC) Order by the votes column
 * @method     ChildSProductsRatingQuery orderByRating($order = Criteria::ASC) Order by the rating column
 *
 * @method     ChildSProductsRatingQuery groupByProductId() Group by the product_id column
 * @method     ChildSProductsRatingQuery groupByVotes() Group by the votes column
 * @method     ChildSProductsRatingQuery groupByRating() Group by the rating column
 *
 * @method     ChildSProductsRatingQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildSProductsRatingQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildSProductsRatingQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildSProductsRatingQuery leftJoinSProducts($relationAlias = null) Adds a LEFT JOIN clause to the query using the SProducts relation
 * @method     ChildSProductsRatingQuery rightJoinSProducts($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SProducts relation
 * @method     ChildSProductsRatingQuery innerJoinSProducts($relationAlias = null) Adds a INNER JOIN clause to the query using the SProducts relation
 *
 * @method     \SProductsQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildSProductsRating findOne(ConnectionInterface $con = null) Return the first ChildSProductsRating matching the query
 * @method     ChildSProductsRating findOneOrCreate(ConnectionInterface $con = null) Return the first ChildSProductsRating matching the query, or a new ChildSProductsRating object populated from the query conditions when no match is found
 *
 * @method     ChildSProductsRating findOneByProductId(int $product_id) Return the first ChildSProductsRating filtered by the product_id column
 * @method     ChildSProductsRating findOneByVotes(int $votes) Return the first ChildSProductsRating filtered by the votes column
 * @method     ChildSProductsRating findOneByRating(int $rating) Return the first ChildSProductsRating filtered by the rating column *

 * @method     ChildSProductsRating requirePk($key, ConnectionInterface $con = null) Return the ChildSProductsRating by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSProductsRating requireOne(ConnectionInterface $con = null) Return the first ChildSProductsRating matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSProductsRating requireOneByProductId(int $product_id) Return the first ChildSProductsRating filtered by the product_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSProductsRating requireOneByVotes(int $votes) Return the first ChildSProductsRating filtered by the votes column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSProductsRating requireOneByRating(int $rating) Return the first ChildSProductsRating filtered by the rating column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSProductsRating[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildSProductsRating objects based on current ModelCriteria
 * @method     ChildSProductsRating[]|ObjectCollection findByProductId(int $product_id) Return ChildSProductsRating objects filtered by the product_id column
 * @method     ChildSProductsRating[]|ObjectCollection findByVotes(int $votes) Return ChildSProductsRating objects filtered by the votes column
 * @method     ChildSProductsRating[]|ObjectCollection findByRating(int $rating) Return ChildSProductsRating objects filtered by the rating column
 * @method     ChildSProductsRating[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class SProductsRatingQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\SProductsRatingQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'Shop', $modelName = '\\SProductsRating', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildSProductsRatingQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildSProductsRatingQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildSProductsRatingQuery) {
            return $criteria;
        }
        $query = new ChildSProductsRatingQuery();
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
     * @return ChildSProductsRating|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = SProductsRatingTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(SProductsRatingTableMap::DATABASE_NAME);
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
     * @return ChildSProductsRating A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT product_id, votes, rating FROM shop_products_rating WHERE product_id = :p0';
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
            /** @var ChildSProductsRating $obj */
            $obj = new ChildSProductsRating();
            $obj->hydrate($row);
            SProductsRatingTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildSProductsRating|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildSProductsRatingQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(SProductsRatingTableMap::COL_PRODUCT_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildSProductsRatingQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(SProductsRatingTableMap::COL_PRODUCT_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the product_id column
     *
     * Example usage:
     * <code>
     * $query->filterByProductId(1234); // WHERE product_id = 1234
     * $query->filterByProductId(array(12, 34)); // WHERE product_id IN (12, 34)
     * $query->filterByProductId(array('min' => 12)); // WHERE product_id > 12
     * </code>
     *
     * @see       filterBySProducts()
     *
     * @param     mixed $productId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSProductsRatingQuery The current query, for fluid interface
     */
    public function filterByProductId($productId = null, $comparison = null)
    {
        if (is_array($productId)) {
            $useMinMax = false;
            if (isset($productId['min'])) {
                $this->addUsingAlias(SProductsRatingTableMap::COL_PRODUCT_ID, $productId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($productId['max'])) {
                $this->addUsingAlias(SProductsRatingTableMap::COL_PRODUCT_ID, $productId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SProductsRatingTableMap::COL_PRODUCT_ID, $productId, $comparison);
    }

    /**
     * Filter the query on the votes column
     *
     * Example usage:
     * <code>
     * $query->filterByVotes(1234); // WHERE votes = 1234
     * $query->filterByVotes(array(12, 34)); // WHERE votes IN (12, 34)
     * $query->filterByVotes(array('min' => 12)); // WHERE votes > 12
     * </code>
     *
     * @param     mixed $votes The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSProductsRatingQuery The current query, for fluid interface
     */
    public function filterByVotes($votes = null, $comparison = null)
    {
        if (is_array($votes)) {
            $useMinMax = false;
            if (isset($votes['min'])) {
                $this->addUsingAlias(SProductsRatingTableMap::COL_VOTES, $votes['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($votes['max'])) {
                $this->addUsingAlias(SProductsRatingTableMap::COL_VOTES, $votes['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SProductsRatingTableMap::COL_VOTES, $votes, $comparison);
    }

    /**
     * Filter the query on the rating column
     *
     * Example usage:
     * <code>
     * $query->filterByRating(1234); // WHERE rating = 1234
     * $query->filterByRating(array(12, 34)); // WHERE rating IN (12, 34)
     * $query->filterByRating(array('min' => 12)); // WHERE rating > 12
     * </code>
     *
     * @param     mixed $rating The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSProductsRatingQuery The current query, for fluid interface
     */
    public function filterByRating($rating = null, $comparison = null)
    {
        if (is_array($rating)) {
            $useMinMax = false;
            if (isset($rating['min'])) {
                $this->addUsingAlias(SProductsRatingTableMap::COL_RATING, $rating['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($rating['max'])) {
                $this->addUsingAlias(SProductsRatingTableMap::COL_RATING, $rating['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SProductsRatingTableMap::COL_RATING, $rating, $comparison);
    }

    /**
     * Filter the query by a related \SProducts object
     *
     * @param \SProducts|ObjectCollection $sProducts The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildSProductsRatingQuery The current query, for fluid interface
     */
    public function filterBySProducts($sProducts, $comparison = null)
    {
        if ($sProducts instanceof \SProducts) {
            return $this
                ->addUsingAlias(SProductsRatingTableMap::COL_PRODUCT_ID, $sProducts->getId(), $comparison);
        } elseif ($sProducts instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(SProductsRatingTableMap::COL_PRODUCT_ID, $sProducts->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterBySProducts() only accepts arguments of type \SProducts or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the SProducts relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSProductsRatingQuery The current query, for fluid interface
     */
    public function joinSProducts($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('SProducts');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'SProducts');
        }

        return $this;
    }

    /**
     * Use the SProducts relation SProducts object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \SProductsQuery A secondary query class using the current class as primary query
     */
    public function useSProductsQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinSProducts($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'SProducts', '\SProductsQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildSProductsRating $sProductsRating Object to remove from the list of results
     *
     * @return $this|ChildSProductsRatingQuery The current query, for fluid interface
     */
    public function prune($sProductsRating = null)
    {
        if ($sProductsRating) {
            $this->addUsingAlias(SProductsRatingTableMap::COL_PRODUCT_ID, $sProductsRating->getProductId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the shop_products_rating table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SProductsRatingTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            SProductsRatingTableMap::clearInstancePool();
            SProductsRatingTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(SProductsRatingTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(SProductsRatingTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            SProductsRatingTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            SProductsRatingTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // SProductsRatingQuery
