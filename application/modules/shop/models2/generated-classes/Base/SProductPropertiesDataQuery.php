<?php

namespace Base;

use \SProductPropertiesData as ChildSProductPropertiesData;
use \SProductPropertiesDataQuery as ChildSProductPropertiesDataQuery;
use \Exception;
use \PDO;
use Map\SProductPropertiesDataTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'shop_product_properties_data' table.
 *
 *
 *
 * @method     ChildSProductPropertiesDataQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildSProductPropertiesDataQuery orderByPropertyId($order = Criteria::ASC) Order by the property_id column
 * @method     ChildSProductPropertiesDataQuery orderByProductId($order = Criteria::ASC) Order by the product_id column
 * @method     ChildSProductPropertiesDataQuery orderByValue($order = Criteria::ASC) Order by the value column
 * @method     ChildSProductPropertiesDataQuery orderByLocale($order = Criteria::ASC) Order by the locale column
 *
 * @method     ChildSProductPropertiesDataQuery groupById() Group by the id column
 * @method     ChildSProductPropertiesDataQuery groupByPropertyId() Group by the property_id column
 * @method     ChildSProductPropertiesDataQuery groupByProductId() Group by the product_id column
 * @method     ChildSProductPropertiesDataQuery groupByValue() Group by the value column
 * @method     ChildSProductPropertiesDataQuery groupByLocale() Group by the locale column
 *
 * @method     ChildSProductPropertiesDataQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildSProductPropertiesDataQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildSProductPropertiesDataQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildSProductPropertiesDataQuery leftJoinSProperties($relationAlias = null) Adds a LEFT JOIN clause to the query using the SProperties relation
 * @method     ChildSProductPropertiesDataQuery rightJoinSProperties($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SProperties relation
 * @method     ChildSProductPropertiesDataQuery innerJoinSProperties($relationAlias = null) Adds a INNER JOIN clause to the query using the SProperties relation
 *
 * @method     ChildSProductPropertiesDataQuery leftJoinProduct($relationAlias = null) Adds a LEFT JOIN clause to the query using the Product relation
 * @method     ChildSProductPropertiesDataQuery rightJoinProduct($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Product relation
 * @method     ChildSProductPropertiesDataQuery innerJoinProduct($relationAlias = null) Adds a INNER JOIN clause to the query using the Product relation
 *
 * @method     \SPropertiesQuery|\SProductsQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildSProductPropertiesData findOne(ConnectionInterface $con = null) Return the first ChildSProductPropertiesData matching the query
 * @method     ChildSProductPropertiesData findOneOrCreate(ConnectionInterface $con = null) Return the first ChildSProductPropertiesData matching the query, or a new ChildSProductPropertiesData object populated from the query conditions when no match is found
 *
 * @method     ChildSProductPropertiesData findOneById(int $id) Return the first ChildSProductPropertiesData filtered by the id column
 * @method     ChildSProductPropertiesData findOneByPropertyId(int $property_id) Return the first ChildSProductPropertiesData filtered by the property_id column
 * @method     ChildSProductPropertiesData findOneByProductId(int $product_id) Return the first ChildSProductPropertiesData filtered by the product_id column
 * @method     ChildSProductPropertiesData findOneByValue(string $value) Return the first ChildSProductPropertiesData filtered by the value column
 * @method     ChildSProductPropertiesData findOneByLocale(string $locale) Return the first ChildSProductPropertiesData filtered by the locale column *

 * @method     ChildSProductPropertiesData requirePk($key, ConnectionInterface $con = null) Return the ChildSProductPropertiesData by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSProductPropertiesData requireOne(ConnectionInterface $con = null) Return the first ChildSProductPropertiesData matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSProductPropertiesData requireOneById(int $id) Return the first ChildSProductPropertiesData filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSProductPropertiesData requireOneByPropertyId(int $property_id) Return the first ChildSProductPropertiesData filtered by the property_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSProductPropertiesData requireOneByProductId(int $product_id) Return the first ChildSProductPropertiesData filtered by the product_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSProductPropertiesData requireOneByValue(string $value) Return the first ChildSProductPropertiesData filtered by the value column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSProductPropertiesData requireOneByLocale(string $locale) Return the first ChildSProductPropertiesData filtered by the locale column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSProductPropertiesData[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildSProductPropertiesData objects based on current ModelCriteria
 * @method     ChildSProductPropertiesData[]|ObjectCollection findById(int $id) Return ChildSProductPropertiesData objects filtered by the id column
 * @method     ChildSProductPropertiesData[]|ObjectCollection findByPropertyId(int $property_id) Return ChildSProductPropertiesData objects filtered by the property_id column
 * @method     ChildSProductPropertiesData[]|ObjectCollection findByProductId(int $product_id) Return ChildSProductPropertiesData objects filtered by the product_id column
 * @method     ChildSProductPropertiesData[]|ObjectCollection findByValue(string $value) Return ChildSProductPropertiesData objects filtered by the value column
 * @method     ChildSProductPropertiesData[]|ObjectCollection findByLocale(string $locale) Return ChildSProductPropertiesData objects filtered by the locale column
 * @method     ChildSProductPropertiesData[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class SProductPropertiesDataQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\SProductPropertiesDataQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'Shop', $modelName = '\\SProductPropertiesData', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildSProductPropertiesDataQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildSProductPropertiesDataQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildSProductPropertiesDataQuery) {
            return $criteria;
        }
        $query = new ChildSProductPropertiesDataQuery();
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
     * @return ChildSProductPropertiesData|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = SProductPropertiesDataTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(SProductPropertiesDataTableMap::DATABASE_NAME);
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
     * @return ChildSProductPropertiesData A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, property_id, product_id, value, locale FROM shop_product_properties_data WHERE id = :p0';
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
            /** @var ChildSProductPropertiesData $obj */
            $obj = new ChildSProductPropertiesData();
            $obj->hydrate($row);
            SProductPropertiesDataTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildSProductPropertiesData|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildSProductPropertiesDataQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(SProductPropertiesDataTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildSProductPropertiesDataQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(SProductPropertiesDataTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildSProductPropertiesDataQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(SProductPropertiesDataTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(SProductPropertiesDataTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SProductPropertiesDataTableMap::COL_ID, $id, $comparison);
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
     * @see       filterBySProperties()
     *
     * @param     mixed $propertyId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSProductPropertiesDataQuery The current query, for fluid interface
     */
    public function filterByPropertyId($propertyId = null, $comparison = null)
    {
        if (is_array($propertyId)) {
            $useMinMax = false;
            if (isset($propertyId['min'])) {
                $this->addUsingAlias(SProductPropertiesDataTableMap::COL_PROPERTY_ID, $propertyId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($propertyId['max'])) {
                $this->addUsingAlias(SProductPropertiesDataTableMap::COL_PROPERTY_ID, $propertyId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SProductPropertiesDataTableMap::COL_PROPERTY_ID, $propertyId, $comparison);
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
     * @see       filterByProduct()
     *
     * @param     mixed $productId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSProductPropertiesDataQuery The current query, for fluid interface
     */
    public function filterByProductId($productId = null, $comparison = null)
    {
        if (is_array($productId)) {
            $useMinMax = false;
            if (isset($productId['min'])) {
                $this->addUsingAlias(SProductPropertiesDataTableMap::COL_PRODUCT_ID, $productId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($productId['max'])) {
                $this->addUsingAlias(SProductPropertiesDataTableMap::COL_PRODUCT_ID, $productId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SProductPropertiesDataTableMap::COL_PRODUCT_ID, $productId, $comparison);
    }

    /**
     * Filter the query on the value column
     *
     * Example usage:
     * <code>
     * $query->filterByValue('fooValue');   // WHERE value = 'fooValue'
     * $query->filterByValue('%fooValue%'); // WHERE value LIKE '%fooValue%'
     * </code>
     *
     * @param     string $value The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSProductPropertiesDataQuery The current query, for fluid interface
     */
    public function filterByValue($value = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($value)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $value)) {
                $value = str_replace('*', '%', $value);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SProductPropertiesDataTableMap::COL_VALUE, $value, $comparison);
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
     * @return $this|ChildSProductPropertiesDataQuery The current query, for fluid interface
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

        return $this->addUsingAlias(SProductPropertiesDataTableMap::COL_LOCALE, $locale, $comparison);
    }

    /**
     * Filter the query by a related \SProperties object
     *
     * @param \SProperties|ObjectCollection $sProperties The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildSProductPropertiesDataQuery The current query, for fluid interface
     */
    public function filterBySProperties($sProperties, $comparison = null)
    {
        if ($sProperties instanceof \SProperties) {
            return $this
                ->addUsingAlias(SProductPropertiesDataTableMap::COL_PROPERTY_ID, $sProperties->getId(), $comparison);
        } elseif ($sProperties instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(SProductPropertiesDataTableMap::COL_PROPERTY_ID, $sProperties->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterBySProperties() only accepts arguments of type \SProperties or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the SProperties relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSProductPropertiesDataQuery The current query, for fluid interface
     */
    public function joinSProperties($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('SProperties');

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
            $this->addJoinObject($join, 'SProperties');
        }

        return $this;
    }

    /**
     * Use the SProperties relation SProperties object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \SPropertiesQuery A secondary query class using the current class as primary query
     */
    public function useSPropertiesQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinSProperties($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'SProperties', '\SPropertiesQuery');
    }

    /**
     * Filter the query by a related \SProducts object
     *
     * @param \SProducts|ObjectCollection $sProducts The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildSProductPropertiesDataQuery The current query, for fluid interface
     */
    public function filterByProduct($sProducts, $comparison = null)
    {
        if ($sProducts instanceof \SProducts) {
            return $this
                ->addUsingAlias(SProductPropertiesDataTableMap::COL_PRODUCT_ID, $sProducts->getId(), $comparison);
        } elseif ($sProducts instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(SProductPropertiesDataTableMap::COL_PRODUCT_ID, $sProducts->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByProduct() only accepts arguments of type \SProducts or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Product relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSProductPropertiesDataQuery The current query, for fluid interface
     */
    public function joinProduct($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Product');

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
            $this->addJoinObject($join, 'Product');
        }

        return $this;
    }

    /**
     * Use the Product relation SProducts object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \SProductsQuery A secondary query class using the current class as primary query
     */
    public function useProductQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinProduct($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Product', '\SProductsQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildSProductPropertiesData $sProductPropertiesData Object to remove from the list of results
     *
     * @return $this|ChildSProductPropertiesDataQuery The current query, for fluid interface
     */
    public function prune($sProductPropertiesData = null)
    {
        if ($sProductPropertiesData) {
            $this->addUsingAlias(SProductPropertiesDataTableMap::COL_ID, $sProductPropertiesData->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the shop_product_properties_data table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SProductPropertiesDataTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            SProductPropertiesDataTableMap::clearInstancePool();
            SProductPropertiesDataTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(SProductPropertiesDataTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(SProductPropertiesDataTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            SProductPropertiesDataTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            SProductPropertiesDataTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // SProductPropertiesDataQuery
