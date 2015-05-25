<?php

namespace Base;

use \SOrders as ChildSOrders;
use \SOrdersQuery as ChildSOrdersQuery;
use \Exception;
use \PDO;
use Map\SOrderProductsTableMap;
use Map\SOrderStatusHistoryTableMap;
use Map\SOrdersTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'shop_orders' table.
 *
 *
 *
 * @method     ChildSOrdersQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildSOrdersQuery orderByUserId($order = Criteria::ASC) Order by the user_id column
 * @method     ChildSOrdersQuery orderByKey($order = Criteria::ASC) Order by the order_key column
 * @method     ChildSOrdersQuery orderByDeliveryMethod($order = Criteria::ASC) Order by the delivery_method column
 * @method     ChildSOrdersQuery orderByDeliveryPrice($order = Criteria::ASC) Order by the delivery_price column
 * @method     ChildSOrdersQuery orderByPaymentMethod($order = Criteria::ASC) Order by the payment_method column
 * @method     ChildSOrdersQuery orderByStatus($order = Criteria::ASC) Order by the status column
 * @method     ChildSOrdersQuery orderByPaid($order = Criteria::ASC) Order by the paid column
 * @method     ChildSOrdersQuery orderByUserFullName($order = Criteria::ASC) Order by the user_full_name column
 * @method     ChildSOrdersQuery orderByUserSurname($order = Criteria::ASC) Order by the user_surname column
 * @method     ChildSOrdersQuery orderByUserEmail($order = Criteria::ASC) Order by the user_email column
 * @method     ChildSOrdersQuery orderByUserPhone($order = Criteria::ASC) Order by the user_phone column
 * @method     ChildSOrdersQuery orderByUserDeliverTo($order = Criteria::ASC) Order by the user_deliver_to column
 * @method     ChildSOrdersQuery orderByUserComment($order = Criteria::ASC) Order by the user_comment column
 * @method     ChildSOrdersQuery orderByDateCreated($order = Criteria::ASC) Order by the date_created column
 * @method     ChildSOrdersQuery orderByDateUpdated($order = Criteria::ASC) Order by the date_updated column
 * @method     ChildSOrdersQuery orderByUserIp($order = Criteria::ASC) Order by the user_ip column
 * @method     ChildSOrdersQuery orderByTotalPrice($order = Criteria::ASC) Order by the total_price column
 * @method     ChildSOrdersQuery orderByExternalId($order = Criteria::ASC) Order by the external_id column
 * @method     ChildSOrdersQuery orderByGiftCertKey($order = Criteria::ASC) Order by the gift_cert_key column
 * @method     ChildSOrdersQuery orderByDiscount($order = Criteria::ASC) Order by the discount column
 * @method     ChildSOrdersQuery orderByGiftCertPrice($order = Criteria::ASC) Order by the gift_cert_price column
 * @method     ChildSOrdersQuery orderByDiscountInfo($order = Criteria::ASC) Order by the discount_info column
 * @method     ChildSOrdersQuery orderByOriginPrice($order = Criteria::ASC) Order by the origin_price column
 * @method     ChildSOrdersQuery orderByComulativ($order = Criteria::ASC) Order by the comulativ column
 *
 * @method     ChildSOrdersQuery groupById() Group by the id column
 * @method     ChildSOrdersQuery groupByUserId() Group by the user_id column
 * @method     ChildSOrdersQuery groupByKey() Group by the order_key column
 * @method     ChildSOrdersQuery groupByDeliveryMethod() Group by the delivery_method column
 * @method     ChildSOrdersQuery groupByDeliveryPrice() Group by the delivery_price column
 * @method     ChildSOrdersQuery groupByPaymentMethod() Group by the payment_method column
 * @method     ChildSOrdersQuery groupByStatus() Group by the status column
 * @method     ChildSOrdersQuery groupByPaid() Group by the paid column
 * @method     ChildSOrdersQuery groupByUserFullName() Group by the user_full_name column
 * @method     ChildSOrdersQuery groupByUserSurname() Group by the user_surname column
 * @method     ChildSOrdersQuery groupByUserEmail() Group by the user_email column
 * @method     ChildSOrdersQuery groupByUserPhone() Group by the user_phone column
 * @method     ChildSOrdersQuery groupByUserDeliverTo() Group by the user_deliver_to column
 * @method     ChildSOrdersQuery groupByUserComment() Group by the user_comment column
 * @method     ChildSOrdersQuery groupByDateCreated() Group by the date_created column
 * @method     ChildSOrdersQuery groupByDateUpdated() Group by the date_updated column
 * @method     ChildSOrdersQuery groupByUserIp() Group by the user_ip column
 * @method     ChildSOrdersQuery groupByTotalPrice() Group by the total_price column
 * @method     ChildSOrdersQuery groupByExternalId() Group by the external_id column
 * @method     ChildSOrdersQuery groupByGiftCertKey() Group by the gift_cert_key column
 * @method     ChildSOrdersQuery groupByDiscount() Group by the discount column
 * @method     ChildSOrdersQuery groupByGiftCertPrice() Group by the gift_cert_price column
 * @method     ChildSOrdersQuery groupByDiscountInfo() Group by the discount_info column
 * @method     ChildSOrdersQuery groupByOriginPrice() Group by the origin_price column
 * @method     ChildSOrdersQuery groupByComulativ() Group by the comulativ column
 *
 * @method     ChildSOrdersQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildSOrdersQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildSOrdersQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildSOrdersQuery leftJoinSDeliveryMethods($relationAlias = null) Adds a LEFT JOIN clause to the query using the SDeliveryMethods relation
 * @method     ChildSOrdersQuery rightJoinSDeliveryMethods($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SDeliveryMethods relation
 * @method     ChildSOrdersQuery innerJoinSDeliveryMethods($relationAlias = null) Adds a INNER JOIN clause to the query using the SDeliveryMethods relation
 *
 * @method     ChildSOrdersQuery leftJoinSPaymentMethods($relationAlias = null) Adds a LEFT JOIN clause to the query using the SPaymentMethods relation
 * @method     ChildSOrdersQuery rightJoinSPaymentMethods($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SPaymentMethods relation
 * @method     ChildSOrdersQuery innerJoinSPaymentMethods($relationAlias = null) Adds a INNER JOIN clause to the query using the SPaymentMethods relation
 *
 * @method     ChildSOrdersQuery leftJoinSOrderStatuses($relationAlias = null) Adds a LEFT JOIN clause to the query using the SOrderStatuses relation
 * @method     ChildSOrdersQuery rightJoinSOrderStatuses($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SOrderStatuses relation
 * @method     ChildSOrdersQuery innerJoinSOrderStatuses($relationAlias = null) Adds a INNER JOIN clause to the query using the SOrderStatuses relation
 *
 * @method     ChildSOrdersQuery leftJoinSOrderProducts($relationAlias = null) Adds a LEFT JOIN clause to the query using the SOrderProducts relation
 * @method     ChildSOrdersQuery rightJoinSOrderProducts($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SOrderProducts relation
 * @method     ChildSOrdersQuery innerJoinSOrderProducts($relationAlias = null) Adds a INNER JOIN clause to the query using the SOrderProducts relation
 *
 * @method     ChildSOrdersQuery leftJoinSOrderStatusHistory($relationAlias = null) Adds a LEFT JOIN clause to the query using the SOrderStatusHistory relation
 * @method     ChildSOrdersQuery rightJoinSOrderStatusHistory($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SOrderStatusHistory relation
 * @method     ChildSOrdersQuery innerJoinSOrderStatusHistory($relationAlias = null) Adds a INNER JOIN clause to the query using the SOrderStatusHistory relation
 *
 * @method     \SDeliveryMethodsQuery|\SPaymentMethodsQuery|\SOrderStatusesQuery|\SOrderProductsQuery|\SOrderStatusHistoryQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildSOrders findOne(ConnectionInterface $con = null) Return the first ChildSOrders matching the query
 * @method     ChildSOrders findOneOrCreate(ConnectionInterface $con = null) Return the first ChildSOrders matching the query, or a new ChildSOrders object populated from the query conditions when no match is found
 *
 * @method     ChildSOrders findOneById(int $id) Return the first ChildSOrders filtered by the id column
 * @method     ChildSOrders findOneByUserId(int $user_id) Return the first ChildSOrders filtered by the user_id column
 * @method     ChildSOrders findOneByKey(string $order_key) Return the first ChildSOrders filtered by the order_key column
 * @method     ChildSOrders findOneByDeliveryMethod(int $delivery_method) Return the first ChildSOrders filtered by the delivery_method column
 * @method     ChildSOrders findOneByDeliveryPrice(string $delivery_price) Return the first ChildSOrders filtered by the delivery_price column
 * @method     ChildSOrders findOneByPaymentMethod(int $payment_method) Return the first ChildSOrders filtered by the payment_method column
 * @method     ChildSOrders findOneByStatus(int $status) Return the first ChildSOrders filtered by the status column
 * @method     ChildSOrders findOneByPaid(boolean $paid) Return the first ChildSOrders filtered by the paid column
 * @method     ChildSOrders findOneByUserFullName(string $user_full_name) Return the first ChildSOrders filtered by the user_full_name column
 * @method     ChildSOrders findOneByUserSurname(string $user_surname) Return the first ChildSOrders filtered by the user_surname column
 * @method     ChildSOrders findOneByUserEmail(string $user_email) Return the first ChildSOrders filtered by the user_email column
 * @method     ChildSOrders findOneByUserPhone(string $user_phone) Return the first ChildSOrders filtered by the user_phone column
 * @method     ChildSOrders findOneByUserDeliverTo(string $user_deliver_to) Return the first ChildSOrders filtered by the user_deliver_to column
 * @method     ChildSOrders findOneByUserComment(string $user_comment) Return the first ChildSOrders filtered by the user_comment column
 * @method     ChildSOrders findOneByDateCreated(int $date_created) Return the first ChildSOrders filtered by the date_created column
 * @method     ChildSOrders findOneByDateUpdated(int $date_updated) Return the first ChildSOrders filtered by the date_updated column
 * @method     ChildSOrders findOneByUserIp(string $user_ip) Return the first ChildSOrders filtered by the user_ip column
 * @method     ChildSOrders findOneByTotalPrice(string $total_price) Return the first ChildSOrders filtered by the total_price column
 * @method     ChildSOrders findOneByExternalId(string $external_id) Return the first ChildSOrders filtered by the external_id column
 * @method     ChildSOrders findOneByGiftCertKey(string $gift_cert_key) Return the first ChildSOrders filtered by the gift_cert_key column
 * @method     ChildSOrders findOneByDiscount(double $discount) Return the first ChildSOrders filtered by the discount column
 * @method     ChildSOrders findOneByGiftCertPrice(double $gift_cert_price) Return the first ChildSOrders filtered by the gift_cert_price column
 * @method     ChildSOrders findOneByDiscountInfo(string $discount_info) Return the first ChildSOrders filtered by the discount_info column
 * @method     ChildSOrders findOneByOriginPrice(double $origin_price) Return the first ChildSOrders filtered by the origin_price column
 * @method     ChildSOrders findOneByComulativ(double $comulativ) Return the first ChildSOrders filtered by the comulativ column *

 * @method     ChildSOrders requirePk($key, ConnectionInterface $con = null) Return the ChildSOrders by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSOrders requireOne(ConnectionInterface $con = null) Return the first ChildSOrders matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSOrders requireOneById(int $id) Return the first ChildSOrders filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSOrders requireOneByUserId(int $user_id) Return the first ChildSOrders filtered by the user_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSOrders requireOneByKey(string $order_key) Return the first ChildSOrders filtered by the order_key column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSOrders requireOneByDeliveryMethod(int $delivery_method) Return the first ChildSOrders filtered by the delivery_method column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSOrders requireOneByDeliveryPrice(string $delivery_price) Return the first ChildSOrders filtered by the delivery_price column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSOrders requireOneByPaymentMethod(int $payment_method) Return the first ChildSOrders filtered by the payment_method column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSOrders requireOneByStatus(int $status) Return the first ChildSOrders filtered by the status column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSOrders requireOneByPaid(boolean $paid) Return the first ChildSOrders filtered by the paid column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSOrders requireOneByUserFullName(string $user_full_name) Return the first ChildSOrders filtered by the user_full_name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSOrders requireOneByUserSurname(string $user_surname) Return the first ChildSOrders filtered by the user_surname column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSOrders requireOneByUserEmail(string $user_email) Return the first ChildSOrders filtered by the user_email column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSOrders requireOneByUserPhone(string $user_phone) Return the first ChildSOrders filtered by the user_phone column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSOrders requireOneByUserDeliverTo(string $user_deliver_to) Return the first ChildSOrders filtered by the user_deliver_to column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSOrders requireOneByUserComment(string $user_comment) Return the first ChildSOrders filtered by the user_comment column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSOrders requireOneByDateCreated(int $date_created) Return the first ChildSOrders filtered by the date_created column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSOrders requireOneByDateUpdated(int $date_updated) Return the first ChildSOrders filtered by the date_updated column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSOrders requireOneByUserIp(string $user_ip) Return the first ChildSOrders filtered by the user_ip column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSOrders requireOneByTotalPrice(string $total_price) Return the first ChildSOrders filtered by the total_price column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSOrders requireOneByExternalId(string $external_id) Return the first ChildSOrders filtered by the external_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSOrders requireOneByGiftCertKey(string $gift_cert_key) Return the first ChildSOrders filtered by the gift_cert_key column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSOrders requireOneByDiscount(double $discount) Return the first ChildSOrders filtered by the discount column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSOrders requireOneByGiftCertPrice(double $gift_cert_price) Return the first ChildSOrders filtered by the gift_cert_price column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSOrders requireOneByDiscountInfo(string $discount_info) Return the first ChildSOrders filtered by the discount_info column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSOrders requireOneByOriginPrice(double $origin_price) Return the first ChildSOrders filtered by the origin_price column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSOrders requireOneByComulativ(double $comulativ) Return the first ChildSOrders filtered by the comulativ column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSOrders[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildSOrders objects based on current ModelCriteria
 * @method     ChildSOrders[]|ObjectCollection findById(int $id) Return ChildSOrders objects filtered by the id column
 * @method     ChildSOrders[]|ObjectCollection findByUserId(int $user_id) Return ChildSOrders objects filtered by the user_id column
 * @method     ChildSOrders[]|ObjectCollection findByKey(string $order_key) Return ChildSOrders objects filtered by the order_key column
 * @method     ChildSOrders[]|ObjectCollection findByDeliveryMethod(int $delivery_method) Return ChildSOrders objects filtered by the delivery_method column
 * @method     ChildSOrders[]|ObjectCollection findByDeliveryPrice(string $delivery_price) Return ChildSOrders objects filtered by the delivery_price column
 * @method     ChildSOrders[]|ObjectCollection findByPaymentMethod(int $payment_method) Return ChildSOrders objects filtered by the payment_method column
 * @method     ChildSOrders[]|ObjectCollection findByStatus(int $status) Return ChildSOrders objects filtered by the status column
 * @method     ChildSOrders[]|ObjectCollection findByPaid(boolean $paid) Return ChildSOrders objects filtered by the paid column
 * @method     ChildSOrders[]|ObjectCollection findByUserFullName(string $user_full_name) Return ChildSOrders objects filtered by the user_full_name column
 * @method     ChildSOrders[]|ObjectCollection findByUserSurname(string $user_surname) Return ChildSOrders objects filtered by the user_surname column
 * @method     ChildSOrders[]|ObjectCollection findByUserEmail(string $user_email) Return ChildSOrders objects filtered by the user_email column
 * @method     ChildSOrders[]|ObjectCollection findByUserPhone(string $user_phone) Return ChildSOrders objects filtered by the user_phone column
 * @method     ChildSOrders[]|ObjectCollection findByUserDeliverTo(string $user_deliver_to) Return ChildSOrders objects filtered by the user_deliver_to column
 * @method     ChildSOrders[]|ObjectCollection findByUserComment(string $user_comment) Return ChildSOrders objects filtered by the user_comment column
 * @method     ChildSOrders[]|ObjectCollection findByDateCreated(int $date_created) Return ChildSOrders objects filtered by the date_created column
 * @method     ChildSOrders[]|ObjectCollection findByDateUpdated(int $date_updated) Return ChildSOrders objects filtered by the date_updated column
 * @method     ChildSOrders[]|ObjectCollection findByUserIp(string $user_ip) Return ChildSOrders objects filtered by the user_ip column
 * @method     ChildSOrders[]|ObjectCollection findByTotalPrice(string $total_price) Return ChildSOrders objects filtered by the total_price column
 * @method     ChildSOrders[]|ObjectCollection findByExternalId(string $external_id) Return ChildSOrders objects filtered by the external_id column
 * @method     ChildSOrders[]|ObjectCollection findByGiftCertKey(string $gift_cert_key) Return ChildSOrders objects filtered by the gift_cert_key column
 * @method     ChildSOrders[]|ObjectCollection findByDiscount(double $discount) Return ChildSOrders objects filtered by the discount column
 * @method     ChildSOrders[]|ObjectCollection findByGiftCertPrice(double $gift_cert_price) Return ChildSOrders objects filtered by the gift_cert_price column
 * @method     ChildSOrders[]|ObjectCollection findByDiscountInfo(string $discount_info) Return ChildSOrders objects filtered by the discount_info column
 * @method     ChildSOrders[]|ObjectCollection findByOriginPrice(double $origin_price) Return ChildSOrders objects filtered by the origin_price column
 * @method     ChildSOrders[]|ObjectCollection findByComulativ(double $comulativ) Return ChildSOrders objects filtered by the comulativ column
 * @method     ChildSOrders[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class SOrdersQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\SOrdersQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'Shop', $modelName = '\\SOrders', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildSOrdersQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildSOrdersQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildSOrdersQuery) {
            return $criteria;
        }
        $query = new ChildSOrdersQuery();
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
     * @return ChildSOrders|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = SOrdersTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(SOrdersTableMap::DATABASE_NAME);
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
     * @return ChildSOrders A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, user_id, order_key, delivery_method, delivery_price, payment_method, status, paid, user_full_name, user_surname, user_email, user_phone, user_deliver_to, user_comment, date_created, date_updated, user_ip, total_price, external_id, gift_cert_key, discount, gift_cert_price, discount_info, origin_price, comulativ FROM shop_orders WHERE id = :p0';
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
            /** @var ChildSOrders $obj */
            $obj = new ChildSOrders();
            $obj->hydrate($row);
            SOrdersTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildSOrders|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildSOrdersQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(SOrdersTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildSOrdersQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(SOrdersTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildSOrdersQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(SOrdersTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(SOrdersTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SOrdersTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the user_id column
     *
     * Example usage:
     * <code>
     * $query->filterByUserId(1234); // WHERE user_id = 1234
     * $query->filterByUserId(array(12, 34)); // WHERE user_id IN (12, 34)
     * $query->filterByUserId(array('min' => 12)); // WHERE user_id > 12
     * </code>
     *
     * @param     mixed $userId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSOrdersQuery The current query, for fluid interface
     */
    public function filterByUserId($userId = null, $comparison = null)
    {
        if (is_array($userId)) {
            $useMinMax = false;
            if (isset($userId['min'])) {
                $this->addUsingAlias(SOrdersTableMap::COL_USER_ID, $userId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($userId['max'])) {
                $this->addUsingAlias(SOrdersTableMap::COL_USER_ID, $userId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SOrdersTableMap::COL_USER_ID, $userId, $comparison);
    }

    /**
     * Filter the query on the order_key column
     *
     * Example usage:
     * <code>
     * $query->filterByKey('fooValue');   // WHERE order_key = 'fooValue'
     * $query->filterByKey('%fooValue%'); // WHERE order_key LIKE '%fooValue%'
     * </code>
     *
     * @param     string $key The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSOrdersQuery The current query, for fluid interface
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

        return $this->addUsingAlias(SOrdersTableMap::COL_ORDER_KEY, $key, $comparison);
    }

    /**
     * Filter the query on the delivery_method column
     *
     * Example usage:
     * <code>
     * $query->filterByDeliveryMethod(1234); // WHERE delivery_method = 1234
     * $query->filterByDeliveryMethod(array(12, 34)); // WHERE delivery_method IN (12, 34)
     * $query->filterByDeliveryMethod(array('min' => 12)); // WHERE delivery_method > 12
     * </code>
     *
     * @see       filterBySDeliveryMethods()
     *
     * @param     mixed $deliveryMethod The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSOrdersQuery The current query, for fluid interface
     */
    public function filterByDeliveryMethod($deliveryMethod = null, $comparison = null)
    {
        if (is_array($deliveryMethod)) {
            $useMinMax = false;
            if (isset($deliveryMethod['min'])) {
                $this->addUsingAlias(SOrdersTableMap::COL_DELIVERY_METHOD, $deliveryMethod['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($deliveryMethod['max'])) {
                $this->addUsingAlias(SOrdersTableMap::COL_DELIVERY_METHOD, $deliveryMethod['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SOrdersTableMap::COL_DELIVERY_METHOD, $deliveryMethod, $comparison);
    }

    /**
     * Filter the query on the delivery_price column
     *
     * Example usage:
     * <code>
     * $query->filterByDeliveryPrice(1234); // WHERE delivery_price = 1234
     * $query->filterByDeliveryPrice(array(12, 34)); // WHERE delivery_price IN (12, 34)
     * $query->filterByDeliveryPrice(array('min' => 12)); // WHERE delivery_price > 12
     * </code>
     *
     * @param     mixed $deliveryPrice The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSOrdersQuery The current query, for fluid interface
     */
    public function filterByDeliveryPrice($deliveryPrice = null, $comparison = null)
    {
        if (is_array($deliveryPrice)) {
            $useMinMax = false;
            if (isset($deliveryPrice['min'])) {
                $this->addUsingAlias(SOrdersTableMap::COL_DELIVERY_PRICE, $deliveryPrice['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($deliveryPrice['max'])) {
                $this->addUsingAlias(SOrdersTableMap::COL_DELIVERY_PRICE, $deliveryPrice['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SOrdersTableMap::COL_DELIVERY_PRICE, $deliveryPrice, $comparison);
    }

    /**
     * Filter the query on the payment_method column
     *
     * Example usage:
     * <code>
     * $query->filterByPaymentMethod(1234); // WHERE payment_method = 1234
     * $query->filterByPaymentMethod(array(12, 34)); // WHERE payment_method IN (12, 34)
     * $query->filterByPaymentMethod(array('min' => 12)); // WHERE payment_method > 12
     * </code>
     *
     * @see       filterBySPaymentMethods()
     *
     * @param     mixed $paymentMethod The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSOrdersQuery The current query, for fluid interface
     */
    public function filterByPaymentMethod($paymentMethod = null, $comparison = null)
    {
        if (is_array($paymentMethod)) {
            $useMinMax = false;
            if (isset($paymentMethod['min'])) {
                $this->addUsingAlias(SOrdersTableMap::COL_PAYMENT_METHOD, $paymentMethod['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($paymentMethod['max'])) {
                $this->addUsingAlias(SOrdersTableMap::COL_PAYMENT_METHOD, $paymentMethod['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SOrdersTableMap::COL_PAYMENT_METHOD, $paymentMethod, $comparison);
    }

    /**
     * Filter the query on the status column
     *
     * Example usage:
     * <code>
     * $query->filterByStatus(1234); // WHERE status = 1234
     * $query->filterByStatus(array(12, 34)); // WHERE status IN (12, 34)
     * $query->filterByStatus(array('min' => 12)); // WHERE status > 12
     * </code>
     *
     * @see       filterBySOrderStatuses()
     *
     * @param     mixed $status The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSOrdersQuery The current query, for fluid interface
     */
    public function filterByStatus($status = null, $comparison = null)
    {
        if (is_array($status)) {
            $useMinMax = false;
            if (isset($status['min'])) {
                $this->addUsingAlias(SOrdersTableMap::COL_STATUS, $status['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($status['max'])) {
                $this->addUsingAlias(SOrdersTableMap::COL_STATUS, $status['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SOrdersTableMap::COL_STATUS, $status, $comparison);
    }

    /**
     * Filter the query on the paid column
     *
     * Example usage:
     * <code>
     * $query->filterByPaid(true); // WHERE paid = true
     * $query->filterByPaid('yes'); // WHERE paid = true
     * </code>
     *
     * @param     boolean|string $paid The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSOrdersQuery The current query, for fluid interface
     */
    public function filterByPaid($paid = null, $comparison = null)
    {
        if (is_string($paid)) {
            $paid = in_array(strtolower($paid), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(SOrdersTableMap::COL_PAID, $paid, $comparison);
    }

    /**
     * Filter the query on the user_full_name column
     *
     * Example usage:
     * <code>
     * $query->filterByUserFullName('fooValue');   // WHERE user_full_name = 'fooValue'
     * $query->filterByUserFullName('%fooValue%'); // WHERE user_full_name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $userFullName The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSOrdersQuery The current query, for fluid interface
     */
    public function filterByUserFullName($userFullName = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($userFullName)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $userFullName)) {
                $userFullName = str_replace('*', '%', $userFullName);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SOrdersTableMap::COL_USER_FULL_NAME, $userFullName, $comparison);
    }

    /**
     * Filter the query on the user_surname column
     *
     * Example usage:
     * <code>
     * $query->filterByUserSurname('fooValue');   // WHERE user_surname = 'fooValue'
     * $query->filterByUserSurname('%fooValue%'); // WHERE user_surname LIKE '%fooValue%'
     * </code>
     *
     * @param     string $userSurname The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSOrdersQuery The current query, for fluid interface
     */
    public function filterByUserSurname($userSurname = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($userSurname)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $userSurname)) {
                $userSurname = str_replace('*', '%', $userSurname);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SOrdersTableMap::COL_USER_SURNAME, $userSurname, $comparison);
    }

    /**
     * Filter the query on the user_email column
     *
     * Example usage:
     * <code>
     * $query->filterByUserEmail('fooValue');   // WHERE user_email = 'fooValue'
     * $query->filterByUserEmail('%fooValue%'); // WHERE user_email LIKE '%fooValue%'
     * </code>
     *
     * @param     string $userEmail The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSOrdersQuery The current query, for fluid interface
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

        return $this->addUsingAlias(SOrdersTableMap::COL_USER_EMAIL, $userEmail, $comparison);
    }

    /**
     * Filter the query on the user_phone column
     *
     * Example usage:
     * <code>
     * $query->filterByUserPhone('fooValue');   // WHERE user_phone = 'fooValue'
     * $query->filterByUserPhone('%fooValue%'); // WHERE user_phone LIKE '%fooValue%'
     * </code>
     *
     * @param     string $userPhone The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSOrdersQuery The current query, for fluid interface
     */
    public function filterByUserPhone($userPhone = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($userPhone)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $userPhone)) {
                $userPhone = str_replace('*', '%', $userPhone);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SOrdersTableMap::COL_USER_PHONE, $userPhone, $comparison);
    }

    /**
     * Filter the query on the user_deliver_to column
     *
     * Example usage:
     * <code>
     * $query->filterByUserDeliverTo('fooValue');   // WHERE user_deliver_to = 'fooValue'
     * $query->filterByUserDeliverTo('%fooValue%'); // WHERE user_deliver_to LIKE '%fooValue%'
     * </code>
     *
     * @param     string $userDeliverTo The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSOrdersQuery The current query, for fluid interface
     */
    public function filterByUserDeliverTo($userDeliverTo = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($userDeliverTo)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $userDeliverTo)) {
                $userDeliverTo = str_replace('*', '%', $userDeliverTo);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SOrdersTableMap::COL_USER_DELIVER_TO, $userDeliverTo, $comparison);
    }

    /**
     * Filter the query on the user_comment column
     *
     * Example usage:
     * <code>
     * $query->filterByUserComment('fooValue');   // WHERE user_comment = 'fooValue'
     * $query->filterByUserComment('%fooValue%'); // WHERE user_comment LIKE '%fooValue%'
     * </code>
     *
     * @param     string $userComment The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSOrdersQuery The current query, for fluid interface
     */
    public function filterByUserComment($userComment = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($userComment)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $userComment)) {
                $userComment = str_replace('*', '%', $userComment);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SOrdersTableMap::COL_USER_COMMENT, $userComment, $comparison);
    }

    /**
     * Filter the query on the date_created column
     *
     * Example usage:
     * <code>
     * $query->filterByDateCreated(1234); // WHERE date_created = 1234
     * $query->filterByDateCreated(array(12, 34)); // WHERE date_created IN (12, 34)
     * $query->filterByDateCreated(array('min' => 12)); // WHERE date_created > 12
     * </code>
     *
     * @param     mixed $dateCreated The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSOrdersQuery The current query, for fluid interface
     */
    public function filterByDateCreated($dateCreated = null, $comparison = null)
    {
        if (is_array($dateCreated)) {
            $useMinMax = false;
            if (isset($dateCreated['min'])) {
                $this->addUsingAlias(SOrdersTableMap::COL_DATE_CREATED, $dateCreated['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dateCreated['max'])) {
                $this->addUsingAlias(SOrdersTableMap::COL_DATE_CREATED, $dateCreated['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SOrdersTableMap::COL_DATE_CREATED, $dateCreated, $comparison);
    }

    /**
     * Filter the query on the date_updated column
     *
     * Example usage:
     * <code>
     * $query->filterByDateUpdated(1234); // WHERE date_updated = 1234
     * $query->filterByDateUpdated(array(12, 34)); // WHERE date_updated IN (12, 34)
     * $query->filterByDateUpdated(array('min' => 12)); // WHERE date_updated > 12
     * </code>
     *
     * @param     mixed $dateUpdated The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSOrdersQuery The current query, for fluid interface
     */
    public function filterByDateUpdated($dateUpdated = null, $comparison = null)
    {
        if (is_array($dateUpdated)) {
            $useMinMax = false;
            if (isset($dateUpdated['min'])) {
                $this->addUsingAlias(SOrdersTableMap::COL_DATE_UPDATED, $dateUpdated['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dateUpdated['max'])) {
                $this->addUsingAlias(SOrdersTableMap::COL_DATE_UPDATED, $dateUpdated['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SOrdersTableMap::COL_DATE_UPDATED, $dateUpdated, $comparison);
    }

    /**
     * Filter the query on the user_ip column
     *
     * Example usage:
     * <code>
     * $query->filterByUserIp('fooValue');   // WHERE user_ip = 'fooValue'
     * $query->filterByUserIp('%fooValue%'); // WHERE user_ip LIKE '%fooValue%'
     * </code>
     *
     * @param     string $userIp The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSOrdersQuery The current query, for fluid interface
     */
    public function filterByUserIp($userIp = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($userIp)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $userIp)) {
                $userIp = str_replace('*', '%', $userIp);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SOrdersTableMap::COL_USER_IP, $userIp, $comparison);
    }

    /**
     * Filter the query on the total_price column
     *
     * Example usage:
     * <code>
     * $query->filterByTotalPrice(1234); // WHERE total_price = 1234
     * $query->filterByTotalPrice(array(12, 34)); // WHERE total_price IN (12, 34)
     * $query->filterByTotalPrice(array('min' => 12)); // WHERE total_price > 12
     * </code>
     *
     * @param     mixed $totalPrice The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSOrdersQuery The current query, for fluid interface
     */
    public function filterByTotalPrice($totalPrice = null, $comparison = null)
    {
        if (is_array($totalPrice)) {
            $useMinMax = false;
            if (isset($totalPrice['min'])) {
                $this->addUsingAlias(SOrdersTableMap::COL_TOTAL_PRICE, $totalPrice['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($totalPrice['max'])) {
                $this->addUsingAlias(SOrdersTableMap::COL_TOTAL_PRICE, $totalPrice['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SOrdersTableMap::COL_TOTAL_PRICE, $totalPrice, $comparison);
    }

    /**
     * Filter the query on the external_id column
     *
     * Example usage:
     * <code>
     * $query->filterByExternalId('fooValue');   // WHERE external_id = 'fooValue'
     * $query->filterByExternalId('%fooValue%'); // WHERE external_id LIKE '%fooValue%'
     * </code>
     *
     * @param     string $externalId The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSOrdersQuery The current query, for fluid interface
     */
    public function filterByExternalId($externalId = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($externalId)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $externalId)) {
                $externalId = str_replace('*', '%', $externalId);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SOrdersTableMap::COL_EXTERNAL_ID, $externalId, $comparison);
    }

    /**
     * Filter the query on the gift_cert_key column
     *
     * Example usage:
     * <code>
     * $query->filterByGiftCertKey('fooValue');   // WHERE gift_cert_key = 'fooValue'
     * $query->filterByGiftCertKey('%fooValue%'); // WHERE gift_cert_key LIKE '%fooValue%'
     * </code>
     *
     * @param     string $giftCertKey The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSOrdersQuery The current query, for fluid interface
     */
    public function filterByGiftCertKey($giftCertKey = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($giftCertKey)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $giftCertKey)) {
                $giftCertKey = str_replace('*', '%', $giftCertKey);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SOrdersTableMap::COL_GIFT_CERT_KEY, $giftCertKey, $comparison);
    }

    /**
     * Filter the query on the discount column
     *
     * Example usage:
     * <code>
     * $query->filterByDiscount(1234); // WHERE discount = 1234
     * $query->filterByDiscount(array(12, 34)); // WHERE discount IN (12, 34)
     * $query->filterByDiscount(array('min' => 12)); // WHERE discount > 12
     * </code>
     *
     * @param     mixed $discount The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSOrdersQuery The current query, for fluid interface
     */
    public function filterByDiscount($discount = null, $comparison = null)
    {
        if (is_array($discount)) {
            $useMinMax = false;
            if (isset($discount['min'])) {
                $this->addUsingAlias(SOrdersTableMap::COL_DISCOUNT, $discount['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($discount['max'])) {
                $this->addUsingAlias(SOrdersTableMap::COL_DISCOUNT, $discount['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SOrdersTableMap::COL_DISCOUNT, $discount, $comparison);
    }

    /**
     * Filter the query on the gift_cert_price column
     *
     * Example usage:
     * <code>
     * $query->filterByGiftCertPrice(1234); // WHERE gift_cert_price = 1234
     * $query->filterByGiftCertPrice(array(12, 34)); // WHERE gift_cert_price IN (12, 34)
     * $query->filterByGiftCertPrice(array('min' => 12)); // WHERE gift_cert_price > 12
     * </code>
     *
     * @param     mixed $giftCertPrice The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSOrdersQuery The current query, for fluid interface
     */
    public function filterByGiftCertPrice($giftCertPrice = null, $comparison = null)
    {
        if (is_array($giftCertPrice)) {
            $useMinMax = false;
            if (isset($giftCertPrice['min'])) {
                $this->addUsingAlias(SOrdersTableMap::COL_GIFT_CERT_PRICE, $giftCertPrice['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($giftCertPrice['max'])) {
                $this->addUsingAlias(SOrdersTableMap::COL_GIFT_CERT_PRICE, $giftCertPrice['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SOrdersTableMap::COL_GIFT_CERT_PRICE, $giftCertPrice, $comparison);
    }

    /**
     * Filter the query on the discount_info column
     *
     * Example usage:
     * <code>
     * $query->filterByDiscountInfo('fooValue');   // WHERE discount_info = 'fooValue'
     * $query->filterByDiscountInfo('%fooValue%'); // WHERE discount_info LIKE '%fooValue%'
     * </code>
     *
     * @param     string $discountInfo The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSOrdersQuery The current query, for fluid interface
     */
    public function filterByDiscountInfo($discountInfo = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($discountInfo)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $discountInfo)) {
                $discountInfo = str_replace('*', '%', $discountInfo);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SOrdersTableMap::COL_DISCOUNT_INFO, $discountInfo, $comparison);
    }

    /**
     * Filter the query on the origin_price column
     *
     * Example usage:
     * <code>
     * $query->filterByOriginPrice(1234); // WHERE origin_price = 1234
     * $query->filterByOriginPrice(array(12, 34)); // WHERE origin_price IN (12, 34)
     * $query->filterByOriginPrice(array('min' => 12)); // WHERE origin_price > 12
     * </code>
     *
     * @param     mixed $originPrice The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSOrdersQuery The current query, for fluid interface
     */
    public function filterByOriginPrice($originPrice = null, $comparison = null)
    {
        if (is_array($originPrice)) {
            $useMinMax = false;
            if (isset($originPrice['min'])) {
                $this->addUsingAlias(SOrdersTableMap::COL_ORIGIN_PRICE, $originPrice['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($originPrice['max'])) {
                $this->addUsingAlias(SOrdersTableMap::COL_ORIGIN_PRICE, $originPrice['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SOrdersTableMap::COL_ORIGIN_PRICE, $originPrice, $comparison);
    }

    /**
     * Filter the query on the comulativ column
     *
     * Example usage:
     * <code>
     * $query->filterByComulativ(1234); // WHERE comulativ = 1234
     * $query->filterByComulativ(array(12, 34)); // WHERE comulativ IN (12, 34)
     * $query->filterByComulativ(array('min' => 12)); // WHERE comulativ > 12
     * </code>
     *
     * @param     mixed $comulativ The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSOrdersQuery The current query, for fluid interface
     */
    public function filterByComulativ($comulativ = null, $comparison = null)
    {
        if (is_array($comulativ)) {
            $useMinMax = false;
            if (isset($comulativ['min'])) {
                $this->addUsingAlias(SOrdersTableMap::COL_COMULATIV, $comulativ['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($comulativ['max'])) {
                $this->addUsingAlias(SOrdersTableMap::COL_COMULATIV, $comulativ['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SOrdersTableMap::COL_COMULATIV, $comulativ, $comparison);
    }

    /**
     * Filter the query by a related \SDeliveryMethods object
     *
     * @param \SDeliveryMethods|ObjectCollection $sDeliveryMethods The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildSOrdersQuery The current query, for fluid interface
     */
    public function filterBySDeliveryMethods($sDeliveryMethods, $comparison = null)
    {
        if ($sDeliveryMethods instanceof \SDeliveryMethods) {
            return $this
                ->addUsingAlias(SOrdersTableMap::COL_DELIVERY_METHOD, $sDeliveryMethods->getId(), $comparison);
        } elseif ($sDeliveryMethods instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(SOrdersTableMap::COL_DELIVERY_METHOD, $sDeliveryMethods->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterBySDeliveryMethods() only accepts arguments of type \SDeliveryMethods or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the SDeliveryMethods relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSOrdersQuery The current query, for fluid interface
     */
    public function joinSDeliveryMethods($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('SDeliveryMethods');

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
            $this->addJoinObject($join, 'SDeliveryMethods');
        }

        return $this;
    }

    /**
     * Use the SDeliveryMethods relation SDeliveryMethods object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \SDeliveryMethodsQuery A secondary query class using the current class as primary query
     */
    public function useSDeliveryMethodsQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinSDeliveryMethods($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'SDeliveryMethods', '\SDeliveryMethodsQuery');
    }

    /**
     * Filter the query by a related \SPaymentMethods object
     *
     * @param \SPaymentMethods|ObjectCollection $sPaymentMethods The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildSOrdersQuery The current query, for fluid interface
     */
    public function filterBySPaymentMethods($sPaymentMethods, $comparison = null)
    {
        if ($sPaymentMethods instanceof \SPaymentMethods) {
            return $this
                ->addUsingAlias(SOrdersTableMap::COL_PAYMENT_METHOD, $sPaymentMethods->getId(), $comparison);
        } elseif ($sPaymentMethods instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(SOrdersTableMap::COL_PAYMENT_METHOD, $sPaymentMethods->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildSOrdersQuery The current query, for fluid interface
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
     * Filter the query by a related \SOrderStatuses object
     *
     * @param \SOrderStatuses|ObjectCollection $sOrderStatuses The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildSOrdersQuery The current query, for fluid interface
     */
    public function filterBySOrderStatuses($sOrderStatuses, $comparison = null)
    {
        if ($sOrderStatuses instanceof \SOrderStatuses) {
            return $this
                ->addUsingAlias(SOrdersTableMap::COL_STATUS, $sOrderStatuses->getId(), $comparison);
        } elseif ($sOrderStatuses instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(SOrdersTableMap::COL_STATUS, $sOrderStatuses->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterBySOrderStatuses() only accepts arguments of type \SOrderStatuses or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the SOrderStatuses relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSOrdersQuery The current query, for fluid interface
     */
    public function joinSOrderStatuses($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('SOrderStatuses');

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
            $this->addJoinObject($join, 'SOrderStatuses');
        }

        return $this;
    }

    /**
     * Use the SOrderStatuses relation SOrderStatuses object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \SOrderStatusesQuery A secondary query class using the current class as primary query
     */
    public function useSOrderStatusesQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinSOrderStatuses($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'SOrderStatuses', '\SOrderStatusesQuery');
    }

    /**
     * Filter the query by a related \SOrderProducts object
     *
     * @param \SOrderProducts|ObjectCollection $sOrderProducts the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSOrdersQuery The current query, for fluid interface
     */
    public function filterBySOrderProducts($sOrderProducts, $comparison = null)
    {
        if ($sOrderProducts instanceof \SOrderProducts) {
            return $this
                ->addUsingAlias(SOrdersTableMap::COL_ID, $sOrderProducts->getOrderId(), $comparison);
        } elseif ($sOrderProducts instanceof ObjectCollection) {
            return $this
                ->useSOrderProductsQuery()
                ->filterByPrimaryKeys($sOrderProducts->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterBySOrderProducts() only accepts arguments of type \SOrderProducts or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the SOrderProducts relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSOrdersQuery The current query, for fluid interface
     */
    public function joinSOrderProducts($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('SOrderProducts');

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
            $this->addJoinObject($join, 'SOrderProducts');
        }

        return $this;
    }

    /**
     * Use the SOrderProducts relation SOrderProducts object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \SOrderProductsQuery A secondary query class using the current class as primary query
     */
    public function useSOrderProductsQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinSOrderProducts($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'SOrderProducts', '\SOrderProductsQuery');
    }

    /**
     * Filter the query by a related \SOrderStatusHistory object
     *
     * @param \SOrderStatusHistory|ObjectCollection $sOrderStatusHistory the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSOrdersQuery The current query, for fluid interface
     */
    public function filterBySOrderStatusHistory($sOrderStatusHistory, $comparison = null)
    {
        if ($sOrderStatusHistory instanceof \SOrderStatusHistory) {
            return $this
                ->addUsingAlias(SOrdersTableMap::COL_ID, $sOrderStatusHistory->getOrderId(), $comparison);
        } elseif ($sOrderStatusHistory instanceof ObjectCollection) {
            return $this
                ->useSOrderStatusHistoryQuery()
                ->filterByPrimaryKeys($sOrderStatusHistory->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterBySOrderStatusHistory() only accepts arguments of type \SOrderStatusHistory or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the SOrderStatusHistory relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSOrdersQuery The current query, for fluid interface
     */
    public function joinSOrderStatusHistory($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('SOrderStatusHistory');

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
            $this->addJoinObject($join, 'SOrderStatusHistory');
        }

        return $this;
    }

    /**
     * Use the SOrderStatusHistory relation SOrderStatusHistory object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \SOrderStatusHistoryQuery A secondary query class using the current class as primary query
     */
    public function useSOrderStatusHistoryQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinSOrderStatusHistory($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'SOrderStatusHistory', '\SOrderStatusHistoryQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildSOrders $sOrders Object to remove from the list of results
     *
     * @return $this|ChildSOrdersQuery The current query, for fluid interface
     */
    public function prune($sOrders = null)
    {
        if ($sOrders) {
            $this->addUsingAlias(SOrdersTableMap::COL_ID, $sOrders->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the shop_orders table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SOrdersTableMap::DATABASE_NAME);
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
            SOrdersTableMap::clearInstancePool();
            SOrdersTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(SOrdersTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(SOrdersTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            // cloning the Criteria in case it's modified by doSelect() or doSelectStmt()
            $c = clone $criteria;
            $affectedRows += $c->doOnDeleteCascade($con);

            SOrdersTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            SOrdersTableMap::clearRelatedInstancePool();

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
        $objects = ChildSOrdersQuery::create(null, $this)->find($con);
        foreach ($objects as $obj) {


            // delete related SOrderProducts objects
            $query = new \SOrderProductsQuery;

            $query->add(SOrderProductsTableMap::COL_ORDER_ID, $obj->getId());
            $affectedRows += $query->delete($con);

            // delete related SOrderStatusHistory objects
            $query = new \SOrderStatusHistoryQuery;

            $query->add(SOrderStatusHistoryTableMap::COL_ORDER_ID, $obj->getId());
            $affectedRows += $query->delete($con);
        }

        return $affectedRows;
    }

} // SOrdersQuery
