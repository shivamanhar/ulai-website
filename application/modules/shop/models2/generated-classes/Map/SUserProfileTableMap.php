<?php

namespace Map;

use \SUserProfile;
use \SUserProfileQuery;
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
 * This class defines the structure of the 'users' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class SUserProfileTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.SUserProfileTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'Shop';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'users';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\SUserProfile';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'SUserProfile';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 21;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 21;

    /**
     * the column name for the id field
     */
    const COL_ID = 'users.id';

    /**
     * the column name for the role_id field
     */
    const COL_ROLE_ID = 'users.role_id';

    /**
     * the column name for the username field
     */
    const COL_USERNAME = 'users.username';

    /**
     * the column name for the password field
     */
    const COL_PASSWORD = 'users.password';

    /**
     * the column name for the email field
     */
    const COL_EMAIL = 'users.email';

    /**
     * the column name for the address field
     */
    const COL_ADDRESS = 'users.address';

    /**
     * the column name for the phone field
     */
    const COL_PHONE = 'users.phone';

    /**
     * the column name for the banned field
     */
    const COL_BANNED = 'users.banned';

    /**
     * the column name for the ban_reason field
     */
    const COL_BAN_REASON = 'users.ban_reason';

    /**
     * the column name for the newpass field
     */
    const COL_NEWPASS = 'users.newpass';

    /**
     * the column name for the newpass_key field
     */
    const COL_NEWPASS_KEY = 'users.newpass_key';

    /**
     * the column name for the newpass_time field
     */
    const COL_NEWPASS_TIME = 'users.newpass_time';

    /**
     * the column name for the created field
     */
    const COL_CREATED = 'users.created';

    /**
     * the column name for the last_ip field
     */
    const COL_LAST_IP = 'users.last_ip';

    /**
     * the column name for the last_login field
     */
    const COL_LAST_LOGIN = 'users.last_login';

    /**
     * the column name for the modified field
     */
    const COL_MODIFIED = 'users.modified';

    /**
     * the column name for the cart_data field
     */
    const COL_CART_DATA = 'users.cart_data';

    /**
     * the column name for the wish_list_data field
     */
    const COL_WISH_LIST_DATA = 'users.wish_list_data';

    /**
     * the column name for the key field
     */
    const COL_KEY = 'users.key';

    /**
     * the column name for the amout field
     */
    const COL_AMOUT = 'users.amout';

    /**
     * the column name for the discount field
     */
    const COL_DISCOUNT = 'users.discount';

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
        self::TYPE_PHPNAME       => array('Id', 'RoleId', 'Name', 'Password', 'UserEmail', 'Address', 'Phone', 'Banned', 'BanReason', 'Newpass', 'NewpassKey', 'NewpassTime', 'DateCreated', 'LastIp', 'LastLogin', 'Modified', 'CartData', 'WishListData', 'Key', 'Amout', 'Discount', ),
        self::TYPE_CAMELNAME     => array('id', 'roleId', 'name', 'password', 'userEmail', 'address', 'phone', 'banned', 'banReason', 'newpass', 'newpassKey', 'newpassTime', 'dateCreated', 'lastIp', 'lastLogin', 'modified', 'cartData', 'wishListData', 'key', 'amout', 'discount', ),
        self::TYPE_COLNAME       => array(SUserProfileTableMap::COL_ID, SUserProfileTableMap::COL_ROLE_ID, SUserProfileTableMap::COL_USERNAME, SUserProfileTableMap::COL_PASSWORD, SUserProfileTableMap::COL_EMAIL, SUserProfileTableMap::COL_ADDRESS, SUserProfileTableMap::COL_PHONE, SUserProfileTableMap::COL_BANNED, SUserProfileTableMap::COL_BAN_REASON, SUserProfileTableMap::COL_NEWPASS, SUserProfileTableMap::COL_NEWPASS_KEY, SUserProfileTableMap::COL_NEWPASS_TIME, SUserProfileTableMap::COL_CREATED, SUserProfileTableMap::COL_LAST_IP, SUserProfileTableMap::COL_LAST_LOGIN, SUserProfileTableMap::COL_MODIFIED, SUserProfileTableMap::COL_CART_DATA, SUserProfileTableMap::COL_WISH_LIST_DATA, SUserProfileTableMap::COL_KEY, SUserProfileTableMap::COL_AMOUT, SUserProfileTableMap::COL_DISCOUNT, ),
        self::TYPE_FIELDNAME     => array('id', 'role_id', 'username', 'password', 'email', 'address', 'phone', 'banned', 'ban_reason', 'newpass', 'newpass_key', 'newpass_time', 'created', 'last_ip', 'last_login', 'modified', 'cart_data', 'wish_list_data', 'key', 'amout', 'discount', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'RoleId' => 1, 'Name' => 2, 'Password' => 3, 'UserEmail' => 4, 'Address' => 5, 'Phone' => 6, 'Banned' => 7, 'BanReason' => 8, 'Newpass' => 9, 'NewpassKey' => 10, 'NewpassTime' => 11, 'DateCreated' => 12, 'LastIp' => 13, 'LastLogin' => 14, 'Modified' => 15, 'CartData' => 16, 'WishListData' => 17, 'Key' => 18, 'Amout' => 19, 'Discount' => 20, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'roleId' => 1, 'name' => 2, 'password' => 3, 'userEmail' => 4, 'address' => 5, 'phone' => 6, 'banned' => 7, 'banReason' => 8, 'newpass' => 9, 'newpassKey' => 10, 'newpassTime' => 11, 'dateCreated' => 12, 'lastIp' => 13, 'lastLogin' => 14, 'modified' => 15, 'cartData' => 16, 'wishListData' => 17, 'key' => 18, 'amout' => 19, 'discount' => 20, ),
        self::TYPE_COLNAME       => array(SUserProfileTableMap::COL_ID => 0, SUserProfileTableMap::COL_ROLE_ID => 1, SUserProfileTableMap::COL_USERNAME => 2, SUserProfileTableMap::COL_PASSWORD => 3, SUserProfileTableMap::COL_EMAIL => 4, SUserProfileTableMap::COL_ADDRESS => 5, SUserProfileTableMap::COL_PHONE => 6, SUserProfileTableMap::COL_BANNED => 7, SUserProfileTableMap::COL_BAN_REASON => 8, SUserProfileTableMap::COL_NEWPASS => 9, SUserProfileTableMap::COL_NEWPASS_KEY => 10, SUserProfileTableMap::COL_NEWPASS_TIME => 11, SUserProfileTableMap::COL_CREATED => 12, SUserProfileTableMap::COL_LAST_IP => 13, SUserProfileTableMap::COL_LAST_LOGIN => 14, SUserProfileTableMap::COL_MODIFIED => 15, SUserProfileTableMap::COL_CART_DATA => 16, SUserProfileTableMap::COL_WISH_LIST_DATA => 17, SUserProfileTableMap::COL_KEY => 18, SUserProfileTableMap::COL_AMOUT => 19, SUserProfileTableMap::COL_DISCOUNT => 20, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'role_id' => 1, 'username' => 2, 'password' => 3, 'email' => 4, 'address' => 5, 'phone' => 6, 'banned' => 7, 'ban_reason' => 8, 'newpass' => 9, 'newpass_key' => 10, 'newpass_time' => 11, 'created' => 12, 'last_ip' => 13, 'last_login' => 14, 'modified' => 15, 'cart_data' => 16, 'wish_list_data' => 17, 'key' => 18, 'amout' => 19, 'discount' => 20, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, )
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
        $this->setName('users');
        $this->setPhpName('SUserProfile');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\SUserProfile');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('role_id', 'RoleId', 'INTEGER', false, null, null);
        $this->addColumn('username', 'Name', 'VARCHAR', false, 50, null);
        $this->addColumn('password', 'Password', 'VARCHAR', false, 255, null);
        $this->addColumn('email', 'UserEmail', 'VARCHAR', false, 100, null);
        $this->addColumn('address', 'Address', 'VARCHAR', false, 255, null);
        $this->addColumn('phone', 'Phone', 'VARCHAR', false, 32, null);
        $this->addColumn('banned', 'Banned', 'TINYINT', false, 1, null);
        $this->addColumn('ban_reason', 'BanReason', 'VARCHAR', false, 255, null);
        $this->addColumn('newpass', 'Newpass', 'VARCHAR', false, 255, null);
        $this->addColumn('newpass_key', 'NewpassKey', 'VARCHAR', false, 255, null);
        $this->addColumn('newpass_time', 'NewpassTime', 'INTEGER', false, null, null);
        $this->addColumn('created', 'DateCreated', 'INTEGER', false, null, null);
        $this->addColumn('last_ip', 'LastIp', 'VARCHAR', false, 40, null);
        $this->addColumn('last_login', 'LastLogin', 'INTEGER', false, null, null);
        $this->addColumn('modified', 'Modified', 'TIMESTAMP', false, null, null);
        $this->addColumn('cart_data', 'CartData', 'LONGVARCHAR', false, null, null);
        $this->addColumn('wish_list_data', 'WishListData', 'LONGVARCHAR', false, null, null);
        $this->addColumn('key', 'Key', 'VARCHAR', true, 255, null);
        $this->addColumn('amout', 'Amout', 'FLOAT', true, null, null);
        $this->addColumn('discount', 'Discount', 'VARCHAR', false, 255, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
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
        return $withPrefix ? SUserProfileTableMap::CLASS_DEFAULT : SUserProfileTableMap::OM_CLASS;
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
     * @return array           (SUserProfile object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = SUserProfileTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = SUserProfileTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + SUserProfileTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = SUserProfileTableMap::OM_CLASS;
            /** @var SUserProfile $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            SUserProfileTableMap::addInstanceToPool($obj, $key);
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
            $key = SUserProfileTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = SUserProfileTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var SUserProfile $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                SUserProfileTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(SUserProfileTableMap::COL_ID);
            $criteria->addSelectColumn(SUserProfileTableMap::COL_ROLE_ID);
            $criteria->addSelectColumn(SUserProfileTableMap::COL_USERNAME);
            $criteria->addSelectColumn(SUserProfileTableMap::COL_PASSWORD);
            $criteria->addSelectColumn(SUserProfileTableMap::COL_EMAIL);
            $criteria->addSelectColumn(SUserProfileTableMap::COL_ADDRESS);
            $criteria->addSelectColumn(SUserProfileTableMap::COL_PHONE);
            $criteria->addSelectColumn(SUserProfileTableMap::COL_BANNED);
            $criteria->addSelectColumn(SUserProfileTableMap::COL_BAN_REASON);
            $criteria->addSelectColumn(SUserProfileTableMap::COL_NEWPASS);
            $criteria->addSelectColumn(SUserProfileTableMap::COL_NEWPASS_KEY);
            $criteria->addSelectColumn(SUserProfileTableMap::COL_NEWPASS_TIME);
            $criteria->addSelectColumn(SUserProfileTableMap::COL_CREATED);
            $criteria->addSelectColumn(SUserProfileTableMap::COL_LAST_IP);
            $criteria->addSelectColumn(SUserProfileTableMap::COL_LAST_LOGIN);
            $criteria->addSelectColumn(SUserProfileTableMap::COL_MODIFIED);
            $criteria->addSelectColumn(SUserProfileTableMap::COL_CART_DATA);
            $criteria->addSelectColumn(SUserProfileTableMap::COL_WISH_LIST_DATA);
            $criteria->addSelectColumn(SUserProfileTableMap::COL_KEY);
            $criteria->addSelectColumn(SUserProfileTableMap::COL_AMOUT);
            $criteria->addSelectColumn(SUserProfileTableMap::COL_DISCOUNT);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.role_id');
            $criteria->addSelectColumn($alias . '.username');
            $criteria->addSelectColumn($alias . '.password');
            $criteria->addSelectColumn($alias . '.email');
            $criteria->addSelectColumn($alias . '.address');
            $criteria->addSelectColumn($alias . '.phone');
            $criteria->addSelectColumn($alias . '.banned');
            $criteria->addSelectColumn($alias . '.ban_reason');
            $criteria->addSelectColumn($alias . '.newpass');
            $criteria->addSelectColumn($alias . '.newpass_key');
            $criteria->addSelectColumn($alias . '.newpass_time');
            $criteria->addSelectColumn($alias . '.created');
            $criteria->addSelectColumn($alias . '.last_ip');
            $criteria->addSelectColumn($alias . '.last_login');
            $criteria->addSelectColumn($alias . '.modified');
            $criteria->addSelectColumn($alias . '.cart_data');
            $criteria->addSelectColumn($alias . '.wish_list_data');
            $criteria->addSelectColumn($alias . '.key');
            $criteria->addSelectColumn($alias . '.amout');
            $criteria->addSelectColumn($alias . '.discount');
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
        return Propel::getServiceContainer()->getDatabaseMap(SUserProfileTableMap::DATABASE_NAME)->getTable(SUserProfileTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(SUserProfileTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(SUserProfileTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new SUserProfileTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a SUserProfile or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or SUserProfile object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(SUserProfileTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \SUserProfile) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(SUserProfileTableMap::DATABASE_NAME);
            $criteria->add(SUserProfileTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = SUserProfileQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            SUserProfileTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                SUserProfileTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the users table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return SUserProfileQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a SUserProfile or Criteria object.
     *
     * @param mixed               $criteria Criteria or SUserProfile object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SUserProfileTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from SUserProfile object
        }

        if ($criteria->containsKey(SUserProfileTableMap::COL_ID) && $criteria->keyContainsValue(SUserProfileTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.SUserProfileTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = SUserProfileQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // SUserProfileTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
SUserProfileTableMap::buildTableMap();
