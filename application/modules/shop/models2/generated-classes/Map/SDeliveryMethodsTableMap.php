<?php

namespace Map;

use \SDeliveryMethods;
use \SDeliveryMethodsQuery;
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
 * This class defines the structure of the 'shop_delivery_methods' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class SDeliveryMethodsTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.SDeliveryMethodsTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'Shop';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'shop_delivery_methods';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\SDeliveryMethods';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'SDeliveryMethods';

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
    const COL_ID = 'shop_delivery_methods.id';

    /**
     * the column name for the price field
     */
    const COL_PRICE = 'shop_delivery_methods.price';

    /**
     * the column name for the free_from field
     */
    const COL_FREE_FROM = 'shop_delivery_methods.free_from';

    /**
     * the column name for the enabled field
     */
    const COL_ENABLED = 'shop_delivery_methods.enabled';

    /**
     * the column name for the is_price_in_percent field
     */
    const COL_IS_PRICE_IN_PERCENT = 'shop_delivery_methods.is_price_in_percent';

    /**
     * the column name for the position field
     */
    const COL_POSITION = 'shop_delivery_methods.position';

    /**
     * the column name for the delivery_sum_specified field
     */
    const COL_DELIVERY_SUM_SPECIFIED = 'shop_delivery_methods.delivery_sum_specified';

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
        self::TYPE_PHPNAME       => array('Id', 'Price', 'FreeFrom', 'Enabled', 'IsPriceInPercent', 'Position', 'DeliverySumSpecified', ),
        self::TYPE_CAMELNAME     => array('id', 'price', 'freeFrom', 'enabled', 'isPriceInPercent', 'position', 'deliverySumSpecified', ),
        self::TYPE_COLNAME       => array(SDeliveryMethodsTableMap::COL_ID, SDeliveryMethodsTableMap::COL_PRICE, SDeliveryMethodsTableMap::COL_FREE_FROM, SDeliveryMethodsTableMap::COL_ENABLED, SDeliveryMethodsTableMap::COL_IS_PRICE_IN_PERCENT, SDeliveryMethodsTableMap::COL_POSITION, SDeliveryMethodsTableMap::COL_DELIVERY_SUM_SPECIFIED, ),
        self::TYPE_FIELDNAME     => array('id', 'price', 'free_from', 'enabled', 'is_price_in_percent', 'position', 'delivery_sum_specified', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'Price' => 1, 'FreeFrom' => 2, 'Enabled' => 3, 'IsPriceInPercent' => 4, 'Position' => 5, 'DeliverySumSpecified' => 6, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'price' => 1, 'freeFrom' => 2, 'enabled' => 3, 'isPriceInPercent' => 4, 'position' => 5, 'deliverySumSpecified' => 6, ),
        self::TYPE_COLNAME       => array(SDeliveryMethodsTableMap::COL_ID => 0, SDeliveryMethodsTableMap::COL_PRICE => 1, SDeliveryMethodsTableMap::COL_FREE_FROM => 2, SDeliveryMethodsTableMap::COL_ENABLED => 3, SDeliveryMethodsTableMap::COL_IS_PRICE_IN_PERCENT => 4, SDeliveryMethodsTableMap::COL_POSITION => 5, SDeliveryMethodsTableMap::COL_DELIVERY_SUM_SPECIFIED => 6, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'price' => 1, 'free_from' => 2, 'enabled' => 3, 'is_price_in_percent' => 4, 'position' => 5, 'delivery_sum_specified' => 6, ),
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
        $this->setName('shop_delivery_methods');
        $this->setPhpName('SDeliveryMethods');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\SDeliveryMethods');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('price', 'Price', 'FLOAT', true, null, null);
        $this->addColumn('free_from', 'FreeFrom', 'FLOAT', true, null, null);
        $this->addColumn('enabled', 'Enabled', 'BOOLEAN', false, 1, null);
        $this->addColumn('is_price_in_percent', 'IsPriceInPercent', 'BOOLEAN', true, 1, null);
        $this->addColumn('position', 'Position', 'INTEGER', false, 11, null);
        $this->addColumn('delivery_sum_specified', 'DeliverySumSpecified', 'BOOLEAN', false, 1, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('SDeliveryMethodsI18n', '\\SDeliveryMethodsI18n', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':id',
    1 => ':id',
  ),
), 'CASCADE', 'CASCADE', 'SDeliveryMethodsI18ns', false);
        $this->addRelation('ShopDeliveryMethodsSystems', '\\ShopDeliveryMethodsSystems', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':delivery_method_id',
    1 => ':id',
  ),
), 'CASCADE', null, 'ShopDeliveryMethodsSystemss', false);
        $this->addRelation('SOrders', '\\SOrders', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':delivery_method',
    1 => ':id',
  ),
), 'SET NULL', null, 'SOrderss', false);
        $this->addRelation('PaymentMethods', '\\SPaymentMethods', RelationMap::MANY_TO_MANY, array(), null, null, 'PaymentMethodss');
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
            'i18n' => array('i18n_table' => '%TABLE%_i18n', 'i18n_phpname' => '%PHPNAME%I18n', 'i18n_columns' => 'name, description, pricedescription', 'i18n_pk_column' => '', 'locale_column' => 'locale', 'locale_length' => '5', 'default_locale' => 'ru', 'locale_alias' => '', ),
        );
    } // getBehaviors()
    /**
     * Method to invalidate the instance pool of all tables related to shop_delivery_methods     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in related instance pools,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        SDeliveryMethodsI18nTableMap::clearInstancePool();
        ShopDeliveryMethodsSystemsTableMap::clearInstancePool();
        SOrdersTableMap::clearInstancePool();
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
        return $withPrefix ? SDeliveryMethodsTableMap::CLASS_DEFAULT : SDeliveryMethodsTableMap::OM_CLASS;
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
     * @return array           (SDeliveryMethods object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = SDeliveryMethodsTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = SDeliveryMethodsTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + SDeliveryMethodsTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = SDeliveryMethodsTableMap::OM_CLASS;
            /** @var SDeliveryMethods $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            SDeliveryMethodsTableMap::addInstanceToPool($obj, $key);
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
            $key = SDeliveryMethodsTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = SDeliveryMethodsTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var SDeliveryMethods $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                SDeliveryMethodsTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(SDeliveryMethodsTableMap::COL_ID);
            $criteria->addSelectColumn(SDeliveryMethodsTableMap::COL_PRICE);
            $criteria->addSelectColumn(SDeliveryMethodsTableMap::COL_FREE_FROM);
            $criteria->addSelectColumn(SDeliveryMethodsTableMap::COL_ENABLED);
            $criteria->addSelectColumn(SDeliveryMethodsTableMap::COL_IS_PRICE_IN_PERCENT);
            $criteria->addSelectColumn(SDeliveryMethodsTableMap::COL_POSITION);
            $criteria->addSelectColumn(SDeliveryMethodsTableMap::COL_DELIVERY_SUM_SPECIFIED);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.price');
            $criteria->addSelectColumn($alias . '.free_from');
            $criteria->addSelectColumn($alias . '.enabled');
            $criteria->addSelectColumn($alias . '.is_price_in_percent');
            $criteria->addSelectColumn($alias . '.position');
            $criteria->addSelectColumn($alias . '.delivery_sum_specified');
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
        return Propel::getServiceContainer()->getDatabaseMap(SDeliveryMethodsTableMap::DATABASE_NAME)->getTable(SDeliveryMethodsTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(SDeliveryMethodsTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(SDeliveryMethodsTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new SDeliveryMethodsTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a SDeliveryMethods or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or SDeliveryMethods object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(SDeliveryMethodsTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \SDeliveryMethods) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(SDeliveryMethodsTableMap::DATABASE_NAME);
            $criteria->add(SDeliveryMethodsTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = SDeliveryMethodsQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            SDeliveryMethodsTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                SDeliveryMethodsTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the shop_delivery_methods table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return SDeliveryMethodsQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a SDeliveryMethods or Criteria object.
     *
     * @param mixed               $criteria Criteria or SDeliveryMethods object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SDeliveryMethodsTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from SDeliveryMethods object
        }

        if ($criteria->containsKey(SDeliveryMethodsTableMap::COL_ID) && $criteria->keyContainsValue(SDeliveryMethodsTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.SDeliveryMethodsTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = SDeliveryMethodsQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // SDeliveryMethodsTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
SDeliveryMethodsTableMap::buildTableMap();
