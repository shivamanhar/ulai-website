<?php

namespace Base;

use \SCurrencies as ChildSCurrencies;
use \SCurrenciesQuery as ChildSCurrenciesQuery;
use \Exception;
use \PDO;
use Map\SCurrenciesTableMap;
use Map\SProductVariantsTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'shop_currencies' table.
 *
 *
 *
 * @method     ChildSCurrenciesQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildSCurrenciesQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method     ChildSCurrenciesQuery orderByMain($order = Criteria::ASC) Order by the main column
 * @method     ChildSCurrenciesQuery orderByIsDefault($order = Criteria::ASC) Order by the is_default column
 * @method     ChildSCurrenciesQuery orderByCode($order = Criteria::ASC) Order by the code column
 * @method     ChildSCurrenciesQuery orderBySymbol($order = Criteria::ASC) Order by the symbol column
 * @method     ChildSCurrenciesQuery orderByRate($order = Criteria::ASC) Order by the rate column
 * @method     ChildSCurrenciesQuery orderByShowonsite($order = Criteria::ASC) Order by the showOnSite column
 * @method     ChildSCurrenciesQuery orderByCurrencyTemplate($order = Criteria::ASC) Order by the currency_template column
 *
 * @method     ChildSCurrenciesQuery groupById() Group by the id column
 * @method     ChildSCurrenciesQuery groupByName() Group by the name column
 * @method     ChildSCurrenciesQuery groupByMain() Group by the main column
 * @method     ChildSCurrenciesQuery groupByIsDefault() Group by the is_default column
 * @method     ChildSCurrenciesQuery groupByCode() Group by the code column
 * @method     ChildSCurrenciesQuery groupBySymbol() Group by the symbol column
 * @method     ChildSCurrenciesQuery groupByRate() Group by the rate column
 * @method     ChildSCurrenciesQuery groupByShowonsite() Group by the showOnSite column
 * @method     ChildSCurrenciesQuery groupByCurrencyTemplate() Group by the currency_template column
 *
 * @method     ChildSCurrenciesQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildSCurrenciesQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildSCurrenciesQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildSCurrenciesQuery leftJoinCurrency($relationAlias = null) Adds a LEFT JOIN clause to the query using the Currency relation
 * @method     ChildSCurrenciesQuery rightJoinCurrency($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Currency relation
 * @method     ChildSCurrenciesQuery innerJoinCurrency($relationAlias = null) Adds a INNER JOIN clause to the query using the Currency relation
 *
 * @method     ChildSCurrenciesQuery leftJoinSPaymentMethods($relationAlias = null) Adds a LEFT JOIN clause to the query using the SPaymentMethods relation
 * @method     ChildSCurrenciesQuery rightJoinSPaymentMethods($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SPaymentMethods relation
 * @method     ChildSCurrenciesQuery innerJoinSPaymentMethods($relationAlias = null) Adds a INNER JOIN clause to the query using the SPaymentMethods relation
 *
 * @method     \SProductVariantsQuery|\SPaymentMethodsQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildSCurrencies findOne(ConnectionInterface $con = null) Return the first ChildSCurrencies matching the query
 * @method     ChildSCurrencies findOneOrCreate(ConnectionInterface $con = null) Return the first ChildSCurrencies matching the query, or a new ChildSCurrencies object populated from the query conditions when no match is found
 *
 * @method     ChildSCurrencies findOneById(int $id) Return the first ChildSCurrencies filtered by the id column
 * @method     ChildSCurrencies findOneByName(string $name) Return the first ChildSCurrencies filtered by the name column
 * @method     ChildSCurrencies findOneByMain(boolean $main) Return the first ChildSCurrencies filtered by the main column
 * @method     ChildSCurrencies findOneByIsDefault(boolean $is_default) Return the first ChildSCurrencies filtered by the is_default column
 * @method     ChildSCurrencies findOneByCode(string $code) Return the first ChildSCurrencies filtered by the code column
 * @method     ChildSCurrencies findOneBySymbol(string $symbol) Return the first ChildSCurrencies filtered by the symbol column
 * @method     ChildSCurrencies findOneByRate(string $rate) Return the first ChildSCurrencies filtered by the rate column
 * @method     ChildSCurrencies findOneByShowonsite(int $showOnSite) Return the first ChildSCurrencies filtered by the showOnSite column
 * @method     ChildSCurrencies findOneByCurrencyTemplate(string $currency_template) Return the first ChildSCurrencies filtered by the currency_template column *

 * @method     ChildSCurrencies requirePk($key, ConnectionInterface $con = null) Return the ChildSCurrencies by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSCurrencies requireOne(ConnectionInterface $con = null) Return the first ChildSCurrencies matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSCurrencies requireOneById(int $id) Return the first ChildSCurrencies filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSCurrencies requireOneByName(string $name) Return the first ChildSCurrencies filtered by the name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSCurrencies requireOneByMain(boolean $main) Return the first ChildSCurrencies filtered by the main column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSCurrencies requireOneByIsDefault(boolean $is_default) Return the first ChildSCurrencies filtered by the is_default column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSCurrencies requireOneByCode(string $code) Return the first ChildSCurrencies filtered by the code column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSCurrencies requireOneBySymbol(string $symbol) Return the first ChildSCurrencies filtered by the symbol column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSCurrencies requireOneByRate(string $rate) Return the first ChildSCurrencies filtered by the rate column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSCurrencies requireOneByShowonsite(int $showOnSite) Return the first ChildSCurrencies filtered by the showOnSite column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSCurrencies requireOneByCurrencyTemplate(string $currency_template) Return the first ChildSCurrencies filtered by the currency_template column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSCurrencies[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildSCurrencies objects based on current ModelCriteria
 * @method     ChildSCurrencies[]|ObjectCollection findById(int $id) Return ChildSCurrencies objects filtered by the id column
 * @method     ChildSCurrencies[]|ObjectCollection findByName(string $name) Return ChildSCurrencies objects filtered by the name column
 * @method     ChildSCurrencies[]|ObjectCollection findByMain(boolean $main) Return ChildSCurrencies objects filtered by the main column
 * @method     ChildSCurrencies[]|ObjectCollection findByIsDefault(boolean $is_default) Return ChildSCurrencies objects filtered by the is_default column
 * @method     ChildSCurrencies[]|ObjectCollection findByCode(string $code) Return ChildSCurrencies objects filtered by the code column
 * @method     ChildSCurrencies[]|ObjectCollection findBySymbol(string $symbol) Return ChildSCurrencies objects filtered by the symbol column
 * @method     ChildSCurrencies[]|ObjectCollection findByRate(string $rate) Return ChildSCurrencies objects filtered by the rate column
 * @method     ChildSCurrencies[]|ObjectCollection findByShowonsite(int $showOnSite) Return ChildSCurrencies objects filtered by the showOnSite column
 * @method     ChildSCurrencies[]|ObjectCollection findByCurrencyTemplate(string $currency_template) Return ChildSCurrencies objects filtered by the currency_template column
 * @method     ChildSCurrencies[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class SCurrenciesQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\SCurrenciesQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'Shop', $modelName = '\\SCurrencies', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildSCurrenciesQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildSCurrenciesQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildSCurrenciesQuery) {
            return $criteria;
        }
        $query = new ChildSCurrenciesQuery();
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
     * @return ChildSCurrencies|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = SCurrenciesTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(SCurrenciesTableMap::DATABASE_NAME);
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
     * @return ChildSCurrencies A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, name, main, is_default, code, symbol, rate, showOnSite, currency_template FROM shop_currencies WHERE id = :p0';
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
            /** @var ChildSCurrencies $obj */
            $obj = new ChildSCurrencies();
            $obj->hydrate($row);
            SCurrenciesTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildSCurrencies|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildSCurrenciesQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(SCurrenciesTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildSCurrenciesQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(SCurrenciesTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildSCurrenciesQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(SCurrenciesTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(SCurrenciesTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SCurrenciesTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildSCurrenciesQuery The current query, for fluid interface
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

        return $this->addUsingAlias(SCurrenciesTableMap::COL_NAME, $name, $comparison);
    }

    /**
     * Filter the query on the main column
     *
     * Example usage:
     * <code>
     * $query->filterByMain(true); // WHERE main = true
     * $query->filterByMain('yes'); // WHERE main = true
     * </code>
     *
     * @param     boolean|string $main The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSCurrenciesQuery The current query, for fluid interface
     */
    public function filterByMain($main = null, $comparison = null)
    {
        if (is_string($main)) {
            $main = in_array(strtolower($main), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(SCurrenciesTableMap::COL_MAIN, $main, $comparison);
    }

    /**
     * Filter the query on the is_default column
     *
     * Example usage:
     * <code>
     * $query->filterByIsDefault(true); // WHERE is_default = true
     * $query->filterByIsDefault('yes'); // WHERE is_default = true
     * </code>
     *
     * @param     boolean|string $isDefault The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSCurrenciesQuery The current query, for fluid interface
     */
    public function filterByIsDefault($isDefault = null, $comparison = null)
    {
        if (is_string($isDefault)) {
            $isDefault = in_array(strtolower($isDefault), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(SCurrenciesTableMap::COL_IS_DEFAULT, $isDefault, $comparison);
    }

    /**
     * Filter the query on the code column
     *
     * Example usage:
     * <code>
     * $query->filterByCode('fooValue');   // WHERE code = 'fooValue'
     * $query->filterByCode('%fooValue%'); // WHERE code LIKE '%fooValue%'
     * </code>
     *
     * @param     string $code The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSCurrenciesQuery The current query, for fluid interface
     */
    public function filterByCode($code = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($code)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $code)) {
                $code = str_replace('*', '%', $code);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SCurrenciesTableMap::COL_CODE, $code, $comparison);
    }

    /**
     * Filter the query on the symbol column
     *
     * Example usage:
     * <code>
     * $query->filterBySymbol('fooValue');   // WHERE symbol = 'fooValue'
     * $query->filterBySymbol('%fooValue%'); // WHERE symbol LIKE '%fooValue%'
     * </code>
     *
     * @param     string $symbol The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSCurrenciesQuery The current query, for fluid interface
     */
    public function filterBySymbol($symbol = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($symbol)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $symbol)) {
                $symbol = str_replace('*', '%', $symbol);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SCurrenciesTableMap::COL_SYMBOL, $symbol, $comparison);
    }

    /**
     * Filter the query on the rate column
     *
     * Example usage:
     * <code>
     * $query->filterByRate(1234); // WHERE rate = 1234
     * $query->filterByRate(array(12, 34)); // WHERE rate IN (12, 34)
     * $query->filterByRate(array('min' => 12)); // WHERE rate > 12
     * </code>
     *
     * @param     mixed $rate The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSCurrenciesQuery The current query, for fluid interface
     */
    public function filterByRate($rate = null, $comparison = null)
    {
        if (is_array($rate)) {
            $useMinMax = false;
            if (isset($rate['min'])) {
                $this->addUsingAlias(SCurrenciesTableMap::COL_RATE, $rate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($rate['max'])) {
                $this->addUsingAlias(SCurrenciesTableMap::COL_RATE, $rate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SCurrenciesTableMap::COL_RATE, $rate, $comparison);
    }

    /**
     * Filter the query on the showOnSite column
     *
     * Example usage:
     * <code>
     * $query->filterByShowonsite(1234); // WHERE showOnSite = 1234
     * $query->filterByShowonsite(array(12, 34)); // WHERE showOnSite IN (12, 34)
     * $query->filterByShowonsite(array('min' => 12)); // WHERE showOnSite > 12
     * </code>
     *
     * @param     mixed $showonsite The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSCurrenciesQuery The current query, for fluid interface
     */
    public function filterByShowonsite($showonsite = null, $comparison = null)
    {
        if (is_array($showonsite)) {
            $useMinMax = false;
            if (isset($showonsite['min'])) {
                $this->addUsingAlias(SCurrenciesTableMap::COL_SHOWONSITE, $showonsite['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($showonsite['max'])) {
                $this->addUsingAlias(SCurrenciesTableMap::COL_SHOWONSITE, $showonsite['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SCurrenciesTableMap::COL_SHOWONSITE, $showonsite, $comparison);
    }

    /**
     * Filter the query on the currency_template column
     *
     * Example usage:
     * <code>
     * $query->filterByCurrencyTemplate('fooValue');   // WHERE currency_template = 'fooValue'
     * $query->filterByCurrencyTemplate('%fooValue%'); // WHERE currency_template LIKE '%fooValue%'
     * </code>
     *
     * @param     string $currencyTemplate The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSCurrenciesQuery The current query, for fluid interface
     */
    public function filterByCurrencyTemplate($currencyTemplate = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($currencyTemplate)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $currencyTemplate)) {
                $currencyTemplate = str_replace('*', '%', $currencyTemplate);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SCurrenciesTableMap::COL_CURRENCY_TEMPLATE, $currencyTemplate, $comparison);
    }

    /**
     * Filter the query by a related \SProductVariants object
     *
     * @param \SProductVariants|ObjectCollection $sProductVariants the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSCurrenciesQuery The current query, for fluid interface
     */
    public function filterByCurrency($sProductVariants, $comparison = null)
    {
        if ($sProductVariants instanceof \SProductVariants) {
            return $this
                ->addUsingAlias(SCurrenciesTableMap::COL_ID, $sProductVariants->getCurrency(), $comparison);
        } elseif ($sProductVariants instanceof ObjectCollection) {
            return $this
                ->useCurrencyQuery()
                ->filterByPrimaryKeys($sProductVariants->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByCurrency() only accepts arguments of type \SProductVariants or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Currency relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSCurrenciesQuery The current query, for fluid interface
     */
    public function joinCurrency($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Currency');

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
            $this->addJoinObject($join, 'Currency');
        }

        return $this;
    }

    /**
     * Use the Currency relation SProductVariants object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \SProductVariantsQuery A secondary query class using the current class as primary query
     */
    public function useCurrencyQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinCurrency($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Currency', '\SProductVariantsQuery');
    }

    /**
     * Filter the query by a related \SPaymentMethods object
     *
     * @param \SPaymentMethods|ObjectCollection $sPaymentMethods the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSCurrenciesQuery The current query, for fluid interface
     */
    public function filterBySPaymentMethods($sPaymentMethods, $comparison = null)
    {
        if ($sPaymentMethods instanceof \SPaymentMethods) {
            return $this
                ->addUsingAlias(SCurrenciesTableMap::COL_ID, $sPaymentMethods->getCurrencyId(), $comparison);
        } elseif ($sPaymentMethods instanceof ObjectCollection) {
            return $this
                ->useSPaymentMethodsQuery()
                ->filterByPrimaryKeys($sPaymentMethods->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterBySPaymentMethods() only accepts arguments of type \SPaymentMethods or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the SPaymentMethods relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSCurrenciesQuery The current query, for fluid interface
     */
    public function joinSPaymentMethods($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('SPaymentMethods');

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
            $this->addJoinObject($join, 'SPaymentMethods');
        }

        return $this;
    }

    /**
     * Use the SPaymentMethods relation SPaymentMethods object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \SPaymentMethodsQuery A secondary query class using the current class as primary query
     */
    public function useSPaymentMethodsQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinSPaymentMethods($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'SPaymentMethods', '\SPaymentMethodsQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildSCurrencies $sCurrencies Object to remove from the list of results
     *
     * @return $this|ChildSCurrenciesQuery The current query, for fluid interface
     */
    public function prune($sCurrencies = null)
    {
        if ($sCurrencies) {
            $this->addUsingAlias(SCurrenciesTableMap::COL_ID, $sCurrencies->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the shop_currencies table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SCurrenciesTableMap::DATABASE_NAME);
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
            SCurrenciesTableMap::clearInstancePool();
            SCurrenciesTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(SCurrenciesTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(SCurrenciesTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            // cloning the Criteria in case it's modified by doSelect() or doSelectStmt()
            $c = clone $criteria;
            $affectedRows += $c->doOnDeleteCascade($con);

            SCurrenciesTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            SCurrenciesTableMap::clearRelatedInstancePool();

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
        $objects = ChildSCurrenciesQuery::create(null, $this)->find($con);
        foreach ($objects as $obj) {


            // delete related SProductVariants objects
            $query = new \SProductVariantsQuery;

            $query->add(SProductVariantsTableMap::COL_CURRENCY, $obj->getId());
            $affectedRows += $query->delete($con);
        }

        return $affectedRows;
    }

} // SCurrenciesQuery
