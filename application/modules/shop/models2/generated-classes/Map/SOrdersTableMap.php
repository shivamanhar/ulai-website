<?php

namespace Map;

use \SOrders;
use \SOrdersQuery;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;


/**
 * This class defines the structure of the 'shop_orders' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class SOrdersTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.SOrdersTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'Shop';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'shop_orders';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\SOrders';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'SOrders';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 25;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 25;

    /**
     * the column name for the id field
     */
    const COL_ID = 'shop_orders.id';

    /**
     * the column name for the user_id field
     */
    const COL_USER_ID = 'shop_orders.user_id';

    /**
     * the column name for the order_key field
     */
    const COL_ORDER_KEY = 'shop_orders.order_key';

    /**
     * the column name for the delivery_method field
     */
    const COL_DELIVERY_METHOD = 'shop_orders.delivery_method';

    /**
     * the column name for the delivery_price field
     */
    const COL_DELIVERY_PRICE = 'shop_orders.delivery_price';

    /**
     * the column name for the payment_method field
     */
    const COL_PAYMENT_METHOD = 'shop_orders.payment_method';

    /**
     * the column name for the status field
     */
    const COL_STATUS = 'shop_orders.status';

    /**
     * the column name for the paid field
     */
    const COL_PAID = 'shop_orders.paid';

    /**
     * the column name for the user_full_name field
     */
    const COL_USER_FULL_NAME = 'shop_orders.user_full_name';

    /**
     * the column name for the user_surname field
     */
    const COL_USER_SURNAME = 'shop_orders.user_surname';

    /**
     * the column name for the user_email field
     */
    const COL_USER_EMAIL = 'shop_orders.user_email';

    /**
     * the column name for the user_phone field
     */
    const COL_USER_PHONE = 'shop_orders.user_phone';

    /**
     * the column name for the user_deliver_to field
     */
    const COL_USER_DELIVER_TO = 'shop_orders.user_deliver_to';

    /**
     * the column name for the user_comment field
     */
    const COL_USER_COMMENT = 'shop_orders.user_comment';

    /**
     * the column name for the date_created field
     */
    const COL_DATE_CREATED = 'shop_orders.date_created';

    /**
     * the column name for the date_updated field
     */
    const COL_DATE_UPDATED = 'shop_orders.date_updated';

    /**
     * the column name for the user_ip field
     */
    const COL_USER_IP = 'shop_orders.user_ip';

    /**
     * the column name for the total_price field
     */
    const COL_TOTAL_PRICE = 'shop_orders.total_price';

    /**
     * the column name for the external_id field
     */
    const COL_EXTERNAL_ID = 'shop_orders.external_id';

    /**
     * the column name for the gift_cert_key field
     */
    const COL_GIFT_CERT_KEY = 'shop_orders.gift_cert_key';

    /**
     * the column name for the discount field
     */
    const COL_DISCOUNT = 'shop_orders.discount';

    /**
     * the column name for the gift_cert_price field
     */
    const COL_GIFT_CERT_PRICE = 'shop_orders.gift_cert_price';

    /**
     * the column name for the discount_info field
     */
    const COL_DISCOUNT_INFO = 'shop_orders.discount_info';

    /**
     * the column name for the origin_price field
     */
    const COL_ORIGIN_PRICE = 'shop_orders.origin_price';

    /**
     * the column name for the comulativ field
     */
    const COL_COMULATIV = 'shop_orders.comulativ';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('Id', 'UserId', 'Key', 'DeliveryMethod', 'DeliveryPrice', 'PaymentMethod', 'Status', 'Paid', 'UserFullName', 'UserSurname', 'UserEmail', 'UserPhone', 'UserDeliverTo', 'UserComment', 'DateCreated', 'DateUpdated', 'UserIp', 'TotalPrice', 'ExternalId', 'GiftCertKey', 'Discount', 'GiftCertPrice', 'DiscountInfo', 'OriginPrice', 'Comulativ', ),
        self::TYPE_CAMELNAME     => array('id', 'userId', 'key', 'deliveryMethod', 'deliveryPrice', 'paymentMethod', 'status', 'paid', 'userFullName', 'userSurname', 'userEmail', 'userPhone', 'userDeliverTo', 'userComment', 'dateCreated', 'dateUpdated', 'userIp', 'totalPrice', 'externalId', 'giftCertKey', 'discount', 'giftCertPrice', 'discountInfo', 'originPrice', 'comulativ', ),
        self::TYPE_COLNAME       => array(SOrdersTableMap::COL_ID, SOrdersTableMap::COL_USER_ID, SOrdersTableMap::COL_ORDER_KEY, SOrdersTableMap::COL_DELIVERY_METHOD, SOrdersTableMap::COL_DELIVERY_PRICE, SOrdersTableMap::COL_PAYMENT_METHOD, SOrdersTableMap::COL_STATUS, SOrdersTableMap::COL_PAID, SOrdersTableMap::COL_USER_FULL_NAME, SOrdersTableMap::COL_USER_SURNAME, SOrdersTableMap::COL_USER_EMAIL, SOrdersTableMap::COL_USER_PHONE, SOrdersTableMap::COL_USER_DELIVER_TO, SOrdersTableMap::COL_USER_COMMENT, SOrdersTableMap::COL_DATE_CREATED, SOrdersTableMap::COL_DATE_UPDATED, SOrdersTableMap::COL_USER_IP, SOrdersTableMap::COL_TOTAL_PRICE, SOrdersTableMap::COL_EXTERNAL_ID, SOrdersTableMap::COL_GIFT_CERT_KEY, SOrdersTableMap::COL_DISCOUNT, SOrdersTableMap::COL_GIFT_CERT_PRICE, SOrdersTableMap::COL_DISCOUNT_INFO, SOrdersTableMap::COL_ORIGIN_PRICE, SOrdersTableMap::COL_COMULATIV, ),
        self::TYPE_FIELDNAME     => array('id', 'user_id', 'order_key', 'delivery_method', 'delivery_price', 'payment_method', 'status', 'paid', 'user_full_name', 'user_surname', 'user_email', 'user_phone', 'user_deliver_to', 'user_comment', 'date_created', 'date_updated', 'user_ip', 'total_price', 'external_id', 'gift_cert_key', 'discount', 'gift_cert_price', 'discount_info', 'origin_price', 'comulativ', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'UserId' => 1, 'Key' => 2, 'DeliveryMethod' => 3, 'DeliveryPrice' => 4, 'PaymentMethod' => 5, 'Status' => 6, 'Paid' => 7, 'UserFullName' => 8, 'UserSurname' => 9, 'UserEmail' => 10, 'UserPhone' => 11, 'UserDeliverTo' => 12, 'UserComment' => 13, 'DateCreated' => 14, 'DateUpdated' => 15, 'UserIp' => 16, 'TotalPrice' => 17, 'ExternalId' => 18, 'GiftCertKey' => 19, 'Discount' => 20, 'GiftCertPrice' => 21, 'DiscountInfo' => 22, 'OriginPrice' => 23, 'Comulativ' => 24, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'userId' => 1, 'key' => 2, 'deliveryMethod' => 3, 'deliveryPrice' => 4, 'paymentMethod' => 5, 'status' => 6, 'paid' => 7, 'userFullName' => 8, 'userSurname' => 9, 'userEmail' => 10, 'userPhone' => 11, 'userDeliverTo' => 12, 'userComment' => 13, 'dateCreated' => 14, 'dateUpdated' => 15, 'userIp' => 16, 'totalPrice' => 17, 'externalId' => 18, 'giftCertKey' => 19, 'discount' => 20, 'giftCertPrice' => 21, 'discountInfo' => 22, 'originPrice' => 23, 'comulativ' => 24, ),
        self::TYPE_COLNAME       => array(SOrdersTableMap::COL_ID => 0, SOrdersTableMap::COL_USER_ID => 1, SOrdersTableMap::COL_ORDER_KEY => 2, SOrdersTableMap::COL_DELIVERY_METHOD => 3, SOrdersTableMap::COL_DELIVERY_PRICE => 4, SOrdersTableMap::COL_PAYMENT_METHOD => 5, SOrdersTableMap::COL_STATUS => 6, SOrdersTableMap::COL_PAID => 7, SOrdersTableMap::COL_USER_FULL_NAME => 8, SOrdersTableMap::COL_USER_SURNAME => 9, SOrdersTableMap::COL_USER_EMAIL => 10, SOrdersTableMap::COL_USER_PHONE => 11, SOrdersTableMap::COL_USER_DELIVER_TO => 12, SOrdersTableMap::COL_USER_COMMENT => 13, SOrdersTableMap::COL_DATE_CREATED => 14, SOrdersTableMap::COL_DATE_UPDATED => 15, SOrdersTableMap::COL_USER_IP => 16, SOrdersTableMap::COL_TOTAL_PRICE => 17, SOrdersTableMap::COL_EXTERNAL_ID => 18, SOrdersTableMap::COL_GIFT_CERT_KEY => 19, SOrdersTableMap::COL_DISCOUNT => 20, SOrdersTableMap::COL_GIFT_CERT_PRICE => 21, SOrdersTableMap::COL_DISCOUNT_INFO => 22, SOrdersTableMap::COL_ORIGIN_PRICE => 23, SOrdersTableMap::COL_COMULATIV => 24, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'user_id' => 1, 'order_key' => 2, 'delivery_method' => 3, 'delivery_price' => 4, 'payment_method' => 5, 'status' => 6, 'paid' => 7, 'user_full_name' => 8, 'user_surname' => 9, 'user_email' => 10, 'user_phone' => 11, 'user_deliver_to' => 12, 'user_comment' => 13, 'date_created' => 14, 'date_updated' => 15, 'user_ip' => 16, 'total_price' => 17, 'external_id' => 18, 'gift_cert_key' => 19, 'discount' => 20, 'gift_cert_price' => 21, 'discount_info' => 22, 'origin_price' => 23, 'comulativ' => 24, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, )
    );

    /**
     * Initialize the table attributes and columns
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('shop_orders');
        $this->setPhpName('SOrders');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\SOrders');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('user_id', 'UserId', 'INTEGER', false, null, null);
        $this->addColumn('order_key', 'Key', 'VARCHAR', true, 255, null);
        $this->addForeignKey('delivery_method', 'DeliveryMethod', 'INTEGER', 'shop_delivery_methods', 'id', false, null, null);
        $this->addColumn('delivery_price', 'DeliveryPrice', 'DOUBLE', false, null, null);
        $this->addForeignKey('payment_method', 'PaymentMethod', 'INTEGER', 'shop_payment_methods', 'id', false, null, null);
        $this->addForeignKey('status', 'Status', 'INTEGER', 'shop_order_statuses', 'id', false, null, null);
        $this->addColumn('paid', 'Paid', 'BOOLEAN', false, 1, null);
        $this->addColumn('user_full_name', 'UserFullName', 'VARCHAR', false, 255, null);
        $this->addColumn('user_surname', 'UserSurname', 'VARCHAR', false, 255, null);
        $this->addColumn('user_email', 'UserEmail', 'VARCHAR', false, 255, null);
        $this->addColumn('user_phone', 'UserPhone', 'VARCHAR', false, 255, null);
        $this->addColumn('user_deliver_to', 'UserDeliverTo', 'VARCHAR', false, 500, null);
        $this->addColumn('user_comment', 'UserComment', 'VARCHAR', false, 1000, null);
        $this->addColumn('date_created', 'DateCreated', 'INTEGER', false, null, null);
        $this->addColumn('date_updated', 'DateUpdated', 'INTEGER', false, null, null);
        $this->addColumn('user_ip', 'UserIp', 'VARCHAR', false, 255, null);
        $this->addColumn('total_price', 'TotalPrice', 'DOUBLE', false, null, null);
        $this->addColumn('external_id', 'ExternalId', 'VARCHAR', false, 255, null);
        $this->addColumn('gift_cert_key', 'GiftCertKey', 'VARCHAR', false, 25, null);
        $this->addColumn('discount', 'Discount', 'DOUBLE', false, null, null);
        $this->addColumn('gift_cert_price', 'GiftCertPrice', 'DOUBLE', false, null, null);
        $this->addColumn('discount_info', 'DiscountInfo', 'LONGVARCHAR', false, null, null);
        $this->addColumn('origin_price', 'OriginPrice', 'DOUBLE', false, null, null);
        $this->addColumn('comulativ', 'Comulativ', 'DOUBLE', false, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('SDeliveryMethods', '\\SDeliveryMethods', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':delivery_method',
    1 => ':id',
  ),
), 'SET NULL', null, null, false);
        $this->addRelation('SPaymentMethods', '\\SPaymentMethods', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':payment_method',
    1 => ':id',
  ),
), 'SET NULL', null, null, false);
        $this->addRelation('SOrderStatuses', '\\SOrderStatuses', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':status',
    1 => ':id',
  ),
), 'SET NULL', null, null, false);
        $this->addRelation('SOrderProducts', '\\SOrderProducts', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':order_id',
    1 => ':id',
  ),
), 'CASCADE', null, 'SOrderProductss', false);
        $this->addRelation('SOrderStatusHistory', '\\SOrderStatusHistory', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':order_id',
    1 => ':id',
  ),
), 'CASCADE', null, 'SOrderStatusHistories', false);
    } // buildRelations()
    /**
     * Method to invalidate the instance pool of all tables related to shop_orders     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in related instance pools,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        SOrderProductsTableMap::clearInstancePool();
        SOrderStatusHistoryTableMap::clearInstancePool();
    }

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return string The primary key hash of the row
     */
    public static function getPrimaryKeyHashFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        // If the PK cannot be derived from the row, return NULL.
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        return (int) $row[
            $indexType == TableMap::TYPE_NUM
                ? 0 + $offset
                : self::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)
        ];
    }

    /**
     * The class that the tableMap will make instances of.
     *
     * If $withPrefix is true, the returned path
     * uses a dot-path notation which is translated into a path
     * relative to a location on the PHP include_path.
     * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
     *
     * @param boolean $withPrefix Whether or not to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass($withPrefix = true)
    {
        return $withPrefix ? SOrdersTableMap::CLASS_DEFAULT : SOrdersTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array  $row       row returned by DataFetcher->fetch().
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     * @return array           (SOrders object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = SOrdersTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = SOrdersTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + SOrdersTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = SOrdersTableMap::OM_CLASS;
            /** @var SOrders $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            SOrdersTableMap::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param DataFetcherInterface $dataFetcher
     * @return array
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher)
    {
        $results = array();

        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = SOrdersTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = SOrdersTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var SOrders $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                SOrdersTableMap::addInstanceToPool($obj, $key);
            } // if key exists
        }

        return $results;
    }
    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param Criteria $criteria object containing the columns to add.
     * @param string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(SOrdersTableMap::COL_ID);
            $criteria->addSelectColumn(SOrdersTableMap::COL_USER_ID);
            $criteria->addSelectColumn(SOrdersTableMap::COL_ORDER_KEY);
            $criteria->addSelectColumn(SOrdersTableMap::COL_DELIVERY_METHOD);
            $criteria->addSelectColumn(SOrdersTableMap::COL_DELIVERY_PRICE);
            $criteria->addSelectColumn(SOrdersTableMap::COL_PAYMENT_METHOD);
            $criteria->addSelectColumn(SOrdersTableMap::COL_STATUS);
            $criteria->addSelectColumn(SOrdersTableMap::COL_PAID);
            $criteria->addSelectColumn(SOrdersTableMap::COL_USER_FULL_NAME);
            $criteria->addSelectColumn(SOrdersTableMap::COL_USER_SURNAME);
            $criteria->addSelectColumn(SOrdersTableMap::COL_USER_EMAIL);
            $criteria->addSelectColumn(SOrdersTableMap::COL_USER_PHONE);
            $criteria->addSelectColumn(SOrdersTableMap::COL_USER_DELIVER_TO);
            $criteria->addSelectColumn(SOrdersTableMap::COL_USER_COMMENT);
            $criteria->addSelectColumn(SOrdersTableMap::COL_DATE_CREATED);
            $criteria->addSelectColumn(SOrdersTableMap::COL_DATE_UPDATED);
            $criteria->addSelectColumn(SOrdersTableMap::COL_USER_IP);
            $criteria->addSelectColumn(SOrdersTableMap::COL_TOTAL_PRICE);
            $criteria->addSelectColumn(SOrdersTableMap::COL_EXTERNAL_ID);
            $criteria->addSelectColumn(SOrdersTableMap::COL_GIFT_CERT_KEY);
            $criteria->addSelectColumn(SOrdersTableMap::COL_DISCOUNT);
            $criteria->addSelectColumn(SOrdersTableMap::COL_GIFT_CERT_PRICE);
            $criteria->addSelectColumn(SOrdersTableMap::COL_DISCOUNT_INFO);
            $criteria->addSelectColumn(SOrdersTableMap::COL_ORIGIN_PRICE);
            $criteria->addSelectColumn(SOrdersTableMap::COL_COMULATIV);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.user_id');
            $criteria->addSelectColumn($alias . '.order_key');
            $criteria->addSelectColumn($alias . '.delivery_method');
            $criteria->addSelectColumn($alias . '.delivery_price');
            $criteria->addSelectColumn($alias . '.payment_method');
            $criteria->addSelectColumn($alias . '.status');
            $criteria->addSelectColumn($alias . '.paid');
            $criteria->addSelectColumn($alias . '.user_full_name');
            $criteria->addSelectColumn($alias . '.user_surname');
            $criteria->addSelectColumn($alias . '.user_email');
            $criteria->addSelectColumn($alias . '.user_phone');
            $criteria->addSelectColumn($alias . '.user_deliver_to');
            $criteria->addSelectColumn($alias . '.user_comment');
            $criteria->addSelectColumn($alias . '.date_created');
            $criteria->addSelectColumn($alias . '.date_updated');
            $criteria->addSelectColumn($alias . '.user_ip');
            $criteria->addSelectColumn($alias . '.total_price');
            $criteria->addSelectColumn($alias . '.external_id');
            $criteria->addSelectColumn($alias . '.gift_cert_key');
            $criteria->addSelectColumn($alias . '.discount');
            $criteria->addSelectColumn($alias . '.gift_cert_price');
            $criteria->addSelectColumn($alias . '.discount_info');
            $criteria->addSelectColumn($alias . '.origin_price');
            $criteria->addSelectColumn($alias . '.comulativ');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getServiceContainer()->getDatabaseMap(SOrdersTableMap::DATABASE_NAME)->getTable(SOrdersTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(SOrdersTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(SOrdersTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new SOrdersTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a SOrders or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or SOrders object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param  ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SOrdersTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \SOrders) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(SOrdersTableMap::DATABASE_NAME);
            $criteria->add(SOrdersTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = SOrdersQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            SOrdersTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                SOrdersTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the shop_orders table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return SOrdersQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a SOrders or Criteria object.
     *
     * @param mixed               $criteria Criteria or SOrders object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SOrdersTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from SOrders object
        }

        if ($criteria->containsKey(SOrdersTableMap::COL_ID) && $criteria->keyContainsValue(SOrdersTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.SOrdersTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = SOrdersQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // SOrdersTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
SOrdersTableMap::buildTableMap();
