<?php

namespace Base;

use \ShopBaners as ChildShopBaners;
use \ShopBanersI18nQuery as ChildShopBanersI18nQuery;
use \ShopBanersQuery as ChildShopBanersQuery;
use \Exception;
use \PDO;
use Map\ShopBanersTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'shop_banners' table.
 *
 *
 *
 * @method     ChildShopBanersQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildShopBanersQuery orderByPosition($order = Criteria::ASC) Order by the position column
 * @method     ChildShopBanersQuery orderByActive($order = Criteria::ASC) Order by the active column
 * @method     ChildShopBanersQuery orderByCategories($order = Criteria::ASC) Order by the categories column
 * @method     ChildShopBanersQuery orderByOnMain($order = Criteria::ASC) Order by the on_main column
 * @method     ChildShopBanersQuery orderByEspdate($order = Criteria::ASC) Order by the espdate column
 *
 * @method     ChildShopBanersQuery groupById() Group by the id column
 * @method     ChildShopBanersQuery groupByPosition() Group by the position column
 * @method     ChildShopBanersQuery groupByActive() Group by the active column
 * @method     ChildShopBanersQuery groupByCategories() Group by the categories column
 * @method     ChildShopBanersQuery groupByOnMain() Group by the on_main column
 * @method     ChildShopBanersQuery groupByEspdate() Group by the espdate column
 *
 * @method     ChildShopBanersQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildShopBanersQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildShopBanersQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildShopBanersQuery leftJoinShopBanersI18n($relationAlias = null) Adds a LEFT JOIN clause to the query using the ShopBanersI18n relation
 * @method     ChildShopBanersQuery rightJoinShopBanersI18n($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ShopBanersI18n relation
 * @method     ChildShopBanersQuery innerJoinShopBanersI18n($relationAlias = null) Adds a INNER JOIN clause to the query using the ShopBanersI18n relation
 *
 * @method     \ShopBanersI18nQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildShopBaners findOne(ConnectionInterface $con = null) Return the first ChildShopBaners matching the query
 * @method     ChildShopBaners findOneOrCreate(ConnectionInterface $con = null) Return the first ChildShopBaners matching the query, or a new ChildShopBaners object populated from the query conditions when no match is found
 *
 * @method     ChildShopBaners findOneById(int $id) Return the first ChildShopBaners filtered by the id column
 * @method     ChildShopBaners findOneByPosition(int $position) Return the first ChildShopBaners filtered by the position column
 * @method     ChildShopBaners findOneByActive(boolean $active) Return the first ChildShopBaners filtered by the active column
 * @method     ChildShopBaners findOneByCategories(string $categories) Return the first ChildShopBaners filtered by the categories column
 * @method     ChildShopBaners findOneByOnMain(boolean $on_main) Return the first ChildShopBaners filtered by the on_main column
 * @method     ChildShopBaners findOneByEspdate(int $espdate) Return the first ChildShopBaners filtered by the espdate column
 *
 * @method     ChildShopBaners[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildShopBaners objects based on current ModelCriteria
 * @method     ChildShopBaners[]|ObjectCollection findById(int $id) Return ChildShopBaners objects filtered by the id column
 * @method     ChildShopBaners[]|ObjectCollection findByPosition(int $position) Return ChildShopBaners objects filtered by the position column
 * @method     ChildShopBaners[]|ObjectCollection findByActive(boolean $active) Return ChildShopBaners objects filtered by the active column
 * @method     ChildShopBaners[]|ObjectCollection findByCategories(string $categories) Return ChildShopBaners objects filtered by the categories column
 * @method     ChildShopBaners[]|ObjectCollection findByOnMain(boolean $on_main) Return ChildShopBaners objects filtered by the on_main column
 * @method     ChildShopBaners[]|ObjectCollection findByEspdate(int $espdate) Return ChildShopBaners objects filtered by the espdate column
 * @method     ChildShopBaners[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class ShopBanersQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \Base\ShopBanersQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'Shop', $modelName = '\\ShopBaners', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildShopBanersQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildShopBanersQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildShopBanersQuery) {
            return $criteria;
        }
        $query = new ChildShopBanersQuery();
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
     * @return ChildShopBaners|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ShopBanersTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ShopBanersTableMap::DATABASE_NAME);
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
     * @return ChildShopBaners A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, position, active, categories, on_main, espdate FROM shop_banners WHERE id = :p0';
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
            /** @var ChildShopBaners $obj */
            $obj = new ChildShopBaners();
            $obj->hydrate($row);
            ShopBanersTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildShopBaners|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildShopBanersQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ShopBanersTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildShopBanersQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ShopBanersTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildShopBanersQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(ShopBanersTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(ShopBanersTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ShopBanersTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildShopBanersQuery The current query, for fluid interface
     */
    public function filterByPosition($position = null, $comparison = null)
    {
        if (is_array($position)) {
            $useMinMax = false;
            if (isset($position['min'])) {
                $this->addUsingAlias(ShopBanersTableMap::COL_POSITION, $position['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($position['max'])) {
                $this->addUsingAlias(ShopBanersTableMap::COL_POSITION, $position['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ShopBanersTableMap::COL_POSITION, $position, $comparison);
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
     * @return $this|ChildShopBanersQuery The current query, for fluid interface
     */
    public function filterByActive($active = null, $comparison = null)
    {
        if (is_string($active)) {
            $active = in_array(strtolower($active), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(ShopBanersTableMap::COL_ACTIVE, $active, $comparison);
    }

    /**
     * Filter the query on the categories column
     *
     * Example usage:
     * <code>
     * $query->filterByCategories('fooValue');   // WHERE categories = 'fooValue'
     * $query->filterByCategories('%fooValue%'); // WHERE categories LIKE '%fooValue%'
     * </code>
     *
     * @param     string $categories The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildShopBanersQuery The current query, for fluid interface
     */
    public function filterByCategories($categories = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($categories)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $categories)) {
                $categories = str_replace('*', '%', $categories);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ShopBanersTableMap::COL_CATEGORIES, $categories, $comparison);
    }

    /**
     * Filter the query on the on_main column
     *
     * Example usage:
     * <code>
     * $query->filterByOnMain(true); // WHERE on_main = true
     * $query->filterByOnMain('yes'); // WHERE on_main = true
     * </code>
     *
     * @param     boolean|string $onMain The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildShopBanersQuery The current query, for fluid interface
     */
    public function filterByOnMain($onMain = null, $comparison = null)
    {
        if (is_string($onMain)) {
            $onMain = in_array(strtolower($onMain), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(ShopBanersTableMap::COL_ON_MAIN, $onMain, $comparison);
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
     * @return $this|ChildShopBanersQuery The current query, for fluid interface
     */
    public function filterByEspdate($espdate = null, $comparison = null)
    {
        if (is_array($espdate)) {
            $useMinMax = false;
            if (isset($espdate['min'])) {
                $this->addUsingAlias(ShopBanersTableMap::COL_ESPDATE, $espdate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($espdate['max'])) {
                $this->addUsingAlias(ShopBanersTableMap::COL_ESPDATE, $espdate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ShopBanersTableMap::COL_ESPDATE, $espdate, $comparison);
    }

    /**
     * Filter the query by a related \ShopBanersI18n object
     *
     * @param \ShopBanersI18n|ObjectCollection $shopBanersI18n  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildShopBanersQuery The current query, for fluid interface
     */
    public function filterByShopBanersI18n($shopBanersI18n, $comparison = null)
    {
        if ($shopBanersI18n instanceof \ShopBanersI18n) {
            return $this
                ->addUsingAlias(ShopBanersTableMap::COL_ID, $shopBanersI18n->getId(), $comparison);
        } elseif ($shopBanersI18n instanceof ObjectCollection) {
            return $this
                ->useShopBanersI18nQuery()
                ->filterByPrimaryKeys($shopBanersI18n->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByShopBanersI18n() only accepts arguments of type \ShopBanersI18n or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ShopBanersI18n relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildShopBanersQuery The current query, for fluid interface
     */
    public function joinShopBanersI18n($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ShopBanersI18n');

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
            $this->addJoinObject($join, 'ShopBanersI18n');
        }

        return $this;
    }

    /**
     * Use the ShopBanersI18n relation ShopBanersI18n object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ShopBanersI18nQuery A secondary query class using the current class as primary query
     */
    public function useShopBanersI18nQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinShopBanersI18n($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ShopBanersI18n', '\ShopBanersI18nQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildShopBaners $shopBaners Object to remove from the list of results
     *
     * @return $this|ChildShopBanersQuery The current query, for fluid interface
     */
    public function prune($shopBaners = null)
    {
        if ($shopBaners) {
            $this->addUsingAlias(ShopBanersTableMap::COL_ID, $shopBaners->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the shop_banners table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ShopBanersTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ShopBanersTableMap::clearInstancePool();
            ShopBanersTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(ShopBanersTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ShopBanersTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            ShopBanersTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            ShopBanersTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    // i18n behavior

    /**
     * Adds a JOIN clause to the query using the i18n relation
     *
     * @param     string $locale Locale to use for the join condition, e.g. 'fr_FR'
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'. Defaults to left join.
     *
     * @return    ChildShopBanersQuery The current query, for fluid interface
     */
    public function joinI18n($locale = 'ru', $relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $relationName = $relationAlias ? $relationAlias : 'ShopBanersI18n';

        return $this
            ->joinShopBanersI18n($relationAlias, $joinType)
            ->addJoinCondition($relationName, $relationName . '.Locale = ?', $locale);
    }

    /**
     * Adds a JOIN clause to the query and hydrates the related I18n object.
     * Shortcut for $c->joinI18n($locale)->with()
     *
     * @param     string $locale Locale to use for the join condition, e.g. 'fr_FR'
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'. Defaults to left join.
     *
     * @return    $this|ChildShopBanersQuery The current query, for fluid interface
     */
    public function joinWithI18n($locale = 'ru', $joinType = Criteria::LEFT_JOIN)
    {
        $this
            ->joinI18n($locale, null, $joinType)
            ->with('ShopBanersI18n');
        $this->with['ShopBanersI18n']->setIsWithOneToMany(false);

        return $this;
    }

    /**
     * Use the I18n relation query object
     *
     * @see       useQuery()
     *
     * @param     string $locale Locale to use for the join condition, e.g. 'fr_FR'
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'. Defaults to left join.
     *
     * @return    ChildShopBanersI18nQuery A secondary query class using the current class as primary query
     */
    public function useI18nQuery($locale = 'ru', $relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinI18n($locale, $relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ShopBanersI18n', '\ShopBanersI18nQuery');
    }

} // ShopBanersQuery
