<?php

namespace Map;

use \CustomFields;
use \CustomFieldsQuery;
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
 * This class defines the structure of the 'custom_fields' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class CustomFieldsTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.CustomFieldsTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'Shop';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'custom_fields';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\CustomFields';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'CustomFields';

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
    const COL_ID = 'custom_fields.id';

    /**
     * the column name for the entity field
     */
    const COL_ENTITY = 'custom_fields.entity';

    /**
     * the column name for the field_type_id field
     */
    const COL_FIELD_TYPE_ID = 'custom_fields.field_type_id';

    /**
     * the column name for the field_name field
     */
    const COL_FIELD_NAME = 'custom_fields.field_name';

    /**
     * the column name for the is_required field
     */
    const COL_IS_REQUIRED = 'custom_fields.is_required';

    /**
     * the column name for the is_active field
     */
    const COL_IS_ACTIVE = 'custom_fields.is_active';

    /**
     * the column name for the options field
     */
    const COL_OPTIONS = 'custom_fields.options';

    /**
     * the column name for the is_private field
     */
    const COL_IS_PRIVATE = 'custom_fields.is_private';

    /**
     * the column name for the validators field
     */
    const COL_VALIDATORS = 'custom_fields.validators';

    /**
     * the column name for the classes field
     */
    const COL_CLASSES = 'custom_fields.classes';

    /**
     * the column name for the position field
     */
    const COL_POSITION = 'custom_fields.position';

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
        self::TYPE_PHPNAME       => array('Id', 'Entity', 'typeId', 'name', 'IsRequired', 'IsActive', 'Options', 'IsPrivate', 'Validators', 'classes', 'position', ),
        self::TYPE_CAMELNAME     => array('id', 'entity', 'typeId', 'name', 'isRequired', 'isActive', 'options', 'isPrivate', 'validators', 'classes', 'position', ),
        self::TYPE_COLNAME       => array(CustomFieldsTableMap::COL_ID, CustomFieldsTableMap::COL_ENTITY, CustomFieldsTableMap::COL_FIELD_TYPE_ID, CustomFieldsTableMap::COL_FIELD_NAME, CustomFieldsTableMap::COL_IS_REQUIRED, CustomFieldsTableMap::COL_IS_ACTIVE, CustomFieldsTableMap::COL_OPTIONS, CustomFieldsTableMap::COL_IS_PRIVATE, CustomFieldsTableMap::COL_VALIDATORS, CustomFieldsTableMap::COL_CLASSES, CustomFieldsTableMap::COL_POSITION, ),
        self::TYPE_FIELDNAME     => array('id', 'entity', 'field_type_id', 'field_name', 'is_required', 'is_active', 'options', 'is_private', 'validators', 'classes', 'position', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'Entity' => 1, 'typeId' => 2, 'name' => 3, 'IsRequired' => 4, 'IsActive' => 5, 'Options' => 6, 'IsPrivate' => 7, 'Validators' => 8, 'classes' => 9, 'position' => 10, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'entity' => 1, 'typeId' => 2, 'name' => 3, 'isRequired' => 4, 'isActive' => 5, 'options' => 6, 'isPrivate' => 7, 'validators' => 8, 'classes' => 9, 'position' => 10, ),
        self::TYPE_COLNAME       => array(CustomFieldsTableMap::COL_ID => 0, CustomFieldsTableMap::COL_ENTITY => 1, CustomFieldsTableMap::COL_FIELD_TYPE_ID => 2, CustomFieldsTableMap::COL_FIELD_NAME => 3, CustomFieldsTableMap::COL_IS_REQUIRED => 4, CustomFieldsTableMap::COL_IS_ACTIVE => 5, CustomFieldsTableMap::COL_OPTIONS => 6, CustomFieldsTableMap::COL_IS_PRIVATE => 7, CustomFieldsTableMap::COL_VALIDATORS => 8, CustomFieldsTableMap::COL_CLASSES => 9, CustomFieldsTableMap::COL_POSITION => 10, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'entity' => 1, 'field_type_id' => 2, 'field_name' => 3, 'is_required' => 4, 'is_active' => 5, 'options' => 6, 'is_private' => 7, 'validators' => 8, 'classes' => 9, 'position' => 10, ),
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
        $this->setName('custom_fields');
        $this->setPhpName('CustomFields');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\CustomFields');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('entity', 'Entity', 'VARCHAR', false, 32, null);
        $this->addColumn('field_type_id', 'typeId', 'INTEGER', true, null, null);
        $this->addColumn('field_name', 'name', 'VARCHAR', true, 64, null);
        $this->addColumn('is_required', 'IsRequired', 'BOOLEAN', true, 1, true);
        $this->addColumn('is_active', 'IsActive', 'BOOLEAN', true, 1, true);
        $this->addColumn('options', 'Options', 'VARCHAR', false, 65, null);
        $this->addColumn('is_private', 'IsPrivate', 'BOOLEAN', true, 1, false);
        $this->addColumn('validators', 'Validators', 'VARCHAR', false, 255, null);
        $this->addColumn('classes', 'classes', 'LONGVARCHAR', false, null, null);
        $this->addColumn('position', 'position', 'TINYINT', false, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('CustomFieldsI18n', '\\CustomFieldsI18n', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':id',
    1 => ':id',
  ),
), 'CASCADE', 'CASCADE', 'CustomFieldsI18ns', false);
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
            'i18n' => array('i18n_table' => '%TABLE%_i18n', 'i18n_phpname' => '%PHPNAME%I18n', 'i18n_columns' => 'field_label, field_description, possible_values', 'i18n_pk_column' => '', 'locale_column' => 'locale', 'locale_length' => '5', 'default_locale' => 'ru', 'locale_alias' => '', ),
        );
    } // getBehaviors()
    /**
     * Method to invalidate the instance pool of all tables related to custom_fields     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in related instance pools,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        CustomFieldsI18nTableMap::clearInstancePool();
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
        return $withPrefix ? CustomFieldsTableMap::CLASS_DEFAULT : CustomFieldsTableMap::OM_CLASS;
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
     * @return array           (CustomFields object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = CustomFieldsTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = CustomFieldsTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + CustomFieldsTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = CustomFieldsTableMap::OM_CLASS;
            /** @var CustomFields $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            CustomFieldsTableMap::addInstanceToPool($obj, $key);
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
            $key = CustomFieldsTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = CustomFieldsTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var CustomFields $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                CustomFieldsTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(CustomFieldsTableMap::COL_ID);
            $criteria->addSelectColumn(CustomFieldsTableMap::COL_ENTITY);
            $criteria->addSelectColumn(CustomFieldsTableMap::COL_FIELD_TYPE_ID);
            $criteria->addSelectColumn(CustomFieldsTableMap::COL_FIELD_NAME);
            $criteria->addSelectColumn(CustomFieldsTableMap::COL_IS_REQUIRED);
            $criteria->addSelectColumn(CustomFieldsTableMap::COL_IS_ACTIVE);
            $criteria->addSelectColumn(CustomFieldsTableMap::COL_OPTIONS);
            $criteria->addSelectColumn(CustomFieldsTableMap::COL_IS_PRIVATE);
            $criteria->addSelectColumn(CustomFieldsTableMap::COL_VALIDATORS);
            $criteria->addSelectColumn(CustomFieldsTableMap::COL_CLASSES);
            $criteria->addSelectColumn(CustomFieldsTableMap::COL_POSITION);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.entity');
            $criteria->addSelectColumn($alias . '.field_type_id');
            $criteria->addSelectColumn($alias . '.field_name');
            $criteria->addSelectColumn($alias . '.is_required');
            $criteria->addSelectColumn($alias . '.is_active');
            $criteria->addSelectColumn($alias . '.options');
            $criteria->addSelectColumn($alias . '.is_private');
            $criteria->addSelectColumn($alias . '.validators');
            $criteria->addSelectColumn($alias . '.classes');
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
        return Propel::getServiceContainer()->getDatabaseMap(CustomFieldsTableMap::DATABASE_NAME)->getTable(CustomFieldsTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(CustomFieldsTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(CustomFieldsTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new CustomFieldsTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a CustomFields or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or CustomFields object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(CustomFieldsTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \CustomFields) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(CustomFieldsTableMap::DATABASE_NAME);
            $criteria->add(CustomFieldsTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = CustomFieldsQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            CustomFieldsTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                CustomFieldsTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the custom_fields table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return CustomFieldsQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a CustomFields or Criteria object.
     *
     * @param mixed               $criteria Criteria or CustomFields object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CustomFieldsTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from CustomFields object
        }

        if ($criteria->containsKey(CustomFieldsTableMap::COL_ID) && $criteria->keyContainsValue(CustomFieldsTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.CustomFieldsTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = CustomFieldsQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // CustomFieldsTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
CustomFieldsTableMap::buildTableMap();
