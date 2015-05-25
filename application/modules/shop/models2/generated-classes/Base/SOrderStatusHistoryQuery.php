<?php

namespace Base;

use \SOrderStatusHistory as ChildSOrderStatusHistory;
use \SOrderStatusHistoryQuery as ChildSOrderStatusHistoryQuery;
use \Exception;
use \PDO;
use Map\SOrderStatusHistoryTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'shop_orders_status_history' table.
 *
 *
 *
 * @method     ChildSOrderStatusHistoryQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildSOrderStatusHistoryQuery orderByOrderId($order = Criteria::ASC) Order by the order_id column
 * @method     ChildSOrderStatusHistoryQuery orderByStatusId($order = Criteria::ASC) Order by the status_id column
 * @method     ChildSOrderStatusHistoryQuery orderByUserId($order = Criteria::ASC) Order by the user_id column
 * @method     ChildSOrderStatusHistoryQuery orderByDateCreated($order = Criteria::ASC) Order by the date_created column
 * @method     ChildSOrderStatusHistoryQuery orderByComment($order = Criteria::ASC) Order by the comment column
 *
 * @method     ChildSOrderStatusHistoryQuery groupById() Group by the id column
 * @method     ChildSOrderStatusHistoryQuery groupByOrderId() Group by the order_id column
 * @method     ChildSOrderStatusHistoryQuery groupByStatusId() Group by the status_id column
 * @method     ChildSOrderStatusHistoryQuery groupByUserId() Group by the user_id column
 * @method     ChildSOrderStatusHistoryQuery groupByDateCreated() Group by the date_created column
 * @method     ChildSOrderStatusHistoryQuery groupByComment() Group by the comment column
 *
 * @method     ChildSOrderStatusHistoryQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildSOrderStatusHistoryQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildSOrderStatusHistoryQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildSOrderStatusHistoryQuery leftJoinSOrders($relationAlias = null) Adds a LEFT JOIN clause to the query using the SOrders relation
 * @method     ChildSOrderStatusHistoryQuery rightJoinSOrders($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SOrders relation
 * @method     ChildSOrderStatusHistoryQuery innerJoinSOrders($relationAlias = null) Adds a INNER JOIN clause to the query using the SOrders relation
 *
 * @method     ChildSOrderStatusHistoryQuery leftJoinSOrderStatuses($relationAlias = null) Adds a LEFT JOIN clause to the query using the SOrderStatuses relation
 * @method     ChildSOrderStatusHistoryQuery rightJoinSOrderStatuses($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SOrderStatuses relation
 * @method     ChildSOrderStatusHistoryQuery innerJoinSOrderStatuses($relationAlias = null) Adds a INNER JOIN clause to the query using the SOrderStatuses relation
 *
 * @method     \SOrdersQuery|\SOrderStatusesQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildSOrderStatusHistory findOne(ConnectionInterface $con = null) Return the first ChildSOrderStatusHistory matching the query
 * @method     ChildSOrderStatusHistory findOneOrCreate(ConnectionInterface $con = null) Return the first ChildSOrderStatusHistory matching the query, or a new ChildSOrderStatusHistory object populated from the query conditions when no match is found
 *
 * @method     ChildSOrderStatusHistory findOneById(int $id) Return the first ChildSOrderStatusHistory filtered by the id column
 * @method     ChildSOrderStatusHistory findOneByOrderId(int $order_id) Return the first ChildSOrderStatusHistory filtered by the order_id column
 * @method     ChildSOrderStatusHistory findOneByStatusId(int $status_id) Return the first ChildSOrderStatusHistory filtered by the status_id column
 * @method     ChildSOrderStatusHistory findOneByUserId(int $user_id) Return the first ChildSOrderStatusHistory filtered by the user_id column
 * @method     ChildSOrderStatusHistory findOneByDateCreated(int $date_created) Return the first ChildSOrderStatusHistory filtered by the date_created column
 * @method     ChildSOrderStatusHistory findOneByComment(string $comment) Return the first ChildSOrderStatusHistory filtered by the comment column *

 * @method     ChildSOrderStatusHistory requirePk($key, ConnectionInterface $con = null) Return the ChildSOrderStatusHistory by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSOrderStatusHistory requireOne(ConnectionInterface $con = null) Return the first ChildSOrderStatusHistory matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSOrderStatusHistory requireOneById(int $id) Return the first ChildSOrderStatusHistory filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSOrderStatusHistory requireOneByOrderId(int $order_id) Return the first ChildSOrderStatusHistory filtered by the order_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSOrderStatusHistory requireOneByStatusId(int $status_id) Return the first ChildSOrderStatusHistory filtered by the status_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSOrderStatusHistory requireOneByUserId(int $user_id) Return the first ChildSOrderStatusHistory filtered by the user_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSOrderStatusHistory requireOneByDateCreated(int $date_created) Return the first ChildSOrderStatusHistory filtered by the date_created column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSOrderStatusHistory requireOneByComment(string $comment) Return the first ChildSOrderStatusHistory filtered by the comment column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSOrderStatusHistory[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildSOrderStatusHistory objects based on current ModelCriteria
 * @method     ChildSOrderStatusHistory[]|ObjectCollection findById(int $id) Return ChildSOrderStatusHistory objects filtered by the id column
 * @method     ChildSOrderStatusHistory[]|ObjectCollection findByOrderId(int $order_id) Return ChildSOrderStatusHistory objects filtered by the order_id column
 * @method     ChildSOrderStatusHistory[]|ObjectCollection findByStatusId(int $status_id) Return ChildSOrderStatusHistory objects filtered by the status_id column
 * @method     ChildSOrderStatusHistory[]|ObjectCollection findByUserId(int $user_id) Return ChildSOrderStatusHistory objects filtered by the user_id column
 * @method     ChildSOrderStatusHistory[]|ObjectCollection findByDateCreated(int $date_created) Return ChildSOrderStatusHistory objects filtered by the date_created column
 * @method     ChildSOrderStatusHistory[]|ObjectCollection findByComment(string $comment) Return ChildSOrderStatusHistory objects filtered by the comment column
 * @method     ChildSOrderStatusHistory[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class SOrderStatusHistoryQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\SOrderStatusHistoryQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'Shop', $modelName = '\\SOrderStatusHistory', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildSOrderStatusHistoryQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildSOrderStatusHistoryQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildSOrderStatusHistoryQuery) {
            return $criteria;
        }
        $query = new ChildSOrderStatusHistoryQuery();
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
     * @return ChildSOrderStatusHistory|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = SOrderStatusHistoryTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(SOrderStatusHistoryTableMap::DATABASE_NAME);
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
     * @return ChildSOrderStatusHistory A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, order_id, status_id, user_id, date_created, comment FROM shop_orders_status_history WHERE id = :p0';
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
            /** @var ChildSOrderStatusHistory $obj */
            $obj = new ChildSOrderStatusHistory();
            $obj->hydrate($row);
            SOrderStatusHistoryTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildSOrderStatusHistory|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildSOrderStatusHistoryQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(SOrderStatusHistoryTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildSOrderStatusHistoryQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(SOrderStatusHistoryTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildSOrderStatusHistoryQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(SOrderStatusHistoryTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(SOrderStatusHistoryTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SOrderStatusHistoryTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the order_id column
     *
     * Example usage:
     * <code>
     * $query->filterByOrderId(1234); // WHERE order_id = 1234
     * $query->filterByOrderId(array(12, 34)); // WHERE order_id IN (12, 34)
     * $query->filterByOrderId(array('min' => 12)); // WHERE order_id > 12
     * </code>
     *
     * @see       filterBySOrders()
     *
     * @param     mixed $orderId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSOrderStatusHistoryQuery The current query, for fluid interface
     */
    public function filterByOrderId($orderId = null, $comparison = null)
    {
        if (is_array($orderId)) {
            $useMinMax = false;
            if (isset($orderId['min'])) {
                $this->addUsingAlias(SOrderStatusHistoryTableMap::COL_ORDER_ID, $orderId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($orderId['max'])) {
                $this->addUsingAlias(SOrderStatusHistoryTableMap::COL_ORDER_ID, $orderId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SOrderStatusHistoryTableMap::COL_ORDER_ID, $orderId, $comparison);
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
     * @see       filterBySOrderStatuses()
     *
     * @param     mixed $statusId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSOrderStatusHistoryQuery The current query, for fluid interface
     */
    public function filterByStatusId($statusId = null, $comparison = null)
    {
        if (is_array($statusId)) {
            $useMinMax = false;
            if (isset($statusId['min'])) {
                $this->addUsingAlias(SOrderStatusHistoryTableMap::COL_STATUS_ID, $statusId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($statusId['max'])) {
                $this->addUsingAlias(SOrderStatusHistoryTableMap::COL_STATUS_ID, $statusId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SOrderStatusHistoryTableMap::COL_STATUS_ID, $statusId, $comparison);
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
     * @return $this|ChildSOrderStatusHistoryQuery The current query, for fluid interface
     */
    public function filterByUserId($userId = null, $comparison = null)
    {
        if (is_array($userId)) {
            $useMinMax = false;
            if (isset($userId['min'])) {
                $this->addUsingAlias(SOrderStatusHistoryTableMap::COL_USER_ID, $userId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($userId['max'])) {
                $this->addUsingAlias(SOrderStatusHistoryTableMap::COL_USER_ID, $userId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SOrderStatusHistoryTableMap::COL_USER_ID, $userId, $comparison);
    }

    /**
     * Filter the query on the date_created column
     *
     * Example usage:
     * <code>
     * $query->filterByDateCreated(1234); // WHERE date_created = 1234
     * $query->filterByDateCreated(array(12, 34)); // WHERE date_created IN (12, 34)
     * $query->filterByDateCreated(array('min' => 12)); // WHERE date_created > 12
     * </code>
     *
     * @param     mixed $dateCreated The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSOrderStatusHistoryQuery The current query, for fluid interface
     */
    public function filterByDateCreated($dateCreated = null, $comparison = null)
    {
        if (is_array($dateCreated)) {
            $useMinMax = false;
            if (isset($dateCreated['min'])) {
                $this->addUsingAlias(SOrderStatusHistoryTableMap::COL_DATE_CREATED, $dateCreated['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dateCreated['max'])) {
                $this->addUsingAlias(SOrderStatusHistoryTableMap::COL_DATE_CREATED, $dateCreated['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SOrderStatusHistoryTableMap::COL_DATE_CREATED, $dateCreated, $comparison);
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
     * @return $this|ChildSOrderStatusHistoryQuery The current query, for fluid interface
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

        return $this->addUsingAlias(SOrderStatusHistoryTableMap::COL_COMMENT, $comment, $comparison);
    }

    /**
     * Filter the query by a related \SOrders object
     *
     * @param \SOrders|ObjectCollection $sOrders The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildSOrderStatusHistoryQuery The current query, for fluid interface
     */
    public function filterBySOrders($sOrders, $comparison = null)
    {
        if ($sOrders instanceof \SOrders) {
            return $this
                ->addUsingAlias(SOrderStatusHistoryTableMap::COL_ORDER_ID, $sOrders->getId(), $comparison);
        } elseif ($sOrders instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(SOrderStatusHistoryTableMap::COL_ORDER_ID, $sOrders->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildSOrderStatusHistoryQuery The current query, for fluid interface
     */
    public function joinSOrders($relationAlias = null, $joinType = Criteria::INNER_JOIN)
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
    public function useSOrdersQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinSOrders($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'SOrders', '\SOrdersQuery');
    }

    /**
     * Filter the query by a related \SOrderStatuses object
     *
     * @param \SOrderStatuses|ObjectCollection $sOrderStatuses The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildSOrderStatusHistoryQuery The current query, for fluid interface
     */
    public function filterBySOrderStatuses($sOrderStatuses, $comparison = null)
    {
        if ($sOrderStatuses instanceof \SOrderStatuses) {
            return $this
                ->addUsingAlias(SOrderStatusHistoryTableMap::COL_STATUS_ID, $sOrderStatuses->getId(), $comparison);
        } elseif ($sOrderStatuses instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(SOrderStatusHistoryTableMap::COL_STATUS_ID, $sOrderStatuses->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterBySOrderStatuses() only accepts arguments of type \SOrderStatuses or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the SOrderStatuses relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSOrderStatusHistoryQuery The current query, for fluid interface
     */
    public function joinSOrderStatuses($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('SOrderStatuses');

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
            $this->addJoinObject($join, 'SOrderStatuses');
        }

        return $this;
    }

    /**
     * Use the SOrderStatuses relation SOrderStatuses object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \SOrderStatusesQuery A secondary query class using the current class as primary query
     */
    public function useSOrderStatusesQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinSOrderStatuses($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'SOrderStatuses', '\SOrderStatusesQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildSOrderStatusHistory $sOrderStatusHistory Object to remove from the list of results
     *
     * @return $this|ChildSOrderStatusHistoryQuery The current query, for fluid interface
     */
    public function prune($sOrderStatusHistory = null)
    {
        if ($sOrderStatusHistory) {
            $this->addUsingAlias(SOrderStatusHistoryTableMap::COL_ID, $sOrderStatusHistory->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the shop_orders_status_history table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SOrderStatusHistoryTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            SOrderStatusHistoryTableMap::clearInstancePool();
            SOrderStatusHistoryTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(SOrderStatusHistoryTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(SOrderStatusHistoryTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            SOrderStatusHistoryTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            SOrderStatusHistoryTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // SOrderStatusHistoryQuery
