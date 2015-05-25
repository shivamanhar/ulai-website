<?php

namespace Map;

use \ShopDiscounts;
use \ShopDiscountsQuery;
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
 * This class defines the structure of the 'shop_discounts' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class ShopDiscountsTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.ShopDiscountsTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'Shop';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'shop_discounts';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\ShopDiscounts';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'ShopDiscounts';

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
    const COL_ID = 'shop_discounts.id';

    /**
     * the column name for the name field
     */
    const COL_NAME = 'shop_discounts.name';

    /**
     * the column name for the description field
     */
    const COL_DESCRIPTION = 'shop_discounts.description';

    /**
     * the column name for the active field
     */
    const COL_ACTIVE = 'shop_discounts.active';

    /**
     * the column name for the date_start field
     */
    const COL_DATE_START = 'shop_discounts.date_start';

    /**
     * the column name for the date_stop field
     */
    const COL_DATE_STOP = 'shop_discounts.date_stop';

    /**
     * the column name for the discount field
     */
    const COL_DISCOUNT = 'shop_discounts.discount';

    /**
     * the column name for the user_group field
     */
    const COL_USER_GROUP = 'shop_discounts.user_group';

    /**
     * the column name for the min_price field
     */
    const COL_MIN_PRICE = 'shop_discounts.min_price';

    /**
     * the column name for the max_price field
     */
    const COL_MAX_PRICE = 'shop_discounts.max_price';

    /**
     * the column name for the categories field
     */
    const COL_CATEGORIES = 'shop_discounts.categories';

    /**
     * the column name for the products field
     */
    const COL_PRODUCTS = 'shop_discounts.products';

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
        self::TYPE_PHPNAME       => array('Id', 'Name', 'Description', 'Active', 'DateStart', 'DateStop', 'Discount', 'UserGroup', 'MinPrice', 'MaxPrice', 'Categories', 'Products', ),
        self::TYPE_CAMELNAME     => array('id', 'name', 'description', 'active', 'dateStart', 'dateStop', 'discount', 'userGroup', 'minPrice', 'maxPrice', 'categories', 'products', ),
        self::TYPE_COLNAME       => array(ShopDiscountsTableMap::COL_ID, ShopDiscountsTableMap::COL_NAME, ShopDiscountsTableMap::COL_DESCRIPTION, ShopDiscountsTableMap::COL_ACTIVE, ShopDiscountsTableMap::COL_DATE_START, ShopDiscountsTableMap::COL_DATE_STOP, ShopDiscountsTableMap::COL_DISCOUNT, ShopDiscountsTableMap::COL_USER_GROUP, ShopDiscountsTableMap::COL_MIN_PRICE, ShopDiscountsTableMap::COL_MAX_PRICE, ShopDiscountsTableMap::COL_CATEGORIES, ShopDiscountsTableMap::COL_PRODUCTS, ),
        self::TYPE_FIELDNAME     => array('id', 'name', 'description', 'active', 'date_start', 'date_stop', 'discount', 'user_group', 'min_price', 'max_price', 'categories', 'products', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'Name' => 1, 'Description' => 2, 'Active' => 3, 'DateStart' => 4, 'DateStop' => 5, 'Discount' => 6, 'UserGroup' => 7, 'MinPrice' => 8, 'MaxPrice' => 9, 'Categories' => 10, 'Products' => 11, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'name' => 1, 'description' => 2, 'active' => 3, 'dateStart' => 4, 'dateStop' => 5, 'discount' => 6, 'userGroup' => 7, 'minPrice' => 8, 'maxPrice' => 9, 'categories' => 10, 'products' => 11, ),
        self::TYPE_COLNAME       => array(ShopDiscountsTableMap::COL_ID => 0, ShopDiscountsTableMap::COL_NAME => 1, ShopDiscountsTableMap::COL_DESCRIPTION => 2, ShopDiscountsTableMap::COL_ACTIVE => 3, ShopDiscountsTableMap::COL_DATE_START => 4, ShopDiscountsTableMap::COL_DATE_STOP => 5, ShopDiscountsTableMap::COL_DISCOUNT => 6, ShopDiscountsTableMap::COL_USER_GROUP => 7, ShopDiscountsTableMap::COL_MIN_PRICE => 8, ShopDiscountsTableMap::COL_MAX_PRICE => 9, ShopDiscountsTableMap::COL_CATEGORIES => 10, ShopDiscountsTableMap::COL_PRODUCTS => 11, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'name' => 1, 'description' => 2, 'active' => 3, 'date_start' => 4, 'date_stop' => 5, 'discount' => 6, 'user_group' => 7, 'min_price' => 8, 'max_price' => 9, 'categories' => 10, 'products' => 11, ),
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
        $this->setName('shop_discounts');
        $this->setPhpName('ShopDiscounts');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\ShopDiscounts');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('name', 'Name', 'VARCHAR', true, 255, null);
        $this->addColumn('description', 'Description', 'LONGVARCHAR', false, null, null);
        $this->addColumn('active', 'Active', 'BOOLEAN', true, 1, null);
        $this->addColumn('date_start', 'DateStart', 'INTEGER', false, 11, null);
        $this->addColumn('date_stop', 'DateStop', 'INTEGER', false, 11, null);
        $this->addColumn('discount', 'Discount', 'VARCHAR', false, 11, null);
        $this->addColumn('user_group', 'UserGroup', 'VARCHAR', false, 255, null);
        $this->addColumn('min_price', 'MinPrice', 'FLOAT', false, null, null);
        $this->addColumn('max_price', 'MaxPrice', 'FLOAT', false, null, null);
        $this->addColumn('categories', 'Categories', 'LONGVARCHAR', false, null, null);
        $this->addColumn('products', 'Products', 'LONGVARCHAR', false, null, null);
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
        return $withPrefix ? ShopDiscountsTableMap::CLASS_DEFAULT : ShopDiscountsTableMap::OM_CLASS;
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
     * @return array           (ShopDiscounts object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = ShopDiscountsTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = ShopDiscountsTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + ShopDiscountsTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = ShopDiscountsTableMap::OM_CLASS;
            /** @var ShopDiscounts $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            ShopDiscountsTableMap::addInstanceToPool($obj, $key);
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
            $key = ShopDiscountsTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = ShopDiscountsTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var ShopDiscounts $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                ShopDiscountsTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(ShopDiscountsTableMap::COL_ID);
            $criteria->addSelectColumn(ShopDiscountsTableMap::COL_NAME);
            $criteria->addSelectColumn(ShopDiscountsTableMap::COL_DESCRIPTION);
            $criteria->addSelectColumn(ShopDiscountsTableMap::COL_ACTIVE);
            $criteria->addSelectColumn(ShopDiscountsTableMap::COL_DATE_START);
            $criteria->addSelectColumn(ShopDiscountsTableMap::COL_DATE_STOP);
            $criteria->addSelectColumn(ShopDiscountsTableMap::COL_DISCOUNT);
            $criteria->addSelectColumn(ShopDiscountsTableMap::COL_USER_GROUP);
            $criteria->addSelectColumn(ShopDiscountsTableMap::COL_MIN_PRICE);
            $criteria->addSelectColumn(ShopDiscountsTableMap::COL_MAX_PRICE);
            $criteria->addSelectColumn(ShopDiscountsTableMap::COL_CATEGORIES);
            $criteria->addSelectColumn(ShopDiscountsTableMap::COL_PRODUCTS);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.name');
            $criteria->addSelectColumn($alias . '.description');
            $criteria->addSelectColumn($alias . '.active');
            $criteria->addSelectColumn($alias . '.date_start');
            $criteria->addSelectColumn($alias . '.date_stop');
            $criteria->addSelectColumn($alias . '.discount');
            $criteria->addSelectColumn($alias . '.user_group');
            $criteria->addSelectColumn($alias . '.min_price');
            $criteria->addSelectColumn($alias . '.max_price');
            $criteria->addSelectColumn($alias . '.categories');
            $criteria->addSelectColumn($alias . '.products');
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
        return Propel::getServiceContainer()->getDatabaseMap(ShopDiscountsTableMap::DATABASE_NAME)->getTable(ShopDiscountsTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(ShopDiscountsTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(ShopDiscountsTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new ShopDiscountsTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a ShopDiscounts or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ShopDiscounts object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(ShopDiscountsTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \ShopDiscounts) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(ShopDiscountsTableMap::DATABASE_NAME);
            $criteria->add(ShopDiscountsTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = ShopDiscountsQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            ShopDiscountsTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                ShopDiscountsTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the shop_discounts table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return ShopDiscountsQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a ShopDiscounts or Criteria object.
     *
     * @param mixed               $criteria Criteria or ShopDiscounts object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ShopDiscountsTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from ShopDiscounts object
        }

        if ($criteria->containsKey(ShopDiscountsTableMap::COL_ID) && $criteria->keyContainsValue(ShopDiscountsTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.ShopDiscountsTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = ShopDiscountsQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // ShopDiscountsTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
ShopDiscountsTableMap::buildTableMap();
