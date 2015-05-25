<?php

namespace Map;

use \SCategoryVersion;
use \SCategoryVersionQuery;
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
 * This class defines the structure of the 'shop_category_version' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class SCategoryVersionTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.SCategoryVersionTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'Shop';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'shop_category_version';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\SCategoryVersion';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'SCategoryVersion';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 18;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 18;

    /**
     * the column name for the id field
     */
    const COL_ID = 'shop_category_version.id';

    /**
     * the column name for the parent_id field
     */
    const COL_PARENT_ID = 'shop_category_version.parent_id';

    /**
     * the column name for the external_id field
     */
    const COL_EXTERNAL_ID = 'shop_category_version.external_id';

    /**
     * the column name for the url field
     */
    const COL_URL = 'shop_category_version.url';

    /**
     * the column name for the active field
     */
    const COL_ACTIVE = 'shop_category_version.active';

    /**
     * the column name for the image field
     */
    const COL_IMAGE = 'shop_category_version.image';

    /**
     * the column name for the position field
     */
    const COL_POSITION = 'shop_category_version.position';

    /**
     * the column name for the full_path field
     */
    const COL_FULL_PATH = 'shop_category_version.full_path';

    /**
     * the column name for the full_path_ids field
     */
    const COL_FULL_PATH_IDS = 'shop_category_version.full_path_ids';

    /**
     * the column name for the tpl field
     */
    const COL_TPL = 'shop_category_version.tpl';

    /**
     * the column name for the order_method field
     */
    const COL_ORDER_METHOD = 'shop_category_version.order_method';

    /**
     * the column name for the showsitetitle field
     */
    const COL_SHOWSITETITLE = 'shop_category_version.showsitetitle';

    /**
     * the column name for the created field
     */
    const COL_CREATED = 'shop_category_version.created';

    /**
     * the column name for the updated field
     */
    const COL_UPDATED = 'shop_category_version.updated';

    /**
     * the column name for the version field
     */
    const COL_VERSION = 'shop_category_version.version';

    /**
     * the column name for the parent_id_version field
     */
    const COL_PARENT_ID_VERSION = 'shop_category_version.parent_id_version';

    /**
     * the column name for the shop_category_ids field
     */
    const COL_SHOP_CATEGORY_IDS = 'shop_category_version.shop_category_ids';

    /**
     * the column name for the shop_category_versions field
     */
    const COL_SHOP_CATEGORY_VERSIONS = 'shop_category_version.shop_category_versions';

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
        self::TYPE_PHPNAME       => array('Id', 'ParentId', 'ExternalId', 'Url', 'Active', 'Image', 'Position', 'FullPath', 'FullPathIds', 'Tpl', 'OrderMethod', 'Showsitetitle', 'Created', 'Updated', 'Version', 'ParentIdVersion', 'ShopCategoryIds', 'ShopCategoryVersions', ),
        self::TYPE_CAMELNAME     => array('id', 'parentId', 'externalId', 'url', 'active', 'image', 'position', 'fullPath', 'fullPathIds', 'tpl', 'orderMethod', 'showsitetitle', 'created', 'updated', 'version', 'parentIdVersion', 'shopCategoryIds', 'shopCategoryVersions', ),
        self::TYPE_COLNAME       => array(SCategoryVersionTableMap::COL_ID, SCategoryVersionTableMap::COL_PARENT_ID, SCategoryVersionTableMap::COL_EXTERNAL_ID, SCategoryVersionTableMap::COL_URL, SCategoryVersionTableMap::COL_ACTIVE, SCategoryVersionTableMap::COL_IMAGE, SCategoryVersionTableMap::COL_POSITION, SCategoryVersionTableMap::COL_FULL_PATH, SCategoryVersionTableMap::COL_FULL_PATH_IDS, SCategoryVersionTableMap::COL_TPL, SCategoryVersionTableMap::COL_ORDER_METHOD, SCategoryVersionTableMap::COL_SHOWSITETITLE, SCategoryVersionTableMap::COL_CREATED, SCategoryVersionTableMap::COL_UPDATED, SCategoryVersionTableMap::COL_VERSION, SCategoryVersionTableMap::COL_PARENT_ID_VERSION, SCategoryVersionTableMap::COL_SHOP_CATEGORY_IDS, SCategoryVersionTableMap::COL_SHOP_CATEGORY_VERSIONS, ),
        self::TYPE_FIELDNAME     => array('id', 'parent_id', 'external_id', 'url', 'active', 'image', 'position', 'full_path', 'full_path_ids', 'tpl', 'order_method', 'showsitetitle', 'created', 'updated', 'version', 'parent_id_version', 'shop_category_ids', 'shop_category_versions', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'ParentId' => 1, 'ExternalId' => 2, 'Url' => 3, 'Active' => 4, 'Image' => 5, 'Position' => 6, 'FullPath' => 7, 'FullPathIds' => 8, 'Tpl' => 9, 'OrderMethod' => 10, 'Showsitetitle' => 11, 'Created' => 12, 'Updated' => 13, 'Version' => 14, 'ParentIdVersion' => 15, 'ShopCategoryIds' => 16, 'ShopCategoryVersions' => 17, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'parentId' => 1, 'externalId' => 2, 'url' => 3, 'active' => 4, 'image' => 5, 'position' => 6, 'fullPath' => 7, 'fullPathIds' => 8, 'tpl' => 9, 'orderMethod' => 10, 'showsitetitle' => 11, 'created' => 12, 'updated' => 13, 'version' => 14, 'parentIdVersion' => 15, 'shopCategoryIds' => 16, 'shopCategoryVersions' => 17, ),
        self::TYPE_COLNAME       => array(SCategoryVersionTableMap::COL_ID => 0, SCategoryVersionTableMap::COL_PARENT_ID => 1, SCategoryVersionTableMap::COL_EXTERNAL_ID => 2, SCategoryVersionTableMap::COL_URL => 3, SCategoryVersionTableMap::COL_ACTIVE => 4, SCategoryVersionTableMap::COL_IMAGE => 5, SCategoryVersionTableMap::COL_POSITION => 6, SCategoryVersionTableMap::COL_FULL_PATH => 7, SCategoryVersionTableMap::COL_FULL_PATH_IDS => 8, SCategoryVersionTableMap::COL_TPL => 9, SCategoryVersionTableMap::COL_ORDER_METHOD => 10, SCategoryVersionTableMap::COL_SHOWSITETITLE => 11, SCategoryVersionTableMap::COL_CREATED => 12, SCategoryVersionTableMap::COL_UPDATED => 13, SCategoryVersionTableMap::COL_VERSION => 14, SCategoryVersionTableMap::COL_PARENT_ID_VERSION => 15, SCategoryVersionTableMap::COL_SHOP_CATEGORY_IDS => 16, SCategoryVersionTableMap::COL_SHOP_CATEGORY_VERSIONS => 17, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'parent_id' => 1, 'external_id' => 2, 'url' => 3, 'active' => 4, 'image' => 5, 'position' => 6, 'full_path' => 7, 'full_path_ids' => 8, 'tpl' => 9, 'order_method' => 10, 'showsitetitle' => 11, 'created' => 12, 'updated' => 13, 'version' => 14, 'parent_id_version' => 15, 'shop_category_ids' => 16, 'shop_category_versions' => 17, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, )
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
        $this->setName('shop_category_version');
        $this->setPhpName('SCategoryVersion');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\SCategoryVersion');
        $this->setPackage('');
        $this->setUseIdGenerator(false);
        // columns
        $this->addForeignPrimaryKey('id', 'Id', 'INTEGER' , 'shop_category', 'id', true, null, null);
        $this->addColumn('parent_id', 'ParentId', 'INTEGER', false, null, null);
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
        $this->addPrimaryKey('version', 'Version', 'INTEGER', true, null, 0);
        $this->addColumn('parent_id_version', 'ParentIdVersion', 'INTEGER', false, null, 0);
        $this->addColumn('shop_category_ids', 'ShopCategoryIds', 'ARRAY', false, null, null);
        $this->addColumn('shop_category_versions', 'ShopCategoryVersions', 'ARRAY', false, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('SCategory', '\\SCategory', RelationMap::MANY_TO_ONE, array('id' => 'id', ), 'CASCADE', null);
    } // buildRelations()

    /**
     * Adds an object to the instance pool.
     *
     * Propel keeps cached copies of objects in an instance pool when they are retrieved
     * from the database. In some cases you may need to explicitly add objects
     * to the cache in order to ensure that the same objects are always returned by find*()
     * and findPk*() calls.
     *
     * @param \SCategoryVersion $obj A \SCategoryVersion object.
     * @param string $key             (optional) key to use for instance map (for performance boost if key was already calculated externally).
     */
    public static function addInstanceToPool($obj, $key = null)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if (null === $key) {
                $key = serialize(array((string) $obj->getId(), (string) $obj->getVersion()));
            } // if key === null
            self::$instances[$key] = $obj;
        }
    }

    /**
     * Removes an object from the instance pool.
     *
     * Propel keeps cached copies of objects in an instance pool when they are retrieved
     * from the database.  In some cases -- especially when you override doDelete
     * methods in your stub classes -- you may need to explicitly remove objects
     * from the cache in order to prevent returning objects that no longer exist.
     *
     * @param mixed $value A \SCategoryVersion object or a primary key value.
     */
    public static function removeInstanceFromPool($value)
    {
        if (Propel::isInstancePoolingEnabled() && null !== $value) {
            if (is_object($value) && $value instanceof \SCategoryVersion) {
                $key = serialize(array((string) $value->getId(), (string) $value->getVersion()));

            } elseif (is_array($value) && count($value) === 2) {
                // assume we've been passed a primary key";
                $key = serialize(array((string) $value[0], (string) $value[1]));
            } elseif ($value instanceof Criteria) {
                self::$instances = [];

                return;
            } else {
                $e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or \SCategoryVersion object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value, true)));
                throw $e;
            }

            unset(self::$instances[$key]);
        }
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] === null && $row[TableMap::TYPE_NUM == $indexType ? 14 + $offset : static::translateFieldName('Version', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return serialize(array((string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)], (string) $row[TableMap::TYPE_NUM == $indexType ? 14 + $offset : static::translateFieldName('Version', TableMap::TYPE_PHPNAME, $indexType)]));
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
            $pks = [];

        $pks[] = (int) $row[
            $indexType == TableMap::TYPE_NUM
                ? 0 + $offset
                : self::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)
        ];
        $pks[] = (int) $row[
            $indexType == TableMap::TYPE_NUM
                ? 14 + $offset
                : self::translateFieldName('Version', TableMap::TYPE_PHPNAME, $indexType)
        ];

        return $pks;
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
        return $withPrefix ? SCategoryVersionTableMap::CLASS_DEFAULT : SCategoryVersionTableMap::OM_CLASS;
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
     * @return array           (SCategoryVersion object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = SCategoryVersionTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = SCategoryVersionTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + SCategoryVersionTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = SCategoryVersionTableMap::OM_CLASS;
            /** @var SCategoryVersion $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            SCategoryVersionTableMap::addInstanceToPool($obj, $key);
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
            $key = SCategoryVersionTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = SCategoryVersionTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var SCategoryVersion $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                SCategoryVersionTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(SCategoryVersionTableMap::COL_ID);
            $criteria->addSelectColumn(SCategoryVersionTableMap::COL_PARENT_ID);
            $criteria->addSelectColumn(SCategoryVersionTableMap::COL_EXTERNAL_ID);
            $criteria->addSelectColumn(SCategoryVersionTableMap::COL_URL);
            $criteria->addSelectColumn(SCategoryVersionTableMap::COL_ACTIVE);
            $criteria->addSelectColumn(SCategoryVersionTableMap::COL_IMAGE);
            $criteria->addSelectColumn(SCategoryVersionTableMap::COL_POSITION);
            $criteria->addSelectColumn(SCategoryVersionTableMap::COL_FULL_PATH);
            $criteria->addSelectColumn(SCategoryVersionTableMap::COL_FULL_PATH_IDS);
            $criteria->addSelectColumn(SCategoryVersionTableMap::COL_TPL);
            $criteria->addSelectColumn(SCategoryVersionTableMap::COL_ORDER_METHOD);
            $criteria->addSelectColumn(SCategoryVersionTableMap::COL_SHOWSITETITLE);
            $criteria->addSelectColumn(SCategoryVersionTableMap::COL_CREATED);
            $criteria->addSelectColumn(SCategoryVersionTableMap::COL_UPDATED);
            $criteria->addSelectColumn(SCategoryVersionTableMap::COL_VERSION);
            $criteria->addSelectColumn(SCategoryVersionTableMap::COL_PARENT_ID_VERSION);
            $criteria->addSelectColumn(SCategoryVersionTableMap::COL_SHOP_CATEGORY_IDS);
            $criteria->addSelectColumn(SCategoryVersionTableMap::COL_SHOP_CATEGORY_VERSIONS);
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
            $criteria->addSelectColumn($alias . '.version');
            $criteria->addSelectColumn($alias . '.parent_id_version');
            $criteria->addSelectColumn($alias . '.shop_category_ids');
            $criteria->addSelectColumn($alias . '.shop_category_versions');
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
        return Propel::getServiceContainer()->getDatabaseMap(SCategoryVersionTableMap::DATABASE_NAME)->getTable(SCategoryVersionTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(SCategoryVersionTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(SCategoryVersionTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new SCategoryVersionTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a SCategoryVersion or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or SCategoryVersion object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(SCategoryVersionTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \SCategoryVersion) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(SCategoryVersionTableMap::DATABASE_NAME);
            // primary key is composite; we therefore, expect
            // the primary key passed to be an array of pkey values
            if (count($values) == count($values, COUNT_RECURSIVE)) {
                // array is not multi-dimensional
                $values = array($values);
            }
            foreach ($values as $value) {
                $criterion = $criteria->getNewCriterion(SCategoryVersionTableMap::COL_ID, $value[0]);
                $criterion->addAnd($criteria->getNewCriterion(SCategoryVersionTableMap::COL_VERSION, $value[1]));
                $criteria->addOr($criterion);
            }
        }

        $query = SCategoryVersionQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            SCategoryVersionTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                SCategoryVersionTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the shop_category_version table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return SCategoryVersionQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a SCategoryVersion or Criteria object.
     *
     * @param mixed               $criteria Criteria or SCategoryVersion object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SCategoryVersionTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from SCategoryVersion object
        }


        // Set the correct dbName
        $query = SCategoryVersionQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // SCategoryVersionTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
SCategoryVersionTableMap::buildTableMap();
