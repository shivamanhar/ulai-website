<?php

namespace Base;

use \SNotificationStatuses as ChildSNotificationStatuses;
use \SNotificationStatusesI18nQuery as ChildSNotificationStatusesI18nQuery;
use \SNotificationStatusesQuery as ChildSNotificationStatusesQuery;
use \Exception;
use \PDO;
use Map\SNotificationStatusesI18nTableMap;
use Map\SNotificationStatusesTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'shop_notification_statuses' table.
 *
 *
 *
 * @method     ChildSNotificationStatusesQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildSNotificationStatusesQuery orderByPosition($order = Criteria::ASC) Order by the position column
 *
 * @method     ChildSNotificationStatusesQuery groupById() Group by the id column
 * @method     ChildSNotificationStatusesQuery groupByPosition() Group by the position column
 *
 * @method     ChildSNotificationStatusesQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildSNotificationStatusesQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildSNotificationStatusesQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildSNotificationStatusesQuery leftJoinSNotifications($relationAlias = null) Adds a LEFT JOIN clause to the query using the SNotifications relation
 * @method     ChildSNotificationStatusesQuery rightJoinSNotifications($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SNotifications relation
 * @method     ChildSNotificationStatusesQuery innerJoinSNotifications($relationAlias = null) Adds a INNER JOIN clause to the query using the SNotifications relation
 *
 * @method     ChildSNotificationStatusesQuery leftJoinSNotificationStatusesI18n($relationAlias = null) Adds a LEFT JOIN clause to the query using the SNotificationStatusesI18n relation
 * @method     ChildSNotificationStatusesQuery rightJoinSNotificationStatusesI18n($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SNotificationStatusesI18n relation
 * @method     ChildSNotificationStatusesQuery innerJoinSNotificationStatusesI18n($relationAlias = null) Adds a INNER JOIN clause to the query using the SNotificationStatusesI18n relation
 *
 * @method     \SNotificationsQuery|\SNotificationStatusesI18nQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildSNotificationStatuses findOne(ConnectionInterface $con = null) Return the first ChildSNotificationStatuses matching the query
 * @method     ChildSNotificationStatuses findOneOrCreate(ConnectionInterface $con = null) Return the first ChildSNotificationStatuses matching the query, or a new ChildSNotificationStatuses object populated from the query conditions when no match is found
 *
 * @method     ChildSNotificationStatuses findOneById(int $id) Return the first ChildSNotificationStatuses filtered by the id column
 * @method     ChildSNotificationStatuses findOneByPosition(int $position) Return the first ChildSNotificationStatuses filtered by the position column *

 * @method     ChildSNotificationStatuses requirePk($key, ConnectionInterface $con = null) Return the ChildSNotificationStatuses by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSNotificationStatuses requireOne(ConnectionInterface $con = null) Return the first ChildSNotificationStatuses matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSNotificationStatuses requireOneById(int $id) Return the first ChildSNotificationStatuses filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSNotificationStatuses requireOneByPosition(int $position) Return the first ChildSNotificationStatuses filtered by the position column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSNotificationStatuses[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildSNotificationStatuses objects based on current ModelCriteria
 * @method     ChildSNotificationStatuses[]|ObjectCollection findById(int $id) Return ChildSNotificationStatuses objects filtered by the id column
 * @method     ChildSNotificationStatuses[]|ObjectCollection findByPosition(int $position) Return ChildSNotificationStatuses objects filtered by the position column
 * @method     ChildSNotificationStatuses[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class SNotificationStatusesQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\SNotificationStatusesQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'Shop', $modelName = '\\SNotificationStatuses', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildSNotificationStatusesQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildSNotificationStatusesQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildSNotificationStatusesQuery) {
            return $criteria;
        }
        $query = new ChildSNotificationStatusesQuery();
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
     * @return ChildSNotificationStatuses|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = SNotificationStatusesTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(SNotificationStatusesTableMap::DATABASE_NAME);
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
     * @return ChildSNotificationStatuses A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, position FROM shop_notification_statuses WHERE id = :p0';
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
            /** @var ChildSNotificationStatuses $obj */
            $obj = new ChildSNotificationStatuses();
            $obj->hydrate($row);
            SNotificationStatusesTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildSNotificationStatuses|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildSNotificationStatusesQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(SNotificationStatusesTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildSNotificationStatusesQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(SNotificationStatusesTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildSNotificationStatusesQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(SNotificationStatusesTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(SNotificationStatusesTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SNotificationStatusesTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildSNotificationStatusesQuery The current query, for fluid interface
     */
    public function filterByPosition($position = null, $comparison = null)
    {
        if (is_array($position)) {
            $useMinMax = false;
            if (isset($position['min'])) {
                $this->addUsingAlias(SNotificationStatusesTableMap::COL_POSITION, $position['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($position['max'])) {
                $this->addUsingAlias(SNotificationStatusesTableMap::COL_POSITION, $position['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SNotificationStatusesTableMap::COL_POSITION, $position, $comparison);
    }

    /**
     * Filter the query by a related \SNotifications object
     *
     * @param \SNotifications|ObjectCollection $sNotifications the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSNotificationStatusesQuery The current query, for fluid interface
     */
    public function filterBySNotifications($sNotifications, $comparison = null)
    {
        if ($sNotifications instanceof \SNotifications) {
            return $this
                ->addUsingAlias(SNotificationStatusesTableMap::COL_ID, $sNotifications->getStatus(), $comparison);
        } elseif ($sNotifications instanceof ObjectCollection) {
            return $this
                ->useSNotificationsQuery()
                ->filterByPrimaryKeys($sNotifications->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterBySNotifications() only accepts arguments of type \SNotifications or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the SNotifications relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSNotificationStatusesQuery The current query, for fluid interface
     */
    public function joinSNotifications($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('SNotifications');

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
            $this->addJoinObject($join, 'SNotifications');
        }

        return $this;
    }

    /**
     * Use the SNotifications relation SNotifications object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \SNotificationsQuery A secondary query class using the current class as primary query
     */
    public function useSNotificationsQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinSNotifications($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'SNotifications', '\SNotificationsQuery');
    }

    /**
     * Filter the query by a related \SNotificationStatusesI18n object
     *
     * @param \SNotificationStatusesI18n|ObjectCollection $sNotificationStatusesI18n the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSNotificationStatusesQuery The current query, for fluid interface
     */
    public function filterBySNotificationStatusesI18n($sNotificationStatusesI18n, $comparison = null)
    {
        if ($sNotificationStatusesI18n instanceof \SNotificationStatusesI18n) {
            return $this
                ->addUsingAlias(SNotificationStatusesTableMap::COL_ID, $sNotificationStatusesI18n->getId(), $comparison);
        } elseif ($sNotificationStatusesI18n instanceof ObjectCollection) {
            return $this
                ->useSNotificationStatusesI18nQuery()
                ->filterByPrimaryKeys($sNotificationStatusesI18n->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterBySNotificationStatusesI18n() only accepts arguments of type \SNotificationStatusesI18n or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the SNotificationStatusesI18n relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSNotificationStatusesQuery The current query, for fluid interface
     */
    public function joinSNotificationStatusesI18n($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('SNotificationStatusesI18n');

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
            $this->addJoinObject($join, 'SNotificationStatusesI18n');
        }

        return $this;
    }

    /**
     * Use the SNotificationStatusesI18n relation SNotificationStatusesI18n object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \SNotificationStatusesI18nQuery A secondary query class using the current class as primary query
     */
    public function useSNotificationStatusesI18nQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinSNotificationStatusesI18n($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'SNotificationStatusesI18n', '\SNotificationStatusesI18nQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildSNotificationStatuses $sNotificationStatuses Object to remove from the list of results
     *
     * @return $this|ChildSNotificationStatusesQuery The current query, for fluid interface
     */
    public function prune($sNotificationStatuses = null)
    {
        if ($sNotificationStatuses) {
            $this->addUsingAlias(SNotificationStatusesTableMap::COL_ID, $sNotificationStatuses->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the shop_notification_statuses table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SNotificationStatusesTableMap::DATABASE_NAME);
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
            SNotificationStatusesTableMap::clearInstancePool();
            SNotificationStatusesTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(SNotificationStatusesTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(SNotificationStatusesTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            // cloning the Criteria in case it's modified by doSelect() or doSelectStmt()
            $c = clone $criteria;
            $affectedRows += $c->doOnDeleteCascade($con);

            SNotificationStatusesTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            SNotificationStatusesTableMap::clearRelatedInstancePool();

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
        $objects = ChildSNotificationStatusesQuery::create(null, $this)->find($con);
        foreach ($objects as $obj) {


            // delete related SNotificationStatusesI18n objects
            $query = new \SNotificationStatusesI18nQuery;

            $query->add(SNotificationStatusesI18nTableMap::COL_ID, $obj->getId());
            $affectedRows += $query->delete($con);
        }

        return $affectedRows;
    }

    // i18n behavior

    /**
     * Adds a JOIN clause to the query using the i18n relation
     *
     * @param     string $locale Locale to use for the join condition, e.g. 'fr_FR'
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'. Defaults to left join.
     *
     * @return    ChildSNotificationStatusesQuery The current query, for fluid interface
     */
    public function joinI18n($locale = 'ru', $relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $relationName = $relationAlias ? $relationAlias : 'SNotificationStatusesI18n';

        return $this
            ->joinSNotificationStatusesI18n($relationAlias, $joinType)
            ->addJoinCondition($relationName, $relationName . '.Locale = ?', $locale);
    }

    /**
     * Adds a JOIN clause to the query and hydrates the related I18n object.
     * Shortcut for $c->joinI18n($locale)->with()
     *
     * @param     string $locale Locale to use for the join condition, e.g. 'fr_FR'
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'. Defaults to left join.
     *
     * @return    $this|ChildSNotificationStatusesQuery The current query, for fluid interface
     */
    public function joinWithI18n($locale = 'ru', $joinType = Criteria::LEFT_JOIN)
    {
        $this
            ->joinI18n($locale, null, $joinType)
            ->with('SNotificationStatusesI18n');
        $this->with['SNotificationStatusesI18n']->setIsWithOneToMany(false);

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
     * @return    ChildSNotificationStatusesI18nQuery A secondary query class using the current class as primary query
     */
    public function useI18nQuery($locale = 'ru', $relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinI18n($locale, $relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'SNotificationStatusesI18n', '\SNotificationStatusesI18nQuery');
    }

} // SNotificationStatusesQuery
