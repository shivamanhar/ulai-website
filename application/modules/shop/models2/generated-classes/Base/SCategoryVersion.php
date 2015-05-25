<?php

namespace Base;

use \SCategory as ChildSCategory;
use \SCategoryQuery as ChildSCategoryQuery;
use \SCategoryVersionQuery as ChildSCategoryVersionQuery;
use \Exception;
use \PDO;
use Map\SCategoryVersionTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;

/**
 * Base class that represents a row from the 'shop_category_version' table.
 *
 *
 *
* @package    propel.generator..Base
*/
abstract class SCategoryVersion extends PropelBaseModelClass implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\SCategoryVersionTableMap';


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
     * The value for the version field.
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $version;

    /**
     * The value for the parent_id_version field.
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $parent_id_version;

    /**
     * The value for the shop_category_ids field.
     * @var        array
     */
    protected $shop_category_ids;

    /**
     * The unserialized $shop_category_ids value - i.e. the persisted object.
     * This is necessary to avoid repeated calls to unserialize() at runtime.
     * @var object
     */
    protected $shop_category_ids_unserialized;

    /**
     * The value for the shop_category_versions field.
     * @var        array
     */
    protected $shop_category_versions;

    /**
     * The unserialized $shop_category_versions value - i.e. the persisted object.
     * This is necessary to avoid repeated calls to unserialize() at runtime.
     * @var object
     */
    protected $shop_category_versions_unserialized;

    /**
     * @var        ChildSCategory
     */
    protected $aSCategory;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see __construct()
     */
    public function applyDefaultValues()
    {
        $this->version = 0;
        $this->parent_id_version = 0;
    }

    /**
     * Initializes internal state of Base\SCategoryVersion object.
     * @see applyDefaults()
     */
    public function __construct()
    {
        $this->applyDefaultValues();
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
     * Compares this with another <code>SCategoryVersion</code> instance.  If
     * <code>obj</code> is an instance of <code>SCategoryVersion</code>, delegates to
     * <code>equals(SCategoryVersion)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|SCategoryVersion The current object, for fluid interface
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
     * Get the [version] column value.
     *
     * @return int
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Get the [parent_id_version] column value.
     *
     * @return int
     */
    public function getParentIdVersion()
    {
        return $this->parent_id_version;
    }

    /**
     * Get the [shop_category_ids] column value.
     *
     * @return array
     */
    public function getShopCategoryIds()
    {
        if (null === $this->shop_category_ids_unserialized) {
            $this->shop_category_ids_unserialized = array();
        }
        if (!$this->shop_category_ids_unserialized && null !== $this->shop_category_ids) {
            $shop_category_ids_unserialized = substr($this->shop_category_ids, 2, -2);
            $this->shop_category_ids_unserialized = $shop_category_ids_unserialized ? explode(' | ', $shop_category_ids_unserialized) : array();
        }

        return $this->shop_category_ids_unserialized;
    }

    /**
     * Test the presence of a value in the [shop_category_ids] array column value.
     * @param      mixed $value
     *
     * @return boolean
     */
    public function hasShopCategoryId($value)
    {
        return in_array($value, $this->getShopCategoryIds());
    } // hasShopCategoryId()

    /**
     * Get the [shop_category_versions] column value.
     *
     * @return array
     */
    public function getShopCategoryVersions()
    {
        if (null === $this->shop_category_versions_unserialized) {
            $this->shop_category_versions_unserialized = array();
        }
        if (!$this->shop_category_versions_unserialized && null !== $this->shop_category_versions) {
            $shop_category_versions_unserialized = substr($this->shop_category_versions, 2, -2);
            $this->shop_category_versions_unserialized = $shop_category_versions_unserialized ? explode(' | ', $shop_category_versions_unserialized) : array();
        }

        return $this->shop_category_versions_unserialized;
    }

    /**
     * Test the presence of a value in the [shop_category_versions] array column value.
     * @param      mixed $value
     *
     * @return boolean
     */
    public function hasShopCategoryVersion($value)
    {
        return in_array($value, $this->getShopCategoryVersions());
    } // hasShopCategoryVersion()

    /**
     * Set the value of [id] column.
     *
     * @param  int $v new value
     * @return $this|\SCategoryVersion The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[SCategoryVersionTableMap::COL_ID] = true;
        }

        if ($this->aSCategory !== null && $this->aSCategory->getId() !== $v) {
            $this->aSCategory = null;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [parent_id] column.
     *
     * @param  int $v new value
     * @return $this|\SCategoryVersion The current object (for fluent API support)
     */
    public function setParentId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->parent_id !== $v) {
            $this->parent_id = $v;
            $this->modifiedColumns[SCategoryVersionTableMap::COL_PARENT_ID] = true;
        }

        return $this;
    } // setParentId()

    /**
     * Set the value of [external_id] column.
     *
     * @param  string $v new value
     * @return $this|\SCategoryVersion The current object (for fluent API support)
     */
    public function setExternalId($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->external_id !== $v) {
            $this->external_id = $v;
            $this->modifiedColumns[SCategoryVersionTableMap::COL_EXTERNAL_ID] = true;
        }

        return $this;
    } // setExternalId()

    /**
     * Set the value of [url] column.
     *
     * @param  string $v new value
     * @return $this|\SCategoryVersion The current object (for fluent API support)
     */
    public function setUrl($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->url !== $v) {
            $this->url = $v;
            $this->modifiedColumns[SCategoryVersionTableMap::COL_URL] = true;
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
     * @return $this|\SCategoryVersion The current object (for fluent API support)
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
            $this->modifiedColumns[SCategoryVersionTableMap::COL_ACTIVE] = true;
        }

        return $this;
    } // setActive()

    /**
     * Set the value of [image] column.
     *
     * @param  string $v new value
     * @return $this|\SCategoryVersion The current object (for fluent API support)
     */
    public function setImage($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->image !== $v) {
            $this->image = $v;
            $this->modifiedColumns[SCategoryVersionTableMap::COL_IMAGE] = true;
        }

        return $this;
    } // setImage()

    /**
     * Set the value of [position] column.
     *
     * @param  int $v new value
     * @return $this|\SCategoryVersion The current object (for fluent API support)
     */
    public function setPosition($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->position !== $v) {
            $this->position = $v;
            $this->modifiedColumns[SCategoryVersionTableMap::COL_POSITION] = true;
        }

        return $this;
    } // setPosition()

    /**
     * Set the value of [full_path] column.
     *
     * @param  string $v new value
     * @return $this|\SCategoryVersion The current object (for fluent API support)
     */
    public function setFullPath($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->full_path !== $v) {
            $this->full_path = $v;
            $this->modifiedColumns[SCategoryVersionTableMap::COL_FULL_PATH] = true;
        }

        return $this;
    } // setFullPath()

    /**
     * Set the value of [full_path_ids] column.
     *
     * @param  string $v new value
     * @return $this|\SCategoryVersion The current object (for fluent API support)
     */
    public function setFullPathIds($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->full_path_ids !== $v) {
            $this->full_path_ids = $v;
            $this->modifiedColumns[SCategoryVersionTableMap::COL_FULL_PATH_IDS] = true;
        }

        return $this;
    } // setFullPathIds()

    /**
     * Set the value of [tpl] column.
     *
     * @param  string $v new value
     * @return $this|\SCategoryVersion The current object (for fluent API support)
     */
    public function setTpl($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->tpl !== $v) {
            $this->tpl = $v;
            $this->modifiedColumns[SCategoryVersionTableMap::COL_TPL] = true;
        }

        return $this;
    } // setTpl()

    /**
     * Set the value of [order_method] column.
     *
     * @param  int $v new value
     * @return $this|\SCategoryVersion The current object (for fluent API support)
     */
    public function setOrderMethod($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->order_method !== $v) {
            $this->order_method = $v;
            $this->modifiedColumns[SCategoryVersionTableMap::COL_ORDER_METHOD] = true;
        }

        return $this;
    } // setOrderMethod()

    /**
     * Set the value of [showsitetitle] column.
     *
     * @param  int $v new value
     * @return $this|\SCategoryVersion The current object (for fluent API support)
     */
    public function setShowsitetitle($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->showsitetitle !== $v) {
            $this->showsitetitle = $v;
            $this->modifiedColumns[SCategoryVersionTableMap::COL_SHOWSITETITLE] = true;
        }

        return $this;
    } // setShowsitetitle()

    /**
     * Set the value of [created] column.
     *
     * @param  int $v new value
     * @return $this|\SCategoryVersion The current object (for fluent API support)
     */
    public function setCreated($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->created !== $v) {
            $this->created = $v;
            $this->modifiedColumns[SCategoryVersionTableMap::COL_CREATED] = true;
        }

        return $this;
    } // setCreated()

    /**
     * Set the value of [updated] column.
     *
     * @param  int $v new value
     * @return $this|\SCategoryVersion The current object (for fluent API support)
     */
    public function setUpdated($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->updated !== $v) {
            $this->updated = $v;
            $this->modifiedColumns[SCategoryVersionTableMap::COL_UPDATED] = true;
        }

        return $this;
    } // setUpdated()

    /**
     * Set the value of [version] column.
     *
     * @param  int $v new value
     * @return $this|\SCategoryVersion The current object (for fluent API support)
     */
    public function setVersion($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->version !== $v) {
            $this->version = $v;
            $this->modifiedColumns[SCategoryVersionTableMap::COL_VERSION] = true;
        }

        return $this;
    } // setVersion()

    /**
     * Set the value of [parent_id_version] column.
     *
     * @param  int $v new value
     * @return $this|\SCategoryVersion The current object (for fluent API support)
     */
    public function setParentIdVersion($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->parent_id_version !== $v) {
            $this->parent_id_version = $v;
            $this->modifiedColumns[SCategoryVersionTableMap::COL_PARENT_ID_VERSION] = true;
        }

        return $this;
    } // setParentIdVersion()

    /**
     * Set the value of [shop_category_ids] column.
     *
     * @param  array $v new value
     * @return $this|\SCategoryVersion The current object (for fluent API support)
     */
    public function setShopCategoryIds($v)
    {
        if ($this->shop_category_ids_unserialized !== $v) {
            $this->shop_category_ids_unserialized = $v;
            $this->shop_category_ids = '| ' . implode(' | ', $v) . ' |';
            $this->modifiedColumns[SCategoryVersionTableMap::COL_SHOP_CATEGORY_IDS] = true;
        }

        return $this;
    } // setShopCategoryIds()

    /**
     * Adds a value to the [shop_category_ids] array column value.
     * @param  mixed $value
     *
     * @return $this|\SCategoryVersion The current object (for fluent API support)
     */
    public function addShopCategoryId($value)
    {
        $currentArray = $this->getShopCategoryIds();
        $currentArray []= $value;
        $this->setShopCategoryIds($currentArray);

        return $this;
    } // addShopCategoryId()

    /**
     * Removes a value from the [shop_category_ids] array column value.
     * @param  mixed $value
     *
     * @return $this|\SCategoryVersion The current object (for fluent API support)
     */
    public function removeShopCategoryId($value)
    {
        $targetArray = array();
        foreach ($this->getShopCategoryIds() as $element) {
            if ($element != $value) {
                $targetArray []= $element;
            }
        }
        $this->setShopCategoryIds($targetArray);

        return $this;
    } // removeShopCategoryId()

    /**
     * Set the value of [shop_category_versions] column.
     *
     * @param  array $v new value
     * @return $this|\SCategoryVersion The current object (for fluent API support)
     */
    public function setShopCategoryVersions($v)
    {
        if ($this->shop_category_versions_unserialized !== $v) {
            $this->shop_category_versions_unserialized = $v;
            $this->shop_category_versions = '| ' . implode(' | ', $v) . ' |';
            $this->modifiedColumns[SCategoryVersionTableMap::COL_SHOP_CATEGORY_VERSIONS] = true;
        }

        return $this;
    } // setShopCategoryVersions()

    /**
     * Adds a value to the [shop_category_versions] array column value.
     * @param  mixed $value
     *
     * @return $this|\SCategoryVersion The current object (for fluent API support)
     */
    public function addShopCategoryVersion($value)
    {
        $currentArray = $this->getShopCategoryVersions();
        $currentArray []= $value;
        $this->setShopCategoryVersions($currentArray);

        return $this;
    } // addShopCategoryVersion()

    /**
     * Removes a value from the [shop_category_versions] array column value.
     * @param  mixed $value
     *
     * @return $this|\SCategoryVersion The current object (for fluent API support)
     */
    public function removeShopCategoryVersion($value)
    {
        $targetArray = array();
        foreach ($this->getShopCategoryVersions() as $element) {
            if ($element != $value) {
                $targetArray []= $element;
            }
        }
        $this->setShopCategoryVersions($targetArray);

        return $this;
    } // removeShopCategoryVersion()

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
            if ($this->version !== 0) {
                return false;
            }

            if ($this->parent_id_version !== 0) {
                return false;
            }

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : SCategoryVersionTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : SCategoryVersionTableMap::translateFieldName('ParentId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->parent_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : SCategoryVersionTableMap::translateFieldName('ExternalId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->external_id = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : SCategoryVersionTableMap::translateFieldName('Url', TableMap::TYPE_PHPNAME, $indexType)];
            $this->url = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : SCategoryVersionTableMap::translateFieldName('Active', TableMap::TYPE_PHPNAME, $indexType)];
            $this->active = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : SCategoryVersionTableMap::translateFieldName('Image', TableMap::TYPE_PHPNAME, $indexType)];
            $this->image = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : SCategoryVersionTableMap::translateFieldName('Position', TableMap::TYPE_PHPNAME, $indexType)];
            $this->position = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : SCategoryVersionTableMap::translateFieldName('FullPath', TableMap::TYPE_PHPNAME, $indexType)];
            $this->full_path = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : SCategoryVersionTableMap::translateFieldName('FullPathIds', TableMap::TYPE_PHPNAME, $indexType)];
            $this->full_path_ids = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : SCategoryVersionTableMap::translateFieldName('Tpl', TableMap::TYPE_PHPNAME, $indexType)];
            $this->tpl = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 10 + $startcol : SCategoryVersionTableMap::translateFieldName('OrderMethod', TableMap::TYPE_PHPNAME, $indexType)];
            $this->order_method = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 11 + $startcol : SCategoryVersionTableMap::translateFieldName('Showsitetitle', TableMap::TYPE_PHPNAME, $indexType)];
            $this->showsitetitle = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 12 + $startcol : SCategoryVersionTableMap::translateFieldName('Created', TableMap::TYPE_PHPNAME, $indexType)];
            $this->created = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 13 + $startcol : SCategoryVersionTableMap::translateFieldName('Updated', TableMap::TYPE_PHPNAME, $indexType)];
            $this->updated = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 14 + $startcol : SCategoryVersionTableMap::translateFieldName('Version', TableMap::TYPE_PHPNAME, $indexType)];
            $this->version = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 15 + $startcol : SCategoryVersionTableMap::translateFieldName('ParentIdVersion', TableMap::TYPE_PHPNAME, $indexType)];
            $this->parent_id_version = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 16 + $startcol : SCategoryVersionTableMap::translateFieldName('ShopCategoryIds', TableMap::TYPE_PHPNAME, $indexType)];
            $this->shop_category_ids = $col;
            $this->shop_category_ids_unserialized = null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 17 + $startcol : SCategoryVersionTableMap::translateFieldName('ShopCategoryVersions', TableMap::TYPE_PHPNAME, $indexType)];
            $this->shop_category_versions = $col;
            $this->shop_category_versions_unserialized = null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 18; // 18 = SCategoryVersionTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\SCategoryVersion'), 0, $e);
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
        if ($this->aSCategory !== null && $this->id !== $this->aSCategory->getId()) {
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
            $con = Propel::getServiceContainer()->getReadConnection(SCategoryVersionTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildSCategoryVersionQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aSCategory = null;
        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see SCategoryVersion::setDeleted()
     * @see SCategoryVersion::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(SCategoryVersionTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildSCategoryVersionQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(SCategoryVersionTableMap::DATABASE_NAME);
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
                SCategoryVersionTableMap::addInstanceToPool($this);
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
                } else {
                    $this->doUpdate($con);
                }
                $affectedRows += 1;
                $this->resetModified();
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


         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(SCategoryVersionTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(SCategoryVersionTableMap::COL_PARENT_ID)) {
            $modifiedColumns[':p' . $index++]  = 'parent_id';
        }
        if ($this->isColumnModified(SCategoryVersionTableMap::COL_EXTERNAL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'external_id';
        }
        if ($this->isColumnModified(SCategoryVersionTableMap::COL_URL)) {
            $modifiedColumns[':p' . $index++]  = 'url';
        }
        if ($this->isColumnModified(SCategoryVersionTableMap::COL_ACTIVE)) {
            $modifiedColumns[':p' . $index++]  = 'active';
        }
        if ($this->isColumnModified(SCategoryVersionTableMap::COL_IMAGE)) {
            $modifiedColumns[':p' . $index++]  = 'image';
        }
        if ($this->isColumnModified(SCategoryVersionTableMap::COL_POSITION)) {
            $modifiedColumns[':p' . $index++]  = 'position';
        }
        if ($this->isColumnModified(SCategoryVersionTableMap::COL_FULL_PATH)) {
            $modifiedColumns[':p' . $index++]  = 'full_path';
        }
        if ($this->isColumnModified(SCategoryVersionTableMap::COL_FULL_PATH_IDS)) {
            $modifiedColumns[':p' . $index++]  = 'full_path_ids';
        }
        if ($this->isColumnModified(SCategoryVersionTableMap::COL_TPL)) {
            $modifiedColumns[':p' . $index++]  = 'tpl';
        }
        if ($this->isColumnModified(SCategoryVersionTableMap::COL_ORDER_METHOD)) {
            $modifiedColumns[':p' . $index++]  = 'order_method';
        }
        if ($this->isColumnModified(SCategoryVersionTableMap::COL_SHOWSITETITLE)) {
            $modifiedColumns[':p' . $index++]  = 'showsitetitle';
        }
        if ($this->isColumnModified(SCategoryVersionTableMap::COL_CREATED)) {
            $modifiedColumns[':p' . $index++]  = 'created';
        }
        if ($this->isColumnModified(SCategoryVersionTableMap::COL_UPDATED)) {
            $modifiedColumns[':p' . $index++]  = 'updated';
        }
        if ($this->isColumnModified(SCategoryVersionTableMap::COL_VERSION)) {
            $modifiedColumns[':p' . $index++]  = 'version';
        }
        if ($this->isColumnModified(SCategoryVersionTableMap::COL_PARENT_ID_VERSION)) {
            $modifiedColumns[':p' . $index++]  = 'parent_id_version';
        }
        if ($this->isColumnModified(SCategoryVersionTableMap::COL_SHOP_CATEGORY_IDS)) {
            $modifiedColumns[':p' . $index++]  = 'shop_category_ids';
        }
        if ($this->isColumnModified(SCategoryVersionTableMap::COL_SHOP_CATEGORY_VERSIONS)) {
            $modifiedColumns[':p' . $index++]  = 'shop_category_versions';
        }

        $sql = sprintf(
            'INSERT INTO shop_category_version (%s) VALUES (%s)',
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
                    case 'version':
                        $stmt->bindValue($identifier, $this->version, PDO::PARAM_INT);
                        break;
                    case 'parent_id_version':
                        $stmt->bindValue($identifier, $this->parent_id_version, PDO::PARAM_INT);
                        break;
                    case 'shop_category_ids':
                        $stmt->bindValue($identifier, $this->shop_category_ids, PDO::PARAM_STR);
                        break;
                    case 'shop_category_versions':
                        $stmt->bindValue($identifier, $this->shop_category_versions, PDO::PARAM_STR);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

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
        $pos = SCategoryVersionTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
            case 14:
                return $this->getVersion();
                break;
            case 15:
                return $this->getParentIdVersion();
                break;
            case 16:
                return $this->getShopCategoryIds();
                break;
            case 17:
                return $this->getShopCategoryVersions();
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

        if (isset($alreadyDumpedObjects['SCategoryVersion'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['SCategoryVersion'][$this->hashCode()] = true;
        $keys = SCategoryVersionTableMap::getFieldNames($keyType);
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
            $keys[14] => $this->getVersion(),
            $keys[15] => $this->getParentIdVersion(),
            $keys[16] => $this->getShopCategoryIds(),
            $keys[17] => $this->getShopCategoryVersions(),
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
     * @return $this|\SCategoryVersion
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = SCategoryVersionTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\SCategoryVersion
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
            case 14:
                $this->setVersion($value);
                break;
            case 15:
                $this->setParentIdVersion($value);
                break;
            case 16:
                if (!is_array($value)) {
                    $v = trim(substr($value, 2, -2));
                    $value = $v ? explode(' | ', $v) : array();
                }
                $this->setShopCategoryIds($value);
                break;
            case 17:
                if (!is_array($value)) {
                    $v = trim(substr($value, 2, -2));
                    $value = $v ? explode(' | ', $v) : array();
                }
                $this->setShopCategoryVersions($value);
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
        $keys = SCategoryVersionTableMap::getFieldNames($keyType);

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
        if (array_key_exists($keys[14], $arr)) {
            $this->setVersion($arr[$keys[14]]);
        }
        if (array_key_exists($keys[15], $arr)) {
            $this->setParentIdVersion($arr[$keys[15]]);
        }
        if (array_key_exists($keys[16], $arr)) {
            $this->setShopCategoryIds($arr[$keys[16]]);
        }
        if (array_key_exists($keys[17], $arr)) {
            $this->setShopCategoryVersions($arr[$keys[17]]);
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
     * @return $this|\SCategoryVersion The current object, for fluid interface
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
        $criteria = new Criteria(SCategoryVersionTableMap::DATABASE_NAME);

        if ($this->isColumnModified(SCategoryVersionTableMap::COL_ID)) {
            $criteria->add(SCategoryVersionTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(SCategoryVersionTableMap::COL_PARENT_ID)) {
            $criteria->add(SCategoryVersionTableMap::COL_PARENT_ID, $this->parent_id);
        }
        if ($this->isColumnModified(SCategoryVersionTableMap::COL_EXTERNAL_ID)) {
            $criteria->add(SCategoryVersionTableMap::COL_EXTERNAL_ID, $this->external_id);
        }
        if ($this->isColumnModified(SCategoryVersionTableMap::COL_URL)) {
            $criteria->add(SCategoryVersionTableMap::COL_URL, $this->url);
        }
        if ($this->isColumnModified(SCategoryVersionTableMap::COL_ACTIVE)) {
            $criteria->add(SCategoryVersionTableMap::COL_ACTIVE, $this->active);
        }
        if ($this->isColumnModified(SCategoryVersionTableMap::COL_IMAGE)) {
            $criteria->add(SCategoryVersionTableMap::COL_IMAGE, $this->image);
        }
        if ($this->isColumnModified(SCategoryVersionTableMap::COL_POSITION)) {
            $criteria->add(SCategoryVersionTableMap::COL_POSITION, $this->position);
        }
        if ($this->isColumnModified(SCategoryVersionTableMap::COL_FULL_PATH)) {
            $criteria->add(SCategoryVersionTableMap::COL_FULL_PATH, $this->full_path);
        }
        if ($this->isColumnModified(SCategoryVersionTableMap::COL_FULL_PATH_IDS)) {
            $criteria->add(SCategoryVersionTableMap::COL_FULL_PATH_IDS, $this->full_path_ids);
        }
        if ($this->isColumnModified(SCategoryVersionTableMap::COL_TPL)) {
            $criteria->add(SCategoryVersionTableMap::COL_TPL, $this->tpl);
        }
        if ($this->isColumnModified(SCategoryVersionTableMap::COL_ORDER_METHOD)) {
            $criteria->add(SCategoryVersionTableMap::COL_ORDER_METHOD, $this->order_method);
        }
        if ($this->isColumnModified(SCategoryVersionTableMap::COL_SHOWSITETITLE)) {
            $criteria->add(SCategoryVersionTableMap::COL_SHOWSITETITLE, $this->showsitetitle);
        }
        if ($this->isColumnModified(SCategoryVersionTableMap::COL_CREATED)) {
            $criteria->add(SCategoryVersionTableMap::COL_CREATED, $this->created);
        }
        if ($this->isColumnModified(SCategoryVersionTableMap::COL_UPDATED)) {
            $criteria->add(SCategoryVersionTableMap::COL_UPDATED, $this->updated);
        }
        if ($this->isColumnModified(SCategoryVersionTableMap::COL_VERSION)) {
            $criteria->add(SCategoryVersionTableMap::COL_VERSION, $this->version);
        }
        if ($this->isColumnModified(SCategoryVersionTableMap::COL_PARENT_ID_VERSION)) {
            $criteria->add(SCategoryVersionTableMap::COL_PARENT_ID_VERSION, $this->parent_id_version);
        }
        if ($this->isColumnModified(SCategoryVersionTableMap::COL_SHOP_CATEGORY_IDS)) {
            $criteria->add(SCategoryVersionTableMap::COL_SHOP_CATEGORY_IDS, $this->shop_category_ids);
        }
        if ($this->isColumnModified(SCategoryVersionTableMap::COL_SHOP_CATEGORY_VERSIONS)) {
            $criteria->add(SCategoryVersionTableMap::COL_SHOP_CATEGORY_VERSIONS, $this->shop_category_versions);
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
        $criteria = ChildSCategoryVersionQuery::create();
        $criteria->add(SCategoryVersionTableMap::COL_ID, $this->id);
        $criteria->add(SCategoryVersionTableMap::COL_VERSION, $this->version);

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
        $validPk = null !== $this->getId() &&
            null !== $this->getVersion();

        $validPrimaryKeyFKs = 1;
        $primaryKeyFKs = [];

        //relation shop_category_version_fk_de3ea2 to table shop_category
        if ($this->aSCategory && $hash = spl_object_hash($this->aSCategory)) {
            $primaryKeyFKs[] = $hash;
        } else {
            $validPrimaryKeyFKs = false;
        }

        if ($validPk) {
            return crc32(json_encode($this->getPrimaryKey(), JSON_UNESCAPED_UNICODE));
        } elseif ($validPrimaryKeyFKs) {
            return crc32(json_encode($primaryKeyFKs, JSON_UNESCAPED_UNICODE));
        }

        return spl_object_hash($this);
    }

    /**
     * Returns the composite primary key for this object.
     * The array elements will be in same order as specified in XML.
     * @return array
     */
    public function getPrimaryKey()
    {
        $pks = array();
        $pks[0] = $this->getId();
        $pks[1] = $this->getVersion();

        return $pks;
    }

    /**
     * Set the [composite] primary key.
     *
     * @param      array $keys The elements of the composite key (order must match the order in XML file).
     * @return void
     */
    public function setPrimaryKey($keys)
    {
        $this->setId($keys[0]);
        $this->setVersion($keys[1]);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return (null === $this->getId()) && (null === $this->getVersion());
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \SCategoryVersion (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setId($this->getId());
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
        $copyObj->setVersion($this->getVersion());
        $copyObj->setParentIdVersion($this->getParentIdVersion());
        $copyObj->setShopCategoryIds($this->getShopCategoryIds());
        $copyObj->setShopCategoryVersions($this->getShopCategoryVersions());
        if ($makeNew) {
            $copyObj->setNew(true);
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
     * @return \SCategoryVersion Clone of current object.
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
     * @return $this|\SCategoryVersion The current object (for fluent API support)
     * @throws PropelException
     */
    public function setSCategory(ChildSCategory $v = null)
    {
        if ($v === null) {
            $this->setId(NULL);
        } else {
            $this->setId($v->getId());
        }

        $this->aSCategory = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildSCategory object, it will not be re-added.
        if ($v !== null) {
            $v->addSCategoryVersion($this);
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
        if ($this->aSCategory === null && ($this->id !== null)) {
            $this->aSCategory = ChildSCategoryQuery::create()->findPk($this->id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aSCategory->addSCategoryVersions($this);
             */
        }

        return $this->aSCategory;
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aSCategory) {
            $this->aSCategory->removeSCategoryVersion($this);
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
        $this->version = null;
        $this->parent_id_version = null;
        $this->shop_category_ids = null;
        $this->shop_category_ids_unserialized = null;
        $this->shop_category_versions = null;
        $this->shop_category_versions_unserialized = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->applyDefaultValues();
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
        } // if ($deep)

        $this->aSCategory = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(SCategoryVersionTableMap::DEFAULT_STRING_FORMAT);
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
