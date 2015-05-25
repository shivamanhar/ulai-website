<?php

namespace Base;

use \SProducts as ChildSProducts;
use \SProductsI18nQuery as ChildSProductsI18nQuery;
use \SProductsQuery as ChildSProductsQuery;
use \Exception;
use \PDO;
use Map\SProductImagesTableMap;
use Map\SProductPropertiesDataTableMap;
use Map\SProductVariantsTableMap;
use Map\SProductsI18nTableMap;
use Map\SProductsTableMap;
use Map\SWarehouseDataTableMap;
use Map\ShopKitProductTableMap;
use Map\ShopKitTableMap;
use Map\ShopProductCategoriesTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'shop_products' table.
 *
 *
 *
 * @method     ChildSProductsQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildSProductsQuery orderByUserId($order = Criteria::ASC) Order by the user_id column
 * @method     ChildSProductsQuery orderByExternalId($order = Criteria::ASC) Order by the external_id column
 * @method     ChildSProductsQuery orderByUrl($order = Criteria::ASC) Order by the url column
 * @method     ChildSProductsQuery orderByActive($order = Criteria::ASC) Order by the active column
 * @method     ChildSProductsQuery orderByHit($order = Criteria::ASC) Order by the hit column
 * @method     ChildSProductsQuery orderByHot($order = Criteria::ASC) Order by the hot column
 * @method     ChildSProductsQuery orderByAction($order = Criteria::ASC) Order by the action column
 * @method     ChildSProductsQuery orderByBrandId($order = Criteria::ASC) Order by the brand_id column
 * @method     ChildSProductsQuery orderByCategoryId($order = Criteria::ASC) Order by the category_id column
 * @method     ChildSProductsQuery orderByRelatedProducts($order = Criteria::ASC) Order by the related_products column
 * @method     ChildSProductsQuery orderByOldPrice($order = Criteria::ASC) Order by the old_price column
 * @method     ChildSProductsQuery orderByCreated($order = Criteria::ASC) Order by the created column
 * @method     ChildSProductsQuery orderByUpdated($order = Criteria::ASC) Order by the updated column
 * @method     ChildSProductsQuery orderByViews($order = Criteria::ASC) Order by the views column
 * @method     ChildSProductsQuery orderByAddedToCartCount($order = Criteria::ASC) Order by the added_to_cart_count column
 * @method     ChildSProductsQuery orderByEnableComments($order = Criteria::ASC) Order by the enable_comments column
 * @method     ChildSProductsQuery orderByTpl($order = Criteria::ASC) Order by the tpl column
 *
 * @method     ChildSProductsQuery groupById() Group by the id column
 * @method     ChildSProductsQuery groupByUserId() Group by the user_id column
 * @method     ChildSProductsQuery groupByExternalId() Group by the external_id column
 * @method     ChildSProductsQuery groupByUrl() Group by the url column
 * @method     ChildSProductsQuery groupByActive() Group by the active column
 * @method     ChildSProductsQuery groupByHit() Group by the hit column
 * @method     ChildSProductsQuery groupByHot() Group by the hot column
 * @method     ChildSProductsQuery groupByAction() Group by the action column
 * @method     ChildSProductsQuery groupByBrandId() Group by the brand_id column
 * @method     ChildSProductsQuery groupByCategoryId() Group by the category_id column
 * @method     ChildSProductsQuery groupByRelatedProducts() Group by the related_products column
 * @method     ChildSProductsQuery groupByOldPrice() Group by the old_price column
 * @method     ChildSProductsQuery groupByCreated() Group by the created column
 * @method     ChildSProductsQuery groupByUpdated() Group by the updated column
 * @method     ChildSProductsQuery groupByViews() Group by the views column
 * @method     ChildSProductsQuery groupByAddedToCartCount() Group by the added_to_cart_count column
 * @method     ChildSProductsQuery groupByEnableComments() Group by the enable_comments column
 * @method     ChildSProductsQuery groupByTpl() Group by the tpl column
 *
 * @method     ChildSProductsQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildSProductsQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildSProductsQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildSProductsQuery leftJoinBrand($relationAlias = null) Adds a LEFT JOIN clause to the query using the Brand relation
 * @method     ChildSProductsQuery rightJoinBrand($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Brand relation
 * @method     ChildSProductsQuery innerJoinBrand($relationAlias = null) Adds a INNER JOIN clause to the query using the Brand relation
 *
 * @method     ChildSProductsQuery leftJoinMainCategory($relationAlias = null) Adds a LEFT JOIN clause to the query using the MainCategory relation
 * @method     ChildSProductsQuery rightJoinMainCategory($relationAlias = null) Adds a RIGHT JOIN clause to the query using the MainCategory relation
 * @method     ChildSProductsQuery innerJoinMainCategory($relationAlias = null) Adds a INNER JOIN clause to the query using the MainCategory relation
 *
 * @method     ChildSProductsQuery leftJoinShopKit($relationAlias = null) Adds a LEFT JOIN clause to the query using the ShopKit relation
 * @method     ChildSProductsQuery rightJoinShopKit($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ShopKit relation
 * @method     ChildSProductsQuery innerJoinShopKit($relationAlias = null) Adds a INNER JOIN clause to the query using the ShopKit relation
 *
 * @method     ChildSProductsQuery leftJoinShopKitProduct($relationAlias = null) Adds a LEFT JOIN clause to the query using the ShopKitProduct relation
 * @method     ChildSProductsQuery rightJoinShopKitProduct($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ShopKitProduct relation
 * @method     ChildSProductsQuery innerJoinShopKitProduct($relationAlias = null) Adds a INNER JOIN clause to the query using the ShopKitProduct relation
 *
 * @method     ChildSProductsQuery leftJoinSProductsI18n($relationAlias = null) Adds a LEFT JOIN clause to the query using the SProductsI18n relation
 * @method     ChildSProductsQuery rightJoinSProductsI18n($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SProductsI18n relation
 * @method     ChildSProductsQuery innerJoinSProductsI18n($relationAlias = null) Adds a INNER JOIN clause to the query using the SProductsI18n relation
 *
 * @method     ChildSProductsQuery leftJoinSProductImages($relationAlias = null) Adds a LEFT JOIN clause to the query using the SProductImages relation
 * @method     ChildSProductsQuery rightJoinSProductImages($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SProductImages relation
 * @method     ChildSProductsQuery innerJoinSProductImages($relationAlias = null) Adds a INNER JOIN clause to the query using the SProductImages relation
 *
 * @method     ChildSProductsQuery leftJoinProductVariant($relationAlias = null) Adds a LEFT JOIN clause to the query using the ProductVariant relation
 * @method     ChildSProductsQuery rightJoinProductVariant($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ProductVariant relation
 * @method     ChildSProductsQuery innerJoinProductVariant($relationAlias = null) Adds a INNER JOIN clause to the query using the ProductVariant relation
 *
 * @method     ChildSProductsQuery leftJoinSWarehouseData($relationAlias = null) Adds a LEFT JOIN clause to the query using the SWarehouseData relation
 * @method     ChildSProductsQuery rightJoinSWarehouseData($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SWarehouseData relation
 * @method     ChildSProductsQuery innerJoinSWarehouseData($relationAlias = null) Adds a INNER JOIN clause to the query using the SWarehouseData relation
 *
 * @method     ChildSProductsQuery leftJoinShopProductCategories($relationAlias = null) Adds a LEFT JOIN clause to the query using the ShopProductCategories relation
 * @method     ChildSProductsQuery rightJoinShopProductCategories($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ShopProductCategories relation
 * @method     ChildSProductsQuery innerJoinShopProductCategories($relationAlias = null) Adds a INNER JOIN clause to the query using the ShopProductCategories relation
 *
 * @method     ChildSProductsQuery leftJoinSProductPropertiesData($relationAlias = null) Adds a LEFT JOIN clause to the query using the SProductPropertiesData relation
 * @method     ChildSProductsQuery rightJoinSProductPropertiesData($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SProductPropertiesData relation
 * @method     ChildSProductsQuery innerJoinSProductPropertiesData($relationAlias = null) Adds a INNER JOIN clause to the query using the SProductPropertiesData relation
 *
 * @method     ChildSProductsQuery leftJoinSNotifications($relationAlias = null) Adds a LEFT JOIN clause to the query using the SNotifications relation
 * @method     ChildSProductsQuery rightJoinSNotifications($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SNotifications relation
 * @method     ChildSProductsQuery innerJoinSNotifications($relationAlias = null) Adds a INNER JOIN clause to the query using the SNotifications relation
 *
 * @method     ChildSProductsQuery leftJoinSOrderProducts($relationAlias = null) Adds a LEFT JOIN clause to the query using the SOrderProducts relation
 * @method     ChildSProductsQuery rightJoinSOrderProducts($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SOrderProducts relation
 * @method     ChildSProductsQuery innerJoinSOrderProducts($relationAlias = null) Adds a INNER JOIN clause to the query using the SOrderProducts relation
 *
 * @method     ChildSProductsQuery leftJoinSProductsRating($relationAlias = null) Adds a LEFT JOIN clause to the query using the SProductsRating relation
 * @method     ChildSProductsQuery rightJoinSProductsRating($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SProductsRating relation
 * @method     ChildSProductsQuery innerJoinSProductsRating($relationAlias = null) Adds a INNER JOIN clause to the query using the SProductsRating relation
 *
 * @method     \SBrandsQuery|\SCategoryQuery|\ShopKitQuery|\ShopKitProductQuery|\SProductsI18nQuery|\SProductImagesQuery|\SProductVariantsQuery|\SWarehouseDataQuery|\ShopProductCategoriesQuery|\SProductPropertiesDataQuery|\SNotificationsQuery|\SOrderProductsQuery|\SProductsRatingQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildSProducts findOne(ConnectionInterface $con = null) Return the first ChildSProducts matching the query
 * @method     ChildSProducts findOneOrCreate(ConnectionInterface $con = null) Return the first ChildSProducts matching the query, or a new ChildSProducts object populated from the query conditions when no match is found
 *
 * @method     ChildSProducts findOneById(int $id) Return the first ChildSProducts filtered by the id column
 * @method     ChildSProducts findOneByUserId(int $user_id) Return the first ChildSProducts filtered by the user_id column
 * @method     ChildSProducts findOneByExternalId(string $external_id) Return the first ChildSProducts filtered by the external_id column
 * @method     ChildSProducts findOneByUrl(string $url) Return the first ChildSProducts filtered by the url column
 * @method     ChildSProducts findOneByActive(boolean $active) Return the first ChildSProducts filtered by the active column
 * @method     ChildSProducts findOneByHit(boolean $hit) Return the first ChildSProducts filtered by the hit column
 * @method     ChildSProducts findOneByHot(boolean $hot) Return the first ChildSProducts filtered by the hot column
 * @method     ChildSProducts findOneByAction(boolean $action) Return the first ChildSProducts filtered by the action column
 * @method     ChildSProducts findOneByBrandId(int $brand_id) Return the first ChildSProducts filtered by the brand_id column
 * @method     ChildSProducts findOneByCategoryId(int $category_id) Return the first ChildSProducts filtered by the category_id column
 * @method     ChildSProducts findOneByRelatedProducts(string $related_products) Return the first ChildSProducts filtered by the related_products column
 * @method     ChildSProducts findOneByOldPrice(string $old_price) Return the first ChildSProducts filtered by the old_price column
 * @method     ChildSProducts findOneByCreated(int $created) Return the first ChildSProducts filtered by the created column
 * @method     ChildSProducts findOneByUpdated(int $updated) Return the first ChildSProducts filtered by the updated column
 * @method     ChildSProducts findOneByViews(int $views) Return the first ChildSProducts filtered by the views column
 * @method     ChildSProducts findOneByAddedToCartCount(int $added_to_cart_count) Return the first ChildSProducts filtered by the added_to_cart_count column
 * @method     ChildSProducts findOneByEnableComments(boolean $enable_comments) Return the first ChildSProducts filtered by the enable_comments column
 * @method     ChildSProducts findOneByTpl(string $tpl) Return the first ChildSProducts filtered by the tpl column *

 * @method     ChildSProducts requirePk($key, ConnectionInterface $con = null) Return the ChildSProducts by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSProducts requireOne(ConnectionInterface $con = null) Return the first ChildSProducts matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSProducts requireOneById(int $id) Return the first ChildSProducts filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSProducts requireOneByUserId(int $user_id) Return the first ChildSProducts filtered by the user_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSProducts requireOneByExternalId(string $external_id) Return the first ChildSProducts filtered by the external_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSProducts requireOneByUrl(string $url) Return the first ChildSProducts filtered by the url column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSProducts requireOneByActive(boolean $active) Return the first ChildSProducts filtered by the active column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSProducts requireOneByHit(boolean $hit) Return the first ChildSProducts filtered by the hit column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSProducts requireOneByHot(boolean $hot) Return the first ChildSProducts filtered by the hot column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSProducts requireOneByAction(boolean $action) Return the first ChildSProducts filtered by the action column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSProducts requireOneByBrandId(int $brand_id) Return the first ChildSProducts filtered by the brand_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSProducts requireOneByCategoryId(int $category_id) Return the first ChildSProducts filtered by the category_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSProducts requireOneByRelatedProducts(string $related_products) Return the first ChildSProducts filtered by the related_products column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSProducts requireOneByOldPrice(string $old_price) Return the first ChildSProducts filtered by the old_price column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSProducts requireOneByCreated(int $created) Return the first ChildSProducts filtered by the created column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSProducts requireOneByUpdated(int $updated) Return the first ChildSProducts filtered by the updated column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSProducts requireOneByViews(int $views) Return the first ChildSProducts filtered by the views column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSProducts requireOneByAddedToCartCount(int $added_to_cart_count) Return the first ChildSProducts filtered by the added_to_cart_count column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSProducts requireOneByEnableComments(boolean $enable_comments) Return the first ChildSProducts filtered by the enable_comments column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSProducts requireOneByTpl(string $tpl) Return the first ChildSProducts filtered by the tpl column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSProducts[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildSProducts objects based on current ModelCriteria
 * @method     ChildSProducts[]|ObjectCollection findById(int $id) Return ChildSProducts objects filtered by the id column
 * @method     ChildSProducts[]|ObjectCollection findByUserId(int $user_id) Return ChildSProducts objects filtered by the user_id column
 * @method     ChildSProducts[]|ObjectCollection findByExternalId(string $external_id) Return ChildSProducts objects filtered by the external_id column
 * @method     ChildSProducts[]|ObjectCollection findByUrl(string $url) Return ChildSProducts objects filtered by the url column
 * @method     ChildSProducts[]|ObjectCollection findByActive(boolean $active) Return ChildSProducts objects filtered by the active column
 * @method     ChildSProducts[]|ObjectCollection findByHit(boolean $hit) Return ChildSProducts objects filtered by the hit column
 * @method     ChildSProducts[]|ObjectCollection findByHot(boolean $hot) Return ChildSProducts objects filtered by the hot column
 * @method     ChildSProducts[]|ObjectCollection findByAction(boolean $action) Return ChildSProducts objects filtered by the action column
 * @method     ChildSProducts[]|ObjectCollection findByBrandId(int $brand_id) Return ChildSProducts objects filtered by the brand_id column
 * @method     ChildSProducts[]|ObjectCollection findByCategoryId(int $category_id) Return ChildSProducts objects filtered by the category_id column
 * @method     ChildSProducts[]|ObjectCollection findByRelatedProducts(string $related_products) Return ChildSProducts objects filtered by the related_products column
 * @method     ChildSProducts[]|ObjectCollection findByOldPrice(string $old_price) Return ChildSProducts objects filtered by the old_price column
 * @method     ChildSProducts[]|ObjectCollection findByCreated(int $created) Return ChildSProducts objects filtered by the created column
 * @method     ChildSProducts[]|ObjectCollection findByUpdated(int $updated) Return ChildSProducts objects filtered by the updated column
 * @method     ChildSProducts[]|ObjectCollection findByViews(int $views) Return ChildSProducts objects filtered by the views column
 * @method     ChildSProducts[]|ObjectCollection findByAddedToCartCount(int $added_to_cart_count) Return ChildSProducts objects filtered by the added_to_cart_count column
 * @method     ChildSProducts[]|ObjectCollection findByEnableComments(boolean $enable_comments) Return ChildSProducts objects filtered by the enable_comments column
 * @method     ChildSProducts[]|ObjectCollection findByTpl(string $tpl) Return ChildSProducts objects filtered by the tpl column
 * @method     ChildSProducts[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class SProductsQuery extends ModelCriteria
{

    // query_cache behavior
    protected $queryKey = '';
    protected static $cacheBackend;
                protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\SProductsQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'Shop', $modelName = '\\SProducts', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildSProductsQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildSProductsQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildSProductsQuery) {
            return $criteria;
        }
        $query = new ChildSProductsQuery();
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
     * @return ChildSProducts|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = SProductsTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(SProductsTableMap::DATABASE_NAME);
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
     * @return ChildSProducts A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, user_id, external_id, url, active, hit, hot, action, brand_id, category_id, related_products, old_price, created, updated, views, added_to_cart_count, enable_comments, tpl FROM shop_products WHERE id = :p0';
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
            /** @var ChildSProducts $obj */
            $obj = new ChildSProducts();
            $obj->hydrate($row);
            SProductsTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildSProducts|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildSProductsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(SProductsTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildSProductsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(SProductsTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildSProductsQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(SProductsTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(SProductsTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SProductsTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildSProductsQuery The current query, for fluid interface
     */
    public function filterByUserId($userId = null, $comparison = null)
    {
        if (is_array($userId)) {
            $useMinMax = false;
            if (isset($userId['min'])) {
                $this->addUsingAlias(SProductsTableMap::COL_USER_ID, $userId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($userId['max'])) {
                $this->addUsingAlias(SProductsTableMap::COL_USER_ID, $userId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SProductsTableMap::COL_USER_ID, $userId, $comparison);
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
     * @return $this|ChildSProductsQuery The current query, for fluid interface
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

        return $this->addUsingAlias(SProductsTableMap::COL_EXTERNAL_ID, $externalId, $comparison);
    }

    /**
     * Filter the query on the url column
     *
     * Example usage:
     * <code>
     * $query->filterByUrl('fooValue');   // WHERE url = 'fooValue'
     * $query->filterByUrl('%fooValue%'); // WHERE url LIKE '%fooValue%'
     * </code>
     *
     * @param     string $url The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSProductsQuery The current query, for fluid interface
     */
    public function filterByUrl($url = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($url)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $url)) {
                $url = str_replace('*', '%', $url);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SProductsTableMap::COL_URL, $url, $comparison);
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
     * @return $this|ChildSProductsQuery The current query, for fluid interface
     */
    public function filterByActive($active = null, $comparison = null)
    {
        if (is_string($active)) {
            $active = in_array(strtolower($active), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(SProductsTableMap::COL_ACTIVE, $active, $comparison);
    }

    /**
     * Filter the query on the hit column
     *
     * Example usage:
     * <code>
     * $query->filterByHit(true); // WHERE hit = true
     * $query->filterByHit('yes'); // WHERE hit = true
     * </code>
     *
     * @param     boolean|string $hit The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSProductsQuery The current query, for fluid interface
     */
    public function filterByHit($hit = null, $comparison = null)
    {
        if (is_string($hit)) {
            $hit = in_array(strtolower($hit), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(SProductsTableMap::COL_HIT, $hit, $comparison);
    }

    /**
     * Filter the query on the hot column
     *
     * Example usage:
     * <code>
     * $query->filterByHot(true); // WHERE hot = true
     * $query->filterByHot('yes'); // WHERE hot = true
     * </code>
     *
     * @param     boolean|string $hot The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSProductsQuery The current query, for fluid interface
     */
    public function filterByHot($hot = null, $comparison = null)
    {
        if (is_string($hot)) {
            $hot = in_array(strtolower($hot), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(SProductsTableMap::COL_HOT, $hot, $comparison);
    }

    /**
     * Filter the query on the action column
     *
     * Example usage:
     * <code>
     * $query->filterByAction(true); // WHERE action = true
     * $query->filterByAction('yes'); // WHERE action = true
     * </code>
     *
     * @param     boolean|string $action The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSProductsQuery The current query, for fluid interface
     */
    public function filterByAction($action = null, $comparison = null)
    {
        if (is_string($action)) {
            $action = in_array(strtolower($action), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(SProductsTableMap::COL_ACTION, $action, $comparison);
    }

    /**
     * Filter the query on the brand_id column
     *
     * Example usage:
     * <code>
     * $query->filterByBrandId(1234); // WHERE brand_id = 1234
     * $query->filterByBrandId(array(12, 34)); // WHERE brand_id IN (12, 34)
     * $query->filterByBrandId(array('min' => 12)); // WHERE brand_id > 12
     * </code>
     *
     * @see       filterByBrand()
     *
     * @param     mixed $brandId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSProductsQuery The current query, for fluid interface
     */
    public function filterByBrandId($brandId = null, $comparison = null)
    {
        if (is_array($brandId)) {
            $useMinMax = false;
            if (isset($brandId['min'])) {
                $this->addUsingAlias(SProductsTableMap::COL_BRAND_ID, $brandId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($brandId['max'])) {
                $this->addUsingAlias(SProductsTableMap::COL_BRAND_ID, $brandId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SProductsTableMap::COL_BRAND_ID, $brandId, $comparison);
    }

    /**
     * Filter the query on the category_id column
     *
     * Example usage:
     * <code>
     * $query->filterByCategoryId(1234); // WHERE category_id = 1234
     * $query->filterByCategoryId(array(12, 34)); // WHERE category_id IN (12, 34)
     * $query->filterByCategoryId(array('min' => 12)); // WHERE category_id > 12
     * </code>
     *
     * @see       filterByMainCategory()
     *
     * @param     mixed $categoryId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSProductsQuery The current query, for fluid interface
     */
    public function filterByCategoryId($categoryId = null, $comparison = null)
    {
        if (is_array($categoryId)) {
            $useMinMax = false;
            if (isset($categoryId['min'])) {
                $this->addUsingAlias(SProductsTableMap::COL_CATEGORY_ID, $categoryId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($categoryId['max'])) {
                $this->addUsingAlias(SProductsTableMap::COL_CATEGORY_ID, $categoryId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SProductsTableMap::COL_CATEGORY_ID, $categoryId, $comparison);
    }

    /**
     * Filter the query on the related_products column
     *
     * Example usage:
     * <code>
     * $query->filterByRelatedProducts('fooValue');   // WHERE related_products = 'fooValue'
     * $query->filterByRelatedProducts('%fooValue%'); // WHERE related_products LIKE '%fooValue%'
     * </code>
     *
     * @param     string $relatedProducts The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSProductsQuery The current query, for fluid interface
     */
    public function filterByRelatedProducts($relatedProducts = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($relatedProducts)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $relatedProducts)) {
                $relatedProducts = str_replace('*', '%', $relatedProducts);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SProductsTableMap::COL_RELATED_PRODUCTS, $relatedProducts, $comparison);
    }

    /**
     * Filter the query on the old_price column
     *
     * Example usage:
     * <code>
     * $query->filterByOldPrice(1234); // WHERE old_price = 1234
     * $query->filterByOldPrice(array(12, 34)); // WHERE old_price IN (12, 34)
     * $query->filterByOldPrice(array('min' => 12)); // WHERE old_price > 12
     * </code>
     *
     * @param     mixed $oldPrice The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSProductsQuery The current query, for fluid interface
     */
    public function filterByOldPrice($oldPrice = null, $comparison = null)
    {
        if (is_array($oldPrice)) {
            $useMinMax = false;
            if (isset($oldPrice['min'])) {
                $this->addUsingAlias(SProductsTableMap::COL_OLD_PRICE, $oldPrice['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($oldPrice['max'])) {
                $this->addUsingAlias(SProductsTableMap::COL_OLD_PRICE, $oldPrice['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SProductsTableMap::COL_OLD_PRICE, $oldPrice, $comparison);
    }

    /**
     * Filter the query on the created column
     *
     * Example usage:
     * <code>
     * $query->filterByCreated(1234); // WHERE created = 1234
     * $query->filterByCreated(array(12, 34)); // WHERE created IN (12, 34)
     * $query->filterByCreated(array('min' => 12)); // WHERE created > 12
     * </code>
     *
     * @param     mixed $created The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSProductsQuery The current query, for fluid interface
     */
    public function filterByCreated($created = null, $comparison = null)
    {
        if (is_array($created)) {
            $useMinMax = false;
            if (isset($created['min'])) {
                $this->addUsingAlias(SProductsTableMap::COL_CREATED, $created['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($created['max'])) {
                $this->addUsingAlias(SProductsTableMap::COL_CREATED, $created['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SProductsTableMap::COL_CREATED, $created, $comparison);
    }

    /**
     * Filter the query on the updated column
     *
     * Example usage:
     * <code>
     * $query->filterByUpdated(1234); // WHERE updated = 1234
     * $query->filterByUpdated(array(12, 34)); // WHERE updated IN (12, 34)
     * $query->filterByUpdated(array('min' => 12)); // WHERE updated > 12
     * </code>
     *
     * @param     mixed $updated The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSProductsQuery The current query, for fluid interface
     */
    public function filterByUpdated($updated = null, $comparison = null)
    {
        if (is_array($updated)) {
            $useMinMax = false;
            if (isset($updated['min'])) {
                $this->addUsingAlias(SProductsTableMap::COL_UPDATED, $updated['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updated['max'])) {
                $this->addUsingAlias(SProductsTableMap::COL_UPDATED, $updated['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SProductsTableMap::COL_UPDATED, $updated, $comparison);
    }

    /**
     * Filter the query on the views column
     *
     * Example usage:
     * <code>
     * $query->filterByViews(1234); // WHERE views = 1234
     * $query->filterByViews(array(12, 34)); // WHERE views IN (12, 34)
     * $query->filterByViews(array('min' => 12)); // WHERE views > 12
     * </code>
     *
     * @param     mixed $views The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSProductsQuery The current query, for fluid interface
     */
    public function filterByViews($views = null, $comparison = null)
    {
        if (is_array($views)) {
            $useMinMax = false;
            if (isset($views['min'])) {
                $this->addUsingAlias(SProductsTableMap::COL_VIEWS, $views['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($views['max'])) {
                $this->addUsingAlias(SProductsTableMap::COL_VIEWS, $views['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SProductsTableMap::COL_VIEWS, $views, $comparison);
    }

    /**
     * Filter the query on the added_to_cart_count column
     *
     * Example usage:
     * <code>
     * $query->filterByAddedToCartCount(1234); // WHERE added_to_cart_count = 1234
     * $query->filterByAddedToCartCount(array(12, 34)); // WHERE added_to_cart_count IN (12, 34)
     * $query->filterByAddedToCartCount(array('min' => 12)); // WHERE added_to_cart_count > 12
     * </code>
     *
     * @param     mixed $addedToCartCount The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSProductsQuery The current query, for fluid interface
     */
    public function filterByAddedToCartCount($addedToCartCount = null, $comparison = null)
    {
        if (is_array($addedToCartCount)) {
            $useMinMax = false;
            if (isset($addedToCartCount['min'])) {
                $this->addUsingAlias(SProductsTableMap::COL_ADDED_TO_CART_COUNT, $addedToCartCount['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($addedToCartCount['max'])) {
                $this->addUsingAlias(SProductsTableMap::COL_ADDED_TO_CART_COUNT, $addedToCartCount['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SProductsTableMap::COL_ADDED_TO_CART_COUNT, $addedToCartCount, $comparison);
    }

    /**
     * Filter the query on the enable_comments column
     *
     * Example usage:
     * <code>
     * $query->filterByEnableComments(true); // WHERE enable_comments = true
     * $query->filterByEnableComments('yes'); // WHERE enable_comments = true
     * </code>
     *
     * @param     boolean|string $enableComments The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSProductsQuery The current query, for fluid interface
     */
    public function filterByEnableComments($enableComments = null, $comparison = null)
    {
        if (is_string($enableComments)) {
            $enableComments = in_array(strtolower($enableComments), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(SProductsTableMap::COL_ENABLE_COMMENTS, $enableComments, $comparison);
    }

    /**
     * Filter the query on the tpl column
     *
     * Example usage:
     * <code>
     * $query->filterByTpl('fooValue');   // WHERE tpl = 'fooValue'
     * $query->filterByTpl('%fooValue%'); // WHERE tpl LIKE '%fooValue%'
     * </code>
     *
     * @param     string $tpl The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSProductsQuery The current query, for fluid interface
     */
    public function filterByTpl($tpl = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($tpl)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $tpl)) {
                $tpl = str_replace('*', '%', $tpl);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SProductsTableMap::COL_TPL, $tpl, $comparison);
    }

    /**
     * Filter the query by a related \SBrands object
     *
     * @param \SBrands|ObjectCollection $sBrands The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildSProductsQuery The current query, for fluid interface
     */
    public function filterByBrand($sBrands, $comparison = null)
    {
        if ($sBrands instanceof \SBrands) {
            return $this
                ->addUsingAlias(SProductsTableMap::COL_BRAND_ID, $sBrands->getId(), $comparison);
        } elseif ($sBrands instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(SProductsTableMap::COL_BRAND_ID, $sBrands->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByBrand() only accepts arguments of type \SBrands or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Brand relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSProductsQuery The current query, for fluid interface
     */
    public function joinBrand($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Brand');

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
            $this->addJoinObject($join, 'Brand');
        }

        return $this;
    }

    /**
     * Use the Brand relation SBrands object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \SBrandsQuery A secondary query class using the current class as primary query
     */
    public function useBrandQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinBrand($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Brand', '\SBrandsQuery');
    }

    /**
     * Filter the query by a related \SCategory object
     *
     * @param \SCategory|ObjectCollection $sCategory The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildSProductsQuery The current query, for fluid interface
     */
    public function filterByMainCategory($sCategory, $comparison = null)
    {
        if ($sCategory instanceof \SCategory) {
            return $this
                ->addUsingAlias(SProductsTableMap::COL_CATEGORY_ID, $sCategory->getId(), $comparison);
        } elseif ($sCategory instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(SProductsTableMap::COL_CATEGORY_ID, $sCategory->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByMainCategory() only accepts arguments of type \SCategory or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the MainCategory relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSProductsQuery The current query, for fluid interface
     */
    public function joinMainCategory($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('MainCategory');

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
            $this->addJoinObject($join, 'MainCategory');
        }

        return $this;
    }

    /**
     * Use the MainCategory relation SCategory object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \SCategoryQuery A secondary query class using the current class as primary query
     */
    public function useMainCategoryQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinMainCategory($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'MainCategory', '\SCategoryQuery');
    }

    /**
     * Filter the query by a related \ShopKit object
     *
     * @param \ShopKit|ObjectCollection $shopKit the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSProductsQuery The current query, for fluid interface
     */
    public function filterByShopKit($shopKit, $comparison = null)
    {
        if ($shopKit instanceof \ShopKit) {
            return $this
                ->addUsingAlias(SProductsTableMap::COL_ID, $shopKit->getProductId(), $comparison);
        } elseif ($shopKit instanceof ObjectCollection) {
            return $this
                ->useShopKitQuery()
                ->filterByPrimaryKeys($shopKit->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByShopKit() only accepts arguments of type \ShopKit or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ShopKit relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSProductsQuery The current query, for fluid interface
     */
    public function joinShopKit($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ShopKit');

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
            $this->addJoinObject($join, 'ShopKit');
        }

        return $this;
    }

    /**
     * Use the ShopKit relation ShopKit object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ShopKitQuery A secondary query class using the current class as primary query
     */
    public function useShopKitQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinShopKit($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ShopKit', '\ShopKitQuery');
    }

    /**
     * Filter the query by a related \ShopKitProduct object
     *
     * @param \ShopKitProduct|ObjectCollection $shopKitProduct the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSProductsQuery The current query, for fluid interface
     */
    public function filterByShopKitProduct($shopKitProduct, $comparison = null)
    {
        if ($shopKitProduct instanceof \ShopKitProduct) {
            return $this
                ->addUsingAlias(SProductsTableMap::COL_ID, $shopKitProduct->getProductId(), $comparison);
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
     * @return $this|ChildSProductsQuery The current query, for fluid interface
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
     * Filter the query by a related \SProductsI18n object
     *
     * @param \SProductsI18n|ObjectCollection $sProductsI18n the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSProductsQuery The current query, for fluid interface
     */
    public function filterBySProductsI18n($sProductsI18n, $comparison = null)
    {
        if ($sProductsI18n instanceof \SProductsI18n) {
            return $this
                ->addUsingAlias(SProductsTableMap::COL_ID, $sProductsI18n->getId(), $comparison);
        } elseif ($sProductsI18n instanceof ObjectCollection) {
            return $this
                ->useSProductsI18nQuery()
                ->filterByPrimaryKeys($sProductsI18n->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterBySProductsI18n() only accepts arguments of type \SProductsI18n or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the SProductsI18n relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSProductsQuery The current query, for fluid interface
     */
    public function joinSProductsI18n($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('SProductsI18n');

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
            $this->addJoinObject($join, 'SProductsI18n');
        }

        return $this;
    }

    /**
     * Use the SProductsI18n relation SProductsI18n object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \SProductsI18nQuery A secondary query class using the current class as primary query
     */
    public function useSProductsI18nQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinSProductsI18n($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'SProductsI18n', '\SProductsI18nQuery');
    }

    /**
     * Filter the query by a related \SProductImages object
     *
     * @param \SProductImages|ObjectCollection $sProductImages the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSProductsQuery The current query, for fluid interface
     */
    public function filterBySProductImages($sProductImages, $comparison = null)
    {
        if ($sProductImages instanceof \SProductImages) {
            return $this
                ->addUsingAlias(SProductsTableMap::COL_ID, $sProductImages->getProductId(), $comparison);
        } elseif ($sProductImages instanceof ObjectCollection) {
            return $this
                ->useSProductImagesQuery()
                ->filterByPrimaryKeys($sProductImages->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterBySProductImages() only accepts arguments of type \SProductImages or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the SProductImages relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSProductsQuery The current query, for fluid interface
     */
    public function joinSProductImages($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('SProductImages');

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
            $this->addJoinObject($join, 'SProductImages');
        }

        return $this;
    }

    /**
     * Use the SProductImages relation SProductImages object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \SProductImagesQuery A secondary query class using the current class as primary query
     */
    public function useSProductImagesQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinSProductImages($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'SProductImages', '\SProductImagesQuery');
    }

    /**
     * Filter the query by a related \SProductVariants object
     *
     * @param \SProductVariants|ObjectCollection $sProductVariants the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSProductsQuery The current query, for fluid interface
     */
    public function filterByProductVariant($sProductVariants, $comparison = null)
    {
        if ($sProductVariants instanceof \SProductVariants) {
            return $this
                ->addUsingAlias(SProductsTableMap::COL_ID, $sProductVariants->getProductId(), $comparison);
        } elseif ($sProductVariants instanceof ObjectCollection) {
            return $this
                ->useProductVariantQuery()
                ->filterByPrimaryKeys($sProductVariants->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByProductVariant() only accepts arguments of type \SProductVariants or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ProductVariant relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSProductsQuery The current query, for fluid interface
     */
    public function joinProductVariant($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ProductVariant');

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
            $this->addJoinObject($join, 'ProductVariant');
        }

        return $this;
    }

    /**
     * Use the ProductVariant relation SProductVariants object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \SProductVariantsQuery A secondary query class using the current class as primary query
     */
    public function useProductVariantQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinProductVariant($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ProductVariant', '\SProductVariantsQuery');
    }

    /**
     * Filter the query by a related \SWarehouseData object
     *
     * @param \SWarehouseData|ObjectCollection $sWarehouseData the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSProductsQuery The current query, for fluid interface
     */
    public function filterBySWarehouseData($sWarehouseData, $comparison = null)
    {
        if ($sWarehouseData instanceof \SWarehouseData) {
            return $this
                ->addUsingAlias(SProductsTableMap::COL_ID, $sWarehouseData->getProductId(), $comparison);
        } elseif ($sWarehouseData instanceof ObjectCollection) {
            return $this
                ->useSWarehouseDataQuery()
                ->filterByPrimaryKeys($sWarehouseData->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterBySWarehouseData() only accepts arguments of type \SWarehouseData or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the SWarehouseData relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSProductsQuery The current query, for fluid interface
     */
    public function joinSWarehouseData($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('SWarehouseData');

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
            $this->addJoinObject($join, 'SWarehouseData');
        }

        return $this;
    }

    /**
     * Use the SWarehouseData relation SWarehouseData object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \SWarehouseDataQuery A secondary query class using the current class as primary query
     */
    public function useSWarehouseDataQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinSWarehouseData($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'SWarehouseData', '\SWarehouseDataQuery');
    }

    /**
     * Filter the query by a related \ShopProductCategories object
     *
     * @param \ShopProductCategories|ObjectCollection $shopProductCategories the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSProductsQuery The current query, for fluid interface
     */
    public function filterByShopProductCategories($shopProductCategories, $comparison = null)
    {
        if ($shopProductCategories instanceof \ShopProductCategories) {
            return $this
                ->addUsingAlias(SProductsTableMap::COL_ID, $shopProductCategories->getProductId(), $comparison);
        } elseif ($shopProductCategories instanceof ObjectCollection) {
            return $this
                ->useShopProductCategoriesQuery()
                ->filterByPrimaryKeys($shopProductCategories->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByShopProductCategories() only accepts arguments of type \ShopProductCategories or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ShopProductCategories relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSProductsQuery The current query, for fluid interface
     */
    public function joinShopProductCategories($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ShopProductCategories');

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
            $this->addJoinObject($join, 'ShopProductCategories');
        }

        return $this;
    }

    /**
     * Use the ShopProductCategories relation ShopProductCategories object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ShopProductCategoriesQuery A secondary query class using the current class as primary query
     */
    public function useShopProductCategoriesQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinShopProductCategories($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ShopProductCategories', '\ShopProductCategoriesQuery');
    }

    /**
     * Filter the query by a related \SProductPropertiesData object
     *
     * @param \SProductPropertiesData|ObjectCollection $sProductPropertiesData the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSProductsQuery The current query, for fluid interface
     */
    public function filterBySProductPropertiesData($sProductPropertiesData, $comparison = null)
    {
        if ($sProductPropertiesData instanceof \SProductPropertiesData) {
            return $this
                ->addUsingAlias(SProductsTableMap::COL_ID, $sProductPropertiesData->getProductId(), $comparison);
        } elseif ($sProductPropertiesData instanceof ObjectCollection) {
            return $this
                ->useSProductPropertiesDataQuery()
                ->filterByPrimaryKeys($sProductPropertiesData->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterBySProductPropertiesData() only accepts arguments of type \SProductPropertiesData or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the SProductPropertiesData relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSProductsQuery The current query, for fluid interface
     */
    public function joinSProductPropertiesData($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('SProductPropertiesData');

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
            $this->addJoinObject($join, 'SProductPropertiesData');
        }

        return $this;
    }

    /**
     * Use the SProductPropertiesData relation SProductPropertiesData object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \SProductPropertiesDataQuery A secondary query class using the current class as primary query
     */
    public function useSProductPropertiesDataQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinSProductPropertiesData($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'SProductPropertiesData', '\SProductPropertiesDataQuery');
    }

    /**
     * Filter the query by a related \SNotifications object
     *
     * @param \SNotifications|ObjectCollection $sNotifications the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSProductsQuery The current query, for fluid interface
     */
    public function filterBySNotifications($sNotifications, $comparison = null)
    {
        if ($sNotifications instanceof \SNotifications) {
            return $this
                ->addUsingAlias(SProductsTableMap::COL_ID, $sNotifications->getProductId(), $comparison);
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
     * @return $this|ChildSProductsQuery The current query, for fluid interface
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
     * @return ChildSProductsQuery The current query, for fluid interface
     */
    public function filterBySOrderProducts($sOrderProducts, $comparison = null)
    {
        if ($sOrderProducts instanceof \SOrderProducts) {
            return $this
                ->addUsingAlias(SProductsTableMap::COL_ID, $sOrderProducts->getProductId(), $comparison);
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
     * @return $this|ChildSProductsQuery The current query, for fluid interface
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
     * Filter the query by a related \SProductsRating object
     *
     * @param \SProductsRating|ObjectCollection $sProductsRating the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSProductsQuery The current query, for fluid interface
     */
    public function filterBySProductsRating($sProductsRating, $comparison = null)
    {
        if ($sProductsRating instanceof \SProductsRating) {
            return $this
                ->addUsingAlias(SProductsTableMap::COL_ID, $sProductsRating->getProductId(), $comparison);
        } elseif ($sProductsRating instanceof ObjectCollection) {
            return $this
                ->useSProductsRatingQuery()
                ->filterByPrimaryKeys($sProductsRating->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterBySProductsRating() only accepts arguments of type \SProductsRating or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the SProductsRating relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSProductsQuery The current query, for fluid interface
     */
    public function joinSProductsRating($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('SProductsRating');

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
            $this->addJoinObject($join, 'SProductsRating');
        }

        return $this;
    }

    /**
     * Use the SProductsRating relation SProductsRating object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \SProductsRatingQuery A secondary query class using the current class as primary query
     */
    public function useSProductsRatingQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinSProductsRating($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'SProductsRating', '\SProductsRatingQuery');
    }

    /**
     * Filter the query by a related SCategory object
     * using the shop_product_categories table as cross reference
     *
     * @param SCategory $sCategory the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSProductsQuery The current query, for fluid interface
     */
    public function filterByCategory($sCategory, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useShopProductCategoriesQuery()
            ->filterByCategory($sCategory, $comparison)
            ->endUse();
    }

    /**
     * Exclude object from result
     *
     * @param   ChildSProducts $sProducts Object to remove from the list of results
     *
     * @return $this|ChildSProductsQuery The current query, for fluid interface
     */
    public function prune($sProducts = null)
    {
        if ($sProducts) {
            $this->addUsingAlias(SProductsTableMap::COL_ID, $sProducts->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the shop_products table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SProductsTableMap::DATABASE_NAME);
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
            SProductsTableMap::clearInstancePool();
            SProductsTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(SProductsTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(SProductsTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            // cloning the Criteria in case it's modified by doSelect() or doSelectStmt()
            $c = clone $criteria;
            $affectedRows += $c->doOnDeleteCascade($con);

            SProductsTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            SProductsTableMap::clearRelatedInstancePool();

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
        $objects = ChildSProductsQuery::create(null, $this)->find($con);
        foreach ($objects as $obj) {


            // delete related ShopKit objects
            $query = new \ShopKitQuery;

            $query->add(ShopKitTableMap::COL_PRODUCT_ID, $obj->getId());
            $affectedRows += $query->delete($con);

            // delete related ShopKitProduct objects
            $query = new \ShopKitProductQuery;

            $query->add(ShopKitProductTableMap::COL_PRODUCT_ID, $obj->getId());
            $affectedRows += $query->delete($con);

            // delete related SProductsI18n objects
            $query = new \SProductsI18nQuery;

            $query->add(SProductsI18nTableMap::COL_ID, $obj->getId());
            $affectedRows += $query->delete($con);

            // delete related SProductImages objects
            $query = new \SProductImagesQuery;

            $query->add(SProductImagesTableMap::COL_PRODUCT_ID, $obj->getId());
            $affectedRows += $query->delete($con);

            // delete related SProductVariants objects
            $query = new \SProductVariantsQuery;

            $query->add(SProductVariantsTableMap::COL_PRODUCT_ID, $obj->getId());
            $affectedRows += $query->delete($con);

            // delete related SWarehouseData objects
            $query = new \SWarehouseDataQuery;

            $query->add(SWarehouseDataTableMap::COL_PRODUCT_ID, $obj->getId());
            $affectedRows += $query->delete($con);

            // delete related ShopProductCategories objects
            $query = new \ShopProductCategoriesQuery;

            $query->add(ShopProductCategoriesTableMap::COL_PRODUCT_ID, $obj->getId());
            $affectedRows += $query->delete($con);

            // delete related SProductPropertiesData objects
            $query = new \SProductPropertiesDataQuery;

            $query->add(SProductPropertiesDataTableMap::COL_PRODUCT_ID, $obj->getId());
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
     * @return    ChildSProductsQuery The current query, for fluid interface
     */
    public function joinI18n($locale = 'ru', $relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $relationName = $relationAlias ? $relationAlias : 'SProductsI18n';

        return $this
            ->joinSProductsI18n($relationAlias, $joinType)
            ->addJoinCondition($relationName, $relationName . '.Locale = ?', $locale);
    }

    /**
     * Adds a JOIN clause to the query and hydrates the related I18n object.
     * Shortcut for $c->joinI18n($locale)->with()
     *
     * @param     string $locale Locale to use for the join condition, e.g. 'fr_FR'
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'. Defaults to left join.
     *
     * @return    $this|ChildSProductsQuery The current query, for fluid interface
     */
    public function joinWithI18n($locale = 'ru', $joinType = Criteria::LEFT_JOIN)
    {
        $this
            ->joinI18n($locale, null, $joinType)
            ->with('SProductsI18n');
        $this->with['SProductsI18n']->setIsWithOneToMany(false);

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
     * @return    ChildSProductsI18nQuery A secondary query class using the current class as primary query
     */
    public function useI18nQuery($locale = 'ru', $relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinI18n($locale, $relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'SProductsI18n', '\SProductsI18nQuery');
    }

    // query_cache behavior

    public function setQueryKey($key)
    {
        $this->queryKey = $key;

        return $this;
    }

    public function getQueryKey()
    {
        return $this->queryKey;
    }

    public function cacheContains($key)
    {
        throw new PropelException('You must override the cacheContains(), cacheStore(), and cacheFetch() methods to enable query cache');
    }

    public function cacheFetch($key)
    {
        throw new PropelException('You must override the cacheContains(), cacheStore(), and cacheFetch() methods to enable query cache');
    }

    public function cacheStore($key, $value, $lifetime = 600)
    {
        throw new PropelException('You must override the cacheContains(), cacheStore(), and cacheFetch() methods to enable query cache');
    }

    public function doSelect(ConnectionInterface $con = null)
    {
        // check that the columns of the main class are already added (if this is the primary ModelCriteria)
        if (!$this->hasSelectClause() && !$this->getPrimaryCriteria()) {
            $this->addSelfSelectColumns();
        }
        $this->configureSelectColumns();

        $dbMap = Propel::getServiceContainer()->getDatabaseMap(SProductsTableMap::DATABASE_NAME);
        $db = Propel::getServiceContainer()->getAdapter(SProductsTableMap::DATABASE_NAME);

        $key = $this->getQueryKey();
        if ($key && $this->cacheContains($key)) {
            $params = $this->getParams();
            $sql = $this->cacheFetch($key);
        } else {
            $params = array();
            $sql = $this->createSelectSql($params);
            if ($key) {
                $this->cacheStore($key, $sql);
            }
        }

        try {
            $stmt = $con->prepare($sql);
            $db->bindValues($stmt, $params, $dbMap);
            $stmt->execute();
            } catch (Exception $e) {
                Propel::log($e->getMessage(), Propel::LOG_ERR);
                throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
            }

        return $con->getDataFetcher($stmt);
    }

    public function doCount(ConnectionInterface $con = null)
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap($this->getDbName());
        $db = Propel::getServiceContainer()->getAdapter($this->getDbName());

        $key = $this->getQueryKey();
        if ($key && $this->cacheContains($key)) {
            $params = $this->getParams();
            $sql = $this->cacheFetch($key);
        } else {
            // check that the columns of the main class are already added (if this is the primary ModelCriteria)
            if (!$this->hasSelectClause() && !$this->getPrimaryCriteria()) {
                $this->addSelfSelectColumns();
            }

            $this->configureSelectColumns();

            $needsComplexCount = $this->getGroupByColumns()
                || $this->getOffset()
                || $this->getLimit()
                || $this->getHaving()
                || in_array(Criteria::DISTINCT, $this->getSelectModifiers());

            $params = array();
            if ($needsComplexCount) {
                if ($this->needsSelectAliases()) {
                    if ($this->getHaving()) {
                        throw new PropelException('Propel cannot create a COUNT query when using HAVING and  duplicate column names in the SELECT part');
                    }
                    $db->turnSelectColumnsToAliases($this);
                }
                $selectSql = $this->createSelectSql($params);
                $sql = 'SELECT COUNT(*) FROM (' . $selectSql . ') propelmatch4cnt';
            } else {
                // Replace SELECT columns with COUNT(*)
                $this->clearSelectColumns()->addSelectColumn('COUNT(*)');
                $sql = $this->createSelectSql($params);
            }

            if ($key) {
                $this->cacheStore($key, $sql);
            }
        }

        try {
            $stmt = $con->prepare($sql);
            $db->bindValues($stmt, $params, $dbMap);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute COUNT statement [%s]', $sql), 0, $e);
        }

        return $con->getDataFetcher($stmt);
    }

} // SProductsQuery
