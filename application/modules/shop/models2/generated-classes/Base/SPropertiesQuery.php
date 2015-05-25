<?php

namespace Base;

use \SProperties as ChildSProperties;
use \SPropertiesI18nQuery as ChildSPropertiesI18nQuery;
use \SPropertiesQuery as ChildSPropertiesQuery;
use \Exception;
use \PDO;
use Map\SProductPropertiesDataTableMap;
use Map\SPropertiesI18nTableMap;
use Map\SPropertiesTableMap;
use Map\ShopProductPropertiesCategoriesTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'shop_product_properties' table.
 *
 *
 *
 * @method     ChildSPropertiesQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildSPropertiesQuery orderByExternalId($order = Criteria::ASC) Order by the external_id column
 * @method     ChildSPropertiesQuery orderByCsvName($order = Criteria::ASC) Order by the csv_name column
 * @method     ChildSPropertiesQuery orderByMultiple($order = Criteria::ASC) Order by the multiple column
 * @method     ChildSPropertiesQuery orderByActive($order = Criteria::ASC) Order by the active column
 * @method     ChildSPropertiesQuery orderByShowOnSite($order = Criteria::ASC) Order by the show_on_site column
 * @method     ChildSPropertiesQuery orderByShowInCompare($order = Criteria::ASC) Order by the show_in_compare column
 * @method     ChildSPropertiesQuery orderByShowInFilter($order = Criteria::ASC) Order by the show_in_filter column
 * @method     ChildSPropertiesQuery orderByShowFaq($order = Criteria::ASC) Order by the show_faq column
 * @method     ChildSPropertiesQuery orderByMainProperty($order = Criteria::ASC) Order by the main_property column
 * @method     ChildSPropertiesQuery orderByPosition($order = Criteria::ASC) Order by the position column
 *
 * @method     ChildSPropertiesQuery groupById() Group by the id column
 * @method     ChildSPropertiesQuery groupByExternalId() Group by the external_id column
 * @method     ChildSPropertiesQuery groupByCsvName() Group by the csv_name column
 * @method     ChildSPropertiesQuery groupByMultiple() Group by the multiple column
 * @method     ChildSPropertiesQuery groupByActive() Group by the active column
 * @method     ChildSPropertiesQuery groupByShowOnSite() Group by the show_on_site column
 * @method     ChildSPropertiesQuery groupByShowInCompare() Group by the show_in_compare column
 * @method     ChildSPropertiesQuery groupByShowInFilter() Group by the show_in_filter column
 * @method     ChildSPropertiesQuery groupByShowFaq() Group by the show_faq column
 * @method     ChildSPropertiesQuery groupByMainProperty() Group by the main_property column
 * @method     ChildSPropertiesQuery groupByPosition() Group by the position column
 *
 * @method     ChildSPropertiesQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildSPropertiesQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildSPropertiesQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildSPropertiesQuery leftJoinSPropertiesI18n($relationAlias = null) Adds a LEFT JOIN clause to the query using the SPropertiesI18n relation
 * @method     ChildSPropertiesQuery rightJoinSPropertiesI18n($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SPropertiesI18n relation
 * @method     ChildSPropertiesQuery innerJoinSPropertiesI18n($relationAlias = null) Adds a INNER JOIN clause to the query using the SPropertiesI18n relation
 *
 * @method     ChildSPropertiesQuery leftJoinShopProductPropertiesCategories($relationAlias = null) Adds a LEFT JOIN clause to the query using the ShopProductPropertiesCategories relation
 * @method     ChildSPropertiesQuery rightJoinShopProductPropertiesCategories($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ShopProductPropertiesCategories relation
 * @method     ChildSPropertiesQuery innerJoinShopProductPropertiesCategories($relationAlias = null) Adds a INNER JOIN clause to the query using the ShopProductPropertiesCategories relation
 *
 * @method     ChildSPropertiesQuery leftJoinSProductPropertiesData($relationAlias = null) Adds a LEFT JOIN clause to the query using the SProductPropertiesData relation
 * @method     ChildSPropertiesQuery rightJoinSProductPropertiesData($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SProductPropertiesData relation
 * @method     ChildSPropertiesQuery innerJoinSProductPropertiesData($relationAlias = null) Adds a INNER JOIN clause to the query using the SProductPropertiesData relation
 *
 * @method     \SPropertiesI18nQuery|\ShopProductPropertiesCategoriesQuery|\SProductPropertiesDataQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildSProperties findOne(ConnectionInterface $con = null) Return the first ChildSProperties matching the query
 * @method     ChildSProperties findOneOrCreate(ConnectionInterface $con = null) Return the first ChildSProperties matching the query, or a new ChildSProperties object populated from the query conditions when no match is found
 *
 * @method     ChildSProperties findOneById(int $id) Return the first ChildSProperties filtered by the id column
 * @method     ChildSProperties findOneByExternalId(string $external_id) Return the first ChildSProperties filtered by the external_id column
 * @method     ChildSProperties findOneByCsvName(string $csv_name) Return the first ChildSProperties filtered by the csv_name column
 * @method     ChildSProperties findOneByMultiple(boolean $multiple) Return the first ChildSProperties filtered by the multiple column
 * @method     ChildSProperties findOneByActive(boolean $active) Return the first ChildSProperties filtered by the active column
 * @method     ChildSProperties findOneByShowOnSite(boolean $show_on_site) Return the first ChildSProperties filtered by the show_on_site column
 * @method     ChildSProperties findOneByShowInCompare(boolean $show_in_compare) Return the first ChildSProperties filtered by the show_in_compare column
 * @method     ChildSProperties findOneByShowInFilter(boolean $show_in_filter) Return the first ChildSProperties filtered by the show_in_filter column
 * @method     ChildSProperties findOneByShowFaq(boolean $show_faq) Return the first ChildSProperties filtered by the show_faq column
 * @method     ChildSProperties findOneByMainProperty(boolean $main_property) Return the first ChildSProperties filtered by the main_property column
 * @method     ChildSProperties findOneByPosition(int $position) Return the first ChildSProperties filtered by the position column *

 * @method     ChildSProperties requirePk($key, ConnectionInterface $con = null) Return the ChildSProperties by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSProperties requireOne(ConnectionInterface $con = null) Return the first ChildSProperties matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSProperties requireOneById(int $id) Return the first ChildSProperties filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSProperties requireOneByExternalId(string $external_id) Return the first ChildSProperties filtered by the external_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSProperties requireOneByCsvName(string $csv_name) Return the first ChildSProperties filtered by the csv_name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSProperties requireOneByMultiple(boolean $multiple) Return the first ChildSProperties filtered by the multiple column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSProperties requireOneByActive(boolean $active) Return the first ChildSProperties filtered by the active column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSProperties requireOneByShowOnSite(boolean $show_on_site) Return the first ChildSProperties filtered by the show_on_site column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSProperties requireOneByShowInCompare(boolean $show_in_compare) Return the first ChildSProperties filtered by the show_in_compare column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSProperties requireOneByShowInFilter(boolean $show_in_filter) Return the first ChildSProperties filtered by the show_in_filter column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSProperties requireOneByShowFaq(boolean $show_faq) Return the first ChildSProperties filtered by the show_faq column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSProperties requireOneByMainProperty(boolean $main_property) Return the first ChildSProperties filtered by the main_property column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSProperties requireOneByPosition(int $position) Return the first ChildSProperties filtered by the position column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSProperties[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildSProperties objects based on current ModelCriteria
 * @method     ChildSProperties[]|ObjectCollection findById(int $id) Return ChildSProperties objects filtered by the id column
 * @method     ChildSProperties[]|ObjectCollection findByExternalId(string $external_id) Return ChildSProperties objects filtered by the external_id column
 * @method     ChildSProperties[]|ObjectCollection findByCsvName(string $csv_name) Return ChildSProperties objects filtered by the csv_name column
 * @method     ChildSProperties[]|ObjectCollection findByMultiple(boolean $multiple) Return ChildSProperties objects filtered by the multiple column
 * @method     ChildSProperties[]|ObjectCollection findByActive(boolean $active) Return ChildSProperties objects filtered by the active column
 * @method     ChildSProperties[]|ObjectCollection findByShowOnSite(boolean $show_on_site) Return ChildSProperties objects filtered by the show_on_site column
 * @method     ChildSProperties[]|ObjectCollection findByShowInCompare(boolean $show_in_compare) Return ChildSProperties objects filtered by the show_in_compare column
 * @method     ChildSProperties[]|ObjectCollection findByShowInFilter(boolean $show_in_filter) Return ChildSProperties objects filtered by the show_in_filter column
 * @method     ChildSProperties[]|ObjectCollection findByShowFaq(boolean $show_faq) Return ChildSProperties objects filtered by the show_faq column
 * @method     ChildSProperties[]|ObjectCollection findByMainProperty(boolean $main_property) Return ChildSProperties objects filtered by the main_property column
 * @method     ChildSProperties[]|ObjectCollection findByPosition(int $position) Return ChildSProperties objects filtered by the position column
 * @method     ChildSProperties[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class SPropertiesQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\SPropertiesQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'Shop', $modelName = '\\SProperties', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildSPropertiesQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildSPropertiesQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildSPropertiesQuery) {
            return $criteria;
        }
        $query = new ChildSPropertiesQuery();
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
     * @return ChildSProperties|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = SPropertiesTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(SPropertiesTableMap::DATABASE_NAME);
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
     * @return ChildSProperties A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, external_id, csv_name, multiple, active, show_on_site, show_in_compare, show_in_filter, show_faq, main_property, position FROM shop_product_properties WHERE id = :p0';
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
            /** @var ChildSProperties $obj */
            $obj = new ChildSProperties();
            $obj->hydrate($row);
            SPropertiesTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildSProperties|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildSPropertiesQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(SPropertiesTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildSPropertiesQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(SPropertiesTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildSPropertiesQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(SPropertiesTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(SPropertiesTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SPropertiesTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildSPropertiesQuery The current query, for fluid interface
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

        return $this->addUsingAlias(SPropertiesTableMap::COL_EXTERNAL_ID, $externalId, $comparison);
    }

    /**
     * Filter the query on the csv_name column
     *
     * Example usage:
     * <code>
     * $query->filterByCsvName('fooValue');   // WHERE csv_name = 'fooValue'
     * $query->filterByCsvName('%fooValue%'); // WHERE csv_name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $csvName The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSPropertiesQuery The current query, for fluid interface
     */
    public function filterByCsvName($csvName = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($csvName)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $csvName)) {
                $csvName = str_replace('*', '%', $csvName);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SPropertiesTableMap::COL_CSV_NAME, $csvName, $comparison);
    }

    /**
     * Filter the query on the multiple column
     *
     * Example usage:
     * <code>
     * $query->filterByMultiple(true); // WHERE multiple = true
     * $query->filterByMultiple('yes'); // WHERE multiple = true
     * </code>
     *
     * @param     boolean|string $multiple The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSPropertiesQuery The current query, for fluid interface
     */
    public function filterByMultiple($multiple = null, $comparison = null)
    {
        if (is_string($multiple)) {
            $multiple = in_array(strtolower($multiple), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(SPropertiesTableMap::COL_MULTIPLE, $multiple, $comparison);
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
     * @return $this|ChildSPropertiesQuery The current query, for fluid interface
     */
    public function filterByActive($active = null, $comparison = null)
    {
        if (is_string($active)) {
            $active = in_array(strtolower($active), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(SPropertiesTableMap::COL_ACTIVE, $active, $comparison);
    }

    /**
     * Filter the query on the show_on_site column
     *
     * Example usage:
     * <code>
     * $query->filterByShowOnSite(true); // WHERE show_on_site = true
     * $query->filterByShowOnSite('yes'); // WHERE show_on_site = true
     * </code>
     *
     * @param     boolean|string $showOnSite The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSPropertiesQuery The current query, for fluid interface
     */
    public function filterByShowOnSite($showOnSite = null, $comparison = null)
    {
        if (is_string($showOnSite)) {
            $showOnSite = in_array(strtolower($showOnSite), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(SPropertiesTableMap::COL_SHOW_ON_SITE, $showOnSite, $comparison);
    }

    /**
     * Filter the query on the show_in_compare column
     *
     * Example usage:
     * <code>
     * $query->filterByShowInCompare(true); // WHERE show_in_compare = true
     * $query->filterByShowInCompare('yes'); // WHERE show_in_compare = true
     * </code>
     *
     * @param     boolean|string $showInCompare The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSPropertiesQuery The current query, for fluid interface
     */
    public function filterByShowInCompare($showInCompare = null, $comparison = null)
    {
        if (is_string($showInCompare)) {
            $showInCompare = in_array(strtolower($showInCompare), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(SPropertiesTableMap::COL_SHOW_IN_COMPARE, $showInCompare, $comparison);
    }

    /**
     * Filter the query on the show_in_filter column
     *
     * Example usage:
     * <code>
     * $query->filterByShowInFilter(true); // WHERE show_in_filter = true
     * $query->filterByShowInFilter('yes'); // WHERE show_in_filter = true
     * </code>
     *
     * @param     boolean|string $showInFilter The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSPropertiesQuery The current query, for fluid interface
     */
    public function filterByShowInFilter($showInFilter = null, $comparison = null)
    {
        if (is_string($showInFilter)) {
            $showInFilter = in_array(strtolower($showInFilter), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(SPropertiesTableMap::COL_SHOW_IN_FILTER, $showInFilter, $comparison);
    }

    /**
     * Filter the query on the show_faq column
     *
     * Example usage:
     * <code>
     * $query->filterByShowFaq(true); // WHERE show_faq = true
     * $query->filterByShowFaq('yes'); // WHERE show_faq = true
     * </code>
     *
     * @param     boolean|string $showFaq The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSPropertiesQuery The current query, for fluid interface
     */
    public function filterByShowFaq($showFaq = null, $comparison = null)
    {
        if (is_string($showFaq)) {
            $showFaq = in_array(strtolower($showFaq), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(SPropertiesTableMap::COL_SHOW_FAQ, $showFaq, $comparison);
    }

    /**
     * Filter the query on the main_property column
     *
     * Example usage:
     * <code>
     * $query->filterByMainProperty(true); // WHERE main_property = true
     * $query->filterByMainProperty('yes'); // WHERE main_property = true
     * </code>
     *
     * @param     boolean|string $mainProperty The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSPropertiesQuery The current query, for fluid interface
     */
    public function filterByMainProperty($mainProperty = null, $comparison = null)
    {
        if (is_string($mainProperty)) {
            $mainProperty = in_array(strtolower($mainProperty), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(SPropertiesTableMap::COL_MAIN_PROPERTY, $mainProperty, $comparison);
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
     * @return $this|ChildSPropertiesQuery The current query, for fluid interface
     */
    public function filterByPosition($position = null, $comparison = null)
    {
        if (is_array($position)) {
            $useMinMax = false;
            if (isset($position['min'])) {
                $this->addUsingAlias(SPropertiesTableMap::COL_POSITION, $position['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($position['max'])) {
                $this->addUsingAlias(SPropertiesTableMap::COL_POSITION, $position['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SPropertiesTableMap::COL_POSITION, $position, $comparison);
    }

    /**
     * Filter the query by a related \SPropertiesI18n object
     *
     * @param \SPropertiesI18n|ObjectCollection $sPropertiesI18n the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSPropertiesQuery The current query, for fluid interface
     */
    public function filterBySPropertiesI18n($sPropertiesI18n, $comparison = null)
    {
        if ($sPropertiesI18n instanceof \SPropertiesI18n) {
            return $this
                ->addUsingAlias(SPropertiesTableMap::COL_ID, $sPropertiesI18n->getId(), $comparison);
        } elseif ($sPropertiesI18n instanceof ObjectCollection) {
            return $this
                ->useSPropertiesI18nQuery()
                ->filterByPrimaryKeys($sPropertiesI18n->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterBySPropertiesI18n() only accepts arguments of type \SPropertiesI18n or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the SPropertiesI18n relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSPropertiesQuery The current query, for fluid interface
     */
    public function joinSPropertiesI18n($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('SPropertiesI18n');

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
            $this->addJoinObject($join, 'SPropertiesI18n');
        }

        return $this;
    }

    /**
     * Use the SPropertiesI18n relation SPropertiesI18n object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \SPropertiesI18nQuery A secondary query class using the current class as primary query
     */
    public function useSPropertiesI18nQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinSPropertiesI18n($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'SPropertiesI18n', '\SPropertiesI18nQuery');
    }

    /**
     * Filter the query by a related \ShopProductPropertiesCategories object
     *
     * @param \ShopProductPropertiesCategories|ObjectCollection $shopProductPropertiesCategories the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSPropertiesQuery The current query, for fluid interface
     */
    public function filterByShopProductPropertiesCategories($shopProductPropertiesCategories, $comparison = null)
    {
        if ($shopProductPropertiesCategories instanceof \ShopProductPropertiesCategories) {
            return $this
                ->addUsingAlias(SPropertiesTableMap::COL_ID, $shopProductPropertiesCategories->getPropertyId(), $comparison);
        } elseif ($shopProductPropertiesCategories instanceof ObjectCollection) {
            return $this
                ->useShopProductPropertiesCategoriesQuery()
                ->filterByPrimaryKeys($shopProductPropertiesCategories->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByShopProductPropertiesCategories() only accepts arguments of type \ShopProductPropertiesCategories or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ShopProductPropertiesCategories relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSPropertiesQuery The current query, for fluid interface
     */
    public function joinShopProductPropertiesCategories($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ShopProductPropertiesCategories');

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
            $this->addJoinObject($join, 'ShopProductPropertiesCategories');
        }

        return $this;
    }

    /**
     * Use the ShopProductPropertiesCategories relation ShopProductPropertiesCategories object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ShopProductPropertiesCategoriesQuery A secondary query class using the current class as primary query
     */
    public function useShopProductPropertiesCategoriesQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinShopProductPropertiesCategories($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ShopProductPropertiesCategories', '\ShopProductPropertiesCategoriesQuery');
    }

    /**
     * Filter the query by a related \SProductPropertiesData object
     *
     * @param \SProductPropertiesData|ObjectCollection $sProductPropertiesData the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSPropertiesQuery The current query, for fluid interface
     */
    public function filterBySProductPropertiesData($sProductPropertiesData, $comparison = null)
    {
        if ($sProductPropertiesData instanceof \SProductPropertiesData) {
            return $this
                ->addUsingAlias(SPropertiesTableMap::COL_ID, $sProductPropertiesData->getPropertyId(), $comparison);
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
     * @return $this|ChildSPropertiesQuery The current query, for fluid interface
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
     * Filter the query by a related SCategory object
     * using the shop_product_properties_categories table as cross reference
     *
     * @param SCategory $sCategory the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSPropertiesQuery The current query, for fluid interface
     */
    public function filterByPropertyCategory($sCategory, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useShopProductPropertiesCategoriesQuery()
            ->filterByPropertyCategory($sCategory, $comparison)
            ->endUse();
    }

    /**
     * Exclude object from result
     *
     * @param   ChildSProperties $sProperties Object to remove from the list of results
     *
     * @return $this|ChildSPropertiesQuery The current query, for fluid interface
     */
    public function prune($sProperties = null)
    {
        if ($sProperties) {
            $this->addUsingAlias(SPropertiesTableMap::COL_ID, $sProperties->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the shop_product_properties table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SPropertiesTableMap::DATABASE_NAME);
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
            SPropertiesTableMap::clearInstancePool();
            SPropertiesTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(SPropertiesTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(SPropertiesTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            // cloning the Criteria in case it's modified by doSelect() or doSelectStmt()
            $c = clone $criteria;
            $affectedRows += $c->doOnDeleteCascade($con);

            SPropertiesTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            SPropertiesTableMap::clearRelatedInstancePool();

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
        $objects = ChildSPropertiesQuery::create(null, $this)->find($con);
        foreach ($objects as $obj) {


            // delete related SPropertiesI18n objects
            $query = new \SPropertiesI18nQuery;

            $query->add(SPropertiesI18nTableMap::COL_ID, $obj->getId());
            $affectedRows += $query->delete($con);

            // delete related ShopProductPropertiesCategories objects
            $query = new \ShopProductPropertiesCategoriesQuery;

            $query->add(ShopProductPropertiesCategoriesTableMap::COL_PROPERTY_ID, $obj->getId());
            $affectedRows += $query->delete($con);

            // delete related SProductPropertiesData objects
            $query = new \SProductPropertiesDataQuery;

            $query->add(SProductPropertiesDataTableMap::COL_PROPERTY_ID, $obj->getId());
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
     * @return    ChildSPropertiesQuery The current query, for fluid interface
     */
    public function joinI18n($locale = 'ru', $relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $relationName = $relationAlias ? $relationAlias : 'SPropertiesI18n';

        return $this
            ->joinSPropertiesI18n($relationAlias, $joinType)
            ->addJoinCondition($relationName, $relationName . '.Locale = ?', $locale);
    }

    /**
     * Adds a JOIN clause to the query and hydrates the related I18n object.
     * Shortcut for $c->joinI18n($locale)->with()
     *
     * @param     string $locale Locale to use for the join condition, e.g. 'fr_FR'
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'. Defaults to left join.
     *
     * @return    $this|ChildSPropertiesQuery The current query, for fluid interface
     */
    public function joinWithI18n($locale = 'ru', $joinType = Criteria::LEFT_JOIN)
    {
        $this
            ->joinI18n($locale, null, $joinType)
            ->with('SPropertiesI18n');
        $this->with['SPropertiesI18n']->setIsWithOneToMany(false);

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
     * @return    ChildSPropertiesI18nQuery A secondary query class using the current class as primary query
     */
    public function useI18nQuery($locale = 'ru', $relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinI18n($locale, $relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'SPropertiesI18n', '\SPropertiesI18nQuery');
    }

} // SPropertiesQuery
