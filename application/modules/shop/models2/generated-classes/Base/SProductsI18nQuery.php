<?php

namespace Base;

use \SProductsI18n as ChildSProductsI18n;
use \SProductsI18nQuery as ChildSProductsI18nQuery;
use \Exception;
use \PDO;
use Map\SProductsI18nTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'shop_products_i18n' table.
 *
 *
 *
 * @method     ChildSProductsI18nQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildSProductsI18nQuery orderByLocale($order = Criteria::ASC) Order by the locale column
 * @method     ChildSProductsI18nQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method     ChildSProductsI18nQuery orderByShortDescription($order = Criteria::ASC) Order by the short_description column
 * @method     ChildSProductsI18nQuery orderByFullDescription($order = Criteria::ASC) Order by the full_description column
 * @method     ChildSProductsI18nQuery orderByMetaTitle($order = Criteria::ASC) Order by the meta_title column
 * @method     ChildSProductsI18nQuery orderByMetaDescription($order = Criteria::ASC) Order by the meta_description column
 * @method     ChildSProductsI18nQuery orderByMetaKeywords($order = Criteria::ASC) Order by the meta_keywords column
 *
 * @method     ChildSProductsI18nQuery groupById() Group by the id column
 * @method     ChildSProductsI18nQuery groupByLocale() Group by the locale column
 * @method     ChildSProductsI18nQuery groupByName() Group by the name column
 * @method     ChildSProductsI18nQuery groupByShortDescription() Group by the short_description column
 * @method     ChildSProductsI18nQuery groupByFullDescription() Group by the full_description column
 * @method     ChildSProductsI18nQuery groupByMetaTitle() Group by the meta_title column
 * @method     ChildSProductsI18nQuery groupByMetaDescription() Group by the meta_description column
 * @method     ChildSProductsI18nQuery groupByMetaKeywords() Group by the meta_keywords column
 *
 * @method     ChildSProductsI18nQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildSProductsI18nQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildSProductsI18nQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildSProductsI18nQuery leftJoinSProducts($relationAlias = null) Adds a LEFT JOIN clause to the query using the SProducts relation
 * @method     ChildSProductsI18nQuery rightJoinSProducts($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SProducts relation
 * @method     ChildSProductsI18nQuery innerJoinSProducts($relationAlias = null) Adds a INNER JOIN clause to the query using the SProducts relation
 *
 * @method     \SProductsQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildSProductsI18n findOne(ConnectionInterface $con = null) Return the first ChildSProductsI18n matching the query
 * @method     ChildSProductsI18n findOneOrCreate(ConnectionInterface $con = null) Return the first ChildSProductsI18n matching the query, or a new ChildSProductsI18n object populated from the query conditions when no match is found
 *
 * @method     ChildSProductsI18n findOneById(int $id) Return the first ChildSProductsI18n filtered by the id column
 * @method     ChildSProductsI18n findOneByLocale(string $locale) Return the first ChildSProductsI18n filtered by the locale column
 * @method     ChildSProductsI18n findOneByName(string $name) Return the first ChildSProductsI18n filtered by the name column
 * @method     ChildSProductsI18n findOneByShortDescription(string $short_description) Return the first ChildSProductsI18n filtered by the short_description column
 * @method     ChildSProductsI18n findOneByFullDescription(string $full_description) Return the first ChildSProductsI18n filtered by the full_description column
 * @method     ChildSProductsI18n findOneByMetaTitle(string $meta_title) Return the first ChildSProductsI18n filtered by the meta_title column
 * @method     ChildSProductsI18n findOneByMetaDescription(string $meta_description) Return the first ChildSProductsI18n filtered by the meta_description column
 * @method     ChildSProductsI18n findOneByMetaKeywords(string $meta_keywords) Return the first ChildSProductsI18n filtered by the meta_keywords column *

 * @method     ChildSProductsI18n requirePk($key, ConnectionInterface $con = null) Return the ChildSProductsI18n by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSProductsI18n requireOne(ConnectionInterface $con = null) Return the first ChildSProductsI18n matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSProductsI18n requireOneById(int $id) Return the first ChildSProductsI18n filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSProductsI18n requireOneByLocale(string $locale) Return the first ChildSProductsI18n filtered by the locale column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSProductsI18n requireOneByName(string $name) Return the first ChildSProductsI18n filtered by the name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSProductsI18n requireOneByShortDescription(string $short_description) Return the first ChildSProductsI18n filtered by the short_description column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSProductsI18n requireOneByFullDescription(string $full_description) Return the first ChildSProductsI18n filtered by the full_description column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSProductsI18n requireOneByMetaTitle(string $meta_title) Return the first ChildSProductsI18n filtered by the meta_title column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSProductsI18n requireOneByMetaDescription(string $meta_description) Return the first ChildSProductsI18n filtered by the meta_description column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSProductsI18n requireOneByMetaKeywords(string $meta_keywords) Return the first ChildSProductsI18n filtered by the meta_keywords column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSProductsI18n[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildSProductsI18n objects based on current ModelCriteria
 * @method     ChildSProductsI18n[]|ObjectCollection findById(int $id) Return ChildSProductsI18n objects filtered by the id column
 * @method     ChildSProductsI18n[]|ObjectCollection findByLocale(string $locale) Return ChildSProductsI18n objects filtered by the locale column
 * @method     ChildSProductsI18n[]|ObjectCollection findByName(string $name) Return ChildSProductsI18n objects filtered by the name column
 * @method     ChildSProductsI18n[]|ObjectCollection findByShortDescription(string $short_description) Return ChildSProductsI18n objects filtered by the short_description column
 * @method     ChildSProductsI18n[]|ObjectCollection findByFullDescription(string $full_description) Return ChildSProductsI18n objects filtered by the full_description column
 * @method     ChildSProductsI18n[]|ObjectCollection findByMetaTitle(string $meta_title) Return ChildSProductsI18n objects filtered by the meta_title column
 * @method     ChildSProductsI18n[]|ObjectCollection findByMetaDescription(string $meta_description) Return ChildSProductsI18n objects filtered by the meta_description column
 * @method     ChildSProductsI18n[]|ObjectCollection findByMetaKeywords(string $meta_keywords) Return ChildSProductsI18n objects filtered by the meta_keywords column
 * @method     ChildSProductsI18n[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class SProductsI18nQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\SProductsI18nQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'Shop', $modelName = '\\SProductsI18n', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildSProductsI18nQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildSProductsI18nQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildSProductsI18nQuery) {
            return $criteria;
        }
        $query = new ChildSProductsI18nQuery();
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
     * @param array[$id, $locale] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildSProductsI18n|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = SProductsI18nTableMap::getInstanceFromPool(serialize(array((string) $key[0], (string) $key[1]))))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(SProductsI18nTableMap::DATABASE_NAME);
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
     * @return ChildSProductsI18n A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, locale, name, short_description, full_description, meta_title, meta_description, meta_keywords FROM shop_products_i18n WHERE id = :p0 AND locale = :p1';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key[0], PDO::PARAM_INT);
            $stmt->bindValue(':p1', $key[1], PDO::PARAM_STR);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildSProductsI18n $obj */
            $obj = new ChildSProductsI18n();
            $obj->hydrate($row);
            SProductsI18nTableMap::addInstanceToPool($obj, serialize(array((string) $key[0], (string) $key[1])));
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
     * @return ChildSProductsI18n|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildSProductsI18nQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(SProductsI18nTableMap::COL_ID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(SProductsI18nTableMap::COL_LOCALE, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildSProductsI18nQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(SProductsI18nTableMap::COL_ID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(SProductsI18nTableMap::COL_LOCALE, $key[1], Criteria::EQUAL);
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
     * @see       filterBySProducts()
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSProductsI18nQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(SProductsI18nTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(SProductsI18nTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SProductsI18nTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the locale column
     *
     * Example usage:
     * <code>
     * $query->filterByLocale('fooValue');   // WHERE locale = 'fooValue'
     * $query->filterByLocale('%fooValue%'); // WHERE locale LIKE '%fooValue%'
     * </code>
     *
     * @param     string $locale The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSProductsI18nQuery The current query, for fluid interface
     */
    public function filterByLocale($locale = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($locale)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $locale)) {
                $locale = str_replace('*', '%', $locale);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SProductsI18nTableMap::COL_LOCALE, $locale, $comparison);
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
     * @return $this|ChildSProductsI18nQuery The current query, for fluid interface
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

        return $this->addUsingAlias(SProductsI18nTableMap::COL_NAME, $name, $comparison);
    }

    /**
     * Filter the query on the short_description column
     *
     * Example usage:
     * <code>
     * $query->filterByShortDescription('fooValue');   // WHERE short_description = 'fooValue'
     * $query->filterByShortDescription('%fooValue%'); // WHERE short_description LIKE '%fooValue%'
     * </code>
     *
     * @param     string $shortDescription The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSProductsI18nQuery The current query, for fluid interface
     */
    public function filterByShortDescription($shortDescription = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($shortDescription)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $shortDescription)) {
                $shortDescription = str_replace('*', '%', $shortDescription);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SProductsI18nTableMap::COL_SHORT_DESCRIPTION, $shortDescription, $comparison);
    }

    /**
     * Filter the query on the full_description column
     *
     * Example usage:
     * <code>
     * $query->filterByFullDescription('fooValue');   // WHERE full_description = 'fooValue'
     * $query->filterByFullDescription('%fooValue%'); // WHERE full_description LIKE '%fooValue%'
     * </code>
     *
     * @param     string $fullDescription The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSProductsI18nQuery The current query, for fluid interface
     */
    public function filterByFullDescription($fullDescription = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($fullDescription)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $fullDescription)) {
                $fullDescription = str_replace('*', '%', $fullDescription);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SProductsI18nTableMap::COL_FULL_DESCRIPTION, $fullDescription, $comparison);
    }

    /**
     * Filter the query on the meta_title column
     *
     * Example usage:
     * <code>
     * $query->filterByMetaTitle('fooValue');   // WHERE meta_title = 'fooValue'
     * $query->filterByMetaTitle('%fooValue%'); // WHERE meta_title LIKE '%fooValue%'
     * </code>
     *
     * @param     string $metaTitle The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSProductsI18nQuery The current query, for fluid interface
     */
    public function filterByMetaTitle($metaTitle = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($metaTitle)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $metaTitle)) {
                $metaTitle = str_replace('*', '%', $metaTitle);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SProductsI18nTableMap::COL_META_TITLE, $metaTitle, $comparison);
    }

    /**
     * Filter the query on the meta_description column
     *
     * Example usage:
     * <code>
     * $query->filterByMetaDescription('fooValue');   // WHERE meta_description = 'fooValue'
     * $query->filterByMetaDescription('%fooValue%'); // WHERE meta_description LIKE '%fooValue%'
     * </code>
     *
     * @param     string $metaDescription The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSProductsI18nQuery The current query, for fluid interface
     */
    public function filterByMetaDescription($metaDescription = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($metaDescription)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $metaDescription)) {
                $metaDescription = str_replace('*', '%', $metaDescription);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SProductsI18nTableMap::COL_META_DESCRIPTION, $metaDescription, $comparison);
    }

    /**
     * Filter the query on the meta_keywords column
     *
     * Example usage:
     * <code>
     * $query->filterByMetaKeywords('fooValue');   // WHERE meta_keywords = 'fooValue'
     * $query->filterByMetaKeywords('%fooValue%'); // WHERE meta_keywords LIKE '%fooValue%'
     * </code>
     *
     * @param     string $metaKeywords The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSProductsI18nQuery The current query, for fluid interface
     */
    public function filterByMetaKeywords($metaKeywords = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($metaKeywords)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $metaKeywords)) {
                $metaKeywords = str_replace('*', '%', $metaKeywords);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SProductsI18nTableMap::COL_META_KEYWORDS, $metaKeywords, $comparison);
    }

    /**
     * Filter the query by a related \SProducts object
     *
     * @param \SProducts|ObjectCollection $sProducts The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildSProductsI18nQuery The current query, for fluid interface
     */
    public function filterBySProducts($sProducts, $comparison = null)
    {
        if ($sProducts instanceof \SProducts) {
            return $this
                ->addUsingAlias(SProductsI18nTableMap::COL_ID, $sProducts->getId(), $comparison);
        } elseif ($sProducts instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(SProductsI18nTableMap::COL_ID, $sProducts->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildSProductsI18nQuery The current query, for fluid interface
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
     * Exclude object from result
     *
     * @param   ChildSProductsI18n $sProductsI18n Object to remove from the list of results
     *
     * @return $this|ChildSProductsI18nQuery The current query, for fluid interface
     */
    public function prune($sProductsI18n = null)
    {
        if ($sProductsI18n) {
            $this->addCond('pruneCond0', $this->getAliasedColName(SProductsI18nTableMap::COL_ID), $sProductsI18n->getId(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(SProductsI18nTableMap::COL_LOCALE), $sProductsI18n->getLocale(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the shop_products_i18n table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SProductsI18nTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            SProductsI18nTableMap::clearInstancePool();
            SProductsI18nTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(SProductsI18nTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(SProductsI18nTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            SProductsI18nTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            SProductsI18nTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // SProductsI18nQuery
