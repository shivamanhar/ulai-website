<?php

namespace Base;

use \SCategory as ChildSCategory;
use \SCategoryQuery as ChildSCategoryQuery;
use \SProductPropertiesData as ChildSProductPropertiesData;
use \SProductPropertiesDataQuery as ChildSProductPropertiesDataQuery;
use \SProperties as ChildSProperties;
use \SPropertiesI18n as ChildSPropertiesI18n;
use \SPropertiesI18nQuery as ChildSPropertiesI18nQuery;
use \SPropertiesQuery as ChildSPropertiesQuery;
use \ShopProductPropertiesCategories as ChildShopProductPropertiesCategories;
use \ShopProductPropertiesCategoriesQuery as ChildShopProductPropertiesCategoriesQuery;
use \Exception;
use \PDO;
use Map\SPropertiesTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;

/**
 * Base class that represents a row from the 'shop_product_properties' table.
 *
 *
 *
* @package    propel.generator..Base
*/
abstract class SProperties extends PropelBaseModelClass implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\SPropertiesTableMap';


    /**
     * attribute to determine if this object has previously been saved.
     * @var boolean
     */
    protected $new = true;

    /**
     * attribute to determine whether this object has been deleted.
     * @var boolean
     */
    protected $deleted = false;

    /**
     * The columns that have been modified in current object.
     * Tracking modified columns allows us to only update modified columns.
     * @var array
     */
    protected $modifiedColumns = array();

    /**
     * The (virtual) columns that are added at runtime
     * The formatters can add supplementary columns based on a resultset
     * @var array
     */
    protected $virtualColumns = array();

    /**
     * The value for the id field.
     * @var        int
     */
    protected $id;

    /**
     * The value for the external_id field.
     * @var        string
     */
    protected $external_id;

    /**
     * The value for the csv_name field.
     * @var        string
     */
    protected $csv_name;

    /**
     * The value for the multiple field.
     * @var        boolean
     */
    protected $multiple;

    /**
     * The value for the active field.
     * @var        boolean
     */
    protected $active;

    /**
     * The value for the show_on_site field.
     * @var        boolean
     */
    protected $show_on_site;

    /**
     * The value for the show_in_compare field.
     * @var        boolean
     */
    protected $show_in_compare;

    /**
     * The value for the show_in_filter field.
     * @var        boolean
     */
    protected $show_in_filter;

    /**
     * The value for the show_faq field.
     * @var        boolean
     */
    protected $show_faq;

    /**
     * The value for the main_property field.
     * @var        boolean
     */
    protected $main_property;

    /**
     * The value for the position field.
     * @var        int
     */
    protected $position;

    /**
     * @var        ObjectCollection|ChildSPropertiesI18n[] Collection to store aggregation of ChildSPropertiesI18n objects.
     */
    protected $collSPropertiesI18ns;
    protected $collSPropertiesI18nsPartial;

    /**
     * @var        ObjectCollection|ChildShopProductPropertiesCategories[] Collection to store aggregation of ChildShopProductPropertiesCategories objects.
     */
    protected $collShopProductPropertiesCategoriess;
    protected $collShopProductPropertiesCategoriessPartial;

    /**
     * @var        ObjectCollection|ChildSProductPropertiesData[] Collection to store aggregation of ChildSProductPropertiesData objects.
     */
    protected $collSProductPropertiesDatas;
    protected $collSProductPropertiesDatasPartial;

    /**
     * @var        ObjectCollection|ChildSCategory[] Cross Collection to store aggregation of ChildSCategory objects.
     */
    protected $collPropertyCategories;

    /**
     * @var bool
     */
    protected $collPropertyCategoriesPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    // i18n behavior

    /**
     * Current locale
     * @var        string
     */
    protected $currentLocale = 'ru';

    /**
     * Current translation objects
     * @var        array[ChildSPropertiesI18n]
     */
    protected $currentTranslations;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildSCategory[]
     */
    protected $propertyCategoriesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildSPropertiesI18n[]
     */
    protected $sPropertiesI18nsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildShopProductPropertiesCategories[]
     */
    protected $shopProductPropertiesCategoriessScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildSProductPropertiesData[]
     */
    protected $sProductPropertiesDatasScheduledForDeletion = null;

    /**
     * Initializes internal state of Base\SProperties object.
     */
    public function __construct()
    {
    }

    /**
     * Returns whether the object has been modified.
     *
     * @return boolean True if the object has been modified.
     */
    public function isModified()
    {
        return !!$this->modifiedColumns;
    }

    /**
     * Has specified column been modified?
     *
     * @param  string  $col column fully qualified name (TableMap::TYPE_COLNAME), e.g. Book::AUTHOR_ID
     * @return boolean True if $col has been modified.
     */
    public function isColumnModified($col)
    {
        return $this->modifiedColumns && isset($this->modifiedColumns[$col]);
    }

    /**
     * Get the columns that have been modified in this object.
     * @return array A unique list of the modified column names for this object.
     */
    public function getModifiedColumns()
    {
        return $this->modifiedColumns ? array_keys($this->modifiedColumns) : [];
    }

    /**
     * Returns whether the object has ever been saved.  This will
     * be false, if the object was retrieved from storage or was created
     * and then saved.
     *
     * @return boolean true, if the object has never been persisted.
     */
    public function isNew()
    {
        return $this->new;
    }

    /**
     * Setter for the isNew attribute.  This method will be called
     * by Propel-generated children and objects.
     *
     * @param boolean $b the state of the object.
     */
    public function setNew($b)
    {
        $this->new = (boolean) $b;
    }

    /**
     * Whether this object has been deleted.
     * @return boolean The deleted state of this object.
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * Specify whether this object has been deleted.
     * @param  boolean $b The deleted state of this object.
     * @return void
     */
    public function setDeleted($b)
    {
        $this->deleted = (boolean) $b;
    }

    /**
     * Sets the modified state for the object to be false.
     * @param  string $col If supplied, only the specified column is reset.
     * @return void
     */
    public function resetModified($col = null)
    {
        if (null !== $col) {
            if (isset($this->modifiedColumns[$col])) {
                unset($this->modifiedColumns[$col]);
            }
        } else {
            $this->modifiedColumns = array();
        }
    }

    /**
     * Compares this with another <code>SProperties</code> instance.  If
     * <code>obj</code> is an instance of <code>SProperties</code>, delegates to
     * <code>equals(SProperties)</code>.  Otherwise, returns <code>false</code>.
     *
     * @param  mixed   $obj The object to compare to.
     * @return boolean Whether equal to the object specified.
     */
    public function equals($obj)
    {
        if (!$obj instanceof static) {
            return false;
        }

        if ($this === $obj) {
            return true;
        }

        if (null === $this->getPrimaryKey() || null === $obj->getPrimaryKey()) {
            return false;
        }

        return $this->getPrimaryKey() === $obj->getPrimaryKey();
    }

    /**
     * Get the associative array of the virtual columns in this object
     *
     * @return array
     */
    public function getVirtualColumns()
    {
        return $this->virtualColumns;
    }

    /**
     * Checks the existence of a virtual column in this object
     *
     * @param  string  $name The virtual column name
     * @return boolean
     */
    public function hasVirtualColumn($name)
    {
        return array_key_exists($name, $this->virtualColumns);
    }

    /**
     * Get the value of a virtual column in this object
     *
     * @param  string $name The virtual column name
     * @return mixed
     *
     * @throws PropelException
     */
    public function getVirtualColumn($name)
    {
        if (!$this->hasVirtualColumn($name)) {
            throw new PropelException(sprintf('Cannot get value of inexistent virtual column %s.', $name));
        }

        return $this->virtualColumns[$name];
    }

    /**
     * Set the value of a virtual column in this object
     *
     * @param string $name  The virtual column name
     * @param mixed  $value The value to give to the virtual column
     *
     * @return $this|SProperties The current object, for fluid interface
     */
    public function setVirtualColumn($name, $value)
    {
        $this->virtualColumns[$name] = $value;

        return $this;
    }

    /**
     * Logs a message using Propel::log().
     *
     * @param  string  $msg
     * @param  int     $priority One of the Propel::LOG_* logging levels
     * @return boolean
     */
    protected function log($msg, $priority = Propel::LOG_INFO)
    {
        return Propel::log(get_class($this) . ': ' . $msg, $priority);
    }

    /**
     * Export the current object properties to a string, using a given parser format
     * <code>
     * $book = BookQuery::create()->findPk(9012);
     * echo $book->exportTo('JSON');
     *  => {"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param  mixed   $parser                 A AbstractParser instance, or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param  boolean $includeLazyLoadColumns (optional) Whether to include lazy load(ed) columns. Defaults to TRUE.
     * @return string  The exported data
     */
    public function exportTo($parser, $includeLazyLoadColumns = true)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        return $parser->fromArray($this->toArray(TableMap::TYPE_PHPNAME, $includeLazyLoadColumns, array(), true));
    }

    /**
     * Clean up internal collections prior to serializing
     * Avoids recursive loops that turn into segmentation faults when serializing
     */
    public function __sleep()
    {
        $this->clearAllReferences();

        return array_keys(get_object_vars($this));
    }

    /**
     * Get the [id] column value.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the [external_id] column value.
     *
     * @return string
     */
    public function getExternalId()
    {
        return $this->external_id;
    }

    /**
     * Get the [csv_name] column value.
     *
     * @return string
     */
    public function getCsvName()
    {
        return $this->csv_name;
    }

    /**
     * Get the [multiple] column value.
     *
     * @return boolean
     */
    public function getMultiple()
    {
        return $this->multiple;
    }

    /**
     * Get the [multiple] column value.
     *
     * @return boolean
     */
    public function isMultiple()
    {
        return $this->getMultiple();
    }

    /**
     * Get the [active] column value.
     *
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Get the [active] column value.
     *
     * @return boolean
     */
    public function isActive()
    {
        return $this->getActive();
    }

    /**
     * Get the [show_on_site] column value.
     *
     * @return boolean
     */
    public function getShowOnSite()
    {
        return $this->show_on_site;
    }

    /**
     * Get the [show_on_site] column value.
     *
     * @return boolean
     */
    public function isShowOnSite()
    {
        return $this->getShowOnSite();
    }

    /**
     * Get the [show_in_compare] column value.
     *
     * @return boolean
     */
    public function getShowInCompare()
    {
        return $this->show_in_compare;
    }

    /**
     * Get the [show_in_compare] column value.
     *
     * @return boolean
     */
    public function isShowInCompare()
    {
        return $this->getShowInCompare();
    }

    /**
     * Get the [show_in_filter] column value.
     *
     * @return boolean
     */
    public function getShowInFilter()
    {
        return $this->show_in_filter;
    }

    /**
     * Get the [show_in_filter] column value.
     *
     * @return boolean
     */
    public function isShowInFilter()
    {
        return $this->getShowInFilter();
    }

    /**
     * Get the [show_faq] column value.
     *
     * @return boolean
     */
    public function getShowFaq()
    {
        return $this->show_faq;
    }

    /**
     * Get the [show_faq] column value.
     *
     * @return boolean
     */
    public function isShowFaq()
    {
        return $this->getShowFaq();
    }

    /**
     * Get the [main_property] column value.
     *
     * @return boolean
     */
    public function getMainProperty()
    {
        return $this->main_property;
    }

    /**
     * Get the [main_property] column value.
     *
     * @return boolean
     */
    public function isMainProperty()
    {
        return $this->getMainProperty();
    }

    /**
     * Get the [position] column value.
     *
     * @return int
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return $this|\SProperties The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[SPropertiesTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [external_id] column.
     *
     * @param string $v new value
     * @return $this|\SProperties The current object (for fluent API support)
     */
    public function setExternalId($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->external_id !== $v) {
            $this->external_id = $v;
            $this->modifiedColumns[SPropertiesTableMap::COL_EXTERNAL_ID] = true;
        }

        return $this;
    } // setExternalId()

    /**
     * Set the value of [csv_name] column.
     *
     * @param string $v new value
     * @return $this|\SProperties The current object (for fluent API support)
     */
    public function setCsvName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->csv_name !== $v) {
            $this->csv_name = $v;
            $this->modifiedColumns[SPropertiesTableMap::COL_CSV_NAME] = true;
        }

        return $this;
    } // setCsvName()

    /**
     * Sets the value of the [multiple] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\SProperties The current object (for fluent API support)
     */
    public function setMultiple($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->multiple !== $v) {
            $this->multiple = $v;
            $this->modifiedColumns[SPropertiesTableMap::COL_MULTIPLE] = true;
        }

        return $this;
    } // setMultiple()

    /**
     * Sets the value of the [active] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\SProperties The current object (for fluent API support)
     */
    public function setActive($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->active !== $v) {
            $this->active = $v;
            $this->modifiedColumns[SPropertiesTableMap::COL_ACTIVE] = true;
        }

        return $this;
    } // setActive()

    /**
     * Sets the value of the [show_on_site] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\SProperties The current object (for fluent API support)
     */
    public function setShowOnSite($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->show_on_site !== $v) {
            $this->show_on_site = $v;
            $this->modifiedColumns[SPropertiesTableMap::COL_SHOW_ON_SITE] = true;
        }

        return $this;
    } // setShowOnSite()

    /**
     * Sets the value of the [show_in_compare] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\SProperties The current object (for fluent API support)
     */
    public function setShowInCompare($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->show_in_compare !== $v) {
            $this->show_in_compare = $v;
            $this->modifiedColumns[SPropertiesTableMap::COL_SHOW_IN_COMPARE] = true;
        }

        return $this;
    } // setShowInCompare()

    /**
     * Sets the value of the [show_in_filter] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\SProperties The current object (for fluent API support)
     */
    public function setShowInFilter($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->show_in_filter !== $v) {
            $this->show_in_filter = $v;
            $this->modifiedColumns[SPropertiesTableMap::COL_SHOW_IN_FILTER] = true;
        }

        return $this;
    } // setShowInFilter()

    /**
     * Sets the value of the [show_faq] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\SProperties The current object (for fluent API support)
     */
    public function setShowFaq($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->show_faq !== $v) {
            $this->show_faq = $v;
            $this->modifiedColumns[SPropertiesTableMap::COL_SHOW_FAQ] = true;
        }

        return $this;
    } // setShowFaq()

    /**
     * Sets the value of the [main_property] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\SProperties The current object (for fluent API support)
     */
    public function setMainProperty($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->main_property !== $v) {
            $this->main_property = $v;
            $this->modifiedColumns[SPropertiesTableMap::COL_MAIN_PROPERTY] = true;
        }

        return $this;
    } // setMainProperty()

    /**
     * Set the value of [position] column.
     *
     * @param int $v new value
     * @return $this|\SProperties The current object (for fluent API support)
     */
    public function setPosition($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->position !== $v) {
            $this->position = $v;
            $this->modifiedColumns[SPropertiesTableMap::COL_POSITION] = true;
        }

        return $this;
    } // setPosition()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
        // otherwise, everything was equal, so return TRUE
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array   $row       The row returned by DataFetcher->fetch().
     * @param int     $startcol  0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @param string  $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                  One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false, $indexType = TableMap::TYPE_NUM)
    {
        try {

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : SPropertiesTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : SPropertiesTableMap::translateFieldName('ExternalId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->external_id = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : SPropertiesTableMap::translateFieldName('CsvName', TableMap::TYPE_PHPNAME, $indexType)];
            $this->csv_name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : SPropertiesTableMap::translateFieldName('Multiple', TableMap::TYPE_PHPNAME, $indexType)];
            $this->multiple = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : SPropertiesTableMap::translateFieldName('Active', TableMap::TYPE_PHPNAME, $indexType)];
            $this->active = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : SPropertiesTableMap::translateFieldName('ShowOnSite', TableMap::TYPE_PHPNAME, $indexType)];
            $this->show_on_site = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : SPropertiesTableMap::translateFieldName('ShowInCompare', TableMap::TYPE_PHPNAME, $indexType)];
            $this->show_in_compare = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : SPropertiesTableMap::translateFieldName('ShowInFilter', TableMap::TYPE_PHPNAME, $indexType)];
            $this->show_in_filter = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : SPropertiesTableMap::translateFieldName('ShowFaq', TableMap::TYPE_PHPNAME, $indexType)];
            $this->show_faq = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : SPropertiesTableMap::translateFieldName('MainProperty', TableMap::TYPE_PHPNAME, $indexType)];
            $this->main_property = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 10 + $startcol : SPropertiesTableMap::translateFieldName('Position', TableMap::TYPE_PHPNAME, $indexType)];
            $this->position = (null !== $col) ? (int) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 11; // 11 = SPropertiesTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\SProperties'), 0, $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {
    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param      boolean $deep (optional) Whether to also de-associated any related objects.
     * @param      ConnectionInterface $con (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(SPropertiesTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildSPropertiesQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collSPropertiesI18ns = null;

            $this->collShopProductPropertiesCategoriess = null;

            $this->collSProductPropertiesDatas = null;

            $this->collPropertyCategories = null;
        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see SProperties::setDeleted()
     * @see SProperties::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(SPropertiesTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildSPropertiesQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $this->setDeleted(true);
            }
        });
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see doSave()
     */
    public function save(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(SPropertiesTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $isInsert = $this->isNew();
            $ret = $this->preSave($con);
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
            } else {
                $ret = $ret && $this->preUpdate($con);
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                SPropertiesTableMap::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }

            return $affectedRows;
        });
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see save()
     */
    protected function doSave(ConnectionInterface $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                    $affectedRows += 1;
                } else {
                    $affectedRows += $this->doUpdate($con);
                }
                $this->resetModified();
            }

            if ($this->propertyCategoriesScheduledForDeletion !== null) {
                if (!$this->propertyCategoriesScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    foreach ($this->propertyCategoriesScheduledForDeletion as $entry) {
                        $entryPk = [];

                        $entryPk[0] = $this->getId();
                        $entryPk[1] = $entry->getId();
                        $pks[] = $entryPk;
                    }

                    \ShopProductPropertiesCategoriesQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);

                    $this->propertyCategoriesScheduledForDeletion = null;
                }

            }

            if ($this->collPropertyCategories) {
                foreach ($this->collPropertyCategories as $propertyCategory) {
                    if (!$propertyCategory->isDeleted() && ($propertyCategory->isNew() || $propertyCategory->isModified())) {
                        $propertyCategory->save($con);
                    }
                }
            }


            if ($this->sPropertiesI18nsScheduledForDeletion !== null) {
                if (!$this->sPropertiesI18nsScheduledForDeletion->isEmpty()) {
                    \SPropertiesI18nQuery::create()
                        ->filterByPrimaryKeys($this->sPropertiesI18nsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->sPropertiesI18nsScheduledForDeletion = null;
                }
            }

            if ($this->collSPropertiesI18ns !== null) {
                foreach ($this->collSPropertiesI18ns as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->shopProductPropertiesCategoriessScheduledForDeletion !== null) {
                if (!$this->shopProductPropertiesCategoriessScheduledForDeletion->isEmpty()) {
                    \ShopProductPropertiesCategoriesQuery::create()
                        ->filterByPrimaryKeys($this->shopProductPropertiesCategoriessScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->shopProductPropertiesCategoriessScheduledForDeletion = null;
                }
            }

            if ($this->collShopProductPropertiesCategoriess !== null) {
                foreach ($this->collShopProductPropertiesCategoriess as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->sProductPropertiesDatasScheduledForDeletion !== null) {
                if (!$this->sProductPropertiesDatasScheduledForDeletion->isEmpty()) {
                    \SProductPropertiesDataQuery::create()
                        ->filterByPrimaryKeys($this->sProductPropertiesDatasScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->sProductPropertiesDatasScheduledForDeletion = null;
                }
            }

            if ($this->collSProductPropertiesDatas !== null) {
                foreach ($this->collSProductPropertiesDatas as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @throws PropelException
     * @see doSave()
     */
    protected function doInsert(ConnectionInterface $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[SPropertiesTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . SPropertiesTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(SPropertiesTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(SPropertiesTableMap::COL_EXTERNAL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'external_id';
        }
        if ($this->isColumnModified(SPropertiesTableMap::COL_CSV_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'csv_name';
        }
        if ($this->isColumnModified(SPropertiesTableMap::COL_MULTIPLE)) {
            $modifiedColumns[':p' . $index++]  = 'multiple';
        }
        if ($this->isColumnModified(SPropertiesTableMap::COL_ACTIVE)) {
            $modifiedColumns[':p' . $index++]  = 'active';
        }
        if ($this->isColumnModified(SPropertiesTableMap::COL_SHOW_ON_SITE)) {
            $modifiedColumns[':p' . $index++]  = 'show_on_site';
        }
        if ($this->isColumnModified(SPropertiesTableMap::COL_SHOW_IN_COMPARE)) {
            $modifiedColumns[':p' . $index++]  = 'show_in_compare';
        }
        if ($this->isColumnModified(SPropertiesTableMap::COL_SHOW_IN_FILTER)) {
            $modifiedColumns[':p' . $index++]  = 'show_in_filter';
        }
        if ($this->isColumnModified(SPropertiesTableMap::COL_SHOW_FAQ)) {
            $modifiedColumns[':p' . $index++]  = 'show_faq';
        }
        if ($this->isColumnModified(SPropertiesTableMap::COL_MAIN_PROPERTY)) {
            $modifiedColumns[':p' . $index++]  = 'main_property';
        }
        if ($this->isColumnModified(SPropertiesTableMap::COL_POSITION)) {
            $modifiedColumns[':p' . $index++]  = 'position';
        }

        $sql = sprintf(
            'INSERT INTO shop_product_properties (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'id':
                        $stmt->bindValue($identifier, $this->id, PDO::PARAM_INT);
                        break;
                    case 'external_id':
                        $stmt->bindValue($identifier, $this->external_id, PDO::PARAM_STR);
                        break;
                    case 'csv_name':
                        $stmt->bindValue($identifier, $this->csv_name, PDO::PARAM_STR);
                        break;
                    case 'multiple':
                        $stmt->bindValue($identifier, (int) $this->multiple, PDO::PARAM_INT);
                        break;
                    case 'active':
                        $stmt->bindValue($identifier, (int) $this->active, PDO::PARAM_INT);
                        break;
                    case 'show_on_site':
                        $stmt->bindValue($identifier, (int) $this->show_on_site, PDO::PARAM_INT);
                        break;
                    case 'show_in_compare':
                        $stmt->bindValue($identifier, (int) $this->show_in_compare, PDO::PARAM_INT);
                        break;
                    case 'show_in_filter':
                        $stmt->bindValue($identifier, (int) $this->show_in_filter, PDO::PARAM_INT);
                        break;
                    case 'show_faq':
                        $stmt->bindValue($identifier, (int) $this->show_faq, PDO::PARAM_INT);
                        break;
                    case 'main_property':
                        $stmt->bindValue($identifier, (int) $this->main_property, PDO::PARAM_INT);
                        break;
                    case 'position':
                        $stmt->bindValue($identifier, $this->position, PDO::PARAM_INT);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', 0, $e);
        }
        $this->setId($pk);

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @return Integer Number of updated rows
     * @see doSave()
     */
    protected function doUpdate(ConnectionInterface $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();

        return $selectCriteria->doUpdate($valuesCriteria, $con);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param      string $name name
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return mixed Value of field.
     */
    public function getByName($name, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = SPropertiesTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getId();
                break;
            case 1:
                return $this->getExternalId();
                break;
            case 2:
                return $this->getCsvName();
                break;
            case 3:
                return $this->getMultiple();
                break;
            case 4:
                return $this->getActive();
                break;
            case 5:
                return $this->getShowOnSite();
                break;
            case 6:
                return $this->getShowInCompare();
                break;
            case 7:
                return $this->getShowInFilter();
                break;
            case 8:
                return $this->getShowFaq();
                break;
            case 9:
                return $this->getMainProperty();
                break;
            case 10:
                return $this->getPosition();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     *                    TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                    Defaults to TableMap::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = TableMap::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {

        if (isset($alreadyDumpedObjects['SProperties'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['SProperties'][$this->hashCode()] = true;
        $keys = SPropertiesTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getExternalId(),
            $keys[2] => $this->getCsvName(),
            $keys[3] => $this->getMultiple(),
            $keys[4] => $this->getActive(),
            $keys[5] => $this->getShowOnSite(),
            $keys[6] => $this->getShowInCompare(),
            $keys[7] => $this->getShowInFilter(),
            $keys[8] => $this->getShowFaq(),
            $keys[9] => $this->getMainProperty(),
            $keys[10] => $this->getPosition(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->collSPropertiesI18ns) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'sPropertiesI18ns';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'shop_product_properties_i18ns';
                        break;
                    default:
                        $key = 'SPropertiesI18ns';
                }

                $result[$key] = $this->collSPropertiesI18ns->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collShopProductPropertiesCategoriess) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'shopProductPropertiesCategoriess';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'shop_product_properties_categoriess';
                        break;
                    default:
                        $key = 'ShopProductPropertiesCategoriess';
                }

                $result[$key] = $this->collShopProductPropertiesCategoriess->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collSProductPropertiesDatas) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'sProductPropertiesDatas';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'shop_product_properties_datas';
                        break;
                    default:
                        $key = 'SProductPropertiesDatas';
                }

                $result[$key] = $this->collSProductPropertiesDatas->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param  string $name
     * @param  mixed  $value field value
     * @param  string $type The type of fieldname the $name is of:
     *                one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                Defaults to TableMap::TYPE_PHPNAME.
     * @return $this|\SProperties
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = SPropertiesTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\SProperties
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setExternalId($value);
                break;
            case 2:
                $this->setCsvName($value);
                break;
            case 3:
                $this->setMultiple($value);
                break;
            case 4:
                $this->setActive($value);
                break;
            case 5:
                $this->setShowOnSite($value);
                break;
            case 6:
                $this->setShowInCompare($value);
                break;
            case 7:
                $this->setShowInFilter($value);
                break;
            case 8:
                $this->setShowFaq($value);
                break;
            case 9:
                $this->setMainProperty($value);
                break;
            case 10:
                $this->setPosition($value);
                break;
        } // switch()

        return $this;
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param      array  $arr     An array to populate the object from.
     * @param      string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = SPropertiesTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setExternalId($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setCsvName($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setMultiple($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setActive($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setShowOnSite($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setShowInCompare($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setShowInFilter($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setShowFaq($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setMainProperty($arr[$keys[9]]);
        }
        if (array_key_exists($keys[10], $arr)) {
            $this->setPosition($arr[$keys[10]]);
        }
    }

     /**
     * Populate the current object from a string, using a given parser format
     * <code>
     * $book = new Book();
     * $book->importFrom('JSON', '{"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param mixed $parser A AbstractParser instance,
     *                       or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param string $data The source data to import from
     * @param string $keyType The type of keys the array uses.
     *
     * @return $this|\SProperties The current object, for fluid interface
     */
    public function importFrom($parser, $data, $keyType = TableMap::TYPE_PHPNAME)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        $this->fromArray($parser->toArray($data), $keyType);

        return $this;
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(SPropertiesTableMap::DATABASE_NAME);

        if ($this->isColumnModified(SPropertiesTableMap::COL_ID)) {
            $criteria->add(SPropertiesTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(SPropertiesTableMap::COL_EXTERNAL_ID)) {
            $criteria->add(SPropertiesTableMap::COL_EXTERNAL_ID, $this->external_id);
        }
        if ($this->isColumnModified(SPropertiesTableMap::COL_CSV_NAME)) {
            $criteria->add(SPropertiesTableMap::COL_CSV_NAME, $this->csv_name);
        }
        if ($this->isColumnModified(SPropertiesTableMap::COL_MULTIPLE)) {
            $criteria->add(SPropertiesTableMap::COL_MULTIPLE, $this->multiple);
        }
        if ($this->isColumnModified(SPropertiesTableMap::COL_ACTIVE)) {
            $criteria->add(SPropertiesTableMap::COL_ACTIVE, $this->active);
        }
        if ($this->isColumnModified(SPropertiesTableMap::COL_SHOW_ON_SITE)) {
            $criteria->add(SPropertiesTableMap::COL_SHOW_ON_SITE, $this->show_on_site);
        }
        if ($this->isColumnModified(SPropertiesTableMap::COL_SHOW_IN_COMPARE)) {
            $criteria->add(SPropertiesTableMap::COL_SHOW_IN_COMPARE, $this->show_in_compare);
        }
        if ($this->isColumnModified(SPropertiesTableMap::COL_SHOW_IN_FILTER)) {
            $criteria->add(SPropertiesTableMap::COL_SHOW_IN_FILTER, $this->show_in_filter);
        }
        if ($this->isColumnModified(SPropertiesTableMap::COL_SHOW_FAQ)) {
            $criteria->add(SPropertiesTableMap::COL_SHOW_FAQ, $this->show_faq);
        }
        if ($this->isColumnModified(SPropertiesTableMap::COL_MAIN_PROPERTY)) {
            $criteria->add(SPropertiesTableMap::COL_MAIN_PROPERTY, $this->main_property);
        }
        if ($this->isColumnModified(SPropertiesTableMap::COL_POSITION)) {
            $criteria->add(SPropertiesTableMap::COL_POSITION, $this->position);
        }

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @throws LogicException if no primary key is defined
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = ChildSPropertiesQuery::create();
        $criteria->add(SPropertiesTableMap::COL_ID, $this->id);

        return $criteria;
    }

    /**
     * If the primary key is not null, return the hashcode of the
     * primary key. Otherwise, return the hash code of the object.
     *
     * @return int Hashcode
     */
    public function hashCode()
    {
        $validPk = null !== $this->getId();

        $validPrimaryKeyFKs = 0;
        $primaryKeyFKs = [];

        if ($validPk) {
            return crc32(json_encode($this->getPrimaryKey(), JSON_UNESCAPED_UNICODE));
        } elseif ($validPrimaryKeyFKs) {
            return crc32(json_encode($primaryKeyFKs, JSON_UNESCAPED_UNICODE));
        }

        return spl_object_hash($this);
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getId();
    }

    /**
     * Generic method to set the primary key (id column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \SProperties (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setExternalId($this->getExternalId());
        $copyObj->setCsvName($this->getCsvName());
        $copyObj->setMultiple($this->getMultiple());
        $copyObj->setActive($this->getActive());
        $copyObj->setShowOnSite($this->getShowOnSite());
        $copyObj->setShowInCompare($this->getShowInCompare());
        $copyObj->setShowInFilter($this->getShowInFilter());
        $copyObj->setShowFaq($this->getShowFaq());
        $copyObj->setMainProperty($this->getMainProperty());
        $copyObj->setPosition($this->getPosition());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getSPropertiesI18ns() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addSPropertiesI18n($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getShopProductPropertiesCategoriess() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addShopProductPropertiesCategories($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getSProductPropertiesDatas() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addSProductPropertiesData($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setId(NULL); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param  boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return \SProperties Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param      string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('SPropertiesI18n' == $relationName) {
            return $this->initSPropertiesI18ns();
        }
        if ('ShopProductPropertiesCategories' == $relationName) {
            return $this->initShopProductPropertiesCategoriess();
        }
        if ('SProductPropertiesData' == $relationName) {
            return $this->initSProductPropertiesDatas();
        }
    }

    /**
     * Clears out the collSPropertiesI18ns collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addSPropertiesI18ns()
     */
    public function clearSPropertiesI18ns()
    {
        $this->collSPropertiesI18ns = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collSPropertiesI18ns collection loaded partially.
     */
    public function resetPartialSPropertiesI18ns($v = true)
    {
        $this->collSPropertiesI18nsPartial = $v;
    }

    /**
     * Initializes the collSPropertiesI18ns collection.
     *
     * By default this just sets the collSPropertiesI18ns collection to an empty array (like clearcollSPropertiesI18ns());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initSPropertiesI18ns($overrideExisting = true)
    {
        if (null !== $this->collSPropertiesI18ns && !$overrideExisting) {
            return;
        }
        $this->collSPropertiesI18ns = new ObjectCollection();
        $this->collSPropertiesI18ns->setModel('\SPropertiesI18n');
    }

    /**
     * Gets an array of ChildSPropertiesI18n objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildSProperties is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildSPropertiesI18n[] List of ChildSPropertiesI18n objects
     * @throws PropelException
     */
    public function getSPropertiesI18ns(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collSPropertiesI18nsPartial && !$this->isNew();
        if (null === $this->collSPropertiesI18ns || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collSPropertiesI18ns) {
                // return empty collection
                $this->initSPropertiesI18ns();
            } else {
                $collSPropertiesI18ns = ChildSPropertiesI18nQuery::create(null, $criteria)
                    ->filterBySProperties($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collSPropertiesI18nsPartial && count($collSPropertiesI18ns)) {
                        $this->initSPropertiesI18ns(false);

                        foreach ($collSPropertiesI18ns as $obj) {
                            if (false == $this->collSPropertiesI18ns->contains($obj)) {
                                $this->collSPropertiesI18ns->append($obj);
                            }
                        }

                        $this->collSPropertiesI18nsPartial = true;
                    }

                    return $collSPropertiesI18ns;
                }

                if ($partial && $this->collSPropertiesI18ns) {
                    foreach ($this->collSPropertiesI18ns as $obj) {
                        if ($obj->isNew()) {
                            $collSPropertiesI18ns[] = $obj;
                        }
                    }
                }

                $this->collSPropertiesI18ns = $collSPropertiesI18ns;
                $this->collSPropertiesI18nsPartial = false;
            }
        }

        return $this->collSPropertiesI18ns;
    }

    /**
     * Sets a collection of ChildSPropertiesI18n objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $sPropertiesI18ns A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildSProperties The current object (for fluent API support)
     */
    public function setSPropertiesI18ns(Collection $sPropertiesI18ns, ConnectionInterface $con = null)
    {
        /** @var ChildSPropertiesI18n[] $sPropertiesI18nsToDelete */
        $sPropertiesI18nsToDelete = $this->getSPropertiesI18ns(new Criteria(), $con)->diff($sPropertiesI18ns);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->sPropertiesI18nsScheduledForDeletion = clone $sPropertiesI18nsToDelete;

        foreach ($sPropertiesI18nsToDelete as $sPropertiesI18nRemoved) {
            $sPropertiesI18nRemoved->setSProperties(null);
        }

        $this->collSPropertiesI18ns = null;
        foreach ($sPropertiesI18ns as $sPropertiesI18n) {
            $this->addSPropertiesI18n($sPropertiesI18n);
        }

        $this->collSPropertiesI18ns = $sPropertiesI18ns;
        $this->collSPropertiesI18nsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related SPropertiesI18n objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related SPropertiesI18n objects.
     * @throws PropelException
     */
    public function countSPropertiesI18ns(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collSPropertiesI18nsPartial && !$this->isNew();
        if (null === $this->collSPropertiesI18ns || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collSPropertiesI18ns) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getSPropertiesI18ns());
            }

            $query = ChildSPropertiesI18nQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterBySProperties($this)
                ->count($con);
        }

        return count($this->collSPropertiesI18ns);
    }

    /**
     * Method called to associate a ChildSPropertiesI18n object to this object
     * through the ChildSPropertiesI18n foreign key attribute.
     *
     * @param  ChildSPropertiesI18n $l ChildSPropertiesI18n
     * @return $this|\SProperties The current object (for fluent API support)
     */
    public function addSPropertiesI18n(ChildSPropertiesI18n $l)
    {
        if ($l && $locale = $l->getLocale()) {
            $this->setLocale($locale);
            $this->currentTranslations[$locale] = $l;
        }
        if ($this->collSPropertiesI18ns === null) {
            $this->initSPropertiesI18ns();
            $this->collSPropertiesI18nsPartial = true;
        }

        if (!$this->collSPropertiesI18ns->contains($l)) {
            $this->doAddSPropertiesI18n($l);
        }

        return $this;
    }

    /**
     * @param ChildSPropertiesI18n $sPropertiesI18n The ChildSPropertiesI18n object to add.
     */
    protected function doAddSPropertiesI18n(ChildSPropertiesI18n $sPropertiesI18n)
    {
        $this->collSPropertiesI18ns[]= $sPropertiesI18n;
        $sPropertiesI18n->setSProperties($this);
    }

    /**
     * @param  ChildSPropertiesI18n $sPropertiesI18n The ChildSPropertiesI18n object to remove.
     * @return $this|ChildSProperties The current object (for fluent API support)
     */
    public function removeSPropertiesI18n(ChildSPropertiesI18n $sPropertiesI18n)
    {
        if ($this->getSPropertiesI18ns()->contains($sPropertiesI18n)) {
            $pos = $this->collSPropertiesI18ns->search($sPropertiesI18n);
            $this->collSPropertiesI18ns->remove($pos);
            if (null === $this->sPropertiesI18nsScheduledForDeletion) {
                $this->sPropertiesI18nsScheduledForDeletion = clone $this->collSPropertiesI18ns;
                $this->sPropertiesI18nsScheduledForDeletion->clear();
            }
            $this->sPropertiesI18nsScheduledForDeletion[]= clone $sPropertiesI18n;
            $sPropertiesI18n->setSProperties(null);
        }

        return $this;
    }

    /**
     * Clears out the collShopProductPropertiesCategoriess collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addShopProductPropertiesCategoriess()
     */
    public function clearShopProductPropertiesCategoriess()
    {
        $this->collShopProductPropertiesCategoriess = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collShopProductPropertiesCategoriess collection loaded partially.
     */
    public function resetPartialShopProductPropertiesCategoriess($v = true)
    {
        $this->collShopProductPropertiesCategoriessPartial = $v;
    }

    /**
     * Initializes the collShopProductPropertiesCategoriess collection.
     *
     * By default this just sets the collShopProductPropertiesCategoriess collection to an empty array (like clearcollShopProductPropertiesCategoriess());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initShopProductPropertiesCategoriess($overrideExisting = true)
    {
        if (null !== $this->collShopProductPropertiesCategoriess && !$overrideExisting) {
            return;
        }
        $this->collShopProductPropertiesCategoriess = new ObjectCollection();
        $this->collShopProductPropertiesCategoriess->setModel('\ShopProductPropertiesCategories');
    }

    /**
     * Gets an array of ChildShopProductPropertiesCategories objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildSProperties is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildShopProductPropertiesCategories[] List of ChildShopProductPropertiesCategories objects
     * @throws PropelException
     */
    public function getShopProductPropertiesCategoriess(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collShopProductPropertiesCategoriessPartial && !$this->isNew();
        if (null === $this->collShopProductPropertiesCategoriess || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collShopProductPropertiesCategoriess) {
                // return empty collection
                $this->initShopProductPropertiesCategoriess();
            } else {
                $collShopProductPropertiesCategoriess = ChildShopProductPropertiesCategoriesQuery::create(null, $criteria)
                    ->filterByProperty($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collShopProductPropertiesCategoriessPartial && count($collShopProductPropertiesCategoriess)) {
                        $this->initShopProductPropertiesCategoriess(false);

                        foreach ($collShopProductPropertiesCategoriess as $obj) {
                            if (false == $this->collShopProductPropertiesCategoriess->contains($obj)) {
                                $this->collShopProductPropertiesCategoriess->append($obj);
                            }
                        }

                        $this->collShopProductPropertiesCategoriessPartial = true;
                    }

                    return $collShopProductPropertiesCategoriess;
                }

                if ($partial && $this->collShopProductPropertiesCategoriess) {
                    foreach ($this->collShopProductPropertiesCategoriess as $obj) {
                        if ($obj->isNew()) {
                            $collShopProductPropertiesCategoriess[] = $obj;
                        }
                    }
                }

                $this->collShopProductPropertiesCategoriess = $collShopProductPropertiesCategoriess;
                $this->collShopProductPropertiesCategoriessPartial = false;
            }
        }

        return $this->collShopProductPropertiesCategoriess;
    }

    /**
     * Sets a collection of ChildShopProductPropertiesCategories objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $shopProductPropertiesCategoriess A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildSProperties The current object (for fluent API support)
     */
    public function setShopProductPropertiesCategoriess(Collection $shopProductPropertiesCategoriess, ConnectionInterface $con = null)
    {
        /** @var ChildShopProductPropertiesCategories[] $shopProductPropertiesCategoriessToDelete */
        $shopProductPropertiesCategoriessToDelete = $this->getShopProductPropertiesCategoriess(new Criteria(), $con)->diff($shopProductPropertiesCategoriess);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->shopProductPropertiesCategoriessScheduledForDeletion = clone $shopProductPropertiesCategoriessToDelete;

        foreach ($shopProductPropertiesCategoriessToDelete as $shopProductPropertiesCategoriesRemoved) {
            $shopProductPropertiesCategoriesRemoved->setProperty(null);
        }

        $this->collShopProductPropertiesCategoriess = null;
        foreach ($shopProductPropertiesCategoriess as $shopProductPropertiesCategories) {
            $this->addShopProductPropertiesCategories($shopProductPropertiesCategories);
        }

        $this->collShopProductPropertiesCategoriess = $shopProductPropertiesCategoriess;
        $this->collShopProductPropertiesCategoriessPartial = false;

        return $this;
    }

    /**
     * Returns the number of related ShopProductPropertiesCategories objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related ShopProductPropertiesCategories objects.
     * @throws PropelException
     */
    public function countShopProductPropertiesCategoriess(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collShopProductPropertiesCategoriessPartial && !$this->isNew();
        if (null === $this->collShopProductPropertiesCategoriess || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collShopProductPropertiesCategoriess) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getShopProductPropertiesCategoriess());
            }

            $query = ChildShopProductPropertiesCategoriesQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByProperty($this)
                ->count($con);
        }

        return count($this->collShopProductPropertiesCategoriess);
    }

    /**
     * Method called to associate a ChildShopProductPropertiesCategories object to this object
     * through the ChildShopProductPropertiesCategories foreign key attribute.
     *
     * @param  ChildShopProductPropertiesCategories $l ChildShopProductPropertiesCategories
     * @return $this|\SProperties The current object (for fluent API support)
     */
    public function addShopProductPropertiesCategories(ChildShopProductPropertiesCategories $l)
    {
        if ($this->collShopProductPropertiesCategoriess === null) {
            $this->initShopProductPropertiesCategoriess();
            $this->collShopProductPropertiesCategoriessPartial = true;
        }

        if (!$this->collShopProductPropertiesCategoriess->contains($l)) {
            $this->doAddShopProductPropertiesCategories($l);
        }

        return $this;
    }

    /**
     * @param ChildShopProductPropertiesCategories $shopProductPropertiesCategories The ChildShopProductPropertiesCategories object to add.
     */
    protected function doAddShopProductPropertiesCategories(ChildShopProductPropertiesCategories $shopProductPropertiesCategories)
    {
        $this->collShopProductPropertiesCategoriess[]= $shopProductPropertiesCategories;
        $shopProductPropertiesCategories->setProperty($this);
    }

    /**
     * @param  ChildShopProductPropertiesCategories $shopProductPropertiesCategories The ChildShopProductPropertiesCategories object to remove.
     * @return $this|ChildSProperties The current object (for fluent API support)
     */
    public function removeShopProductPropertiesCategories(ChildShopProductPropertiesCategories $shopProductPropertiesCategories)
    {
        if ($this->getShopProductPropertiesCategoriess()->contains($shopProductPropertiesCategories)) {
            $pos = $this->collShopProductPropertiesCategoriess->search($shopProductPropertiesCategories);
            $this->collShopProductPropertiesCategoriess->remove($pos);
            if (null === $this->shopProductPropertiesCategoriessScheduledForDeletion) {
                $this->shopProductPropertiesCategoriessScheduledForDeletion = clone $this->collShopProductPropertiesCategoriess;
                $this->shopProductPropertiesCategoriessScheduledForDeletion->clear();
            }
            $this->shopProductPropertiesCategoriessScheduledForDeletion[]= clone $shopProductPropertiesCategories;
            $shopProductPropertiesCategories->setProperty(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this SProperties is new, it will return
     * an empty collection; or if this SProperties has previously
     * been saved, it will retrieve related ShopProductPropertiesCategoriess from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in SProperties.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildShopProductPropertiesCategories[] List of ChildShopProductPropertiesCategories objects
     */
    public function getShopProductPropertiesCategoriessJoinPropertyCategory(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildShopProductPropertiesCategoriesQuery::create(null, $criteria);
        $query->joinWith('PropertyCategory', $joinBehavior);

        return $this->getShopProductPropertiesCategoriess($query, $con);
    }

    /**
     * Clears out the collSProductPropertiesDatas collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addSProductPropertiesDatas()
     */
    public function clearSProductPropertiesDatas()
    {
        $this->collSProductPropertiesDatas = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collSProductPropertiesDatas collection loaded partially.
     */
    public function resetPartialSProductPropertiesDatas($v = true)
    {
        $this->collSProductPropertiesDatasPartial = $v;
    }

    /**
     * Initializes the collSProductPropertiesDatas collection.
     *
     * By default this just sets the collSProductPropertiesDatas collection to an empty array (like clearcollSProductPropertiesDatas());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initSProductPropertiesDatas($overrideExisting = true)
    {
        if (null !== $this->collSProductPropertiesDatas && !$overrideExisting) {
            return;
        }
        $this->collSProductPropertiesDatas = new ObjectCollection();
        $this->collSProductPropertiesDatas->setModel('\SProductPropertiesData');
    }

    /**
     * Gets an array of ChildSProductPropertiesData objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildSProperties is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildSProductPropertiesData[] List of ChildSProductPropertiesData objects
     * @throws PropelException
     */
    public function getSProductPropertiesDatas(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collSProductPropertiesDatasPartial && !$this->isNew();
        if (null === $this->collSProductPropertiesDatas || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collSProductPropertiesDatas) {
                // return empty collection
                $this->initSProductPropertiesDatas();
            } else {
                $collSProductPropertiesDatas = ChildSProductPropertiesDataQuery::create(null, $criteria)
                    ->filterBySProperties($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collSProductPropertiesDatasPartial && count($collSProductPropertiesDatas)) {
                        $this->initSProductPropertiesDatas(false);

                        foreach ($collSProductPropertiesDatas as $obj) {
                            if (false == $this->collSProductPropertiesDatas->contains($obj)) {
                                $this->collSProductPropertiesDatas->append($obj);
                            }
                        }

                        $this->collSProductPropertiesDatasPartial = true;
                    }

                    return $collSProductPropertiesDatas;
                }

                if ($partial && $this->collSProductPropertiesDatas) {
                    foreach ($this->collSProductPropertiesDatas as $obj) {
                        if ($obj->isNew()) {
                            $collSProductPropertiesDatas[] = $obj;
                        }
                    }
                }

                $this->collSProductPropertiesDatas = $collSProductPropertiesDatas;
                $this->collSProductPropertiesDatasPartial = false;
            }
        }

        return $this->collSProductPropertiesDatas;
    }

    /**
     * Sets a collection of ChildSProductPropertiesData objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $sProductPropertiesDatas A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildSProperties The current object (for fluent API support)
     */
    public function setSProductPropertiesDatas(Collection $sProductPropertiesDatas, ConnectionInterface $con = null)
    {
        /** @var ChildSProductPropertiesData[] $sProductPropertiesDatasToDelete */
        $sProductPropertiesDatasToDelete = $this->getSProductPropertiesDatas(new Criteria(), $con)->diff($sProductPropertiesDatas);


        $this->sProductPropertiesDatasScheduledForDeletion = $sProductPropertiesDatasToDelete;

        foreach ($sProductPropertiesDatasToDelete as $sProductPropertiesDataRemoved) {
            $sProductPropertiesDataRemoved->setSProperties(null);
        }

        $this->collSProductPropertiesDatas = null;
        foreach ($sProductPropertiesDatas as $sProductPropertiesData) {
            $this->addSProductPropertiesData($sProductPropertiesData);
        }

        $this->collSProductPropertiesDatas = $sProductPropertiesDatas;
        $this->collSProductPropertiesDatasPartial = false;

        return $this;
    }

    /**
     * Returns the number of related SProductPropertiesData objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related SProductPropertiesData objects.
     * @throws PropelException
     */
    public function countSProductPropertiesDatas(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collSProductPropertiesDatasPartial && !$this->isNew();
        if (null === $this->collSProductPropertiesDatas || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collSProductPropertiesDatas) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getSProductPropertiesDatas());
            }

            $query = ChildSProductPropertiesDataQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterBySProperties($this)
                ->count($con);
        }

        return count($this->collSProductPropertiesDatas);
    }

    /**
     * Method called to associate a ChildSProductPropertiesData object to this object
     * through the ChildSProductPropertiesData foreign key attribute.
     *
     * @param  ChildSProductPropertiesData $l ChildSProductPropertiesData
     * @return $this|\SProperties The current object (for fluent API support)
     */
    public function addSProductPropertiesData(ChildSProductPropertiesData $l)
    {
        if ($this->collSProductPropertiesDatas === null) {
            $this->initSProductPropertiesDatas();
            $this->collSProductPropertiesDatasPartial = true;
        }

        if (!$this->collSProductPropertiesDatas->contains($l)) {
            $this->doAddSProductPropertiesData($l);
        }

        return $this;
    }

    /**
     * @param ChildSProductPropertiesData $sProductPropertiesData The ChildSProductPropertiesData object to add.
     */
    protected function doAddSProductPropertiesData(ChildSProductPropertiesData $sProductPropertiesData)
    {
        $this->collSProductPropertiesDatas[]= $sProductPropertiesData;
        $sProductPropertiesData->setSProperties($this);
    }

    /**
     * @param  ChildSProductPropertiesData $sProductPropertiesData The ChildSProductPropertiesData object to remove.
     * @return $this|ChildSProperties The current object (for fluent API support)
     */
    public function removeSProductPropertiesData(ChildSProductPropertiesData $sProductPropertiesData)
    {
        if ($this->getSProductPropertiesDatas()->contains($sProductPropertiesData)) {
            $pos = $this->collSProductPropertiesDatas->search($sProductPropertiesData);
            $this->collSProductPropertiesDatas->remove($pos);
            if (null === $this->sProductPropertiesDatasScheduledForDeletion) {
                $this->sProductPropertiesDatasScheduledForDeletion = clone $this->collSProductPropertiesDatas;
                $this->sProductPropertiesDatasScheduledForDeletion->clear();
            }
            $this->sProductPropertiesDatasScheduledForDeletion[]= $sProductPropertiesData;
            $sProductPropertiesData->setSProperties(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this SProperties is new, it will return
     * an empty collection; or if this SProperties has previously
     * been saved, it will retrieve related SProductPropertiesDatas from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in SProperties.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildSProductPropertiesData[] List of ChildSProductPropertiesData objects
     */
    public function getSProductPropertiesDatasJoinProduct(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildSProductPropertiesDataQuery::create(null, $criteria);
        $query->joinWith('Product', $joinBehavior);

        return $this->getSProductPropertiesDatas($query, $con);
    }

    /**
     * Clears out the collPropertyCategories collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addPropertyCategories()
     */
    public function clearPropertyCategories()
    {
        $this->collPropertyCategories = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Initializes the collPropertyCategories crossRef collection.
     *
     * By default this just sets the collPropertyCategories collection to an empty collection (like clearPropertyCategories());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initPropertyCategories()
    {
        $this->collPropertyCategories = new ObjectCollection();
        $this->collPropertyCategoriesPartial = true;

        $this->collPropertyCategories->setModel('\SCategory');
    }

    /**
     * Checks if the collPropertyCategories collection is loaded.
     *
     * @return bool
     */
    public function isPropertyCategoriesLoaded()
    {
        return null !== $this->collPropertyCategories;
    }

    /**
     * Gets a collection of ChildSCategory objects related by a many-to-many relationship
     * to the current object by way of the shop_product_properties_categories cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildSProperties is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return ObjectCollection|ChildSCategory[] List of ChildSCategory objects
     */
    public function getPropertyCategories(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collPropertyCategoriesPartial && !$this->isNew();
        if (null === $this->collPropertyCategories || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collPropertyCategories) {
                    $this->initPropertyCategories();
                }
            } else {

                $query = ChildSCategoryQuery::create(null, $criteria)
                    ->filterByProperty($this);
                $collPropertyCategories = $query->find($con);
                if (null !== $criteria) {
                    return $collPropertyCategories;
                }

                if ($partial && $this->collPropertyCategories) {
                    //make sure that already added objects gets added to the list of the database.
                    foreach ($this->collPropertyCategories as $obj) {
                        if (!$collPropertyCategories->contains($obj)) {
                            $collPropertyCategories[] = $obj;
                        }
                    }
                }

                $this->collPropertyCategories = $collPropertyCategories;
                $this->collPropertyCategoriesPartial = false;
            }
        }

        return $this->collPropertyCategories;
    }

    /**
     * Sets a collection of SCategory objects related by a many-to-many relationship
     * to the current object by way of the shop_product_properties_categories cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param  Collection $propertyCategories A Propel collection.
     * @param  ConnectionInterface $con Optional connection object
     * @return $this|ChildSProperties The current object (for fluent API support)
     */
    public function setPropertyCategories(Collection $propertyCategories, ConnectionInterface $con = null)
    {
        $this->clearPropertyCategories();
        $currentPropertyCategories = $this->getPropertyCategories();

        $propertyCategoriesScheduledForDeletion = $currentPropertyCategories->diff($propertyCategories);

        foreach ($propertyCategoriesScheduledForDeletion as $toDelete) {
            $this->removePropertyCategory($toDelete);
        }

        foreach ($propertyCategories as $propertyCategory) {
            if (!$currentPropertyCategories->contains($propertyCategory)) {
                $this->doAddPropertyCategory($propertyCategory);
            }
        }

        $this->collPropertyCategoriesPartial = false;
        $this->collPropertyCategories = $propertyCategories;

        return $this;
    }

    /**
     * Gets the number of SCategory objects related by a many-to-many relationship
     * to the current object by way of the shop_product_properties_categories cross-reference table.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      boolean $distinct Set to true to force count distinct
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return int the number of related SCategory objects
     */
    public function countPropertyCategories(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collPropertyCategoriesPartial && !$this->isNew();
        if (null === $this->collPropertyCategories || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPropertyCategories) {
                return 0;
            } else {

                if ($partial && !$criteria) {
                    return count($this->getPropertyCategories());
                }

                $query = ChildSCategoryQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByProperty($this)
                    ->count($con);
            }
        } else {
            return count($this->collPropertyCategories);
        }
    }

    /**
     * Associate a ChildSCategory to this object
     * through the shop_product_properties_categories cross reference table.
     *
     * @param ChildSCategory $propertyCategory
     * @return ChildSProperties The current object (for fluent API support)
     */
    public function addPropertyCategory(ChildSCategory $propertyCategory)
    {
        if ($this->collPropertyCategories === null) {
            $this->initPropertyCategories();
        }

        if (!$this->getPropertyCategories()->contains($propertyCategory)) {
            // only add it if the **same** object is not already associated
            $this->collPropertyCategories->push($propertyCategory);
            $this->doAddPropertyCategory($propertyCategory);
        }

        return $this;
    }

    /**
     *
     * @param ChildSCategory $propertyCategory
     */
    protected function doAddPropertyCategory(ChildSCategory $propertyCategory)
    {
        $shopProductPropertiesCategories = new ChildShopProductPropertiesCategories();

        $shopProductPropertiesCategories->setPropertyCategory($propertyCategory);

        $shopProductPropertiesCategories->setProperty($this);

        $this->addShopProductPropertiesCategories($shopProductPropertiesCategories);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if (!$propertyCategory->isPropertiesLoaded()) {
            $propertyCategory->initProperties();
            $propertyCategory->getProperties()->push($this);
        } elseif (!$propertyCategory->getProperties()->contains($this)) {
            $propertyCategory->getProperties()->push($this);
        }

    }

    /**
     * Remove propertyCategory of this object
     * through the shop_product_properties_categories cross reference table.
     *
     * @param ChildSCategory $propertyCategory
     * @return ChildSProperties The current object (for fluent API support)
     */
    public function removePropertyCategory(ChildSCategory $propertyCategory)
    {
        if ($this->getPropertyCategories()->contains($propertyCategory)) { $shopProductPropertiesCategories = new ChildShopProductPropertiesCategories();

            $shopProductPropertiesCategories->setPropertyCategory($propertyCategory);
            if ($propertyCategory->isPropertiesLoaded()) {
                //remove the back reference if available
                $propertyCategory->getProperties()->removeObject($this);
            }

            $shopProductPropertiesCategories->setProperty($this);
            $this->removeShopProductPropertiesCategories(clone $shopProductPropertiesCategories);
            $shopProductPropertiesCategories->clear();

            $this->collPropertyCategories->remove($this->collPropertyCategories->search($propertyCategory));

            if (null === $this->propertyCategoriesScheduledForDeletion) {
                $this->propertyCategoriesScheduledForDeletion = clone $this->collPropertyCategories;
                $this->propertyCategoriesScheduledForDeletion->clear();
            }

            $this->propertyCategoriesScheduledForDeletion->push($propertyCategory);
        }


        return $this;
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        $this->id = null;
        $this->external_id = null;
        $this->csv_name = null;
        $this->multiple = null;
        $this->active = null;
        $this->show_on_site = null;
        $this->show_in_compare = null;
        $this->show_in_filter = null;
        $this->show_faq = null;
        $this->main_property = null;
        $this->position = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references and back-references to other model objects or collections of model objects.
     *
     * This method is used to reset all php object references (not the actual reference in the database).
     * Necessary for object serialisation.
     *
     * @param      boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep) {
            if ($this->collSPropertiesI18ns) {
                foreach ($this->collSPropertiesI18ns as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collShopProductPropertiesCategoriess) {
                foreach ($this->collShopProductPropertiesCategoriess as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collSProductPropertiesDatas) {
                foreach ($this->collSProductPropertiesDatas as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collPropertyCategories) {
                foreach ($this->collPropertyCategories as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        // i18n behavior
        $this->currentLocale = 'ru';
        $this->currentTranslations = null;

        $this->collSPropertiesI18ns = null;
        $this->collShopProductPropertiesCategoriess = null;
        $this->collSProductPropertiesDatas = null;
        $this->collPropertyCategories = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(SPropertiesTableMap::DEFAULT_STRING_FORMAT);
    }

    // i18n behavior

    /**
     * Sets the locale for translations
     *
     * @param     string $locale Locale to use for the translation, e.g. 'fr_FR'
     *
     * @return    $this|ChildSProperties The current object (for fluent API support)
     */
    public function setLocale($locale = 'ru')
    {
        $this->currentLocale = $locale;

        return $this;
    }

    /**
     * Gets the locale for translations
     *
     * @return    string $locale Locale to use for the translation, e.g. 'fr_FR'
     */
    public function getLocale()
    {
        return $this->currentLocale;
    }

    /**
     * Returns the current translation for a given locale
     *
     * @param     string $locale Locale to use for the translation, e.g. 'fr_FR'
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ChildSPropertiesI18n */
    public function getTranslation($locale = 'ru', ConnectionInterface $con = null)
    {
        if (!isset($this->currentTranslations[$locale])) {
            if (null !== $this->collSPropertiesI18ns) {
                foreach ($this->collSPropertiesI18ns as $translation) {
                    if ($translation->getLocale() == $locale) {
                        $this->currentTranslations[$locale] = $translation;

                        return $translation;
                    }
                }
            }
            if ($this->isNew()) {
                $translation = new ChildSPropertiesI18n();
                $translation->setLocale($locale);
            } else {
                $translation = ChildSPropertiesI18nQuery::create()
                    ->filterByPrimaryKey(array($this->getPrimaryKey(), $locale))
                    ->findOneOrCreate($con);
                $this->currentTranslations[$locale] = $translation;
            }
            $this->addSPropertiesI18n($translation);
        }

        return $this->currentTranslations[$locale];
    }

    /**
     * Remove the translation for a given locale
     *
     * @param     string $locale Locale to use for the translation, e.g. 'fr_FR'
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return    $this|ChildSProperties The current object (for fluent API support)
     */
    public function removeTranslation($locale = 'ru', ConnectionInterface $con = null)
    {
        if (!$this->isNew()) {
            ChildSPropertiesI18nQuery::create()
                ->filterByPrimaryKey(array($this->getPrimaryKey(), $locale))
                ->delete($con);
        }
        if (isset($this->currentTranslations[$locale])) {
            unset($this->currentTranslations[$locale]);
        }
        foreach ($this->collSPropertiesI18ns as $key => $translation) {
            if ($translation->getLocale() == $locale) {
                unset($this->collSPropertiesI18ns[$key]);
                break;
            }
        }

        return $this;
    }

    /**
     * Returns the current translation
     *
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ChildSPropertiesI18n */
    public function getCurrentTranslation(ConnectionInterface $con = null)
    {
        return $this->getTranslation($this->getLocale(), $con);
    }


        /**
         * Get the [name] column value.
         *
         * @return string
         */
        public function getName()
        {
        return $this->getCurrentTranslation()->getName();
    }


        /**
         * Set the value of [name] column.
         *
         * @param string $v new value
         * @return $this|\SPropertiesI18n The current object (for fluent API support)
         */
        public function setName($v)
        {    $this->getCurrentTranslation()->setName($v);

        return $this;
    }


        /**
         * Get the [description] column value.
         *
         * @return string
         */
        public function getDescription()
        {
        return $this->getCurrentTranslation()->getDescription();
    }


        /**
         * Set the value of [description] column.
         *
         * @param string $v new value
         * @return $this|\SPropertiesI18n The current object (for fluent API support)
         */
        public function setDescription($v)
        {    $this->getCurrentTranslation()->setDescription($v);

        return $this;
    }

    /**
     * Code to be run before persisting the object
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preSave(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after persisting the object
     * @param ConnectionInterface $con
     */
    public function postSave(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before inserting to database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preInsert(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after inserting to database
     * @param ConnectionInterface $con
     */
    public function postInsert(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before updating the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preUpdate(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after updating the object in database
     * @param ConnectionInterface $con
     */
    public function postUpdate(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before deleting the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preDelete(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after deleting the object in database
     * @param ConnectionInterface $con
     */
    public function postDelete(ConnectionInterface $con = null)
    {

    }


    /**
     * Derived method to catches calls to undefined methods.
     *
     * Provides magic import/export method support (fromXML()/toXML(), fromYAML()/toYAML(), etc.).
     * Allows to define default __call() behavior if you overwrite __call()
     *
     * @param string $name
     * @param mixed  $params
     *
     * @return array|string
     */
    public function __call($name, $params)
    {
        if (0 === strpos($name, 'get')) {
            $virtualColumn = substr($name, 3);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }

            $virtualColumn = lcfirst($virtualColumn);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }
        }

        if (0 === strpos($name, 'from')) {
            $format = substr($name, 4);

            return $this->importFrom($format, reset($params));
        }

        if (0 === strpos($name, 'to')) {
            $format = substr($name, 2);
            $includeLazyLoadColumns = isset($params[0]) ? $params[0] : true;

            return $this->exportTo($format, $includeLazyLoadColumns);
        }

        throw new BadMethodCallException(sprintf('Call to undefined method: %s.', $name));
    }

}
