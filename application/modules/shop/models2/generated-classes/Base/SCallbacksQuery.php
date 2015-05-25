<?php

namespace Base;

use \SCallbacks as ChildSCallbacks;
use \SCallbacksQuery as ChildSCallbacksQuery;
use \Exception;
use \PDO;
use Map\SCallbacksTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'shop_callbacks' table.
 *
 *
 *
 * @method     ChildSCallbacksQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildSCallbacksQuery orderByUserId($order = Criteria::ASC) Order by the user_id column
 * @method     ChildSCallbacksQuery orderByStatusId($order = Criteria::ASC) Order by the status_id column
 * @method     ChildSCallbacksQuery orderByThemeId($order = Criteria::ASC) Order by the theme_id column
 * @method     ChildSCallbacksQuery orderByPhone($order = Criteria::ASC) Order by the phone column
 * @method     ChildSCallbacksQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method     ChildSCallbacksQuery orderByComment($order = Criteria::ASC) Order by the comment column
 * @method     ChildSCallbacksQuery orderByDate($order = Criteria::ASC) Order by the date column
 *
 * @method     ChildSCallbacksQuery groupById() Group by the id column
 * @method     ChildSCallbacksQuery groupByUserId() Group by the user_id column
 * @method     ChildSCallbacksQuery groupByStatusId() Group by the status_id column
 * @method     ChildSCallbacksQuery groupByThemeId() Group by the theme_id column
 * @method     ChildSCallbacksQuery groupByPhone() Group by the phone column
 * @method     ChildSCallbacksQuery groupByName() Group by the name column
 * @method     ChildSCallbacksQuery groupByComment() Group by the comment column
 * @method     ChildSCallbacksQuery groupByDate() Group by the date column
 *
 * @method     ChildSCallbacksQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildSCallbacksQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildSCallbacksQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildSCallbacksQuery leftJoinSCallbackStatuses($relationAlias = null) Adds a LEFT JOIN clause to the query using the SCallbackStatuses relation
 * @method     ChildSCallbacksQuery rightJoinSCallbackStatuses($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SCallbackStatuses relation
 * @method     ChildSCallbacksQuery innerJoinSCallbackStatuses($relationAlias = null) Adds a INNER JOIN clause to the query using the SCallbackStatuses relation
 *
 * @method     ChildSCallbacksQuery leftJoinSCallbackThemes($relationAlias = null) Adds a LEFT JOIN clause to the query using the SCallbackThemes relation
 * @method     ChildSCallbacksQuery rightJoinSCallbackThemes($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SCallbackThemes relation
 * @method     ChildSCallbacksQuery innerJoinSCallbackThemes($relationAlias = null) Adds a INNER JOIN clause to the query using the SCallbackThemes relation
 *
 * @method     \SCallbackStatusesQuery|\SCallbackThemesQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildSCallbacks findOne(ConnectionInterface $con = null) Return the first ChildSCallbacks matching the query
 * @method     ChildSCallbacks findOneOrCreate(ConnectionInterface $con = null) Return the first ChildSCallbacks matching the query, or a new ChildSCallbacks object populated from the query conditions when no match is found
 *
 * @method     ChildSCallbacks findOneById(int $id) Return the first ChildSCallbacks filtered by the id column
 * @method     ChildSCallbacks findOneByUserId(int $user_id) Return the first ChildSCallbacks filtered by the user_id column
 * @method     ChildSCallbacks findOneByStatusId(int $status_id) Return the first ChildSCallbacks filtered by the status_id column
 * @method     ChildSCallbacks findOneByThemeId(int $theme_id) Return the first ChildSCallbacks filtered by the theme_id column
 * @method     ChildSCallbacks findOneByPhone(string $phone) Return the first ChildSCallbacks filtered by the phone column
 * @method     ChildSCallbacks findOneByName(string $name) Return the first ChildSCallbacks filtered by the name column
 * @method     ChildSCallbacks findOneByComment(string $comment) Return the first ChildSCallbacks filtered by the comment column
 * @method     ChildSCallbacks findOneByDate(int $date) Return the first ChildSCallbacks filtered by the date column *

 * @method     ChildSCallbacks requirePk($key, ConnectionInterface $con = null) Return the ChildSCallbacks by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSCallbacks requireOne(ConnectionInterface $con = null) Return the first ChildSCallbacks matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSCallbacks requireOneById(int $id) Return the first ChildSCallbacks filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSCallbacks requireOneByUserId(int $user_id) Return the first ChildSCallbacks filtered by the user_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSCallbacks requireOneByStatusId(int $status_id) Return the first ChildSCallbacks filtered by the status_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSCallbacks requireOneByThemeId(int $theme_id) Return the first ChildSCallbacks filtered by the theme_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSCallbacks requireOneByPhone(string $phone) Return the first ChildSCallbacks filtered by the phone column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSCallbacks requireOneByName(string $name) Return the first ChildSCallbacks filtered by the name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSCallbacks requireOneByComment(string $comment) Return the first ChildSCallbacks filtered by the comment column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSCallbacks requireOneByDate(int $date) Return the first ChildSCallbacks filtered by the date column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSCallbacks[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildSCallbacks objects based on current ModelCriteria
 * @method     ChildSCallbacks[]|ObjectCollection findById(int $id) Return ChildSCallbacks objects filtered by the id column
 * @method     ChildSCallbacks[]|ObjectCollection findByUserId(int $user_id) Return ChildSCallbacks objects filtered by the user_id column
 * @method     ChildSCallbacks[]|ObjectCollection findByStatusId(int $status_id) Return ChildSCallbacks objects filtered by the status_id column
 * @method     ChildSCallbacks[]|ObjectCollection findByThemeId(int $theme_id) Return ChildSCallbacks objects filtered by the theme_id column
 * @method     ChildSCallbacks[]|ObjectCollection findByPhone(string $phone) Return ChildSCallbacks objects filtered by the phone column
 * @method     ChildSCallbacks[]|ObjectCollection findByName(string $name) Return ChildSCallbacks objects filtered by the name column
 * @method     ChildSCallbacks[]|ObjectCollection findByComment(string $comment) Return ChildSCallbacks objects filtered by the comment column
 * @method     ChildSCallbacks[]|ObjectCollection findByDate(int $date) Return ChildSCallbacks objects filtered by the date column
 * @method     ChildSCallbacks[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class SCallbacksQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\SCallbacksQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'Shop', $modelName = '\\SCallbacks', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildSCallbacksQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildSCallbacksQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildSCallbacksQuery) {
            return $criteria;
        }
        $query = new ChildSCallbacksQuery();
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
     * @return ChildSCallbacks|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = SCallbacksTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(SCallbacksTableMap::DATABASE_NAME);
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
     * @return ChildSCallbacks A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, user_id, status_id, theme_id, phone, name, comment, date FROM shop_callbacks WHERE id = :p0';
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
            /** @var ChildSCallbacks $obj */
            $obj = new ChildSCallbacks();
            $obj->hydrate($row);
            SCallbacksTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildSCallbacks|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildSCallbacksQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(SCallbacksTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildSCallbacksQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(SCallbacksTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildSCallbacksQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(SCallbacksTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(SCallbacksTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SCallbacksTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the user_id column
     *
     * Example usage:
     * <code>
     * $query->filterByUserId(1234); // WHERE user_id = 1234
     * $query->filterByUserId(array(12, 34)); // WHERE user_id IN (12, 34)
     * $query->filterByUserId(array('min' => 12)); // WHERE user_id > 12
     * </code>
     *
     * @param     mixed $userId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSCallbacksQuery The current query, for fluid interface
     */
    public function filterByUserId($userId = null, $comparison = null)
    {
        if (is_array($userId)) {
            $useMinMax = false;
            if (isset($userId['min'])) {
                $this->addUsingAlias(SCallbacksTableMap::COL_USER_ID, $userId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($userId['max'])) {
                $this->addUsingAlias(SCallbacksTableMap::COL_USER_ID, $userId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SCallbacksTableMap::COL_USER_ID, $userId, $comparison);
    }

    /**
     * Filter the query on the status_id column
     *
     * Example usage:
     * <code>
     * $query->filterByStatusId(1234); // WHERE status_id = 1234
     * $query->filterByStatusId(array(12, 34)); // WHERE status_id IN (12, 34)
     * $query->filterByStatusId(array('min' => 12)); // WHERE status_id > 12
     * </code>
     *
     * @see       filterBySCallbackStatuses()
     *
     * @param     mixed $statusId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSCallbacksQuery The current query, for fluid interface
     */
    public function filterByStatusId($statusId = null, $comparison = null)
    {
        if (is_array($statusId)) {
            $useMinMax = false;
            if (isset($statusId['min'])) {
                $this->addUsingAlias(SCallbacksTableMap::COL_STATUS_ID, $statusId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($statusId['max'])) {
                $this->addUsingAlias(SCallbacksTableMap::COL_STATUS_ID, $statusId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SCallbacksTableMap::COL_STATUS_ID, $statusId, $comparison);
    }

    /**
     * Filter the query on the theme_id column
     *
     * Example usage:
     * <code>
     * $query->filterByThemeId(1234); // WHERE theme_id = 1234
     * $query->filterByThemeId(array(12, 34)); // WHERE theme_id IN (12, 34)
     * $query->filterByThemeId(array('min' => 12)); // WHERE theme_id > 12
     * </code>
     *
     * @see       filterBySCallbackThemes()
     *
     * @param     mixed $themeId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSCallbacksQuery The current query, for fluid interface
     */
    public function filterByThemeId($themeId = null, $comparison = null)
    {
        if (is_array($themeId)) {
            $useMinMax = false;
            if (isset($themeId['min'])) {
                $this->addUsingAlias(SCallbacksTableMap::COL_THEME_ID, $themeId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($themeId['max'])) {
                $this->addUsingAlias(SCallbacksTableMap::COL_THEME_ID, $themeId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SCallbacksTableMap::COL_THEME_ID, $themeId, $comparison);
    }

    /**
     * Filter the query on the phone column
     *
     * Example usage:
     * <code>
     * $query->filterByPhone('fooValue');   // WHERE phone = 'fooValue'
     * $query->filterByPhone('%fooValue%'); // WHERE phone LIKE '%fooValue%'
     * </code>
     *
     * @param     string $phone The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSCallbacksQuery The current query, for fluid interface
     */
    public function filterByPhone($phone = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($phone)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $phone)) {
                $phone = str_replace('*', '%', $phone);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SCallbacksTableMap::COL_PHONE, $phone, $comparison);
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
     * @return $this|ChildSCallbacksQuery The current query, for fluid interface
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

        return $this->addUsingAlias(SCallbacksTableMap::COL_NAME, $name, $comparison);
    }

    /**
     * Filter the query on the comment column
     *
     * Example usage:
     * <code>
     * $query->filterByComment('fooValue');   // WHERE comment = 'fooValue'
     * $query->filterByComment('%fooValue%'); // WHERE comment LIKE '%fooValue%'
     * </code>
     *
     * @param     string $comment The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSCallbacksQuery The current query, for fluid interface
     */
    public function filterByComment($comment = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($comment)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $comment)) {
                $comment = str_replace('*', '%', $comment);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SCallbacksTableMap::COL_COMMENT, $comment, $comparison);
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
     * @return $this|ChildSCallbacksQuery The current query, for fluid interface
     */
    public function filterByDate($date = null, $comparison = null)
    {
        if (is_array($date)) {
            $useMinMax = false;
            if (isset($date['min'])) {
                $this->addUsingAlias(SCallbacksTableMap::COL_DATE, $date['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($date['max'])) {
                $this->addUsingAlias(SCallbacksTableMap::COL_DATE, $date['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SCallbacksTableMap::COL_DATE, $date, $comparison);
    }

    /**
     * Filter the query by a related \SCallbackStatuses object
     *
     * @param \SCallbackStatuses|ObjectCollection $sCallbackStatuses The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildSCallbacksQuery The current query, for fluid interface
     */
    public function filterBySCallbackStatuses($sCallbackStatuses, $comparison = null)
    {
        if ($sCallbackStatuses instanceof \SCallbackStatuses) {
            return $this
                ->addUsingAlias(SCallbacksTableMap::COL_STATUS_ID, $sCallbackStatuses->getId(), $comparison);
        } elseif ($sCallbackStatuses instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(SCallbacksTableMap::COL_STATUS_ID, $sCallbackStatuses->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildSCallbacksQuery The current query, for fluid interface
     */
    public function joinSCallbackStatuses($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
    public function useSCallbackStatusesQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinSCallbackStatuses($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'SCallbackStatuses', '\SCallbackStatusesQuery');
    }

    /**
     * Filter the query by a related \SCallbackThemes object
     *
     * @param \SCallbackThemes|ObjectCollection $sCallbackThemes The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildSCallbacksQuery The current query, for fluid interface
     */
    public function filterBySCallbackThemes($sCallbackThemes, $comparison = null)
    {
        if ($sCallbackThemes instanceof \SCallbackThemes) {
            return $this
                ->addUsingAlias(SCallbacksTableMap::COL_THEME_ID, $sCallbackThemes->getId(), $comparison);
        } elseif ($sCallbackThemes instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(SCallbacksTableMap::COL_THEME_ID, $sCallbackThemes->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterBySCallbackThemes() only accepts arguments of type \SCallbackThemes or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the SCallbackThemes relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSCallbacksQuery The current query, for fluid interface
     */
    public function joinSCallbackThemes($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('SCallbackThemes');

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
            $this->addJoinObject($join, 'SCallbackThemes');
        }

        return $this;
    }

    /**
     * Use the SCallbackThemes relation SCallbackThemes object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \SCallbackThemesQuery A secondary query class using the current class as primary query
     */
    public function useSCallbackThemesQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinSCallbackThemes($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'SCallbackThemes', '\SCallbackThemesQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildSCallbacks $sCallbacks Object to remove from the list of results
     *
     * @return $this|ChildSCallbacksQuery The current query, for fluid interface
     */
    public function prune($sCallbacks = null)
    {
        if ($sCallbacks) {
            $this->addUsingAlias(SCallbacksTableMap::COL_ID, $sCallbacks->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the shop_callbacks table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SCallbacksTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            SCallbacksTableMap::clearInstancePool();
            SCallbacksTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(SCallbacksTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(SCallbacksTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            SCallbacksTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            SCallbacksTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // SCallbacksQuery
