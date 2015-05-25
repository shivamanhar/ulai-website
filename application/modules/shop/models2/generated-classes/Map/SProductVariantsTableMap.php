<?php

namespace Map;

use \SProductVariants;
use \SProductVariantsQuery;
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
 * This class defines the structure of the 'shop_product_variants' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class SProductVariantsTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.SProductVariantsTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'Shop';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'shop_product_variants';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\SProductVariants';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'SProductVariants';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 10;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 10;

    /**
     * the column name for the id field
     */
    const COL_ID = 'shop_product_variants.id';

    /**
     * the column name for the external_id field
     */
    const COL_EXTERNAL_ID = 'shop_product_variants.external_id';

    /**
     * the column name for the product_id field
     */
    const COL_PRODUCT_ID = 'shop_product_variants.product_id';

    /**
     * the column name for the price field
     */
    const COL_PRICE = 'shop_product_variants.price';

    /**
     * the column name for the number field
     */
    const COL_NUMBER = 'shop_product_variants.number';

    /**
     * the column name for the stock field
     */
    const COL_STOCK = 'shop_product_variants.stock';

    /**
     * the column name for the mainImage field
     */
    const COL_MAINIMAGE = 'shop_product_variants.mainImage';

    /**
     * the column name for the position field
     */
    const COL_POSITION = 'shop_product_variants.position';

    /**
     * the column name for the currency field
     */
    const COL_CURRENCY = 'shop_product_variants.currency';

    /**
     * the column name for the price_in_main field
     */
    const COL_PRICE_IN_MAIN = 'shop_product_variants.price_in_main';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    // i18n behavior

    /**
     * The default locale to use for translations.
     *
     * @var string
     */
    const DEFAULT_LOCALE = 'ru';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('Id', 'ExternalId', 'ProductId', 'Price', 'Number', 'Stock', 'Mainimage', 'Position', 'Currency', 'PriceInMain', ),
        self::TYPE_CAMELNAME     => array('id', 'externalId', 'productId', 'price', 'number', 'stock', 'mainimage', 'position', 'currency', 'priceInMain', ),
        self::TYPE_COLNAME       => array(SProductVariantsTableMap::COL_ID, SProductVariantsTableMap::COL_EXTERNAL_ID, SProductVariantsTableMap::COL_PRODUCT_ID, SProductVariantsTableMap::COL_PRICE, SProductVariantsTableMap::COL_NUMBER, SProductVariantsTableMap::COL_STOCK, SProductVariantsTableMap::COL_MAINIMAGE, SProductVariantsTableMap::COL_POSITION, SProductVariantsTableMap::COL_CURRENCY, SProductVariantsTableMap::COL_PRICE_IN_MAIN, ),
        self::TYPE_FIELDNAME     => array('id', 'external_id', 'product_id', 'price', 'number', 'stock', 'mainImage', 'position', 'currency', 'price_in_main', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'ExternalId' => 1, 'ProductId' => 2, 'Price' => 3, 'Number' => 4, 'Stock' => 5, 'Mainimage' => 6, 'Position' => 7, 'Currency' => 8, 'PriceInMain' => 9, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'externalId' => 1, 'productId' => 2, 'price' => 3, 'number' => 4, 'stock' => 5, 'mainimage' => 6, 'position' => 7, 'currency' => 8, 'priceInMain' => 9, ),
        self::TYPE_COLNAME       => array(SProductVariantsTableMap::COL_ID => 0, SProductVariantsTableMap::COL_EXTERNAL_ID => 1, SProductVariantsTableMap::COL_PRODUCT_ID => 2, SProductVariantsTableMap::COL_PRICE => 3, SProductVariantsTableMap::COL_NUMBER => 4, SProductVariantsTableMap::COL_STOCK => 5, SProductVariantsTableMap::COL_MAINIMAGE => 6, SProductVariantsTableMap::COL_POSITION => 7, SProductVariantsTableMap::COL_CURRENCY => 8, SProductVariantsTableMap::COL_PRICE_IN_MAIN => 9, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'external_id' => 1, 'product_id' => 2, 'price' => 3, 'number' => 4, 'stock' => 5, 'mainImage' => 6, 'position' => 7, 'currency' => 8, 'price_in_main' => 9, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, )
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
        $this->setName('shop_product_variants');
        $this->setPhpName('SProductVariants');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\SProductVariants');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('external_id', 'ExternalId', 'VARCHAR', false, 255, null);
        $this->addForeignKey('product_id', 'ProductId', 'INTEGER', 'shop_products', 'id', true, null, null);
        $this->addColumn('price', 'Price', 'FLOAT', true, null, null);
        $this->addColumn('number', 'Number', 'VARCHAR', false, 255, null);
        $this->addColumn('stock', 'Stock', 'INTEGER', false, null, null);
        $this->addColumn('mainImage', 'Mainimage', 'VARCHAR', false, 255, null);
        $this->addColumn('position', 'Position', 'INTEGER', false, null, null);
        $this->addForeignKey('currency', 'Currency', 'INTEGER', 'shop_currencies', 'id', false, null, null);
        $this->addColumn('price_in_main', 'PriceInMain', 'FLOAT', true, null, null);
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
), 'CASCADE', 'CASCADE', null, false);
        $this->addRelation('SCurrencies', '\\SCurrencies', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':currency',
    1 => ':id',
  ),
), 'CASCADE', 'CASCADE', null, false);
        $this->addRelation('ShopKitProduct', '\\ShopKitProduct', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':product_id',
    1 => ':product_id',
  ),
), 'CASCADE', 'CASCADE', 'ShopKitProducts', false);
        $this->addRelation('SProductVariantsI18n', '\\SProductVariantsI18n', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':id',
    1 => ':id',
  ),
), 'CASCADE', 'CASCADE', 'SProductVariantsI18ns', false);
        $this->addRelation('SNotifications', '\\SNotifications', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':variant_id',
    1 => ':id',
  ),
), null, null, 'SNotificationss', false);
        $this->addRelation('SOrderProducts', '\\SOrderProducts', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':variant_id',
    1 => ':id',
  ),
), null, null, 'SOrderProductss', false);
    } // buildRelations()

    /**
     *
     * Gets the list of behaviors registered for this table
     *
     * @return array Associative array (name => parameters) of behaviors
     */
    public function getBehaviors()
    {
        return array(
            'i18n' => array('i18n_table' => '%TABLE%_i18n', 'i18n_phpname' => '%PHPNAME%I18n', 'i18n_columns' => 'name', 'i18n_pk_column' => '', 'locale_column' => 'locale', 'locale_length' => '5', 'default_locale' => 'ru', 'locale_alias' => '', ),
        );
    } // getBehaviors()
    /**
     * Method to invalidate the instance pool of all tables related to shop_product_variants     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in related instance pools,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        ShopKitProductTableMap::clearInstancePool();
        SProductVariantsI18nTableMap::clearInstancePool();
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
        return $withPrefix ? SProductVariantsTableMap::CLASS_DEFAULT : SProductVariantsTableMap::OM_CLASS;
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
     * @return array           (SProductVariants object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = SProductVariantsTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = SProductVariantsTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + SProductVariantsTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = SProductVariantsTableMap::OM_CLASS;
            /** @var SProductVariants $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            SProductVariantsTableMap::addInstanceToPool($obj, $key);
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
            $key = SProductVariantsTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = SProductVariantsTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var SProductVariants $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                SProductVariantsTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(SProductVariantsTableMap::COL_ID);
            $criteria->addSelectColumn(SProductVariantsTableMap::COL_EXTERNAL_ID);
            $criteria->addSelectColumn(SProductVariantsTableMap::COL_PRODUCT_ID);
            $criteria->addSelectColumn(SProductVariantsTableMap::COL_PRICE);
            $criteria->addSelectColumn(SProductVariantsTableMap::COL_NUMBER);
            $criteria->addSelectColumn(SProductVariantsTableMap::COL_STOCK);
            $criteria->addSelectColumn(SProductVariantsTableMap::COL_MAINIMAGE);
            $criteria->addSelectColumn(SProductVariantsTableMap::COL_POSITION);
            $criteria->addSelectColumn(SProductVariantsTableMap::COL_CURRENCY);
            $criteria->addSelectColumn(SProductVariantsTableMap::COL_PRICE_IN_MAIN);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.external_id');
            $criteria->addSelectColumn($alias . '.product_id');
            $criteria->addSelectColumn($alias . '.price');
            $criteria->addSelectColumn($alias . '.number');
            $criteria->addSelectColumn($alias . '.stock');
            $criteria->addSelectColumn($alias . '.mainImage');
            $criteria->addSelectColumn($alias . '.position');
            $criteria->addSelectColumn($alias . '.currency');
            $criteria->addSelectColumn($alias . '.price_in_main');
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
        return Propel::getServiceContainer()->getDatabaseMap(SProductVariantsTableMap::DATABASE_NAME)->getTable(SProductVariantsTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(SProductVariantsTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(SProductVariantsTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new SProductVariantsTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a SProductVariants or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or SProductVariants object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(SProductVariantsTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \SProductVariants) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(SProductVariantsTableMap::DATABASE_NAME);
            $criteria->add(SProductVariantsTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = SProductVariantsQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            SProductVariantsTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                SProductVariantsTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the shop_product_variants table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return SProductVariantsQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a SProductVariants or Criteria object.
     *
     * @param mixed               $criteria Criteria or SProductVariants object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SProductVariantsTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from SProductVariants object
        }

        if ($criteria->containsKey(SProductVariantsTableMap::COL_ID) && $criteria->keyContainsValue(SProductVariantsTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.SProductVariantsTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = SProductVariantsQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // SProductVariantsTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
SProductVariantsTableMap::buildTableMap();
