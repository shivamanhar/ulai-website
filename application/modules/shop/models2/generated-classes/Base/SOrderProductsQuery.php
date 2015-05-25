<?php

namespace Base;

use \SOrderProducts as ChildSOrderProducts;
use \SOrderProductsQuery as ChildSOrderProductsQuery;
use \Exception;
use \PDO;
use Map\SOrderProductsTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'shop_orders_products' table.
 *
 *
 *
 * @method     ChildSOrderProductsQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildSOrderProductsQuery orderByOrderId($order = Criteria::ASC) Order by the order_id column
 * @method     ChildSOrderProductsQuery orderByKitId($order = Criteria::ASC) Order by the kit_id column
 * @method     ChildSOrderProductsQuery orderByIsMain($order = Criteria::ASC) Order by the is_main column
 * @method     ChildSOrderProductsQuery orderByProductId($order = Criteria::ASC) Order by the product_id column
 * @method     ChildSOrderProductsQuery orderByVariantId($order = Criteria::ASC) Order by the variant_id column
 * @method     ChildSOrderProductsQuery orderByProductName($order = Criteria::ASC) Order by the product_name column
 * @method     ChildSOrderProductsQuery orderByVariantName($order = Criteria::ASC) Order by the variant_name column
 * @method     ChildSOrderProductsQuery orderByPrice($order = Criteria::ASC) Order by the price column
 * @method     ChildSOrderProductsQuery orderByOriginPrice($order = Criteria::ASC) Order by the origin_price column
 * @method     ChildSOrderProductsQuery orderByQuantity($order = Criteria::ASC) Order by the quantity column
 *
 * @method     ChildSOrderProductsQuery groupById() Group by the id column
 * @method     ChildSOrderProductsQuery groupByOrderId() Group by the order_id column
 * @method     ChildSOrderProductsQuery groupByKitId() Group by the kit_id column
 * @method     ChildSOrderProductsQuery groupByIsMain() Group by the is_main column
 * @method     ChildSOrderProductsQuery groupByProductId() Group by the product_id column
 * @method     ChildSOrderProductsQuery groupByVariantId() Group by the variant_id column
 * @method     ChildSOrderProductsQuery groupByProductName() Group by the product_name column
 * @method     ChildSOrderProductsQuery groupByVariantName() Group by the variant_name column
 * @method     ChildSOrderProductsQuery groupByPrice() Group by the price column
 * @method     ChildSOrderProductsQuery groupByOriginPrice() Group by the origin_price column
 * @method     ChildSOrderProductsQuery groupByQuantity() Group by the quantity column
 *
 * @method     ChildSOrderProductsQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildSOrderProductsQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildSOrderProductsQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildSOrderProductsQuery leftJoinSProducts($relationAlias = null) Adds a LEFT JOIN clause to the query using the SProducts relation
 * @method     ChildSOrderProductsQuery rightJoinSProducts($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SProducts relation
 * @method     ChildSOrderProductsQuery innerJoinSProducts($relationAlias = null) Adds a INNER JOIN clause to the query using the SProducts relation
 *
 * @method     ChildSOrderProductsQuery leftJoinSProductVariants($relationAlias = null) Adds a LEFT JOIN clause to the query using the SProductVariants relation
 * @method     ChildSOrderProductsQuery rightJoinSProductVariants($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SProductVariants relation
 * @method     ChildSOrderProductsQuery innerJoinSProductVariants($relationAlias = null) Adds a INNER JOIN clause to the query using the SProductVariants relation
 *
 * @method     ChildSOrderProductsQuery leftJoinSOrders($relationAlias = null) Adds a LEFT JOIN clause to the query using the SOrders relation
 * @method     ChildSOrderProductsQuery rightJoinSOrders($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SOrders relation
 * @method     ChildSOrderProductsQuery innerJoinSOrders($relationAlias = null) Adds a INNER JOIN clause to the query using the SOrders relation
 *
 * @method     \SProductsQuery|\SProductVariantsQuery|\SOrdersQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildSOrderProducts findOne(ConnectionInterface $con = null) Return the first ChildSOrderProducts matching the query
 * @method     ChildSOrderProducts findOneOrCreate(ConnectionInterface $con = null) Return the first ChildSOrderProducts matching the query, or a new ChildSOrderProducts object populated from the query conditions when no match is found
 *
 * @method     ChildSOrderProducts findOneById(int $id) Return the first ChildSOrderProducts filtered by the id column
 * @method     ChildSOrderProducts findOneByOrderId(int $order_id) Return the first ChildSOrderProducts filtered by the order_id column
 * @method     ChildSOrderProducts findOneByKitId(int $kit_id) Return the first ChildSOrderProducts filtered by the kit_id column
 * @method     ChildSOrderProducts findOneByIsMain(boolean $is_main) Return the first ChildSOrderProducts filtered by the is_main column
 * @method     ChildSOrderProducts findOneByProductId(int $product_id) Return the first ChildSOrderProducts filtered by the product_id column
 * @method     ChildSOrderProducts findOneByVariantId(int $variant_id) Return the first ChildSOrderProducts filtered by the variant_id column
 * @method     ChildSOrderProducts findOneByProductName(string $product_name) Return the first ChildSOrderProducts filtered by the product_name column
 * @method     ChildSOrderProducts findOneByVariantName(string $variant_name) Return the first ChildSOrderProducts filtered by the variant_name column
 * @method     ChildSOrderProducts findOneByPrice(double $price) Return the first ChildSOrderProducts filtered by the price column
 * @method     ChildSOrderProducts findOneByOriginPrice(double $origin_price) Return the first ChildSOrderProducts filtered by the origin_price column
 * @method     ChildSOrderProducts findOneByQuantity(int $quantity) Return the first ChildSOrderProducts filtered by the quantity column *

 * @method     ChildSOrderProducts requirePk($key, ConnectionInterface $con = null) Return the ChildSOrderProducts by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSOrderProducts requireOne(ConnectionInterface $con = null) Return the first ChildSOrderProducts matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSOrderProducts requireOneById(int $id) Return the first ChildSOrderProducts filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSOrderProducts requireOneByOrderId(int $order_id) Return the first ChildSOrderProducts filtered by the order_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSOrderProducts requireOneByKitId(int $kit_id) Return the first ChildSOrderProducts filtered by the kit_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSOrderProducts requireOneByIsMain(boolean $is_main) Return the first ChildSOrderProducts filtered by the is_main column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSOrderProducts requireOneByProductId(int $product_id) Return the first ChildSOrderProducts filtered by the product_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSOrderProducts requireOneByVariantId(int $variant_id) Return the first ChildSOrderProducts filtered by the variant_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSOrderProducts requireOneByProductName(string $product_name) Return the first ChildSOrderProducts filtered by the product_name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSOrderProducts requireOneByVariantName(string $variant_name) Return the first ChildSOrderProducts filtered by the variant_name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSOrderProducts requireOneByPrice(double $price) Return the first ChildSOrderProducts filtered by the price column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSOrderProducts requireOneByOriginPrice(double $origin_price) Return the first ChildSOrderProducts filtered by the origin_price column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSOrderProducts requireOneByQuantity(int $quantity) Return the first ChildSOrderProducts filtered by the quantity column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSOrderProducts[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildSOrderProducts objects based on current ModelCriteria
 * @method     ChildSOrderProducts[]|ObjectCollection findById(int $id) Return ChildSOrderProducts objects filtered by the id column
 * @method     ChildSOrderProducts[]|ObjectCollection findByOrderId(int $order_id) Return ChildSOrderProducts objects filtered by the order_id column
 * @method     ChildSOrderProducts[]|ObjectCollection findByKitId(int $kit_id) Return ChildSOrderProducts objects filtered by the kit_id column
 * @method     ChildSOrderProducts[]|ObjectCollection findByIsMain(boolean $is_main) Return ChildSOrderProducts objects filtered by the is_main column
 * @method     ChildSOrderProducts[]|ObjectCollection findByProductId(int $product_id) Return ChildSOrderProducts objects filtered by the product_id column
 * @method     ChildSOrderProducts[]|ObjectCollection findByVariantId(int $variant_id) Return ChildSOrderProducts objects filtered by the variant_id column
 * @method     ChildSOrderProducts[]|ObjectCollection findByProductName(string $product_name) Return ChildSOrderProducts objects filtered by the product_name column
 * @method     ChildSOrderProducts[]|ObjectCollection findByVariantName(string $variant_name) Return ChildSOrderProducts objects filtered by the variant_name column
 * @method     ChildSOrderProducts[]|ObjectCollection findByPrice(double $price) Return ChildSOrderProducts objects filtered by the price column
 * @method     ChildSOrderProducts[]|ObjectCollection findByOriginPrice(double $origin_price) Return ChildSOrderProducts objects filtered by the origin_price column
 * @method     ChildSOrderProducts[]|ObjectCollection findByQuantity(int $quantity) Return ChildSOrderProducts objects filtered by the quantity column
 * @method     ChildSOrderProducts[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class SOrderProductsQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\SOrderProductsQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'Shop', $modelName = '\\SOrderProducts', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildSOrderProductsQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildSOrderProductsQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildSOrderProductsQuery) {
            return $criteria;
        }
        $query = new ChildSOrderProductsQuery();
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
     * @return ChildSOrderProducts|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = SOrderProductsTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(SOrderProductsTableMap::DATABASE_NAME);
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
     * @return ChildSOrderProducts A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, order_id, kit_id, is_main, product_id, variant_id, product_name, variant_name, price, origin_price, quantity FROM shop_orders_products WHERE id = :p0';
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
            /** @var ChildSOrderProducts $obj */
            $obj = new ChildSOrderProducts();
            $obj->hydrate($row);
            SOrderProductsTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildSOrderProducts|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildSOrderProductsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(SOrderProductsTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildSOrderProductsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(SOrderProductsTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildSOrderProductsQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(SOrderProductsTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(SOrderProductsTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SOrderProductsTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildSOrderProductsQuery The current query, for fluid interface
     */
    public function filterByOrderId($orderId = null, $comparison = null)
    {
        if (is_array($orderId)) {
            $useMinMax = false;
            if (isset($orderId['min'])) {
                $this->addUsingAlias(SOrderProductsTableMap::COL_ORDER_ID, $orderId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($orderId['max'])) {
                $this->addUsingAlias(SOrderProductsTableMap::COL_ORDER_ID, $orderId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SOrderProductsTableMap::COL_ORDER_ID, $orderId, $comparison);
    }

    /**
     * Filter the query on the kit_id column
     *
     * Example usage:
     * <code>
     * $query->filterByKitId(1234); // WHERE kit_id = 1234
     * $query->filterByKitId(array(12, 34)); // WHERE kit_id IN (12, 34)
     * $query->filterByKitId(array('min' => 12)); // WHERE kit_id > 12
     * </code>
     *
     * @param     mixed $kitId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSOrderProductsQuery The current query, for fluid interface
     */
    public function filterByKitId($kitId = null, $comparison = null)
    {
        if (is_array($kitId)) {
            $useMinMax = false;
            if (isset($kitId['min'])) {
                $this->addUsingAlias(SOrderProductsTableMap::COL_KIT_ID, $kitId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($kitId['max'])) {
                $this->addUsingAlias(SOrderProductsTableMap::COL_KIT_ID, $kitId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SOrderProductsTableMap::COL_KIT_ID, $kitId, $comparison);
    }

    /**
     * Filter the query on the is_main column
     *
     * Example usage:
     * <code>
     * $query->filterByIsMain(true); // WHERE is_main = true
     * $query->filterByIsMain('yes'); // WHERE is_main = true
     * </code>
     *
     * @param     boolean|string $isMain The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSOrderProductsQuery The current query, for fluid interface
     */
    public function filterByIsMain($isMain = null, $comparison = null)
    {
        if (is_string($isMain)) {
            $isMain = in_array(strtolower($isMain), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(SOrderProductsTableMap::COL_IS_MAIN, $isMain, $comparison);
    }

    /**
     * Filter the query on the product_id column
     *
     * Example usage:
     * <code>
     * $query->filterByProductId(1234); // WHERE product_id = 1234
     * $query->filterByProductId(array(12, 34)); // WHERE product_id IN (12, 34)
     * $query->filterByProductId(array('min' => 12)); // WHERE product_id > 12
     * </code>
     *
     * @see       filterBySProducts()
     *
     * @param     mixed $productId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSOrderProductsQuery The current query, for fluid interface
     */
    public function filterByProductId($productId = null, $comparison = null)
    {
        if (is_array($productId)) {
            $useMinMax = false;
            if (isset($productId['min'])) {
                $this->addUsingAlias(SOrderProductsTableMap::COL_PRODUCT_ID, $productId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($productId['max'])) {
                $this->addUsingAlias(SOrderProductsTableMap::COL_PRODUCT_ID, $productId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SOrderProductsTableMap::COL_PRODUCT_ID, $productId, $comparison);
    }

    /**
     * Filter the query on the variant_id column
     *
     * Example usage:
     * <code>
     * $query->filterByVariantId(1234); // WHERE variant_id = 1234
     * $query->filterByVariantId(array(12, 34)); // WHERE variant_id IN (12, 34)
     * $query->filterByVariantId(array('min' => 12)); // WHERE variant_id > 12
     * </code>
     *
     * @see       filterBySProductVariants()
     *
     * @param     mixed $variantId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSOrderProductsQuery The current query, for fluid interface
     */
    public function filterByVariantId($variantId = null, $comparison = null)
    {
        if (is_array($variantId)) {
            $useMinMax = false;
            if (isset($variantId['min'])) {
                $this->addUsingAlias(SOrderProductsTableMap::COL_VARIANT_ID, $variantId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($variantId['max'])) {
                $this->addUsingAlias(SOrderProductsTableMap::COL_VARIANT_ID, $variantId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SOrderProductsTableMap::COL_VARIANT_ID, $variantId, $comparison);
    }

    /**
     * Filter the query on the product_name column
     *
     * Example usage:
     * <code>
     * $query->filterByProductName('fooValue');   // WHERE product_name = 'fooValue'
     * $query->filterByProductName('%fooValue%'); // WHERE product_name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $productName The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSOrderProductsQuery The current query, for fluid interface
     */
    public function filterByProductName($productName = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($productName)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $productName)) {
                $productName = str_replace('*', '%', $productName);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SOrderProductsTableMap::COL_PRODUCT_NAME, $productName, $comparison);
    }

    /**
     * Filter the query on the variant_name column
     *
     * Example usage:
     * <code>
     * $query->filterByVariantName('fooValue');   // WHERE variant_name = 'fooValue'
     * $query->filterByVariantName('%fooValue%'); // WHERE variant_name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $variantName The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSOrderProductsQuery The current query, for fluid interface
     */
    public function filterByVariantName($variantName = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($variantName)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $variantName)) {
                $variantName = str_replace('*', '%', $variantName);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SOrderProductsTableMap::COL_VARIANT_NAME, $variantName, $comparison);
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
     * @return $this|ChildSOrderProductsQuery The current query, for fluid interface
     */
    public function filterByPrice($price = null, $comparison = null)
    {
        if (is_array($price)) {
            $useMinMax = false;
            if (isset($price['min'])) {
                $this->addUsingAlias(SOrderProductsTableMap::COL_PRICE, $price['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($price['max'])) {
                $this->addUsingAlias(SOrderProductsTableMap::COL_PRICE, $price['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SOrderProductsTableMap::COL_PRICE, $price, $comparison);
    }

    /**
     * Filter the query on the origin_price column
     *
     * Example usage:
     * <code>
     * $query->filterByOriginPrice(1234); // WHERE origin_price = 1234
     * $query->filterByOriginPrice(array(12, 34)); // WHERE origin_price IN (12, 34)
     * $query->filterByOriginPrice(array('min' => 12)); // WHERE origin_price > 12
     * </code>
     *
     * @param     mixed $originPrice The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSOrderProductsQuery The current query, for fluid interface
     */
    public function filterByOriginPrice($originPrice = null, $comparison = null)
    {
        if (is_array($originPrice)) {
            $useMinMax = false;
            if (isset($originPrice['min'])) {
                $this->addUsingAlias(SOrderProductsTableMap::COL_ORIGIN_PRICE, $originPrice['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($originPrice['max'])) {
                $this->addUsingAlias(SOrderProductsTableMap::COL_ORIGIN_PRICE, $originPrice['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SOrderProductsTableMap::COL_ORIGIN_PRICE, $originPrice, $comparison);
    }

    /**
     * Filter the query on the quantity column
     *
     * Example usage:
     * <code>
     * $query->filterByQuantity(1234); // WHERE quantity = 1234
     * $query->filterByQuantity(array(12, 34)); // WHERE quantity IN (12, 34)
     * $query->filterByQuantity(array('min' => 12)); // WHERE quantity > 12
     * </code>
     *
     * @param     mixed $quantity The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSOrderProductsQuery The current query, for fluid interface
     */
    public function filterByQuantity($quantity = null, $comparison = null)
    {
        if (is_array($quantity)) {
            $useMinMax = false;
            if (isset($quantity['min'])) {
                $this->addUsingAlias(SOrderProductsTableMap::COL_QUANTITY, $quantity['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($quantity['max'])) {
                $this->addUsingAlias(SOrderProductsTableMap::COL_QUANTITY, $quantity['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SOrderProductsTableMap::COL_QUANTITY, $quantity, $comparison);
    }

    /**
     * Filter the query by a related \SProducts object
     *
     * @param \SProducts|ObjectCollection $sProducts The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildSOrderProductsQuery The current query, for fluid interface
     */
    public function filterBySProducts($sProducts, $comparison = null)
    {
        if ($sProducts instanceof \SProducts) {
            return $this
                ->addUsingAlias(SOrderProductsTableMap::COL_PRODUCT_ID, $sProducts->getId(), $comparison);
        } elseif ($sProducts instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(SOrderProductsTableMap::COL_PRODUCT_ID, $sProducts->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterBySProducts() only accepts arguments of type \SProducts or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the SProducts relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSOrderProductsQuery The current query, for fluid interface
     */
    public function joinSProducts($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('SProducts');

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
            $this->addJoinObject($join, 'SProducts');
        }

        return $this;
    }

    /**
     * Use the SProducts relation SProducts object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \SProductsQuery A secondary query class using the current class as primary query
     */
    public function useSProductsQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinSProducts($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'SProducts', '\SProductsQuery');
    }

    /**
     * Filter the query by a related \SProductVariants object
     *
     * @param \SProductVariants|ObjectCollection $sProductVariants The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildSOrderProductsQuery The current query, for fluid interface
     */
    public function filterBySProductVariants($sProductVariants, $comparison = null)
    {
        if ($sProductVariants instanceof \SProductVariants) {
            return $this
                ->addUsingAlias(SOrderProductsTableMap::COL_VARIANT_ID, $sProductVariants->getId(), $comparison);
        } elseif ($sProductVariants instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(SOrderProductsTableMap::COL_VARIANT_ID, $sProductVariants->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterBySProductVariants() only accepts arguments of type \SProductVariants or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the SProductVariants relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSOrderProductsQuery The current query, for fluid interface
     */
    public function joinSProductVariants($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('SProductVariants');

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
            $this->addJoinObject($join, 'SProductVariants');
        }

        return $this;
    }

    /**
     * Use the SProductVariants relation SProductVariants object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \SProductVariantsQuery A secondary query class using the current class as primary query
     */
    public function useSProductVariantsQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinSProductVariants($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'SProductVariants', '\SProductVariantsQuery');
    }

    /**
     * Filter the query by a related \SOrders object
     *
     * @param \SOrders|ObjectCollection $sOrders The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildSOrderProductsQuery The current query, for fluid interface
     */
    public function filterBySOrders($sOrders, $comparison = null)
    {
        if ($sOrders instanceof \SOrders) {
            return $this
                ->addUsingAlias(SOrderProductsTableMap::COL_ORDER_ID, $sOrders->getId(), $comparison);
        } elseif ($sOrders instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(SOrderProductsTableMap::COL_ORDER_ID, $sOrders->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildSOrderProductsQuery The current query, for fluid interface
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
     * Exclude object from result
     *
     * @param   ChildSOrderProducts $sOrderProducts Object to remove from the list of results
     *
     * @return $this|ChildSOrderProductsQuery The current query, for fluid interface
     */
    public function prune($sOrderProducts = null)
    {
        if ($sOrderProducts) {
            $this->addUsingAlias(SOrderProductsTableMap::COL_ID, $sOrderProducts->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the shop_orders_products table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SOrderProductsTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            SOrderProductsTableMap::clearInstancePool();
            SOrderProductsTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(SOrderProductsTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(SOrderProductsTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            SOrderProductsTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            SOrderProductsTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // SOrderProductsQuery
