<?php

namespace Base;

use \SOrderStatuses as ChildSOrderStatuses;
use \SOrderStatusesI18nQuery as ChildSOrderStatusesI18nQuery;
use \SOrderStatusesQuery as ChildSOrderStatusesQuery;
use \Exception;
use \PDO;
use Map\SOrderStatusHistoryTableMap;
use Map\SOrderStatusesI18nTableMap;
use Map\SOrderStatusesTableMap;
use Map\SOrdersTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'shop_order_statuses' table.
 *
 *
 *
 * @method     ChildSOrderStatusesQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildSOrderStatusesQuery orderByColor($order = Criteria::ASC) Order by the color column
 * @method     ChildSOrderStatusesQuery orderByFontcolor($order = Criteria::ASC) Order by the fontcolor column
 * @method     ChildSOrderStatusesQuery orderByPosition($order = Criteria::ASC) Order by the position column
 *
 * @method     ChildSOrderStatusesQuery groupById() Group by the id column
 * @method     ChildSOrderStatusesQuery groupByColor() Group by the color column
 * @method     ChildSOrderStatusesQuery groupByFontcolor() Group by the fontcolor column
 * @method     ChildSOrderStatusesQuery groupByPosition() Group by the position column
 *
 * @method     ChildSOrderStatusesQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildSOrderStatusesQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildSOrderStatusesQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildSOrderStatusesQuery leftJoinSOrderStatusesI18n($relationAlias = null) Adds a LEFT JOIN clause to the query using the SOrderStatusesI18n relation
 * @method     ChildSOrderStatusesQuery rightJoinSOrderStatusesI18n($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SOrderStatusesI18n relation
 * @method     ChildSOrderStatusesQuery innerJoinSOrderStatusesI18n($relationAlias = null) Adds a INNER JOIN clause to the query using the SOrderStatusesI18n relation
 *
 * @method     ChildSOrderStatusesQuery leftJoinSOrders($relationAlias = null) Adds a LEFT JOIN clause to the query using the SOrders relation
 * @method     ChildSOrderStatusesQuery rightJoinSOrders($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SOrders relation
 * @method     ChildSOrderStatusesQuery innerJoinSOrders($relationAlias = null) Adds a INNER JOIN clause to the query using the SOrders relation
 *
 * @method     ChildSOrderStatusesQuery leftJoinSOrderStatusHistory($relationAlias = null) Adds a LEFT JOIN clause to the query using the SOrderStatusHistory relation
 * @method     ChildSOrderStatusesQuery rightJoinSOrderStatusHistory($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SOrderStatusHistory relation
 * @method     ChildSOrderStatusesQuery innerJoinSOrderStatusHistory($relationAlias = null) Adds a INNER JOIN clause to the query using the SOrderStatusHistory relation
 *
 * @method     \SOrderStatusesI18nQuery|\SOrdersQuery|\SOrderStatusHistoryQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildSOrderStatuses findOne(ConnectionInterface $con = null) Return the first ChildSOrderStatuses matching the query
 * @method     ChildSOrderStatuses findOneOrCreate(ConnectionInterface $con = null) Return the first ChildSOrderStatuses matching the query, or a new ChildSOrderStatuses object populated from the query conditions when no match is found
 *
 * @method     ChildSOrderStatuses findOneById(int $id) Return the first ChildSOrderStatuses filtered by the id column
 * @method     ChildSOrderStatuses findOneByColor(string $color) Return the first ChildSOrderStatuses filtered by the color column
 * @method     ChildSOrderStatuses findOneByFontcolor(string $fontcolor) Return the first ChildSOrderStatuses filtered by the fontcolor column
 * @method     ChildSOrderStatuses findOneByPosition(int $position) Return the first ChildSOrderStatuses filtered by the position column *

 * @method     ChildSOrderStatuses requirePk($key, ConnectionInterface $con = null) Return the ChildSOrderStatuses by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSOrderStatuses requireOne(ConnectionInterface $con = null) Return the first ChildSOrderStatuses matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSOrderStatuses requireOneById(int $id) Return the first ChildSOrderStatuses filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSOrderStatuses requireOneByColor(string $color) Return the first ChildSOrderStatuses filtered by the color column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSOrderStatuses requireOneByFontcolor(string $fontcolor) Return the first ChildSOrderStatuses filtered by the fontcolor column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSOrderStatuses requireOneByPosition(int $position) Return the first ChildSOrderStatuses filtered by the position column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSOrderStatuses[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildSOrderStatuses objects based on current ModelCriteria
 * @method     ChildSOrderStatuses[]|ObjectCollection findById(int $id) Return ChildSOrderStatuses objects filtered by the id column
 * @method     ChildSOrderStatuses[]|ObjectCollection findByColor(string $color) Return ChildSOrderStatuses objects filtered by the color column
 * @method     ChildSOrderStatuses[]|ObjectCollection findByFontcolor(string $fontcolor) Return ChildSOrderStatuses objects filtered by the fontcolor column
 * @method     ChildSOrderStatuses[]|ObjectCollection findByPosition(int $position) Return ChildSOrderStatuses objects filtered by the position column
 * @method     ChildSOrderStatuses[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class SOrderStatusesQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\SOrderStatusesQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'Shop', $modelName = '\\SOrderStatuses', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildSOrderStatusesQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildSOrderStatusesQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildSOrderStatusesQuery) {
            return $criteria;
        }
        $query = new ChildSOrderStatusesQuery();
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
     * @return ChildSOrderStatuses|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = SOrderStatusesTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(SOrderStatusesTableMap::DATABASE_NAME);
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
     * @return ChildSOrderStatuses A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, color, fontcolor, position FROM shop_order_statuses WHERE id = :p0';
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
            /** @var ChildSOrderStatuses $obj */
            $obj = new ChildSOrderStatuses();
            $obj->hydrate($row);
            SOrderStatusesTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildSOrderStatuses|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildSOrderStatusesQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(SOrderStatusesTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildSOrderStatusesQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(SOrderStatusesTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildSOrderStatusesQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(SOrderStatusesTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(SOrderStatusesTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SOrderStatusesTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the color column
     *
     * Example usage:
     * <code>
     * $query->filterByColor('fooValue');   // WHERE color = 'fooValue'
     * $query->filterByColor('%fooValue%'); // WHERE color LIKE '%fooValue%'
     * </code>
     *
     * @param     string $color The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSOrderStatusesQuery The current query, for fluid interface
     */
    public function filterByColor($color = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($color)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $color)) {
                $color = str_replace('*', '%', $color);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SOrderStatusesTableMap::COL_COLOR, $color, $comparison);
    }

    /**
     * Filter the query on the fontcolor column
     *
     * Example usage:
     * <code>
     * $query->filterByFontcolor('fooValue');   // WHERE fontcolor = 'fooValue'
     * $query->filterByFontcolor('%fooValue%'); // WHERE fontcolor LIKE '%fooValue%'
     * </code>
     *
     * @param     string $fontcolor The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSOrderStatusesQuery The current query, for fluid interface
     */
    public function filterByFontcolor($fontcolor = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($fontcolor)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $fontcolor)) {
                $fontcolor = str_replace('*', '%', $fontcolor);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SOrderStatusesTableMap::COL_FONTCOLOR, $fontcolor, $comparison);
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
     * @return $this|ChildSOrderStatusesQuery The current query, for fluid interface
     */
    public function filterByPosition($position = null, $comparison = null)
    {
        if (is_array($position)) {
            $useMinMax = false;
            if (isset($position['min'])) {
                $this->addUsingAlias(SOrderStatusesTableMap::COL_POSITION, $position['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($position['max'])) {
                $this->addUsingAlias(SOrderStatusesTableMap::COL_POSITION, $position['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SOrderStatusesTableMap::COL_POSITION, $position, $comparison);
    }

    /**
     * Filter the query by a related \SOrderStatusesI18n object
     *
     * @param \SOrderStatusesI18n|ObjectCollection $sOrderStatusesI18n the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSOrderStatusesQuery The current query, for fluid interface
     */
    public function filterBySOrderStatusesI18n($sOrderStatusesI18n, $comparison = null)
    {
        if ($sOrderStatusesI18n instanceof \SOrderStatusesI18n) {
            return $this
                ->addUsingAlias(SOrderStatusesTableMap::COL_ID, $sOrderStatusesI18n->getId(), $comparison);
        } elseif ($sOrderStatusesI18n instanceof ObjectCollection) {
            return $this
                ->useSOrderStatusesI18nQuery()
                ->filterByPrimaryKeys($sOrderStatusesI18n->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterBySOrderStatusesI18n() only accepts arguments of type \SOrderStatusesI18n or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the SOrderStatusesI18n relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSOrderStatusesQuery The current query, for fluid interface
     */
    public function joinSOrderStatusesI18n($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('SOrderStatusesI18n');

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
            $this->addJoinObject($join, 'SOrderStatusesI18n');
        }

        return $this;
    }

    /**
     * Use the SOrderStatusesI18n relation SOrderStatusesI18n object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \SOrderStatusesI18nQuery A secondary query class using the current class as primary query
     */
    public function useSOrderStatusesI18nQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinSOrderStatusesI18n($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'SOrderStatusesI18n', '\SOrderStatusesI18nQuery');
    }

    /**
     * Filter the query by a related \SOrders object
     *
     * @param \SOrders|ObjectCollection $sOrders the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSOrderStatusesQuery The current query, for fluid interface
     */
    public function filterBySOrders($sOrders, $comparison = null)
    {
        if ($sOrders instanceof \SOrders) {
            return $this
                ->addUsingAlias(SOrderStatusesTableMap::COL_ID, $sOrders->getStatus(), $comparison);
        } elseif ($sOrders instanceof ObjectCollection) {
            return $this
                ->useSOrdersQuery()
                ->filterByPrimaryKeys($sOrders->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterBySOrders() only accepts arguments of type \SOrders or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the SOrders relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSOrderStatusesQuery The current query, for fluid interface
     */
    public function joinSOrders($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('SOrders');

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
            $this->addJoinObject($join, 'SOrders');
        }

        return $this;
    }

    /**
     * Use the SOrders relation SOrders object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \SOrdersQuery A secondary query class using the current class as primary query
     */
    public function useSOrdersQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinSOrders($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'SOrders', '\SOrdersQuery');
    }

    /**
     * Filter the query by a related \SOrderStatusHistory object
     *
     * @param \SOrderStatusHistory|ObjectCollection $sOrderStatusHistory the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSOrderStatusesQuery The current query, for fluid interface
     */
    public function filterBySOrderStatusHistory($sOrderStatusHistory, $comparison = null)
    {
        if ($sOrderStatusHistory instanceof \SOrderStatusHistory) {
            return $this
                ->addUsingAlias(SOrderStatusesTableMap::COL_ID, $sOrderStatusHistory->getStatusId(), $comparison);
        } elseif ($sOrderStatusHistory instanceof ObjectCollection) {
            return $this
                ->useSOrderStatusHistoryQuery()
                ->filterByPrimaryKeys($sOrderStatusHistory->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterBySOrderStatusHistory() only accepts arguments of type \SOrderStatusHistory or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the SOrderStatusHistory relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSOrderStatusesQuery The current query, for fluid interface
     */
    public function joinSOrderStatusHistory($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('SOrderStatusHistory');

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
            $this->addJoinObject($join, 'SOrderStatusHistory');
        }

        return $this;
    }

    /**
     * Use the SOrderStatusHistory relation SOrderStatusHistory object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \SOrderStatusHistoryQuery A secondary query class using the current class as primary query
     */
    public function useSOrderStatusHistoryQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinSOrderStatusHistory($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'SOrderStatusHistory', '\SOrderStatusHistoryQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildSOrderStatuses $sOrderStatuses Object to remove from the list of results
     *
     * @return $this|ChildSOrderStatusesQuery The current query, for fluid interface
     */
    public function prune($sOrderStatuses = null)
    {
        if ($sOrderStatuses) {
            $this->addUsingAlias(SOrderStatusesTableMap::COL_ID, $sOrderStatuses->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the shop_order_statuses table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SOrderStatusesTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += $this->doOnDeleteCascade($con);
            $this->doOnDeleteSetNull($con);
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            SOrderStatusesTableMap::clearInstancePool();
            SOrderStatusesTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(SOrderStatusesTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(SOrderStatusesTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            // cloning the Criteria in case it's modified by doSelect() or doSelectStmt()
            $c = clone $criteria;
            $affectedRows += $c->doOnDeleteCascade($con);

            // cloning the Criteria in case it's modified by doSelect() or doSelectStmt()
            $c = clone $criteria;
            $c->doOnDeleteSetNull($con);

            SOrderStatusesTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            SOrderStatusesTableMap::clearRelatedInstancePool();

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
        $objects = ChildSOrderStatusesQuery::create(null, $this)->find($con);
        foreach ($objects as $obj) {


            // delete related SOrderStatusesI18n objects
            $query = new \SOrderStatusesI18nQuery;

            $query->add(SOrderStatusesI18nTableMap::COL_ID, $obj->getId());
            $affectedRows += $query->delete($con);
        }

        return $affectedRows;
    }

    /**
     * This is a method for emulating ON DELETE SET NULL DBs that don't support this
     * feature (like MySQL or SQLite).
     *
     * This method is not very speedy because it must perform a query first to get
     * the implicated records and then perform the deletes by calling those query classes.
     *
     * This method should be used within a transaction if possible.
     *
     * @param ConnectionInterface $con
     * @return void
     */
    protected function doOnDeleteSetNull(ConnectionInterface $con)
    {
        // first find the objects that are implicated by the $this
        $objects = ChildSOrderStatusesQuery::create(null, $this)->find($con);
        foreach ($objects as $obj) {

            // set fkey col in related SOrders rows to NULL
            $query = new \SOrdersQuery();
            $updateValues = new Criteria();
            $query->add(SOrdersTableMap::COL_STATUS, $obj->getId());
            $updateValues->add(SOrdersTableMap::COL_STATUS, null);
$query->update($updateValues, $con);

            // set fkey col in related SOrderStatusHistory rows to NULL
            $query = new \SOrderStatusHistoryQuery();
            $updateValues = new Criteria();
            $query->add(SOrderStatusHistoryTableMap::COL_STATUS_ID, $obj->getId());
            $updateValues->add(SOrderStatusHistoryTableMap::COL_STATUS_ID, null);
$query->update($updateValues, $con);

        }
    }

    // i18n behavior

    /**
     * Adds a JOIN clause to the query using the i18n relation
     *
     * @param     string $locale Locale to use for the join condition, e.g. 'fr_FR'
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'. Defaults to left join.
     *
     * @return    ChildSOrderStatusesQuery The current query, for fluid interface
     */
    public function joinI18n($locale = 'ru', $relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $relationName = $relationAlias ? $relationAlias : 'SOrderStatusesI18n';

        return $this
            ->joinSOrderStatusesI18n($relationAlias, $joinType)
            ->addJoinCondition($relationName, $relationName . '.Locale = ?', $locale);
    }

    /**
     * Adds a JOIN clause to the query and hydrates the related I18n object.
     * Shortcut for $c->joinI18n($locale)->with()
     *
     * @param     string $locale Locale to use for the join condition, e.g. 'fr_FR'
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'. Defaults to left join.
     *
     * @return    $this|ChildSOrderStatusesQuery The current query, for fluid interface
     */
    public function joinWithI18n($locale = 'ru', $joinType = Criteria::LEFT_JOIN)
    {
        $this
            ->joinI18n($locale, null, $joinType)
            ->with('SOrderStatusesI18n');
        $this->with['SOrderStatusesI18n']->setIsWithOneToMany(false);

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
     * @return    ChildSOrderStatusesI18nQuery A secondary query class using the current class as primary query
     */
    public function useI18nQuery($locale = 'ru', $relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinI18n($locale, $relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'SOrderStatusesI18n', '\SOrderStatusesI18nQuery');
    }

} // SOrderStatusesQuery
