<?php

namespace Base;

use \SCategoryVersion as ChildSCategoryVersion;
use \SCategoryVersionQuery as ChildSCategoryVersionQuery;
use \Exception;
use \PDO;
use Map\SCategoryVersionTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'shop_category_version' table.
 *
 *
 *
 * @method     ChildSCategoryVersionQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildSCategoryVersionQuery orderByParentId($order = Criteria::ASC) Order by the parent_id column
 * @method     ChildSCategoryVersionQuery orderByExternalId($order = Criteria::ASC) Order by the external_id column
 * @method     ChildSCategoryVersionQuery orderByUrl($order = Criteria::ASC) Order by the url column
 * @method     ChildSCategoryVersionQuery orderByActive($order = Criteria::ASC) Order by the active column
 * @method     ChildSCategoryVersionQuery orderByImage($order = Criteria::ASC) Order by the image column
 * @method     ChildSCategoryVersionQuery orderByPosition($order = Criteria::ASC) Order by the position column
 * @method     ChildSCategoryVersionQuery orderByFullPath($order = Criteria::ASC) Order by the full_path column
 * @method     ChildSCategoryVersionQuery orderByFullPathIds($order = Criteria::ASC) Order by the full_path_ids column
 * @method     ChildSCategoryVersionQuery orderByTpl($order = Criteria::ASC) Order by the tpl column
 * @method     ChildSCategoryVersionQuery orderByOrderMethod($order = Criteria::ASC) Order by the order_method column
 * @method     ChildSCategoryVersionQuery orderByShowsitetitle($order = Criteria::ASC) Order by the showsitetitle column
 * @method     ChildSCategoryVersionQuery orderByCreated($order = Criteria::ASC) Order by the created column
 * @method     ChildSCategoryVersionQuery orderByUpdated($order = Criteria::ASC) Order by the updated column
 * @method     ChildSCategoryVersionQuery orderByVersion($order = Criteria::ASC) Order by the version column
 * @method     ChildSCategoryVersionQuery orderByParentIdVersion($order = Criteria::ASC) Order by the parent_id_version column
 * @method     ChildSCategoryVersionQuery orderByShopCategoryIds($order = Criteria::ASC) Order by the shop_category_ids column
 * @method     ChildSCategoryVersionQuery orderByShopCategoryVersions($order = Criteria::ASC) Order by the shop_category_versions column
 *
 * @method     ChildSCategoryVersionQuery groupById() Group by the id column
 * @method     ChildSCategoryVersionQuery groupByParentId() Group by the parent_id column
 * @method     ChildSCategoryVersionQuery groupByExternalId() Group by the external_id column
 * @method     ChildSCategoryVersionQuery groupByUrl() Group by the url column
 * @method     ChildSCategoryVersionQuery groupByActive() Group by the active column
 * @method     ChildSCategoryVersionQuery groupByImage() Group by the image column
 * @method     ChildSCategoryVersionQuery groupByPosition() Group by the position column
 * @method     ChildSCategoryVersionQuery groupByFullPath() Group by the full_path column
 * @method     ChildSCategoryVersionQuery groupByFullPathIds() Group by the full_path_ids column
 * @method     ChildSCategoryVersionQuery groupByTpl() Group by the tpl column
 * @method     ChildSCategoryVersionQuery groupByOrderMethod() Group by the order_method column
 * @method     ChildSCategoryVersionQuery groupByShowsitetitle() Group by the showsitetitle column
 * @method     ChildSCategoryVersionQuery groupByCreated() Group by the created column
 * @method     ChildSCategoryVersionQuery groupByUpdated() Group by the updated column
 * @method     ChildSCategoryVersionQuery groupByVersion() Group by the version column
 * @method     ChildSCategoryVersionQuery groupByParentIdVersion() Group by the parent_id_version column
 * @method     ChildSCategoryVersionQuery groupByShopCategoryIds() Group by the shop_category_ids column
 * @method     ChildSCategoryVersionQuery groupByShopCategoryVersions() Group by the shop_category_versions column
 *
 * @method     ChildSCategoryVersionQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildSCategoryVersionQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildSCategoryVersionQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildSCategoryVersionQuery leftJoinSCategory($relationAlias = null) Adds a LEFT JOIN clause to the query using the SCategory relation
 * @method     ChildSCategoryVersionQuery rightJoinSCategory($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SCategory relation
 * @method     ChildSCategoryVersionQuery innerJoinSCategory($relationAlias = null) Adds a INNER JOIN clause to the query using the SCategory relation
 *
 * @method     \SCategoryQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildSCategoryVersion findOne(ConnectionInterface $con = null) Return the first ChildSCategoryVersion matching the query
 * @method     ChildSCategoryVersion findOneOrCreate(ConnectionInterface $con = null) Return the first ChildSCategoryVersion matching the query, or a new ChildSCategoryVersion object populated from the query conditions when no match is found
 *
 * @method     ChildSCategoryVersion findOneById(int $id) Return the first ChildSCategoryVersion filtered by the id column
 * @method     ChildSCategoryVersion findOneByParentId(int $parent_id) Return the first ChildSCategoryVersion filtered by the parent_id column
 * @method     ChildSCategoryVersion findOneByExternalId(string $external_id) Return the first ChildSCategoryVersion filtered by the external_id column
 * @method     ChildSCategoryVersion findOneByUrl(string $url) Return the first ChildSCategoryVersion filtered by the url column
 * @method     ChildSCategoryVersion findOneByActive(boolean $active) Return the first ChildSCategoryVersion filtered by the active column
 * @method     ChildSCategoryVersion findOneByImage(string $image) Return the first ChildSCategoryVersion filtered by the image column
 * @method     ChildSCategoryVersion findOneByPosition(int $position) Return the first ChildSCategoryVersion filtered by the position column
 * @method     ChildSCategoryVersion findOneByFullPath(string $full_path) Return the first ChildSCategoryVersion filtered by the full_path column
 * @method     ChildSCategoryVersion findOneByFullPathIds(string $full_path_ids) Return the first ChildSCategoryVersion filtered by the full_path_ids column
 * @method     ChildSCategoryVersion findOneByTpl(string $tpl) Return the first ChildSCategoryVersion filtered by the tpl column
 * @method     ChildSCategoryVersion findOneByOrderMethod(int $order_method) Return the first ChildSCategoryVersion filtered by the order_method column
 * @method     ChildSCategoryVersion findOneByShowsitetitle(int $showsitetitle) Return the first ChildSCategoryVersion filtered by the showsitetitle column
 * @method     ChildSCategoryVersion findOneByCreated(int $created) Return the first ChildSCategoryVersion filtered by the created column
 * @method     ChildSCategoryVersion findOneByUpdated(int $updated) Return the first ChildSCategoryVersion filtered by the updated column
 * @method     ChildSCategoryVersion findOneByVersion(int $version) Return the first ChildSCategoryVersion filtered by the version column
 * @method     ChildSCategoryVersion findOneByParentIdVersion(int $parent_id_version) Return the first ChildSCategoryVersion filtered by the parent_id_version column
 * @method     ChildSCategoryVersion findOneByShopCategoryIds(array $shop_category_ids) Return the first ChildSCategoryVersion filtered by the shop_category_ids column
 * @method     ChildSCategoryVersion findOneByShopCategoryVersions(array $shop_category_versions) Return the first ChildSCategoryVersion filtered by the shop_category_versions column
 *
 * @method     ChildSCategoryVersion[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildSCategoryVersion objects based on current ModelCriteria
 * @method     ChildSCategoryVersion[]|ObjectCollection findById(int $id) Return ChildSCategoryVersion objects filtered by the id column
 * @method     ChildSCategoryVersion[]|ObjectCollection findByParentId(int $parent_id) Return ChildSCategoryVersion objects filtered by the parent_id column
 * @method     ChildSCategoryVersion[]|ObjectCollection findByExternalId(string $external_id) Return ChildSCategoryVersion objects filtered by the external_id column
 * @method     ChildSCategoryVersion[]|ObjectCollection findByUrl(string $url) Return ChildSCategoryVersion objects filtered by the url column
 * @method     ChildSCategoryVersion[]|ObjectCollection findByActive(boolean $active) Return ChildSCategoryVersion objects filtered by the active column
 * @method     ChildSCategoryVersion[]|ObjectCollection findByImage(string $image) Return ChildSCategoryVersion objects filtered by the image column
 * @method     ChildSCategoryVersion[]|ObjectCollection findByPosition(int $position) Return ChildSCategoryVersion objects filtered by the position column
 * @method     ChildSCategoryVersion[]|ObjectCollection findByFullPath(string $full_path) Return ChildSCategoryVersion objects filtered by the full_path column
 * @method     ChildSCategoryVersion[]|ObjectCollection findByFullPathIds(string $full_path_ids) Return ChildSCategoryVersion objects filtered by the full_path_ids column
 * @method     ChildSCategoryVersion[]|ObjectCollection findByTpl(string $tpl) Return ChildSCategoryVersion objects filtered by the tpl column
 * @method     ChildSCategoryVersion[]|ObjectCollection findByOrderMethod(int $order_method) Return ChildSCategoryVersion objects filtered by the order_method column
 * @method     ChildSCategoryVersion[]|ObjectCollection findByShowsitetitle(int $showsitetitle) Return ChildSCategoryVersion objects filtered by the showsitetitle column
 * @method     ChildSCategoryVersion[]|ObjectCollection findByCreated(int $created) Return ChildSCategoryVersion objects filtered by the created column
 * @method     ChildSCategoryVersion[]|ObjectCollection findByUpdated(int $updated) Return ChildSCategoryVersion objects filtered by the updated column
 * @method     ChildSCategoryVersion[]|ObjectCollection findByVersion(int $version) Return ChildSCategoryVersion objects filtered by the version column
 * @method     ChildSCategoryVersion[]|ObjectCollection findByParentIdVersion(int $parent_id_version) Return ChildSCategoryVersion objects filtered by the parent_id_version column
 * @method     ChildSCategoryVersion[]|ObjectCollection findByShopCategoryIds(array $shop_category_ids) Return ChildSCategoryVersion objects filtered by the shop_category_ids column
 * @method     ChildSCategoryVersion[]|ObjectCollection findByShopCategoryVersions(array $shop_category_versions) Return ChildSCategoryVersion objects filtered by the shop_category_versions column
 * @method     ChildSCategoryVersion[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class SCategoryVersionQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \Base\SCategoryVersionQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'Shop', $modelName = '\\SCategoryVersion', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildSCategoryVersionQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildSCategoryVersionQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildSCategoryVersionQuery) {
            return $criteria;
        }
        $query = new ChildSCategoryVersionQuery();
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
     * @param array[$id, $version] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildSCategoryVersion|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = SCategoryVersionTableMap::getInstanceFromPool(serialize(array((string) $key[0], (string) $key[1]))))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(SCategoryVersionTableMap::DATABASE_NAME);
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
     * @return ChildSCategoryVersion A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, parent_id, external_id, url, active, image, position, full_path, full_path_ids, tpl, order_method, showsitetitle, created, updated, version, parent_id_version, shop_category_ids, shop_category_versions FROM shop_category_version WHERE id = :p0 AND version = :p1';
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
            /** @var ChildSCategoryVersion $obj */
            $obj = new ChildSCategoryVersion();
            $obj->hydrate($row);
            SCategoryVersionTableMap::addInstanceToPool($obj, serialize(array((string) $key[0], (string) $key[1])));
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
     * @return ChildSCategoryVersion|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildSCategoryVersionQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(SCategoryVersionTableMap::COL_ID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(SCategoryVersionTableMap::COL_VERSION, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildSCategoryVersionQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(SCategoryVersionTableMap::COL_ID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(SCategoryVersionTableMap::COL_VERSION, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $this->addOr($cton0);
        }

        return $this;
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
     * @see       filterBySCategory()
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSCategoryVersionQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(SCategoryVersionTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(SCategoryVersionTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SCategoryVersionTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the parent_id column
     *
     * Example usage:
     * <code>
     * $query->filterByParentId(1234); // WHERE parent_id = 1234
     * $query->filterByParentId(array(12, 34)); // WHERE parent_id IN (12, 34)
     * $query->filterByParentId(array('min' => 12)); // WHERE parent_id > 12
     * </code>
     *
     * @param     mixed $parentId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSCategoryVersionQuery The current query, for fluid interface
     */
    public function filterByParentId($parentId = null, $comparison = null)
    {
        if (is_array($parentId)) {
            $useMinMax = false;
            if (isset($parentId['min'])) {
                $this->addUsingAlias(SCategoryVersionTableMap::COL_PARENT_ID, $parentId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($parentId['max'])) {
                $this->addUsingAlias(SCategoryVersionTableMap::COL_PARENT_ID, $parentId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SCategoryVersionTableMap::COL_PARENT_ID, $parentId, $comparison);
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
     * @return $this|ChildSCategoryVersionQuery The current query, for fluid interface
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

        return $this->addUsingAlias(SCategoryVersionTableMap::COL_EXTERNAL_ID, $externalId, $comparison);
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
     * @return $this|ChildSCategoryVersionQuery The current query, for fluid interface
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

        return $this->addUsingAlias(SCategoryVersionTableMap::COL_URL, $url, $comparison);
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
     * @return $this|ChildSCategoryVersionQuery The current query, for fluid interface
     */
    public function filterByActive($active = null, $comparison = null)
    {
        if (is_string($active)) {
            $active = in_array(strtolower($active), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(SCategoryVersionTableMap::COL_ACTIVE, $active, $comparison);
    }

    /**
     * Filter the query on the image column
     *
     * Example usage:
     * <code>
     * $query->filterByImage('fooValue');   // WHERE image = 'fooValue'
     * $query->filterByImage('%fooValue%'); // WHERE image LIKE '%fooValue%'
     * </code>
     *
     * @param     string $image The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSCategoryVersionQuery The current query, for fluid interface
     */
    public function filterByImage($image = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($image)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $image)) {
                $image = str_replace('*', '%', $image);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SCategoryVersionTableMap::COL_IMAGE, $image, $comparison);
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
     * @return $this|ChildSCategoryVersionQuery The current query, for fluid interface
     */
    public function filterByPosition($position = null, $comparison = null)
    {
        if (is_array($position)) {
            $useMinMax = false;
            if (isset($position['min'])) {
                $this->addUsingAlias(SCategoryVersionTableMap::COL_POSITION, $position['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($position['max'])) {
                $this->addUsingAlias(SCategoryVersionTableMap::COL_POSITION, $position['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SCategoryVersionTableMap::COL_POSITION, $position, $comparison);
    }

    /**
     * Filter the query on the full_path column
     *
     * Example usage:
     * <code>
     * $query->filterByFullPath('fooValue');   // WHERE full_path = 'fooValue'
     * $query->filterByFullPath('%fooValue%'); // WHERE full_path LIKE '%fooValue%'
     * </code>
     *
     * @param     string $fullPath The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSCategoryVersionQuery The current query, for fluid interface
     */
    public function filterByFullPath($fullPath = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($fullPath)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $fullPath)) {
                $fullPath = str_replace('*', '%', $fullPath);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SCategoryVersionTableMap::COL_FULL_PATH, $fullPath, $comparison);
    }

    /**
     * Filter the query on the full_path_ids column
     *
     * Example usage:
     * <code>
     * $query->filterByFullPathIds('fooValue');   // WHERE full_path_ids = 'fooValue'
     * $query->filterByFullPathIds('%fooValue%'); // WHERE full_path_ids LIKE '%fooValue%'
     * </code>
     *
     * @param     string $fullPathIds The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSCategoryVersionQuery The current query, for fluid interface
     */
    public function filterByFullPathIds($fullPathIds = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($fullPathIds)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $fullPathIds)) {
                $fullPathIds = str_replace('*', '%', $fullPathIds);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SCategoryVersionTableMap::COL_FULL_PATH_IDS, $fullPathIds, $comparison);
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
     * @return $this|ChildSCategoryVersionQuery The current query, for fluid interface
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

        return $this->addUsingAlias(SCategoryVersionTableMap::COL_TPL, $tpl, $comparison);
    }

    /**
     * Filter the query on the order_method column
     *
     * Example usage:
     * <code>
     * $query->filterByOrderMethod(1234); // WHERE order_method = 1234
     * $query->filterByOrderMethod(array(12, 34)); // WHERE order_method IN (12, 34)
     * $query->filterByOrderMethod(array('min' => 12)); // WHERE order_method > 12
     * </code>
     *
     * @param     mixed $orderMethod The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSCategoryVersionQuery The current query, for fluid interface
     */
    public function filterByOrderMethod($orderMethod = null, $comparison = null)
    {
        if (is_array($orderMethod)) {
            $useMinMax = false;
            if (isset($orderMethod['min'])) {
                $this->addUsingAlias(SCategoryVersionTableMap::COL_ORDER_METHOD, $orderMethod['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($orderMethod['max'])) {
                $this->addUsingAlias(SCategoryVersionTableMap::COL_ORDER_METHOD, $orderMethod['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SCategoryVersionTableMap::COL_ORDER_METHOD, $orderMethod, $comparison);
    }

    /**
     * Filter the query on the showsitetitle column
     *
     * Example usage:
     * <code>
     * $query->filterByShowsitetitle(1234); // WHERE showsitetitle = 1234
     * $query->filterByShowsitetitle(array(12, 34)); // WHERE showsitetitle IN (12, 34)
     * $query->filterByShowsitetitle(array('min' => 12)); // WHERE showsitetitle > 12
     * </code>
     *
     * @param     mixed $showsitetitle The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSCategoryVersionQuery The current query, for fluid interface
     */
    public function filterByShowsitetitle($showsitetitle = null, $comparison = null)
    {
        if (is_array($showsitetitle)) {
            $useMinMax = false;
            if (isset($showsitetitle['min'])) {
                $this->addUsingAlias(SCategoryVersionTableMap::COL_SHOWSITETITLE, $showsitetitle['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($showsitetitle['max'])) {
                $this->addUsingAlias(SCategoryVersionTableMap::COL_SHOWSITETITLE, $showsitetitle['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SCategoryVersionTableMap::COL_SHOWSITETITLE, $showsitetitle, $comparison);
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
     * @return $this|ChildSCategoryVersionQuery The current query, for fluid interface
     */
    public function filterByCreated($created = null, $comparison = null)
    {
        if (is_array($created)) {
            $useMinMax = false;
            if (isset($created['min'])) {
                $this->addUsingAlias(SCategoryVersionTableMap::COL_CREATED, $created['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($created['max'])) {
                $this->addUsingAlias(SCategoryVersionTableMap::COL_CREATED, $created['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SCategoryVersionTableMap::COL_CREATED, $created, $comparison);
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
     * @return $this|ChildSCategoryVersionQuery The current query, for fluid interface
     */
    public function filterByUpdated($updated = null, $comparison = null)
    {
        if (is_array($updated)) {
            $useMinMax = false;
            if (isset($updated['min'])) {
                $this->addUsingAlias(SCategoryVersionTableMap::COL_UPDATED, $updated['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updated['max'])) {
                $this->addUsingAlias(SCategoryVersionTableMap::COL_UPDATED, $updated['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SCategoryVersionTableMap::COL_UPDATED, $updated, $comparison);
    }

    /**
     * Filter the query on the version column
     *
     * Example usage:
     * <code>
     * $query->filterByVersion(1234); // WHERE version = 1234
     * $query->filterByVersion(array(12, 34)); // WHERE version IN (12, 34)
     * $query->filterByVersion(array('min' => 12)); // WHERE version > 12
     * </code>
     *
     * @param     mixed $version The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSCategoryVersionQuery The current query, for fluid interface
     */
    public function filterByVersion($version = null, $comparison = null)
    {
        if (is_array($version)) {
            $useMinMax = false;
            if (isset($version['min'])) {
                $this->addUsingAlias(SCategoryVersionTableMap::COL_VERSION, $version['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($version['max'])) {
                $this->addUsingAlias(SCategoryVersionTableMap::COL_VERSION, $version['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SCategoryVersionTableMap::COL_VERSION, $version, $comparison);
    }

    /**
     * Filter the query on the parent_id_version column
     *
     * Example usage:
     * <code>
     * $query->filterByParentIdVersion(1234); // WHERE parent_id_version = 1234
     * $query->filterByParentIdVersion(array(12, 34)); // WHERE parent_id_version IN (12, 34)
     * $query->filterByParentIdVersion(array('min' => 12)); // WHERE parent_id_version > 12
     * </code>
     *
     * @param     mixed $parentIdVersion The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSCategoryVersionQuery The current query, for fluid interface
     */
    public function filterByParentIdVersion($parentIdVersion = null, $comparison = null)
    {
        if (is_array($parentIdVersion)) {
            $useMinMax = false;
            if (isset($parentIdVersion['min'])) {
                $this->addUsingAlias(SCategoryVersionTableMap::COL_PARENT_ID_VERSION, $parentIdVersion['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($parentIdVersion['max'])) {
                $this->addUsingAlias(SCategoryVersionTableMap::COL_PARENT_ID_VERSION, $parentIdVersion['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SCategoryVersionTableMap::COL_PARENT_ID_VERSION, $parentIdVersion, $comparison);
    }

    /**
     * Filter the query on the shop_category_ids column
     *
     * @param     array $shopCategoryIds The values to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSCategoryVersionQuery The current query, for fluid interface
     */
    public function filterByShopCategoryIds($shopCategoryIds = null, $comparison = null)
    {
        $key = $this->getAliasedColName(SCategoryVersionTableMap::COL_SHOP_CATEGORY_IDS);
        if (null === $comparison || $comparison == Criteria::CONTAINS_ALL) {
            foreach ($shopCategoryIds as $value) {
                $value = '%| ' . $value . ' |%';
                if ($this->containsKey($key)) {
                    $this->addAnd($key, $value, Criteria::LIKE);
                } else {
                    $this->add($key, $value, Criteria::LIKE);
                }
            }

            return $this;
        } elseif ($comparison == Criteria::CONTAINS_SOME) {
            foreach ($shopCategoryIds as $value) {
                $value = '%| ' . $value . ' |%';
                if ($this->containsKey($key)) {
                    $this->addOr($key, $value, Criteria::LIKE);
                } else {
                    $this->add($key, $value, Criteria::LIKE);
                }
            }

            return $this;
        } elseif ($comparison == Criteria::CONTAINS_NONE) {
            foreach ($shopCategoryIds as $value) {
                $value = '%| ' . $value . ' |%';
                if ($this->containsKey($key)) {
                    $this->addAnd($key, $value, Criteria::NOT_LIKE);
                } else {
                    $this->add($key, $value, Criteria::NOT_LIKE);
                }
            }
            $this->addOr($key, null, Criteria::ISNULL);

            return $this;
        }

        return $this->addUsingAlias(SCategoryVersionTableMap::COL_SHOP_CATEGORY_IDS, $shopCategoryIds, $comparison);
    }

    /**
     * Filter the query on the shop_category_ids column
     * @param     mixed $shopCategoryIds The value to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::CONTAINS_ALL
     *
     * @return $this|ChildSCategoryVersionQuery The current query, for fluid interface
     */
    public function filterByShopCategoryId($shopCategoryIds = null, $comparison = null)
    {
        if (null === $comparison || $comparison == Criteria::CONTAINS_ALL) {
            if (is_scalar($shopCategoryIds)) {
                $shopCategoryIds = '%| ' . $shopCategoryIds . ' |%';
                $comparison = Criteria::LIKE;
            }
        } elseif ($comparison == Criteria::CONTAINS_NONE) {
            $shopCategoryIds = '%| ' . $shopCategoryIds . ' |%';
            $comparison = Criteria::NOT_LIKE;
            $key = $this->getAliasedColName(SCategoryVersionTableMap::COL_SHOP_CATEGORY_IDS);
            if ($this->containsKey($key)) {
                $this->addAnd($key, $shopCategoryIds, $comparison);
            } else {
                $this->addAnd($key, $shopCategoryIds, $comparison);
            }
            $this->addOr($key, null, Criteria::ISNULL);

            return $this;
        }

        return $this->addUsingAlias(SCategoryVersionTableMap::COL_SHOP_CATEGORY_IDS, $shopCategoryIds, $comparison);
    }

    /**
     * Filter the query on the shop_category_versions column
     *
     * @param     array $shopCategoryVersions The values to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSCategoryVersionQuery The current query, for fluid interface
     */
    public function filterByShopCategoryVersions($shopCategoryVersions = null, $comparison = null)
    {
        $key = $this->getAliasedColName(SCategoryVersionTableMap::COL_SHOP_CATEGORY_VERSIONS);
        if (null === $comparison || $comparison == Criteria::CONTAINS_ALL) {
            foreach ($shopCategoryVersions as $value) {
                $value = '%| ' . $value . ' |%';
                if ($this->containsKey($key)) {
                    $this->addAnd($key, $value, Criteria::LIKE);
                } else {
                    $this->add($key, $value, Criteria::LIKE);
                }
            }

            return $this;
        } elseif ($comparison == Criteria::CONTAINS_SOME) {
            foreach ($shopCategoryVersions as $value) {
                $value = '%| ' . $value . ' |%';
                if ($this->containsKey($key)) {
                    $this->addOr($key, $value, Criteria::LIKE);
                } else {
                    $this->add($key, $value, Criteria::LIKE);
                }
            }

            return $this;
        } elseif ($comparison == Criteria::CONTAINS_NONE) {
            foreach ($shopCategoryVersions as $value) {
                $value = '%| ' . $value . ' |%';
                if ($this->containsKey($key)) {
                    $this->addAnd($key, $value, Criteria::NOT_LIKE);
                } else {
                    $this->add($key, $value, Criteria::NOT_LIKE);
                }
            }
            $this->addOr($key, null, Criteria::ISNULL);

            return $this;
        }

        return $this->addUsingAlias(SCategoryVersionTableMap::COL_SHOP_CATEGORY_VERSIONS, $shopCategoryVersions, $comparison);
    }

    /**
     * Filter the query on the shop_category_versions column
     * @param     mixed $shopCategoryVersions The value to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::CONTAINS_ALL
     *
     * @return $this|ChildSCategoryVersionQuery The current query, for fluid interface
     */
    public function filterByShopCategoryVersion($shopCategoryVersions = null, $comparison = null)
    {
        if (null === $comparison || $comparison == Criteria::CONTAINS_ALL) {
            if (is_scalar($shopCategoryVersions)) {
                $shopCategoryVersions = '%| ' . $shopCategoryVersions . ' |%';
                $comparison = Criteria::LIKE;
            }
        } elseif ($comparison == Criteria::CONTAINS_NONE) {
            $shopCategoryVersions = '%| ' . $shopCategoryVersions . ' |%';
            $comparison = Criteria::NOT_LIKE;
            $key = $this->getAliasedColName(SCategoryVersionTableMap::COL_SHOP_CATEGORY_VERSIONS);
            if ($this->containsKey($key)) {
                $this->addAnd($key, $shopCategoryVersions, $comparison);
            } else {
                $this->addAnd($key, $shopCategoryVersions, $comparison);
            }
            $this->addOr($key, null, Criteria::ISNULL);

            return $this;
        }

        return $this->addUsingAlias(SCategoryVersionTableMap::COL_SHOP_CATEGORY_VERSIONS, $shopCategoryVersions, $comparison);
    }

    /**
     * Filter the query by a related \SCategory object
     *
     * @param \SCategory|ObjectCollection $sCategory The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildSCategoryVersionQuery The current query, for fluid interface
     */
    public function filterBySCategory($sCategory, $comparison = null)
    {
        if ($sCategory instanceof \SCategory) {
            return $this
                ->addUsingAlias(SCategoryVersionTableMap::COL_ID, $sCategory->getId(), $comparison);
        } elseif ($sCategory instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(SCategoryVersionTableMap::COL_ID, $sCategory->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterBySCategory() only accepts arguments of type \SCategory or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the SCategory relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSCategoryVersionQuery The current query, for fluid interface
     */
    public function joinSCategory($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('SCategory');

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
            $this->addJoinObject($join, 'SCategory');
        }

        return $this;
    }

    /**
     * Use the SCategory relation SCategory object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \SCategoryQuery A secondary query class using the current class as primary query
     */
    public function useSCategoryQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinSCategory($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'SCategory', '\SCategoryQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildSCategoryVersion $sCategoryVersion Object to remove from the list of results
     *
     * @return $this|ChildSCategoryVersionQuery The current query, for fluid interface
     */
    public function prune($sCategoryVersion = null)
    {
        if ($sCategoryVersion) {
            $this->addCond('pruneCond0', $this->getAliasedColName(SCategoryVersionTableMap::COL_ID), $sCategoryVersion->getId(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(SCategoryVersionTableMap::COL_VERSION), $sCategoryVersion->getVersion(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the shop_category_version table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SCategoryVersionTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            SCategoryVersionTableMap::clearInstancePool();
            SCategoryVersionTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(SCategoryVersionTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(SCategoryVersionTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            SCategoryVersionTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            SCategoryVersionTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // SCategoryVersionQuery
