<?php

namespace Base;

use \SCategory as ChildSCategory;
use \SCategoryI18n as ChildSCategoryI18n;
use \SCategoryI18nQuery as ChildSCategoryI18nQuery;
use \SCategoryQuery as ChildSCategoryQuery;
use \SProducts as ChildSProducts;
use \SProductsQuery as ChildSProductsQuery;
use \SProperties as ChildSProperties;
use \SPropertiesQuery as ChildSPropertiesQuery;
use \ShopProductCategories as ChildShopProductCategories;
use \ShopProductCategoriesQuery as ChildShopProductCategoriesQuery;
use \ShopProductPropertiesCategories as ChildShopProductPropertiesCategories;
use \ShopProductPropertiesCategoriesQuery as ChildShopProductPropertiesCategoriesQuery;
use \Exception;
use \PDO;
use Map\SCategoryTableMap;
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
 * Base class that represents a row from the 'shop_category' table.
 *
 *
 *
* @package    propel.generator..Base
*/
abstract class SCategory extends PropelBaseModelClass implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\SCategoryTableMap';


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
     * The value for the parent_id field.
     * @var        int
     */
    protected $parent_id;

    /**
     * The value for the external_id field.
     * @var        string
     */
    protected $external_id;

    /**
     * The value for the url field.
     * @var        string
     */
    protected $url;

    /**
     * The value for the active field.
     * @var        boolean
     */
    protected $active;

    /**
     * The value for the image field.
     * @var        string
     */
    protected $image;

    /**
     * The value for the position field.
     * @var        int
     */
    protected $position;

    /**
     * The value for the full_path field.
     * @var        string
     */
    protected $full_path;

    /**
     * The value for the full_path_ids field.
     * @var        string
     */
    protected $full_path_ids;

    /**
     * The value for the tpl field.
     * @var        string
     */
    protected $tpl;

    /**
     * The value for the order_method field.
     * @var        int
     */
    protected $order_method;

    /**
     * The value for the showsitetitle field.
     * @var        int
     */
    protected $showsitetitle;

    /**
     * The value for the created field.
     * @var        int
     */
    protected $created;

    /**
     * The value for the updated field.
     * @var        int
     */
    protected $updated;

    /**
     * @var        ChildSCategory
     */
    protected $aSCategory;

    /**
     * @var        ObjectCollection|ChildSCategory[] Collection to store aggregation of ChildSCategory objects.
     */
    protected $collSCategoriesRelatedById;
    protected $collSCategoriesRelatedByIdPartial;

    /**
     * @var        ObjectCollection|ChildSCategoryI18n[] Collection to store aggregation of ChildSCategoryI18n objects.
     */
    protected $collSCategoryI18ns;
    protected $collSCategoryI18nsPartial;

    /**
     * @var        ObjectCollection|ChildSProducts[] Collection to store aggregation of ChildSProducts objects.
     */
    protected $collSProductss;
    protected $collSProductssPartial;

    /**
     * @var        ObjectCollection|ChildShopProductCategories[] Collection to store aggregation of ChildShopProductCategories objects.
     */
    protected $collShopProductCategoriess;
    protected $collShopProductCategoriessPartial;

    /**
     * @var        ObjectCollection|ChildShopProductPropertiesCategories[] Collection to store aggregation of ChildShopProductPropertiesCategories objects.
     */
    protected $collShopProductPropertiesCategoriess;
    protected $collShopProductPropertiesCategoriessPartial;

    /**
     * @var        ObjectCollection|ChildSProducts[] Cross Collection to store aggregation of ChildSProducts objects.
     */
    protected $collProducts;

    /**
     * @var bool
     */
    protected $collProductsPartial;

    /**
     * @var        ObjectCollection|ChildSProperties[] Cross Collection to store aggregation of ChildSProperties objects.
     */
    protected $collProperties;

    /**
     * @var bool
     */
    protected $collPropertiesPartial;

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
     * @var        array[ChildSCategoryI18n]
     */
    protected $currentTranslations;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildSProducts[]
     */
    protected $productsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildSProperties[]
     */
    protected $propertiesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildSCategory[]
     */
    protected $sCategoriesRelatedByIdScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildSCategoryI18n[]
     */
    protected $sCategoryI18nsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildSProducts[]
     */
    protected $sProductssScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildShopProductCategories[]
     */
    protected $shopProductCategoriessScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildShopProductPropertiesCategories[]
     */
    protected $shopProductPropertiesCategoriessScheduledForDeletion = null;

    /**
     * Initializes internal state of Base\SCategory object.
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
     * Compares this with another <code>SCategory</code> instance.  If
     * <code>obj</code> is an instance of <code>SCategory</code>, delegates to
     * <code>equals(SCategory)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|SCategory The current object, for fluid interface
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
     * Get the [parent_id] column value.
     *
     * @return int
     */
    public function getParentId()
    {
        return $this->parent_id;
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
     * Get the [url] column value.
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
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
     * Get the [image] column value.
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
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
     * Get the [full_path] column value.
     *
     * @return string
     */
    public function getFullPath()
    {
        return $this->full_path;
    }

    /**
     * Get the [full_path_ids] column value.
     *
     * @return string
     */
    public function getFullPathIds()
    {
        return $this->full_path_ids;
    }

    /**
     * Get the [tpl] column value.
     *
     * @return string
     */
    public function getTpl()
    {
        return $this->tpl;
    }

    /**
     * Get the [order_method] column value.
     *
     * @return int
     */
    public function getOrderMethod()
    {
        return $this->order_method;
    }

    /**
     * Get the [showsitetitle] column value.
     *
     * @return int
     */
    public function getShowsitetitle()
    {
        return $this->showsitetitle;
    }

    /**
     * Get the [created] column value.
     *
     * @return int
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Get the [updated] column value.
     *
     * @return int
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return $this|\SCategory The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[SCategoryTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [parent_id] column.
     *
     * @param int $v new value
     * @return $this|\SCategory The current object (for fluent API support)
     */
    public function setParentId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->parent_id !== $v) {
            $this->parent_id = $v;
            $this->modifiedColumns[SCategoryTableMap::COL_PARENT_ID] = true;
        }

        if ($this->aSCategory !== null && $this->aSCategory->getId() !== $v) {
            $this->aSCategory = null;
        }

        return $this;
    } // setParentId()

    /**
     * Set the value of [external_id] column.
     *
     * @param string $v new value
     * @return $this|\SCategory The current object (for fluent API support)
     */
    public function setExternalId($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->external_id !== $v) {
            $this->external_id = $v;
            $this->modifiedColumns[SCategoryTableMap::COL_EXTERNAL_ID] = true;
        }

        return $this;
    } // setExternalId()

    /**
     * Set the value of [url] column.
     *
     * @param string $v new value
     * @return $this|\SCategory The current object (for fluent API support)
     */
    public function setUrl($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->url !== $v) {
            $this->url = $v;
            $this->modifiedColumns[SCategoryTableMap::COL_URL] = true;
        }

        return $this;
    } // setUrl()

    /**
     * Sets the value of the [active] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\SCategory The current object (for fluent API support)
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
            $this->modifiedColumns[SCategoryTableMap::COL_ACTIVE] = true;
        }

        return $this;
    } // setActive()

    /**
     * Set the value of [image] column.
     *
     * @param string $v new value
     * @return $this|\SCategory The current object (for fluent API support)
     */
    public function setImage($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->image !== $v) {
            $this->image = $v;
            $this->modifiedColumns[SCategoryTableMap::COL_IMAGE] = true;
        }

        return $this;
    } // setImage()

    /**
     * Set the value of [position] column.
     *
     * @param int $v new value
     * @return $this|\SCategory The current object (for fluent API support)
     */
    public function setPosition($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->position !== $v) {
            $this->position = $v;
            $this->modifiedColumns[SCategoryTableMap::COL_POSITION] = true;
        }

        return $this;
    } // setPosition()

    /**
     * Set the value of [full_path] column.
     *
     * @param string $v new value
     * @return $this|\SCategory The current object (for fluent API support)
     */
    public function setFullPath($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->full_path !== $v) {
            $this->full_path = $v;
            $this->modifiedColumns[SCategoryTableMap::COL_FULL_PATH] = true;
        }

        return $this;
    } // setFullPath()

    /**
     * Set the value of [full_path_ids] column.
     *
     * @param string $v new value
     * @return $this|\SCategory The current object (for fluent API support)
     */
    public function setFullPathIds($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->full_path_ids !== $v) {
            $this->full_path_ids = $v;
            $this->modifiedColumns[SCategoryTableMap::COL_FULL_PATH_IDS] = true;
        }

        return $this;
    } // setFullPathIds()

    /**
     * Set the value of [tpl] column.
     *
     * @param string $v new value
     * @return $this|\SCategory The current object (for fluent API support)
     */
    public function setTpl($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->tpl !== $v) {
            $this->tpl = $v;
            $this->modifiedColumns[SCategoryTableMap::COL_TPL] = true;
        }

        return $this;
    } // setTpl()

    /**
     * Set the value of [order_method] column.
     *
     * @param int $v new value
     * @return $this|\SCategory The current object (for fluent API support)
     */
    public function setOrderMethod($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->order_method !== $v) {
            $this->order_method = $v;
            $this->modifiedColumns[SCategoryTableMap::COL_ORDER_METHOD] = true;
        }

        return $this;
    } // setOrderMethod()

    /**
     * Set the value of [showsitetitle] column.
     *
     * @param int $v new value
     * @return $this|\SCategory The current object (for fluent API support)
     */
    public function setShowsitetitle($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->showsitetitle !== $v) {
            $this->showsitetitle = $v;
            $this->modifiedColumns[SCategoryTableMap::COL_SHOWSITETITLE] = true;
        }

        return $this;
    } // setShowsitetitle()

    /**
     * Set the value of [created] column.
     *
     * @param int $v new value
     * @return $this|\SCategory The current object (for fluent API support)
     */
    public function setCreated($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->created !== $v) {
            $this->created = $v;
            $this->modifiedColumns[SCategoryTableMap::COL_CREATED] = true;
        }

        return $this;
    } // setCreated()

    /**
     * Set the value of [updated] column.
     *
     * @param int $v new value
     * @return $this|\SCategory The current object (for fluent API support)
     */
    public function setUpdated($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->updated !== $v) {
            $this->updated = $v;
            $this->modifiedColumns[SCategoryTableMap::COL_UPDATED] = true;
        }

        return $this;
    } // setUpdated()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : SCategoryTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : SCategoryTableMap::translateFieldName('ParentId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->parent_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : SCategoryTableMap::translateFieldName('ExternalId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->external_id = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : SCategoryTableMap::translateFieldName('Url', TableMap::TYPE_PHPNAME, $indexType)];
            $this->url = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : SCategoryTableMap::translateFieldName('Active', TableMap::TYPE_PHPNAME, $indexType)];
            $this->active = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : SCategoryTableMap::translateFieldName('Image', TableMap::TYPE_PHPNAME, $indexType)];
            $this->image = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : SCategoryTableMap::translateFieldName('Position', TableMap::TYPE_PHPNAME, $indexType)];
            $this->position = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : SCategoryTableMap::translateFieldName('FullPath', TableMap::TYPE_PHPNAME, $indexType)];
            $this->full_path = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : SCategoryTableMap::translateFieldName('FullPathIds', TableMap::TYPE_PHPNAME, $indexType)];
            $this->full_path_ids = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : SCategoryTableMap::translateFieldName('Tpl', TableMap::TYPE_PHPNAME, $indexType)];
            $this->tpl = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 10 + $startcol : SCategoryTableMap::translateFieldName('OrderMethod', TableMap::TYPE_PHPNAME, $indexType)];
            $this->order_method = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 11 + $startcol : SCategoryTableMap::translateFieldName('Showsitetitle', TableMap::TYPE_PHPNAME, $indexType)];
            $this->showsitetitle = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 12 + $startcol : SCategoryTableMap::translateFieldName('Created', TableMap::TYPE_PHPNAME, $indexType)];
            $this->created = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 13 + $startcol : SCategoryTableMap::translateFieldName('Updated', TableMap::TYPE_PHPNAME, $indexType)];
            $this->updated = (null !== $col) ? (int) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 14; // 14 = SCategoryTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\SCategory'), 0, $e);
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
        if ($this->aSCategory !== null && $this->parent_id !== $this->aSCategory->getId()) {
            $this->aSCategory = null;
        }
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
            $con = Propel::getServiceContainer()->getReadConnection(SCategoryTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildSCategoryQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aSCategory = null;
            $this->collSCategoriesRelatedById = null;

            $this->collSCategoryI18ns = null;

            $this->collSProductss = null;

            $this->collShopProductCategoriess = null;

            $this->collShopProductPropertiesCategoriess = null;

            $this->collProducts = null;
            $this->collProperties = null;
        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see SCategory::setDeleted()
     * @see SCategory::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(SCategoryTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildSCategoryQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(SCategoryTableMap::DATABASE_NAME);
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
                SCategoryTableMap::addInstanceToPool($this);
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

            // We call the save method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aSCategory !== null) {
                if ($this->aSCategory->isModified() || $this->aSCategory->isNew()) {
                    $affectedRows += $this->aSCategory->save($con);
                }
                $this->setSCategory($this->aSCategory);
            }

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

            if ($this->productsScheduledForDeletion !== null) {
                if (!$this->productsScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    foreach ($this->productsScheduledForDeletion as $entry) {
                        $entryPk = [];

                        $entryPk[1] = $this->getId();
                        $entryPk[0] = $entry->getId();
                        $pks[] = $entryPk;
                    }

                    \ShopProductCategoriesQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);

                    $this->productsScheduledForDeletion = null;
                }

            }

            if ($this->collProducts) {
                foreach ($this->collProducts as $product) {
                    if (!$product->isDeleted() && ($product->isNew() || $product->isModified())) {
                        $product->save($con);
                    }
                }
            }


            if ($this->propertiesScheduledForDeletion !== null) {
                if (!$this->propertiesScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    foreach ($this->propertiesScheduledForDeletion as $entry) {
                        $entryPk = [];

                        $entryPk[1] = $this->getId();
                        $entryPk[0] = $entry->getId();
                        $pks[] = $entryPk;
                    }

                    \ShopProductPropertiesCategoriesQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);

                    $this->propertiesScheduledForDeletion = null;
                }

            }

            if ($this->collProperties) {
                foreach ($this->collProperties as $property) {
                    if (!$property->isDeleted() && ($property->isNew() || $property->isModified())) {
                        $property->save($con);
                    }
                }
            }


            if ($this->sCategoriesRelatedByIdScheduledForDeletion !== null) {
                if (!$this->sCategoriesRelatedByIdScheduledForDeletion->isEmpty()) {
                    \SCategoryQuery::create()
                        ->filterByPrimaryKeys($this->sCategoriesRelatedByIdScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->sCategoriesRelatedByIdScheduledForDeletion = null;
                }
            }

            if ($this->collSCategoriesRelatedById !== null) {
                foreach ($this->collSCategoriesRelatedById as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->sCategoryI18nsScheduledForDeletion !== null) {
                if (!$this->sCategoryI18nsScheduledForDeletion->isEmpty()) {
                    \SCategoryI18nQuery::create()
                        ->filterByPrimaryKeys($this->sCategoryI18nsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->sCategoryI18nsScheduledForDeletion = null;
                }
            }

            if ($this->collSCategoryI18ns !== null) {
                foreach ($this->collSCategoryI18ns as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->sProductssScheduledForDeletion !== null) {
                if (!$this->sProductssScheduledForDeletion->isEmpty()) {
                    \SProductsQuery::create()
                        ->filterByPrimaryKeys($this->sProductssScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->sProductssScheduledForDeletion = null;
                }
            }

            if ($this->collSProductss !== null) {
                foreach ($this->collSProductss as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->shopProductCategoriessScheduledForDeletion !== null) {
                if (!$this->shopProductCategoriessScheduledForDeletion->isEmpty()) {
                    \ShopProductCategoriesQuery::create()
                        ->filterByPrimaryKeys($this->shopProductCategoriessScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->shopProductCategoriessScheduledForDeletion = null;
                }
            }

            if ($this->collShopProductCategoriess !== null) {
                foreach ($this->collShopProductCategoriess as $referrerFK) {
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

        $this->modifiedColumns[SCategoryTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . SCategoryTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(SCategoryTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(SCategoryTableMap::COL_PARENT_ID)) {
            $modifiedColumns[':p' . $index++]  = 'parent_id';
        }
        if ($this->isColumnModified(SCategoryTableMap::COL_EXTERNAL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'external_id';
        }
        if ($this->isColumnModified(SCategoryTableMap::COL_URL)) {
            $modifiedColumns[':p' . $index++]  = 'url';
        }
        if ($this->isColumnModified(SCategoryTableMap::COL_ACTIVE)) {
            $modifiedColumns[':p' . $index++]  = 'active';
        }
        if ($this->isColumnModified(SCategoryTableMap::COL_IMAGE)) {
            $modifiedColumns[':p' . $index++]  = 'image';
        }
        if ($this->isColumnModified(SCategoryTableMap::COL_POSITION)) {
            $modifiedColumns[':p' . $index++]  = 'position';
        }
        if ($this->isColumnModified(SCategoryTableMap::COL_FULL_PATH)) {
            $modifiedColumns[':p' . $index++]  = 'full_path';
        }
        if ($this->isColumnModified(SCategoryTableMap::COL_FULL_PATH_IDS)) {
            $modifiedColumns[':p' . $index++]  = 'full_path_ids';
        }
        if ($this->isColumnModified(SCategoryTableMap::COL_TPL)) {
            $modifiedColumns[':p' . $index++]  = 'tpl';
        }
        if ($this->isColumnModified(SCategoryTableMap::COL_ORDER_METHOD)) {
            $modifiedColumns[':p' . $index++]  = 'order_method';
        }
        if ($this->isColumnModified(SCategoryTableMap::COL_SHOWSITETITLE)) {
            $modifiedColumns[':p' . $index++]  = 'showsitetitle';
        }
        if ($this->isColumnModified(SCategoryTableMap::COL_CREATED)) {
            $modifiedColumns[':p' . $index++]  = 'created';
        }
        if ($this->isColumnModified(SCategoryTableMap::COL_UPDATED)) {
            $modifiedColumns[':p' . $index++]  = 'updated';
        }

        $sql = sprintf(
            'INSERT INTO shop_category (%s) VALUES (%s)',
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
                    case 'parent_id':
                        $stmt->bindValue($identifier, $this->parent_id, PDO::PARAM_INT);
                        break;
                    case 'external_id':
                        $stmt->bindValue($identifier, $this->external_id, PDO::PARAM_STR);
                        break;
                    case 'url':
                        $stmt->bindValue($identifier, $this->url, PDO::PARAM_STR);
                        break;
                    case 'active':
                        $stmt->bindValue($identifier, (int) $this->active, PDO::PARAM_INT);
                        break;
                    case 'image':
                        $stmt->bindValue($identifier, $this->image, PDO::PARAM_STR);
                        break;
                    case 'position':
                        $stmt->bindValue($identifier, $this->position, PDO::PARAM_INT);
                        break;
                    case 'full_path':
                        $stmt->bindValue($identifier, $this->full_path, PDO::PARAM_STR);
                        break;
                    case 'full_path_ids':
                        $stmt->bindValue($identifier, $this->full_path_ids, PDO::PARAM_STR);
                        break;
                    case 'tpl':
                        $stmt->bindValue($identifier, $this->tpl, PDO::PARAM_STR);
                        break;
                    case 'order_method':
                        $stmt->bindValue($identifier, $this->order_method, PDO::PARAM_INT);
                        break;
                    case 'showsitetitle':
                        $stmt->bindValue($identifier, $this->showsitetitle, PDO::PARAM_INT);
                        break;
                    case 'created':
                        $stmt->bindValue($identifier, $this->created, PDO::PARAM_INT);
                        break;
                    case 'updated':
                        $stmt->bindValue($identifier, $this->updated, PDO::PARAM_INT);
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
        $pos = SCategoryTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getParentId();
                break;
            case 2:
                return $this->getExternalId();
                break;
            case 3:
                return $this->getUrl();
                break;
            case 4:
                return $this->getActive();
                break;
            case 5:
                return $this->getImage();
                break;
            case 6:
                return $this->getPosition();
                break;
            case 7:
                return $this->getFullPath();
                break;
            case 8:
                return $this->getFullPathIds();
                break;
            case 9:
                return $this->getTpl();
                break;
            case 10:
                return $this->getOrderMethod();
                break;
            case 11:
                return $this->getShowsitetitle();
                break;
            case 12:
                return $this->getCreated();
                break;
            case 13:
                return $this->getUpdated();
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

        if (isset($alreadyDumpedObjects['SCategory'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['SCategory'][$this->hashCode()] = true;
        $keys = SCategoryTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getParentId(),
            $keys[2] => $this->getExternalId(),
            $keys[3] => $this->getUrl(),
            $keys[4] => $this->getActive(),
            $keys[5] => $this->getImage(),
            $keys[6] => $this->getPosition(),
            $keys[7] => $this->getFullPath(),
            $keys[8] => $this->getFullPathIds(),
            $keys[9] => $this->getTpl(),
            $keys[10] => $this->getOrderMethod(),
            $keys[11] => $this->getShowsitetitle(),
            $keys[12] => $this->getCreated(),
            $keys[13] => $this->getUpdated(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aSCategory) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'sCategory';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'shop_category';
                        break;
                    default:
                        $key = 'SCategory';
                }

                $result[$key] = $this->aSCategory->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collSCategoriesRelatedById) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'sCategories';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'shop_categories';
                        break;
                    default:
                        $key = 'SCategories';
                }

                $result[$key] = $this->collSCategoriesRelatedById->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collSCategoryI18ns) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'sCategoryI18ns';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'shop_category_i18ns';
                        break;
                    default:
                        $key = 'SCategoryI18ns';
                }

                $result[$key] = $this->collSCategoryI18ns->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collSProductss) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'sProductss';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'shop_productss';
                        break;
                    default:
                        $key = 'SProductss';
                }

                $result[$key] = $this->collSProductss->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collShopProductCategoriess) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'shopProductCategoriess';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'shop_product_categoriess';
                        break;
                    default:
                        $key = 'ShopProductCategoriess';
                }

                $result[$key] = $this->collShopProductCategoriess->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\SCategory
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = SCategoryTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\SCategory
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setParentId($value);
                break;
            case 2:
                $this->setExternalId($value);
                break;
            case 3:
                $this->setUrl($value);
                break;
            case 4:
                $this->setActive($value);
                break;
            case 5:
                $this->setImage($value);
                break;
            case 6:
                $this->setPosition($value);
                break;
            case 7:
                $this->setFullPath($value);
                break;
            case 8:
                $this->setFullPathIds($value);
                break;
            case 9:
                $this->setTpl($value);
                break;
            case 10:
                $this->setOrderMethod($value);
                break;
            case 11:
                $this->setShowsitetitle($value);
                break;
            case 12:
                $this->setCreated($value);
                break;
            case 13:
                $this->setUpdated($value);
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
        $keys = SCategoryTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setParentId($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setExternalId($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setUrl($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setActive($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setImage($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setPosition($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setFullPath($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setFullPathIds($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setTpl($arr[$keys[9]]);
        }
        if (array_key_exists($keys[10], $arr)) {
            $this->setOrderMethod($arr[$keys[10]]);
        }
        if (array_key_exists($keys[11], $arr)) {
            $this->setShowsitetitle($arr[$keys[11]]);
        }
        if (array_key_exists($keys[12], $arr)) {
            $this->setCreated($arr[$keys[12]]);
        }
        if (array_key_exists($keys[13], $arr)) {
            $this->setUpdated($arr[$keys[13]]);
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
     * @return $this|\SCategory The current object, for fluid interface
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
        $criteria = new Criteria(SCategoryTableMap::DATABASE_NAME);

        if ($this->isColumnModified(SCategoryTableMap::COL_ID)) {
            $criteria->add(SCategoryTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(SCategoryTableMap::COL_PARENT_ID)) {
            $criteria->add(SCategoryTableMap::COL_PARENT_ID, $this->parent_id);
        }
        if ($this->isColumnModified(SCategoryTableMap::COL_EXTERNAL_ID)) {
            $criteria->add(SCategoryTableMap::COL_EXTERNAL_ID, $this->external_id);
        }
        if ($this->isColumnModified(SCategoryTableMap::COL_URL)) {
            $criteria->add(SCategoryTableMap::COL_URL, $this->url);
        }
        if ($this->isColumnModified(SCategoryTableMap::COL_ACTIVE)) {
            $criteria->add(SCategoryTableMap::COL_ACTIVE, $this->active);
        }
        if ($this->isColumnModified(SCategoryTableMap::COL_IMAGE)) {
            $criteria->add(SCategoryTableMap::COL_IMAGE, $this->image);
        }
        if ($this->isColumnModified(SCategoryTableMap::COL_POSITION)) {
            $criteria->add(SCategoryTableMap::COL_POSITION, $this->position);
        }
        if ($this->isColumnModified(SCategoryTableMap::COL_FULL_PATH)) {
            $criteria->add(SCategoryTableMap::COL_FULL_PATH, $this->full_path);
        }
        if ($this->isColumnModified(SCategoryTableMap::COL_FULL_PATH_IDS)) {
            $criteria->add(SCategoryTableMap::COL_FULL_PATH_IDS, $this->full_path_ids);
        }
        if ($this->isColumnModified(SCategoryTableMap::COL_TPL)) {
            $criteria->add(SCategoryTableMap::COL_TPL, $this->tpl);
        }
        if ($this->isColumnModified(SCategoryTableMap::COL_ORDER_METHOD)) {
            $criteria->add(SCategoryTableMap::COL_ORDER_METHOD, $this->order_method);
        }
        if ($this->isColumnModified(SCategoryTableMap::COL_SHOWSITETITLE)) {
            $criteria->add(SCategoryTableMap::COL_SHOWSITETITLE, $this->showsitetitle);
        }
        if ($this->isColumnModified(SCategoryTableMap::COL_CREATED)) {
            $criteria->add(SCategoryTableMap::COL_CREATED, $this->created);
        }
        if ($this->isColumnModified(SCategoryTableMap::COL_UPDATED)) {
            $criteria->add(SCategoryTableMap::COL_UPDATED, $this->updated);
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
        $criteria = ChildSCategoryQuery::create();
        $criteria->add(SCategoryTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \SCategory (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setParentId($this->getParentId());
        $copyObj->setExternalId($this->getExternalId());
        $copyObj->setUrl($this->getUrl());
        $copyObj->setActive($this->getActive());
        $copyObj->setImage($this->getImage());
        $copyObj->setPosition($this->getPosition());
        $copyObj->setFullPath($this->getFullPath());
        $copyObj->setFullPathIds($this->getFullPathIds());
        $copyObj->setTpl($this->getTpl());
        $copyObj->setOrderMethod($this->getOrderMethod());
        $copyObj->setShowsitetitle($this->getShowsitetitle());
        $copyObj->setCreated($this->getCreated());
        $copyObj->setUpdated($this->getUpdated());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getSCategoriesRelatedById() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addSCategoryRelatedById($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getSCategoryI18ns() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addSCategoryI18n($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getSProductss() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addSProducts($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getShopProductCategoriess() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addShopProductCategories($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getShopProductPropertiesCategoriess() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addShopProductPropertiesCategories($relObj->copy($deepCopy));
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
     * @return \SCategory Clone of current object.
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
     * Declares an association between this object and a ChildSCategory object.
     *
     * @param  ChildSCategory $v
     * @return $this|\SCategory The current object (for fluent API support)
     * @throws PropelException
     */
    public function setSCategory(ChildSCategory $v = null)
    {
        if ($v === null) {
            $this->setParentId(NULL);
        } else {
            $this->setParentId($v->getId());
        }

        $this->aSCategory = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildSCategory object, it will not be re-added.
        if ($v !== null) {
            $v->addSCategoryRelatedById($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildSCategory object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildSCategory The associated ChildSCategory object.
     * @throws PropelException
     */
    public function getSCategory(ConnectionInterface $con = null)
    {
        if ($this->aSCategory === null && ($this->parent_id !== null)) {
            $this->aSCategory = ChildSCategoryQuery::create()->findPk($this->parent_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aSCategory->addSCategoriesRelatedById($this);
             */
        }

        return $this->aSCategory;
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
        if ('SCategoryRelatedById' == $relationName) {
            return $this->initSCategoriesRelatedById();
        }
        if ('SCategoryI18n' == $relationName) {
            return $this->initSCategoryI18ns();
        }
        if ('SProducts' == $relationName) {
            return $this->initSProductss();
        }
        if ('ShopProductCategories' == $relationName) {
            return $this->initShopProductCategoriess();
        }
        if ('ShopProductPropertiesCategories' == $relationName) {
            return $this->initShopProductPropertiesCategoriess();
        }
    }

    /**
     * Clears out the collSCategoriesRelatedById collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addSCategoriesRelatedById()
     */
    public function clearSCategoriesRelatedById()
    {
        $this->collSCategoriesRelatedById = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collSCategoriesRelatedById collection loaded partially.
     */
    public function resetPartialSCategoriesRelatedById($v = true)
    {
        $this->collSCategoriesRelatedByIdPartial = $v;
    }

    /**
     * Initializes the collSCategoriesRelatedById collection.
     *
     * By default this just sets the collSCategoriesRelatedById collection to an empty array (like clearcollSCategoriesRelatedById());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initSCategoriesRelatedById($overrideExisting = true)
    {
        if (null !== $this->collSCategoriesRelatedById && !$overrideExisting) {
            return;
        }
        $this->collSCategoriesRelatedById = new ObjectCollection();
        $this->collSCategoriesRelatedById->setModel('\SCategory');
    }

    /**
     * Gets an array of ChildSCategory objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildSCategory is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildSCategory[] List of ChildSCategory objects
     * @throws PropelException
     */
    public function getSCategoriesRelatedById(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collSCategoriesRelatedByIdPartial && !$this->isNew();
        if (null === $this->collSCategoriesRelatedById || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collSCategoriesRelatedById) {
                // return empty collection
                $this->initSCategoriesRelatedById();
            } else {
                $collSCategoriesRelatedById = ChildSCategoryQuery::create(null, $criteria)
                    ->filterBySCategory($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collSCategoriesRelatedByIdPartial && count($collSCategoriesRelatedById)) {
                        $this->initSCategoriesRelatedById(false);

                        foreach ($collSCategoriesRelatedById as $obj) {
                            if (false == $this->collSCategoriesRelatedById->contains($obj)) {
                                $this->collSCategoriesRelatedById->append($obj);
                            }
                        }

                        $this->collSCategoriesRelatedByIdPartial = true;
                    }

                    return $collSCategoriesRelatedById;
                }

                if ($partial && $this->collSCategoriesRelatedById) {
                    foreach ($this->collSCategoriesRelatedById as $obj) {
                        if ($obj->isNew()) {
                            $collSCategoriesRelatedById[] = $obj;
                        }
                    }
                }

                $this->collSCategoriesRelatedById = $collSCategoriesRelatedById;
                $this->collSCategoriesRelatedByIdPartial = false;
            }
        }

        return $this->collSCategoriesRelatedById;
    }

    /**
     * Sets a collection of ChildSCategory objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $sCategoriesRelatedById A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildSCategory The current object (for fluent API support)
     */
    public function setSCategoriesRelatedById(Collection $sCategoriesRelatedById, ConnectionInterface $con = null)
    {
        /** @var ChildSCategory[] $sCategoriesRelatedByIdToDelete */
        $sCategoriesRelatedByIdToDelete = $this->getSCategoriesRelatedById(new Criteria(), $con)->diff($sCategoriesRelatedById);


        $this->sCategoriesRelatedByIdScheduledForDeletion = $sCategoriesRelatedByIdToDelete;

        foreach ($sCategoriesRelatedByIdToDelete as $sCategoryRelatedByIdRemoved) {
            $sCategoryRelatedByIdRemoved->setSCategory(null);
        }

        $this->collSCategoriesRelatedById = null;
        foreach ($sCategoriesRelatedById as $sCategoryRelatedById) {
            $this->addSCategoryRelatedById($sCategoryRelatedById);
        }

        $this->collSCategoriesRelatedById = $sCategoriesRelatedById;
        $this->collSCategoriesRelatedByIdPartial = false;

        return $this;
    }

    /**
     * Returns the number of related SCategory objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related SCategory objects.
     * @throws PropelException
     */
    public function countSCategoriesRelatedById(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collSCategoriesRelatedByIdPartial && !$this->isNew();
        if (null === $this->collSCategoriesRelatedById || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collSCategoriesRelatedById) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getSCategoriesRelatedById());
            }

            $query = ChildSCategoryQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterBySCategory($this)
                ->count($con);
        }

        return count($this->collSCategoriesRelatedById);
    }

    /**
     * Method called to associate a ChildSCategory object to this object
     * through the ChildSCategory foreign key attribute.
     *
     * @param  ChildSCategory $l ChildSCategory
     * @return $this|\SCategory The current object (for fluent API support)
     */
    public function addSCategoryRelatedById(ChildSCategory $l)
    {
        if ($this->collSCategoriesRelatedById === null) {
            $this->initSCategoriesRelatedById();
            $this->collSCategoriesRelatedByIdPartial = true;
        }

        if (!$this->collSCategoriesRelatedById->contains($l)) {
            $this->doAddSCategoryRelatedById($l);
        }

        return $this;
    }

    /**
     * @param ChildSCategory $sCategoryRelatedById The ChildSCategory object to add.
     */
    protected function doAddSCategoryRelatedById(ChildSCategory $sCategoryRelatedById)
    {
        $this->collSCategoriesRelatedById[]= $sCategoryRelatedById;
        $sCategoryRelatedById->setSCategory($this);
    }

    /**
     * @param  ChildSCategory $sCategoryRelatedById The ChildSCategory object to remove.
     * @return $this|ChildSCategory The current object (for fluent API support)
     */
    public function removeSCategoryRelatedById(ChildSCategory $sCategoryRelatedById)
    {
        if ($this->getSCategoriesRelatedById()->contains($sCategoryRelatedById)) {
            $pos = $this->collSCategoriesRelatedById->search($sCategoryRelatedById);
            $this->collSCategoriesRelatedById->remove($pos);
            if (null === $this->sCategoriesRelatedByIdScheduledForDeletion) {
                $this->sCategoriesRelatedByIdScheduledForDeletion = clone $this->collSCategoriesRelatedById;
                $this->sCategoriesRelatedByIdScheduledForDeletion->clear();
            }
            $this->sCategoriesRelatedByIdScheduledForDeletion[]= $sCategoryRelatedById;
            $sCategoryRelatedById->setSCategory(null);
        }

        return $this;
    }

    /**
     * Clears out the collSCategoryI18ns collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addSCategoryI18ns()
     */
    public function clearSCategoryI18ns()
    {
        $this->collSCategoryI18ns = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collSCategoryI18ns collection loaded partially.
     */
    public function resetPartialSCategoryI18ns($v = true)
    {
        $this->collSCategoryI18nsPartial = $v;
    }

    /**
     * Initializes the collSCategoryI18ns collection.
     *
     * By default this just sets the collSCategoryI18ns collection to an empty array (like clearcollSCategoryI18ns());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initSCategoryI18ns($overrideExisting = true)
    {
        if (null !== $this->collSCategoryI18ns && !$overrideExisting) {
            return;
        }
        $this->collSCategoryI18ns = new ObjectCollection();
        $this->collSCategoryI18ns->setModel('\SCategoryI18n');
    }

    /**
     * Gets an array of ChildSCategoryI18n objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildSCategory is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildSCategoryI18n[] List of ChildSCategoryI18n objects
     * @throws PropelException
     */
    public function getSCategoryI18ns(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collSCategoryI18nsPartial && !$this->isNew();
        if (null === $this->collSCategoryI18ns || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collSCategoryI18ns) {
                // return empty collection
                $this->initSCategoryI18ns();
            } else {
                $collSCategoryI18ns = ChildSCategoryI18nQuery::create(null, $criteria)
                    ->filterBySCategory($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collSCategoryI18nsPartial && count($collSCategoryI18ns)) {
                        $this->initSCategoryI18ns(false);

                        foreach ($collSCategoryI18ns as $obj) {
                            if (false == $this->collSCategoryI18ns->contains($obj)) {
                                $this->collSCategoryI18ns->append($obj);
                            }
                        }

                        $this->collSCategoryI18nsPartial = true;
                    }

                    return $collSCategoryI18ns;
                }

                if ($partial && $this->collSCategoryI18ns) {
                    foreach ($this->collSCategoryI18ns as $obj) {
                        if ($obj->isNew()) {
                            $collSCategoryI18ns[] = $obj;
                        }
                    }
                }

                $this->collSCategoryI18ns = $collSCategoryI18ns;
                $this->collSCategoryI18nsPartial = false;
            }
        }

        return $this->collSCategoryI18ns;
    }

    /**
     * Sets a collection of ChildSCategoryI18n objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $sCategoryI18ns A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildSCategory The current object (for fluent API support)
     */
    public function setSCategoryI18ns(Collection $sCategoryI18ns, ConnectionInterface $con = null)
    {
        /** @var ChildSCategoryI18n[] $sCategoryI18nsToDelete */
        $sCategoryI18nsToDelete = $this->getSCategoryI18ns(new Criteria(), $con)->diff($sCategoryI18ns);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->sCategoryI18nsScheduledForDeletion = clone $sCategoryI18nsToDelete;

        foreach ($sCategoryI18nsToDelete as $sCategoryI18nRemoved) {
            $sCategoryI18nRemoved->setSCategory(null);
        }

        $this->collSCategoryI18ns = null;
        foreach ($sCategoryI18ns as $sCategoryI18n) {
            $this->addSCategoryI18n($sCategoryI18n);
        }

        $this->collSCategoryI18ns = $sCategoryI18ns;
        $this->collSCategoryI18nsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related SCategoryI18n objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related SCategoryI18n objects.
     * @throws PropelException
     */
    public function countSCategoryI18ns(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collSCategoryI18nsPartial && !$this->isNew();
        if (null === $this->collSCategoryI18ns || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collSCategoryI18ns) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getSCategoryI18ns());
            }

            $query = ChildSCategoryI18nQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterBySCategory($this)
                ->count($con);
        }

        return count($this->collSCategoryI18ns);
    }

    /**
     * Method called to associate a ChildSCategoryI18n object to this object
     * through the ChildSCategoryI18n foreign key attribute.
     *
     * @param  ChildSCategoryI18n $l ChildSCategoryI18n
     * @return $this|\SCategory The current object (for fluent API support)
     */
    public function addSCategoryI18n(ChildSCategoryI18n $l)
    {
        if ($l && $locale = $l->getLocale()) {
            $this->setLocale($locale);
            $this->currentTranslations[$locale] = $l;
        }
        if ($this->collSCategoryI18ns === null) {
            $this->initSCategoryI18ns();
            $this->collSCategoryI18nsPartial = true;
        }

        if (!$this->collSCategoryI18ns->contains($l)) {
            $this->doAddSCategoryI18n($l);
        }

        return $this;
    }

    /**
     * @param ChildSCategoryI18n $sCategoryI18n The ChildSCategoryI18n object to add.
     */
    protected function doAddSCategoryI18n(ChildSCategoryI18n $sCategoryI18n)
    {
        $this->collSCategoryI18ns[]= $sCategoryI18n;
        $sCategoryI18n->setSCategory($this);
    }

    /**
     * @param  ChildSCategoryI18n $sCategoryI18n The ChildSCategoryI18n object to remove.
     * @return $this|ChildSCategory The current object (for fluent API support)
     */
    public function removeSCategoryI18n(ChildSCategoryI18n $sCategoryI18n)
    {
        if ($this->getSCategoryI18ns()->contains($sCategoryI18n)) {
            $pos = $this->collSCategoryI18ns->search($sCategoryI18n);
            $this->collSCategoryI18ns->remove($pos);
            if (null === $this->sCategoryI18nsScheduledForDeletion) {
                $this->sCategoryI18nsScheduledForDeletion = clone $this->collSCategoryI18ns;
                $this->sCategoryI18nsScheduledForDeletion->clear();
            }
            $this->sCategoryI18nsScheduledForDeletion[]= clone $sCategoryI18n;
            $sCategoryI18n->setSCategory(null);
        }

        return $this;
    }

    /**
     * Clears out the collSProductss collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addSProductss()
     */
    public function clearSProductss()
    {
        $this->collSProductss = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collSProductss collection loaded partially.
     */
    public function resetPartialSProductss($v = true)
    {
        $this->collSProductssPartial = $v;
    }

    /**
     * Initializes the collSProductss collection.
     *
     * By default this just sets the collSProductss collection to an empty array (like clearcollSProductss());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initSProductss($overrideExisting = true)
    {
        if (null !== $this->collSProductss && !$overrideExisting) {
            return;
        }
        $this->collSProductss = new ObjectCollection();
        $this->collSProductss->setModel('\SProducts');
    }

    /**
     * Gets an array of ChildSProducts objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildSCategory is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildSProducts[] List of ChildSProducts objects
     * @throws PropelException
     */
    public function getSProductss(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collSProductssPartial && !$this->isNew();
        if (null === $this->collSProductss || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collSProductss) {
                // return empty collection
                $this->initSProductss();
            } else {
                $collSProductss = ChildSProductsQuery::create(null, $criteria)
                    ->filterByMainCategory($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collSProductssPartial && count($collSProductss)) {
                        $this->initSProductss(false);

                        foreach ($collSProductss as $obj) {
                            if (false == $this->collSProductss->contains($obj)) {
                                $this->collSProductss->append($obj);
                            }
                        }

                        $this->collSProductssPartial = true;
                    }

                    return $collSProductss;
                }

                if ($partial && $this->collSProductss) {
                    foreach ($this->collSProductss as $obj) {
                        if ($obj->isNew()) {
                            $collSProductss[] = $obj;
                        }
                    }
                }

                $this->collSProductss = $collSProductss;
                $this->collSProductssPartial = false;
            }
        }

        return $this->collSProductss;
    }

    /**
     * Sets a collection of ChildSProducts objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $sProductss A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildSCategory The current object (for fluent API support)
     */
    public function setSProductss(Collection $sProductss, ConnectionInterface $con = null)
    {
        /** @var ChildSProducts[] $sProductssToDelete */
        $sProductssToDelete = $this->getSProductss(new Criteria(), $con)->diff($sProductss);


        $this->sProductssScheduledForDeletion = $sProductssToDelete;

        foreach ($sProductssToDelete as $sProductsRemoved) {
            $sProductsRemoved->setMainCategory(null);
        }

        $this->collSProductss = null;
        foreach ($sProductss as $sProducts) {
            $this->addSProducts($sProducts);
        }

        $this->collSProductss = $sProductss;
        $this->collSProductssPartial = false;

        return $this;
    }

    /**
     * Returns the number of related SProducts objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related SProducts objects.
     * @throws PropelException
     */
    public function countSProductss(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collSProductssPartial && !$this->isNew();
        if (null === $this->collSProductss || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collSProductss) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getSProductss());
            }

            $query = ChildSProductsQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByMainCategory($this)
                ->count($con);
        }

        return count($this->collSProductss);
    }

    /**
     * Method called to associate a ChildSProducts object to this object
     * through the ChildSProducts foreign key attribute.
     *
     * @param  ChildSProducts $l ChildSProducts
     * @return $this|\SCategory The current object (for fluent API support)
     */
    public function addSProducts(ChildSProducts $l)
    {
        if ($this->collSProductss === null) {
            $this->initSProductss();
            $this->collSProductssPartial = true;
        }

        if (!$this->collSProductss->contains($l)) {
            $this->doAddSProducts($l);
        }

        return $this;
    }

    /**
     * @param ChildSProducts $sProducts The ChildSProducts object to add.
     */
    protected function doAddSProducts(ChildSProducts $sProducts)
    {
        $this->collSProductss[]= $sProducts;
        $sProducts->setMainCategory($this);
    }

    /**
     * @param  ChildSProducts $sProducts The ChildSProducts object to remove.
     * @return $this|ChildSCategory The current object (for fluent API support)
     */
    public function removeSProducts(ChildSProducts $sProducts)
    {
        if ($this->getSProductss()->contains($sProducts)) {
            $pos = $this->collSProductss->search($sProducts);
            $this->collSProductss->remove($pos);
            if (null === $this->sProductssScheduledForDeletion) {
                $this->sProductssScheduledForDeletion = clone $this->collSProductss;
                $this->sProductssScheduledForDeletion->clear();
            }
            $this->sProductssScheduledForDeletion[]= clone $sProducts;
            $sProducts->setMainCategory(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this SCategory is new, it will return
     * an empty collection; or if this SCategory has previously
     * been saved, it will retrieve related SProductss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in SCategory.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildSProducts[] List of ChildSProducts objects
     */
    public function getSProductssJoinBrand(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildSProductsQuery::create(null, $criteria);
        $query->joinWith('Brand', $joinBehavior);

        return $this->getSProductss($query, $con);
    }

    /**
     * Clears out the collShopProductCategoriess collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addShopProductCategoriess()
     */
    public function clearShopProductCategoriess()
    {
        $this->collShopProductCategoriess = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collShopProductCategoriess collection loaded partially.
     */
    public function resetPartialShopProductCategoriess($v = true)
    {
        $this->collShopProductCategoriessPartial = $v;
    }

    /**
     * Initializes the collShopProductCategoriess collection.
     *
     * By default this just sets the collShopProductCategoriess collection to an empty array (like clearcollShopProductCategoriess());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initShopProductCategoriess($overrideExisting = true)
    {
        if (null !== $this->collShopProductCategoriess && !$overrideExisting) {
            return;
        }
        $this->collShopProductCategoriess = new ObjectCollection();
        $this->collShopProductCategoriess->setModel('\ShopProductCategories');
    }

    /**
     * Gets an array of ChildShopProductCategories objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildSCategory is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildShopProductCategories[] List of ChildShopProductCategories objects
     * @throws PropelException
     */
    public function getShopProductCategoriess(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collShopProductCategoriessPartial && !$this->isNew();
        if (null === $this->collShopProductCategoriess || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collShopProductCategoriess) {
                // return empty collection
                $this->initShopProductCategoriess();
            } else {
                $collShopProductCategoriess = ChildShopProductCategoriesQuery::create(null, $criteria)
                    ->filterByCategory($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collShopProductCategoriessPartial && count($collShopProductCategoriess)) {
                        $this->initShopProductCategoriess(false);

                        foreach ($collShopProductCategoriess as $obj) {
                            if (false == $this->collShopProductCategoriess->contains($obj)) {
                                $this->collShopProductCategoriess->append($obj);
                            }
                        }

                        $this->collShopProductCategoriessPartial = true;
                    }

                    return $collShopProductCategoriess;
                }

                if ($partial && $this->collShopProductCategoriess) {
                    foreach ($this->collShopProductCategoriess as $obj) {
                        if ($obj->isNew()) {
                            $collShopProductCategoriess[] = $obj;
                        }
                    }
                }

                $this->collShopProductCategoriess = $collShopProductCategoriess;
                $this->collShopProductCategoriessPartial = false;
            }
        }

        return $this->collShopProductCategoriess;
    }

    /**
     * Sets a collection of ChildShopProductCategories objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $shopProductCategoriess A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildSCategory The current object (for fluent API support)
     */
    public function setShopProductCategoriess(Collection $shopProductCategoriess, ConnectionInterface $con = null)
    {
        /** @var ChildShopProductCategories[] $shopProductCategoriessToDelete */
        $shopProductCategoriessToDelete = $this->getShopProductCategoriess(new Criteria(), $con)->diff($shopProductCategoriess);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->shopProductCategoriessScheduledForDeletion = clone $shopProductCategoriessToDelete;

        foreach ($shopProductCategoriessToDelete as $shopProductCategoriesRemoved) {
            $shopProductCategoriesRemoved->setCategory(null);
        }

        $this->collShopProductCategoriess = null;
        foreach ($shopProductCategoriess as $shopProductCategories) {
            $this->addShopProductCategories($shopProductCategories);
        }

        $this->collShopProductCategoriess = $shopProductCategoriess;
        $this->collShopProductCategoriessPartial = false;

        return $this;
    }

    /**
     * Returns the number of related ShopProductCategories objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related ShopProductCategories objects.
     * @throws PropelException
     */
    public function countShopProductCategoriess(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collShopProductCategoriessPartial && !$this->isNew();
        if (null === $this->collShopProductCategoriess || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collShopProductCategoriess) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getShopProductCategoriess());
            }

            $query = ChildShopProductCategoriesQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCategory($this)
                ->count($con);
        }

        return count($this->collShopProductCategoriess);
    }

    /**
     * Method called to associate a ChildShopProductCategories object to this object
     * through the ChildShopProductCategories foreign key attribute.
     *
     * @param  ChildShopProductCategories $l ChildShopProductCategories
     * @return $this|\SCategory The current object (for fluent API support)
     */
    public function addShopProductCategories(ChildShopProductCategories $l)
    {
        if ($this->collShopProductCategoriess === null) {
            $this->initShopProductCategoriess();
            $this->collShopProductCategoriessPartial = true;
        }

        if (!$this->collShopProductCategoriess->contains($l)) {
            $this->doAddShopProductCategories($l);
        }

        return $this;
    }

    /**
     * @param ChildShopProductCategories $shopProductCategories The ChildShopProductCategories object to add.
     */
    protected function doAddShopProductCategories(ChildShopProductCategories $shopProductCategories)
    {
        $this->collShopProductCategoriess[]= $shopProductCategories;
        $shopProductCategories->setCategory($this);
    }

    /**
     * @param  ChildShopProductCategories $shopProductCategories The ChildShopProductCategories object to remove.
     * @return $this|ChildSCategory The current object (for fluent API support)
     */
    public function removeShopProductCategories(ChildShopProductCategories $shopProductCategories)
    {
        if ($this->getShopProductCategoriess()->contains($shopProductCategories)) {
            $pos = $this->collShopProductCategoriess->search($shopProductCategories);
            $this->collShopProductCategoriess->remove($pos);
            if (null === $this->shopProductCategoriessScheduledForDeletion) {
                $this->shopProductCategoriessScheduledForDeletion = clone $this->collShopProductCategoriess;
                $this->shopProductCategoriessScheduledForDeletion->clear();
            }
            $this->shopProductCategoriessScheduledForDeletion[]= clone $shopProductCategories;
            $shopProductCategories->setCategory(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this SCategory is new, it will return
     * an empty collection; or if this SCategory has previously
     * been saved, it will retrieve related ShopProductCategoriess from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in SCategory.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildShopProductCategories[] List of ChildShopProductCategories objects
     */
    public function getShopProductCategoriessJoinProduct(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildShopProductCategoriesQuery::create(null, $criteria);
        $query->joinWith('Product', $joinBehavior);

        return $this->getShopProductCategoriess($query, $con);
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
     * If this ChildSCategory is new, it will return
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
                    ->filterByPropertyCategory($this)
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
     * @return $this|ChildSCategory The current object (for fluent API support)
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
            $shopProductPropertiesCategoriesRemoved->setPropertyCategory(null);
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
                ->filterByPropertyCategory($this)
                ->count($con);
        }

        return count($this->collShopProductPropertiesCategoriess);
    }

    /**
     * Method called to associate a ChildShopProductPropertiesCategories object to this object
     * through the ChildShopProductPropertiesCategories foreign key attribute.
     *
     * @param  ChildShopProductPropertiesCategories $l ChildShopProductPropertiesCategories
     * @return $this|\SCategory The current object (for fluent API support)
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
        $shopProductPropertiesCategories->setPropertyCategory($this);
    }

    /**
     * @param  ChildShopProductPropertiesCategories $shopProductPropertiesCategories The ChildShopProductPropertiesCategories object to remove.
     * @return $this|ChildSCategory The current object (for fluent API support)
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
            $shopProductPropertiesCategories->setPropertyCategory(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this SCategory is new, it will return
     * an empty collection; or if this SCategory has previously
     * been saved, it will retrieve related ShopProductPropertiesCategoriess from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in SCategory.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildShopProductPropertiesCategories[] List of ChildShopProductPropertiesCategories objects
     */
    public function getShopProductPropertiesCategoriessJoinProperty(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildShopProductPropertiesCategoriesQuery::create(null, $criteria);
        $query->joinWith('Property', $joinBehavior);

        return $this->getShopProductPropertiesCategoriess($query, $con);
    }

    /**
     * Clears out the collProducts collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addProducts()
     */
    public function clearProducts()
    {
        $this->collProducts = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Initializes the collProducts crossRef collection.
     *
     * By default this just sets the collProducts collection to an empty collection (like clearProducts());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initProducts()
    {
        $this->collProducts = new ObjectCollection();
        $this->collProductsPartial = true;

        $this->collProducts->setModel('\SProducts');
    }

    /**
     * Checks if the collProducts collection is loaded.
     *
     * @return bool
     */
    public function isProductsLoaded()
    {
        return null !== $this->collProducts;
    }

    /**
     * Gets a collection of ChildSProducts objects related by a many-to-many relationship
     * to the current object by way of the shop_product_categories cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildSCategory is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return ObjectCollection|ChildSProducts[] List of ChildSProducts objects
     */
    public function getProducts(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collProductsPartial && !$this->isNew();
        if (null === $this->collProducts || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collProducts) {
                    $this->initProducts();
                }
            } else {

                $query = ChildSProductsQuery::create(null, $criteria)
                    ->filterByCategory($this);
                $collProducts = $query->find($con);
                if (null !== $criteria) {
                    return $collProducts;
                }

                if ($partial && $this->collProducts) {
                    //make sure that already added objects gets added to the list of the database.
                    foreach ($this->collProducts as $obj) {
                        if (!$collProducts->contains($obj)) {
                            $collProducts[] = $obj;
                        }
                    }
                }

                $this->collProducts = $collProducts;
                $this->collProductsPartial = false;
            }
        }

        return $this->collProducts;
    }

    /**
     * Sets a collection of SProducts objects related by a many-to-many relationship
     * to the current object by way of the shop_product_categories cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param  Collection $products A Propel collection.
     * @param  ConnectionInterface $con Optional connection object
     * @return $this|ChildSCategory The current object (for fluent API support)
     */
    public function setProducts(Collection $products, ConnectionInterface $con = null)
    {
        $this->clearProducts();
        $currentProducts = $this->getProducts();

        $productsScheduledForDeletion = $currentProducts->diff($products);

        foreach ($productsScheduledForDeletion as $toDelete) {
            $this->removeProduct($toDelete);
        }

        foreach ($products as $product) {
            if (!$currentProducts->contains($product)) {
                $this->doAddProduct($product);
            }
        }

        $this->collProductsPartial = false;
        $this->collProducts = $products;

        return $this;
    }

    /**
     * Gets the number of SProducts objects related by a many-to-many relationship
     * to the current object by way of the shop_product_categories cross-reference table.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      boolean $distinct Set to true to force count distinct
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return int the number of related SProducts objects
     */
    public function countProducts(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collProductsPartial && !$this->isNew();
        if (null === $this->collProducts || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collProducts) {
                return 0;
            } else {

                if ($partial && !$criteria) {
                    return count($this->getProducts());
                }

                $query = ChildSProductsQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByCategory($this)
                    ->count($con);
            }
        } else {
            return count($this->collProducts);
        }
    }

    /**
     * Associate a ChildSProducts to this object
     * through the shop_product_categories cross reference table.
     *
     * @param ChildSProducts $product
     * @return ChildSCategory The current object (for fluent API support)
     */
    public function addProduct(ChildSProducts $product)
    {
        if ($this->collProducts === null) {
            $this->initProducts();
        }

        if (!$this->getProducts()->contains($product)) {
            // only add it if the **same** object is not already associated
            $this->collProducts->push($product);
            $this->doAddProduct($product);
        }

        return $this;
    }

    /**
     *
     * @param ChildSProducts $product
     */
    protected function doAddProduct(ChildSProducts $product)
    {
        $shopProductCategories = new ChildShopProductCategories();

        $shopProductCategories->setProduct($product);

        $shopProductCategories->setCategory($this);

        $this->addShopProductCategories($shopProductCategories);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if (!$product->isCategoriesLoaded()) {
            $product->initCategories();
            $product->getCategories()->push($this);
        } elseif (!$product->getCategories()->contains($this)) {
            $product->getCategories()->push($this);
        }

    }

    /**
     * Remove product of this object
     * through the shop_product_categories cross reference table.
     *
     * @param ChildSProducts $product
     * @return ChildSCategory The current object (for fluent API support)
     */
    public function removeProduct(ChildSProducts $product)
    {
        if ($this->getProducts()->contains($product)) { $shopProductCategories = new ChildShopProductCategories();

            $shopProductCategories->setProduct($product);
            if ($product->isCategoriesLoaded()) {
                //remove the back reference if available
                $product->getCategories()->removeObject($this);
            }

            $shopProductCategories->setCategory($this);
            $this->removeShopProductCategories(clone $shopProductCategories);
            $shopProductCategories->clear();

            $this->collProducts->remove($this->collProducts->search($product));

            if (null === $this->productsScheduledForDeletion) {
                $this->productsScheduledForDeletion = clone $this->collProducts;
                $this->productsScheduledForDeletion->clear();
            }

            $this->productsScheduledForDeletion->push($product);
        }


        return $this;
    }

    /**
     * Clears out the collProperties collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addProperties()
     */
    public function clearProperties()
    {
        $this->collProperties = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Initializes the collProperties crossRef collection.
     *
     * By default this just sets the collProperties collection to an empty collection (like clearProperties());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initProperties()
    {
        $this->collProperties = new ObjectCollection();
        $this->collPropertiesPartial = true;

        $this->collProperties->setModel('\SProperties');
    }

    /**
     * Checks if the collProperties collection is loaded.
     *
     * @return bool
     */
    public function isPropertiesLoaded()
    {
        return null !== $this->collProperties;
    }

    /**
     * Gets a collection of ChildSProperties objects related by a many-to-many relationship
     * to the current object by way of the shop_product_properties_categories cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildSCategory is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return ObjectCollection|ChildSProperties[] List of ChildSProperties objects
     */
    public function getProperties(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collPropertiesPartial && !$this->isNew();
        if (null === $this->collProperties || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collProperties) {
                    $this->initProperties();
                }
            } else {

                $query = ChildSPropertiesQuery::create(null, $criteria)
                    ->filterByPropertyCategory($this);
                $collProperties = $query->find($con);
                if (null !== $criteria) {
                    return $collProperties;
                }

                if ($partial && $this->collProperties) {
                    //make sure that already added objects gets added to the list of the database.
                    foreach ($this->collProperties as $obj) {
                        if (!$collProperties->contains($obj)) {
                            $collProperties[] = $obj;
                        }
                    }
                }

                $this->collProperties = $collProperties;
                $this->collPropertiesPartial = false;
            }
        }

        return $this->collProperties;
    }

    /**
     * Sets a collection of SProperties objects related by a many-to-many relationship
     * to the current object by way of the shop_product_properties_categories cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param  Collection $properties A Propel collection.
     * @param  ConnectionInterface $con Optional connection object
     * @return $this|ChildSCategory The current object (for fluent API support)
     */
    public function setProperties(Collection $properties, ConnectionInterface $con = null)
    {
        $this->clearProperties();
        $currentProperties = $this->getProperties();

        $propertiesScheduledForDeletion = $currentProperties->diff($properties);

        foreach ($propertiesScheduledForDeletion as $toDelete) {
            $this->removeProperty($toDelete);
        }

        foreach ($properties as $property) {
            if (!$currentProperties->contains($property)) {
                $this->doAddProperty($property);
            }
        }

        $this->collPropertiesPartial = false;
        $this->collProperties = $properties;

        return $this;
    }

    /**
     * Gets the number of SProperties objects related by a many-to-many relationship
     * to the current object by way of the shop_product_properties_categories cross-reference table.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      boolean $distinct Set to true to force count distinct
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return int the number of related SProperties objects
     */
    public function countProperties(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collPropertiesPartial && !$this->isNew();
        if (null === $this->collProperties || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collProperties) {
                return 0;
            } else {

                if ($partial && !$criteria) {
                    return count($this->getProperties());
                }

                $query = ChildSPropertiesQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByPropertyCategory($this)
                    ->count($con);
            }
        } else {
            return count($this->collProperties);
        }
    }

    /**
     * Associate a ChildSProperties to this object
     * through the shop_product_properties_categories cross reference table.
     *
     * @param ChildSProperties $property
     * @return ChildSCategory The current object (for fluent API support)
     */
    public function addProperty(ChildSProperties $property)
    {
        if ($this->collProperties === null) {
            $this->initProperties();
        }

        if (!$this->getProperties()->contains($property)) {
            // only add it if the **same** object is not already associated
            $this->collProperties->push($property);
            $this->doAddProperty($property);
        }

        return $this;
    }

    /**
     *
     * @param ChildSProperties $property
     */
    protected function doAddProperty(ChildSProperties $property)
    {
        $shopProductPropertiesCategories = new ChildShopProductPropertiesCategories();

        $shopProductPropertiesCategories->setProperty($property);

        $shopProductPropertiesCategories->setPropertyCategory($this);

        $this->addShopProductPropertiesCategories($shopProductPropertiesCategories);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if (!$property->isPropertyCategoriesLoaded()) {
            $property->initPropertyCategories();
            $property->getPropertyCategories()->push($this);
        } elseif (!$property->getPropertyCategories()->contains($this)) {
            $property->getPropertyCategories()->push($this);
        }

    }

    /**
     * Remove property of this object
     * through the shop_product_properties_categories cross reference table.
     *
     * @param ChildSProperties $property
     * @return ChildSCategory The current object (for fluent API support)
     */
    public function removeProperty(ChildSProperties $property)
    {
        if ($this->getProperties()->contains($property)) { $shopProductPropertiesCategories = new ChildShopProductPropertiesCategories();

            $shopProductPropertiesCategories->setProperty($property);
            if ($property->isPropertyCategoriesLoaded()) {
                //remove the back reference if available
                $property->getPropertyCategories()->removeObject($this);
            }

            $shopProductPropertiesCategories->setPropertyCategory($this);
            $this->removeShopProductPropertiesCategories(clone $shopProductPropertiesCategories);
            $shopProductPropertiesCategories->clear();

            $this->collProperties->remove($this->collProperties->search($property));

            if (null === $this->propertiesScheduledForDeletion) {
                $this->propertiesScheduledForDeletion = clone $this->collProperties;
                $this->propertiesScheduledForDeletion->clear();
            }

            $this->propertiesScheduledForDeletion->push($property);
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
        if (null !== $this->aSCategory) {
            $this->aSCategory->removeSCategoryRelatedById($this);
        }
        $this->id = null;
        $this->parent_id = null;
        $this->external_id = null;
        $this->url = null;
        $this->active = null;
        $this->image = null;
        $this->position = null;
        $this->full_path = null;
        $this->full_path_ids = null;
        $this->tpl = null;
        $this->order_method = null;
        $this->showsitetitle = null;
        $this->created = null;
        $this->updated = null;
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
            if ($this->collSCategoriesRelatedById) {
                foreach ($this->collSCategoriesRelatedById as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collSCategoryI18ns) {
                foreach ($this->collSCategoryI18ns as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collSProductss) {
                foreach ($this->collSProductss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collShopProductCategoriess) {
                foreach ($this->collShopProductCategoriess as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collShopProductPropertiesCategoriess) {
                foreach ($this->collShopProductPropertiesCategoriess as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collProducts) {
                foreach ($this->collProducts as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collProperties) {
                foreach ($this->collProperties as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        // i18n behavior
        $this->currentLocale = 'ru';
        $this->currentTranslations = null;

        $this->collSCategoriesRelatedById = null;
        $this->collSCategoryI18ns = null;
        $this->collSProductss = null;
        $this->collShopProductCategoriess = null;
        $this->collShopProductPropertiesCategoriess = null;
        $this->collProducts = null;
        $this->collProperties = null;
        $this->aSCategory = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(SCategoryTableMap::DEFAULT_STRING_FORMAT);
    }

    // i18n behavior

    /**
     * Sets the locale for translations
     *
     * @param     string $locale Locale to use for the translation, e.g. 'fr_FR'
     *
     * @return    $this|ChildSCategory The current object (for fluent API support)
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
     * @return ChildSCategoryI18n */
    public function getTranslation($locale = 'ru', ConnectionInterface $con = null)
    {
        if (!isset($this->currentTranslations[$locale])) {
            if (null !== $this->collSCategoryI18ns) {
                foreach ($this->collSCategoryI18ns as $translation) {
                    if ($translation->getLocale() == $locale) {
                        $this->currentTranslations[$locale] = $translation;

                        return $translation;
                    }
                }
            }
            if ($this->isNew()) {
                $translation = new ChildSCategoryI18n();
                $translation->setLocale($locale);
            } else {
                $translation = ChildSCategoryI18nQuery::create()
                    ->filterByPrimaryKey(array($this->getPrimaryKey(), $locale))
                    ->findOneOrCreate($con);
                $this->currentTranslations[$locale] = $translation;
            }
            $this->addSCategoryI18n($translation);
        }

        return $this->currentTranslations[$locale];
    }

    /**
     * Remove the translation for a given locale
     *
     * @param     string $locale Locale to use for the translation, e.g. 'fr_FR'
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return    $this|ChildSCategory The current object (for fluent API support)
     */
    public function removeTranslation($locale = 'ru', ConnectionInterface $con = null)
    {
        if (!$this->isNew()) {
            ChildSCategoryI18nQuery::create()
                ->filterByPrimaryKey(array($this->getPrimaryKey(), $locale))
                ->delete($con);
        }
        if (isset($this->currentTranslations[$locale])) {
            unset($this->currentTranslations[$locale]);
        }
        foreach ($this->collSCategoryI18ns as $key => $translation) {
            if ($translation->getLocale() == $locale) {
                unset($this->collSCategoryI18ns[$key]);
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
     * @return ChildSCategoryI18n */
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
         * @return $this|\SCategoryI18n The current object (for fluent API support)
         */
        public function setName($v)
        {    $this->getCurrentTranslation()->setName($v);

        return $this;
    }


        /**
         * Get the [h1] column value.
         *
         * @return string
         */
        public function getH1()
        {
        return $this->getCurrentTranslation()->getH1();
    }


        /**
         * Set the value of [h1] column.
         *
         * @param string $v new value
         * @return $this|\SCategoryI18n The current object (for fluent API support)
         */
        public function setH1($v)
        {    $this->getCurrentTranslation()->setH1($v);

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
         * @return $this|\SCategoryI18n The current object (for fluent API support)
         */
        public function setDescription($v)
        {    $this->getCurrentTranslation()->setDescription($v);

        return $this;
    }


        /**
         * Get the [meta_desc] column value.
         *
         * @return string
         */
        public function getMetaDesc()
        {
        return $this->getCurrentTranslation()->getMetaDesc();
    }


        /**
         * Set the value of [meta_desc] column.
         *
         * @param string $v new value
         * @return $this|\SCategoryI18n The current object (for fluent API support)
         */
        public function setMetaDesc($v)
        {    $this->getCurrentTranslation()->setMetaDesc($v);

        return $this;
    }


        /**
         * Get the [meta_title] column value.
         *
         * @return string
         */
        public function getMetaTitle()
        {
        return $this->getCurrentTranslation()->getMetaTitle();
    }


        /**
         * Set the value of [meta_title] column.
         *
         * @param string $v new value
         * @return $this|\SCategoryI18n The current object (for fluent API support)
         */
        public function setMetaTitle($v)
        {    $this->getCurrentTranslation()->setMetaTitle($v);

        return $this;
    }


        /**
         * Get the [meta_keywords] column value.
         *
         * @return string
         */
        public function getMetaKeywords()
        {
        return $this->getCurrentTranslation()->getMetaKeywords();
    }


        /**
         * Set the value of [meta_keywords] column.
         *
         * @param string $v new value
         * @return $this|\SCategoryI18n The current object (for fluent API support)
         */
        public function setMetaKeywords($v)
        {    $this->getCurrentTranslation()->setMetaKeywords($v);

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
