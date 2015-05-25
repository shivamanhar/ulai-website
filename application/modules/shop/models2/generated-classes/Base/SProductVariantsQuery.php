<?php

namespace Base;

use \SProductVariants as ChildSProductVariants;
use \SProductVariantsI18nQuery as ChildSProductVariantsI18nQuery;
use \SProductVariantsQuery as ChildSProductVariantsQuery;
use \Exception;
use \PDO;
use Map\SProductVariantsI18nTableMap;
use Map\SProductVariantsTableMap;
use Map\ShopKitProductTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'shop_product_variants' table.
 *
 *
 *
 * @method     ChildSProductVariantsQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildSProductVariantsQuery orderByExternalId($order = Criteria::ASC) Order by the external_id column
 * @method     ChildSProductVariantsQuery orderByProductId($order = Criteria::ASC) Order by the product_id column
 * @method     ChildSProductVariantsQuery orderByPrice($order = Criteria::ASC) Order by the price column
 * @method     ChildSProductVariantsQuery orderByNumber($order = Criteria::ASC) Order by the number column
 * @method     ChildSProductVariantsQuery orderByStock($order = Criteria::ASC) Order by the stock column
 * @method     ChildSProductVariantsQuery orderByMainimage($order = Criteria::ASC) Order by the mainImage column
 * @method     ChildSProductVariantsQuery orderByPosition($order = Criteria::ASC) Order by the position column
 * @method     ChildSProductVariantsQuery orderByCurrency($order = Criteria::ASC) Order by the currency column
 * @method     ChildSProductVariantsQuery orderByPriceInMain($order = Criteria::ASC) Order by the price_in_main column
 *
 * @method     ChildSProductVariantsQuery groupById() Group by the id column
 * @method     ChildSProductVariantsQuery groupByExternalId() Group by the external_id column
 * @method     ChildSProductVariantsQuery groupByProductId() Group by the product_id column
 * @method     ChildSProductVariantsQuery groupByPrice() Group by the price column
 * @method     ChildSProductVariantsQuery groupByNumber() Group by the number column
 * @method     ChildSProductVariantsQuery groupByStock() Group by the stock column
 * @method     ChildSProductVariantsQuery groupByMainimage() Group by the mainImage column
 * @method     ChildSProductVariantsQuery groupByPosition() Group by the position column
 * @method     ChildSProductVariantsQuery groupByCurrency() Group by the currency column
 * @method     ChildSProductVariantsQuery groupByPriceInMain() Group by the price_in_main column
 *
 * @method     ChildSProductVariantsQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildSProductVariantsQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildSProductVariantsQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildSProductVariantsQuery leftJoinSProducts($relationAlias = null) Adds a LEFT JOIN clause to the query using the SProducts relation
 * @method     ChildSProductVariantsQuery rightJoinSProducts($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SProducts relation
 * @method     ChildSProductVariantsQuery innerJoinSProducts($relationAlias = null) Adds a INNER JOIN clause to the query using the SProducts relation
 *
 * @method     ChildSProductVariantsQuery leftJoinSCurrencies($relationAlias = null) Adds a LEFT JOIN clause to the query using the SCurrencies relation
 * @method     ChildSProductVariantsQuery rightJoinSCurrencies($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SCurrencies relation
 * @method     ChildSProductVariantsQuery innerJoinSCurrencies($relationAlias = null) Adds a INNER JOIN clause to the query using the SCurrencies relation
 *
 * @method     ChildSProductVariantsQuery leftJoinShopKitProduct($relationAlias = null) Adds a LEFT JOIN clause to the query using the ShopKitProduct relation
 * @method     ChildSProductVariantsQuery rightJoinShopKitProduct($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ShopKitProduct relation
 * @method     ChildSProductVariantsQuery innerJoinShopKitProduct($relationAlias = null) Adds a INNER JOIN clause to the query using the ShopKitProduct relation
 *
 * @method     ChildSProductVariantsQuery leftJoinSProductVariantsI18n($relationAlias = null) Adds a LEFT JOIN clause to the query using the SProductVariantsI18n relation
 * @method     ChildSProductVariantsQuery rightJoinSProductVariantsI18n($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SProductVariantsI18n relation
 * @method     ChildSProductVariantsQuery innerJoinSProductVariantsI18n($relationAlias = null) Adds a INNER JOIN clause to the query using the SProductVariantsI18n relation
 *
 * @method     ChildSProductVariantsQuery leftJoinSNotifications($relationAlias = null) Adds a LEFT JOIN clause to the query using the SNotifications relation
 * @method     ChildSProductVariantsQuery rightJoinSNotifications($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SNotifications relation
 * @method     ChildSProductVariantsQuery innerJoinSNotifications($relationAlias = null) Adds a INNER JOIN clause to the query using the SNotifications relation
 *
 * @method     ChildSProductVariantsQuery leftJoinSOrderProducts($relationAlias = null) Adds a LEFT JOIN clause to the query using the SOrderProducts relation
 * @method     ChildSProductVariantsQuery rightJoinSOrderProducts($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SOrderProducts relation
 * @method     ChildSProductVariantsQuery innerJoinSOrderProducts($relationAlias = null) Adds a INNER JOIN clause to the query using the SOrderProducts relation
 *
 * @method     \SProductsQuery|\SCurrenciesQuery|\ShopKitProductQuery|\SProductVariantsI18nQuery|\SNotificationsQuery|\SOrderProductsQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildSProductVariants findOne(ConnectionInterface $con = null) Return the first ChildSProductVariants matching the query
 * @method     ChildSProductVariants findOneOrCreate(ConnectionInterface $con = null) Return the first ChildSProductVariants matching the query, or a new ChildSProductVariants object populated from the query conditions when no match is found
 *
 * @method     ChildSProductVariants findOneById(int $id) Return the first ChildSProductVariants filtered by the id column
 * @method     ChildSProductVariants findOneByExternalId(string $external_id) Return the first ChildSProductVariants filtered by the external_id column
 * @method     ChildSProductVariants findOneByProductId(int $product_id) Return the first ChildSProductVariants filtered by the product_id column
 * @method     ChildSProductVariants findOneByPrice(double $price) Return the first ChildSProductVariants filtered by the price column
 * @method     ChildSProductVariants findOneByNumber(string $number) Return the first ChildSProductVariants filtered by the number column
 * @method     ChildSProductVariants findOneByStock(int $stock) Return the first ChildSProductVariants filtered by the stock column
 * @method     ChildSProductVariants findOneByMainimage(string $mainImage) Return the first ChildSProductVariants filtered by the mainImage column
 * @method     ChildSProductVariants findOneByPosition(int $position) Return the first ChildSProductVariants filtered by the position column
 * @method     ChildSProductVariants findOneByCurrency(int $currency) Return the first ChildSProductVariants filtered by the currency column
 * @method     ChildSProductVariants findOneByPriceInMain(string $price_in_main) Return the first ChildSProductVariants filtered by the price_in_main column *

 * @method     ChildSProductVariants requirePk($key, ConnectionInterface $con = null) Return the ChildSProductVariants by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSProductVariants requireOne(ConnectionInterface $con = null) Return the first ChildSProductVariants matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSProductVariants requireOneById(int $id) Return the first ChildSProductVariants filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSProductVariants requireOneByExternalId(string $external_id) Return the first ChildSProductVariants filtered by the external_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSProductVariants requireOneByProductId(int $product_id) Return the first ChildSProductVariants filtered by the product_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSProductVariants requireOneByPrice(double $price) Return the first ChildSProductVariants filtered by the price column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSProductVariants requireOneByNumber(string $number) Return the first ChildSProductVariants filtered by the number column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSProductVariants requireOneByStock(int $stock) Return the first ChildSProductVariants filtered by the stock column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSProductVariants requireOneByMainimage(string $mainImage) Return the first ChildSProductVariants filtered by the mainImage column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSProductVariants requireOneByPosition(int $position) Return the first ChildSProductVariants filtered by the position column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSProductVariants requireOneByCurrency(int $currency) Return the first ChildSProductVariants filtered by the currency column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSProductVariants requireOneByPriceInMain(string $price_in_main) Return the first ChildSProductVariants filtered by the price_in_main column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSProductVariants[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildSProductVariants objects based on current ModelCriteria
 * @method     ChildSProductVariants[]|ObjectCollection findById(int $id) Return ChildSProductVariants objects filtered by the id column
 * @method     ChildSProductVariants[]|ObjectCollection findByExternalId(string $external_id) Return ChildSProductVariants objects filtered by the external_id column
 * @method     ChildSProductVariants[]|ObjectCollection findByProductId(int $product_id) Return ChildSProductVariants objects filtered by the product_id column
 * @method     ChildSProductVariants[]|ObjectCollection findByPrice(double $price) Return ChildSProductVariants objects filtered by the price column
 * @method     ChildSProductVariants[]|ObjectCollection findByNumber(string $number) Return ChildSProductVariants objects filtered by the number column
 * @method     ChildSProductVariants[]|ObjectCollection findByStock(int $stock) Return ChildSProductVariants objects filtered by the stock column
 * @method     ChildSProductVariants[]|ObjectCollection findByMainimage(string $mainImage) Return ChildSProductVariants objects filtered by the mainImage column
 * @method     ChildSProductVariants[]|ObjectCollection findByPosition(int $position) Return ChildSProductVariants objects filtered by the position column
 * @method     ChildSProductVariants[]|ObjectCollection findByCurrency(int $currency) Return ChildSProductVariants objects filtered by the currency column
 * @method     ChildSProductVariants[]|ObjectCollection findByPriceInMain(string $price_in_main) Return ChildSProductVariants objects filtered by the price_in_main column
 * @method     ChildSProductVariants[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class SProductVariantsQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\SProductVariantsQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'Shop', $modelName = '\\SProductVariants', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildSProductVariantsQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildSProductVariantsQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildSProductVariantsQuery) {
            return $criteria;
        }
        $query = new ChildSProductVariantsQuery();
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
     * @return ChildSProductVariants|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = SProductVariantsTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(SProductVariantsTableMap::DATABASE_NAME);
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
     * @return ChildSProductVariants A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, external_id, product_id, price, number, stock, mainImage, position, currency, price_in_main FROM shop_product_variants WHERE id = :p0';
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
            /** @var ChildSProductVariants $obj */
            $obj = new ChildSProductVariants();
            $obj->hydrate($row);
            SProductVariantsTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildSProductVariants|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildSProductVariantsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(SProductVariantsTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildSProductVariantsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(SProductVariantsTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildSProductVariantsQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(SProductVariantsTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(SProductVariantsTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SProductVariantsTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the external_id column
     *
     * Example usage:
     * <code>
     * $query->filterByExternalId('fooValue');   // WHERE external_id = 'fooValue'
     * $query->filterByExternalId('%fooValue%'); // WHERE external_id LIKE '%fooValue%'
     * </code>
     *
     * @param     string $externalId The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSProductVariantsQuery The current query, for fluid interface
     */
    public function filterByExternalId($externalId = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($externalId)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $externalId)) {
                $externalId = str_replace('*', '%', $externalId);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SProductVariantsTableMap::COL_EXTERNAL_ID, $externalId, $comparison);
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
     * @return $this|ChildSProductVariantsQuery The current query, for fluid interface
     */
    public function filterByProductId($productId = null, $comparison = null)
    {
        if (is_array($productId)) {
            $useMinMax = false;
            if (isset($productId['min'])) {
                $this->addUsingAlias(SProductVariantsTableMap::COL_PRODUCT_ID, $productId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($productId['max'])) {
                $this->addUsingAlias(SProductVariantsTableMap::COL_PRODUCT_ID, $productId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SProductVariantsTableMap::COL_PRODUCT_ID, $productId, $comparison);
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
     * @return $this|ChildSProductVariantsQuery The current query, for fluid interface
     */
    public function filterByPrice($price = null, $comparison = null)
    {
        if (is_array($price)) {
            $useMinMax = false;
            if (isset($price['min'])) {
                $this->addUsingAlias(SProductVariantsTableMap::COL_PRICE, $price['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($price['max'])) {
                $this->addUsingAlias(SProductVariantsTableMap::COL_PRICE, $price['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SProductVariantsTableMap::COL_PRICE, $price, $comparison);
    }

    /**
     * Filter the query on the number column
     *
     * Example usage:
     * <code>
     * $query->filterByNumber('fooValue');   // WHERE number = 'fooValue'
     * $query->filterByNumber('%fooValue%'); // WHERE number LIKE '%fooValue%'
     * </code>
     *
     * @param     string $number The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSProductVariantsQuery The current query, for fluid interface
     */
    public function filterByNumber($number = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($number)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $number)) {
                $number = str_replace('*', '%', $number);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SProductVariantsTableMap::COL_NUMBER, $number, $comparison);
    }

    /**
     * Filter the query on the stock column
     *
     * Example usage:
     * <code>
     * $query->filterByStock(1234); // WHERE stock = 1234
     * $query->filterByStock(array(12, 34)); // WHERE stock IN (12, 34)
     * $query->filterByStock(array('min' => 12)); // WHERE stock > 12
     * </code>
     *
     * @param     mixed $stock The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSProductVariantsQuery The current query, for fluid interface
     */
    public function filterByStock($stock = null, $comparison = null)
    {
        if (is_array($stock)) {
            $useMinMax = false;
            if (isset($stock['min'])) {
                $this->addUsingAlias(SProductVariantsTableMap::COL_STOCK, $stock['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($stock['max'])) {
                $this->addUsingAlias(SProductVariantsTableMap::COL_STOCK, $stock['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SProductVariantsTableMap::COL_STOCK, $stock, $comparison);
    }

    /**
     * Filter the query on the mainImage column
     *
     * Example usage:
     * <code>
     * $query->filterByMainimage('fooValue');   // WHERE mainImage = 'fooValue'
     * $query->filterByMainimage('%fooValue%'); // WHERE mainImage LIKE '%fooValue%'
     * </code>
     *
     * @param     string $mainimage The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSProductVariantsQuery The current query, for fluid interface
     */
    public function filterByMainimage($mainimage = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($mainimage)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $mainimage)) {
                $mainimage = str_replace('*', '%', $mainimage);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SProductVariantsTableMap::COL_MAINIMAGE, $mainimage, $comparison);
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
     * @return $this|ChildSProductVariantsQuery The current query, for fluid interface
     */
    public function filterByPosition($position = null, $comparison = null)
    {
        if (is_array($position)) {
            $useMinMax = false;
            if (isset($position['min'])) {
                $this->addUsingAlias(SProductVariantsTableMap::COL_POSITION, $position['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($position['max'])) {
                $this->addUsingAlias(SProductVariantsTableMap::COL_POSITION, $position['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SProductVariantsTableMap::COL_POSITION, $position, $comparison);
    }

    /**
     * Filter the query on the currency column
     *
     * Example usage:
     * <code>
     * $query->filterByCurrency(1234); // WHERE currency = 1234
     * $query->filterByCurrency(array(12, 34)); // WHERE currency IN (12, 34)
     * $query->filterByCurrency(array('min' => 12)); // WHERE currency > 12
     * </code>
     *
     * @see       filterBySCurrencies()
     *
     * @param     mixed $currency The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSProductVariantsQuery The current query, for fluid interface
     */
    public function filterByCurrency($currency = null, $comparison = null)
    {
        if (is_array($currency)) {
            $useMinMax = false;
            if (isset($currency['min'])) {
                $this->addUsingAlias(SProductVariantsTableMap::COL_CURRENCY, $currency['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($currency['max'])) {
                $this->addUsingAlias(SProductVariantsTableMap::COL_CURRENCY, $currency['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SProductVariantsTableMap::COL_CURRENCY, $currency, $comparison);
    }

    /**
     * Filter the query on the price_in_main column
     *
     * Example usage:
     * <code>
     * $query->filterByPriceInMain(1234); // WHERE price_in_main = 1234
     * $query->filterByPriceInMain(array(12, 34)); // WHERE price_in_main IN (12, 34)
     * $query->filterByPriceInMain(array('min' => 12)); // WHERE price_in_main > 12
     * </code>
     *
     * @param     mixed $priceInMain The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSProductVariantsQuery The current query, for fluid interface
     */
    public function filterByPriceInMain($priceInMain = null, $comparison = null)
    {
        if (is_array($priceInMain)) {
            $useMinMax = false;
            if (isset($priceInMain['min'])) {
                $this->addUsingAlias(SProductVariantsTableMap::COL_PRICE_IN_MAIN, $priceInMain['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($priceInMain['max'])) {
                $this->addUsingAlias(SProductVariantsTableMap::COL_PRICE_IN_MAIN, $priceInMain['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SProductVariantsTableMap::COL_PRICE_IN_MAIN, $priceInMain, $comparison);
    }

    /**
     * Filter the query by a related \SProducts object
     *
     * @param \SProducts|ObjectCollection $sProducts The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildSProductVariantsQuery The current query, for fluid interface
     */
    public function filterBySProducts($sProducts, $comparison = null)
    {
        if ($sProducts instanceof \SProducts) {
            return $this
                ->addUsingAlias(SProductVariantsTableMap::COL_PRODUCT_ID, $sProducts->getId(), $comparison);
        } elseif ($sProducts instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(SProductVariantsTableMap::COL_PRODUCT_ID, $sProducts->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildSProductVariantsQuery The current query, for fluid interface
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
     * Filter the query by a related \SCurrencies object
     *
     * @param \SCurrencies|ObjectCollection $sCurrencies The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildSProductVariantsQuery The current query, for fluid interface
     */
    public function filterBySCurrencies($sCurrencies, $comparison = null)
    {
        if ($sCurrencies instanceof \SCurrencies) {
            return $this
                ->addUsingAlias(SProductVariantsTableMap::COL_CURRENCY, $sCurrencies->getId(), $comparison);
        } elseif ($sCurrencies instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(SProductVariantsTableMap::COL_CURRENCY, $sCurrencies->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterBySCurrencies() only accepts arguments of type \SCurrencies or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the SCurrencies relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSProductVariantsQuery The current query, for fluid interface
     */
    public function joinSCurrencies($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('SCurrencies');

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
            $this->addJoinObject($join, 'SCurrencies');
        }

        return $this;
    }

    /**
     * Use the SCurrencies relation SCurrencies object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \SCurrenciesQuery A secondary query class using the current class as primary query
     */
    public function useSCurrenciesQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinSCurrencies($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'SCurrencies', '\SCurrenciesQuery');
    }

    /**
     * Filter the query by a related \ShopKitProduct object
     *
     * @param \ShopKitProduct|ObjectCollection $shopKitProduct the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSProductVariantsQuery The current query, for fluid interface
     */
    public function filterByShopKitProduct($shopKitProduct, $comparison = null)
    {
        if ($shopKitProduct instanceof \ShopKitProduct) {
            return $this
                ->addUsingAlias(SProductVariantsTableMap::COL_PRODUCT_ID, $shopKitProduct->getProductId(), $comparison);
        } elseif ($shopKitProduct instanceof ObjectCollection) {
            return $this
                ->useShopKitProductQuery()
                ->filterByPrimaryKeys($shopKitProduct->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByShopKitProduct() only accepts arguments of type \ShopKitProduct or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ShopKitProduct relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSProductVariantsQuery The current query, for fluid interface
     */
    public function joinShopKitProduct($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ShopKitProduct');

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
            $this->addJoinObject($join, 'ShopKitProduct');
        }

        return $this;
    }

    /**
     * Use the ShopKitProduct relation ShopKitProduct object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ShopKitProductQuery A secondary query class using the current class as primary query
     */
    public function useShopKitProductQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinShopKitProduct($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ShopKitProduct', '\ShopKitProductQuery');
    }

    /**
     * Filter the query by a related \SProductVariantsI18n object
     *
     * @param \SProductVariantsI18n|ObjectCollection $sProductVariantsI18n the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSProductVariantsQuery The current query, for fluid interface
     */
    public function filterBySProductVariantsI18n($sProductVariantsI18n, $comparison = null)
    {
        if ($sProductVariantsI18n instanceof \SProductVariantsI18n) {
            return $this
                ->addUsingAlias(SProductVariantsTableMap::COL_ID, $sProductVariantsI18n->getId(), $comparison);
        } elseif ($sProductVariantsI18n instanceof ObjectCollection) {
            return $this
                ->useSProductVariantsI18nQuery()
                ->filterByPrimaryKeys($sProductVariantsI18n->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterBySProductVariantsI18n() only accepts arguments of type \SProductVariantsI18n or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the SProductVariantsI18n relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSProductVariantsQuery The current query, for fluid interface
     */
    public function joinSProductVariantsI18n($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('SProductVariantsI18n');

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
            $this->addJoinObject($join, 'SProductVariantsI18n');
        }

        return $this;
    }

    /**
     * Use the SProductVariantsI18n relation SProductVariantsI18n object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \SProductVariantsI18nQuery A secondary query class using the current class as primary query
     */
    public function useSProductVariantsI18nQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinSProductVariantsI18n($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'SProductVariantsI18n', '\SProductVariantsI18nQuery');
    }

    /**
     * Filter the query by a related \SNotifications object
     *
     * @param \SNotifications|ObjectCollection $sNotifications the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSProductVariantsQuery The current query, for fluid interface
     */
    public function filterBySNotifications($sNotifications, $comparison = null)
    {
        if ($sNotifications instanceof \SNotifications) {
            return $this
                ->addUsingAlias(SProductVariantsTableMap::COL_ID, $sNotifications->getVariantId(), $comparison);
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
     * @return $this|ChildSProductVariantsQuery The current query, for fluid interface
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
     * Filter the query by a related \SOrderProducts object
     *
     * @param \SOrderProducts|ObjectCollection $sOrderProducts the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSProductVariantsQuery The current query, for fluid interface
     */
    public function filterBySOrderProducts($sOrderProducts, $comparison = null)
    {
        if ($sOrderProducts instanceof \SOrderProducts) {
            return $this
                ->addUsingAlias(SProductVariantsTableMap::COL_ID, $sOrderProducts->getVariantId(), $comparison);
        } elseif ($sOrderProducts instanceof ObjectCollection) {
            return $this
                ->useSOrderProductsQuery()
                ->filterByPrimaryKeys($sOrderProducts->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterBySOrderProducts() only accepts arguments of type \SOrderProducts or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the SOrderProducts relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSProductVariantsQuery The current query, for fluid interface
     */
    public function joinSOrderProducts($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('SOrderProducts');

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
            $this->addJoinObject($join, 'SOrderProducts');
        }

        return $this;
    }

    /**
     * Use the SOrderProducts relation SOrderProducts object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \SOrderProductsQuery A secondary query class using the current class as primary query
     */
    public function useSOrderProductsQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinSOrderProducts($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'SOrderProducts', '\SOrderProductsQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildSProductVariants $sProductVariants Object to remove from the list of results
     *
     * @return $this|ChildSProductVariantsQuery The current query, for fluid interface
     */
    public function prune($sProductVariants = null)
    {
        if ($sProductVariants) {
            $this->addUsingAlias(SProductVariantsTableMap::COL_ID, $sProductVariants->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the shop_product_variants table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SProductVariantsTableMap::DATABASE_NAME);
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
            SProductVariantsTableMap::clearInstancePool();
            SProductVariantsTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(SProductVariantsTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(SProductVariantsTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            // cloning the Criteria in case it's modified by doSelect() or doSelectStmt()
            $c = clone $criteria;
            $affectedRows += $c->doOnDeleteCascade($con);

            SProductVariantsTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            SProductVariantsTableMap::clearRelatedInstancePool();

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
        $objects = ChildSProductVariantsQuery::create(null, $this)->find($con);
        foreach ($objects as $obj) {


            // delete related ShopKitProduct objects
            $query = new \ShopKitProductQuery;

            $query->add(ShopKitProductTableMap::COL_PRODUCT_ID, $obj->getProductId());
            $affectedRows += $query->delete($con);

            // delete related SProductVariantsI18n objects
            $query = new \SProductVariantsI18nQuery;

            $query->add(SProductVariantsI18nTableMap::COL_ID, $obj->getId());
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
     * @return    ChildSProductVariantsQuery The current query, for fluid interface
     */
    public function joinI18n($locale = 'ru', $relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $relationName = $relationAlias ? $relationAlias : 'SProductVariantsI18n';

        return $this
            ->joinSProductVariantsI18n($relationAlias, $joinType)
            ->addJoinCondition($relationName, $relationName . '.Locale = ?', $locale);
    }

    /**
     * Adds a JOIN clause to the query and hydrates the related I18n object.
     * Shortcut for $c->joinI18n($locale)->with()
     *
     * @param     string $locale Locale to use for the join condition, e.g. 'fr_FR'
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'. Defaults to left join.
     *
     * @return    $this|ChildSProductVariantsQuery The current query, for fluid interface
     */
    public function joinWithI18n($locale = 'ru', $joinType = Criteria::LEFT_JOIN)
    {
        $this
            ->joinI18n($locale, null, $joinType)
            ->with('SProductVariantsI18n');
        $this->with['SProductVariantsI18n']->setIsWithOneToMany(false);

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
     * @return    ChildSProductVariantsI18nQuery A secondary query class using the current class as primary query
     */
    public function useI18nQuery($locale = 'ru', $relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinI18n($locale, $relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'SProductVariantsI18n', '\SProductVariantsI18nQuery');
    }

} // SProductVariantsQuery
