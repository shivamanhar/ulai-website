<?php

namespace Base;

use \CustomFields as ChildCustomFields;
use \CustomFieldsI18nQuery as ChildCustomFieldsI18nQuery;
use \CustomFieldsQuery as ChildCustomFieldsQuery;
use \Exception;
use \PDO;
use Map\CustomFieldsI18nTableMap;
use Map\CustomFieldsTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'custom_fields' table.
 *
 *
 *
 * @method     ChildCustomFieldsQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildCustomFieldsQuery orderByEntity($order = Criteria::ASC) Order by the entity column
 * @method     ChildCustomFieldsQuery orderBytypeId($order = Criteria::ASC) Order by the field_type_id column
 * @method     ChildCustomFieldsQuery orderByname($order = Criteria::ASC) Order by the field_name column
 * @method     ChildCustomFieldsQuery orderByIsRequired($order = Criteria::ASC) Order by the is_required column
 * @method     ChildCustomFieldsQuery orderByIsActive($order = Criteria::ASC) Order by the is_active column
 * @method     ChildCustomFieldsQuery orderByOptions($order = Criteria::ASC) Order by the options column
 * @method     ChildCustomFieldsQuery orderByIsPrivate($order = Criteria::ASC) Order by the is_private column
 * @method     ChildCustomFieldsQuery orderByValidators($order = Criteria::ASC) Order by the validators column
 * @method     ChildCustomFieldsQuery orderByclasses($order = Criteria::ASC) Order by the classes column
 * @method     ChildCustomFieldsQuery orderByposition($order = Criteria::ASC) Order by the position column
 *
 * @method     ChildCustomFieldsQuery groupById() Group by the id column
 * @method     ChildCustomFieldsQuery groupByEntity() Group by the entity column
 * @method     ChildCustomFieldsQuery groupBytypeId() Group by the field_type_id column
 * @method     ChildCustomFieldsQuery groupByname() Group by the field_name column
 * @method     ChildCustomFieldsQuery groupByIsRequired() Group by the is_required column
 * @method     ChildCustomFieldsQuery groupByIsActive() Group by the is_active column
 * @method     ChildCustomFieldsQuery groupByOptions() Group by the options column
 * @method     ChildCustomFieldsQuery groupByIsPrivate() Group by the is_private column
 * @method     ChildCustomFieldsQuery groupByValidators() Group by the validators column
 * @method     ChildCustomFieldsQuery groupByclasses() Group by the classes column
 * @method     ChildCustomFieldsQuery groupByposition() Group by the position column
 *
 * @method     ChildCustomFieldsQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildCustomFieldsQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildCustomFieldsQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildCustomFieldsQuery leftJoinCustomFieldsI18n($relationAlias = null) Adds a LEFT JOIN clause to the query using the CustomFieldsI18n relation
 * @method     ChildCustomFieldsQuery rightJoinCustomFieldsI18n($relationAlias = null) Adds a RIGHT JOIN clause to the query using the CustomFieldsI18n relation
 * @method     ChildCustomFieldsQuery innerJoinCustomFieldsI18n($relationAlias = null) Adds a INNER JOIN clause to the query using the CustomFieldsI18n relation
 *
 * @method     \CustomFieldsI18nQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildCustomFields findOne(ConnectionInterface $con = null) Return the first ChildCustomFields matching the query
 * @method     ChildCustomFields findOneOrCreate(ConnectionInterface $con = null) Return the first ChildCustomFields matching the query, or a new ChildCustomFields object populated from the query conditions when no match is found
 *
 * @method     ChildCustomFields findOneById(int $id) Return the first ChildCustomFields filtered by the id column
 * @method     ChildCustomFields findOneByEntity(string $entity) Return the first ChildCustomFields filtered by the entity column
 * @method     ChildCustomFields findOneBytypeId(int $field_type_id) Return the first ChildCustomFields filtered by the field_type_id column
 * @method     ChildCustomFields findOneByname(string $field_name) Return the first ChildCustomFields filtered by the field_name column
 * @method     ChildCustomFields findOneByIsRequired(boolean $is_required) Return the first ChildCustomFields filtered by the is_required column
 * @method     ChildCustomFields findOneByIsActive(boolean $is_active) Return the first ChildCustomFields filtered by the is_active column
 * @method     ChildCustomFields findOneByOptions(string $options) Return the first ChildCustomFields filtered by the options column
 * @method     ChildCustomFields findOneByIsPrivate(boolean $is_private) Return the first ChildCustomFields filtered by the is_private column
 * @method     ChildCustomFields findOneByValidators(string $validators) Return the first ChildCustomFields filtered by the validators column
 * @method     ChildCustomFields findOneByclasses(string $classes) Return the first ChildCustomFields filtered by the classes column
 * @method     ChildCustomFields findOneByposition(int $position) Return the first ChildCustomFields filtered by the position column *

 * @method     ChildCustomFields requirePk($key, ConnectionInterface $con = null) Return the ChildCustomFields by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCustomFields requireOne(ConnectionInterface $con = null) Return the first ChildCustomFields matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildCustomFields requireOneById(int $id) Return the first ChildCustomFields filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCustomFields requireOneByEntity(string $entity) Return the first ChildCustomFields filtered by the entity column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCustomFields requireOneBytypeId(int $field_type_id) Return the first ChildCustomFields filtered by the field_type_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCustomFields requireOneByname(string $field_name) Return the first ChildCustomFields filtered by the field_name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCustomFields requireOneByIsRequired(boolean $is_required) Return the first ChildCustomFields filtered by the is_required column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCustomFields requireOneByIsActive(boolean $is_active) Return the first ChildCustomFields filtered by the is_active column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCustomFields requireOneByOptions(string $options) Return the first ChildCustomFields filtered by the options column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCustomFields requireOneByIsPrivate(boolean $is_private) Return the first ChildCustomFields filtered by the is_private column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCustomFields requireOneByValidators(string $validators) Return the first ChildCustomFields filtered by the validators column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCustomFields requireOneByclasses(string $classes) Return the first ChildCustomFields filtered by the classes column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCustomFields requireOneByposition(int $position) Return the first ChildCustomFields filtered by the position column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildCustomFields[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildCustomFields objects based on current ModelCriteria
 * @method     ChildCustomFields[]|ObjectCollection findById(int $id) Return ChildCustomFields objects filtered by the id column
 * @method     ChildCustomFields[]|ObjectCollection findByEntity(string $entity) Return ChildCustomFields objects filtered by the entity column
 * @method     ChildCustomFields[]|ObjectCollection findBytypeId(int $field_type_id) Return ChildCustomFields objects filtered by the field_type_id column
 * @method     ChildCustomFields[]|ObjectCollection findByname(string $field_name) Return ChildCustomFields objects filtered by the field_name column
 * @method     ChildCustomFields[]|ObjectCollection findByIsRequired(boolean $is_required) Return ChildCustomFields objects filtered by the is_required column
 * @method     ChildCustomFields[]|ObjectCollection findByIsActive(boolean $is_active) Return ChildCustomFields objects filtered by the is_active column
 * @method     ChildCustomFields[]|ObjectCollection findByOptions(string $options) Return ChildCustomFields objects filtered by the options column
 * @method     ChildCustomFields[]|ObjectCollection findByIsPrivate(boolean $is_private) Return ChildCustomFields objects filtered by the is_private column
 * @method     ChildCustomFields[]|ObjectCollection findByValidators(string $validators) Return ChildCustomFields objects filtered by the validators column
 * @method     ChildCustomFields[]|ObjectCollection findByclasses(string $classes) Return ChildCustomFields objects filtered by the classes column
 * @method     ChildCustomFields[]|ObjectCollection findByposition(int $position) Return ChildCustomFields objects filtered by the position column
 * @method     ChildCustomFields[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class CustomFieldsQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\CustomFieldsQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'Shop', $modelName = '\\CustomFields', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildCustomFieldsQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildCustomFieldsQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildCustomFieldsQuery) {
            return $criteria;
        }
        $query = new ChildCustomFieldsQuery();
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
     * @return ChildCustomFields|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = CustomFieldsTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(CustomFieldsTableMap::DATABASE_NAME);
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
     * @return ChildCustomFields A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, entity, field_type_id, field_name, is_required, is_active, options, is_private, validators, classes, position FROM custom_fields WHERE id = :p0';
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
            /** @var ChildCustomFields $obj */
            $obj = new ChildCustomFields();
            $obj->hydrate($row);
            CustomFieldsTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildCustomFields|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildCustomFieldsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(CustomFieldsTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildCustomFieldsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(CustomFieldsTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildCustomFieldsQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(CustomFieldsTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(CustomFieldsTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CustomFieldsTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the entity column
     *
     * Example usage:
     * <code>
     * $query->filterByEntity('fooValue');   // WHERE entity = 'fooValue'
     * $query->filterByEntity('%fooValue%'); // WHERE entity LIKE '%fooValue%'
     * </code>
     *
     * @param     string $entity The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCustomFieldsQuery The current query, for fluid interface
     */
    public function filterByEntity($entity = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($entity)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $entity)) {
                $entity = str_replace('*', '%', $entity);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CustomFieldsTableMap::COL_ENTITY, $entity, $comparison);
    }

    /**
     * Filter the query on the field_type_id column
     *
     * Example usage:
     * <code>
     * $query->filterBytypeId(1234); // WHERE field_type_id = 1234
     * $query->filterBytypeId(array(12, 34)); // WHERE field_type_id IN (12, 34)
     * $query->filterBytypeId(array('min' => 12)); // WHERE field_type_id > 12
     * </code>
     *
     * @param     mixed $typeId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCustomFieldsQuery The current query, for fluid interface
     */
    public function filterBytypeId($typeId = null, $comparison = null)
    {
        if (is_array($typeId)) {
            $useMinMax = false;
            if (isset($typeId['min'])) {
                $this->addUsingAlias(CustomFieldsTableMap::COL_FIELD_TYPE_ID, $typeId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($typeId['max'])) {
                $this->addUsingAlias(CustomFieldsTableMap::COL_FIELD_TYPE_ID, $typeId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CustomFieldsTableMap::COL_FIELD_TYPE_ID, $typeId, $comparison);
    }

    /**
     * Filter the query on the field_name column
     *
     * Example usage:
     * <code>
     * $query->filterByname('fooValue');   // WHERE field_name = 'fooValue'
     * $query->filterByname('%fooValue%'); // WHERE field_name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $name The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCustomFieldsQuery The current query, for fluid interface
     */
    public function filterByname($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $name)) {
                $name = str_replace('*', '%', $name);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CustomFieldsTableMap::COL_FIELD_NAME, $name, $comparison);
    }

    /**
     * Filter the query on the is_required column
     *
     * Example usage:
     * <code>
     * $query->filterByIsRequired(true); // WHERE is_required = true
     * $query->filterByIsRequired('yes'); // WHERE is_required = true
     * </code>
     *
     * @param     boolean|string $isRequired The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCustomFieldsQuery The current query, for fluid interface
     */
    public function filterByIsRequired($isRequired = null, $comparison = null)
    {
        if (is_string($isRequired)) {
            $isRequired = in_array(strtolower($isRequired), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(CustomFieldsTableMap::COL_IS_REQUIRED, $isRequired, $comparison);
    }

    /**
     * Filter the query on the is_active column
     *
     * Example usage:
     * <code>
     * $query->filterByIsActive(true); // WHERE is_active = true
     * $query->filterByIsActive('yes'); // WHERE is_active = true
     * </code>
     *
     * @param     boolean|string $isActive The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCustomFieldsQuery The current query, for fluid interface
     */
    public function filterByIsActive($isActive = null, $comparison = null)
    {
        if (is_string($isActive)) {
            $isActive = in_array(strtolower($isActive), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(CustomFieldsTableMap::COL_IS_ACTIVE, $isActive, $comparison);
    }

    /**
     * Filter the query on the options column
     *
     * Example usage:
     * <code>
     * $query->filterByOptions('fooValue');   // WHERE options = 'fooValue'
     * $query->filterByOptions('%fooValue%'); // WHERE options LIKE '%fooValue%'
     * </code>
     *
     * @param     string $options The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCustomFieldsQuery The current query, for fluid interface
     */
    public function filterByOptions($options = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($options)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $options)) {
                $options = str_replace('*', '%', $options);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CustomFieldsTableMap::COL_OPTIONS, $options, $comparison);
    }

    /**
     * Filter the query on the is_private column
     *
     * Example usage:
     * <code>
     * $query->filterByIsPrivate(true); // WHERE is_private = true
     * $query->filterByIsPrivate('yes'); // WHERE is_private = true
     * </code>
     *
     * @param     boolean|string $isPrivate The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCustomFieldsQuery The current query, for fluid interface
     */
    public function filterByIsPrivate($isPrivate = null, $comparison = null)
    {
        if (is_string($isPrivate)) {
            $isPrivate = in_array(strtolower($isPrivate), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(CustomFieldsTableMap::COL_IS_PRIVATE, $isPrivate, $comparison);
    }

    /**
     * Filter the query on the validators column
     *
     * Example usage:
     * <code>
     * $query->filterByValidators('fooValue');   // WHERE validators = 'fooValue'
     * $query->filterByValidators('%fooValue%'); // WHERE validators LIKE '%fooValue%'
     * </code>
     *
     * @param     string $validators The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCustomFieldsQuery The current query, for fluid interface
     */
    public function filterByValidators($validators = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($validators)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $validators)) {
                $validators = str_replace('*', '%', $validators);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CustomFieldsTableMap::COL_VALIDATORS, $validators, $comparison);
    }

    /**
     * Filter the query on the classes column
     *
     * Example usage:
     * <code>
     * $query->filterByclasses('fooValue');   // WHERE classes = 'fooValue'
     * $query->filterByclasses('%fooValue%'); // WHERE classes LIKE '%fooValue%'
     * </code>
     *
     * @param     string $classes The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCustomFieldsQuery The current query, for fluid interface
     */
    public function filterByclasses($classes = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($classes)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $classes)) {
                $classes = str_replace('*', '%', $classes);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CustomFieldsTableMap::COL_CLASSES, $classes, $comparison);
    }

    /**
     * Filter the query on the position column
     *
     * Example usage:
     * <code>
     * $query->filterByposition(1234); // WHERE position = 1234
     * $query->filterByposition(array(12, 34)); // WHERE position IN (12, 34)
     * $query->filterByposition(array('min' => 12)); // WHERE position > 12
     * </code>
     *
     * @param     mixed $position The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCustomFieldsQuery The current query, for fluid interface
     */
    public function filterByposition($position = null, $comparison = null)
    {
        if (is_array($position)) {
            $useMinMax = false;
            if (isset($position['min'])) {
                $this->addUsingAlias(CustomFieldsTableMap::COL_POSITION, $position['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($position['max'])) {
                $this->addUsingAlias(CustomFieldsTableMap::COL_POSITION, $position['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CustomFieldsTableMap::COL_POSITION, $position, $comparison);
    }

    /**
     * Filter the query by a related \CustomFieldsI18n object
     *
     * @param \CustomFieldsI18n|ObjectCollection $customFieldsI18n the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCustomFieldsQuery The current query, for fluid interface
     */
    public function filterByCustomFieldsI18n($customFieldsI18n, $comparison = null)
    {
        if ($customFieldsI18n instanceof \CustomFieldsI18n) {
            return $this
                ->addUsingAlias(CustomFieldsTableMap::COL_ID, $customFieldsI18n->getId(), $comparison);
        } elseif ($customFieldsI18n instanceof ObjectCollection) {
            return $this
                ->useCustomFieldsI18nQuery()
                ->filterByPrimaryKeys($customFieldsI18n->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByCustomFieldsI18n() only accepts arguments of type \CustomFieldsI18n or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the CustomFieldsI18n relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildCustomFieldsQuery The current query, for fluid interface
     */
    public function joinCustomFieldsI18n($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('CustomFieldsI18n');

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
            $this->addJoinObject($join, 'CustomFieldsI18n');
        }

        return $this;
    }

    /**
     * Use the CustomFieldsI18n relation CustomFieldsI18n object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \CustomFieldsI18nQuery A secondary query class using the current class as primary query
     */
    public function useCustomFieldsI18nQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinCustomFieldsI18n($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'CustomFieldsI18n', '\CustomFieldsI18nQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildCustomFields $customFields Object to remove from the list of results
     *
     * @return $this|ChildCustomFieldsQuery The current query, for fluid interface
     */
    public function prune($customFields = null)
    {
        if ($customFields) {
            $this->addUsingAlias(CustomFieldsTableMap::COL_ID, $customFields->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the custom_fields table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CustomFieldsTableMap::DATABASE_NAME);
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
            CustomFieldsTableMap::clearInstancePool();
            CustomFieldsTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(CustomFieldsTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(CustomFieldsTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            // cloning the Criteria in case it's modified by doSelect() or doSelectStmt()
            $c = clone $criteria;
            $affectedRows += $c->doOnDeleteCascade($con);

            CustomFieldsTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            CustomFieldsTableMap::clearRelatedInstancePool();

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
        $objects = ChildCustomFieldsQuery::create(null, $this)->find($con);
        foreach ($objects as $obj) {


            // delete related CustomFieldsI18n objects
            $query = new \CustomFieldsI18nQuery;

            $query->add(CustomFieldsI18nTableMap::COL_ID, $obj->getId());
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
     * @return    ChildCustomFieldsQuery The current query, for fluid interface
     */
    public function joinI18n($locale = 'ru', $relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $relationName = $relationAlias ? $relationAlias : 'CustomFieldsI18n';

        return $this
            ->joinCustomFieldsI18n($relationAlias, $joinType)
            ->addJoinCondition($relationName, $relationName . '.Locale = ?', $locale);
    }

    /**
     * Adds a JOIN clause to the query and hydrates the related I18n object.
     * Shortcut for $c->joinI18n($locale)->with()
     *
     * @param     string $locale Locale to use for the join condition, e.g. 'fr_FR'
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'. Defaults to left join.
     *
     * @return    $this|ChildCustomFieldsQuery The current query, for fluid interface
     */
    public function joinWithI18n($locale = 'ru', $joinType = Criteria::LEFT_JOIN)
    {
        $this
            ->joinI18n($locale, null, $joinType)
            ->with('CustomFieldsI18n');
        $this->with['CustomFieldsI18n']->setIsWithOneToMany(false);

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
     * @return    ChildCustomFieldsI18nQuery A secondary query class using the current class as primary query
     */
    public function useI18nQuery($locale = 'ru', $relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinI18n($locale, $relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'CustomFieldsI18n', '\CustomFieldsI18nQuery');
    }

} // CustomFieldsQuery
