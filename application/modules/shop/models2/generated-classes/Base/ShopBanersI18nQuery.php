<?php

namespace Base;

use \ShopBanersI18n as ChildShopBanersI18n;
use \ShopBanersI18nQuery as ChildShopBanersI18nQuery;
use \Exception;
use \PDO;
use Map\ShopBanersI18nTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'shop_banners_i18n' table.
 *
 *
 *
 * @method     ChildShopBanersI18nQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildShopBanersI18nQuery orderByLocale($order = Criteria::ASC) Order by the locale column
 * @method     ChildShopBanersI18nQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method     ChildShopBanersI18nQuery orderByText($order = Criteria::ASC) Order by the text column
 * @method     ChildShopBanersI18nQuery orderByUrl($order = Criteria::ASC) Order by the url column
 * @method     ChildShopBanersI18nQuery orderByImage($order = Criteria::ASC) Order by the image column
 *
 * @method     ChildShopBanersI18nQuery groupById() Group by the id column
 * @method     ChildShopBanersI18nQuery groupByLocale() Group by the locale column
 * @method     ChildShopBanersI18nQuery groupByName() Group by the name column
 * @method     ChildShopBanersI18nQuery groupByText() Group by the text column
 * @method     ChildShopBanersI18nQuery groupByUrl() Group by the url column
 * @method     ChildShopBanersI18nQuery groupByImage() Group by the image column
 *
 * @method     ChildShopBanersI18nQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildShopBanersI18nQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildShopBanersI18nQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildShopBanersI18nQuery leftJoinShopBaners($relationAlias = null) Adds a LEFT JOIN clause to the query using the ShopBaners relation
 * @method     ChildShopBanersI18nQuery rightJoinShopBaners($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ShopBaners relation
 * @method     ChildShopBanersI18nQuery innerJoinShopBaners($relationAlias = null) Adds a INNER JOIN clause to the query using the ShopBaners relation
 *
 * @method     \ShopBanersQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildShopBanersI18n findOne(ConnectionInterface $con = null) Return the first ChildShopBanersI18n matching the query
 * @method     ChildShopBanersI18n findOneOrCreate(ConnectionInterface $con = null) Return the first ChildShopBanersI18n matching the query, or a new ChildShopBanersI18n object populated from the query conditions when no match is found
 *
 * @method     ChildShopBanersI18n findOneById(int $id) Return the first ChildShopBanersI18n filtered by the id column
 * @method     ChildShopBanersI18n findOneByLocale(string $locale) Return the first ChildShopBanersI18n filtered by the locale column
 * @method     ChildShopBanersI18n findOneByName(string $name) Return the first ChildShopBanersI18n filtered by the name column
 * @method     ChildShopBanersI18n findOneByText(string $text) Return the first ChildShopBanersI18n filtered by the text column
 * @method     ChildShopBanersI18n findOneByUrl(string $url) Return the first ChildShopBanersI18n filtered by the url column
 * @method     ChildShopBanersI18n findOneByImage(string $image) Return the first ChildShopBanersI18n filtered by the image column
 *
 * @method     ChildShopBanersI18n[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildShopBanersI18n objects based on current ModelCriteria
 * @method     ChildShopBanersI18n[]|ObjectCollection findById(int $id) Return ChildShopBanersI18n objects filtered by the id column
 * @method     ChildShopBanersI18n[]|ObjectCollection findByLocale(string $locale) Return ChildShopBanersI18n objects filtered by the locale column
 * @method     ChildShopBanersI18n[]|ObjectCollection findByName(string $name) Return ChildShopBanersI18n objects filtered by the name column
 * @method     ChildShopBanersI18n[]|ObjectCollection findByText(string $text) Return ChildShopBanersI18n objects filtered by the text column
 * @method     ChildShopBanersI18n[]|ObjectCollection findByUrl(string $url) Return ChildShopBanersI18n objects filtered by the url column
 * @method     ChildShopBanersI18n[]|ObjectCollection findByImage(string $image) Return ChildShopBanersI18n objects filtered by the image column
 * @method     ChildShopBanersI18n[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class ShopBanersI18nQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \Base\ShopBanersI18nQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'Shop', $modelName = '\\ShopBanersI18n', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildShopBanersI18nQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildShopBanersI18nQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildShopBanersI18nQuery) {
            return $criteria;
        }
        $query = new ChildShopBanersI18nQuery();
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
     * @return ChildShopBanersI18n|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ShopBanersI18nTableMap::getInstanceFromPool(serialize(array((string) $key[0], (string) $key[1]))))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ShopBanersI18nTableMap::DATABASE_NAME);
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
     * @return ChildShopBanersI18n A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, locale, name, text, url, image FROM shop_banners_i18n WHERE id = :p0 AND locale = :p1';
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
            /** @var ChildShopBanersI18n $obj */
            $obj = new ChildShopBanersI18n();
            $obj->hydrate($row);
            ShopBanersI18nTableMap::addInstanceToPool($obj, serialize(array((string) $key[0], (string) $key[1])));
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
     * @return ChildShopBanersI18n|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildShopBanersI18nQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(ShopBanersI18nTableMap::COL_ID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(ShopBanersI18nTableMap::COL_LOCALE, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildShopBanersI18nQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(ShopBanersI18nTableMap::COL_ID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(ShopBanersI18nTableMap::COL_LOCALE, $key[1], Criteria::EQUAL);
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
     * @see       filterByShopBaners()
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildShopBanersI18nQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(ShopBanersI18nTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(ShopBanersI18nTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ShopBanersI18nTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildShopBanersI18nQuery The current query, for fluid interface
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

        return $this->addUsingAlias(ShopBanersI18nTableMap::COL_LOCALE, $locale, $comparison);
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
     * @return $this|ChildShopBanersI18nQuery The current query, for fluid interface
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

        return $this->addUsingAlias(ShopBanersI18nTableMap::COL_NAME, $name, $comparison);
    }

    /**
     * Filter the query on the text column
     *
     * Example usage:
     * <code>
     * $query->filterByText('fooValue');   // WHERE text = 'fooValue'
     * $query->filterByText('%fooValue%'); // WHERE text LIKE '%fooValue%'
     * </code>
     *
     * @param     string $text The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildShopBanersI18nQuery The current query, for fluid interface
     */
    public function filterByText($text = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($text)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $text)) {
                $text = str_replace('*', '%', $text);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ShopBanersI18nTableMap::COL_TEXT, $text, $comparison);
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
     * @return $this|ChildShopBanersI18nQuery The current query, for fluid interface
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

        return $this->addUsingAlias(ShopBanersI18nTableMap::COL_URL, $url, $comparison);
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
     * @return $this|ChildShopBanersI18nQuery The current query, for fluid interface
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

        return $this->addUsingAlias(ShopBanersI18nTableMap::COL_IMAGE, $image, $comparison);
    }

    /**
     * Filter the query by a related \ShopBaners object
     *
     * @param \ShopBaners|ObjectCollection $shopBaners The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildShopBanersI18nQuery The current query, for fluid interface
     */
    public function filterByShopBaners($shopBaners, $comparison = null)
    {
        if ($shopBaners instanceof \ShopBaners) {
            return $this
                ->addUsingAlias(ShopBanersI18nTableMap::COL_ID, $shopBaners->getId(), $comparison);
        } elseif ($shopBaners instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ShopBanersI18nTableMap::COL_ID, $shopBaners->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByShopBaners() only accepts arguments of type \ShopBaners or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ShopBaners relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildShopBanersI18nQuery The current query, for fluid interface
     */
    public function joinShopBaners($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ShopBaners');

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
            $this->addJoinObject($join, 'ShopBaners');
        }

        return $this;
    }

    /**
     * Use the ShopBaners relation ShopBaners object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ShopBanersQuery A secondary query class using the current class as primary query
     */
    public function useShopBanersQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinShopBaners($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ShopBaners', '\ShopBanersQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildShopBanersI18n $shopBanersI18n Object to remove from the list of results
     *
     * @return $this|ChildShopBanersI18nQuery The current query, for fluid interface
     */
    public function prune($shopBanersI18n = null)
    {
        if ($shopBanersI18n) {
            $this->addCond('pruneCond0', $this->getAliasedColName(ShopBanersI18nTableMap::COL_ID), $shopBanersI18n->getId(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(ShopBanersI18nTableMap::COL_LOCALE), $shopBanersI18n->getLocale(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the shop_banners_i18n table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ShopBanersI18nTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ShopBanersI18nTableMap::clearInstancePool();
            ShopBanersI18nTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(ShopBanersI18nTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ShopBanersI18nTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            ShopBanersI18nTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            ShopBanersI18nTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // ShopBanersI18nQuery
