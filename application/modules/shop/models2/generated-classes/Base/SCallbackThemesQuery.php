<?php

namespace Base;

use \SCallbackThemes as ChildSCallbackThemes;
use \SCallbackThemesI18nQuery as ChildSCallbackThemesI18nQuery;
use \SCallbackThemesQuery as ChildSCallbackThemesQuery;
use \Exception;
use \PDO;
use Map\SCallbackThemesI18nTableMap;
use Map\SCallbackThemesTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'shop_callbacks_themes' table.
 *
 *
 *
 * @method     ChildSCallbackThemesQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildSCallbackThemesQuery orderByPosition($order = Criteria::ASC) Order by the position column
 *
 * @method     ChildSCallbackThemesQuery groupById() Group by the id column
 * @method     ChildSCallbackThemesQuery groupByPosition() Group by the position column
 *
 * @method     ChildSCallbackThemesQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildSCallbackThemesQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildSCallbackThemesQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildSCallbackThemesQuery leftJoinSCallbacks($relationAlias = null) Adds a LEFT JOIN clause to the query using the SCallbacks relation
 * @method     ChildSCallbackThemesQuery rightJoinSCallbacks($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SCallbacks relation
 * @method     ChildSCallbackThemesQuery innerJoinSCallbacks($relationAlias = null) Adds a INNER JOIN clause to the query using the SCallbacks relation
 *
 * @method     ChildSCallbackThemesQuery leftJoinSCallbackThemesI18n($relationAlias = null) Adds a LEFT JOIN clause to the query using the SCallbackThemesI18n relation
 * @method     ChildSCallbackThemesQuery rightJoinSCallbackThemesI18n($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SCallbackThemesI18n relation
 * @method     ChildSCallbackThemesQuery innerJoinSCallbackThemesI18n($relationAlias = null) Adds a INNER JOIN clause to the query using the SCallbackThemesI18n relation
 *
 * @method     \SCallbacksQuery|\SCallbackThemesI18nQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildSCallbackThemes findOne(ConnectionInterface $con = null) Return the first ChildSCallbackThemes matching the query
 * @method     ChildSCallbackThemes findOneOrCreate(ConnectionInterface $con = null) Return the first ChildSCallbackThemes matching the query, or a new ChildSCallbackThemes object populated from the query conditions when no match is found
 *
 * @method     ChildSCallbackThemes findOneById(int $id) Return the first ChildSCallbackThemes filtered by the id column
 * @method     ChildSCallbackThemes findOneByPosition(int $position) Return the first ChildSCallbackThemes filtered by the position column *

 * @method     ChildSCallbackThemes requirePk($key, ConnectionInterface $con = null) Return the ChildSCallbackThemes by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSCallbackThemes requireOne(ConnectionInterface $con = null) Return the first ChildSCallbackThemes matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSCallbackThemes requireOneById(int $id) Return the first ChildSCallbackThemes filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSCallbackThemes requireOneByPosition(int $position) Return the first ChildSCallbackThemes filtered by the position column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSCallbackThemes[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildSCallbackThemes objects based on current ModelCriteria
 * @method     ChildSCallbackThemes[]|ObjectCollection findById(int $id) Return ChildSCallbackThemes objects filtered by the id column
 * @method     ChildSCallbackThemes[]|ObjectCollection findByPosition(int $position) Return ChildSCallbackThemes objects filtered by the position column
 * @method     ChildSCallbackThemes[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class SCallbackThemesQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\SCallbackThemesQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'Shop', $modelName = '\\SCallbackThemes', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildSCallbackThemesQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildSCallbackThemesQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildSCallbackThemesQuery) {
            return $criteria;
        }
        $query = new ChildSCallbackThemesQuery();
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
     * @return ChildSCallbackThemes|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = SCallbackThemesTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(SCallbackThemesTableMap::DATABASE_NAME);
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
     * @return ChildSCallbackThemes A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, position FROM shop_callbacks_themes WHERE id = :p0';
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
            /** @var ChildSCallbackThemes $obj */
            $obj = new ChildSCallbackThemes();
            $obj->hydrate($row);
            SCallbackThemesTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildSCallbackThemes|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildSCallbackThemesQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(SCallbackThemesTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildSCallbackThemesQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(SCallbackThemesTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildSCallbackThemesQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(SCallbackThemesTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(SCallbackThemesTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SCallbackThemesTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildSCallbackThemesQuery The current query, for fluid interface
     */
    public function filterByPosition($position = null, $comparison = null)
    {
        if (is_array($position)) {
            $useMinMax = false;
            if (isset($position['min'])) {
                $this->addUsingAlias(SCallbackThemesTableMap::COL_POSITION, $position['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($position['max'])) {
                $this->addUsingAlias(SCallbackThemesTableMap::COL_POSITION, $position['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SCallbackThemesTableMap::COL_POSITION, $position, $comparison);
    }

    /**
     * Filter the query by a related \SCallbacks object
     *
     * @param \SCallbacks|ObjectCollection $sCallbacks the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSCallbackThemesQuery The current query, for fluid interface
     */
    public function filterBySCallbacks($sCallbacks, $comparison = null)
    {
        if ($sCallbacks instanceof \SCallbacks) {
            return $this
                ->addUsingAlias(SCallbackThemesTableMap::COL_ID, $sCallbacks->getThemeId(), $comparison);
        } elseif ($sCallbacks instanceof ObjectCollection) {
            return $this
                ->useSCallbacksQuery()
                ->filterByPrimaryKeys($sCallbacks->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterBySCallbacks() only accepts arguments of type \SCallbacks or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the SCallbacks relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSCallbackThemesQuery The current query, for fluid interface
     */
    public function joinSCallbacks($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('SCallbacks');

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
            $this->addJoinObject($join, 'SCallbacks');
        }

        return $this;
    }

    /**
     * Use the SCallbacks relation SCallbacks object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \SCallbacksQuery A secondary query class using the current class as primary query
     */
    public function useSCallbacksQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinSCallbacks($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'SCallbacks', '\SCallbacksQuery');
    }

    /**
     * Filter the query by a related \SCallbackThemesI18n object
     *
     * @param \SCallbackThemesI18n|ObjectCollection $sCallbackThemesI18n the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSCallbackThemesQuery The current query, for fluid interface
     */
    public function filterBySCallbackThemesI18n($sCallbackThemesI18n, $comparison = null)
    {
        if ($sCallbackThemesI18n instanceof \SCallbackThemesI18n) {
            return $this
                ->addUsingAlias(SCallbackThemesTableMap::COL_ID, $sCallbackThemesI18n->getId(), $comparison);
        } elseif ($sCallbackThemesI18n instanceof ObjectCollection) {
            return $this
                ->useSCallbackThemesI18nQuery()
                ->filterByPrimaryKeys($sCallbackThemesI18n->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterBySCallbackThemesI18n() only accepts arguments of type \SCallbackThemesI18n or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the SCallbackThemesI18n relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSCallbackThemesQuery The current query, for fluid interface
     */
    public function joinSCallbackThemesI18n($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('SCallbackThemesI18n');

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
            $this->addJoinObject($join, 'SCallbackThemesI18n');
        }

        return $this;
    }

    /**
     * Use the SCallbackThemesI18n relation SCallbackThemesI18n object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \SCallbackThemesI18nQuery A secondary query class using the current class as primary query
     */
    public function useSCallbackThemesI18nQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinSCallbackThemesI18n($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'SCallbackThemesI18n', '\SCallbackThemesI18nQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildSCallbackThemes $sCallbackThemes Object to remove from the list of results
     *
     * @return $this|ChildSCallbackThemesQuery The current query, for fluid interface
     */
    public function prune($sCallbackThemes = null)
    {
        if ($sCallbackThemes) {
            $this->addUsingAlias(SCallbackThemesTableMap::COL_ID, $sCallbackThemes->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the shop_callbacks_themes table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SCallbackThemesTableMap::DATABASE_NAME);
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
            SCallbackThemesTableMap::clearInstancePool();
            SCallbackThemesTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(SCallbackThemesTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(SCallbackThemesTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            // cloning the Criteria in case it's modified by doSelect() or doSelectStmt()
            $c = clone $criteria;
            $affectedRows += $c->doOnDeleteCascade($con);

            SCallbackThemesTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            SCallbackThemesTableMap::clearRelatedInstancePool();

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
        $objects = ChildSCallbackThemesQuery::create(null, $this)->find($con);
        foreach ($objects as $obj) {


            // delete related SCallbackThemesI18n objects
            $query = new \SCallbackThemesI18nQuery;

            $query->add(SCallbackThemesI18nTableMap::COL_ID, $obj->getId());
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
     * @return    ChildSCallbackThemesQuery The current query, for fluid interface
     */
    public function joinI18n($locale = 'ru', $relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $relationName = $relationAlias ? $relationAlias : 'SCallbackThemesI18n';

        return $this
            ->joinSCallbackThemesI18n($relationAlias, $joinType)
            ->addJoinCondition($relationName, $relationName . '.Locale = ?', $locale);
    }

    /**
     * Adds a JOIN clause to the query and hydrates the related I18n object.
     * Shortcut for $c->joinI18n($locale)->with()
     *
     * @param     string $locale Locale to use for the join condition, e.g. 'fr_FR'
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'. Defaults to left join.
     *
     * @return    $this|ChildSCallbackThemesQuery The current query, for fluid interface
     */
    public function joinWithI18n($locale = 'ru', $joinType = Criteria::LEFT_JOIN)
    {
        $this
            ->joinI18n($locale, null, $joinType)
            ->with('SCallbackThemesI18n');
        $this->with['SCallbackThemesI18n']->setIsWithOneToMany(false);

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
     * @return    ChildSCallbackThemesI18nQuery A secondary query class using the current class as primary query
     */
    public function useI18nQuery($locale = 'ru', $relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinI18n($locale, $relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'SCallbackThemesI18n', '\SCallbackThemesI18nQuery');
    }

} // SCallbackThemesQuery
