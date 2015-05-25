<?php

namespace Map;

use \SPaymentMethods;
use \SPaymentMethodsQuery;
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
 * This class defines the structure of the 'shop_payment_methods' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class SPaymentMethodsTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.SPaymentMethodsTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'Shop';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'shop_payment_methods';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\SPaymentMethods';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'SPaymentMethods';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 5;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 5;

    /**
     * the column name for the id field
     */
    const COL_ID = 'shop_payment_methods.id';

    /**
     * the column name for the active field
     */
    const COL_ACTIVE = 'shop_payment_methods.active';

    /**
     * the column name for the currency_id field
     */
    const COL_CURRENCY_ID = 'shop_payment_methods.currency_id';

    /**
     * the column name for the payment_system_name field
     */
    const COL_PAYMENT_SYSTEM_NAME = 'shop_payment_methods.payment_system_name';

    /**
     * the column name for the position field
     */
    const COL_POSITION = 'shop_payment_methods.position';

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
        self::TYPE_PHPNAME       => array('Id', 'Active', 'CurrencyId', 'PaymentSystemName', 'Position', ),
        self::TYPE_CAMELNAME     => array('id', 'active', 'currencyId', 'paymentSystemName', 'position', ),
        self::TYPE_COLNAME       => array(SPaymentMethodsTableMap::COL_ID, SPaymentMethodsTableMap::COL_ACTIVE, SPaymentMethodsTableMap::COL_CURRENCY_ID, SPaymentMethodsTableMap::COL_PAYMENT_SYSTEM_NAME, SPaymentMethodsTableMap::COL_POSITION, ),
        self::TYPE_FIELDNAME     => array('id', 'active', 'currency_id', 'payment_system_name', 'position', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'Active' => 1, 'CurrencyId' => 2, 'PaymentSystemName' => 3, 'Position' => 4, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'active' => 1, 'currencyId' => 2, 'paymentSystemName' => 3, 'position' => 4, ),
        self::TYPE_COLNAME       => array(SPaymentMethodsTableMap::COL_ID => 0, SPaymentMethodsTableMap::COL_ACTIVE => 1, SPaymentMethodsTableMap::COL_CURRENCY_ID => 2, SPaymentMethodsTableMap::COL_PAYMENT_SYSTEM_NAME => 3, SPaymentMethodsTableMap::COL_POSITION => 4, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'active' => 1, 'currency_id' => 2, 'payment_system_name' => 3, 'position' => 4, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, )
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
        $this->setName('shop_payment_methods');
        $this->setPhpName('SPaymentMethods');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\SPaymentMethods');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('active', 'Active', 'BOOLEAN', false, 1, null);
        $this->addForeignKey('currency_id', 'CurrencyId', 'INTEGER', 'shop_currencies', 'id', false, 11, null);
        $this->addColumn('payment_system_name', 'PaymentSystemName', 'VARCHAR', false, 255, null);
        $this->addColumn('position', 'Position', 'INTEGER', false, 11, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Currency', '\\SCurrencies', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':currency_id',
    1 => ':id',
  ),
), null, null, null, false);
        $this->addRelation('ShopDeliveryMethodsSystems', '\\ShopDeliveryMethodsSystems', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':payment_method_id',
    1 => ':id',
  ),
), null, null, 'ShopDeliveryMethodsSystemss', false);
        $this->addRelation('SOrders', '\\SOrders', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':payment_method',
    1 => ':id',
  ),
), 'SET NULL', null, 'SOrderss', false);
        $this->addRelation('SPaymentMethodsI18n', '\\SPaymentMethodsI18n', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':id',
    1 => ':id',
  ),
), 'CASCADE', 'CASCADE', 'SPaymentMethodsI18ns', false);
        $this->addRelation('SDeliveryMethods', '\\SDeliveryMethods', RelationMap::MANY_TO_MANY, array(), 'CASCADE', null, 'SDeliveryMethodss');
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
            'i18n' => array('i18n_table' => '%TABLE%_i18n', 'i18n_phpname' => '%PHPNAME%I18n', 'i18n_columns' => 'name, description', 'i18n_pk_column' => '', 'locale_column' => 'locale', 'locale_length' => '5', 'default_locale' => 'ru', 'locale_alias' => '', ),
        );
    } // getBehaviors()
    /**
     * Method to invalidate the instance pool of all tables related to shop_payment_methods     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in related instance pools,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        SOrdersTableMap::clearInstancePool();
        SPaymentMethodsI18nTableMap::clearInstancePool();
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
        return $withPrefix ? SPaymentMethodsTableMap::CLASS_DEFAULT : SPaymentMethodsTableMap::OM_CLASS;
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
     * @return array           (SPaymentMethods object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = SPaymentMethodsTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = SPaymentMethodsTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + SPaymentMethodsTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = SPaymentMethodsTableMap::OM_CLASS;
            /** @var SPaymentMethods $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            SPaymentMethodsTableMap::addInstanceToPool($obj, $key);
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
            $key = SPaymentMethodsTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = SPaymentMethodsTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var SPaymentMethods $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                SPaymentMethodsTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(SPaymentMethodsTableMap::COL_ID);
            $criteria->addSelectColumn(SPaymentMethodsTableMap::COL_ACTIVE);
            $criteria->addSelectColumn(SPaymentMethodsTableMap::COL_CURRENCY_ID);
            $criteria->addSelectColumn(SPaymentMethodsTableMap::COL_PAYMENT_SYSTEM_NAME);
            $criteria->addSelectColumn(SPaymentMethodsTableMap::COL_POSITION);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.active');
            $criteria->addSelectColumn($alias . '.currency_id');
            $criteria->addSelectColumn($alias . '.payment_system_name');
            $criteria->addSelectColumn($alias . '.position');
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
        return Propel::getServiceContainer()->getDatabaseMap(SPaymentMethodsTableMap::DATABASE_NAME)->getTable(SPaymentMethodsTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(SPaymentMethodsTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(SPaymentMethodsTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new SPaymentMethodsTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a SPaymentMethods or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or SPaymentMethods object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(SPaymentMethodsTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \SPaymentMethods) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(SPaymentMethodsTableMap::DATABASE_NAME);
            $criteria->add(SPaymentMethodsTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = SPaymentMethodsQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            SPaymentMethodsTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                SPaymentMethodsTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the shop_payment_methods table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return SPaymentMethodsQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a SPaymentMethods or Criteria object.
     *
     * @param mixed               $criteria Criteria or SPaymentMethods object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SPaymentMethodsTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from SPaymentMethods object
        }

        if ($criteria->containsKey(SPaymentMethodsTableMap::COL_ID) && $criteria->keyContainsValue(SPaymentMethodsTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.SPaymentMethodsTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = SPaymentMethodsQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // SPaymentMethodsTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
SPaymentMethodsTableMap::buildTableMap();
