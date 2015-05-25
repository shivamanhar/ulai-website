<?php

namespace Map;

use \SCategory;
use \SCategoryQuery;
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
 * This class defines the structure of the 'shop_category' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class SCategoryTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.SCategoryTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'Shop';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'shop_category';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\SCategory';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'SCategory';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 14;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 14;

    /**
     * the column name for the id field
     */
    const COL_ID = 'shop_category.id';

    /**
     * the column name for the parent_id field
     */
    const COL_PARENT_ID = 'shop_category.parent_id';

    /**
     * the column name for the external_id field
     */
    const COL_EXTERNAL_ID = 'shop_category.external_id';

    /**
     * the column name for the url field
     */
    const COL_URL = 'shop_category.url';

    /**
     * the column name for the active field
     */
    const COL_ACTIVE = 'shop_category.active';

    /**
     * the column name for the image field
     */
    const COL_IMAGE = 'shop_category.image';

    /**
     * the column name for the position field
     */
    const COL_POSITION = 'shop_category.position';

    /**
     * the column name for the full_path field
     */
    const COL_FULL_PATH = 'shop_category.full_path';

    /**
     * the column name for the full_path_ids field
     */
    const COL_FULL_PATH_IDS = 'shop_category.full_path_ids';

    /**
     * the column name for the tpl field
     */
    const COL_TPL = 'shop_category.tpl';

    /**
     * the column name for the order_method field
     */
    const COL_ORDER_METHOD = 'shop_category.order_method';

    /**
     * the column name for the showsitetitle field
     */
    const COL_SHOWSITETITLE = 'shop_category.showsitetitle';

    /**
     * the column name for the created field
     */
    const COL_CREATED = 'shop_category.created';

    /**
     * the column name for the updated field
     */
    const COL_UPDATED = 'shop_category.updated';

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
        self::TYPE_PHPNAME       => array('Id', 'ParentId', 'ExternalId', 'Url', 'Active', 'Image', 'Position', 'FullPath', 'FullPathIds', 'Tpl', 'OrderMethod', 'Showsitetitle', 'Created', 'Updated', ),
        self::TYPE_CAMELNAME     => array('id', 'parentId', 'externalId', 'url', 'active', 'image', 'position', 'fullPath', 'fullPathIds', 'tpl', 'orderMethod', 'showsitetitle', 'created', 'updated', ),
        self::TYPE_COLNAME       => array(SCategoryTableMap::COL_ID, SCategoryTableMap::COL_PARENT_ID, SCategoryTableMap::COL_EXTERNAL_ID, SCategoryTableMap::COL_URL, SCategoryTableMap::COL_ACTIVE, SCategoryTableMap::COL_IMAGE, SCategoryTableMap::COL_POSITION, SCategoryTableMap::COL_FULL_PATH, SCategoryTableMap::COL_FULL_PATH_IDS, SCategoryTableMap::COL_TPL, SCategoryTableMap::COL_ORDER_METHOD, SCategoryTableMap::COL_SHOWSITETITLE, SCategoryTableMap::COL_CREATED, SCategoryTableMap::COL_UPDATED, ),
        self::TYPE_FIELDNAME     => array('id', 'parent_id', 'external_id', 'url', 'active', 'image', 'position', 'full_path', 'full_path_ids', 'tpl', 'order_method', 'showsitetitle', 'created', 'updated', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'ParentId' => 1, 'ExternalId' => 2, 'Url' => 3, 'Active' => 4, 'Image' => 5, 'Position' => 6, 'FullPath' => 7, 'FullPathIds' => 8, 'Tpl' => 9, 'OrderMethod' => 10, 'Showsitetitle' => 11, 'Created' => 12, 'Updated' => 13, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'parentId' => 1, 'externalId' => 2, 'url' => 3, 'active' => 4, 'image' => 5, 'position' => 6, 'fullPath' => 7, 'fullPathIds' => 8, 'tpl' => 9, 'orderMethod' => 10, 'showsitetitle' => 11, 'created' => 12, 'updated' => 13, ),
        self::TYPE_COLNAME       => array(SCategoryTableMap::COL_ID => 0, SCategoryTableMap::COL_PARENT_ID => 1, SCategoryTableMap::COL_EXTERNAL_ID => 2, SCategoryTableMap::COL_URL => 3, SCategoryTableMap::COL_ACTIVE => 4, SCategoryTableMap::COL_IMAGE => 5, SCategoryTableMap::COL_POSITION => 6, SCategoryTableMap::COL_FULL_PATH => 7, SCategoryTableMap::COL_FULL_PATH_IDS => 8, SCategoryTableMap::COL_TPL => 9, SCategoryTableMap::COL_ORDER_METHOD => 10, SCategoryTableMap::COL_SHOWSITETITLE => 11, SCategoryTableMap::COL_CREATED => 12, SCategoryTableMap::COL_UPDATED => 13, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'parent_id' => 1, 'external_id' => 2, 'url' => 3, 'active' => 4, 'image' => 5, 'position' => 6, 'full_path' => 7, 'full_path_ids' => 8, 'tpl' => 9, 'order_method' => 10, 'showsitetitle' => 11, 'created' => 12, 'updated' => 13, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, )
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
        $this->setName('shop_category');
        $this->setPhpName('SCategory');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\SCategory');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('parent_id', 'ParentId', 'INTEGER', 'shop_category', 'id', false, null, null);
        $this->addColumn('external_id', 'ExternalId', 'VARCHAR', false, 255, null);
        $this->addColumn('url', 'Url', 'VARCHAR', true, 255, null);
        $this->addColumn('active', 'Active', 'BOOLEAN', false, 1, null);
        $this->addColumn('image', 'Image', 'VARCHAR', false, 255, null);
        $this->addColumn('position', 'Position', 'INTEGER', false, null, null);
        $this->addColumn('full_path', 'FullPath', 'VARCHAR', false, 1000, null);
        $this->addColumn('full_path_ids', 'FullPathIds', 'VARCHAR', false, 250, null);
        $this->addColumn('tpl', 'Tpl', 'VARCHAR', false, 250, null);
        $this->addColumn('order_method', 'OrderMethod', 'INTEGER', false, null, null);
        $this->addColumn('showsitetitle', 'Showsitetitle', 'INTEGER', false, null, null);
        $this->addColumn('created', 'Created', 'INTEGER', true, null, null);
        $this->addColumn('updated', 'Updated', 'INTEGER', true, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('SCategory', '\\SCategory', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':parent_id',
    1 => ':id',
  ),
), 'CASCADE', 'CASCADE', null, false);
        $this->addRelation('SCategoryRelatedById', '\\SCategory', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':parent_id',
    1 => ':id',
  ),
), 'CASCADE', 'CASCADE', 'SCategoriesRelatedById', false);
        $this->addRelation('SCategoryI18n', '\\SCategoryI18n', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':id',
    1 => ':id',
  ),
), 'CASCADE', 'CASCADE', 'SCategoryI18ns', false);
        $this->addRelation('SProducts', '\\SProducts', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':category_id',
    1 => ':id',
  ),
), 'CASCADE', 'CASCADE', 'SProductss', false);
        $this->addRelation('ShopProductCategories', '\\ShopProductCategories', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':category_id',
    1 => ':id',
  ),
), 'CASCADE', null, 'ShopProductCategoriess', false);
        $this->addRelation('ShopProductPropertiesCategories', '\\ShopProductPropertiesCategories', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':category_id',
    1 => ':id',
  ),
), 'CASCADE', null, 'ShopProductPropertiesCategoriess', false);
        $this->addRelation('Product', '\\SProducts', RelationMap::MANY_TO_MANY, array(), 'CASCADE', null, 'Products');
        $this->addRelation('Property', '\\SProperties', RelationMap::MANY_TO_MANY, array(), 'CASCADE', null, 'Properties');
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
            'i18n' => array('i18n_table' => '%TABLE%_i18n', 'i18n_phpname' => '%PHPNAME%I18n', 'i18n_columns' => 'name, h1, description, meta_desc, meta_title, meta_keywords', 'i18n_pk_column' => '', 'locale_column' => 'locale', 'locale_length' => '5', 'default_locale' => 'ru', 'locale_alias' => '', ),
        );
    } // getBehaviors()
    /**
     * Method to invalidate the instance pool of all tables related to shop_category     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in related instance pools,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        SCategoryTableMap::clearInstancePool();
        SCategoryI18nTableMap::clearInstancePool();
        SProductsTableMap::clearInstancePool();
        ShopProductCategoriesTableMap::clearInstancePool();
        ShopProductPropertiesCategoriesTableMap::clearInstancePool();
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
        return $withPrefix ? SCategoryTableMap::CLASS_DEFAULT : SCategoryTableMap::OM_CLASS;
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
     * @return array           (SCategory object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = SCategoryTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = SCategoryTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + SCategoryTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = SCategoryTableMap::OM_CLASS;
            /** @var SCategory $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            SCategoryTableMap::addInstanceToPool($obj, $key);
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
            $key = SCategoryTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = SCategoryTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var SCategory $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                SCategoryTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(SCategoryTableMap::COL_ID);
            $criteria->addSelectColumn(SCategoryTableMap::COL_PARENT_ID);
            $criteria->addSelectColumn(SCategoryTableMap::COL_EXTERNAL_ID);
            $criteria->addSelectColumn(SCategoryTableMap::COL_URL);
            $criteria->addSelectColumn(SCategoryTableMap::COL_ACTIVE);
            $criteria->addSelectColumn(SCategoryTableMap::COL_IMAGE);
            $criteria->addSelectColumn(SCategoryTableMap::COL_POSITION);
            $criteria->addSelectColumn(SCategoryTableMap::COL_FULL_PATH);
            $criteria->addSelectColumn(SCategoryTableMap::COL_FULL_PATH_IDS);
            $criteria->addSelectColumn(SCategoryTableMap::COL_TPL);
            $criteria->addSelectColumn(SCategoryTableMap::COL_ORDER_METHOD);
            $criteria->addSelectColumn(SCategoryTableMap::COL_SHOWSITETITLE);
            $criteria->addSelectColumn(SCategoryTableMap::COL_CREATED);
            $criteria->addSelectColumn(SCategoryTableMap::COL_UPDATED);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.parent_id');
            $criteria->addSelectColumn($alias . '.external_id');
            $criteria->addSelectColumn($alias . '.url');
            $criteria->addSelectColumn($alias . '.active');
            $criteria->addSelectColumn($alias . '.image');
            $criteria->addSelectColumn($alias . '.position');
            $criteria->addSelectColumn($alias . '.full_path');
            $criteria->addSelectColumn($alias . '.full_path_ids');
            $criteria->addSelectColumn($alias . '.tpl');
            $criteria->addSelectColumn($alias . '.order_method');
            $criteria->addSelectColumn($alias . '.showsitetitle');
            $criteria->addSelectColumn($alias . '.created');
            $criteria->addSelectColumn($alias . '.updated');
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
        return Propel::getServiceContainer()->getDatabaseMap(SCategoryTableMap::DATABASE_NAME)->getTable(SCategoryTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(SCategoryTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(SCategoryTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new SCategoryTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a SCategory or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or SCategory object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(SCategoryTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \SCategory) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(SCategoryTableMap::DATABASE_NAME);
            $criteria->add(SCategoryTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = SCategoryQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            SCategoryTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                SCategoryTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the shop_category table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return SCategoryQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a SCategory or Criteria object.
     *
     * @param mixed               $criteria Criteria or SCategory object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SCategoryTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from SCategory object
        }

        if ($criteria->containsKey(SCategoryTableMap::COL_ID) && $criteria->keyContainsValue(SCategoryTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.SCategoryTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = SCategoryQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // SCategoryTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
SCategoryTableMap::buildTableMap();
