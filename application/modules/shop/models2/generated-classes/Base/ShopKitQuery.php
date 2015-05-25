<?php

namespace Base;

use \ShopKit as ChildShopKit;
use \ShopKitQuery as ChildShopKitQuery;
use \Exception;
use \PDO;
use Map\ShopKitProductTableMap;
use Map\ShopKitTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'shop_kit' table.
 *
 *
 *
 * @method     ChildShopKitQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildShopKitQuery orderByProductId($order = Criteria::ASC) Order by the product_id column
 * @method     ChildShopKitQuery orderByActive($order = Criteria::ASC) Order by the active column
 * @method     ChildShopKitQuery orderByPosition($order = Criteria::ASC) Order by the position column
 * @method     ChildShopKitQuery orderByOnlyForLogged($order = Criteria::ASC) Order by the only_for_logged column
 *
 * @method     ChildShopKitQuery groupById() Group by the id column
 * @method     ChildShopKitQuery groupByProductId() Group by the product_id column
 * @method     ChildShopKitQuery groupByActive() Group by the active column
 * @method     ChildShopKitQuery groupByPosition() Group by the position column
 * @method     ChildShopKitQuery groupByOnlyForLogged() Group by the only_for_logged column
 *
 * @method     ChildShopKitQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildShopKitQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildShopKitQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildShopKitQuery leftJoinSProducts($relationAlias = null) Adds a LEFT JOIN clause to the query using the SProducts relation
 * @method     ChildShopKitQuery rightJoinSProducts($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SProducts relation
 * @method     ChildShopKitQuery innerJoinSProducts($relationAlias = null) Adds a INNER JOIN clause to the query using the SProducts relation
 *
 * @method     ChildShopKitQuery leftJoinShopKitProduct($relationAlias = null) Adds a LEFT JOIN clause to the query using the ShopKitProduct relation
 * @method     ChildShopKitQuery rightJoinShopKitProduct($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ShopKitProduct relation
 * @method     ChildShopKitQuery innerJoinShopKitProduct($relationAlias = null) Adds a INNER JOIN clause to the query using the ShopKitProduct relation
 *
 * @method     \SProductsQuery|\ShopKitProductQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildShopKit findOne(ConnectionInterface $con = null) Return the first ChildShopKit matching the query
 * @method     ChildShopKit findOneOrCreate(ConnectionInterface $con = null) Return the first ChildShopKit matching the query, or a new ChildShopKit object populated from the query conditions when no match is found
 *
 * @method     ChildShopKit findOneById(int $id) Return the first ChildShopKit filtered by the id column
 * @method     ChildShopKit findOneByProductId(int $product_id) Return the first ChildShopKit filtered by the product_id column
 * @method     ChildShopKit findOneByActive(boolean $active) Return the first ChildShopKit filtered by the active column
 * @method     ChildShopKit findOneByPosition(int $position) Return the first ChildShopKit filtered by the position column
 * @method     ChildShopKit findOneByOnlyForLogged(boolean $only_for_logged) Return the first ChildShopKit filtered by the only_for_logged column *

 * @method     ChildShopKit requirePk($key, ConnectionInterface $con = null) Return the ChildShopKit by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildShopKit requireOne(ConnectionInterface $con = null) Return the first ChildShopKit matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildShopKit requireOneById(int $id) Return the first ChildShopKit filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildShopKit requireOneByProductId(int $product_id) Return the first ChildShopKit filtered by the product_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildShopKit requireOneByActive(boolean $active) Return the first ChildShopKit filtered by the active column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildShopKit requireOneByPosition(int $position) Return the first ChildShopKit filtered by the position column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildShopKit requireOneByOnlyForLogged(boolean $only_for_logged) Return the first ChildShopKit filtered by the only_for_logged column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildShopKit[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildShopKit objects based on current ModelCriteria
 * @method     ChildShopKit[]|ObjectCollection findById(int $id) Return ChildShopKit objects filtered by the id column
 * @method     ChildShopKit[]|ObjectCollection findByProductId(int $product_id) Return ChildShopKit objects filtered by the product_id column
 * @method     ChildShopKit[]|ObjectCollection findByActive(boolean $active) Return ChildShopKit objects filtered by the active column
 * @method     ChildShopKit[]|ObjectCollection findByPosition(int $position) Return ChildShopKit objects filtered by the position column
 * @method     ChildShopKit[]|ObjectCollection findByOnlyForLogged(boolean $only_for_logged) Return ChildShopKit objects filtered by the only_for_logged column
 * @method     ChildShopKit[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class ShopKitQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\ShopKitQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'Shop', $modelName = '\\ShopKit', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildShopKitQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildShopKitQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildShopKitQuery) {
            return $criteria;
        }
        $query = new ChildShopKitQuery();
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
     * @return ChildShopKit|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ShopKitTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ShopKitTableMap::DATABASE_NAME);
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
     * @return ChildShopKit A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, product_id, active, position, only_for_logged FROM shop_kit WHERE id = :p0';
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
            /** @var ChildShopKit $obj */
            $obj = new ChildShopKit();
            $obj->hydrate($row);
            ShopKitTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildShopKit|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildShopKitQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ShopKitTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildShopKitQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ShopKitTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildShopKitQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(ShopKitTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(ShopKitTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ShopKitTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildShopKitQuery The current query, for fluid interface
     */
    public function filterByProductId($productId = null, $comparison = null)
    {
        if (is_array($productId)) {
            $useMinMax = false;
            if (isset($productId['min'])) {
                $this->addUsingAlias(ShopKitTableMap::COL_PRODUCT_ID, $productId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($productId['max'])) {
                $this->addUsingAlias(ShopKitTableMap::COL_PRODUCT_ID, $productId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ShopKitTableMap::COL_PRODUCT_ID, $productId, $comparison);
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
     * @return $this|ChildShopKitQuery The current query, for fluid interface
     */
    public function filterByActive($active = null, $comparison = null)
    {
        if (is_string($active)) {
            $active = in_array(strtolower($active), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(ShopKitTableMap::COL_ACTIVE, $active, $comparison);
    }

    /**
     * Filter the query on the position column
     *
     * Example usage:
     * <code>
     * $query->filterByPosition(1234); // WHERE position = 1234
     * $query->filterByPosition(array(12, 34)); // WHERE position IN (12, 34)
     * $query->filterByPosition(array('min' => 12)); // WHERE position > 12
     * </code>
     *
     * @param     mixed $position The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildShopKitQuery The current query, for fluid interface
     */
    public function filterByPosition($position = null, $comparison = null)
    {
        if (is_array($position)) {
            $useMinMax = false;
            if (isset($position['min'])) {
                $this->addUsingAlias(ShopKitTableMap::COL_POSITION, $position['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($position['max'])) {
                $this->addUsingAlias(ShopKitTableMap::COL_POSITION, $position['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ShopKitTableMap::COL_POSITION, $position, $comparison);
    }

    /**
     * Filter the query on the only_for_logged column
     *
     * Example usage:
     * <code>
     * $query->filterByOnlyForLogged(true); // WHERE only_for_logged = true
     * $query->filterByOnlyForLogged('yes'); // WHERE only_for_logged = true
     * </code>
     *
     * @param     boolean|string $onlyForLogged The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildShopKitQuery The current query, for fluid interface
     */
    public function filterByOnlyForLogged($onlyForLogged = null, $comparison = null)
    {
        if (is_string($onlyForLogged)) {
            $onlyForLogged = in_array(strtolower($onlyForLogged), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(ShopKitTableMap::COL_ONLY_FOR_LOGGED, $onlyForLogged, $comparison);
    }

    /**
     * Filter the query by a related \SProducts object
     *
     * @param \SProducts|ObjectCollection $sProducts The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildShopKitQuery The current query, for fluid interface
     */
    public function filterBySProducts($sProducts, $comparison = null)
    {
        if ($sProducts instanceof \SProducts) {
            return $this
                ->addUsingAlias(ShopKitTableMap::COL_PRODUCT_ID, $sProducts->getId(), $comparison);
        } elseif ($sProducts instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ShopKitTableMap::COL_PRODUCT_ID, $sProducts->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildShopKitQuery The current query, for fluid interface
     */
    public function joinSProducts($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
    public function useSProductsQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinSProducts($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'SProducts', '\SProductsQuery');
    }

    /**
     * Filter the query by a related \ShopKitProduct object
     *
     * @param \ShopKitProduct|ObjectCollection $shopKitProduct the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildShopKitQuery The current query, for fluid interface
     */
    public function filterByShopKitProduct($shopKitProduct, $comparison = null)
    {
        if ($shopKitProduct instanceof \ShopKitProduct) {
            return $this
                ->addUsingAlias(ShopKitTableMap::COL_ID, $shopKitProduct->getKitId(), $comparison);
        } elseif ($shopKitProduct instanceof ObjectCollection) {
            return $this
                ->useShopKitProductQuery()
                ->filterByPrimaryKeys($shopKitProduct->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByShopKitProduct() only accepts arguments of type \ShopKitProduct or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ShopKitProduct relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildShopKitQuery The current query, for fluid interface
     */
    public function joinShopKitProduct($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ShopKitProduct');

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
            $this->addJoinObject($join, 'ShopKitProduct');
        }

        return $this;
    }

    /**
     * Use the ShopKitProduct relation ShopKitProduct object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ShopKitProductQuery A secondary query class using the current class as primary query
     */
    public function useShopKitProductQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinShopKitProduct($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ShopKitProduct', '\ShopKitProductQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildShopKit $shopKit Object to remove from the list of results
     *
     * @return $this|ChildShopKitQuery The current query, for fluid interface
     */
    public function prune($shopKit = null)
    {
        if ($shopKit) {
            $this->addUsingAlias(ShopKitTableMap::COL_ID, $shopKit->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the shop_kit table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ShopKitTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += $this->doOnDeleteCascade($con);
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ShopKitTableMap::clearInstancePool();
            ShopKitTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(ShopKitTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ShopKitTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            // cloning the Criteria in case it's modified by doSelect() or doSelectStmt()
            $c = clone $criteria;
            $affectedRows += $c->doOnDeleteCascade($con);

            ShopKitTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            ShopKitTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * This is a method for emulating ON DELETE CASCADE for DBs that don't support this
     * feature (like MySQL or SQLite).
     *
     * This method is not very speedy because it must perform a query first to get
     * the implicated records and then perform the deletes by calling those Query classes.
     *
     * This method should be used within a transaction if possible.
     *
     * @param ConnectionInterface $con
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    protected function doOnDeleteCascade(ConnectionInterface $con)
    {
        // initialize var to track total num of affected rows
        $affectedRows = 0;

        // first find the objects that are implicated by the $this
        $objects = ChildShopKitQuery::create(null, $this)->find($con);
        foreach ($objects as $obj) {


            // delete related ShopKitProduct objects
            $query = new \ShopKitProductQuery;

            $query->add(ShopKitProductTableMap::COL_KIT_ID, $obj->getId());
            $affectedRows += $query->delete($con);
        }

        return $affectedRows;
    }

} // ShopKitQuery
