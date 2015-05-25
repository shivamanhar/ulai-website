<?php

namespace Map;

use \SOrderStatusHistory;
use \SOrderStatusHistoryQuery;
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
 * This class defines the structure of the 'shop_orders_status_history' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class SOrderStatusHistoryTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.SOrderStatusHistoryTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'Shop';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'shop_orders_status_history';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\SOrderStatusHistory';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'SOrderStatusHistory';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 6;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 6;

    /**
     * the column name for the id field
     */
    const COL_ID = 'shop_orders_status_history.id';

    /**
     * the column name for the order_id field
     */
    const COL_ORDER_ID = 'shop_orders_status_history.order_id';

    /**
     * the column name for the status_id field
     */
    const COL_STATUS_ID = 'shop_orders_status_history.status_id';

    /**
     * the column name for the user_id field
     */
    const COL_USER_ID = 'shop_orders_status_history.user_id';

    /**
     * the column name for the date_created field
     */
    const COL_DATE_CREATED = 'shop_orders_status_history.date_created';

    /**
     * the column name for the comment field
     */
    const COL_COMMENT = 'shop_orders_status_history.comment';

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
        self::TYPE_PHPNAME       => array('Id', 'OrderId', 'StatusId', 'UserId', 'DateCreated', 'Comment', ),
        self::TYPE_CAMELNAME     => array('id', 'orderId', 'statusId', 'userId', 'dateCreated', 'comment', ),
        self::TYPE_COLNAME       => array(SOrderStatusHistoryTableMap::COL_ID, SOrderStatusHistoryTableMap::COL_ORDER_ID, SOrderStatusHistoryTableMap::COL_STATUS_ID, SOrderStatusHistoryTableMap::COL_USER_ID, SOrderStatusHistoryTableMap::COL_DATE_CREATED, SOrderStatusHistoryTableMap::COL_COMMENT, ),
        self::TYPE_FIELDNAME     => array('id', 'order_id', 'status_id', 'user_id', 'date_created', 'comment', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'OrderId' => 1, 'StatusId' => 2, 'UserId' => 3, 'DateCreated' => 4, 'Comment' => 5, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'orderId' => 1, 'statusId' => 2, 'userId' => 3, 'dateCreated' => 4, 'comment' => 5, ),
        self::TYPE_COLNAME       => array(SOrderStatusHistoryTableMap::COL_ID => 0, SOrderStatusHistoryTableMap::COL_ORDER_ID => 1, SOrderStatusHistoryTableMap::COL_STATUS_ID => 2, SOrderStatusHistoryTableMap::COL_USER_ID => 3, SOrderStatusHistoryTableMap::COL_DATE_CREATED => 4, SOrderStatusHistoryTableMap::COL_COMMENT => 5, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'order_id' => 1, 'status_id' => 2, 'user_id' => 3, 'date_created' => 4, 'comment' => 5, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, )
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
        $this->setName('shop_orders_status_history');
        $this->setPhpName('SOrderStatusHistory');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\SOrderStatusHistory');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('order_id', 'OrderId', 'INTEGER', 'shop_orders', 'id', true, null, null);
        $this->addForeignKey('status_id', 'StatusId', 'INTEGER', 'shop_order_statuses', 'id', false, null, null);
        $this->addColumn('user_id', 'UserId', 'INTEGER', true, null, null);
        $this->addColumn('date_created', 'DateCreated', 'INTEGER', false, null, null);
        $this->addColumn('comment', 'Comment', 'VARCHAR', false, 1000, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('SOrders', '\\SOrders', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':order_id',
    1 => ':id',
  ),
), 'CASCADE', null, null, false);
        $this->addRelation('SOrderStatuses', '\\SOrderStatuses', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':status_id',
    1 => ':id',
  ),
), 'SET NULL', null, null, false);
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
        return $withPrefix ? SOrderStatusHistoryTableMap::CLASS_DEFAULT : SOrderStatusHistoryTableMap::OM_CLASS;
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
     * @return array           (SOrderStatusHistory object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = SOrderStatusHistoryTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = SOrderStatusHistoryTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + SOrderStatusHistoryTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = SOrderStatusHistoryTableMap::OM_CLASS;
            /** @var SOrderStatusHistory $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            SOrderStatusHistoryTableMap::addInstanceToPool($obj, $key);
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
            $key = SOrderStatusHistoryTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = SOrderStatusHistoryTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var SOrderStatusHistory $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                SOrderStatusHistoryTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(SOrderStatusHistoryTableMap::COL_ID);
            $criteria->addSelectColumn(SOrderStatusHistoryTableMap::COL_ORDER_ID);
            $criteria->addSelectColumn(SOrderStatusHistoryTableMap::COL_STATUS_ID);
            $criteria->addSelectColumn(SOrderStatusHistoryTableMap::COL_USER_ID);
            $criteria->addSelectColumn(SOrderStatusHistoryTableMap::COL_DATE_CREATED);
            $criteria->addSelectColumn(SOrderStatusHistoryTableMap::COL_COMMENT);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.order_id');
            $criteria->addSelectColumn($alias . '.status_id');
            $criteria->addSelectColumn($alias . '.user_id');
            $criteria->addSelectColumn($alias . '.date_created');
            $criteria->addSelectColumn($alias . '.comment');
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
        return Propel::getServiceContainer()->getDatabaseMap(SOrderStatusHistoryTableMap::DATABASE_NAME)->getTable(SOrderStatusHistoryTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(SOrderStatusHistoryTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(SOrderStatusHistoryTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new SOrderStatusHistoryTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a SOrderStatusHistory or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or SOrderStatusHistory object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(SOrderStatusHistoryTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \SOrderStatusHistory) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(SOrderStatusHistoryTableMap::DATABASE_NAME);
            $criteria->add(SOrderStatusHistoryTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = SOrderStatusHistoryQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            SOrderStatusHistoryTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                SOrderStatusHistoryTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the shop_orders_status_history table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return SOrderStatusHistoryQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a SOrderStatusHistory or Criteria object.
     *
     * @param mixed               $criteria Criteria or SOrderStatusHistory object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SOrderStatusHistoryTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from SOrderStatusHistory object
        }

        if ($criteria->containsKey(SOrderStatusHistoryTableMap::COL_ID) && $criteria->keyContainsValue(SOrderStatusHistoryTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.SOrderStatusHistoryTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = SOrderStatusHistoryQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // SOrderStatusHistoryTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
SOrderStatusHistoryTableMap::buildTableMap();
