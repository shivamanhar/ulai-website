<?php

namespace Base;

use \SProductImages as ChildSProductImages;
use \SProductImagesQuery as ChildSProductImagesQuery;
use \Exception;
use \PDO;
use Map\SProductImagesTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'shop_product_images' table.
 *
 *
 *
 * @method     ChildSProductImagesQuery orderByProductId($order = Criteria::ASC) Order by the product_id column
 * @method     ChildSProductImagesQuery orderByImageName($order = Criteria::ASC) Order by the image_name column
 * @method     ChildSProductImagesQuery orderByPosition($order = Criteria::ASC) Order by the position column
 *
 * @method     ChildSProductImagesQuery groupByProductId() Group by the product_id column
 * @method     ChildSProductImagesQuery groupByImageName() Group by the image_name column
 * @method     ChildSProductImagesQuery groupByPosition() Group by the position column
 *
 * @method     ChildSProductImagesQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildSProductImagesQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildSProductImagesQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildSProductImagesQuery leftJoinSProducts($relationAlias = null) Adds a LEFT JOIN clause to the query using the SProducts relation
 * @method     ChildSProductImagesQuery rightJoinSProducts($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SProducts relation
 * @method     ChildSProductImagesQuery innerJoinSProducts($relationAlias = null) Adds a INNER JOIN clause to the query using the SProducts relation
 *
 * @method     \SProductsQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildSProductImages findOne(ConnectionInterface $con = null) Return the first ChildSProductImages matching the query
 * @method     ChildSProductImages findOneOrCreate(ConnectionInterface $con = null) Return the first ChildSProductImages matching the query, or a new ChildSProductImages object populated from the query conditions when no match is found
 *
 * @method     ChildSProductImages findOneByProductId(int $product_id) Return the first ChildSProductImages filtered by the product_id column
 * @method     ChildSProductImages findOneByImageName(string $image_name) Return the first ChildSProductImages filtered by the image_name column
 * @method     ChildSProductImages findOneByPosition(int $position) Return the first ChildSProductImages filtered by the position column *

 * @method     ChildSProductImages requirePk($key, ConnectionInterface $con = null) Return the ChildSProductImages by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSProductImages requireOne(ConnectionInterface $con = null) Return the first ChildSProductImages matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSProductImages requireOneByProductId(int $product_id) Return the first ChildSProductImages filtered by the product_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSProductImages requireOneByImageName(string $image_name) Return the first ChildSProductImages filtered by the image_name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSProductImages requireOneByPosition(int $position) Return the first ChildSProductImages filtered by the position column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSProductImages[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildSProductImages objects based on current ModelCriteria
 * @method     ChildSProductImages[]|ObjectCollection findByProductId(int $product_id) Return ChildSProductImages objects filtered by the product_id column
 * @method     ChildSProductImages[]|ObjectCollection findByImageName(string $image_name) Return ChildSProductImages objects filtered by the image_name column
 * @method     ChildSProductImages[]|ObjectCollection findByPosition(int $position) Return ChildSProductImages objects filtered by the position column
 * @method     ChildSProductImages[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class SProductImagesQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\SProductImagesQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'Shop', $modelName = '\\SProductImages', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildSProductImagesQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildSProductImagesQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildSProductImagesQuery) {
            return $criteria;
        }
        $query = new ChildSProductImagesQuery();
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
     * @param array[$product_id, $image_name] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildSProductImages|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = SProductImagesTableMap::getInstanceFromPool(serialize(array((string) $key[0], (string) $key[1]))))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(SProductImagesTableMap::DATABASE_NAME);
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
     * @return ChildSProductImages A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT product_id, image_name, position FROM shop_product_images WHERE product_id = :p0 AND image_name = :p1';
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
            /** @var ChildSProductImages $obj */
            $obj = new ChildSProductImages();
            $obj->hydrate($row);
            SProductImagesTableMap::addInstanceToPool($obj, serialize(array((string) $key[0], (string) $key[1])));
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
     * @return ChildSProductImages|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildSProductImagesQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(SProductImagesTableMap::COL_PRODUCT_ID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(SProductImagesTableMap::COL_IMAGE_NAME, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildSProductImagesQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(SProductImagesTableMap::COL_PRODUCT_ID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(SProductImagesTableMap::COL_IMAGE_NAME, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $this->addOr($cton0);
        }

        return $this;
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
     * @return $this|ChildSProductImagesQuery The current query, for fluid interface
     */
    public function filterByProductId($productId = null, $comparison = null)
    {
        if (is_array($productId)) {
            $useMinMax = false;
            if (isset($productId['min'])) {
                $this->addUsingAlias(SProductImagesTableMap::COL_PRODUCT_ID, $productId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($productId['max'])) {
                $this->addUsingAlias(SProductImagesTableMap::COL_PRODUCT_ID, $productId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SProductImagesTableMap::COL_PRODUCT_ID, $productId, $comparison);
    }

    /**
     * Filter the query on the image_name column
     *
     * Example usage:
     * <code>
     * $query->filterByImageName('fooValue');   // WHERE image_name = 'fooValue'
     * $query->filterByImageName('%fooValue%'); // WHERE image_name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $imageName The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSProductImagesQuery The current query, for fluid interface
     */
    public function filterByImageName($imageName = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($imageName)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $imageName)) {
                $imageName = str_replace('*', '%', $imageName);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SProductImagesTableMap::COL_IMAGE_NAME, $imageName, $comparison);
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
     * @return $this|ChildSProductImagesQuery The current query, for fluid interface
     */
    public function filterByPosition($position = null, $comparison = null)
    {
        if (is_array($position)) {
            $useMinMax = false;
            if (isset($position['min'])) {
                $this->addUsingAlias(SProductImagesTableMap::COL_POSITION, $position['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($position['max'])) {
                $this->addUsingAlias(SProductImagesTableMap::COL_POSITION, $position['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SProductImagesTableMap::COL_POSITION, $position, $comparison);
    }

    /**
     * Filter the query by a related \SProducts object
     *
     * @param \SProducts|ObjectCollection $sProducts The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildSProductImagesQuery The current query, for fluid interface
     */
    public function filterBySProducts($sProducts, $comparison = null)
    {
        if ($sProducts instanceof \SProducts) {
            return $this
                ->addUsingAlias(SProductImagesTableMap::COL_PRODUCT_ID, $sProducts->getId(), $comparison);
        } elseif ($sProducts instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(SProductImagesTableMap::COL_PRODUCT_ID, $sProducts->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildSProductImagesQuery The current query, for fluid interface
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
     * @param   ChildSProductImages $sProductImages Object to remove from the list of results
     *
     * @return $this|ChildSProductImagesQuery The current query, for fluid interface
     */
    public function prune($sProductImages = null)
    {
        if ($sProductImages) {
            $this->addCond('pruneCond0', $this->getAliasedColName(SProductImagesTableMap::COL_PRODUCT_ID), $sProductImages->getProductId(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(SProductImagesTableMap::COL_IMAGE_NAME), $sProductImages->getImageName(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the shop_product_images table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SProductImagesTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            SProductImagesTableMap::clearInstancePool();
            SProductImagesTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(SProductImagesTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(SProductImagesTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            SProductImagesTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            SProductImagesTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // SProductImagesQuery
