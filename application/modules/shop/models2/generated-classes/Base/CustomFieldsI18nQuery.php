<?php

namespace Base;

use \CustomFieldsI18n as ChildCustomFieldsI18n;
use \CustomFieldsI18nQuery as ChildCustomFieldsI18nQuery;
use \Exception;
use \PDO;
use Map\CustomFieldsI18nTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'custom_fields_i18n' table.
 *
 *
 *
 * @method     ChildCustomFieldsI18nQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildCustomFieldsI18nQuery orderByLocale($order = Criteria::ASC) Order by the locale column
 * @method     ChildCustomFieldsI18nQuery orderByFieldLabel($order = Criteria::ASC) Order by the field_label column
 * @method     ChildCustomFieldsI18nQuery orderByFieldDescription($order = Criteria::ASC) Order by the field_description column
 * @method     ChildCustomFieldsI18nQuery orderByPossibleValues($order = Criteria::ASC) Order by the possible_values column
 *
 * @method     ChildCustomFieldsI18nQuery groupById() Group by the id column
 * @method     ChildCustomFieldsI18nQuery groupByLocale() Group by the locale column
 * @method     ChildCustomFieldsI18nQuery groupByFieldLabel() Group by the field_label column
 * @method     ChildCustomFieldsI18nQuery groupByFieldDescription() Group by the field_description column
 * @method     ChildCustomFieldsI18nQuery groupByPossibleValues() Group by the possible_values column
 *
 * @method     ChildCustomFieldsI18nQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildCustomFieldsI18nQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildCustomFieldsI18nQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildCustomFieldsI18nQuery leftJoinCustomFields($relationAlias = null) Adds a LEFT JOIN clause to the query using the CustomFields relation
 * @method     ChildCustomFieldsI18nQuery rightJoinCustomFields($relationAlias = null) Adds a RIGHT JOIN clause to the query using the CustomFields relation
 * @method     ChildCustomFieldsI18nQuery innerJoinCustomFields($relationAlias = null) Adds a INNER JOIN clause to the query using the CustomFields relation
 *
 * @method     \CustomFieldsQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildCustomFieldsI18n findOne(ConnectionInterface $con = null) Return the first ChildCustomFieldsI18n matching the query
 * @method     ChildCustomFieldsI18n findOneOrCreate(ConnectionInterface $con = null) Return the first ChildCustomFieldsI18n matching the query, or a new ChildCustomFieldsI18n object populated from the query conditions when no match is found
 *
 * @method     ChildCustomFieldsI18n findOneById(int $id) Return the first ChildCustomFieldsI18n filtered by the id column
 * @method     ChildCustomFieldsI18n findOneByLocale(string $locale) Return the first ChildCustomFieldsI18n filtered by the locale column
 * @method     ChildCustomFieldsI18n findOneByFieldLabel(string $field_label) Return the first ChildCustomFieldsI18n filtered by the field_label column
 * @method     ChildCustomFieldsI18n findOneByFieldDescription(string $field_description) Return the first ChildCustomFieldsI18n filtered by the field_description column
 * @method     ChildCustomFieldsI18n findOneByPossibleValues(string $possible_values) Return the first ChildCustomFieldsI18n filtered by the possible_values column *

 * @method     ChildCustomFieldsI18n requirePk($key, ConnectionInterface $con = null) Return the ChildCustomFieldsI18n by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCustomFieldsI18n requireOne(ConnectionInterface $con = null) Return the first ChildCustomFieldsI18n matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildCustomFieldsI18n requireOneById(int $id) Return the first ChildCustomFieldsI18n filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCustomFieldsI18n requireOneByLocale(string $locale) Return the first ChildCustomFieldsI18n filtered by the locale column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCustomFieldsI18n requireOneByFieldLabel(string $field_label) Return the first ChildCustomFieldsI18n filtered by the field_label column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCustomFieldsI18n requireOneByFieldDescription(string $field_description) Return the first ChildCustomFieldsI18n filtered by the field_description column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCustomFieldsI18n requireOneByPossibleValues(string $possible_values) Return the first ChildCustomFieldsI18n filtered by the possible_values column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildCustomFieldsI18n[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildCustomFieldsI18n objects based on current ModelCriteria
 * @method     ChildCustomFieldsI18n[]|ObjectCollection findById(int $id) Return ChildCustomFieldsI18n objects filtered by the id column
 * @method     ChildCustomFieldsI18n[]|ObjectCollection findByLocale(string $locale) Return ChildCustomFieldsI18n objects filtered by the locale column
 * @method     ChildCustomFieldsI18n[]|ObjectCollection findByFieldLabel(string $field_label) Return ChildCustomFieldsI18n objects filtered by the field_label column
 * @method     ChildCustomFieldsI18n[]|ObjectCollection findByFieldDescription(string $field_description) Return ChildCustomFieldsI18n objects filtered by the field_description column
 * @method     ChildCustomFieldsI18n[]|ObjectCollection findByPossibleValues(string $possible_values) Return ChildCustomFieldsI18n objects filtered by the possible_values column
 * @method     ChildCustomFieldsI18n[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class CustomFieldsI18nQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\CustomFieldsI18nQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'Shop', $modelName = '\\CustomFieldsI18n', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildCustomFieldsI18nQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildCustomFieldsI18nQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildCustomFieldsI18nQuery) {
            return $criteria;
        }
        $query = new ChildCustomFieldsI18nQuery();
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
     * @return ChildCustomFieldsI18n|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = CustomFieldsI18nTableMap::getInstanceFromPool(serialize(array((string) $key[0], (string) $key[1]))))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(CustomFieldsI18nTableMap::DATABASE_NAME);
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
     * @return ChildCustomFieldsI18n A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, locale, field_label, field_description, possible_values FROM custom_fields_i18n WHERE id = :p0 AND locale = :p1';
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
            /** @var ChildCustomFieldsI18n $obj */
            $obj = new ChildCustomFieldsI18n();
            $obj->hydrate($row);
            CustomFieldsI18nTableMap::addInstanceToPool($obj, serialize(array((string) $key[0], (string) $key[1])));
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
     * @return ChildCustomFieldsI18n|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildCustomFieldsI18nQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(CustomFieldsI18nTableMap::COL_ID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(CustomFieldsI18nTableMap::COL_LOCALE, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildCustomFieldsI18nQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(CustomFieldsI18nTableMap::COL_ID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(CustomFieldsI18nTableMap::COL_LOCALE, $key[1], Criteria::EQUAL);
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
     * @see       filterByCustomFields()
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCustomFieldsI18nQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(CustomFieldsI18nTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(CustomFieldsI18nTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CustomFieldsI18nTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildCustomFieldsI18nQuery The current query, for fluid interface
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

        return $this->addUsingAlias(CustomFieldsI18nTableMap::COL_LOCALE, $locale, $comparison);
    }

    /**
     * Filter the query on the field_label column
     *
     * Example usage:
     * <code>
     * $query->filterByFieldLabel('fooValue');   // WHERE field_label = 'fooValue'
     * $query->filterByFieldLabel('%fooValue%'); // WHERE field_label LIKE '%fooValue%'
     * </code>
     *
     * @param     string $fieldLabel The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCustomFieldsI18nQuery The current query, for fluid interface
     */
    public function filterByFieldLabel($fieldLabel = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($fieldLabel)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $fieldLabel)) {
                $fieldLabel = str_replace('*', '%', $fieldLabel);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CustomFieldsI18nTableMap::COL_FIELD_LABEL, $fieldLabel, $comparison);
    }

    /**
     * Filter the query on the field_description column
     *
     * Example usage:
     * <code>
     * $query->filterByFieldDescription('fooValue');   // WHERE field_description = 'fooValue'
     * $query->filterByFieldDescription('%fooValue%'); // WHERE field_description LIKE '%fooValue%'
     * </code>
     *
     * @param     string $fieldDescription The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCustomFieldsI18nQuery The current query, for fluid interface
     */
    public function filterByFieldDescription($fieldDescription = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($fieldDescription)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $fieldDescription)) {
                $fieldDescription = str_replace('*', '%', $fieldDescription);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CustomFieldsI18nTableMap::COL_FIELD_DESCRIPTION, $fieldDescription, $comparison);
    }

    /**
     * Filter the query on the possible_values column
     *
     * Example usage:
     * <code>
     * $query->filterByPossibleValues('fooValue');   // WHERE possible_values = 'fooValue'
     * $query->filterByPossibleValues('%fooValue%'); // WHERE possible_values LIKE '%fooValue%'
     * </code>
     *
     * @param     string $possibleValues The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCustomFieldsI18nQuery The current query, for fluid interface
     */
    public function filterByPossibleValues($possibleValues = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($possibleValues)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $possibleValues)) {
                $possibleValues = str_replace('*', '%', $possibleValues);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CustomFieldsI18nTableMap::COL_POSSIBLE_VALUES, $possibleValues, $comparison);
    }

    /**
     * Filter the query by a related \CustomFields object
     *
     * @param \CustomFields|ObjectCollection $customFields The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildCustomFieldsI18nQuery The current query, for fluid interface
     */
    public function filterByCustomFields($customFields, $comparison = null)
    {
        if ($customFields instanceof \CustomFields) {
            return $this
                ->addUsingAlias(CustomFieldsI18nTableMap::COL_ID, $customFields->getId(), $comparison);
        } elseif ($customFields instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(CustomFieldsI18nTableMap::COL_ID, $customFields->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByCustomFields() only accepts arguments of type \CustomFields or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the CustomFields relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildCustomFieldsI18nQuery The current query, for fluid interface
     */
    public function joinCustomFields($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('CustomFields');

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
            $this->addJoinObject($join, 'CustomFields');
        }

        return $this;
    }

    /**
     * Use the CustomFields relation CustomFields object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \CustomFieldsQuery A secondary query class using the current class as primary query
     */
    public function useCustomFieldsQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinCustomFields($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'CustomFields', '\CustomFieldsQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildCustomFieldsI18n $customFieldsI18n Object to remove from the list of results
     *
     * @return $this|ChildCustomFieldsI18nQuery The current query, for fluid interface
     */
    public function prune($customFieldsI18n = null)
    {
        if ($customFieldsI18n) {
            $this->addCond('pruneCond0', $this->getAliasedColName(CustomFieldsI18nTableMap::COL_ID), $customFieldsI18n->getId(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(CustomFieldsI18nTableMap::COL_LOCALE), $customFieldsI18n->getLocale(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the custom_fields_i18n table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CustomFieldsI18nTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            CustomFieldsI18nTableMap::clearInstancePool();
            CustomFieldsI18nTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(CustomFieldsI18nTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(CustomFieldsI18nTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            CustomFieldsI18nTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            CustomFieldsI18nTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // CustomFieldsI18nQuery
