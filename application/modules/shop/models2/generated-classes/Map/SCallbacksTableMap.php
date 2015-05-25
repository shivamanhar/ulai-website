<?php

namespace Map;

use \SCallbacks;
use \SCallbacksQuery;
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
 * This class defines the structure of the 'shop_callbacks' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class SCallbacksTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.SCallbacksTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'Shop';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'shop_callbacks';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\SCallbacks';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'SCallbacks';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 8;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 8;

    /**
     * the column name for the id field
     */
    const COL_ID = 'shop_callbacks.id';

    /**
     * the column name for the user_id field
     */
    const COL_USER_ID = 'shop_callbacks.user_id';

    /**
     * the column name for the status_id field
     */
    const COL_STATUS_ID = 'shop_callbacks.status_id';

    /**
     * the column name for the theme_id field
     */
    const COL_THEME_ID = 'shop_callbacks.theme_id';

    /**
     * the column name for the phone field
     */
    const COL_PHONE = 'shop_callbacks.phone';

    /**
     * the column name for the name field
     */
    const COL_NAME = 'shop_callbacks.name';

    /**
     * the column name for the comment field
     */
    const COL_COMMENT = 'shop_callbacks.comment';

    /**
     * the column name for the date field
     */
    const COL_DATE = 'shop_callbacks.date';

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
        self::TYPE_PHPNAME       => array('Id', 'UserId', 'StatusId', 'ThemeId', 'Phone', 'Name', 'Comment', 'Date', ),
        self::TYPE_CAMELNAME     => array('id', 'userId', 'statusId', 'themeId', 'phone', 'name', 'comment', 'date', ),
        self::TYPE_COLNAME       => array(SCallbacksTableMap::COL_ID, SCallbacksTableMap::COL_USER_ID, SCallbacksTableMap::COL_STATUS_ID, SCallbacksTableMap::COL_THEME_ID, SCallbacksTableMap::COL_PHONE, SCallbacksTableMap::COL_NAME, SCallbacksTableMap::COL_COMMENT, SCallbacksTableMap::COL_DATE, ),
        self::TYPE_FIELDNAME     => array('id', 'user_id', 'status_id', 'theme_id', 'phone', 'name', 'comment', 'date', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'UserId' => 1, 'StatusId' => 2, 'ThemeId' => 3, 'Phone' => 4, 'Name' => 5, 'Comment' => 6, 'Date' => 7, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'userId' => 1, 'statusId' => 2, 'themeId' => 3, 'phone' => 4, 'name' => 5, 'comment' => 6, 'date' => 7, ),
        self::TYPE_COLNAME       => array(SCallbacksTableMap::COL_ID => 0, SCallbacksTableMap::COL_USER_ID => 1, SCallbacksTableMap::COL_STATUS_ID => 2, SCallbacksTableMap::COL_THEME_ID => 3, SCallbacksTableMap::COL_PHONE => 4, SCallbacksTableMap::COL_NAME => 5, SCallbacksTableMap::COL_COMMENT => 6, SCallbacksTableMap::COL_DATE => 7, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'user_id' => 1, 'status_id' => 2, 'theme_id' => 3, 'phone' => 4, 'name' => 5, 'comment' => 6, 'date' => 7, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, )
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
        $this->setName('shop_callbacks');
        $this->setPhpName('SCallbacks');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\SCallbacks');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('user_id', 'UserId', 'INTEGER', false, null, null);
        $this->addForeignKey('status_id', 'StatusId', 'INTEGER', 'shop_callbacks_statuses', 'id', false, null, null);
        $this->addForeignKey('theme_id', 'ThemeId', 'INTEGER', 'shop_callbacks_themes', 'id', false, null, null);
        $this->addColumn('phone', 'Phone', 'VARCHAR', false, 255, null);
        $this->addColumn('name', 'Name', 'VARCHAR', false, 255, null);
        $this->addColumn('comment', 'Comment', 'LONGVARCHAR', false, null, null);
        $this->addColumn('date', 'Date', 'INTEGER', false, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('SCallbackStatuses', '\\SCallbackStatuses', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':status_id',
    1 => ':id',
  ),
), null, null, null, false);
        $this->addRelation('SCallbackThemes', '\\SCallbackThemes', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':theme_id',
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
        return $withPrefix ? SCallbacksTableMap::CLASS_DEFAULT : SCallbacksTableMap::OM_CLASS;
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
     * @return array           (SCallbacks object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = SCallbacksTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = SCallbacksTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + SCallbacksTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = SCallbacksTableMap::OM_CLASS;
            /** @var SCallbacks $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            SCallbacksTableMap::addInstanceToPool($obj, $key);
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
            $key = SCallbacksTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = SCallbacksTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var SCallbacks $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                SCallbacksTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(SCallbacksTableMap::COL_ID);
            $criteria->addSelectColumn(SCallbacksTableMap::COL_USER_ID);
            $criteria->addSelectColumn(SCallbacksTableMap::COL_STATUS_ID);
            $criteria->addSelectColumn(SCallbacksTableMap::COL_THEME_ID);
            $criteria->addSelectColumn(SCallbacksTableMap::COL_PHONE);
            $criteria->addSelectColumn(SCallbacksTableMap::COL_NAME);
            $criteria->addSelectColumn(SCallbacksTableMap::COL_COMMENT);
            $criteria->addSelectColumn(SCallbacksTableMap::COL_DATE);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.user_id');
            $criteria->addSelectColumn($alias . '.status_id');
            $criteria->addSelectColumn($alias . '.theme_id');
            $criteria->addSelectColumn($alias . '.phone');
            $criteria->addSelectColumn($alias . '.name');
            $criteria->addSelectColumn($alias . '.comment');
            $criteria->addSelectColumn($alias . '.date');
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
        return Propel::getServiceContainer()->getDatabaseMap(SCallbacksTableMap::DATABASE_NAME)->getTable(SCallbacksTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(SCallbacksTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(SCallbacksTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new SCallbacksTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a SCallbacks or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or SCallbacks object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(SCallbacksTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \SCallbacks) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(SCallbacksTableMap::DATABASE_NAME);
            $criteria->add(SCallbacksTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = SCallbacksQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            SCallbacksTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                SCallbacksTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the shop_callbacks table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return SCallbacksQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a SCallbacks or Criteria object.
     *
     * @param mixed               $criteria Criteria or SCallbacks object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SCallbacksTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from SCallbacks object
        }

        if ($criteria->containsKey(SCallbacksTableMap::COL_ID) && $criteria->keyContainsValue(SCallbacksTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.SCallbacksTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = SCallbacksQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // SCallbacksTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
SCallbacksTableMap::buildTableMap();
