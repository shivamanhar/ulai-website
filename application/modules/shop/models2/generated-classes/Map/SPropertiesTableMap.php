<?php

namespace Map;

use \SProperties;
use \SPropertiesQuery;
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
 * This class defines the structure of the 'shop_product_properties' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class SPropertiesTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.SPropertiesTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'Shop';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'shop_product_properties';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\SProperties';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'SProperties';

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
    const COL_ID = 'shop_product_properties.id';

    /**
     * the column name for the external_id field
     */
    const COL_EXTERNAL_ID = 'shop_product_properties.external_id';

    /**
     * the column name for the csv_name field
     */
    const COL_CSV_NAME = 'shop_product_properties.csv_name';

    /**
     * the column name for the multiple field
     */
    const COL_MULTIPLE = 'shop_product_properties.multiple';

    /**
     * the column name for the active field
     */
    const COL_ACTIVE = 'shop_product_properties.active';

    /**
     * the column name for the show_on_site field
     */
    const COL_SHOW_ON_SITE = 'shop_product_properties.show_on_site';

    /**
     * the column name for the show_in_compare field
     */
    const COL_SHOW_IN_COMPARE = 'shop_product_properties.show_in_compare';

    /**
     * the column name for the show_in_filter field
     */
    const COL_SHOW_IN_FILTER = 'shop_product_properties.show_in_filter';

    /**
     * the column name for the show_faq field
     */
    const COL_SHOW_FAQ = 'shop_product_properties.show_faq';

    /**
     * the column name for the main_property field
     */
    const COL_MAIN_PROPERTY = 'shop_product_properties.main_property';

    /**
     * the column name for the position field
     */
    const COL_POSITION = 'shop_product_properties.position';

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
        self::TYPE_PHPNAME       => array('Id', 'ExternalId', 'CsvName', 'Multiple', 'Active', 'ShowOnSite', 'ShowInCompare', 'ShowInFilter', 'ShowFaq', 'MainProperty', 'Position', ),
        self::TYPE_CAMELNAME     => array('id', 'externalId', 'csvName', 'multiple', 'active', 'showOnSite', 'showInCompare', 'showInFilter', 'showFaq', 'mainProperty', 'position', ),
        self::TYPE_COLNAME       => array(SPropertiesTableMap::COL_ID, SPropertiesTableMap::COL_EXTERNAL_ID, SPropertiesTableMap::COL_CSV_NAME, SPropertiesTableMap::COL_MULTIPLE, SPropertiesTableMap::COL_ACTIVE, SPropertiesTableMap::COL_SHOW_ON_SITE, SPropertiesTableMap::COL_SHOW_IN_COMPARE, SPropertiesTableMap::COL_SHOW_IN_FILTER, SPropertiesTableMap::COL_SHOW_FAQ, SPropertiesTableMap::COL_MAIN_PROPERTY, SPropertiesTableMap::COL_POSITION, ),
        self::TYPE_FIELDNAME     => array('id', 'external_id', 'csv_name', 'multiple', 'active', 'show_on_site', 'show_in_compare', 'show_in_filter', 'show_faq', 'main_property', 'position', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'ExternalId' => 1, 'CsvName' => 2, 'Multiple' => 3, 'Active' => 4, 'ShowOnSite' => 5, 'ShowInCompare' => 6, 'ShowInFilter' => 7, 'ShowFaq' => 8, 'MainProperty' => 9, 'Position' => 10, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'externalId' => 1, 'csvName' => 2, 'multiple' => 3, 'active' => 4, 'showOnSite' => 5, 'showInCompare' => 6, 'showInFilter' => 7, 'showFaq' => 8, 'mainProperty' => 9, 'position' => 10, ),
        self::TYPE_COLNAME       => array(SPropertiesTableMap::COL_ID => 0, SPropertiesTableMap::COL_EXTERNAL_ID => 1, SPropertiesTableMap::COL_CSV_NAME => 2, SPropertiesTableMap::COL_MULTIPLE => 3, SPropertiesTableMap::COL_ACTIVE => 4, SPropertiesTableMap::COL_SHOW_ON_SITE => 5, SPropertiesTableMap::COL_SHOW_IN_COMPARE => 6, SPropertiesTableMap::COL_SHOW_IN_FILTER => 7, SPropertiesTableMap::COL_SHOW_FAQ => 8, SPropertiesTableMap::COL_MAIN_PROPERTY => 9, SPropertiesTableMap::COL_POSITION => 10, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'external_id' => 1, 'csv_name' => 2, 'multiple' => 3, 'active' => 4, 'show_on_site' => 5, 'show_in_compare' => 6, 'show_in_filter' => 7, 'show_faq' => 8, 'main_property' => 9, 'position' => 10, ),
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
        $this->setName('shop_product_properties');
        $this->setPhpName('SProperties');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\SProperties');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('external_id', 'ExternalId', 'VARCHAR', false, 255, null);
        $this->addColumn('csv_name', 'CsvName', 'VARCHAR', true, 50, null);
        $this->addColumn('multiple', 'Multiple', 'BOOLEAN', false, 1, null);
        $this->addColumn('active', 'Active', 'BOOLEAN', false, 1, null);
        $this->addColumn('show_on_site', 'ShowOnSite', 'BOOLEAN', false, 1, null);
        $this->addColumn('show_in_compare', 'ShowInCompare', 'BOOLEAN', false, 1, null);
        $this->addColumn('show_in_filter', 'ShowInFilter', 'BOOLEAN', false, 1, null);
        $this->addColumn('show_faq', 'ShowFaq', 'BOOLEAN', false, 1, null);
        $this->addColumn('main_property', 'MainProperty', 'BOOLEAN', false, 1, null);
        $this->addColumn('position', 'Position', 'INTEGER', true, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('SPropertiesI18n', '\\SPropertiesI18n', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':id',
    1 => ':id',
  ),
), 'CASCADE', 'CASCADE', 'SPropertiesI18ns', false);
        $this->addRelation('ShopProductPropertiesCategories', '\\ShopProductPropertiesCategories', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':property_id',
    1 => ':id',
  ),
), 'CASCADE', null, 'ShopProductPropertiesCategoriess', false);
        $this->addRelation('SProductPropertiesData', '\\SProductPropertiesData', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':property_id',
    1 => ':id',
  ),
), 'CASCADE', null, 'SProductPropertiesDatas', false);
        $this->addRelation('PropertyCategory', '\\SCategory', RelationMap::MANY_TO_MANY, array(), 'CASCADE', null, 'PropertyCategories');
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
     * Method to invalidate the instance pool of all tables related to shop_product_properties     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in related instance pools,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        SPropertiesI18nTableMap::clearInstancePool();
        ShopProductPropertiesCategoriesTableMap::clearInstancePool();
        SProductPropertiesDataTableMap::clearInstancePool();
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
        return $withPrefix ? SPropertiesTableMap::CLASS_DEFAULT : SPropertiesTableMap::OM_CLASS;
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
     * @return array           (SProperties object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = SPropertiesTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = SPropertiesTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + SPropertiesTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = SPropertiesTableMap::OM_CLASS;
            /** @var SProperties $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            SPropertiesTableMap::addInstanceToPool($obj, $key);
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
            $key = SPropertiesTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = SPropertiesTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var SProperties $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                SPropertiesTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(SPropertiesTableMap::COL_ID);
            $criteria->addSelectColumn(SPropertiesTableMap::COL_EXTERNAL_ID);
            $criteria->addSelectColumn(SPropertiesTableMap::COL_CSV_NAME);
            $criteria->addSelectColumn(SPropertiesTableMap::COL_MULTIPLE);
            $criteria->addSelectColumn(SPropertiesTableMap::COL_ACTIVE);
            $criteria->addSelectColumn(SPropertiesTableMap::COL_SHOW_ON_SITE);
            $criteria->addSelectColumn(SPropertiesTableMap::COL_SHOW_IN_COMPARE);
            $criteria->addSelectColumn(SPropertiesTableMap::COL_SHOW_IN_FILTER);
            $criteria->addSelectColumn(SPropertiesTableMap::COL_SHOW_FAQ);
            $criteria->addSelectColumn(SPropertiesTableMap::COL_MAIN_PROPERTY);
            $criteria->addSelectColumn(SPropertiesTableMap::COL_POSITION);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.external_id');
            $criteria->addSelectColumn($alias . '.csv_name');
            $criteria->addSelectColumn($alias . '.multiple');
            $criteria->addSelectColumn($alias . '.active');
            $criteria->addSelectColumn($alias . '.show_on_site');
            $criteria->addSelectColumn($alias . '.show_in_compare');
            $criteria->addSelectColumn($alias . '.show_in_filter');
            $criteria->addSelectColumn($alias . '.show_faq');
            $criteria->addSelectColumn($alias . '.main_property');
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
        return Propel::getServiceContainer()->getDatabaseMap(SPropertiesTableMap::DATABASE_NAME)->getTable(SPropertiesTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(SPropertiesTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(SPropertiesTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new SPropertiesTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a SProperties or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or SProperties object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(SPropertiesTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \SProperties) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(SPropertiesTableMap::DATABASE_NAME);
            $criteria->add(SPropertiesTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = SPropertiesQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            SPropertiesTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                SPropertiesTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the shop_product_properties table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return SPropertiesQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a SProperties or Criteria object.
     *
     * @param mixed               $criteria Criteria or SProperties object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SPropertiesTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from SProperties object
        }

        if ($criteria->containsKey(SPropertiesTableMap::COL_ID) && $criteria->keyContainsValue(SPropertiesTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.SPropertiesTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = SPropertiesQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // SPropertiesTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
SPropertiesTableMap::buildTableMap();
