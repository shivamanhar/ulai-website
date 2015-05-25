<?php

namespace Base;

use \ShopProductPropertiesCategories as ChildShopProductPropertiesCategories;
use \ShopProductPropertiesCategoriesQuery as ChildShopProductPropertiesCategoriesQuery;
use \Exception;
use \PDO;
use Map\ShopProductPropertiesCategoriesTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'shop_product_properties_categories' table.
 *
 *
 *
 * @method     ChildShopProductPropertiesCategoriesQuery orderByPropertyId($order = Criteria::ASC) Order by the property_id column
 * @method     ChildShopProductPropertiesCategoriesQuery orderByCategoryId($order = Criteria::ASC) Order by the category_id column
 *
 * @method     ChildShopProductPropertiesCategoriesQuery groupByPropertyId() Group by the property_id column
 * @method     ChildShopProductPropertiesCategoriesQuery groupByCategoryId() Group by the category_id column
 *
 * @method     ChildShopProductPropertiesCategoriesQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildShopProductPropertiesCategoriesQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildShopProductPropertiesCategoriesQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildShopProductPropertiesCategoriesQuery leftJoinProperty($relationAlias = null) Adds a LEFT JOIN clause to the query using the Property relation
 * @method     ChildShopProductPropertiesCategoriesQuery rightJoinProperty($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Property relation
 * @method     ChildShopProductPropertiesCategoriesQuery innerJoinProperty($relationAlias = null) Adds a INNER JOIN clause to the query using the Property relation
 *
 * @method     ChildShopProductPropertiesCategoriesQuery leftJoinPropertyCategory($relationAlias = null) Adds a LEFT JOIN clause to the query using the PropertyCategory relation
 * @method     ChildShopProductPropertiesCategoriesQuery rightJoinPropertyCategory($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PropertyCategory relation
 * @method     ChildShopProductPropertiesCategoriesQuery innerJoinPropertyCategory($relationAlias = null) Adds a INNER JOIN clause to the query using the PropertyCategory relation
 *
 * @method     \SPropertiesQuery|\SCategoryQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildShopProductPropertiesCategories findOne(ConnectionInterface $con = null) Return the first ChildShopProductPropertiesCategories matching the query
 * @method     ChildShopProductPropertiesCategories findOneOrCreate(ConnectionInterface $con = null) Return the first ChildShopProductPropertiesCategories matching the query, or a new ChildShopProductPropertiesCategories object populated from the query conditions when no match is found
 *
 * @method     ChildShopProductPropertiesCategories findOneByPropertyId(int $property_id) Return the first ChildShopProductPropertiesCategories filtered by the property_id column
 * @method     ChildShopProductPropertiesCategories findOneByCategoryId(int $category_id) Return the first ChildShopProductPropertiesCategories filtered by the category_id column *

 * @method     ChildShopProductPropertiesCategories requirePk($key, ConnectionInterface $con = null) Return the ChildShopProductPropertiesCategories by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildShopProductPropertiesCategories requireOne(ConnectionInterface $con = null) Return the first ChildShopProductPropertiesCategories matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildShopProductPropertiesCategories requireOneByPropertyId(int $property_id) Return the first ChildShopProductPropertiesCategories filtered by the property_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildShopProductPropertiesCategories requireOneByCategoryId(int $category_id) Return the first ChildShopProductPropertiesCategories filtered by the category_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildShopProductPropertiesCategories[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildShopProductPropertiesCategories objects based on current ModelCriteria
 * @method     ChildShopProductPropertiesCategories[]|ObjectCollection findByPropertyId(int $property_id) Return ChildShopProductPropertiesCategories objects filtered by the property_id column
 * @method     ChildShopProductPropertiesCategories[]|ObjectCollection findByCategoryId(int $category_id) Return ChildShopProductPropertiesCategories objects filtered by the category_id column
 * @method     ChildShopProductPropertiesCategories[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class ShopProductPropertiesCategoriesQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\ShopProductPropertiesCategoriesQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'Shop', $modelName = '\\ShopProductPropertiesCategories', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildShopProductPropertiesCategoriesQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildShopProductPropertiesCategoriesQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildShopProductPropertiesCategoriesQuery) {
            return $criteria;
        }
        $query = new ChildShopProductPropertiesCategoriesQuery();
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
     * @param array[$property_id, $category_id] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildShopProductPropertiesCategories|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ShopProductPropertiesCategoriesTableMap::getInstanceFromPool(serialize(array((string) $key[0], (string) $key[1]))))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ShopProductPropertiesCategoriesTableMap::DATABASE_NAME);
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
     * @return ChildShopProductPropertiesCategories A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT property_id, category_id FROM shop_product_properties_categories WHERE property_id = :p0 AND category_id = :p1';
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
            /** @var ChildShopProductPropertiesCategories $obj */
            $obj = new ChildShopProductPropertiesCategories();
            $obj->hydrate($row);
            ShopProductPropertiesCategoriesTableMap::addInstanceToPool($obj, serialize(array((string) $key[0], (string) $key[1])));
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
     * @return ChildShopProductPropertiesCategories|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildShopProductPropertiesCategoriesQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(ShopProductPropertiesCategoriesTableMap::COL_PROPERTY_ID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(ShopProductPropertiesCategoriesTableMap::COL_CATEGORY_ID, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildShopProductPropertiesCategoriesQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(ShopProductPropertiesCategoriesTableMap::COL_PROPERTY_ID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(ShopProductPropertiesCategoriesTableMap::COL_CATEGORY_ID, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $this->addOr($cton0);
        }

        return $this;
    }

    /**
     * Filter the query on the property_id column
     *
     * Example usage:
     * <code>
     * $query->filterByPropertyId(1234); // WHERE property_id = 1234
     * $query->filterByPropertyId(array(12, 34)); // WHERE property_id IN (12, 34)
     * $query->filterByPropertyId(array('min' => 12)); // WHERE property_id > 12
     * </code>
     *
     * @see       filterByProperty()
     *
     * @param     mixed $propertyId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildShopProductPropertiesCategoriesQuery The current query, for fluid interface
     */
    public function filterByPropertyId($propertyId = null, $comparison = null)
    {
        if (is_array($propertyId)) {
            $useMinMax = false;
            if (isset($propertyId['min'])) {
                $this->addUsingAlias(ShopProductPropertiesCategoriesTableMap::COL_PROPERTY_ID, $propertyId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($propertyId['max'])) {
                $this->addUsingAlias(ShopProductPropertiesCategoriesTableMap::COL_PROPERTY_ID, $propertyId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ShopProductPropertiesCategoriesTableMap::COL_PROPERTY_ID, $propertyId, $comparison);
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
     * @see       filterByPropertyCategory()
     *
     * @param     mixed $categoryId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildShopProductPropertiesCategoriesQuery The current query, for fluid interface
     */
    public function filterByCategoryId($categoryId = null, $comparison = null)
    {
        if (is_array($categoryId)) {
            $useMinMax = false;
            if (isset($categoryId['min'])) {
                $this->addUsingAlias(ShopProductPropertiesCategoriesTableMap::COL_CATEGORY_ID, $categoryId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($categoryId['max'])) {
                $this->addUsingAlias(ShopProductPropertiesCategoriesTableMap::COL_CATEGORY_ID, $categoryId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ShopProductPropertiesCategoriesTableMap::COL_CATEGORY_ID, $categoryId, $comparison);
    }

    /**
     * Filter the query by a related \SProperties object
     *
     * @param \SProperties|ObjectCollection $sProperties The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildShopProductPropertiesCategoriesQuery The current query, for fluid interface
     */
    public function filterByProperty($sProperties, $comparison = null)
    {
        if ($sProperties instanceof \SProperties) {
            return $this
                ->addUsingAlias(ShopProductPropertiesCategoriesTableMap::COL_PROPERTY_ID, $sProperties->getId(), $comparison);
        } elseif ($sProperties instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ShopProductPropertiesCategoriesTableMap::COL_PROPERTY_ID, $sProperties->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByProperty() only accepts arguments of type \SProperties or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Property relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildShopProductPropertiesCategoriesQuery The current query, for fluid interface
     */
    public function joinProperty($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Property');

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
            $this->addJoinObject($join, 'Property');
        }

        return $this;
    }

    /**
     * Use the Property relation SProperties object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \SPropertiesQuery A secondary query class using the current class as primary query
     */
    public function usePropertyQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinProperty($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Property', '\SPropertiesQuery');
    }

    /**
     * Filter the query by a related \SCategory object
     *
     * @param \SCategory|ObjectCollection $sCategory The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildShopProductPropertiesCategoriesQuery The current query, for fluid interface
     */
    public function filterByPropertyCategory($sCategory, $comparison = null)
    {
        if ($sCategory instanceof \SCategory) {
            return $this
                ->addUsingAlias(ShopProductPropertiesCategoriesTableMap::COL_CATEGORY_ID, $sCategory->getId(), $comparison);
        } elseif ($sCategory instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ShopProductPropertiesCategoriesTableMap::COL_CATEGORY_ID, $sCategory->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByPropertyCategory() only accepts arguments of type \SCategory or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the PropertyCategory relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildShopProductPropertiesCategoriesQuery The current query, for fluid interface
     */
    public function joinPropertyCategory($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('PropertyCategory');

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
            $this->addJoinObject($join, 'PropertyCategory');
        }

        return $this;
    }

    /**
     * Use the PropertyCategory relation SCategory object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \SCategoryQuery A secondary query class using the current class as primary query
     */
    public function usePropertyCategoryQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPropertyCategory($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'PropertyCategory', '\SCategoryQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildShopProductPropertiesCategories $shopProductPropertiesCategories Object to remove from the list of results
     *
     * @return $this|ChildShopProductPropertiesCategoriesQuery The current query, for fluid interface
     */
    public function prune($shopProductPropertiesCategories = null)
    {
        if ($shopProductPropertiesCategories) {
            $this->addCond('pruneCond0', $this->getAliasedColName(ShopProductPropertiesCategoriesTableMap::COL_PROPERTY_ID), $shopProductPropertiesCategories->getPropertyId(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(ShopProductPropertiesCategoriesTableMap::COL_CATEGORY_ID), $shopProductPropertiesCategories->getCategoryId(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the shop_product_properties_categories table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ShopProductPropertiesCategoriesTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ShopProductPropertiesCategoriesTableMap::clearInstancePool();
            ShopProductPropertiesCategoriesTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(ShopProductPropertiesCategoriesTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ShopProductPropertiesCategoriesTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            ShopProductPropertiesCategoriesTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            ShopProductPropertiesCategoriesTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // ShopProductPropertiesCategoriesQuery
