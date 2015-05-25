<?php

namespace Base;

use \SPaymentMethods as ChildSPaymentMethods;
use \SPaymentMethodsI18nQuery as ChildSPaymentMethodsI18nQuery;
use \SPaymentMethodsQuery as ChildSPaymentMethodsQuery;
use \Exception;
use \PDO;
use Map\SOrdersTableMap;
use Map\SPaymentMethodsI18nTableMap;
use Map\SPaymentMethodsTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'shop_payment_methods' table.
 *
 *
 *
 * @method     ChildSPaymentMethodsQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildSPaymentMethodsQuery orderByActive($order = Criteria::ASC) Order by the active column
 * @method     ChildSPaymentMethodsQuery orderByCurrencyId($order = Criteria::ASC) Order by the currency_id column
 * @method     ChildSPaymentMethodsQuery orderByPaymentSystemName($order = Criteria::ASC) Order by the payment_system_name column
 * @method     ChildSPaymentMethodsQuery orderByPosition($order = Criteria::ASC) Order by the position column
 *
 * @method     ChildSPaymentMethodsQuery groupById() Group by the id column
 * @method     ChildSPaymentMethodsQuery groupByActive() Group by the active column
 * @method     ChildSPaymentMethodsQuery groupByCurrencyId() Group by the currency_id column
 * @method     ChildSPaymentMethodsQuery groupByPaymentSystemName() Group by the payment_system_name column
 * @method     ChildSPaymentMethodsQuery groupByPosition() Group by the position column
 *
 * @method     ChildSPaymentMethodsQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildSPaymentMethodsQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildSPaymentMethodsQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildSPaymentMethodsQuery leftJoinCurrency($relationAlias = null) Adds a LEFT JOIN clause to the query using the Currency relation
 * @method     ChildSPaymentMethodsQuery rightJoinCurrency($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Currency relation
 * @method     ChildSPaymentMethodsQuery innerJoinCurrency($relationAlias = null) Adds a INNER JOIN clause to the query using the Currency relation
 *
 * @method     ChildSPaymentMethodsQuery leftJoinShopDeliveryMethodsSystems($relationAlias = null) Adds a LEFT JOIN clause to the query using the ShopDeliveryMethodsSystems relation
 * @method     ChildSPaymentMethodsQuery rightJoinShopDeliveryMethodsSystems($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ShopDeliveryMethodsSystems relation
 * @method     ChildSPaymentMethodsQuery innerJoinShopDeliveryMethodsSystems($relationAlias = null) Adds a INNER JOIN clause to the query using the ShopDeliveryMethodsSystems relation
 *
 * @method     ChildSPaymentMethodsQuery leftJoinSOrders($relationAlias = null) Adds a LEFT JOIN clause to the query using the SOrders relation
 * @method     ChildSPaymentMethodsQuery rightJoinSOrders($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SOrders relation
 * @method     ChildSPaymentMethodsQuery innerJoinSOrders($relationAlias = null) Adds a INNER JOIN clause to the query using the SOrders relation
 *
 * @method     ChildSPaymentMethodsQuery leftJoinSPaymentMethodsI18n($relationAlias = null) Adds a LEFT JOIN clause to the query using the SPaymentMethodsI18n relation
 * @method     ChildSPaymentMethodsQuery rightJoinSPaymentMethodsI18n($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SPaymentMethodsI18n relation
 * @method     ChildSPaymentMethodsQuery innerJoinSPaymentMethodsI18n($relationAlias = null) Adds a INNER JOIN clause to the query using the SPaymentMethodsI18n relation
 *
 * @method     \SCurrenciesQuery|\ShopDeliveryMethodsSystemsQuery|\SOrdersQuery|\SPaymentMethodsI18nQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildSPaymentMethods findOne(ConnectionInterface $con = null) Return the first ChildSPaymentMethods matching the query
 * @method     ChildSPaymentMethods findOneOrCreate(ConnectionInterface $con = null) Return the first ChildSPaymentMethods matching the query, or a new ChildSPaymentMethods object populated from the query conditions when no match is found
 *
 * @method     ChildSPaymentMethods findOneById(int $id) Return the first ChildSPaymentMethods filtered by the id column
 * @method     ChildSPaymentMethods findOneByActive(boolean $active) Return the first ChildSPaymentMethods filtered by the active column
 * @method     ChildSPaymentMethods findOneByCurrencyId(int $currency_id) Return the first ChildSPaymentMethods filtered by the currency_id column
 * @method     ChildSPaymentMethods findOneByPaymentSystemName(string $payment_system_name) Return the first ChildSPaymentMethods filtered by the payment_system_name column
 * @method     ChildSPaymentMethods findOneByPosition(int $position) Return the first ChildSPaymentMethods filtered by the position column *

 * @method     ChildSPaymentMethods requirePk($key, ConnectionInterface $con = null) Return the ChildSPaymentMethods by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSPaymentMethods requireOne(ConnectionInterface $con = null) Return the first ChildSPaymentMethods matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSPaymentMethods requireOneById(int $id) Return the first ChildSPaymentMethods filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSPaymentMethods requireOneByActive(boolean $active) Return the first ChildSPaymentMethods filtered by the active column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSPaymentMethods requireOneByCurrencyId(int $currency_id) Return the first ChildSPaymentMethods filtered by the currency_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSPaymentMethods requireOneByPaymentSystemName(string $payment_system_name) Return the first ChildSPaymentMethods filtered by the payment_system_name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSPaymentMethods requireOneByPosition(int $position) Return the first ChildSPaymentMethods filtered by the position column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSPaymentMethods[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildSPaymentMethods objects based on current ModelCriteria
 * @method     ChildSPaymentMethods[]|ObjectCollection findById(int $id) Return ChildSPaymentMethods objects filtered by the id column
 * @method     ChildSPaymentMethods[]|ObjectCollection findByActive(boolean $active) Return ChildSPaymentMethods objects filtered by the active column
 * @method     ChildSPaymentMethods[]|ObjectCollection findByCurrencyId(int $currency_id) Return ChildSPaymentMethods objects filtered by the currency_id column
 * @method     ChildSPaymentMethods[]|ObjectCollection findByPaymentSystemName(string $payment_system_name) Return ChildSPaymentMethods objects filtered by the payment_system_name column
 * @method     ChildSPaymentMethods[]|ObjectCollection findByPosition(int $position) Return ChildSPaymentMethods objects filtered by the position column
 * @method     ChildSPaymentMethods[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class SPaymentMethodsQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\SPaymentMethodsQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'Shop', $modelName = '\\SPaymentMethods', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildSPaymentMethodsQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildSPaymentMethodsQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildSPaymentMethodsQuery) {
            return $criteria;
        }
        $query = new ChildSPaymentMethodsQuery();
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
     * @return ChildSPaymentMethods|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = SPaymentMethodsTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(SPaymentMethodsTableMap::DATABASE_NAME);
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
     * @return ChildSPaymentMethods A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, active, currency_id, payment_system_name, position FROM shop_payment_methods WHERE id = :p0';
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
            /** @var ChildSPaymentMethods $obj */
            $obj = new ChildSPaymentMethods();
            $obj->hydrate($row);
            SPaymentMethodsTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildSPaymentMethods|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildSPaymentMethodsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(SPaymentMethodsTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildSPaymentMethodsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(SPaymentMethodsTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildSPaymentMethodsQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(SPaymentMethodsTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(SPaymentMethodsTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SPaymentMethodsTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildSPaymentMethodsQuery The current query, for fluid interface
     */
    public function filterByActive($active = null, $comparison = null)
    {
        if (is_string($active)) {
            $active = in_array(strtolower($active), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(SPaymentMethodsTableMap::COL_ACTIVE, $active, $comparison);
    }

    /**
     * Filter the query on the currency_id column
     *
     * Example usage:
     * <code>
     * $query->filterByCurrencyId(1234); // WHERE currency_id = 1234
     * $query->filterByCurrencyId(array(12, 34)); // WHERE currency_id IN (12, 34)
     * $query->filterByCurrencyId(array('min' => 12)); // WHERE currency_id > 12
     * </code>
     *
     * @see       filterByCurrency()
     *
     * @param     mixed $currencyId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSPaymentMethodsQuery The current query, for fluid interface
     */
    public function filterByCurrencyId($currencyId = null, $comparison = null)
    {
        if (is_array($currencyId)) {
            $useMinMax = false;
            if (isset($currencyId['min'])) {
                $this->addUsingAlias(SPaymentMethodsTableMap::COL_CURRENCY_ID, $currencyId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($currencyId['max'])) {
                $this->addUsingAlias(SPaymentMethodsTableMap::COL_CURRENCY_ID, $currencyId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SPaymentMethodsTableMap::COL_CURRENCY_ID, $currencyId, $comparison);
    }

    /**
     * Filter the query on the payment_system_name column
     *
     * Example usage:
     * <code>
     * $query->filterByPaymentSystemName('fooValue');   // WHERE payment_system_name = 'fooValue'
     * $query->filterByPaymentSystemName('%fooValue%'); // WHERE payment_system_name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $paymentSystemName The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSPaymentMethodsQuery The current query, for fluid interface
     */
    public function filterByPaymentSystemName($paymentSystemName = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($paymentSystemName)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $paymentSystemName)) {
                $paymentSystemName = str_replace('*', '%', $paymentSystemName);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SPaymentMethodsTableMap::COL_PAYMENT_SYSTEM_NAME, $paymentSystemName, $comparison);
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
     * @return $this|ChildSPaymentMethodsQuery The current query, for fluid interface
     */
    public function filterByPosition($position = null, $comparison = null)
    {
        if (is_array($position)) {
            $useMinMax = false;
            if (isset($position['min'])) {
                $this->addUsingAlias(SPaymentMethodsTableMap::COL_POSITION, $position['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($position['max'])) {
                $this->addUsingAlias(SPaymentMethodsTableMap::COL_POSITION, $position['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SPaymentMethodsTableMap::COL_POSITION, $position, $comparison);
    }

    /**
     * Filter the query by a related \SCurrencies object
     *
     * @param \SCurrencies|ObjectCollection $sCurrencies The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildSPaymentMethodsQuery The current query, for fluid interface
     */
    public function filterByCurrency($sCurrencies, $comparison = null)
    {
        if ($sCurrencies instanceof \SCurrencies) {
            return $this
                ->addUsingAlias(SPaymentMethodsTableMap::COL_CURRENCY_ID, $sCurrencies->getId(), $comparison);
        } elseif ($sCurrencies instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(SPaymentMethodsTableMap::COL_CURRENCY_ID, $sCurrencies->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByCurrency() only accepts arguments of type \SCurrencies or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Currency relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSPaymentMethodsQuery The current query, for fluid interface
     */
    public function joinCurrency($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Currency');

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
            $this->addJoinObject($join, 'Currency');
        }

        return $this;
    }

    /**
     * Use the Currency relation SCurrencies object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \SCurrenciesQuery A secondary query class using the current class as primary query
     */
    public function useCurrencyQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinCurrency($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Currency', '\SCurrenciesQuery');
    }

    /**
     * Filter the query by a related \ShopDeliveryMethodsSystems object
     *
     * @param \ShopDeliveryMethodsSystems|ObjectCollection $shopDeliveryMethodsSystems the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSPaymentMethodsQuery The current query, for fluid interface
     */
    public function filterByShopDeliveryMethodsSystems($shopDeliveryMethodsSystems, $comparison = null)
    {
        if ($shopDeliveryMethodsSystems instanceof \ShopDeliveryMethodsSystems) {
            return $this
                ->addUsingAlias(SPaymentMethodsTableMap::COL_ID, $shopDeliveryMethodsSystems->getPaymentMethodId(), $comparison);
        } elseif ($shopDeliveryMethodsSystems instanceof ObjectCollection) {
            return $this
                ->useShopDeliveryMethodsSystemsQuery()
                ->filterByPrimaryKeys($shopDeliveryMethodsSystems->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByShopDeliveryMethodsSystems() only accepts arguments of type \ShopDeliveryMethodsSystems or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ShopDeliveryMethodsSystems relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSPaymentMethodsQuery The current query, for fluid interface
     */
    public function joinShopDeliveryMethodsSystems($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ShopDeliveryMethodsSystems');

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
            $this->addJoinObject($join, 'ShopDeliveryMethodsSystems');
        }

        return $this;
    }

    /**
     * Use the ShopDeliveryMethodsSystems relation ShopDeliveryMethodsSystems object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ShopDeliveryMethodsSystemsQuery A secondary query class using the current class as primary query
     */
    public function useShopDeliveryMethodsSystemsQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinShopDeliveryMethodsSystems($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ShopDeliveryMethodsSystems', '\ShopDeliveryMethodsSystemsQuery');
    }

    /**
     * Filter the query by a related \SOrders object
     *
     * @param \SOrders|ObjectCollection $sOrders the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSPaymentMethodsQuery The current query, for fluid interface
     */
    public function filterBySOrders($sOrders, $comparison = null)
    {
        if ($sOrders instanceof \SOrders) {
            return $this
                ->addUsingAlias(SPaymentMethodsTableMap::COL_ID, $sOrders->getPaymentMethod(), $comparison);
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
     * @return $this|ChildSPaymentMethodsQuery The current query, for fluid interface
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
     * Filter the query by a related \SPaymentMethodsI18n object
     *
     * @param \SPaymentMethodsI18n|ObjectCollection $sPaymentMethodsI18n the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSPaymentMethodsQuery The current query, for fluid interface
     */
    public function filterBySPaymentMethodsI18n($sPaymentMethodsI18n, $comparison = null)
    {
        if ($sPaymentMethodsI18n instanceof \SPaymentMethodsI18n) {
            return $this
                ->addUsingAlias(SPaymentMethodsTableMap::COL_ID, $sPaymentMethodsI18n->getId(), $comparison);
        } elseif ($sPaymentMethodsI18n instanceof ObjectCollection) {
            return $this
                ->useSPaymentMethodsI18nQuery()
                ->filterByPrimaryKeys($sPaymentMethodsI18n->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterBySPaymentMethodsI18n() only accepts arguments of type \SPaymentMethodsI18n or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the SPaymentMethodsI18n relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSPaymentMethodsQuery The current query, for fluid interface
     */
    public function joinSPaymentMethodsI18n($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('SPaymentMethodsI18n');

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
            $this->addJoinObject($join, 'SPaymentMethodsI18n');
        }

        return $this;
    }

    /**
     * Use the SPaymentMethodsI18n relation SPaymentMethodsI18n object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \SPaymentMethodsI18nQuery A secondary query class using the current class as primary query
     */
    public function useSPaymentMethodsI18nQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinSPaymentMethodsI18n($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'SPaymentMethodsI18n', '\SPaymentMethodsI18nQuery');
    }

    /**
     * Filter the query by a related SDeliveryMethods object
     * using the shop_delivery_methods_systems table as cross reference
     *
     * @param SDeliveryMethods $sDeliveryMethods the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSPaymentMethodsQuery The current query, for fluid interface
     */
    public function filterBySDeliveryMethods($sDeliveryMethods, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useShopDeliveryMethodsSystemsQuery()
            ->filterBySDeliveryMethods($sDeliveryMethods, $comparison)
            ->endUse();
    }

    /**
     * Exclude object from result
     *
     * @param   ChildSPaymentMethods $sPaymentMethods Object to remove from the list of results
     *
     * @return $this|ChildSPaymentMethodsQuery The current query, for fluid interface
     */
    public function prune($sPaymentMethods = null)
    {
        if ($sPaymentMethods) {
            $this->addUsingAlias(SPaymentMethodsTableMap::COL_ID, $sPaymentMethods->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the shop_payment_methods table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SPaymentMethodsTableMap::DATABASE_NAME);
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
            SPaymentMethodsTableMap::clearInstancePool();
            SPaymentMethodsTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(SPaymentMethodsTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(SPaymentMethodsTableMap::DATABASE_NAME);

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

            SPaymentMethodsTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            SPaymentMethodsTableMap::clearRelatedInstancePool();

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
        $objects = ChildSPaymentMethodsQuery::create(null, $this)->find($con);
        foreach ($objects as $obj) {


            // delete related SPaymentMethodsI18n objects
            $query = new \SPaymentMethodsI18nQuery;

            $query->add(SPaymentMethodsI18nTableMap::COL_ID, $obj->getId());
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
        $objects = ChildSPaymentMethodsQuery::create(null, $this)->find($con);
        foreach ($objects as $obj) {

            // set fkey col in related SOrders rows to NULL
            $query = new \SOrdersQuery();
            $updateValues = new Criteria();
            $query->add(SOrdersTableMap::COL_PAYMENT_METHOD, $obj->getId());
            $updateValues->add(SOrdersTableMap::COL_PAYMENT_METHOD, null);
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
     * @return    ChildSPaymentMethodsQuery The current query, for fluid interface
     */
    public function joinI18n($locale = 'ru', $relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $relationName = $relationAlias ? $relationAlias : 'SPaymentMethodsI18n';

        return $this
            ->joinSPaymentMethodsI18n($relationAlias, $joinType)
            ->addJoinCondition($relationName, $relationName . '.Locale = ?', $locale);
    }

    /**
     * Adds a JOIN clause to the query and hydrates the related I18n object.
     * Shortcut for $c->joinI18n($locale)->with()
     *
     * @param     string $locale Locale to use for the join condition, e.g. 'fr_FR'
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'. Defaults to left join.
     *
     * @return    $this|ChildSPaymentMethodsQuery The current query, for fluid interface
     */
    public function joinWithI18n($locale = 'ru', $joinType = Criteria::LEFT_JOIN)
    {
        $this
            ->joinI18n($locale, null, $joinType)
            ->with('SPaymentMethodsI18n');
        $this->with['SPaymentMethodsI18n']->setIsWithOneToMany(false);

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
     * @return    ChildSPaymentMethodsI18nQuery A secondary query class using the current class as primary query
     */
    public function useI18nQuery($locale = 'ru', $relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinI18n($locale, $relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'SPaymentMethodsI18n', '\SPaymentMethodsI18nQuery');
    }

} // SPaymentMethodsQuery
