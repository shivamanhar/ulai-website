<?php

namespace Base;

use \SDeliveryMethods as ChildSDeliveryMethods;
use \SDeliveryMethodsI18nQuery as ChildSDeliveryMethodsI18nQuery;
use \SDeliveryMethodsQuery as ChildSDeliveryMethodsQuery;
use \Exception;
use \PDO;
use Map\SDeliveryMethodsI18nTableMap;
use Map\SDeliveryMethodsTableMap;
use Map\SOrdersTableMap;
use Map\ShopDeliveryMethodsSystemsTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'shop_delivery_methods' table.
 *
 *
 *
 * @method     ChildSDeliveryMethodsQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildSDeliveryMethodsQuery orderByPrice($order = Criteria::ASC) Order by the price column
 * @method     ChildSDeliveryMethodsQuery orderByFreeFrom($order = Criteria::ASC) Order by the free_from column
 * @method     ChildSDeliveryMethodsQuery orderByEnabled($order = Criteria::ASC) Order by the enabled column
 * @method     ChildSDeliveryMethodsQuery orderByIsPriceInPercent($order = Criteria::ASC) Order by the is_price_in_percent column
 * @method     ChildSDeliveryMethodsQuery orderByPosition($order = Criteria::ASC) Order by the position column
 * @method     ChildSDeliveryMethodsQuery orderByDeliverySumSpecified($order = Criteria::ASC) Order by the delivery_sum_specified column
 *
 * @method     ChildSDeliveryMethodsQuery groupById() Group by the id column
 * @method     ChildSDeliveryMethodsQuery groupByPrice() Group by the price column
 * @method     ChildSDeliveryMethodsQuery groupByFreeFrom() Group by the free_from column
 * @method     ChildSDeliveryMethodsQuery groupByEnabled() Group by the enabled column
 * @method     ChildSDeliveryMethodsQuery groupByIsPriceInPercent() Group by the is_price_in_percent column
 * @method     ChildSDeliveryMethodsQuery groupByPosition() Group by the position column
 * @method     ChildSDeliveryMethodsQuery groupByDeliverySumSpecified() Group by the delivery_sum_specified column
 *
 * @method     ChildSDeliveryMethodsQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildSDeliveryMethodsQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildSDeliveryMethodsQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildSDeliveryMethodsQuery leftJoinSDeliveryMethodsI18n($relationAlias = null) Adds a LEFT JOIN clause to the query using the SDeliveryMethodsI18n relation
 * @method     ChildSDeliveryMethodsQuery rightJoinSDeliveryMethodsI18n($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SDeliveryMethodsI18n relation
 * @method     ChildSDeliveryMethodsQuery innerJoinSDeliveryMethodsI18n($relationAlias = null) Adds a INNER JOIN clause to the query using the SDeliveryMethodsI18n relation
 *
 * @method     ChildSDeliveryMethodsQuery leftJoinShopDeliveryMethodsSystems($relationAlias = null) Adds a LEFT JOIN clause to the query using the ShopDeliveryMethodsSystems relation
 * @method     ChildSDeliveryMethodsQuery rightJoinShopDeliveryMethodsSystems($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ShopDeliveryMethodsSystems relation
 * @method     ChildSDeliveryMethodsQuery innerJoinShopDeliveryMethodsSystems($relationAlias = null) Adds a INNER JOIN clause to the query using the ShopDeliveryMethodsSystems relation
 *
 * @method     ChildSDeliveryMethodsQuery leftJoinSOrders($relationAlias = null) Adds a LEFT JOIN clause to the query using the SOrders relation
 * @method     ChildSDeliveryMethodsQuery rightJoinSOrders($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SOrders relation
 * @method     ChildSDeliveryMethodsQuery innerJoinSOrders($relationAlias = null) Adds a INNER JOIN clause to the query using the SOrders relation
 *
 * @method     \SDeliveryMethodsI18nQuery|\ShopDeliveryMethodsSystemsQuery|\SOrdersQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildSDeliveryMethods findOne(ConnectionInterface $con = null) Return the first ChildSDeliveryMethods matching the query
 * @method     ChildSDeliveryMethods findOneOrCreate(ConnectionInterface $con = null) Return the first ChildSDeliveryMethods matching the query, or a new ChildSDeliveryMethods object populated from the query conditions when no match is found
 *
 * @method     ChildSDeliveryMethods findOneById(int $id) Return the first ChildSDeliveryMethods filtered by the id column
 * @method     ChildSDeliveryMethods findOneByPrice(string $price) Return the first ChildSDeliveryMethods filtered by the price column
 * @method     ChildSDeliveryMethods findOneByFreeFrom(string $free_from) Return the first ChildSDeliveryMethods filtered by the free_from column
 * @method     ChildSDeliveryMethods findOneByEnabled(boolean $enabled) Return the first ChildSDeliveryMethods filtered by the enabled column
 * @method     ChildSDeliveryMethods findOneByIsPriceInPercent(boolean $is_price_in_percent) Return the first ChildSDeliveryMethods filtered by the is_price_in_percent column
 * @method     ChildSDeliveryMethods findOneByPosition(int $position) Return the first ChildSDeliveryMethods filtered by the position column
 * @method     ChildSDeliveryMethods findOneByDeliverySumSpecified(boolean $delivery_sum_specified) Return the first ChildSDeliveryMethods filtered by the delivery_sum_specified column *

 * @method     ChildSDeliveryMethods requirePk($key, ConnectionInterface $con = null) Return the ChildSDeliveryMethods by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSDeliveryMethods requireOne(ConnectionInterface $con = null) Return the first ChildSDeliveryMethods matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSDeliveryMethods requireOneById(int $id) Return the first ChildSDeliveryMethods filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSDeliveryMethods requireOneByPrice(string $price) Return the first ChildSDeliveryMethods filtered by the price column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSDeliveryMethods requireOneByFreeFrom(string $free_from) Return the first ChildSDeliveryMethods filtered by the free_from column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSDeliveryMethods requireOneByEnabled(boolean $enabled) Return the first ChildSDeliveryMethods filtered by the enabled column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSDeliveryMethods requireOneByIsPriceInPercent(boolean $is_price_in_percent) Return the first ChildSDeliveryMethods filtered by the is_price_in_percent column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSDeliveryMethods requireOneByPosition(int $position) Return the first ChildSDeliveryMethods filtered by the position column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSDeliveryMethods requireOneByDeliverySumSpecified(boolean $delivery_sum_specified) Return the first ChildSDeliveryMethods filtered by the delivery_sum_specified column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSDeliveryMethods[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildSDeliveryMethods objects based on current ModelCriteria
 * @method     ChildSDeliveryMethods[]|ObjectCollection findById(int $id) Return ChildSDeliveryMethods objects filtered by the id column
 * @method     ChildSDeliveryMethods[]|ObjectCollection findByPrice(string $price) Return ChildSDeliveryMethods objects filtered by the price column
 * @method     ChildSDeliveryMethods[]|ObjectCollection findByFreeFrom(string $free_from) Return ChildSDeliveryMethods objects filtered by the free_from column
 * @method     ChildSDeliveryMethods[]|ObjectCollection findByEnabled(boolean $enabled) Return ChildSDeliveryMethods objects filtered by the enabled column
 * @method     ChildSDeliveryMethods[]|ObjectCollection findByIsPriceInPercent(boolean $is_price_in_percent) Return ChildSDeliveryMethods objects filtered by the is_price_in_percent column
 * @method     ChildSDeliveryMethods[]|ObjectCollection findByPosition(int $position) Return ChildSDeliveryMethods objects filtered by the position column
 * @method     ChildSDeliveryMethods[]|ObjectCollection findByDeliverySumSpecified(boolean $delivery_sum_specified) Return ChildSDeliveryMethods objects filtered by the delivery_sum_specified column
 * @method     ChildSDeliveryMethods[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class SDeliveryMethodsQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\SDeliveryMethodsQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'Shop', $modelName = '\\SDeliveryMethods', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildSDeliveryMethodsQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildSDeliveryMethodsQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildSDeliveryMethodsQuery) {
            return $criteria;
        }
        $query = new ChildSDeliveryMethodsQuery();
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
     * @return ChildSDeliveryMethods|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = SDeliveryMethodsTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(SDeliveryMethodsTableMap::DATABASE_NAME);
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
     * @return ChildSDeliveryMethods A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, price, free_from, enabled, is_price_in_percent, position, delivery_sum_specified FROM shop_delivery_methods WHERE id = :p0';
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
            /** @var ChildSDeliveryMethods $obj */
            $obj = new ChildSDeliveryMethods();
            $obj->hydrate($row);
            SDeliveryMethodsTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildSDeliveryMethods|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildSDeliveryMethodsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(SDeliveryMethodsTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildSDeliveryMethodsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(SDeliveryMethodsTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildSDeliveryMethodsQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(SDeliveryMethodsTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(SDeliveryMethodsTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SDeliveryMethodsTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the price column
     *
     * Example usage:
     * <code>
     * $query->filterByPrice(1234); // WHERE price = 1234
     * $query->filterByPrice(array(12, 34)); // WHERE price IN (12, 34)
     * $query->filterByPrice(array('min' => 12)); // WHERE price > 12
     * </code>
     *
     * @param     mixed $price The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSDeliveryMethodsQuery The current query, for fluid interface
     */
    public function filterByPrice($price = null, $comparison = null)
    {
        if (is_array($price)) {
            $useMinMax = false;
            if (isset($price['min'])) {
                $this->addUsingAlias(SDeliveryMethodsTableMap::COL_PRICE, $price['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($price['max'])) {
                $this->addUsingAlias(SDeliveryMethodsTableMap::COL_PRICE, $price['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SDeliveryMethodsTableMap::COL_PRICE, $price, $comparison);
    }

    /**
     * Filter the query on the free_from column
     *
     * Example usage:
     * <code>
     * $query->filterByFreeFrom(1234); // WHERE free_from = 1234
     * $query->filterByFreeFrom(array(12, 34)); // WHERE free_from IN (12, 34)
     * $query->filterByFreeFrom(array('min' => 12)); // WHERE free_from > 12
     * </code>
     *
     * @param     mixed $freeFrom The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSDeliveryMethodsQuery The current query, for fluid interface
     */
    public function filterByFreeFrom($freeFrom = null, $comparison = null)
    {
        if (is_array($freeFrom)) {
            $useMinMax = false;
            if (isset($freeFrom['min'])) {
                $this->addUsingAlias(SDeliveryMethodsTableMap::COL_FREE_FROM, $freeFrom['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($freeFrom['max'])) {
                $this->addUsingAlias(SDeliveryMethodsTableMap::COL_FREE_FROM, $freeFrom['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SDeliveryMethodsTableMap::COL_FREE_FROM, $freeFrom, $comparison);
    }

    /**
     * Filter the query on the enabled column
     *
     * Example usage:
     * <code>
     * $query->filterByEnabled(true); // WHERE enabled = true
     * $query->filterByEnabled('yes'); // WHERE enabled = true
     * </code>
     *
     * @param     boolean|string $enabled The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSDeliveryMethodsQuery The current query, for fluid interface
     */
    public function filterByEnabled($enabled = null, $comparison = null)
    {
        if (is_string($enabled)) {
            $enabled = in_array(strtolower($enabled), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(SDeliveryMethodsTableMap::COL_ENABLED, $enabled, $comparison);
    }

    /**
     * Filter the query on the is_price_in_percent column
     *
     * Example usage:
     * <code>
     * $query->filterByIsPriceInPercent(true); // WHERE is_price_in_percent = true
     * $query->filterByIsPriceInPercent('yes'); // WHERE is_price_in_percent = true
     * </code>
     *
     * @param     boolean|string $isPriceInPercent The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSDeliveryMethodsQuery The current query, for fluid interface
     */
    public function filterByIsPriceInPercent($isPriceInPercent = null, $comparison = null)
    {
        if (is_string($isPriceInPercent)) {
            $isPriceInPercent = in_array(strtolower($isPriceInPercent), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(SDeliveryMethodsTableMap::COL_IS_PRICE_IN_PERCENT, $isPriceInPercent, $comparison);
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
     * @return $this|ChildSDeliveryMethodsQuery The current query, for fluid interface
     */
    public function filterByPosition($position = null, $comparison = null)
    {
        if (is_array($position)) {
            $useMinMax = false;
            if (isset($position['min'])) {
                $this->addUsingAlias(SDeliveryMethodsTableMap::COL_POSITION, $position['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($position['max'])) {
                $this->addUsingAlias(SDeliveryMethodsTableMap::COL_POSITION, $position['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SDeliveryMethodsTableMap::COL_POSITION, $position, $comparison);
    }

    /**
     * Filter the query on the delivery_sum_specified column
     *
     * Example usage:
     * <code>
     * $query->filterByDeliverySumSpecified(true); // WHERE delivery_sum_specified = true
     * $query->filterByDeliverySumSpecified('yes'); // WHERE delivery_sum_specified = true
     * </code>
     *
     * @param     boolean|string $deliverySumSpecified The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSDeliveryMethodsQuery The current query, for fluid interface
     */
    public function filterByDeliverySumSpecified($deliverySumSpecified = null, $comparison = null)
    {
        if (is_string($deliverySumSpecified)) {
            $deliverySumSpecified = in_array(strtolower($deliverySumSpecified), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(SDeliveryMethodsTableMap::COL_DELIVERY_SUM_SPECIFIED, $deliverySumSpecified, $comparison);
    }

    /**
     * Filter the query by a related \SDeliveryMethodsI18n object
     *
     * @param \SDeliveryMethodsI18n|ObjectCollection $sDeliveryMethodsI18n the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSDeliveryMethodsQuery The current query, for fluid interface
     */
    public function filterBySDeliveryMethodsI18n($sDeliveryMethodsI18n, $comparison = null)
    {
        if ($sDeliveryMethodsI18n instanceof \SDeliveryMethodsI18n) {
            return $this
                ->addUsingAlias(SDeliveryMethodsTableMap::COL_ID, $sDeliveryMethodsI18n->getId(), $comparison);
        } elseif ($sDeliveryMethodsI18n instanceof ObjectCollection) {
            return $this
                ->useSDeliveryMethodsI18nQuery()
                ->filterByPrimaryKeys($sDeliveryMethodsI18n->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterBySDeliveryMethodsI18n() only accepts arguments of type \SDeliveryMethodsI18n or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the SDeliveryMethodsI18n relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSDeliveryMethodsQuery The current query, for fluid interface
     */
    public function joinSDeliveryMethodsI18n($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('SDeliveryMethodsI18n');

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
            $this->addJoinObject($join, 'SDeliveryMethodsI18n');
        }

        return $this;
    }

    /**
     * Use the SDeliveryMethodsI18n relation SDeliveryMethodsI18n object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \SDeliveryMethodsI18nQuery A secondary query class using the current class as primary query
     */
    public function useSDeliveryMethodsI18nQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinSDeliveryMethodsI18n($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'SDeliveryMethodsI18n', '\SDeliveryMethodsI18nQuery');
    }

    /**
     * Filter the query by a related \ShopDeliveryMethodsSystems object
     *
     * @param \ShopDeliveryMethodsSystems|ObjectCollection $shopDeliveryMethodsSystems the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSDeliveryMethodsQuery The current query, for fluid interface
     */
    public function filterByShopDeliveryMethodsSystems($shopDeliveryMethodsSystems, $comparison = null)
    {
        if ($shopDeliveryMethodsSystems instanceof \ShopDeliveryMethodsSystems) {
            return $this
                ->addUsingAlias(SDeliveryMethodsTableMap::COL_ID, $shopDeliveryMethodsSystems->getDeliveryMethodId(), $comparison);
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
     * @return $this|ChildSDeliveryMethodsQuery The current query, for fluid interface
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
     * @return ChildSDeliveryMethodsQuery The current query, for fluid interface
     */
    public function filterBySOrders($sOrders, $comparison = null)
    {
        if ($sOrders instanceof \SOrders) {
            return $this
                ->addUsingAlias(SDeliveryMethodsTableMap::COL_ID, $sOrders->getDeliveryMethod(), $comparison);
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
     * @return $this|ChildSDeliveryMethodsQuery The current query, for fluid interface
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
     * Filter the query by a related SPaymentMethods object
     * using the shop_delivery_methods_systems table as cross reference
     *
     * @param SPaymentMethods $sPaymentMethods the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSDeliveryMethodsQuery The current query, for fluid interface
     */
    public function filterByPaymentMethods($sPaymentMethods, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useShopDeliveryMethodsSystemsQuery()
            ->filterByPaymentMethods($sPaymentMethods, $comparison)
            ->endUse();
    }

    /**
     * Exclude object from result
     *
     * @param   ChildSDeliveryMethods $sDeliveryMethods Object to remove from the list of results
     *
     * @return $this|ChildSDeliveryMethodsQuery The current query, for fluid interface
     */
    public function prune($sDeliveryMethods = null)
    {
        if ($sDeliveryMethods) {
            $this->addUsingAlias(SDeliveryMethodsTableMap::COL_ID, $sDeliveryMethods->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the shop_delivery_methods table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SDeliveryMethodsTableMap::DATABASE_NAME);
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
            SDeliveryMethodsTableMap::clearInstancePool();
            SDeliveryMethodsTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(SDeliveryMethodsTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(SDeliveryMethodsTableMap::DATABASE_NAME);

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

            SDeliveryMethodsTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            SDeliveryMethodsTableMap::clearRelatedInstancePool();

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
        $objects = ChildSDeliveryMethodsQuery::create(null, $this)->find($con);
        foreach ($objects as $obj) {


            // delete related SDeliveryMethodsI18n objects
            $query = new \SDeliveryMethodsI18nQuery;

            $query->add(SDeliveryMethodsI18nTableMap::COL_ID, $obj->getId());
            $affectedRows += $query->delete($con);

            // delete related ShopDeliveryMethodsSystems objects
            $query = new \ShopDeliveryMethodsSystemsQuery;

            $query->add(ShopDeliveryMethodsSystemsTableMap::COL_DELIVERY_METHOD_ID, $obj->getId());
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
        $objects = ChildSDeliveryMethodsQuery::create(null, $this)->find($con);
        foreach ($objects as $obj) {

            // set fkey col in related SOrders rows to NULL
            $query = new \SOrdersQuery();
            $updateValues = new Criteria();
            $query->add(SOrdersTableMap::COL_DELIVERY_METHOD, $obj->getId());
            $updateValues->add(SOrdersTableMap::COL_DELIVERY_METHOD, null);
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
     * @return    ChildSDeliveryMethodsQuery The current query, for fluid interface
     */
    public function joinI18n($locale = 'ru', $relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $relationName = $relationAlias ? $relationAlias : 'SDeliveryMethodsI18n';

        return $this
            ->joinSDeliveryMethodsI18n($relationAlias, $joinType)
            ->addJoinCondition($relationName, $relationName . '.Locale = ?', $locale);
    }

    /**
     * Adds a JOIN clause to the query and hydrates the related I18n object.
     * Shortcut for $c->joinI18n($locale)->with()
     *
     * @param     string $locale Locale to use for the join condition, e.g. 'fr_FR'
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'. Defaults to left join.
     *
     * @return    $this|ChildSDeliveryMethodsQuery The current query, for fluid interface
     */
    public function joinWithI18n($locale = 'ru', $joinType = Criteria::LEFT_JOIN)
    {
        $this
            ->joinI18n($locale, null, $joinType)
            ->with('SDeliveryMethodsI18n');
        $this->with['SDeliveryMethodsI18n']->setIsWithOneToMany(false);

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
     * @return    ChildSDeliveryMethodsI18nQuery A secondary query class using the current class as primary query
     */
    public function useI18nQuery($locale = 'ru', $relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinI18n($locale, $relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'SDeliveryMethodsI18n', '\SDeliveryMethodsI18nQuery');
    }

} // SDeliveryMethodsQuery
