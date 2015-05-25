<?php

namespace Map;

use \SOrderProducts;
use \SOrderProductsQuery;
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
 * This class defines the structure of the 'shop_orders_products' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class SOrderProductsTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.SOrderProductsTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'Shop';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'shop_orders_products';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\SOrderProducts';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'SOrderProducts';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 11;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 11;

    /**
     * the column name for the id field
     */
    const COL_ID = 'shop_orders_products.id';

    /**
     * the column name for the order_id field
     */
    const COL_ORDER_ID = 'shop_orders_products.order_id';

    /**
     * the column name for the kit_id field
     */
    const COL_KIT_ID = 'shop_orders_products.kit_id';

    /**
     * the column name for the is_main field
     */
    const COL_IS_MAIN = 'shop_orders_products.is_main';

    /**
     * the column name for the product_id field
     */
    const COL_PRODUCT_ID = 'shop_orders_products.product_id';

    /**
     * the column name for the variant_id field
     */
    const COL_VARIANT_ID = 'shop_orders_products.variant_id';

    /**
     * the column name for the product_name field
     */
    const COL_PRODUCT_NAME = 'shop_orders_products.product_name';

    /**
     * the column name for the variant_name field
     */
    const COL_VARIANT_NAME = 'shop_orders_products.variant_name';

    /**
     * the column name for the price field
     */
    const COL_PRICE = 'shop_orders_products.price';

    /**
     * the column name for the origin_price field
     */
    const COL_ORIGIN_PRICE = 'shop_orders_products.origin_price';

    /**
     * the column name for the quantity field
     */
    const COL_QUANTITY = 'shop_orders_products.quantity';

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
        self::TYPE_PHPNAME       => array('Id', 'OrderId', 'KitId', 'IsMain', 'ProductId', 'VariantId', 'ProductName', 'VariantName', 'Price', 'OriginPrice', 'Quantity', ),
        self::TYPE_CAMELNAME     => array('id', 'orderId', 'kitId', 'isMain', 'productId', 'variantId', 'productName', 'variantName', 'price', 'originPrice', 'quantity', ),
        self::TYPE_COLNAME       => array(SOrderProductsTableMap::COL_ID, SOrderProductsTableMap::COL_ORDER_ID, SOrderProductsTableMap::COL_KIT_ID, SOrderProductsTableMap::COL_IS_MAIN, SOrderProductsTableMap::COL_PRODUCT_ID, SOrderProductsTableMap::COL_VARIANT_ID, SOrderProductsTableMap::COL_PRODUCT_NAME, SOrderProductsTableMap::COL_VARIANT_NAME, SOrderProductsTableMap::COL_PRICE, SOrderProductsTableMap::COL_ORIGIN_PRICE, SOrderProductsTableMap::COL_QUANTITY, ),
        self::TYPE_FIELDNAME     => array('id', 'order_id', 'kit_id', 'is_main', 'product_id', 'variant_id', 'product_name', 'variant_name', 'price', 'origin_price', 'quantity', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'OrderId' => 1, 'KitId' => 2, 'IsMain' => 3, 'ProductId' => 4, 'VariantId' => 5, 'ProductName' => 6, 'VariantName' => 7, 'Price' => 8, 'OriginPrice' => 9, 'Quantity' => 10, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'orderId' => 1, 'kitId' => 2, 'isMain' => 3, 'productId' => 4, 'variantId' => 5, 'productName' => 6, 'variantName' => 7, 'price' => 8, 'originPrice' => 9, 'quantity' => 10, ),
        self::TYPE_COLNAME       => array(SOrderProductsTableMap::COL_ID => 0, SOrderProductsTableMap::COL_ORDER_ID => 1, SOrderProductsTableMap::COL_KIT_ID => 2, SOrderProductsTableMap::COL_IS_MAIN => 3, SOrderProductsTableMap::COL_PRODUCT_ID => 4, SOrderProductsTableMap::COL_VARIANT_ID => 5, SOrderProductsTableMap::COL_PRODUCT_NAME => 6, SOrderProductsTableMap::COL_VARIANT_NAME => 7, SOrderProductsTableMap::COL_PRICE => 8, SOrderProductsTableMap::COL_ORIGIN_PRICE => 9, SOrderProductsTableMap::COL_QUANTITY => 10, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'order_id' => 1, 'kit_id' => 2, 'is_main' => 3, 'product_id' => 4, 'variant_id' => 5, 'product_name' => 6, 'variant_name' => 7, 'price' => 8, 'origin_price' => 9, 'quantity' => 10, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, )
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
        $this->setName('shop_orders_products');
        $this->setPhpName('SOrderProducts');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\SOrderProducts');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('order_id', 'OrderId', 'INTEGER', 'shop_orders', 'id', true, null, null);
        $this->addColumn('kit_id', 'KitId', 'INTEGER', false, null, null);
        $this->addColumn('is_main', 'IsMain', 'BOOLEAN', false, 1, null);
        $this->addForeignKey('product_id', 'ProductId', 'INTEGER', 'shop_products', 'id', true, null, null);
        $this->addForeignKey('variant_id', 'VariantId', 'INTEGER', 'shop_product_variants', 'id', true, null, null);
        $this->addColumn('product_name', 'ProductName', 'VARCHAR', false, 255, null);
        $this->addColumn('variant_name', 'VariantName', 'VARCHAR', false, 255, null);
        $this->addColumn('price', 'Price', 'DOUBLE', false, null, null);
        $this->addColumn('origin_price', 'OriginPrice', 'DOUBLE', false, null, null);
        $this->addColumn('quantity', 'Quantity', 'INTEGER', false, null, null);
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
        $this->addRelation('SOrders', '\\SOrders', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':order_id',
    1 => ':id',
  ),
), 'CASCADE', null, null, false);
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
        return $withPrefix ? SOrderProductsTableMap::CLASS_DEFAULT : SOrderProductsTableMap::OM_CLASS;
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
     * @return array           (SOrderProducts object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = SOrderProductsTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = SOrderProductsTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + SOrderProductsTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = SOrderProductsTableMap::OM_CLASS;
            /** @var SOrderProducts $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            SOrderProductsTableMap::addInstanceToPool($obj, $key);
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
            $key = SOrderProductsTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = SOrderProductsTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var SOrderProducts $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                SOrderProductsTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(SOrderProductsTableMap::COL_ID);
            $criteria->addSelectColumn(SOrderProductsTableMap::COL_ORDER_ID);
            $criteria->addSelectColumn(SOrderProductsTableMap::COL_KIT_ID);
            $criteria->addSelectColumn(SOrderProductsTableMap::COL_IS_MAIN);
            $criteria->addSelectColumn(SOrderProductsTableMap::COL_PRODUCT_ID);
            $criteria->addSelectColumn(SOrderProductsTableMap::COL_VARIANT_ID);
            $criteria->addSelectColumn(SOrderProductsTableMap::COL_PRODUCT_NAME);
            $criteria->addSelectColumn(SOrderProductsTableMap::COL_VARIANT_NAME);
            $criteria->addSelectColumn(SOrderProductsTableMap::COL_PRICE);
            $criteria->addSelectColumn(SOrderProductsTableMap::COL_ORIGIN_PRICE);
            $criteria->addSelectColumn(SOrderProductsTableMap::COL_QUANTITY);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.order_id');
            $criteria->addSelectColumn($alias . '.kit_id');
            $criteria->addSelectColumn($alias . '.is_main');
            $criteria->addSelectColumn($alias . '.product_id');
            $criteria->addSelectColumn($alias . '.variant_id');
            $criteria->addSelectColumn($alias . '.product_name');
            $criteria->addSelectColumn($alias . '.variant_name');
            $criteria->addSelectColumn($alias . '.price');
            $criteria->addSelectColumn($alias . '.origin_price');
            $criteria->addSelectColumn($alias . '.quantity');
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
        return Propel::getServiceContainer()->getDatabaseMap(SOrderProductsTableMap::DATABASE_NAME)->getTable(SOrderProductsTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(SOrderProductsTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(SOrderProductsTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new SOrderProductsTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a SOrderProducts or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or SOrderProducts object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(SOrderProductsTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \SOrderProducts) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(SOrderProductsTableMap::DATABASE_NAME);
            $criteria->add(SOrderProductsTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = SOrderProductsQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            SOrderProductsTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                SOrderProductsTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the shop_orders_products table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return SOrderProductsQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a SOrderProducts or Criteria object.
     *
     * @param mixed               $criteria Criteria or SOrderProducts object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SOrderProductsTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from SOrderProducts object
        }

        if ($criteria->containsKey(SOrderProductsTableMap::COL_ID) && $criteria->keyContainsValue(SOrderProductsTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.SOrderProductsTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = SOrderProductsQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // SOrderProductsTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
SOrderProductsTableMap::buildTableMap();
