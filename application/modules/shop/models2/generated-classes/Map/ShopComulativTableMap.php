<?php

namespace Map;

use \ShopComulativ;
use \ShopComulativQuery;
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
 * This class defines the structure of the 'shop_comulativ_discount' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class ShopComulativTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.ShopComulativTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'Shop';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'shop_comulativ_discount';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\ShopComulativ';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'ShopComulativ';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 7;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 7;

    /**
     * the column name for the id field
     */
    const COL_ID = 'shop_comulativ_discount.id';

    /**
     * the column name for the description field
     */
    const COL_DESCRIPTION = 'shop_comulativ_discount.description';

    /**
     * the column name for the discount field
     */
    const COL_DISCOUNT = 'shop_comulativ_discount.discount';

    /**
     * the column name for the active field
     */
    const COL_ACTIVE = 'shop_comulativ_discount.active';

    /**
     * the column name for the date field
     */
    const COL_DATE = 'shop_comulativ_discount.date';

    /**
     * the column name for the total field
     */
    const COL_TOTAL = 'shop_comulativ_discount.total';

    /**
     * the column name for the total_a field
     */
    const COL_TOTAL_A = 'shop_comulativ_discount.total_a';

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
        self::TYPE_PHPNAME       => array('Id', 'Description', 'Discount', 'Active', 'Date', 'Total', 'TotalA', ),
        self::TYPE_CAMELNAME     => array('id', 'description', 'discount', 'active', 'date', 'total', 'totalA', ),
        self::TYPE_COLNAME       => array(ShopComulativTableMap::COL_ID, ShopComulativTableMap::COL_DESCRIPTION, ShopComulativTableMap::COL_DISCOUNT, ShopComulativTableMap::COL_ACTIVE, ShopComulativTableMap::COL_DATE, ShopComulativTableMap::COL_TOTAL, ShopComulativTableMap::COL_TOTAL_A, ),
        self::TYPE_FIELDNAME     => array('id', 'description', 'discount', 'active', 'date', 'total', 'total_a', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'Description' => 1, 'Discount' => 2, 'Active' => 3, 'Date' => 4, 'Total' => 5, 'TotalA' => 6, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'description' => 1, 'discount' => 2, 'active' => 3, 'date' => 4, 'total' => 5, 'totalA' => 6, ),
        self::TYPE_COLNAME       => array(ShopComulativTableMap::COL_ID => 0, ShopComulativTableMap::COL_DESCRIPTION => 1, ShopComulativTableMap::COL_DISCOUNT => 2, ShopComulativTableMap::COL_ACTIVE => 3, ShopComulativTableMap::COL_DATE => 4, ShopComulativTableMap::COL_TOTAL => 5, ShopComulativTableMap::COL_TOTAL_A => 6, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'description' => 1, 'discount' => 2, 'active' => 3, 'date' => 4, 'total' => 5, 'total_a' => 6, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, )
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
        $this->setName('shop_comulativ_discount');
        $this->setPhpName('ShopComulativ');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\ShopComulativ');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        $this->setIsCrossRef(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('description', 'Description', 'VARCHAR', false, 255, null);
        $this->addColumn('discount', 'Discount', 'INTEGER', false, 3, null);
        $this->addColumn('active', 'Active', 'INTEGER', false, 1, null);
        $this->addColumn('date', 'Date', 'INTEGER', false, 15, null);
        $this->addColumn('total', 'Total', 'INTEGER', false, 255, null);
        $this->addColumn('total_a', 'TotalA', 'INTEGER', false, 255, null);
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
        return $withPrefix ? ShopComulativTableMap::CLASS_DEFAULT : ShopComulativTableMap::OM_CLASS;
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
     * @return array           (ShopComulativ object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = ShopComulativTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = ShopComulativTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + ShopComulativTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = ShopComulativTableMap::OM_CLASS;
            /** @var ShopComulativ $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            ShopComulativTableMap::addInstanceToPool($obj, $key);
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
            $key = ShopComulativTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = ShopComulativTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var ShopComulativ $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                ShopComulativTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(ShopComulativTableMap::COL_ID);
            $criteria->addSelectColumn(ShopComulativTableMap::COL_DESCRIPTION);
            $criteria->addSelectColumn(ShopComulativTableMap::COL_DISCOUNT);
            $criteria->addSelectColumn(ShopComulativTableMap::COL_ACTIVE);
            $criteria->addSelectColumn(ShopComulativTableMap::COL_DATE);
            $criteria->addSelectColumn(ShopComulativTableMap::COL_TOTAL);
            $criteria->addSelectColumn(ShopComulativTableMap::COL_TOTAL_A);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.description');
            $criteria->addSelectColumn($alias . '.discount');
            $criteria->addSelectColumn($alias . '.active');
            $criteria->addSelectColumn($alias . '.date');
            $criteria->addSelectColumn($alias . '.total');
            $criteria->addSelectColumn($alias . '.total_a');
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
        return Propel::getServiceContainer()->getDatabaseMap(ShopComulativTableMap::DATABASE_NAME)->getTable(ShopComulativTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(ShopComulativTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(ShopComulativTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new ShopComulativTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a ShopComulativ or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ShopComulativ object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(ShopComulativTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \ShopComulativ) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(ShopComulativTableMap::DATABASE_NAME);
            $criteria->add(ShopComulativTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = ShopComulativQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            ShopComulativTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                ShopComulativTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the shop_comulativ_discount table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return ShopComulativQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a ShopComulativ or Criteria object.
     *
     * @param mixed               $criteria Criteria or ShopComulativ object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ShopComulativTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from ShopComulativ object
        }

        if ($criteria->containsKey(ShopComulativTableMap::COL_ID) && $criteria->keyContainsValue(ShopComulativTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.ShopComulativTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = ShopComulativQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // ShopComulativTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
ShopComulativTableMap::buildTableMap();
