<?php

namespace Map;

use \SProducts;
use \SProductsQuery;
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
 * This class defines the structure of the 'shop_products' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class SProductsTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.SProductsTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'Shop';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'shop_products';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\SProducts';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'SProducts';

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
    const COL_ID = 'shop_products.id';

    /**
     * the column name for the user_id field
     */
    const COL_USER_ID = 'shop_products.user_id';

    /**
     * the column name for the external_id field
     */
    const COL_EXTERNAL_ID = 'shop_products.external_id';

    /**
     * the column name for the url field
     */
    const COL_URL = 'shop_products.url';

    /**
     * the column name for the active field
     */
    const COL_ACTIVE = 'shop_products.active';

    /**
     * the column name for the hit field
     */
    const COL_HIT = 'shop_products.hit';

    /**
     * the column name for the hot field
     */
    const COL_HOT = 'shop_products.hot';

    /**
     * the column name for the action field
     */
    const COL_ACTION = 'shop_products.action';

    /**
     * the column name for the brand_id field
     */
    const COL_BRAND_ID = 'shop_products.brand_id';

    /**
     * the column name for the category_id field
     */
    const COL_CATEGORY_ID = 'shop_products.category_id';

    /**
     * the column name for the related_products field
     */
    const COL_RELATED_PRODUCTS = 'shop_products.related_products';

    /**
     * the column name for the old_price field
     */
    const COL_OLD_PRICE = 'shop_products.old_price';

    /**
     * the column name for the created field
     */
    const COL_CREATED = 'shop_products.created';

    /**
     * the column name for the updated field
     */
    const COL_UPDATED = 'shop_products.updated';

    /**
     * the column name for the views field
     */
    const COL_VIEWS = 'shop_products.views';

    /**
     * the column name for the added_to_cart_count field
     */
    const COL_ADDED_TO_CART_COUNT = 'shop_products.added_to_cart_count';

    /**
     * the column name for the enable_comments field
     */
    const COL_ENABLE_COMMENTS = 'shop_products.enable_comments';

    /**
     * the column name for the tpl field
     */
    const COL_TPL = 'shop_products.tpl';

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
        self::TYPE_PHPNAME       => array('Id', 'UserId', 'ExternalId', 'Url', 'Active', 'Hit', 'Hot', 'Action', 'BrandId', 'CategoryId', 'RelatedProducts', 'OldPrice', 'Created', 'Updated', 'Views', 'AddedToCartCount', 'EnableComments', 'Tpl', ),
        self::TYPE_CAMELNAME     => array('id', 'userId', 'externalId', 'url', 'active', 'hit', 'hot', 'action', 'brandId', 'categoryId', 'relatedProducts', 'oldPrice', 'created', 'updated', 'views', 'addedToCartCount', 'enableComments', 'tpl', ),
        self::TYPE_COLNAME       => array(SProductsTableMap::COL_ID, SProductsTableMap::COL_USER_ID, SProductsTableMap::COL_EXTERNAL_ID, SProductsTableMap::COL_URL, SProductsTableMap::COL_ACTIVE, SProductsTableMap::COL_HIT, SProductsTableMap::COL_HOT, SProductsTableMap::COL_ACTION, SProductsTableMap::COL_BRAND_ID, SProductsTableMap::COL_CATEGORY_ID, SProductsTableMap::COL_RELATED_PRODUCTS, SProductsTableMap::COL_OLD_PRICE, SProductsTableMap::COL_CREATED, SProductsTableMap::COL_UPDATED, SProductsTableMap::COL_VIEWS, SProductsTableMap::COL_ADDED_TO_CART_COUNT, SProductsTableMap::COL_ENABLE_COMMENTS, SProductsTableMap::COL_TPL, ),
        self::TYPE_FIELDNAME     => array('id', 'user_id', 'external_id', 'url', 'active', 'hit', 'hot', 'action', 'brand_id', 'category_id', 'related_products', 'old_price', 'created', 'updated', 'views', 'added_to_cart_count', 'enable_comments', 'tpl', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'UserId' => 1, 'ExternalId' => 2, 'Url' => 3, 'Active' => 4, 'Hit' => 5, 'Hot' => 6, 'Action' => 7, 'BrandId' => 8, 'CategoryId' => 9, 'RelatedProducts' => 10, 'OldPrice' => 11, 'Created' => 12, 'Updated' => 13, 'Views' => 14, 'AddedToCartCount' => 15, 'EnableComments' => 16, 'Tpl' => 17, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'userId' => 1, 'externalId' => 2, 'url' => 3, 'active' => 4, 'hit' => 5, 'hot' => 6, 'action' => 7, 'brandId' => 8, 'categoryId' => 9, 'relatedProducts' => 10, 'oldPrice' => 11, 'created' => 12, 'updated' => 13, 'views' => 14, 'addedToCartCount' => 15, 'enableComments' => 16, 'tpl' => 17, ),
        self::TYPE_COLNAME       => array(SProductsTableMap::COL_ID => 0, SProductsTableMap::COL_USER_ID => 1, SProductsTableMap::COL_EXTERNAL_ID => 2, SProductsTableMap::COL_URL => 3, SProductsTableMap::COL_ACTIVE => 4, SProductsTableMap::COL_HIT => 5, SProductsTableMap::COL_HOT => 6, SProductsTableMap::COL_ACTION => 7, SProductsTableMap::COL_BRAND_ID => 8, SProductsTableMap::COL_CATEGORY_ID => 9, SProductsTableMap::COL_RELATED_PRODUCTS => 10, SProductsTableMap::COL_OLD_PRICE => 11, SProductsTableMap::COL_CREATED => 12, SProductsTableMap::COL_UPDATED => 13, SProductsTableMap::COL_VIEWS => 14, SProductsTableMap::COL_ADDED_TO_CART_COUNT => 15, SProductsTableMap::COL_ENABLE_COMMENTS => 16, SProductsTableMap::COL_TPL => 17, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'user_id' => 1, 'external_id' => 2, 'url' => 3, 'active' => 4, 'hit' => 5, 'hot' => 6, 'action' => 7, 'brand_id' => 8, 'category_id' => 9, 'related_products' => 10, 'old_price' => 11, 'created' => 12, 'updated' => 13, 'views' => 14, 'added_to_cart_count' => 15, 'enable_comments' => 16, 'tpl' => 17, ),
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
        $this->setName('shop_products');
        $this->setPhpName('SProducts');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\SProducts');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('user_id', 'UserId', 'INTEGER', false, null, null);
        $this->addColumn('external_id', 'ExternalId', 'VARCHAR', false, 255, null);
        $this->addColumn('url', 'Url', 'VARCHAR', true, 255, null);
        $this->addColumn('active', 'Active', 'BOOLEAN', false, 1, null);
        $this->addColumn('hit', 'Hit', 'BOOLEAN', false, 1, null);
        $this->addColumn('hot', 'Hot', 'BOOLEAN', false, 1, null);
        $this->addColumn('action', 'Action', 'BOOLEAN', false, 1, null);
        $this->addForeignKey('brand_id', 'BrandId', 'INTEGER', 'shop_brands', 'id', false, null, null);
        $this->addForeignKey('category_id', 'CategoryId', 'INTEGER', 'shop_category', 'id', true, null, null);
        $this->addColumn('related_products', 'RelatedProducts', 'VARCHAR', false, 255, null);
        $this->addColumn('old_price', 'OldPrice', 'DOUBLE', false, null, null);
        $this->addColumn('created', 'Created', 'INTEGER', true, null, null);
        $this->addColumn('updated', 'Updated', 'INTEGER', true, null, null);
        $this->addColumn('views', 'Views', 'INTEGER', false, null, 0);
        $this->addColumn('added_to_cart_count', 'AddedToCartCount', 'INTEGER', false, null, null);
        $this->addColumn('enable_comments', 'EnableComments', 'BOOLEAN', false, 1, true);
        $this->addColumn('tpl', 'Tpl', 'VARCHAR', false, 250, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Brand', '\\SBrands', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':brand_id',
    1 => ':id',
  ),
), null, null, null, false);
        $this->addRelation('MainCategory', '\\SCategory', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':category_id',
    1 => ':id',
  ),
), 'CASCADE', 'CASCADE', null, false);
        $this->addRelation('ShopKit', '\\ShopKit', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':product_id',
    1 => ':id',
  ),
), 'CASCADE', 'CASCADE', 'ShopKits', false);
        $this->addRelation('ShopKitProduct', '\\ShopKitProduct', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':product_id',
    1 => ':id',
  ),
), 'CASCADE', 'CASCADE', 'ShopKitProducts', false);
        $this->addRelation('SProductsI18n', '\\SProductsI18n', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':id',
    1 => ':id',
  ),
), 'CASCADE', 'CASCADE', 'SProductsI18ns', false);
        $this->addRelation('SProductImages', '\\SProductImages', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':product_id',
    1 => ':id',
  ),
), 'CASCADE', null, 'SProductImagess', false);
        $this->addRelation('ProductVariant', '\\SProductVariants', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':product_id',
    1 => ':id',
  ),
), 'CASCADE', 'CASCADE', 'ProductVariants', false);
        $this->addRelation('SWarehouseData', '\\SWarehouseData', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':product_id',
    1 => ':id',
  ),
), 'CASCADE', null, 'SWarehouseDatas', false);
        $this->addRelation('ShopProductCategories', '\\ShopProductCategories', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':product_id',
    1 => ':id',
  ),
), 'CASCADE', null, 'ShopProductCategoriess', false);
        $this->addRelation('SProductPropertiesData', '\\SProductPropertiesData', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':product_id',
    1 => ':id',
  ),
), 'CASCADE', null, 'SProductPropertiesDatas', false);
        $this->addRelation('SNotifications', '\\SNotifications', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':product_id',
    1 => ':id',
  ),
), null, null, 'SNotificationss', false);
        $this->addRelation('SOrderProducts', '\\SOrderProducts', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':product_id',
    1 => ':id',
  ),
), null, null, 'SOrderProductss', false);
        $this->addRelation('SProductsRating', '\\SProductsRating', RelationMap::ONE_TO_ONE, array (
  0 =>
  array (
    0 => ':product_id',
    1 => ':id',
  ),
), null, null, null, false);
        $this->addRelation('Category', '\\SCategory', RelationMap::MANY_TO_MANY, array(), 'CASCADE', null, 'Categories');
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
            'i18n' => array('i18n_table' => '%TABLE%_i18n', 'i18n_phpname' => '%PHPNAME%I18n', 'i18n_columns' => 'name, short_description, full_description, meta_title, meta_description, meta_keywords', 'i18n_pk_column' => '', 'locale_column' => 'locale', 'locale_length' => '5', 'default_locale' => 'ru', 'locale_alias' => '', ),
            'query_cache' => array('backend' => 'custom', 'lifetime' => '600', ),
        );
    } // getBehaviors()
    /**
     * Method to invalidate the instance pool of all tables related to shop_products     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in related instance pools,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        ShopKitTableMap::clearInstancePool();
        ShopKitProductTableMap::clearInstancePool();
        SProductsI18nTableMap::clearInstancePool();
        SProductImagesTableMap::clearInstancePool();
        SProductVariantsTableMap::clearInstancePool();
        SWarehouseDataTableMap::clearInstancePool();
        ShopProductCategoriesTableMap::clearInstancePool();
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
        return $withPrefix ? SProductsTableMap::CLASS_DEFAULT : SProductsTableMap::OM_CLASS;
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
     * @return array           (SProducts object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = SProductsTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = SProductsTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + SProductsTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = SProductsTableMap::OM_CLASS;
            /** @var SProducts $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            SProductsTableMap::addInstanceToPool($obj, $key);
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
            $key = SProductsTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = SProductsTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var SProducts $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                SProductsTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(SProductsTableMap::COL_ID);
            $criteria->addSelectColumn(SProductsTableMap::COL_USER_ID);
            $criteria->addSelectColumn(SProductsTableMap::COL_EXTERNAL_ID);
            $criteria->addSelectColumn(SProductsTableMap::COL_URL);
            $criteria->addSelectColumn(SProductsTableMap::COL_ACTIVE);
            $criteria->addSelectColumn(SProductsTableMap::COL_HIT);
            $criteria->addSelectColumn(SProductsTableMap::COL_HOT);
            $criteria->addSelectColumn(SProductsTableMap::COL_ACTION);
            $criteria->addSelectColumn(SProductsTableMap::COL_BRAND_ID);
            $criteria->addSelectColumn(SProductsTableMap::COL_CATEGORY_ID);
            $criteria->addSelectColumn(SProductsTableMap::COL_RELATED_PRODUCTS);
            $criteria->addSelectColumn(SProductsTableMap::COL_OLD_PRICE);
            $criteria->addSelectColumn(SProductsTableMap::COL_CREATED);
            $criteria->addSelectColumn(SProductsTableMap::COL_UPDATED);
            $criteria->addSelectColumn(SProductsTableMap::COL_VIEWS);
            $criteria->addSelectColumn(SProductsTableMap::COL_ADDED_TO_CART_COUNT);
            $criteria->addSelectColumn(SProductsTableMap::COL_ENABLE_COMMENTS);
            $criteria->addSelectColumn(SProductsTableMap::COL_TPL);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.user_id');
            $criteria->addSelectColumn($alias . '.external_id');
            $criteria->addSelectColumn($alias . '.url');
            $criteria->addSelectColumn($alias . '.active');
            $criteria->addSelectColumn($alias . '.hit');
            $criteria->addSelectColumn($alias . '.hot');
            $criteria->addSelectColumn($alias . '.action');
            $criteria->addSelectColumn($alias . '.brand_id');
            $criteria->addSelectColumn($alias . '.category_id');
            $criteria->addSelectColumn($alias . '.related_products');
            $criteria->addSelectColumn($alias . '.old_price');
            $criteria->addSelectColumn($alias . '.created');
            $criteria->addSelectColumn($alias . '.updated');
            $criteria->addSelectColumn($alias . '.views');
            $criteria->addSelectColumn($alias . '.added_to_cart_count');
            $criteria->addSelectColumn($alias . '.enable_comments');
            $criteria->addSelectColumn($alias . '.tpl');
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
        return Propel::getServiceContainer()->getDatabaseMap(SProductsTableMap::DATABASE_NAME)->getTable(SProductsTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(SProductsTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(SProductsTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new SProductsTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a SProducts or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or SProducts object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(SProductsTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \SProducts) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(SProductsTableMap::DATABASE_NAME);
            $criteria->add(SProductsTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = SProductsQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            SProductsTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                SProductsTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the shop_products table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return SProductsQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a SProducts or Criteria object.
     *
     * @param mixed               $criteria Criteria or SProducts object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SProductsTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from SProducts object
        }

        if ($criteria->containsKey(SProductsTableMap::COL_ID) && $criteria->keyContainsValue(SProductsTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.SProductsTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = SProductsQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // SProductsTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
SProductsTableMap::buildTableMap();
