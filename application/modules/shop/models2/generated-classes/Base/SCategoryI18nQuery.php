<?php

namespace Base;

use \SCategoryI18n as ChildSCategoryI18n;
use \SCategoryI18nQuery as ChildSCategoryI18nQuery;
use \Exception;
use \PDO;
use Map\SCategoryI18nTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'shop_category_i18n' table.
 *
 *
 *
 * @method     ChildSCategoryI18nQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildSCategoryI18nQuery orderByLocale($order = Criteria::ASC) Order by the locale column
 * @method     ChildSCategoryI18nQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method     ChildSCategoryI18nQuery orderByH1($order = Criteria::ASC) Order by the h1 column
 * @method     ChildSCategoryI18nQuery orderByDescription($order = Criteria::ASC) Order by the description column
 * @method     ChildSCategoryI18nQuery orderByMetaDesc($order = Criteria::ASC) Order by the meta_desc column
 * @method     ChildSCategoryI18nQuery orderByMetaTitle($order = Criteria::ASC) Order by the meta_title column
 * @method     ChildSCategoryI18nQuery orderByMetaKeywords($order = Criteria::ASC) Order by the meta_keywords column
 *
 * @method     ChildSCategoryI18nQuery groupById() Group by the id column
 * @method     ChildSCategoryI18nQuery groupByLocale() Group by the locale column
 * @method     ChildSCategoryI18nQuery groupByName() Group by the name column
 * @method     ChildSCategoryI18nQuery groupByH1() Group by the h1 column
 * @method     ChildSCategoryI18nQuery groupByDescription() Group by the description column
 * @method     ChildSCategoryI18nQuery groupByMetaDesc() Group by the meta_desc column
 * @method     ChildSCategoryI18nQuery groupByMetaTitle() Group by the meta_title column
 * @method     ChildSCategoryI18nQuery groupByMetaKeywords() Group by the meta_keywords column
 *
 * @method     ChildSCategoryI18nQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildSCategoryI18nQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildSCategoryI18nQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildSCategoryI18nQuery leftJoinSCategory($relationAlias = null) Adds a LEFT JOIN clause to the query using the SCategory relation
 * @method     ChildSCategoryI18nQuery rightJoinSCategory($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SCategory relation
 * @method     ChildSCategoryI18nQuery innerJoinSCategory($relationAlias = null) Adds a INNER JOIN clause to the query using the SCategory relation
 *
 * @method     \SCategoryQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildSCategoryI18n findOne(ConnectionInterface $con = null) Return the first ChildSCategoryI18n matching the query
 * @method     ChildSCategoryI18n findOneOrCreate(ConnectionInterface $con = null) Return the first ChildSCategoryI18n matching the query, or a new ChildSCategoryI18n object populated from the query conditions when no match is found
 *
 * @method     ChildSCategoryI18n findOneById(int $id) Return the first ChildSCategoryI18n filtered by the id column
 * @method     ChildSCategoryI18n findOneByLocale(string $locale) Return the first ChildSCategoryI18n filtered by the locale column
 * @method     ChildSCategoryI18n findOneByName(string $name) Return the first ChildSCategoryI18n filtered by the name column
 * @method     ChildSCategoryI18n findOneByH1(string $h1) Return the first ChildSCategoryI18n filtered by the h1 column
 * @method     ChildSCategoryI18n findOneByDescription(string $description) Return the first ChildSCategoryI18n filtered by the description column
 * @method     ChildSCategoryI18n findOneByMetaDesc(string $meta_desc) Return the first ChildSCategoryI18n filtered by the meta_desc column
 * @method     ChildSCategoryI18n findOneByMetaTitle(string $meta_title) Return the first ChildSCategoryI18n filtered by the meta_title column
 * @method     ChildSCategoryI18n findOneByMetaKeywords(string $meta_keywords) Return the first ChildSCategoryI18n filtered by the meta_keywords column *

 * @method     ChildSCategoryI18n requirePk($key, ConnectionInterface $con = null) Return the ChildSCategoryI18n by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSCategoryI18n requireOne(ConnectionInterface $con = null) Return the first ChildSCategoryI18n matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSCategoryI18n requireOneById(int $id) Return the first ChildSCategoryI18n filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSCategoryI18n requireOneByLocale(string $locale) Return the first ChildSCategoryI18n filtered by the locale column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSCategoryI18n requireOneByName(string $name) Return the first ChildSCategoryI18n filtered by the name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSCategoryI18n requireOneByH1(string $h1) Return the first ChildSCategoryI18n filtered by the h1 column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSCategoryI18n requireOneByDescription(string $description) Return the first ChildSCategoryI18n filtered by the description column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSCategoryI18n requireOneByMetaDesc(string $meta_desc) Return the first ChildSCategoryI18n filtered by the meta_desc column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSCategoryI18n requireOneByMetaTitle(string $meta_title) Return the first ChildSCategoryI18n filtered by the meta_title column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSCategoryI18n requireOneByMetaKeywords(string $meta_keywords) Return the first ChildSCategoryI18n filtered by the meta_keywords column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSCategoryI18n[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildSCategoryI18n objects based on current ModelCriteria
 * @method     ChildSCategoryI18n[]|ObjectCollection findById(int $id) Return ChildSCategoryI18n objects filtered by the id column
 * @method     ChildSCategoryI18n[]|ObjectCollection findByLocale(string $locale) Return ChildSCategoryI18n objects filtered by the locale column
 * @method     ChildSCategoryI18n[]|ObjectCollection findByName(string $name) Return ChildSCategoryI18n objects filtered by the name column
 * @method     ChildSCategoryI18n[]|ObjectCollection findByH1(string $h1) Return ChildSCategoryI18n objects filtered by the h1 column
 * @method     ChildSCategoryI18n[]|ObjectCollection findByDescription(string $description) Return ChildSCategoryI18n objects filtered by the description column
 * @method     ChildSCategoryI18n[]|ObjectCollection findByMetaDesc(string $meta_desc) Return ChildSCategoryI18n objects filtered by the meta_desc column
 * @method     ChildSCategoryI18n[]|ObjectCollection findByMetaTitle(string $meta_title) Return ChildSCategoryI18n objects filtered by the meta_title column
 * @method     ChildSCategoryI18n[]|ObjectCollection findByMetaKeywords(string $meta_keywords) Return ChildSCategoryI18n objects filtered by the meta_keywords column
 * @method     ChildSCategoryI18n[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class SCategoryI18nQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\SCategoryI18nQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'Shop', $modelName = '\\SCategoryI18n', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildSCategoryI18nQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildSCategoryI18nQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildSCategoryI18nQuery) {
            return $criteria;
        }
        $query = new ChildSCategoryI18nQuery();
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
     * @return ChildSCategoryI18n|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = SCategoryI18nTableMap::getInstanceFromPool(serialize(array((string) $key[0], (string) $key[1]))))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(SCategoryI18nTableMap::DATABASE_NAME);
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
     * @return ChildSCategoryI18n A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, locale, name, h1, description, meta_desc, meta_title, meta_keywords FROM shop_category_i18n WHERE id = :p0 AND locale = :p1';
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
            /** @var ChildSCategoryI18n $obj */
            $obj = new ChildSCategoryI18n();
            $obj->hydrate($row);
            SCategoryI18nTableMap::addInstanceToPool($obj, serialize(array((string) $key[0], (string) $key[1])));
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
     * @return ChildSCategoryI18n|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildSCategoryI18nQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(SCategoryI18nTableMap::COL_ID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(SCategoryI18nTableMap::COL_LOCALE, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildSCategoryI18nQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(SCategoryI18nTableMap::COL_ID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(SCategoryI18nTableMap::COL_LOCALE, $key[1], Criteria::EQUAL);
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
     * @return $this|ChildSCategoryI18nQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(SCategoryI18nTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(SCategoryI18nTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SCategoryI18nTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildSCategoryI18nQuery The current query, for fluid interface
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

        return $this->addUsingAlias(SCategoryI18nTableMap::COL_LOCALE, $locale, $comparison);
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
     * @return $this|ChildSCategoryI18nQuery The current query, for fluid interface
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

        return $this->addUsingAlias(SCategoryI18nTableMap::COL_NAME, $name, $comparison);
    }

    /**
     * Filter the query on the h1 column
     *
     * Example usage:
     * <code>
     * $query->filterByH1('fooValue');   // WHERE h1 = 'fooValue'
     * $query->filterByH1('%fooValue%'); // WHERE h1 LIKE '%fooValue%'
     * </code>
     *
     * @param     string $h1 The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSCategoryI18nQuery The current query, for fluid interface
     */
    public function filterByH1($h1 = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($h1)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $h1)) {
                $h1 = str_replace('*', '%', $h1);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SCategoryI18nTableMap::COL_H1, $h1, $comparison);
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
     * @return $this|ChildSCategoryI18nQuery The current query, for fluid interface
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

        return $this->addUsingAlias(SCategoryI18nTableMap::COL_DESCRIPTION, $description, $comparison);
    }

    /**
     * Filter the query on the meta_desc column
     *
     * Example usage:
     * <code>
     * $query->filterByMetaDesc('fooValue');   // WHERE meta_desc = 'fooValue'
     * $query->filterByMetaDesc('%fooValue%'); // WHERE meta_desc LIKE '%fooValue%'
     * </code>
     *
     * @param     string $metaDesc The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSCategoryI18nQuery The current query, for fluid interface
     */
    public function filterByMetaDesc($metaDesc = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($metaDesc)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $metaDesc)) {
                $metaDesc = str_replace('*', '%', $metaDesc);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SCategoryI18nTableMap::COL_META_DESC, $metaDesc, $comparison);
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
     * @return $this|ChildSCategoryI18nQuery The current query, for fluid interface
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

        return $this->addUsingAlias(SCategoryI18nTableMap::COL_META_TITLE, $metaTitle, $comparison);
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
     * @return $this|ChildSCategoryI18nQuery The current query, for fluid interface
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

        return $this->addUsingAlias(SCategoryI18nTableMap::COL_META_KEYWORDS, $metaKeywords, $comparison);
    }

    /**
     * Filter the query by a related \SCategory object
     *
     * @param \SCategory|ObjectCollection $sCategory The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildSCategoryI18nQuery The current query, for fluid interface
     */
    public function filterBySCategory($sCategory, $comparison = null)
    {
        if ($sCategory instanceof \SCategory) {
            return $this
                ->addUsingAlias(SCategoryI18nTableMap::COL_ID, $sCategory->getId(), $comparison);
        } elseif ($sCategory instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(SCategoryI18nTableMap::COL_ID, $sCategory->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildSCategoryI18nQuery The current query, for fluid interface
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
     * @param   ChildSCategoryI18n $sCategoryI18n Object to remove from the list of results
     *
     * @return $this|ChildSCategoryI18nQuery The current query, for fluid interface
     */
    public function prune($sCategoryI18n = null)
    {
        if ($sCategoryI18n) {
            $this->addCond('pruneCond0', $this->getAliasedColName(SCategoryI18nTableMap::COL_ID), $sCategoryI18n->getId(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(SCategoryI18nTableMap::COL_LOCALE), $sCategoryI18n->getLocale(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the shop_category_i18n table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SCategoryI18nTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            SCategoryI18nTableMap::clearInstancePool();
            SCategoryI18nTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(SCategoryI18nTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(SCategoryI18nTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            SCategoryI18nTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            SCategoryI18nTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // SCategoryI18nQuery
