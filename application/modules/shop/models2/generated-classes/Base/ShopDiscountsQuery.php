<?php

namespace Base;

use \ShopDiscounts as ChildShopDiscounts;
use \ShopDiscountsQuery as ChildShopDiscountsQuery;
use \Exception;
use \PDO;
use Map\ShopDiscountsTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'shop_discounts' table.
 *
 *
 *
 * @method     ChildShopDiscountsQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildShopDiscountsQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method     ChildShopDiscountsQuery orderByDescription($order = Criteria::ASC) Order by the description column
 * @method     ChildShopDiscountsQuery orderByActive($order = Criteria::ASC) Order by the active column
 * @method     ChildShopDiscountsQuery orderByDateStart($order = Criteria::ASC) Order by the date_start column
 * @method     ChildShopDiscountsQuery orderByDateStop($order = Criteria::ASC) Order by the date_stop column
 * @method     ChildShopDiscountsQuery orderByDiscount($order = Criteria::ASC) Order by the discount column
 * @method     ChildShopDiscountsQuery orderByUserGroup($order = Criteria::ASC) Order by the user_group column
 * @method     ChildShopDiscountsQuery orderByMinPrice($order = Criteria::ASC) Order by the min_price column
 * @method     ChildShopDiscountsQuery orderByMaxPrice($order = Criteria::ASC) Order by the max_price column
 * @method     ChildShopDiscountsQuery orderByCategories($order = Criteria::ASC) Order by the categories column
 * @method     ChildShopDiscountsQuery orderByProducts($order = Criteria::ASC) Order by the products column
 *
 * @method     ChildShopDiscountsQuery groupById() Group by the id column
 * @method     ChildShopDiscountsQuery groupByName() Group by the name column
 * @method     ChildShopDiscountsQuery groupByDescription() Group by the description column
 * @method     ChildShopDiscountsQuery groupByActive() Group by the active column
 * @method     ChildShopDiscountsQuery groupByDateStart() Group by the date_start column
 * @method     ChildShopDiscountsQuery groupByDateStop() Group by the date_stop column
 * @method     ChildShopDiscountsQuery groupByDiscount() Group by the discount column
 * @method     ChildShopDiscountsQuery groupByUserGroup() Group by the user_group column
 * @method     ChildShopDiscountsQuery groupByMinPrice() Group by the min_price column
 * @method     ChildShopDiscountsQuery groupByMaxPrice() Group by the max_price column
 * @method     ChildShopDiscountsQuery groupByCategories() Group by the categories column
 * @method     ChildShopDiscountsQuery groupByProducts() Group by the products column
 *
 * @method     ChildShopDiscountsQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildShopDiscountsQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildShopDiscountsQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildShopDiscounts findOne(ConnectionInterface $con = null) Return the first ChildShopDiscounts matching the query
 * @method     ChildShopDiscounts findOneOrCreate(ConnectionInterface $con = null) Return the first ChildShopDiscounts matching the query, or a new ChildShopDiscounts object populated from the query conditions when no match is found
 *
 * @method     ChildShopDiscounts findOneById(int $id) Return the first ChildShopDiscounts filtered by the id column
 * @method     ChildShopDiscounts findOneByName(string $name) Return the first ChildShopDiscounts filtered by the name column
 * @method     ChildShopDiscounts findOneByDescription(string $description) Return the first ChildShopDiscounts filtered by the description column
 * @method     ChildShopDiscounts findOneByActive(boolean $active) Return the first ChildShopDiscounts filtered by the active column
 * @method     ChildShopDiscounts findOneByDateStart(int $date_start) Return the first ChildShopDiscounts filtered by the date_start column
 * @method     ChildShopDiscounts findOneByDateStop(int $date_stop) Return the first ChildShopDiscounts filtered by the date_stop column
 * @method     ChildShopDiscounts findOneByDiscount(string $discount) Return the first ChildShopDiscounts filtered by the discount column
 * @method     ChildShopDiscounts findOneByUserGroup(string $user_group) Return the first ChildShopDiscounts filtered by the user_group column
 * @method     ChildShopDiscounts findOneByMinPrice(string $min_price) Return the first ChildShopDiscounts filtered by the min_price column
 * @method     ChildShopDiscounts findOneByMaxPrice(string $max_price) Return the first ChildShopDiscounts filtered by the max_price column
 * @method     ChildShopDiscounts findOneByCategories(string $categories) Return the first ChildShopDiscounts filtered by the categories column
 * @method     ChildShopDiscounts findOneByProducts(string $products) Return the first ChildShopDiscounts filtered by the products column *

 * @method     ChildShopDiscounts requirePk($key, ConnectionInterface $con = null) Return the ChildShopDiscounts by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildShopDiscounts requireOne(ConnectionInterface $con = null) Return the first ChildShopDiscounts matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildShopDiscounts requireOneById(int $id) Return the first ChildShopDiscounts filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildShopDiscounts requireOneByName(string $name) Return the first ChildShopDiscounts filtered by the name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildShopDiscounts requireOneByDescription(string $description) Return the first ChildShopDiscounts filtered by the description column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildShopDiscounts requireOneByActive(boolean $active) Return the first ChildShopDiscounts filtered by the active column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildShopDiscounts requireOneByDateStart(int $date_start) Return the first ChildShopDiscounts filtered by the date_start column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildShopDiscounts requireOneByDateStop(int $date_stop) Return the first ChildShopDiscounts filtered by the date_stop column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildShopDiscounts requireOneByDiscount(string $discount) Return the first ChildShopDiscounts filtered by the discount column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildShopDiscounts requireOneByUserGroup(string $user_group) Return the first ChildShopDiscounts filtered by the user_group column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildShopDiscounts requireOneByMinPrice(string $min_price) Return the first ChildShopDiscounts filtered by the min_price column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildShopDiscounts requireOneByMaxPrice(string $max_price) Return the first ChildShopDiscounts filtered by the max_price column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildShopDiscounts requireOneByCategories(string $categories) Return the first ChildShopDiscounts filtered by the categories column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildShopDiscounts requireOneByProducts(string $products) Return the first ChildShopDiscounts filtered by the products column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildShopDiscounts[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildShopDiscounts objects based on current ModelCriteria
 * @method     ChildShopDiscounts[]|ObjectCollection findById(int $id) Return ChildShopDiscounts objects filtered by the id column
 * @method     ChildShopDiscounts[]|ObjectCollection findByName(string $name) Return ChildShopDiscounts objects filtered by the name column
 * @method     ChildShopDiscounts[]|ObjectCollection findByDescription(string $description) Return ChildShopDiscounts objects filtered by the description column
 * @method     ChildShopDiscounts[]|ObjectCollection findByActive(boolean $active) Return ChildShopDiscounts objects filtered by the active column
 * @method     ChildShopDiscounts[]|ObjectCollection findByDateStart(int $date_start) Return ChildShopDiscounts objects filtered by the date_start column
 * @method     ChildShopDiscounts[]|ObjectCollection findByDateStop(int $date_stop) Return ChildShopDiscounts objects filtered by the date_stop column
 * @method     ChildShopDiscounts[]|ObjectCollection findByDiscount(string $discount) Return ChildShopDiscounts objects filtered by the discount column
 * @method     ChildShopDiscounts[]|ObjectCollection findByUserGroup(string $user_group) Return ChildShopDiscounts objects filtered by the user_group column
 * @method     ChildShopDiscounts[]|ObjectCollection findByMinPrice(string $min_price) Return ChildShopDiscounts objects filtered by the min_price column
 * @method     ChildShopDiscounts[]|ObjectCollection findByMaxPrice(string $max_price) Return ChildShopDiscounts objects filtered by the max_price column
 * @method     ChildShopDiscounts[]|ObjectCollection findByCategories(string $categories) Return ChildShopDiscounts objects filtered by the categories column
 * @method     ChildShopDiscounts[]|ObjectCollection findByProducts(string $products) Return ChildShopDiscounts objects filtered by the products column
 * @method     ChildShopDiscounts[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class ShopDiscountsQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\ShopDiscountsQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'Shop', $modelName = '\\ShopDiscounts', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildShopDiscountsQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildShopDiscountsQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildShopDiscountsQuery) {
            return $criteria;
        }
        $query = new ChildShopDiscountsQuery();
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
     * @return ChildShopDiscounts|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ShopDiscountsTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ShopDiscountsTableMap::DATABASE_NAME);
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
     * @return ChildShopDiscounts A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, name, description, active, date_start, date_stop, discount, user_group, min_price, max_price, categories, products FROM shop_discounts WHERE id = :p0';
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
            /** @var ChildShopDiscounts $obj */
            $obj = new ChildShopDiscounts();
            $obj->hydrate($row);
            ShopDiscountsTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildShopDiscounts|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildShopDiscountsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ShopDiscountsTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildShopDiscountsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ShopDiscountsTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildShopDiscountsQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(ShopDiscountsTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(ShopDiscountsTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ShopDiscountsTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildShopDiscountsQuery The current query, for fluid interface
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

        return $this->addUsingAlias(ShopDiscountsTableMap::COL_NAME, $name, $comparison);
    }

    /**
     * Filter the query on the description column
     *
     * Example usage:
     * <code>
     * $query->filterByDescription('fooValue');   // WHERE description = 'fooValue'
     * $query->filterByDescription('%fooValue%'); // WHERE description LIKE '%fooValue%'
     * </code>
     *
     * @param     string $description The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildShopDiscountsQuery The current query, for fluid interface
     */
    public function filterByDescription($description = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($description)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $description)) {
                $description = str_replace('*', '%', $description);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ShopDiscountsTableMap::COL_DESCRIPTION, $description, $comparison);
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
     * @return $this|ChildShopDiscountsQuery The current query, for fluid interface
     */
    public function filterByActive($active = null, $comparison = null)
    {
        if (is_string($active)) {
            $active = in_array(strtolower($active), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(ShopDiscountsTableMap::COL_ACTIVE, $active, $comparison);
    }

    /**
     * Filter the query on the date_start column
     *
     * Example usage:
     * <code>
     * $query->filterByDateStart(1234); // WHERE date_start = 1234
     * $query->filterByDateStart(array(12, 34)); // WHERE date_start IN (12, 34)
     * $query->filterByDateStart(array('min' => 12)); // WHERE date_start > 12
     * </code>
     *
     * @param     mixed $dateStart The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildShopDiscountsQuery The current query, for fluid interface
     */
    public function filterByDateStart($dateStart = null, $comparison = null)
    {
        if (is_array($dateStart)) {
            $useMinMax = false;
            if (isset($dateStart['min'])) {
                $this->addUsingAlias(ShopDiscountsTableMap::COL_DATE_START, $dateStart['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dateStart['max'])) {
                $this->addUsingAlias(ShopDiscountsTableMap::COL_DATE_START, $dateStart['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ShopDiscountsTableMap::COL_DATE_START, $dateStart, $comparison);
    }

    /**
     * Filter the query on the date_stop column
     *
     * Example usage:
     * <code>
     * $query->filterByDateStop(1234); // WHERE date_stop = 1234
     * $query->filterByDateStop(array(12, 34)); // WHERE date_stop IN (12, 34)
     * $query->filterByDateStop(array('min' => 12)); // WHERE date_stop > 12
     * </code>
     *
     * @param     mixed $dateStop The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildShopDiscountsQuery The current query, for fluid interface
     */
    public function filterByDateStop($dateStop = null, $comparison = null)
    {
        if (is_array($dateStop)) {
            $useMinMax = false;
            if (isset($dateStop['min'])) {
                $this->addUsingAlias(ShopDiscountsTableMap::COL_DATE_STOP, $dateStop['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dateStop['max'])) {
                $this->addUsingAlias(ShopDiscountsTableMap::COL_DATE_STOP, $dateStop['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ShopDiscountsTableMap::COL_DATE_STOP, $dateStop, $comparison);
    }

    /**
     * Filter the query on the discount column
     *
     * Example usage:
     * <code>
     * $query->filterByDiscount('fooValue');   // WHERE discount = 'fooValue'
     * $query->filterByDiscount('%fooValue%'); // WHERE discount LIKE '%fooValue%'
     * </code>
     *
     * @param     string $discount The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildShopDiscountsQuery The current query, for fluid interface
     */
    public function filterByDiscount($discount = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($discount)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $discount)) {
                $discount = str_replace('*', '%', $discount);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ShopDiscountsTableMap::COL_DISCOUNT, $discount, $comparison);
    }

    /**
     * Filter the query on the user_group column
     *
     * Example usage:
     * <code>
     * $query->filterByUserGroup('fooValue');   // WHERE user_group = 'fooValue'
     * $query->filterByUserGroup('%fooValue%'); // WHERE user_group LIKE '%fooValue%'
     * </code>
     *
     * @param     string $userGroup The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildShopDiscountsQuery The current query, for fluid interface
     */
    public function filterByUserGroup($userGroup = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($userGroup)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $userGroup)) {
                $userGroup = str_replace('*', '%', $userGroup);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ShopDiscountsTableMap::COL_USER_GROUP, $userGroup, $comparison);
    }

    /**
     * Filter the query on the min_price column
     *
     * Example usage:
     * <code>
     * $query->filterByMinPrice(1234); // WHERE min_price = 1234
     * $query->filterByMinPrice(array(12, 34)); // WHERE min_price IN (12, 34)
     * $query->filterByMinPrice(array('min' => 12)); // WHERE min_price > 12
     * </code>
     *
     * @param     mixed $minPrice The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildShopDiscountsQuery The current query, for fluid interface
     */
    public function filterByMinPrice($minPrice = null, $comparison = null)
    {
        if (is_array($minPrice)) {
            $useMinMax = false;
            if (isset($minPrice['min'])) {
                $this->addUsingAlias(ShopDiscountsTableMap::COL_MIN_PRICE, $minPrice['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($minPrice['max'])) {
                $this->addUsingAlias(ShopDiscountsTableMap::COL_MIN_PRICE, $minPrice['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ShopDiscountsTableMap::COL_MIN_PRICE, $minPrice, $comparison);
    }

    /**
     * Filter the query on the max_price column
     *
     * Example usage:
     * <code>
     * $query->filterByMaxPrice(1234); // WHERE max_price = 1234
     * $query->filterByMaxPrice(array(12, 34)); // WHERE max_price IN (12, 34)
     * $query->filterByMaxPrice(array('min' => 12)); // WHERE max_price > 12
     * </code>
     *
     * @param     mixed $maxPrice The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildShopDiscountsQuery The current query, for fluid interface
     */
    public function filterByMaxPrice($maxPrice = null, $comparison = null)
    {
        if (is_array($maxPrice)) {
            $useMinMax = false;
            if (isset($maxPrice['min'])) {
                $this->addUsingAlias(ShopDiscountsTableMap::COL_MAX_PRICE, $maxPrice['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($maxPrice['max'])) {
                $this->addUsingAlias(ShopDiscountsTableMap::COL_MAX_PRICE, $maxPrice['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ShopDiscountsTableMap::COL_MAX_PRICE, $maxPrice, $comparison);
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
     * @return $this|ChildShopDiscountsQuery The current query, for fluid interface
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

        return $this->addUsingAlias(ShopDiscountsTableMap::COL_CATEGORIES, $categories, $comparison);
    }

    /**
     * Filter the query on the products column
     *
     * Example usage:
     * <code>
     * $query->filterByProducts('fooValue');   // WHERE products = 'fooValue'
     * $query->filterByProducts('%fooValue%'); // WHERE products LIKE '%fooValue%'
     * </code>
     *
     * @param     string $products The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildShopDiscountsQuery The current query, for fluid interface
     */
    public function filterByProducts($products = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($products)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $products)) {
                $products = str_replace('*', '%', $products);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ShopDiscountsTableMap::COL_PRODUCTS, $products, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildShopDiscounts $shopDiscounts Object to remove from the list of results
     *
     * @return $this|ChildShopDiscountsQuery The current query, for fluid interface
     */
    public function prune($shopDiscounts = null)
    {
        if ($shopDiscounts) {
            $this->addUsingAlias(ShopDiscountsTableMap::COL_ID, $shopDiscounts->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the shop_discounts table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ShopDiscountsTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ShopDiscountsTableMap::clearInstancePool();
            ShopDiscountsTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(ShopDiscountsTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ShopDiscountsTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            ShopDiscountsTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            ShopDiscountsTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // ShopDiscountsQuery
