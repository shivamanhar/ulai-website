<?php

namespace Base;

use \SCallbackStatusesI18n as ChildSCallbackStatusesI18n;
use \SCallbackStatusesI18nQuery as ChildSCallbackStatusesI18nQuery;
use \Exception;
use \PDO;
use Map\SCallbackStatusesI18nTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'shop_callbacks_statuses_i18n' table.
 *
 *
 *
 * @method     ChildSCallbackStatusesI18nQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildSCallbackStatusesI18nQuery orderByLocale($order = Criteria::ASC) Order by the locale column
 * @method     ChildSCallbackStatusesI18nQuery orderByText($order = Criteria::ASC) Order by the text column
 *
 * @method     ChildSCallbackStatusesI18nQuery groupById() Group by the id column
 * @method     ChildSCallbackStatusesI18nQuery groupByLocale() Group by the locale column
 * @method     ChildSCallbackStatusesI18nQuery groupByText() Group by the text column
 *
 * @method     ChildSCallbackStatusesI18nQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildSCallbackStatusesI18nQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildSCallbackStatusesI18nQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildSCallbackStatusesI18nQuery leftJoinSCallbackStatuses($relationAlias = null) Adds a LEFT JOIN clause to the query using the SCallbackStatuses relation
 * @method     ChildSCallbackStatusesI18nQuery rightJoinSCallbackStatuses($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SCallbackStatuses relation
 * @method     ChildSCallbackStatusesI18nQuery innerJoinSCallbackStatuses($relationAlias = null) Adds a INNER JOIN clause to the query using the SCallbackStatuses relation
 *
 * @method     \SCallbackStatusesQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildSCallbackStatusesI18n findOne(ConnectionInterface $con = null) Return the first ChildSCallbackStatusesI18n matching the query
 * @method     ChildSCallbackStatusesI18n findOneOrCreate(ConnectionInterface $con = null) Return the first ChildSCallbackStatusesI18n matching the query, or a new ChildSCallbackStatusesI18n object populated from the query conditions when no match is found
 *
 * @method     ChildSCallbackStatusesI18n findOneById(int $id) Return the first ChildSCallbackStatusesI18n filtered by the id column
 * @method     ChildSCallbackStatusesI18n findOneByLocale(string $locale) Return the first ChildSCallbackStatusesI18n filtered by the locale column
 * @method     ChildSCallbackStatusesI18n findOneByText(string $text) Return the first ChildSCallbackStatusesI18n filtered by the text column *

 * @method     ChildSCallbackStatusesI18n requirePk($key, ConnectionInterface $con = null) Return the ChildSCallbackStatusesI18n by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSCallbackStatusesI18n requireOne(ConnectionInterface $con = null) Return the first ChildSCallbackStatusesI18n matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSCallbackStatusesI18n requireOneById(int $id) Return the first ChildSCallbackStatusesI18n filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSCallbackStatusesI18n requireOneByLocale(string $locale) Return the first ChildSCallbackStatusesI18n filtered by the locale column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSCallbackStatusesI18n requireOneByText(string $text) Return the first ChildSCallbackStatusesI18n filtered by the text column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSCallbackStatusesI18n[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildSCallbackStatusesI18n objects based on current ModelCriteria
 * @method     ChildSCallbackStatusesI18n[]|ObjectCollection findById(int $id) Return ChildSCallbackStatusesI18n objects filtered by the id column
 * @method     ChildSCallbackStatusesI18n[]|ObjectCollection findByLocale(string $locale) Return ChildSCallbackStatusesI18n objects filtered by the locale column
 * @method     ChildSCallbackStatusesI18n[]|ObjectCollection findByText(string $text) Return ChildSCallbackStatusesI18n objects filtered by the text column
 * @method     ChildSCallbackStatusesI18n[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class SCallbackStatusesI18nQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\SCallbackStatusesI18nQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'Shop', $modelName = '\\SCallbackStatusesI18n', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildSCallbackStatusesI18nQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildSCallbackStatusesI18nQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildSCallbackStatusesI18nQuery) {
            return $criteria;
        }
        $query = new ChildSCallbackStatusesI18nQuery();
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
     * $obj = $c->findPk(array(12, 34), $con);
     * </code>
     *
     * @param array[$id, $locale] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildSCallbackStatusesI18n|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = SCallbackStatusesI18nTableMap::getInstanceFromPool(serialize(array((string) $key[0], (string) $key[1]))))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(SCallbackStatusesI18nTableMap::DATABASE_NAME);
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
     * @return ChildSCallbackStatusesI18n A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, locale, text FROM shop_callbacks_statuses_i18n WHERE id = :p0 AND locale = :p1';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key[0], PDO::PARAM_INT);
            $stmt->bindValue(':p1', $key[1], PDO::PARAM_STR);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildSCallbackStatusesI18n $obj */
            $obj = new ChildSCallbackStatusesI18n();
            $obj->hydrate($row);
            SCallbackStatusesI18nTableMap::addInstanceToPool($obj, serialize(array((string) $key[0], (string) $key[1])));
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
     * @return ChildSCallbackStatusesI18n|array|mixed the result, formatted by the current formatter
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
     * $objs = $c->findPks(array(array(12, 56), array(832, 123), array(123, 456)), $con);
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
     * @return $this|ChildSCallbackStatusesI18nQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(SCallbackStatusesI18nTableMap::COL_ID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(SCallbackStatusesI18nTableMap::COL_LOCALE, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildSCallbackStatusesI18nQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(SCallbackStatusesI18nTableMap::COL_ID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(SCallbackStatusesI18nTableMap::COL_LOCALE, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $this->addOr($cton0);
        }

        return $this;
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
     * @see       filterBySCallbackStatuses()
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSCallbackStatusesI18nQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(SCallbackStatusesI18nTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(SCallbackStatusesI18nTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SCallbackStatusesI18nTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildSCallbackStatusesI18nQuery The current query, for fluid interface
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

        return $this->addUsingAlias(SCallbackStatusesI18nTableMap::COL_LOCALE, $locale, $comparison);
    }

    /**
     * Filter the query on the text column
     *
     * Example usage:
     * <code>
     * $query->filterByText('fooValue');   // WHERE text = 'fooValue'
     * $query->filterByText('%fooValue%'); // WHERE text LIKE '%fooValue%'
     * </code>
     *
     * @param     string $text The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSCallbackStatusesI18nQuery The current query, for fluid interface
     */
    public function filterByText($text = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($text)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $text)) {
                $text = str_replace('*', '%', $text);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SCallbackStatusesI18nTableMap::COL_TEXT, $text, $comparison);
    }

    /**
     * Filter the query by a related \SCallbackStatuses object
     *
     * @param \SCallbackStatuses|ObjectCollection $sCallbackStatuses The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildSCallbackStatusesI18nQuery The current query, for fluid interface
     */
    public function filterBySCallbackStatuses($sCallbackStatuses, $comparison = null)
    {
        if ($sCallbackStatuses instanceof \SCallbackStatuses) {
            return $this
                ->addUsingAlias(SCallbackStatusesI18nTableMap::COL_ID, $sCallbackStatuses->getId(), $comparison);
        } elseif ($sCallbackStatuses instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(SCallbackStatusesI18nTableMap::COL_ID, $sCallbackStatuses->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterBySCallbackStatuses() only accepts arguments of type \SCallbackStatuses or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the SCallbackStatuses relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSCallbackStatusesI18nQuery The current query, for fluid interface
     */
    public function joinSCallbackStatuses($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('SCallbackStatuses');

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
            $this->addJoinObject($join, 'SCallbackStatuses');
        }

        return $this;
    }

    /**
     * Use the SCallbackStatuses relation SCallbackStatuses object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \SCallbackStatusesQuery A secondary query class using the current class as primary query
     */
    public function useSCallbackStatusesQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinSCallbackStatuses($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'SCallbackStatuses', '\SCallbackStatusesQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildSCallbackStatusesI18n $sCallbackStatusesI18n Object to remove from the list of results
     *
     * @return $this|ChildSCallbackStatusesI18nQuery The current query, for fluid interface
     */
    public function prune($sCallbackStatusesI18n = null)
    {
        if ($sCallbackStatusesI18n) {
            $this->addCond('pruneCond0', $this->getAliasedColName(SCallbackStatusesI18nTableMap::COL_ID), $sCallbackStatusesI18n->getId(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(SCallbackStatusesI18nTableMap::COL_LOCALE), $sCallbackStatusesI18n->getLocale(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the shop_callbacks_statuses_i18n table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SCallbackStatusesI18nTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            SCallbackStatusesI18nTableMap::clearInstancePool();
            SCallbackStatusesI18nTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(SCallbackStatusesI18nTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(SCallbackStatusesI18nTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            SCallbackStatusesI18nTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            SCallbackStatusesI18nTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // SCallbackStatusesI18nQuery
