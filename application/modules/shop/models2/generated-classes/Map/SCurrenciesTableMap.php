<?php

namespace Map;

use \SCurrencies;
use \SCurrenciesQuery;
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
 * This class defines the structure of the 'shop_currencies' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class SCurrenciesTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.SCurrenciesTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'Shop';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'shop_currencies';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\SCurrencies';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'SCurrencies';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 9;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 9;

    /**
     * the column name for the id field
     */
    const COL_ID = 'shop_currencies.id';

    /**
     * the column name for the name field
     */
    const COL_NAME = 'shop_currencies.name';

    /**
     * the column name for the main field
     */
    const COL_MAIN = 'shop_currencies.main';

    /**
     * the column name for the is_default field
     */
    const COL_IS_DEFAULT = 'shop_currencies.is_default';

    /**
     * the column name for the code field
     */
    const COL_CODE = 'shop_currencies.code';

    /**
     * the column name for the symbol field
     */
    const COL_SYMBOL = 'shop_currencies.symbol';

    /**
     * the column name for the rate field
     */
    const COL_RATE = 'shop_currencies.rate';

    /**
     * the column name for the showOnSite field
     */
    const COL_SHOWONSITE = 'shop_currencies.showOnSite';

    /**
     * the column name for the currency_template field
     */
    const COL_CURRENCY_TEMPLATE = 'shop_currencies.currency_template';

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
        self::TYPE_PHPNAME       => array('Id', 'Name', 'Main', 'IsDefault', 'Code', 'Symbol', 'Rate', 'Showonsite', 'CurrencyTemplate', ),
        self::TYPE_CAMELNAME     => array('id', 'name', 'main', 'isDefault', 'code', 'symbol', 'rate', 'showonsite', 'currencyTemplate', ),
        self::TYPE_COLNAME       => array(SCurrenciesTableMap::COL_ID, SCurrenciesTableMap::COL_NAME, SCurrenciesTableMap::COL_MAIN, SCurrenciesTableMap::COL_IS_DEFAULT, SCurrenciesTableMap::COL_CODE, SCurrenciesTableMap::COL_SYMBOL, SCurrenciesTableMap::COL_RATE, SCurrenciesTableMap::COL_SHOWONSITE, SCurrenciesTableMap::COL_CURRENCY_TEMPLATE, ),
        self::TYPE_FIELDNAME     => array('id', 'name', 'main', 'is_default', 'code', 'symbol', 'rate', 'showOnSite', 'currency_template', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'Name' => 1, 'Main' => 2, 'IsDefault' => 3, 'Code' => 4, 'Symbol' => 5, 'Rate' => 6, 'Showonsite' => 7, 'CurrencyTemplate' => 8, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'name' => 1, 'main' => 2, 'isDefault' => 3, 'code' => 4, 'symbol' => 5, 'rate' => 6, 'showonsite' => 7, 'currencyTemplate' => 8, ),
        self::TYPE_COLNAME       => array(SCurrenciesTableMap::COL_ID => 0, SCurrenciesTableMap::COL_NAME => 1, SCurrenciesTableMap::COL_MAIN => 2, SCurrenciesTableMap::COL_IS_DEFAULT => 3, SCurrenciesTableMap::COL_CODE => 4, SCurrenciesTableMap::COL_SYMBOL => 5, SCurrenciesTableMap::COL_RATE => 6, SCurrenciesTableMap::COL_SHOWONSITE => 7, SCurrenciesTableMap::COL_CURRENCY_TEMPLATE => 8, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'name' => 1, 'main' => 2, 'is_default' => 3, 'code' => 4, 'symbol' => 5, 'rate' => 6, 'showOnSite' => 7, 'currency_template' => 8, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, )
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
        $this->setName('shop_currencies');
        $this->setPhpName('SCurrencies');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\SCurrencies');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('name', 'Name', 'VARCHAR', false, 255, null);
        $this->addColumn('main', 'Main', 'BOOLEAN', false, 1, null);
        $this->addColumn('is_default', 'IsDefault', 'BOOLEAN', false, 1, null);
        $this->addColumn('code', 'Code', 'VARCHAR', false, 5, null);
        $this->addColumn('symbol', 'Symbol', 'VARCHAR', false, 5, null);
        $this->addColumn('rate', 'Rate', 'FLOAT', false, null, 1);
        $this->addColumn('showOnSite', 'Showonsite', 'INTEGER', false, null, 0);
        $this->addColumn('currency_template', 'CurrencyTemplate', 'VARCHAR', false, 500, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Currency', '\\SProductVariants', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':currency',
    1 => ':id',
  ),
), 'CASCADE', 'CASCADE', 'Currencies', false);
        $this->addRelation('SPaymentMethods', '\\SPaymentMethods', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':currency_id',
    1 => ':id',
  ),
), null, null, 'SPaymentMethodss', false);
    } // buildRelations()
    /**
     * Method to invalidate the instance pool of all tables related to shop_currencies     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in related instance pools,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        SProductVariantsTableMap::clearInstancePool();
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
        return $withPrefix ? SCurrenciesTableMap::CLASS_DEFAULT : SCurrenciesTableMap::OM_CLASS;
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
     * @return array           (SCurrencies object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = SCurrenciesTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = SCurrenciesTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + SCurrenciesTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = SCurrenciesTableMap::OM_CLASS;
            /** @var SCurrencies $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            SCurrenciesTableMap::addInstanceToPool($obj, $key);
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
            $key = SCurrenciesTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = SCurrenciesTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var SCurrencies $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                SCurrenciesTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(SCurrenciesTableMap::COL_ID);
            $criteria->addSelectColumn(SCurrenciesTableMap::COL_NAME);
            $criteria->addSelectColumn(SCurrenciesTableMap::COL_MAIN);
            $criteria->addSelectColumn(SCurrenciesTableMap::COL_IS_DEFAULT);
            $criteria->addSelectColumn(SCurrenciesTableMap::COL_CODE);
            $criteria->addSelectColumn(SCurrenciesTableMap::COL_SYMBOL);
            $criteria->addSelectColumn(SCurrenciesTableMap::COL_RATE);
            $criteria->addSelectColumn(SCurrenciesTableMap::COL_SHOWONSITE);
            $criteria->addSelectColumn(SCurrenciesTableMap::COL_CURRENCY_TEMPLATE);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.name');
            $criteria->addSelectColumn($alias . '.main');
            $criteria->addSelectColumn($alias . '.is_default');
            $criteria->addSelectColumn($alias . '.code');
            $criteria->addSelectColumn($alias . '.symbol');
            $criteria->addSelectColumn($alias . '.rate');
            $criteria->addSelectColumn($alias . '.showOnSite');
            $criteria->addSelectColumn($alias . '.currency_template');
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
        return Propel::getServiceContainer()->getDatabaseMap(SCurrenciesTableMap::DATABASE_NAME)->getTable(SCurrenciesTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(SCurrenciesTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(SCurrenciesTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new SCurrenciesTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a SCurrencies or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or SCurrencies object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(SCurrenciesTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \SCurrencies) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(SCurrenciesTableMap::DATABASE_NAME);
            $criteria->add(SCurrenciesTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = SCurrenciesQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            SCurrenciesTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                SCurrenciesTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the shop_currencies table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return SCurrenciesQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a SCurrencies or Criteria object.
     *
     * @param mixed               $criteria Criteria or SCurrencies object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SCurrenciesTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from SCurrencies object
        }

        if ($criteria->containsKey(SCurrenciesTableMap::COL_ID) && $criteria->keyContainsValue(SCurrenciesTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.SCurrenciesTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = SCurrenciesQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // SCurrenciesTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
SCurrenciesTableMap::buildTableMap();
