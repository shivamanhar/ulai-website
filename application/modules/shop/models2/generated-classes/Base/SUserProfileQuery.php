<?php

namespace Base;

use \SUserProfile as ChildSUserProfile;
use \SUserProfileQuery as ChildSUserProfileQuery;
use \Exception;
use \PDO;
use Map\SUserProfileTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'users' table.
 *
 *
 *
 * @method     ChildSUserProfileQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildSUserProfileQuery orderByRoleId($order = Criteria::ASC) Order by the role_id column
 * @method     ChildSUserProfileQuery orderByName($order = Criteria::ASC) Order by the username column
 * @method     ChildSUserProfileQuery orderByPassword($order = Criteria::ASC) Order by the password column
 * @method     ChildSUserProfileQuery orderByUserEmail($order = Criteria::ASC) Order by the email column
 * @method     ChildSUserProfileQuery orderByAddress($order = Criteria::ASC) Order by the address column
 * @method     ChildSUserProfileQuery orderByPhone($order = Criteria::ASC) Order by the phone column
 * @method     ChildSUserProfileQuery orderByBanned($order = Criteria::ASC) Order by the banned column
 * @method     ChildSUserProfileQuery orderByBanReason($order = Criteria::ASC) Order by the ban_reason column
 * @method     ChildSUserProfileQuery orderByNewpass($order = Criteria::ASC) Order by the newpass column
 * @method     ChildSUserProfileQuery orderByNewpassKey($order = Criteria::ASC) Order by the newpass_key column
 * @method     ChildSUserProfileQuery orderByNewpassTime($order = Criteria::ASC) Order by the newpass_time column
 * @method     ChildSUserProfileQuery orderByDateCreated($order = Criteria::ASC) Order by the created column
 * @method     ChildSUserProfileQuery orderByLastIp($order = Criteria::ASC) Order by the last_ip column
 * @method     ChildSUserProfileQuery orderByLastLogin($order = Criteria::ASC) Order by the last_login column
 * @method     ChildSUserProfileQuery orderByModified($order = Criteria::ASC) Order by the modified column
 * @method     ChildSUserProfileQuery orderByCartData($order = Criteria::ASC) Order by the cart_data column
 * @method     ChildSUserProfileQuery orderByWishListData($order = Criteria::ASC) Order by the wish_list_data column
 * @method     ChildSUserProfileQuery orderByKey($order = Criteria::ASC) Order by the key column
 * @method     ChildSUserProfileQuery orderByAmout($order = Criteria::ASC) Order by the amout column
 * @method     ChildSUserProfileQuery orderByDiscount($order = Criteria::ASC) Order by the discount column
 *
 * @method     ChildSUserProfileQuery groupById() Group by the id column
 * @method     ChildSUserProfileQuery groupByRoleId() Group by the role_id column
 * @method     ChildSUserProfileQuery groupByName() Group by the username column
 * @method     ChildSUserProfileQuery groupByPassword() Group by the password column
 * @method     ChildSUserProfileQuery groupByUserEmail() Group by the email column
 * @method     ChildSUserProfileQuery groupByAddress() Group by the address column
 * @method     ChildSUserProfileQuery groupByPhone() Group by the phone column
 * @method     ChildSUserProfileQuery groupByBanned() Group by the banned column
 * @method     ChildSUserProfileQuery groupByBanReason() Group by the ban_reason column
 * @method     ChildSUserProfileQuery groupByNewpass() Group by the newpass column
 * @method     ChildSUserProfileQuery groupByNewpassKey() Group by the newpass_key column
 * @method     ChildSUserProfileQuery groupByNewpassTime() Group by the newpass_time column
 * @method     ChildSUserProfileQuery groupByDateCreated() Group by the created column
 * @method     ChildSUserProfileQuery groupByLastIp() Group by the last_ip column
 * @method     ChildSUserProfileQuery groupByLastLogin() Group by the last_login column
 * @method     ChildSUserProfileQuery groupByModified() Group by the modified column
 * @method     ChildSUserProfileQuery groupByCartData() Group by the cart_data column
 * @method     ChildSUserProfileQuery groupByWishListData() Group by the wish_list_data column
 * @method     ChildSUserProfileQuery groupByKey() Group by the key column
 * @method     ChildSUserProfileQuery groupByAmout() Group by the amout column
 * @method     ChildSUserProfileQuery groupByDiscount() Group by the discount column
 *
 * @method     ChildSUserProfileQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildSUserProfileQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildSUserProfileQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildSUserProfile findOne(ConnectionInterface $con = null) Return the first ChildSUserProfile matching the query
 * @method     ChildSUserProfile findOneOrCreate(ConnectionInterface $con = null) Return the first ChildSUserProfile matching the query, or a new ChildSUserProfile object populated from the query conditions when no match is found
 *
 * @method     ChildSUserProfile findOneById(int $id) Return the first ChildSUserProfile filtered by the id column
 * @method     ChildSUserProfile findOneByRoleId(int $role_id) Return the first ChildSUserProfile filtered by the role_id column
 * @method     ChildSUserProfile findOneByName(string $username) Return the first ChildSUserProfile filtered by the username column
 * @method     ChildSUserProfile findOneByPassword(string $password) Return the first ChildSUserProfile filtered by the password column
 * @method     ChildSUserProfile findOneByUserEmail(string $email) Return the first ChildSUserProfile filtered by the email column
 * @method     ChildSUserProfile findOneByAddress(string $address) Return the first ChildSUserProfile filtered by the address column
 * @method     ChildSUserProfile findOneByPhone(string $phone) Return the first ChildSUserProfile filtered by the phone column
 * @method     ChildSUserProfile findOneByBanned(int $banned) Return the first ChildSUserProfile filtered by the banned column
 * @method     ChildSUserProfile findOneByBanReason(string $ban_reason) Return the first ChildSUserProfile filtered by the ban_reason column
 * @method     ChildSUserProfile findOneByNewpass(string $newpass) Return the first ChildSUserProfile filtered by the newpass column
 * @method     ChildSUserProfile findOneByNewpassKey(string $newpass_key) Return the first ChildSUserProfile filtered by the newpass_key column
 * @method     ChildSUserProfile findOneByNewpassTime(int $newpass_time) Return the first ChildSUserProfile filtered by the newpass_time column
 * @method     ChildSUserProfile findOneByDateCreated(int $created) Return the first ChildSUserProfile filtered by the created column
 * @method     ChildSUserProfile findOneByLastIp(string $last_ip) Return the first ChildSUserProfile filtered by the last_ip column
 * @method     ChildSUserProfile findOneByLastLogin(int $last_login) Return the first ChildSUserProfile filtered by the last_login column
 * @method     ChildSUserProfile findOneByModified(string $modified) Return the first ChildSUserProfile filtered by the modified column
 * @method     ChildSUserProfile findOneByCartData(string $cart_data) Return the first ChildSUserProfile filtered by the cart_data column
 * @method     ChildSUserProfile findOneByWishListData(string $wish_list_data) Return the first ChildSUserProfile filtered by the wish_list_data column
 * @method     ChildSUserProfile findOneByKey(string $key) Return the first ChildSUserProfile filtered by the key column
 * @method     ChildSUserProfile findOneByAmout(string $amout) Return the first ChildSUserProfile filtered by the amout column
 * @method     ChildSUserProfile findOneByDiscount(string $discount) Return the first ChildSUserProfile filtered by the discount column *

 * @method     ChildSUserProfile requirePk($key, ConnectionInterface $con = null) Return the ChildSUserProfile by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSUserProfile requireOne(ConnectionInterface $con = null) Return the first ChildSUserProfile matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSUserProfile requireOneById(int $id) Return the first ChildSUserProfile filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSUserProfile requireOneByRoleId(int $role_id) Return the first ChildSUserProfile filtered by the role_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSUserProfile requireOneByName(string $username) Return the first ChildSUserProfile filtered by the username column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSUserProfile requireOneByPassword(string $password) Return the first ChildSUserProfile filtered by the password column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSUserProfile requireOneByUserEmail(string $email) Return the first ChildSUserProfile filtered by the email column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSUserProfile requireOneByAddress(string $address) Return the first ChildSUserProfile filtered by the address column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSUserProfile requireOneByPhone(string $phone) Return the first ChildSUserProfile filtered by the phone column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSUserProfile requireOneByBanned(int $banned) Return the first ChildSUserProfile filtered by the banned column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSUserProfile requireOneByBanReason(string $ban_reason) Return the first ChildSUserProfile filtered by the ban_reason column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSUserProfile requireOneByNewpass(string $newpass) Return the first ChildSUserProfile filtered by the newpass column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSUserProfile requireOneByNewpassKey(string $newpass_key) Return the first ChildSUserProfile filtered by the newpass_key column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSUserProfile requireOneByNewpassTime(int $newpass_time) Return the first ChildSUserProfile filtered by the newpass_time column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSUserProfile requireOneByDateCreated(int $created) Return the first ChildSUserProfile filtered by the created column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSUserProfile requireOneByLastIp(string $last_ip) Return the first ChildSUserProfile filtered by the last_ip column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSUserProfile requireOneByLastLogin(int $last_login) Return the first ChildSUserProfile filtered by the last_login column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSUserProfile requireOneByModified(string $modified) Return the first ChildSUserProfile filtered by the modified column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSUserProfile requireOneByCartData(string $cart_data) Return the first ChildSUserProfile filtered by the cart_data column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSUserProfile requireOneByWishListData(string $wish_list_data) Return the first ChildSUserProfile filtered by the wish_list_data column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSUserProfile requireOneByKey(string $key) Return the first ChildSUserProfile filtered by the key column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSUserProfile requireOneByAmout(string $amout) Return the first ChildSUserProfile filtered by the amout column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSUserProfile requireOneByDiscount(string $discount) Return the first ChildSUserProfile filtered by the discount column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSUserProfile[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildSUserProfile objects based on current ModelCriteria
 * @method     ChildSUserProfile[]|ObjectCollection findById(int $id) Return ChildSUserProfile objects filtered by the id column
 * @method     ChildSUserProfile[]|ObjectCollection findByRoleId(int $role_id) Return ChildSUserProfile objects filtered by the role_id column
 * @method     ChildSUserProfile[]|ObjectCollection findByName(string $username) Return ChildSUserProfile objects filtered by the username column
 * @method     ChildSUserProfile[]|ObjectCollection findByPassword(string $password) Return ChildSUserProfile objects filtered by the password column
 * @method     ChildSUserProfile[]|ObjectCollection findByUserEmail(string $email) Return ChildSUserProfile objects filtered by the email column
 * @method     ChildSUserProfile[]|ObjectCollection findByAddress(string $address) Return ChildSUserProfile objects filtered by the address column
 * @method     ChildSUserProfile[]|ObjectCollection findByPhone(string $phone) Return ChildSUserProfile objects filtered by the phone column
 * @method     ChildSUserProfile[]|ObjectCollection findByBanned(int $banned) Return ChildSUserProfile objects filtered by the banned column
 * @method     ChildSUserProfile[]|ObjectCollection findByBanReason(string $ban_reason) Return ChildSUserProfile objects filtered by the ban_reason column
 * @method     ChildSUserProfile[]|ObjectCollection findByNewpass(string $newpass) Return ChildSUserProfile objects filtered by the newpass column
 * @method     ChildSUserProfile[]|ObjectCollection findByNewpassKey(string $newpass_key) Return ChildSUserProfile objects filtered by the newpass_key column
 * @method     ChildSUserProfile[]|ObjectCollection findByNewpassTime(int $newpass_time) Return ChildSUserProfile objects filtered by the newpass_time column
 * @method     ChildSUserProfile[]|ObjectCollection findByDateCreated(int $created) Return ChildSUserProfile objects filtered by the created column
 * @method     ChildSUserProfile[]|ObjectCollection findByLastIp(string $last_ip) Return ChildSUserProfile objects filtered by the last_ip column
 * @method     ChildSUserProfile[]|ObjectCollection findByLastLogin(int $last_login) Return ChildSUserProfile objects filtered by the last_login column
 * @method     ChildSUserProfile[]|ObjectCollection findByModified(string $modified) Return ChildSUserProfile objects filtered by the modified column
 * @method     ChildSUserProfile[]|ObjectCollection findByCartData(string $cart_data) Return ChildSUserProfile objects filtered by the cart_data column
 * @method     ChildSUserProfile[]|ObjectCollection findByWishListData(string $wish_list_data) Return ChildSUserProfile objects filtered by the wish_list_data column
 * @method     ChildSUserProfile[]|ObjectCollection findByKey(string $key) Return ChildSUserProfile objects filtered by the key column
 * @method     ChildSUserProfile[]|ObjectCollection findByAmout(string $amout) Return ChildSUserProfile objects filtered by the amout column
 * @method     ChildSUserProfile[]|ObjectCollection findByDiscount(string $discount) Return ChildSUserProfile objects filtered by the discount column
 * @method     ChildSUserProfile[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class SUserProfileQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\SUserProfileQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'Shop', $modelName = '\\SUserProfile', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildSUserProfileQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildSUserProfileQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildSUserProfileQuery) {
            return $criteria;
        }
        $query = new ChildSUserProfileQuery();
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
     * @return ChildSUserProfile|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = SUserProfileTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(SUserProfileTableMap::DATABASE_NAME);
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
     * @return ChildSUserProfile A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, role_id, username, password, email, address, phone, banned, ban_reason, newpass, newpass_key, newpass_time, created, last_ip, last_login, modified, cart_data, wish_list_data, key, amout, discount FROM users WHERE id = :p0';
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
            /** @var ChildSUserProfile $obj */
            $obj = new ChildSUserProfile();
            $obj->hydrate($row);
            SUserProfileTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildSUserProfile|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildSUserProfileQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(SUserProfileTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildSUserProfileQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(SUserProfileTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildSUserProfileQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(SUserProfileTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(SUserProfileTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SUserProfileTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the role_id column
     *
     * Example usage:
     * <code>
     * $query->filterByRoleId(1234); // WHERE role_id = 1234
     * $query->filterByRoleId(array(12, 34)); // WHERE role_id IN (12, 34)
     * $query->filterByRoleId(array('min' => 12)); // WHERE role_id > 12
     * </code>
     *
     * @param     mixed $roleId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSUserProfileQuery The current query, for fluid interface
     */
    public function filterByRoleId($roleId = null, $comparison = null)
    {
        if (is_array($roleId)) {
            $useMinMax = false;
            if (isset($roleId['min'])) {
                $this->addUsingAlias(SUserProfileTableMap::COL_ROLE_ID, $roleId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($roleId['max'])) {
                $this->addUsingAlias(SUserProfileTableMap::COL_ROLE_ID, $roleId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SUserProfileTableMap::COL_ROLE_ID, $roleId, $comparison);
    }

    /**
     * Filter the query on the username column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue');   // WHERE username = 'fooValue'
     * $query->filterByName('%fooValue%'); // WHERE username LIKE '%fooValue%'
     * </code>
     *
     * @param     string $name The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSUserProfileQuery The current query, for fluid interface
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

        return $this->addUsingAlias(SUserProfileTableMap::COL_USERNAME, $name, $comparison);
    }

    /**
     * Filter the query on the password column
     *
     * Example usage:
     * <code>
     * $query->filterByPassword('fooValue');   // WHERE password = 'fooValue'
     * $query->filterByPassword('%fooValue%'); // WHERE password LIKE '%fooValue%'
     * </code>
     *
     * @param     string $password The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSUserProfileQuery The current query, for fluid interface
     */
    public function filterByPassword($password = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($password)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $password)) {
                $password = str_replace('*', '%', $password);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SUserProfileTableMap::COL_PASSWORD, $password, $comparison);
    }

    /**
     * Filter the query on the email column
     *
     * Example usage:
     * <code>
     * $query->filterByUserEmail('fooValue');   // WHERE email = 'fooValue'
     * $query->filterByUserEmail('%fooValue%'); // WHERE email LIKE '%fooValue%'
     * </code>
     *
     * @param     string $userEmail The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSUserProfileQuery The current query, for fluid interface
     */
    public function filterByUserEmail($userEmail = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($userEmail)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $userEmail)) {
                $userEmail = str_replace('*', '%', $userEmail);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SUserProfileTableMap::COL_EMAIL, $userEmail, $comparison);
    }

    /**
     * Filter the query on the address column
     *
     * Example usage:
     * <code>
     * $query->filterByAddress('fooValue');   // WHERE address = 'fooValue'
     * $query->filterByAddress('%fooValue%'); // WHERE address LIKE '%fooValue%'
     * </code>
     *
     * @param     string $address The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSUserProfileQuery The current query, for fluid interface
     */
    public function filterByAddress($address = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($address)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $address)) {
                $address = str_replace('*', '%', $address);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SUserProfileTableMap::COL_ADDRESS, $address, $comparison);
    }

    /**
     * Filter the query on the phone column
     *
     * Example usage:
     * <code>
     * $query->filterByPhone('fooValue');   // WHERE phone = 'fooValue'
     * $query->filterByPhone('%fooValue%'); // WHERE phone LIKE '%fooValue%'
     * </code>
     *
     * @param     string $phone The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSUserProfileQuery The current query, for fluid interface
     */
    public function filterByPhone($phone = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($phone)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $phone)) {
                $phone = str_replace('*', '%', $phone);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SUserProfileTableMap::COL_PHONE, $phone, $comparison);
    }

    /**
     * Filter the query on the banned column
     *
     * Example usage:
     * <code>
     * $query->filterByBanned(1234); // WHERE banned = 1234
     * $query->filterByBanned(array(12, 34)); // WHERE banned IN (12, 34)
     * $query->filterByBanned(array('min' => 12)); // WHERE banned > 12
     * </code>
     *
     * @param     mixed $banned The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSUserProfileQuery The current query, for fluid interface
     */
    public function filterByBanned($banned = null, $comparison = null)
    {
        if (is_array($banned)) {
            $useMinMax = false;
            if (isset($banned['min'])) {
                $this->addUsingAlias(SUserProfileTableMap::COL_BANNED, $banned['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($banned['max'])) {
                $this->addUsingAlias(SUserProfileTableMap::COL_BANNED, $banned['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SUserProfileTableMap::COL_BANNED, $banned, $comparison);
    }

    /**
     * Filter the query on the ban_reason column
     *
     * Example usage:
     * <code>
     * $query->filterByBanReason('fooValue');   // WHERE ban_reason = 'fooValue'
     * $query->filterByBanReason('%fooValue%'); // WHERE ban_reason LIKE '%fooValue%'
     * </code>
     *
     * @param     string $banReason The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSUserProfileQuery The current query, for fluid interface
     */
    public function filterByBanReason($banReason = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($banReason)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $banReason)) {
                $banReason = str_replace('*', '%', $banReason);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SUserProfileTableMap::COL_BAN_REASON, $banReason, $comparison);
    }

    /**
     * Filter the query on the newpass column
     *
     * Example usage:
     * <code>
     * $query->filterByNewpass('fooValue');   // WHERE newpass = 'fooValue'
     * $query->filterByNewpass('%fooValue%'); // WHERE newpass LIKE '%fooValue%'
     * </code>
     *
     * @param     string $newpass The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSUserProfileQuery The current query, for fluid interface
     */
    public function filterByNewpass($newpass = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($newpass)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $newpass)) {
                $newpass = str_replace('*', '%', $newpass);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SUserProfileTableMap::COL_NEWPASS, $newpass, $comparison);
    }

    /**
     * Filter the query on the newpass_key column
     *
     * Example usage:
     * <code>
     * $query->filterByNewpassKey('fooValue');   // WHERE newpass_key = 'fooValue'
     * $query->filterByNewpassKey('%fooValue%'); // WHERE newpass_key LIKE '%fooValue%'
     * </code>
     *
     * @param     string $newpassKey The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSUserProfileQuery The current query, for fluid interface
     */
    public function filterByNewpassKey($newpassKey = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($newpassKey)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $newpassKey)) {
                $newpassKey = str_replace('*', '%', $newpassKey);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SUserProfileTableMap::COL_NEWPASS_KEY, $newpassKey, $comparison);
    }

    /**
     * Filter the query on the newpass_time column
     *
     * Example usage:
     * <code>
     * $query->filterByNewpassTime(1234); // WHERE newpass_time = 1234
     * $query->filterByNewpassTime(array(12, 34)); // WHERE newpass_time IN (12, 34)
     * $query->filterByNewpassTime(array('min' => 12)); // WHERE newpass_time > 12
     * </code>
     *
     * @param     mixed $newpassTime The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSUserProfileQuery The current query, for fluid interface
     */
    public function filterByNewpassTime($newpassTime = null, $comparison = null)
    {
        if (is_array($newpassTime)) {
            $useMinMax = false;
            if (isset($newpassTime['min'])) {
                $this->addUsingAlias(SUserProfileTableMap::COL_NEWPASS_TIME, $newpassTime['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($newpassTime['max'])) {
                $this->addUsingAlias(SUserProfileTableMap::COL_NEWPASS_TIME, $newpassTime['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SUserProfileTableMap::COL_NEWPASS_TIME, $newpassTime, $comparison);
    }

    /**
     * Filter the query on the created column
     *
     * Example usage:
     * <code>
     * $query->filterByDateCreated(1234); // WHERE created = 1234
     * $query->filterByDateCreated(array(12, 34)); // WHERE created IN (12, 34)
     * $query->filterByDateCreated(array('min' => 12)); // WHERE created > 12
     * </code>
     *
     * @param     mixed $dateCreated The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSUserProfileQuery The current query, for fluid interface
     */
    public function filterByDateCreated($dateCreated = null, $comparison = null)
    {
        if (is_array($dateCreated)) {
            $useMinMax = false;
            if (isset($dateCreated['min'])) {
                $this->addUsingAlias(SUserProfileTableMap::COL_CREATED, $dateCreated['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dateCreated['max'])) {
                $this->addUsingAlias(SUserProfileTableMap::COL_CREATED, $dateCreated['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SUserProfileTableMap::COL_CREATED, $dateCreated, $comparison);
    }

    /**
     * Filter the query on the last_ip column
     *
     * Example usage:
     * <code>
     * $query->filterByLastIp('fooValue');   // WHERE last_ip = 'fooValue'
     * $query->filterByLastIp('%fooValue%'); // WHERE last_ip LIKE '%fooValue%'
     * </code>
     *
     * @param     string $lastIp The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSUserProfileQuery The current query, for fluid interface
     */
    public function filterByLastIp($lastIp = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($lastIp)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $lastIp)) {
                $lastIp = str_replace('*', '%', $lastIp);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SUserProfileTableMap::COL_LAST_IP, $lastIp, $comparison);
    }

    /**
     * Filter the query on the last_login column
     *
     * Example usage:
     * <code>
     * $query->filterByLastLogin(1234); // WHERE last_login = 1234
     * $query->filterByLastLogin(array(12, 34)); // WHERE last_login IN (12, 34)
     * $query->filterByLastLogin(array('min' => 12)); // WHERE last_login > 12
     * </code>
     *
     * @param     mixed $lastLogin The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSUserProfileQuery The current query, for fluid interface
     */
    public function filterByLastLogin($lastLogin = null, $comparison = null)
    {
        if (is_array($lastLogin)) {
            $useMinMax = false;
            if (isset($lastLogin['min'])) {
                $this->addUsingAlias(SUserProfileTableMap::COL_LAST_LOGIN, $lastLogin['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($lastLogin['max'])) {
                $this->addUsingAlias(SUserProfileTableMap::COL_LAST_LOGIN, $lastLogin['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SUserProfileTableMap::COL_LAST_LOGIN, $lastLogin, $comparison);
    }

    /**
     * Filter the query on the modified column
     *
     * Example usage:
     * <code>
     * $query->filterByModified('2011-03-14'); // WHERE modified = '2011-03-14'
     * $query->filterByModified('now'); // WHERE modified = '2011-03-14'
     * $query->filterByModified(array('max' => 'yesterday')); // WHERE modified > '2011-03-13'
     * </code>
     *
     * @param     mixed $modified The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSUserProfileQuery The current query, for fluid interface
     */
    public function filterByModified($modified = null, $comparison = null)
    {
        if (is_array($modified)) {
            $useMinMax = false;
            if (isset($modified['min'])) {
                $this->addUsingAlias(SUserProfileTableMap::COL_MODIFIED, $modified['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($modified['max'])) {
                $this->addUsingAlias(SUserProfileTableMap::COL_MODIFIED, $modified['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SUserProfileTableMap::COL_MODIFIED, $modified, $comparison);
    }

    /**
     * Filter the query on the cart_data column
     *
     * Example usage:
     * <code>
     * $query->filterByCartData('fooValue');   // WHERE cart_data = 'fooValue'
     * $query->filterByCartData('%fooValue%'); // WHERE cart_data LIKE '%fooValue%'
     * </code>
     *
     * @param     string $cartData The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSUserProfileQuery The current query, for fluid interface
     */
    public function filterByCartData($cartData = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($cartData)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $cartData)) {
                $cartData = str_replace('*', '%', $cartData);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SUserProfileTableMap::COL_CART_DATA, $cartData, $comparison);
    }

    /**
     * Filter the query on the wish_list_data column
     *
     * Example usage:
     * <code>
     * $query->filterByWishListData('fooValue');   // WHERE wish_list_data = 'fooValue'
     * $query->filterByWishListData('%fooValue%'); // WHERE wish_list_data LIKE '%fooValue%'
     * </code>
     *
     * @param     string $wishListData The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSUserProfileQuery The current query, for fluid interface
     */
    public function filterByWishListData($wishListData = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($wishListData)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $wishListData)) {
                $wishListData = str_replace('*', '%', $wishListData);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SUserProfileTableMap::COL_WISH_LIST_DATA, $wishListData, $comparison);
    }

    /**
     * Filter the query on the key column
     *
     * Example usage:
     * <code>
     * $query->filterByKey('fooValue');   // WHERE key = 'fooValue'
     * $query->filterByKey('%fooValue%'); // WHERE key LIKE '%fooValue%'
     * </code>
     *
     * @param     string $key The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSUserProfileQuery The current query, for fluid interface
     */
    public function filterByKey($key = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($key)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $key)) {
                $key = str_replace('*', '%', $key);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SUserProfileTableMap::COL_KEY, $key, $comparison);
    }

    /**
     * Filter the query on the amout column
     *
     * Example usage:
     * <code>
     * $query->filterByAmout(1234); // WHERE amout = 1234
     * $query->filterByAmout(array(12, 34)); // WHERE amout IN (12, 34)
     * $query->filterByAmout(array('min' => 12)); // WHERE amout > 12
     * </code>
     *
     * @param     mixed $amout The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSUserProfileQuery The current query, for fluid interface
     */
    public function filterByAmout($amout = null, $comparison = null)
    {
        if (is_array($amout)) {
            $useMinMax = false;
            if (isset($amout['min'])) {
                $this->addUsingAlias(SUserProfileTableMap::COL_AMOUT, $amout['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($amout['max'])) {
                $this->addUsingAlias(SUserProfileTableMap::COL_AMOUT, $amout['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SUserProfileTableMap::COL_AMOUT, $amout, $comparison);
    }

    /**
     * Filter the query on the discount column
     *
     * Example usage:
     * <code>
     * $query->filterByDiscount('fooValue');   // WHERE discount = 'fooValue'
     * $query->filterByDiscount('%fooValue%'); // WHERE discount LIKE '%fooValue%'
     * </code>
     *
     * @param     string $discount The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSUserProfileQuery The current query, for fluid interface
     */
    public function filterByDiscount($discount = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($discount)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $discount)) {
                $discount = str_replace('*', '%', $discount);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SUserProfileTableMap::COL_DISCOUNT, $discount, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildSUserProfile $sUserProfile Object to remove from the list of results
     *
     * @return $this|ChildSUserProfileQuery The current query, for fluid interface
     */
    public function prune($sUserProfile = null)
    {
        if ($sUserProfile) {
            $this->addUsingAlias(SUserProfileTableMap::COL_ID, $sUserProfile->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the users table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SUserProfileTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            SUserProfileTableMap::clearInstancePool();
            SUserProfileTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(SUserProfileTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(SUserProfileTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            SUserProfileTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            SUserProfileTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // SUserProfileQuery
