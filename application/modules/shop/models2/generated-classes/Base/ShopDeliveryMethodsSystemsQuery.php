<?php

namespace Base;

use \ShopDeliveryMethodsSystems as ChildShopDeliveryMethodsSystems;
use \ShopDeliveryMethodsSystemsQuery as ChildShopDeliveryMethodsSystemsQuery;
use \Exception;
use \PDO;
use Map\ShopDeliveryMethodsSystemsTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'shop_delivery_methods_systems' table.
 *
 *
 *
 * @method     ChildShopDeliveryMethodsSystemsQuery orderByDeliveryMethodId($order = Criteria::ASC) Order by the delivery_method_id column
 * @method     ChildShopDeliveryMethodsSystemsQuery orderByPaymentMethodId($order = Criteria::ASC) Order by the payment_method_id column
 *
 * @method     ChildShopDeliveryMethodsSystemsQuery groupByDeliveryMethodId() Group by the delivery_method_id column
 * @method     ChildShopDeliveryMethodsSystemsQuery groupByPaymentMethodId() Group by the payment_method_id column
 *
 * @method     ChildShopDeliveryMethodsSystemsQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildShopDeliveryMethodsSystemsQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildShopDeliveryMethodsSystemsQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildShopDeliveryMethodsSystemsQuery leftJoinSDeliveryMethods($relationAlias = null) Adds a LEFT JOIN clause to the query using the SDeliveryMethods relation
 * @method     ChildShopDeliveryMethodsSystemsQuery rightJoinSDeliveryMethods($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SDeliveryMethods relation
 * @method     ChildShopDeliveryMethodsSystemsQuery innerJoinSDeliveryMethods($relationAlias = null) Adds a INNER JOIN clause to the query using the SDeliveryMethods relation
 *
 * @method     ChildShopDeliveryMethodsSystemsQuery leftJoinPaymentMethods($relationAlias = null) Adds a LEFT JOIN clause to the query using the PaymentMethods relation
 * @method     ChildShopDeliveryMethodsSystemsQuery rightJoinPaymentMethods($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PaymentMethods relation
 * @method     ChildShopDeliveryMethodsSystemsQuery innerJoinPaymentMethods($relationAlias = null) Adds a INNER JOIN clause to the query using the PaymentMethods relation
 *
 * @method     \SDeliveryMethodsQuery|\SPaymentMethodsQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildShopDeliveryMethodsSystems findOne(ConnectionInterface $con = null) Return the first ChildShopDeliveryMethodsSystems matching the query
 * @method     ChildShopDeliveryMethodsSystems findOneOrCreate(ConnectionInterface $con = null) Return the first ChildShopDeliveryMethodsSystems matching the query, or a new ChildShopDeliveryMethodsSystems object populated from the query conditions when no match is found
 *
 * @method     ChildShopDeliveryMethodsSystems findOneByDeliveryMethodId(int $delivery_method_id) Return the first ChildShopDeliveryMethodsSystems filtered by the delivery_method_id column
 * @method     ChildShopDeliveryMethodsSystems findOneByPaymentMethodId(int $payment_method_id) Return the first ChildShopDeliveryMethodsSystems filtered by the payment_method_id column *

 * @method     ChildShopDeliveryMethodsSystems requirePk($key, ConnectionInterface $con = null) Return the ChildShopDeliveryMethodsSystems by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildShopDeliveryMethodsSystems requireOne(ConnectionInterface $con = null) Return the first ChildShopDeliveryMethodsSystems matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildShopDeliveryMethodsSystems requireOneByDeliveryMethodId(int $delivery_method_id) Return the first ChildShopDeliveryMethodsSystems filtered by the delivery_method_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildShopDeliveryMethodsSystems requireOneByPaymentMethodId(int $payment_method_id) Return the first ChildShopDeliveryMethodsSystems filtered by the payment_method_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildShopDeliveryMethodsSystems[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildShopDeliveryMethodsSystems objects based on current ModelCriteria
 * @method     ChildShopDeliveryMethodsSystems[]|ObjectCollection findByDeliveryMethodId(int $delivery_method_id) Return ChildShopDeliveryMethodsSystems objects filtered by the delivery_method_id column
 * @method     ChildShopDeliveryMethodsSystems[]|ObjectCollection findByPaymentMethodId(int $payment_method_id) Return ChildShopDeliveryMethodsSystems objects filtered by the payment_method_id column
 * @method     ChildShopDeliveryMethodsSystems[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class ShopDeliveryMethodsSystemsQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\ShopDeliveryMethodsSystemsQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'Shop', $modelName = '\\ShopDeliveryMethodsSystems', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildShopDeliveryMethodsSystemsQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildShopDeliveryMethodsSystemsQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildShopDeliveryMethodsSystemsQuery) {
            return $criteria;
        }
        $query = new ChildShopDeliveryMethodsSystemsQuery();
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
     * @param array[$delivery_method_id, $payment_method_id] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildShopDeliveryMethodsSystems|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ShopDeliveryMethodsSystemsTableMap::getInstanceFromPool(serialize(array((string) $key[0], (string) $key[1]))))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ShopDeliveryMethodsSystemsTableMap::DATABASE_NAME);
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
     * @return ChildShopDeliveryMethodsSystems A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT delivery_method_id, payment_method_id FROM shop_delivery_methods_systems WHERE delivery_method_id = :p0 AND payment_method_id = :p1';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key[0], PDO::PARAM_INT);
            $stmt->bindValue(':p1', $key[1], PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildShopDeliveryMethodsSystems $obj */
            $obj = new ChildShopDeliveryMethodsSystems();
            $obj->hydrate($row);
            ShopDeliveryMethodsSystemsTableMap::addInstanceToPool($obj, serialize(array((string) $key[0], (string) $key[1])));
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
     * @return ChildShopDeliveryMethodsSystems|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildShopDeliveryMethodsSystemsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(ShopDeliveryMethodsSystemsTableMap::COL_DELIVERY_METHOD_ID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(ShopDeliveryMethodsSystemsTableMap::COL_PAYMENT_METHOD_ID, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildShopDeliveryMethodsSystemsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(ShopDeliveryMethodsSystemsTableMap::COL_DELIVERY_METHOD_ID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(ShopDeliveryMethodsSystemsTableMap::COL_PAYMENT_METHOD_ID, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $this->addOr($cton0);
        }

        return $this;
    }

    /**
     * Filter the query on the delivery_method_id column
     *
     * Example usage:
     * <code>
     * $query->filterByDeliveryMethodId(1234); // WHERE delivery_method_id = 1234
     * $query->filterByDeliveryMethodId(array(12, 34)); // WHERE delivery_method_id IN (12, 34)
     * $query->filterByDeliveryMethodId(array('min' => 12)); // WHERE delivery_method_id > 12
     * </code>
     *
     * @see       filterBySDeliveryMethods()
     *
     * @param     mixed $deliveryMethodId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildShopDeliveryMethodsSystemsQuery The current query, for fluid interface
     */
    public function filterByDeliveryMethodId($deliveryMethodId = null, $comparison = null)
    {
        if (is_array($deliveryMethodId)) {
            $useMinMax = false;
            if (isset($deliveryMethodId['min'])) {
                $this->addUsingAlias(ShopDeliveryMethodsSystemsTableMap::COL_DELIVERY_METHOD_ID, $deliveryMethodId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($deliveryMethodId['max'])) {
                $this->addUsingAlias(ShopDeliveryMethodsSystemsTableMap::COL_DELIVERY_METHOD_ID, $deliveryMethodId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ShopDeliveryMethodsSystemsTableMap::COL_DELIVERY_METHOD_ID, $deliveryMethodId, $comparison);
    }

    /**
     * Filter the query on the payment_method_id column
     *
     * Example usage:
     * <code>
     * $query->filterByPaymentMethodId(1234); // WHERE payment_method_id = 1234
     * $query->filterByPaymentMethodId(array(12, 34)); // WHERE payment_method_id IN (12, 34)
     * $query->filterByPaymentMethodId(array('min' => 12)); // WHERE payment_method_id > 12
     * </code>
     *
     * @see       filterByPaymentMethods()
     *
     * @param     mixed $paymentMethodId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildShopDeliveryMethodsSystemsQuery The current query, for fluid interface
     */
    public function filterByPaymentMethodId($paymentMethodId = null, $comparison = null)
    {
        if (is_array($paymentMethodId)) {
            $useMinMax = false;
            if (isset($paymentMethodId['min'])) {
                $this->addUsingAlias(ShopDeliveryMethodsSystemsTableMap::COL_PAYMENT_METHOD_ID, $paymentMethodId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($paymentMethodId['max'])) {
                $this->addUsingAlias(ShopDeliveryMethodsSystemsTableMap::COL_PAYMENT_METHOD_ID, $paymentMethodId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ShopDeliveryMethodsSystemsTableMap::COL_PAYMENT_METHOD_ID, $paymentMethodId, $comparison);
    }

    /**
     * Filter the query by a related \SDeliveryMethods object
     *
     * @param \SDeliveryMethods|ObjectCollection $sDeliveryMethods The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildShopDeliveryMethodsSystemsQuery The current query, for fluid interface
     */
    public function filterBySDeliveryMethods($sDeliveryMethods, $comparison = null)
    {
        if ($sDeliveryMethods instanceof \SDeliveryMethods) {
            return $this
                ->addUsingAlias(ShopDeliveryMethodsSystemsTableMap::COL_DELIVERY_METHOD_ID, $sDeliveryMethods->getId(), $comparison);
        } elseif ($sDeliveryMethods instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ShopDeliveryMethodsSystemsTableMap::COL_DELIVERY_METHOD_ID, $sDeliveryMethods->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterBySDeliveryMethods() only accepts arguments of type \SDeliveryMethods or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the SDeliveryMethods relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildShopDeliveryMethodsSystemsQuery The current query, for fluid interface
     */
    public function joinSDeliveryMethods($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('SDeliveryMethods');

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
            $this->addJoinObject($join, 'SDeliveryMethods');
        }

        return $this;
    }

    /**
     * Use the SDeliveryMethods relation SDeliveryMethods object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \SDeliveryMethodsQuery A secondary query class using the current class as primary query
     */
    public function useSDeliveryMethodsQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinSDeliveryMethods($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'SDeliveryMethods', '\SDeliveryMethodsQuery');
    }

    /**
     * Filter the query by a related \SPaymentMethods object
     *
     * @param \SPaymentMethods|ObjectCollection $sPaymentMethods The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildShopDeliveryMethodsSystemsQuery The current query, for fluid interface
     */
    public function filterByPaymentMethods($sPaymentMethods, $comparison = null)
    {
        if ($sPaymentMethods instanceof \SPaymentMethods) {
            return $this
                ->addUsingAlias(ShopDeliveryMethodsSystemsTableMap::COL_PAYMENT_METHOD_ID, $sPaymentMethods->getId(), $comparison);
        } elseif ($sPaymentMethods instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ShopDeliveryMethodsSystemsTableMap::COL_PAYMENT_METHOD_ID, $sPaymentMethods->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByPaymentMethods() only accepts arguments of type \SPaymentMethods or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the PaymentMethods relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildShopDeliveryMethodsSystemsQuery The current query, for fluid interface
     */
    public function joinPaymentMethods($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('PaymentMethods');

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
            $this->addJoinObject($join, 'PaymentMethods');
        }

        return $this;
    }

    /**
     * Use the PaymentMethods relation SPaymentMethods object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \SPaymentMethodsQuery A secondary query class using the current class as primary query
     */
    public function usePaymentMethodsQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPaymentMethods($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'PaymentMethods', '\SPaymentMethodsQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildShopDeliveryMethodsSystems $shopDeliveryMethodsSystems Object to remove from the list of results
     *
     * @return $this|ChildShopDeliveryMethodsSystemsQuery The current query, for fluid interface
     */
    public function prune($shopDeliveryMethodsSystems = null)
    {
        if ($shopDeliveryMethodsSystems) {
            $this->addCond('pruneCond0', $this->getAliasedColName(ShopDeliveryMethodsSystemsTableMap::COL_DELIVERY_METHOD_ID), $shopDeliveryMethodsSystems->getDeliveryMethodId(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(ShopDeliveryMethodsSystemsTableMap::COL_PAYMENT_METHOD_ID), $shopDeliveryMethodsSystems->getPaymentMethodId(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the shop_delivery_methods_systems table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ShopDeliveryMethodsSystemsTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ShopDeliveryMethodsSystemsTableMap::clearInstancePool();
            ShopDeliveryMethodsSystemsTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(ShopDeliveryMethodsSystemsTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ShopDeliveryMethodsSystemsTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            ShopDeliveryMethodsSystemsTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            ShopDeliveryMethodsSystemsTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // ShopDeliveryMethodsSystemsQuery
