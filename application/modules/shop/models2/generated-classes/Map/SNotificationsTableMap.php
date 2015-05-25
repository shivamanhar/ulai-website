<?php

namespace Map;

use \SNotifications;
use \SNotificationsQuery;
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
 * This class defines the structure of the 'shop_notifications' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class SNotificationsTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.SNotificationsTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'Shop';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'shop_notifications';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\SNotifications';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'SNotifications';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 12;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 12;

    /**
     * the column name for the id field
     */
    const COL_ID = 'shop_notifications.id';

    /**
     * the column name for the product_id field
     */
    const COL_PRODUCT_ID = 'shop_notifications.product_id';

    /**
     * the column name for the variant_id field
     */
    const COL_VARIANT_ID = 'shop_notifications.variant_id';

    /**
     * the column name for the user_name field
     */
    const COL_USER_NAME = 'shop_notifications.user_name';

    /**
     * the column name for the user_email field
     */
    const COL_USER_EMAIL = 'shop_notifications.user_email';

    /**
     * the column name for the user_phone field
     */
    const COL_USER_PHONE = 'shop_notifications.user_phone';

    /**
     * the column name for the user_comment field
     */
    const COL_USER_COMMENT = 'shop_notifications.user_comment';

    /**
     * the column name for the status field
     */
    const COL_STATUS = 'shop_notifications.status';

    /**
     * the column name for the date_created field
     */
    const COL_DATE_CREATED = 'shop_notifications.date_created';

    /**
     * the column name for the active_to field
     */
    const COL_ACTIVE_TO = 'shop_notifications.active_to';

    /**
     * the column name for the manager_id field
     */
    const COL_MANAGER_ID = 'shop_notifications.manager_id';

    /**
     * the column name for the notified_by_email field
     */
    const COL_NOTIFIED_BY_EMAIL = 'shop_notifications.notified_by_email';

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
        self::TYPE_PHPNAME       => array('Id', 'ProductId', 'VariantId', 'UserName', 'UserEmail', 'UserPhone', 'UserComment', 'Status', 'DateCreated', 'ActiveTo', 'ManagerId', 'NotifiedByEmail', ),
        self::TYPE_CAMELNAME     => array('id', 'productId', 'variantId', 'userName', 'userEmail', 'userPhone', 'userComment', 'status', 'dateCreated', 'activeTo', 'managerId', 'notifiedByEmail', ),
        self::TYPE_COLNAME       => array(SNotificationsTableMap::COL_ID, SNotificationsTableMap::COL_PRODUCT_ID, SNotificationsTableMap::COL_VARIANT_ID, SNotificationsTableMap::COL_USER_NAME, SNotificationsTableMap::COL_USER_EMAIL, SNotificationsTableMap::COL_USER_PHONE, SNotificationsTableMap::COL_USER_COMMENT, SNotificationsTableMap::COL_STATUS, SNotificationsTableMap::COL_DATE_CREATED, SNotificationsTableMap::COL_ACTIVE_TO, SNotificationsTableMap::COL_MANAGER_ID, SNotificationsTableMap::COL_NOTIFIED_BY_EMAIL, ),
        self::TYPE_FIELDNAME     => array('id', 'product_id', 'variant_id', 'user_name', 'user_email', 'user_phone', 'user_comment', 'status', 'date_created', 'active_to', 'manager_id', 'notified_by_email', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'ProductId' => 1, 'VariantId' => 2, 'UserName' => 3, 'UserEmail' => 4, 'UserPhone' => 5, 'UserComment' => 6, 'Status' => 7, 'DateCreated' => 8, 'ActiveTo' => 9, 'ManagerId' => 10, 'NotifiedByEmail' => 11, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'productId' => 1, 'variantId' => 2, 'userName' => 3, 'userEmail' => 4, 'userPhone' => 5, 'userComment' => 6, 'status' => 7, 'dateCreated' => 8, 'activeTo' => 9, 'managerId' => 10, 'notifiedByEmail' => 11, ),
        self::TYPE_COLNAME       => array(SNotificationsTableMap::COL_ID => 0, SNotificationsTableMap::COL_PRODUCT_ID => 1, SNotificationsTableMap::COL_VARIANT_ID => 2, SNotificationsTableMap::COL_USER_NAME => 3, SNotificationsTableMap::COL_USER_EMAIL => 4, SNotificationsTableMap::COL_USER_PHONE => 5, SNotificationsTableMap::COL_USER_COMMENT => 6, SNotificationsTableMap::COL_STATUS => 7, SNotificationsTableMap::COL_DATE_CREATED => 8, SNotificationsTableMap::COL_ACTIVE_TO => 9, SNotificationsTableMap::COL_MANAGER_ID => 10, SNotificationsTableMap::COL_NOTIFIED_BY_EMAIL => 11, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'product_id' => 1, 'variant_id' => 2, 'user_name' => 3, 'user_email' => 4, 'user_phone' => 5, 'user_comment' => 6, 'status' => 7, 'date_created' => 8, 'active_to' => 9, 'manager_id' => 10, 'notified_by_email' => 11, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, )
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
        $this->setName('shop_notifications');
        $this->setPhpName('SNotifications');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\SNotifications');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('product_id', 'ProductId', 'INTEGER', 'shop_products', 'id', true, null, null);
        $this->addForeignKey('variant_id', 'VariantId', 'INTEGER', 'shop_product_variants', 'id', true, null, null);
        $this->addColumn('user_name', 'UserName', 'VARCHAR', false, 100, null);
        $this->addColumn('user_email', 'UserEmail', 'VARCHAR', false, 100, null);
        $this->addColumn('user_phone', 'UserPhone', 'VARCHAR', false, 100, null);
        $this->addColumn('user_comment', 'UserComment', 'VARCHAR', false, 500, null);
        $this->addForeignKey('status', 'Status', 'INTEGER', 'shop_notification_statuses', 'id', true, null, null);
        $this->addColumn('date_created', 'DateCreated', 'INTEGER', true, null, null);
        $this->addColumn('active_to', 'ActiveTo', 'INTEGER', true, null, null);
        $this->addColumn('manager_id', 'ManagerId', 'INTEGER', false, null, null);
        $this->addColumn('notified_by_email', 'NotifiedByEmail', 'BOOLEAN', false, 1, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('SProducts', '\\SProducts', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':product_id',
    1 => ':id',
  ),
), null, null, null, false);
        $this->addRelation('SProductVariants', '\\SProductVariants', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':variant_id',
    1 => ':id',
  ),
), null, null, null, false);
        $this->addRelation('SNotificationStatuses', '\\SNotificationStatuses', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':status',
    1 => ':id',
  ),
), null, null, null, false);
    } // buildRelations()

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
        return $withPrefix ? SNotificationsTableMap::CLASS_DEFAULT : SNotificationsTableMap::OM_CLASS;
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
     * @return array           (SNotifications object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = SNotificationsTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = SNotificationsTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + SNotificationsTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = SNotificationsTableMap::OM_CLASS;
            /** @var SNotifications $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            SNotificationsTableMap::addInstanceToPool($obj, $key);
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
            $key = SNotificationsTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = SNotificationsTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var SNotifications $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                SNotificationsTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(SNotificationsTableMap::COL_ID);
            $criteria->addSelectColumn(SNotificationsTableMap::COL_PRODUCT_ID);
            $criteria->addSelectColumn(SNotificationsTableMap::COL_VARIANT_ID);
            $criteria->addSelectColumn(SNotificationsTableMap::COL_USER_NAME);
            $criteria->addSelectColumn(SNotificationsTableMap::COL_USER_EMAIL);
            $criteria->addSelectColumn(SNotificationsTableMap::COL_USER_PHONE);
            $criteria->addSelectColumn(SNotificationsTableMap::COL_USER_COMMENT);
            $criteria->addSelectColumn(SNotificationsTableMap::COL_STATUS);
            $criteria->addSelectColumn(SNotificationsTableMap::COL_DATE_CREATED);
            $criteria->addSelectColumn(SNotificationsTableMap::COL_ACTIVE_TO);
            $criteria->addSelectColumn(SNotificationsTableMap::COL_MANAGER_ID);
            $criteria->addSelectColumn(SNotificationsTableMap::COL_NOTIFIED_BY_EMAIL);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.product_id');
            $criteria->addSelectColumn($alias . '.variant_id');
            $criteria->addSelectColumn($alias . '.user_name');
            $criteria->addSelectColumn($alias . '.user_email');
            $criteria->addSelectColumn($alias . '.user_phone');
            $criteria->addSelectColumn($alias . '.user_comment');
            $criteria->addSelectColumn($alias . '.status');
            $criteria->addSelectColumn($alias . '.date_created');
            $criteria->addSelectColumn($alias . '.active_to');
            $criteria->addSelectColumn($alias . '.manager_id');
            $criteria->addSelectColumn($alias . '.notified_by_email');
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
        return Propel::getServiceContainer()->getDatabaseMap(SNotificationsTableMap::DATABASE_NAME)->getTable(SNotificationsTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(SNotificationsTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(SNotificationsTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new SNotificationsTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a SNotifications or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or SNotifications object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(SNotificationsTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \SNotifications) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(SNotificationsTableMap::DATABASE_NAME);
            $criteria->add(SNotificationsTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = SNotificationsQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            SNotificationsTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                SNotificationsTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the shop_notifications table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return SNotificationsQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a SNotifications or Criteria object.
     *
     * @param mixed               $criteria Criteria or SNotifications object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SNotificationsTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from SNotifications object
        }

        if ($criteria->containsKey(SNotificationsTableMap::COL_ID) && $criteria->keyContainsValue(SNotificationsTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.SNotificationsTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = SNotificationsQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // SNotificationsTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
SNotificationsTableMap::buildTableMap();
