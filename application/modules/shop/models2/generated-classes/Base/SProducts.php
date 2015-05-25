<?php

namespace Base;

use \SBrands as ChildSBrands;
use \SBrandsQuery as ChildSBrandsQuery;
use \SCategory as ChildSCategory;
use \SCategoryQuery as ChildSCategoryQuery;
use \SNotifications as ChildSNotifications;
use \SNotificationsQuery as ChildSNotificationsQuery;
use \SOrderProducts as ChildSOrderProducts;
use \SOrderProductsQuery as ChildSOrderProductsQuery;
use \SProductImages as ChildSProductImages;
use \SProductImagesQuery as ChildSProductImagesQuery;
use \SProductPropertiesData as ChildSProductPropertiesData;
use \SProductPropertiesDataQuery as ChildSProductPropertiesDataQuery;
use \SProductVariants as ChildSProductVariants;
use \SProductVariantsQuery as ChildSProductVariantsQuery;
use \SProducts as ChildSProducts;
use \SProductsI18n as ChildSProductsI18n;
use \SProductsI18nQuery as ChildSProductsI18nQuery;
use \SProductsQuery as ChildSProductsQuery;
use \SProductsRating as ChildSProductsRating;
use \SProductsRatingQuery as ChildSProductsRatingQuery;
use \SWarehouseData as ChildSWarehouseData;
use \SWarehouseDataQuery as ChildSWarehouseDataQuery;
use \ShopKit as ChildShopKit;
use \ShopKitProduct as ChildShopKitProduct;
use \ShopKitProductQuery as ChildShopKitProductQuery;
use \ShopKitQuery as ChildShopKitQuery;
use \ShopProductCategories as ChildShopProductCategories;
use \ShopProductCategoriesQuery as ChildShopProductCategoriesQuery;
use \Exception;
use \PDO;
use Map\SProductsTableMap;
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
 * Base class that represents a row from the 'shop_products' table.
 *
 *
 *
* @package    propel.generator..Base
*/
abstract class SProducts extends PropelBaseModelClass implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\SProductsTableMap';


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
     * The value for the user_id field.
     * @var        int
     */
    protected $user_id;

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
     * The value for the hit field.
     * @var        boolean
     */
    protected $hit;

    /**
     * The value for the hot field.
     * @var        boolean
     */
    protected $hot;

    /**
     * The value for the action field.
     * @var        boolean
     */
    protected $action;

    /**
     * The value for the brand_id field.
     * @var        int
     */
    protected $brand_id;

    /**
     * The value for the category_id field.
     * @var        int
     */
    protected $category_id;

    /**
     * The value for the related_products field.
     * @var        string
     */
    protected $related_products;

    /**
     * The value for the old_price field.
     * @var        string
     */
    protected $old_price;

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
     * The value for the views field.
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $views;

    /**
     * The value for the added_to_cart_count field.
     * @var        int
     */
    protected $added_to_cart_count;

    /**
     * The value for the enable_comments field.
     * Note: this column has a database default value of: true
     * @var        boolean
     */
    protected $enable_comments;

    /**
     * The value for the tpl field.
     * @var        string
     */
    protected $tpl;

    /**
     * @var        ChildSBrands
     */
    protected $aBrand;

    /**
     * @var        ChildSCategory
     */
    protected $aMainCategory;

    /**
     * @var        ObjectCollection|ChildShopKit[] Collection to store aggregation of ChildShopKit objects.
     */
    protected $collShopKits;
    protected $collShopKitsPartial;

    /**
     * @var        ObjectCollection|ChildShopKitProduct[] Collection to store aggregation of ChildShopKitProduct objects.
     */
    protected $collShopKitProducts;
    protected $collShopKitProductsPartial;

    /**
     * @var        ObjectCollection|ChildSProductsI18n[] Collection to store aggregation of ChildSProductsI18n objects.
     */
    protected $collSProductsI18ns;
    protected $collSProductsI18nsPartial;

    /**
     * @var        ObjectCollection|ChildSProductImages[] Collection to store aggregation of ChildSProductImages objects.
     */
    protected $collSProductImagess;
    protected $collSProductImagessPartial;

    /**
     * @var        ObjectCollection|ChildSProductVariants[] Collection to store aggregation of ChildSProductVariants objects.
     */
    protected $collProductVariants;
    protected $collProductVariantsPartial;

    /**
     * @var        ObjectCollection|ChildSWarehouseData[] Collection to store aggregation of ChildSWarehouseData objects.
     */
    protected $collSWarehouseDatas;
    protected $collSWarehouseDatasPartial;

    /**
     * @var        ObjectCollection|ChildShopProductCategories[] Collection to store aggregation of ChildShopProductCategories objects.
     */
    protected $collShopProductCategoriess;
    protected $collShopProductCategoriessPartial;

    /**
     * @var        ObjectCollection|ChildSProductPropertiesData[] Collection to store aggregation of ChildSProductPropertiesData objects.
     */
    protected $collSProductPropertiesDatas;
    protected $collSProductPropertiesDatasPartial;

    /**
     * @var        ObjectCollection|ChildSNotifications[] Collection to store aggregation of ChildSNotifications objects.
     */
    protected $collSNotificationss;
    protected $collSNotificationssPartial;

    /**
     * @var        ObjectCollection|ChildSOrderProducts[] Collection to store aggregation of ChildSOrderProducts objects.
     */
    protected $collSOrderProductss;
    protected $collSOrderProductssPartial;

    /**
     * @var        ChildSProductsRating one-to-one related ChildSProductsRating object
     */
    protected $singleSProductsRating;

    /**
     * @var        ObjectCollection|ChildSCategory[] Cross Collection to store aggregation of ChildSCategory objects.
     */
    protected $collCategories;

    /**
     * @var bool
     */
    protected $collCategoriesPartial;

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
     * @var        array[ChildSProductsI18n]
     */
    protected $currentTranslations;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildSCategory[]
     */
    protected $categoriesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildShopKit[]
     */
    protected $shopKitsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildShopKitProduct[]
     */
    protected $shopKitProductsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildSProductsI18n[]
     */
    protected $sProductsI18nsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildSProductImages[]
     */
    protected $sProductImagessScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildSProductVariants[]
     */
    protected $productVariantsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildSWarehouseData[]
     */
    protected $sWarehouseDatasScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildShopProductCategories[]
     */
    protected $shopProductCategoriessScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildSProductPropertiesData[]
     */
    protected $sProductPropertiesDatasScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildSNotifications[]
     */
    protected $sNotificationssScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildSOrderProducts[]
     */
    protected $sOrderProductssScheduledForDeletion = null;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see __construct()
     */
    public function applyDefaultValues()
    {
        $this->views = 0;
        $this->enable_comments = true;
    }

    /**
     * Initializes internal state of Base\SProducts object.
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
     * Compares this with another <code>SProducts</code> instance.  If
     * <code>obj</code> is an instance of <code>SProducts</code>, delegates to
     * <code>equals(SProducts)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|SProducts The current object, for fluid interface
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
     * Get the [user_id] column value.
     *
     * @return int
     */
    public function getUserId()
    {
        return $this->user_id;
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
     * Get the [hit] column value.
     *
     * @return boolean
     */
    public function getHit()
    {
        return $this->hit;
    }

    /**
     * Get the [hit] column value.
     *
     * @return boolean
     */
    public function isHit()
    {
        return $this->getHit();
    }

    /**
     * Get the [hot] column value.
     *
     * @return boolean
     */
    public function getHot()
    {
        return $this->hot;
    }

    /**
     * Get the [hot] column value.
     *
     * @return boolean
     */
    public function isHot()
    {
        return $this->getHot();
    }

    /**
     * Get the [action] column value.
     *
     * @return boolean
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * Get the [action] column value.
     *
     * @return boolean
     */
    public function isAction()
    {
        return $this->getAction();
    }

    /**
     * Get the [brand_id] column value.
     *
     * @return int
     */
    public function getBrandId()
    {
        return $this->brand_id;
    }

    /**
     * Get the [category_id] column value.
     *
     * @return int
     */
    public function getCategoryId()
    {
        return $this->category_id;
    }

    /**
     * Get the [related_products] column value.
     *
     * @return string
     */
    public function getRelatedProducts()
    {
        return $this->related_products;
    }

    /**
     * Get the [old_price] column value.
     *
     * @return string
     */
    public function getOldPrice()
    {
        return $this->old_price;
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
     * Get the [views] column value.
     *
     * @return int
     */
    public function getViews()
    {
        return $this->views;
    }

    /**
     * Get the [added_to_cart_count] column value.
     *
     * @return int
     */
    public function getAddedToCartCount()
    {
        return $this->added_to_cart_count;
    }

    /**
     * Get the [enable_comments] column value.
     *
     * @return boolean
     */
    public function getEnableComments()
    {
        return $this->enable_comments;
    }

    /**
     * Get the [enable_comments] column value.
     *
     * @return boolean
     */
    public function isEnableComments()
    {
        return $this->getEnableComments();
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
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return $this|\SProducts The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[SProductsTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [user_id] column.
     *
     * @param int $v new value
     * @return $this|\SProducts The current object (for fluent API support)
     */
    public function setUserId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->user_id !== $v) {
            $this->user_id = $v;
            $this->modifiedColumns[SProductsTableMap::COL_USER_ID] = true;
        }

        return $this;
    } // setUserId()

    /**
     * Set the value of [external_id] column.
     *
     * @param string $v new value
     * @return $this|\SProducts The current object (for fluent API support)
     */
    public function setExternalId($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->external_id !== $v) {
            $this->external_id = $v;
            $this->modifiedColumns[SProductsTableMap::COL_EXTERNAL_ID] = true;
        }

        return $this;
    } // setExternalId()

    /**
     * Set the value of [url] column.
     *
     * @param string $v new value
     * @return $this|\SProducts The current object (for fluent API support)
     */
    public function setUrl($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->url !== $v) {
            $this->url = $v;
            $this->modifiedColumns[SProductsTableMap::COL_URL] = true;
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
     * @return $this|\SProducts The current object (for fluent API support)
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
            $this->modifiedColumns[SProductsTableMap::COL_ACTIVE] = true;
        }

        return $this;
    } // setActive()

    /**
     * Sets the value of the [hit] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\SProducts The current object (for fluent API support)
     */
    public function setHit($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->hit !== $v) {
            $this->hit = $v;
            $this->modifiedColumns[SProductsTableMap::COL_HIT] = true;
        }

        return $this;
    } // setHit()

    /**
     * Sets the value of the [hot] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\SProducts The current object (for fluent API support)
     */
    public function setHot($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->hot !== $v) {
            $this->hot = $v;
            $this->modifiedColumns[SProductsTableMap::COL_HOT] = true;
        }

        return $this;
    } // setHot()

    /**
     * Sets the value of the [action] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\SProducts The current object (for fluent API support)
     */
    public function setAction($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->action !== $v) {
            $this->action = $v;
            $this->modifiedColumns[SProductsTableMap::COL_ACTION] = true;
        }

        return $this;
    } // setAction()

    /**
     * Set the value of [brand_id] column.
     *
     * @param int $v new value
     * @return $this|\SProducts The current object (for fluent API support)
     */
    public function setBrandId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->brand_id !== $v) {
            $this->brand_id = $v;
            $this->modifiedColumns[SProductsTableMap::COL_BRAND_ID] = true;
        }

        if ($this->aBrand !== null && $this->aBrand->getId() !== $v) {
            $this->aBrand = null;
        }

        return $this;
    } // setBrandId()

    /**
     * Set the value of [category_id] column.
     *
     * @param int $v new value
     * @return $this|\SProducts The current object (for fluent API support)
     */
    public function setCategoryId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->category_id !== $v) {
            $this->category_id = $v;
            $this->modifiedColumns[SProductsTableMap::COL_CATEGORY_ID] = true;
        }

        if ($this->aMainCategory !== null && $this->aMainCategory->getId() !== $v) {
            $this->aMainCategory = null;
        }

        return $this;
    } // setCategoryId()

    /**
     * Set the value of [related_products] column.
     *
     * @param string $v new value
     * @return $this|\SProducts The current object (for fluent API support)
     */
    public function setRelatedProducts($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->related_products !== $v) {
            $this->related_products = $v;
            $this->modifiedColumns[SProductsTableMap::COL_RELATED_PRODUCTS] = true;
        }

        return $this;
    } // setRelatedProducts()

    /**
     * Set the value of [old_price] column.
     *
     * @param string $v new value
     * @return $this|\SProducts The current object (for fluent API support)
     */
    public function setOldPrice($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->old_price !== $v) {
            $this->old_price = $v;
            $this->modifiedColumns[SProductsTableMap::COL_OLD_PRICE] = true;
        }

        return $this;
    } // setOldPrice()

    /**
     * Set the value of [created] column.
     *
     * @param int $v new value
     * @return $this|\SProducts The current object (for fluent API support)
     */
    public function setCreated($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->created !== $v) {
            $this->created = $v;
            $this->modifiedColumns[SProductsTableMap::COL_CREATED] = true;
        }

        return $this;
    } // setCreated()

    /**
     * Set the value of [updated] column.
     *
     * @param int $v new value
     * @return $this|\SProducts The current object (for fluent API support)
     */
    public function setUpdated($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->updated !== $v) {
            $this->updated = $v;
            $this->modifiedColumns[SProductsTableMap::COL_UPDATED] = true;
        }

        return $this;
    } // setUpdated()

    /**
     * Set the value of [views] column.
     *
     * @param int $v new value
     * @return $this|\SProducts The current object (for fluent API support)
     */
    public function setViews($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->views !== $v) {
            $this->views = $v;
            $this->modifiedColumns[SProductsTableMap::COL_VIEWS] = true;
        }

        return $this;
    } // setViews()

    /**
     * Set the value of [added_to_cart_count] column.
     *
     * @param int $v new value
     * @return $this|\SProducts The current object (for fluent API support)
     */
    public function setAddedToCartCount($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->added_to_cart_count !== $v) {
            $this->added_to_cart_count = $v;
            $this->modifiedColumns[SProductsTableMap::COL_ADDED_TO_CART_COUNT] = true;
        }

        return $this;
    } // setAddedToCartCount()

    /**
     * Sets the value of the [enable_comments] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\SProducts The current object (for fluent API support)
     */
    public function setEnableComments($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->enable_comments !== $v) {
            $this->enable_comments = $v;
            $this->modifiedColumns[SProductsTableMap::COL_ENABLE_COMMENTS] = true;
        }

        return $this;
    } // setEnableComments()

    /**
     * Set the value of [tpl] column.
     *
     * @param string $v new value
     * @return $this|\SProducts The current object (for fluent API support)
     */
    public function setTpl($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->tpl !== $v) {
            $this->tpl = $v;
            $this->modifiedColumns[SProductsTableMap::COL_TPL] = true;
        }

        return $this;
    } // setTpl()

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
            if ($this->views !== 0) {
                return false;
            }

            if ($this->enable_comments !== true) {
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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : SProductsTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : SProductsTableMap::translateFieldName('UserId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->user_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : SProductsTableMap::translateFieldName('ExternalId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->external_id = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : SProductsTableMap::translateFieldName('Url', TableMap::TYPE_PHPNAME, $indexType)];
            $this->url = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : SProductsTableMap::translateFieldName('Active', TableMap::TYPE_PHPNAME, $indexType)];
            $this->active = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : SProductsTableMap::translateFieldName('Hit', TableMap::TYPE_PHPNAME, $indexType)];
            $this->hit = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : SProductsTableMap::translateFieldName('Hot', TableMap::TYPE_PHPNAME, $indexType)];
            $this->hot = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : SProductsTableMap::translateFieldName('Action', TableMap::TYPE_PHPNAME, $indexType)];
            $this->action = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : SProductsTableMap::translateFieldName('BrandId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->brand_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : SProductsTableMap::translateFieldName('CategoryId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->category_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 10 + $startcol : SProductsTableMap::translateFieldName('RelatedProducts', TableMap::TYPE_PHPNAME, $indexType)];
            $this->related_products = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 11 + $startcol : SProductsTableMap::translateFieldName('OldPrice', TableMap::TYPE_PHPNAME, $indexType)];
            $this->old_price = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 12 + $startcol : SProductsTableMap::translateFieldName('Created', TableMap::TYPE_PHPNAME, $indexType)];
            $this->created = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 13 + $startcol : SProductsTableMap::translateFieldName('Updated', TableMap::TYPE_PHPNAME, $indexType)];
            $this->updated = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 14 + $startcol : SProductsTableMap::translateFieldName('Views', TableMap::TYPE_PHPNAME, $indexType)];
            $this->views = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 15 + $startcol : SProductsTableMap::translateFieldName('AddedToCartCount', TableMap::TYPE_PHPNAME, $indexType)];
            $this->added_to_cart_count = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 16 + $startcol : SProductsTableMap::translateFieldName('EnableComments', TableMap::TYPE_PHPNAME, $indexType)];
            $this->enable_comments = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 17 + $startcol : SProductsTableMap::translateFieldName('Tpl', TableMap::TYPE_PHPNAME, $indexType)];
            $this->tpl = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 18; // 18 = SProductsTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\SProducts'), 0, $e);
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
        if ($this->aBrand !== null && $this->brand_id !== $this->aBrand->getId()) {
            $this->aBrand = null;
        }
        if ($this->aMainCategory !== null && $this->category_id !== $this->aMainCategory->getId()) {
            $this->aMainCategory = null;
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
            $con = Propel::getServiceContainer()->getReadConnection(SProductsTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildSProductsQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aBrand = null;
            $this->aMainCategory = null;
            $this->collShopKits = null;

            $this->collShopKitProducts = null;

            $this->collSProductsI18ns = null;

            $this->collSProductImagess = null;

            $this->collProductVariants = null;

            $this->collSWarehouseDatas = null;

            $this->collShopProductCategoriess = null;

            $this->collSProductPropertiesDatas = null;

            $this->collSNotificationss = null;

            $this->collSOrderProductss = null;

            $this->singleSProductsRating = null;

            $this->collCategories = null;
        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see SProducts::setDeleted()
     * @see SProducts::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(SProductsTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildSProductsQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(SProductsTableMap::DATABASE_NAME);
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
                SProductsTableMap::addInstanceToPool($this);
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

            if ($this->aBrand !== null) {
                if ($this->aBrand->isModified() || $this->aBrand->isNew()) {
                    $affectedRows += $this->aBrand->save($con);
                }
                $this->setBrand($this->aBrand);
            }

            if ($this->aMainCategory !== null) {
                if ($this->aMainCategory->isModified() || $this->aMainCategory->isNew()) {
                    $affectedRows += $this->aMainCategory->save($con);
                }
                $this->setMainCategory($this->aMainCategory);
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

            if ($this->categoriesScheduledForDeletion !== null) {
                if (!$this->categoriesScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    foreach ($this->categoriesScheduledForDeletion as $entry) {
                        $entryPk = [];

                        $entryPk[0] = $this->getId();
                        $entryPk[1] = $entry->getId();
                        $pks[] = $entryPk;
                    }

                    \ShopProductCategoriesQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);

                    $this->categoriesScheduledForDeletion = null;
                }

            }

            if ($this->collCategories) {
                foreach ($this->collCategories as $category) {
                    if (!$category->isDeleted() && ($category->isNew() || $category->isModified())) {
                        $category->save($con);
                    }
                }
            }


            if ($this->shopKitsScheduledForDeletion !== null) {
                if (!$this->shopKitsScheduledForDeletion->isEmpty()) {
                    \ShopKitQuery::create()
                        ->filterByPrimaryKeys($this->shopKitsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->shopKitsScheduledForDeletion = null;
                }
            }

            if ($this->collShopKits !== null) {
                foreach ($this->collShopKits as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->shopKitProductsScheduledForDeletion !== null) {
                if (!$this->shopKitProductsScheduledForDeletion->isEmpty()) {
                    \ShopKitProductQuery::create()
                        ->filterByPrimaryKeys($this->shopKitProductsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->shopKitProductsScheduledForDeletion = null;
                }
            }

            if ($this->collShopKitProducts !== null) {
                foreach ($this->collShopKitProducts as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->sProductsI18nsScheduledForDeletion !== null) {
                if (!$this->sProductsI18nsScheduledForDeletion->isEmpty()) {
                    \SProductsI18nQuery::create()
                        ->filterByPrimaryKeys($this->sProductsI18nsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->sProductsI18nsScheduledForDeletion = null;
                }
            }

            if ($this->collSProductsI18ns !== null) {
                foreach ($this->collSProductsI18ns as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->sProductImagessScheduledForDeletion !== null) {
                if (!$this->sProductImagessScheduledForDeletion->isEmpty()) {
                    \SProductImagesQuery::create()
                        ->filterByPrimaryKeys($this->sProductImagessScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->sProductImagessScheduledForDeletion = null;
                }
            }

            if ($this->collSProductImagess !== null) {
                foreach ($this->collSProductImagess as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->productVariantsScheduledForDeletion !== null) {
                if (!$this->productVariantsScheduledForDeletion->isEmpty()) {
                    \SProductVariantsQuery::create()
                        ->filterByPrimaryKeys($this->productVariantsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->productVariantsScheduledForDeletion = null;
                }
            }

            if ($this->collProductVariants !== null) {
                foreach ($this->collProductVariants as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->sWarehouseDatasScheduledForDeletion !== null) {
                if (!$this->sWarehouseDatasScheduledForDeletion->isEmpty()) {
                    \SWarehouseDataQuery::create()
                        ->filterByPrimaryKeys($this->sWarehouseDatasScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->sWarehouseDatasScheduledForDeletion = null;
                }
            }

            if ($this->collSWarehouseDatas !== null) {
                foreach ($this->collSWarehouseDatas as $referrerFK) {
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

            if ($this->sNotificationssScheduledForDeletion !== null) {
                if (!$this->sNotificationssScheduledForDeletion->isEmpty()) {
                    \SNotificationsQuery::create()
                        ->filterByPrimaryKeys($this->sNotificationssScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->sNotificationssScheduledForDeletion = null;
                }
            }

            if ($this->collSNotificationss !== null) {
                foreach ($this->collSNotificationss as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->sOrderProductssScheduledForDeletion !== null) {
                if (!$this->sOrderProductssScheduledForDeletion->isEmpty()) {
                    \SOrderProductsQuery::create()
                        ->filterByPrimaryKeys($this->sOrderProductssScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->sOrderProductssScheduledForDeletion = null;
                }
            }

            if ($this->collSOrderProductss !== null) {
                foreach ($this->collSOrderProductss as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->singleSProductsRating !== null) {
                if (!$this->singleSProductsRating->isDeleted() && ($this->singleSProductsRating->isNew() || $this->singleSProductsRating->isModified())) {
                    $affectedRows += $this->singleSProductsRating->save($con);
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

        $this->modifiedColumns[SProductsTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . SProductsTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(SProductsTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(SProductsTableMap::COL_USER_ID)) {
            $modifiedColumns[':p' . $index++]  = 'user_id';
        }
        if ($this->isColumnModified(SProductsTableMap::COL_EXTERNAL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'external_id';
        }
        if ($this->isColumnModified(SProductsTableMap::COL_URL)) {
            $modifiedColumns[':p' . $index++]  = 'url';
        }
        if ($this->isColumnModified(SProductsTableMap::COL_ACTIVE)) {
            $modifiedColumns[':p' . $index++]  = 'active';
        }
        if ($this->isColumnModified(SProductsTableMap::COL_HIT)) {
            $modifiedColumns[':p' . $index++]  = 'hit';
        }
        if ($this->isColumnModified(SProductsTableMap::COL_HOT)) {
            $modifiedColumns[':p' . $index++]  = 'hot';
        }
        if ($this->isColumnModified(SProductsTableMap::COL_ACTION)) {
            $modifiedColumns[':p' . $index++]  = 'action';
        }
        if ($this->isColumnModified(SProductsTableMap::COL_BRAND_ID)) {
            $modifiedColumns[':p' . $index++]  = 'brand_id';
        }
        if ($this->isColumnModified(SProductsTableMap::COL_CATEGORY_ID)) {
            $modifiedColumns[':p' . $index++]  = 'category_id';
        }
        if ($this->isColumnModified(SProductsTableMap::COL_RELATED_PRODUCTS)) {
            $modifiedColumns[':p' . $index++]  = 'related_products';
        }
        if ($this->isColumnModified(SProductsTableMap::COL_OLD_PRICE)) {
            $modifiedColumns[':p' . $index++]  = 'old_price';
        }
        if ($this->isColumnModified(SProductsTableMap::COL_CREATED)) {
            $modifiedColumns[':p' . $index++]  = 'created';
        }
        if ($this->isColumnModified(SProductsTableMap::COL_UPDATED)) {
            $modifiedColumns[':p' . $index++]  = 'updated';
        }
        if ($this->isColumnModified(SProductsTableMap::COL_VIEWS)) {
            $modifiedColumns[':p' . $index++]  = 'views';
        }
        if ($this->isColumnModified(SProductsTableMap::COL_ADDED_TO_CART_COUNT)) {
            $modifiedColumns[':p' . $index++]  = 'added_to_cart_count';
        }
        if ($this->isColumnModified(SProductsTableMap::COL_ENABLE_COMMENTS)) {
            $modifiedColumns[':p' . $index++]  = 'enable_comments';
        }
        if ($this->isColumnModified(SProductsTableMap::COL_TPL)) {
            $modifiedColumns[':p' . $index++]  = 'tpl';
        }

        $sql = sprintf(
            'INSERT INTO shop_products (%s) VALUES (%s)',
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
                    case 'user_id':
                        $stmt->bindValue($identifier, $this->user_id, PDO::PARAM_INT);
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
                    case 'hit':
                        $stmt->bindValue($identifier, (int) $this->hit, PDO::PARAM_INT);
                        break;
                    case 'hot':
                        $stmt->bindValue($identifier, (int) $this->hot, PDO::PARAM_INT);
                        break;
                    case 'action':
                        $stmt->bindValue($identifier, (int) $this->action, PDO::PARAM_INT);
                        break;
                    case 'brand_id':
                        $stmt->bindValue($identifier, $this->brand_id, PDO::PARAM_INT);
                        break;
                    case 'category_id':
                        $stmt->bindValue($identifier, $this->category_id, PDO::PARAM_INT);
                        break;
                    case 'related_products':
                        $stmt->bindValue($identifier, $this->related_products, PDO::PARAM_STR);
                        break;
                    case 'old_price':
                        $stmt->bindValue($identifier, $this->old_price, PDO::PARAM_STR);
                        break;
                    case 'created':
                        $stmt->bindValue($identifier, $this->created, PDO::PARAM_INT);
                        break;
                    case 'updated':
                        $stmt->bindValue($identifier, $this->updated, PDO::PARAM_INT);
                        break;
                    case 'views':
                        $stmt->bindValue($identifier, $this->views, PDO::PARAM_INT);
                        break;
                    case 'added_to_cart_count':
                        $stmt->bindValue($identifier, $this->added_to_cart_count, PDO::PARAM_INT);
                        break;
                    case 'enable_comments':
                        $stmt->bindValue($identifier, (int) $this->enable_comments, PDO::PARAM_INT);
                        break;
                    case 'tpl':
                        $stmt->bindValue($identifier, $this->tpl, PDO::PARAM_STR);
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
        $pos = SProductsTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getUserId();
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
                return $this->getHit();
                break;
            case 6:
                return $this->getHot();
                break;
            case 7:
                return $this->getAction();
                break;
            case 8:
                return $this->getBrandId();
                break;
            case 9:
                return $this->getCategoryId();
                break;
            case 10:
                return $this->getRelatedProducts();
                break;
            case 11:
                return $this->getOldPrice();
                break;
            case 12:
                return $this->getCreated();
                break;
            case 13:
                return $this->getUpdated();
                break;
            case 14:
                return $this->getViews();
                break;
            case 15:
                return $this->getAddedToCartCount();
                break;
            case 16:
                return $this->getEnableComments();
                break;
            case 17:
                return $this->getTpl();
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

        if (isset($alreadyDumpedObjects['SProducts'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['SProducts'][$this->hashCode()] = true;
        $keys = SProductsTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getUserId(),
            $keys[2] => $this->getExternalId(),
            $keys[3] => $this->getUrl(),
            $keys[4] => $this->getActive(),
            $keys[5] => $this->getHit(),
            $keys[6] => $this->getHot(),
            $keys[7] => $this->getAction(),
            $keys[8] => $this->getBrandId(),
            $keys[9] => $this->getCategoryId(),
            $keys[10] => $this->getRelatedProducts(),
            $keys[11] => $this->getOldPrice(),
            $keys[12] => $this->getCreated(),
            $keys[13] => $this->getUpdated(),
            $keys[14] => $this->getViews(),
            $keys[15] => $this->getAddedToCartCount(),
            $keys[16] => $this->getEnableComments(),
            $keys[17] => $this->getTpl(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aBrand) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'sBrands';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'shop_brands';
                        break;
                    default:
                        $key = 'SBrands';
                }

                $result[$key] = $this->aBrand->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aMainCategory) {

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

                $result[$key] = $this->aMainCategory->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collShopKits) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'shopKits';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'shop_kits';
                        break;
                    default:
                        $key = 'ShopKits';
                }

                $result[$key] = $this->collShopKits->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collShopKitProducts) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'shopKitProducts';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'shop_kit_products';
                        break;
                    default:
                        $key = 'ShopKitProducts';
                }

                $result[$key] = $this->collShopKitProducts->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collSProductsI18ns) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'sProductsI18ns';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'shop_products_i18ns';
                        break;
                    default:
                        $key = 'SProductsI18ns';
                }

                $result[$key] = $this->collSProductsI18ns->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collSProductImagess) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'sProductImagess';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'shop_product_imagess';
                        break;
                    default:
                        $key = 'SProductImagess';
                }

                $result[$key] = $this->collSProductImagess->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collProductVariants) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'sProductVariantss';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'shop_product_variantss';
                        break;
                    default:
                        $key = 'SProductVariantss';
                }

                $result[$key] = $this->collProductVariants->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collSWarehouseDatas) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'sWarehouseDatas';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'shop_warehouse_datas';
                        break;
                    default:
                        $key = 'SWarehouseDatas';
                }

                $result[$key] = $this->collSWarehouseDatas->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
            if (null !== $this->collSNotificationss) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'sNotificationss';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'shop_notificationss';
                        break;
                    default:
                        $key = 'SNotificationss';
                }

                $result[$key] = $this->collSNotificationss->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collSOrderProductss) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'sOrderProductss';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'shop_orders_productss';
                        break;
                    default:
                        $key = 'SOrderProductss';
                }

                $result[$key] = $this->collSOrderProductss->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->singleSProductsRating) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'sProductsRating';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'shop_products_rating';
                        break;
                    default:
                        $key = 'SProductsRating';
                }

                $result[$key] = $this->singleSProductsRating->toArray($keyType, $includeLazyLoadColumns, $alreadyDumpedObjects, true);
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
     * @return $this|\SProducts
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = SProductsTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\SProducts
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setUserId($value);
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
                $this->setHit($value);
                break;
            case 6:
                $this->setHot($value);
                break;
            case 7:
                $this->setAction($value);
                break;
            case 8:
                $this->setBrandId($value);
                break;
            case 9:
                $this->setCategoryId($value);
                break;
            case 10:
                $this->setRelatedProducts($value);
                break;
            case 11:
                $this->setOldPrice($value);
                break;
            case 12:
                $this->setCreated($value);
                break;
            case 13:
                $this->setUpdated($value);
                break;
            case 14:
                $this->setViews($value);
                break;
            case 15:
                $this->setAddedToCartCount($value);
                break;
            case 16:
                $this->setEnableComments($value);
                break;
            case 17:
                $this->setTpl($value);
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
        $keys = SProductsTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setUserId($arr[$keys[1]]);
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
            $this->setHit($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setHot($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setAction($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setBrandId($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setCategoryId($arr[$keys[9]]);
        }
        if (array_key_exists($keys[10], $arr)) {
            $this->setRelatedProducts($arr[$keys[10]]);
        }
        if (array_key_exists($keys[11], $arr)) {
            $this->setOldPrice($arr[$keys[11]]);
        }
        if (array_key_exists($keys[12], $arr)) {
            $this->setCreated($arr[$keys[12]]);
        }
        if (array_key_exists($keys[13], $arr)) {
            $this->setUpdated($arr[$keys[13]]);
        }
        if (array_key_exists($keys[14], $arr)) {
            $this->setViews($arr[$keys[14]]);
        }
        if (array_key_exists($keys[15], $arr)) {
            $this->setAddedToCartCount($arr[$keys[15]]);
        }
        if (array_key_exists($keys[16], $arr)) {
            $this->setEnableComments($arr[$keys[16]]);
        }
        if (array_key_exists($keys[17], $arr)) {
            $this->setTpl($arr[$keys[17]]);
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
     * @return $this|\SProducts The current object, for fluid interface
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
        $criteria = new Criteria(SProductsTableMap::DATABASE_NAME);

        if ($this->isColumnModified(SProductsTableMap::COL_ID)) {
            $criteria->add(SProductsTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(SProductsTableMap::COL_USER_ID)) {
            $criteria->add(SProductsTableMap::COL_USER_ID, $this->user_id);
        }
        if ($this->isColumnModified(SProductsTableMap::COL_EXTERNAL_ID)) {
            $criteria->add(SProductsTableMap::COL_EXTERNAL_ID, $this->external_id);
        }
        if ($this->isColumnModified(SProductsTableMap::COL_URL)) {
            $criteria->add(SProductsTableMap::COL_URL, $this->url);
        }
        if ($this->isColumnModified(SProductsTableMap::COL_ACTIVE)) {
            $criteria->add(SProductsTableMap::COL_ACTIVE, $this->active);
        }
        if ($this->isColumnModified(SProductsTableMap::COL_HIT)) {
            $criteria->add(SProductsTableMap::COL_HIT, $this->hit);
        }
        if ($this->isColumnModified(SProductsTableMap::COL_HOT)) {
            $criteria->add(SProductsTableMap::COL_HOT, $this->hot);
        }
        if ($this->isColumnModified(SProductsTableMap::COL_ACTION)) {
            $criteria->add(SProductsTableMap::COL_ACTION, $this->action);
        }
        if ($this->isColumnModified(SProductsTableMap::COL_BRAND_ID)) {
            $criteria->add(SProductsTableMap::COL_BRAND_ID, $this->brand_id);
        }
        if ($this->isColumnModified(SProductsTableMap::COL_CATEGORY_ID)) {
            $criteria->add(SProductsTableMap::COL_CATEGORY_ID, $this->category_id);
        }
        if ($this->isColumnModified(SProductsTableMap::COL_RELATED_PRODUCTS)) {
            $criteria->add(SProductsTableMap::COL_RELATED_PRODUCTS, $this->related_products);
        }
        if ($this->isColumnModified(SProductsTableMap::COL_OLD_PRICE)) {
            $criteria->add(SProductsTableMap::COL_OLD_PRICE, $this->old_price);
        }
        if ($this->isColumnModified(SProductsTableMap::COL_CREATED)) {
            $criteria->add(SProductsTableMap::COL_CREATED, $this->created);
        }
        if ($this->isColumnModified(SProductsTableMap::COL_UPDATED)) {
            $criteria->add(SProductsTableMap::COL_UPDATED, $this->updated);
        }
        if ($this->isColumnModified(SProductsTableMap::COL_VIEWS)) {
            $criteria->add(SProductsTableMap::COL_VIEWS, $this->views);
        }
        if ($this->isColumnModified(SProductsTableMap::COL_ADDED_TO_CART_COUNT)) {
            $criteria->add(SProductsTableMap::COL_ADDED_TO_CART_COUNT, $this->added_to_cart_count);
        }
        if ($this->isColumnModified(SProductsTableMap::COL_ENABLE_COMMENTS)) {
            $criteria->add(SProductsTableMap::COL_ENABLE_COMMENTS, $this->enable_comments);
        }
        if ($this->isColumnModified(SProductsTableMap::COL_TPL)) {
            $criteria->add(SProductsTableMap::COL_TPL, $this->tpl);
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
        $criteria = ChildSProductsQuery::create();
        $criteria->add(SProductsTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \SProducts (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setUserId($this->getUserId());
        $copyObj->setExternalId($this->getExternalId());
        $copyObj->setUrl($this->getUrl());
        $copyObj->setActive($this->getActive());
        $copyObj->setHit($this->getHit());
        $copyObj->setHot($this->getHot());
        $copyObj->setAction($this->getAction());
        $copyObj->setBrandId($this->getBrandId());
        $copyObj->setCategoryId($this->getCategoryId());
        $copyObj->setRelatedProducts($this->getRelatedProducts());
        $copyObj->setOldPrice($this->getOldPrice());
        $copyObj->setCreated($this->getCreated());
        $copyObj->setUpdated($this->getUpdated());
        $copyObj->setViews($this->getViews());
        $copyObj->setAddedToCartCount($this->getAddedToCartCount());
        $copyObj->setEnableComments($this->getEnableComments());
        $copyObj->setTpl($this->getTpl());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getShopKits() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addShopKit($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getShopKitProducts() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addShopKitProduct($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getSProductsI18ns() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addSProductsI18n($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getSProductImagess() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addSProductImages($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getProductVariants() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addProductVariant($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getSWarehouseDatas() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addSWarehouseData($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getShopProductCategoriess() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addShopProductCategories($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getSProductPropertiesDatas() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addSProductPropertiesData($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getSNotificationss() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addSNotifications($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getSOrderProductss() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addSOrderProducts($relObj->copy($deepCopy));
                }
            }

            $relObj = $this->getSProductsRating();
            if ($relObj) {
                $copyObj->setSProductsRating($relObj->copy($deepCopy));
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
     * @return \SProducts Clone of current object.
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
     * Declares an association between this object and a ChildSBrands object.
     *
     * @param  ChildSBrands $v
     * @return $this|\SProducts The current object (for fluent API support)
     * @throws PropelException
     */
    public function setBrand(ChildSBrands $v = null)
    {
        if ($v === null) {
            $this->setBrandId(NULL);
        } else {
            $this->setBrandId($v->getId());
        }

        $this->aBrand = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildSBrands object, it will not be re-added.
        if ($v !== null) {
            $v->addSProducts($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildSBrands object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildSBrands The associated ChildSBrands object.
     * @throws PropelException
     */
    public function getBrand(ConnectionInterface $con = null)
    {
        if ($this->aBrand === null && ($this->brand_id !== null)) {
            $this->aBrand = ChildSBrandsQuery::create()->findPk($this->brand_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aBrand->addSProductss($this);
             */
        }

        return $this->aBrand;
    }

    /**
     * Declares an association between this object and a ChildSCategory object.
     *
     * @param  ChildSCategory $v
     * @return $this|\SProducts The current object (for fluent API support)
     * @throws PropelException
     */
    public function setMainCategory(ChildSCategory $v = null)
    {
        if ($v === null) {
            $this->setCategoryId(NULL);
        } else {
            $this->setCategoryId($v->getId());
        }

        $this->aMainCategory = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildSCategory object, it will not be re-added.
        if ($v !== null) {
            $v->addSProducts($this);
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
    public function getMainCategory(ConnectionInterface $con = null)
    {
        if ($this->aMainCategory === null && ($this->category_id !== null)) {
            $this->aMainCategory = ChildSCategoryQuery::create()->findPk($this->category_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aMainCategory->addSProductss($this);
             */
        }

        return $this->aMainCategory;
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
        if ('ShopKit' == $relationName) {
            return $this->initShopKits();
        }
        if ('ShopKitProduct' == $relationName) {
            return $this->initShopKitProducts();
        }
        if ('SProductsI18n' == $relationName) {
            return $this->initSProductsI18ns();
        }
        if ('SProductImages' == $relationName) {
            return $this->initSProductImagess();
        }
        if ('ProductVariant' == $relationName) {
            return $this->initProductVariants();
        }
        if ('SWarehouseData' == $relationName) {
            return $this->initSWarehouseDatas();
        }
        if ('ShopProductCategories' == $relationName) {
            return $this->initShopProductCategoriess();
        }
        if ('SProductPropertiesData' == $relationName) {
            return $this->initSProductPropertiesDatas();
        }
        if ('SNotifications' == $relationName) {
            return $this->initSNotificationss();
        }
        if ('SOrderProducts' == $relationName) {
            return $this->initSOrderProductss();
        }
    }

    /**
     * Clears out the collShopKits collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addShopKits()
     */
    public function clearShopKits()
    {
        $this->collShopKits = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collShopKits collection loaded partially.
     */
    public function resetPartialShopKits($v = true)
    {
        $this->collShopKitsPartial = $v;
    }

    /**
     * Initializes the collShopKits collection.
     *
     * By default this just sets the collShopKits collection to an empty array (like clearcollShopKits());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initShopKits($overrideExisting = true)
    {
        if (null !== $this->collShopKits && !$overrideExisting) {
            return;
        }
        $this->collShopKits = new ObjectCollection();
        $this->collShopKits->setModel('\ShopKit');
    }

    /**
     * Gets an array of ChildShopKit objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildSProducts is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildShopKit[] List of ChildShopKit objects
     * @throws PropelException
     */
    public function getShopKits(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collShopKitsPartial && !$this->isNew();
        if (null === $this->collShopKits || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collShopKits) {
                // return empty collection
                $this->initShopKits();
            } else {
                $collShopKits = ChildShopKitQuery::create(null, $criteria)
                    ->filterBySProducts($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collShopKitsPartial && count($collShopKits)) {
                        $this->initShopKits(false);

                        foreach ($collShopKits as $obj) {
                            if (false == $this->collShopKits->contains($obj)) {
                                $this->collShopKits->append($obj);
                            }
                        }

                        $this->collShopKitsPartial = true;
                    }

                    return $collShopKits;
                }

                if ($partial && $this->collShopKits) {
                    foreach ($this->collShopKits as $obj) {
                        if ($obj->isNew()) {
                            $collShopKits[] = $obj;
                        }
                    }
                }

                $this->collShopKits = $collShopKits;
                $this->collShopKitsPartial = false;
            }
        }

        return $this->collShopKits;
    }

    /**
     * Sets a collection of ChildShopKit objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $shopKits A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildSProducts The current object (for fluent API support)
     */
    public function setShopKits(Collection $shopKits, ConnectionInterface $con = null)
    {
        /** @var ChildShopKit[] $shopKitsToDelete */
        $shopKitsToDelete = $this->getShopKits(new Criteria(), $con)->diff($shopKits);


        $this->shopKitsScheduledForDeletion = $shopKitsToDelete;

        foreach ($shopKitsToDelete as $shopKitRemoved) {
            $shopKitRemoved->setSProducts(null);
        }

        $this->collShopKits = null;
        foreach ($shopKits as $shopKit) {
            $this->addShopKit($shopKit);
        }

        $this->collShopKits = $shopKits;
        $this->collShopKitsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related ShopKit objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related ShopKit objects.
     * @throws PropelException
     */
    public function countShopKits(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collShopKitsPartial && !$this->isNew();
        if (null === $this->collShopKits || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collShopKits) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getShopKits());
            }

            $query = ChildShopKitQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterBySProducts($this)
                ->count($con);
        }

        return count($this->collShopKits);
    }

    /**
     * Method called to associate a ChildShopKit object to this object
     * through the ChildShopKit foreign key attribute.
     *
     * @param  ChildShopKit $l ChildShopKit
     * @return $this|\SProducts The current object (for fluent API support)
     */
    public function addShopKit(ChildShopKit $l)
    {
        if ($this->collShopKits === null) {
            $this->initShopKits();
            $this->collShopKitsPartial = true;
        }

        if (!$this->collShopKits->contains($l)) {
            $this->doAddShopKit($l);
        }

        return $this;
    }

    /**
     * @param ChildShopKit $shopKit The ChildShopKit object to add.
     */
    protected function doAddShopKit(ChildShopKit $shopKit)
    {
        $this->collShopKits[]= $shopKit;
        $shopKit->setSProducts($this);
    }

    /**
     * @param  ChildShopKit $shopKit The ChildShopKit object to remove.
     * @return $this|ChildSProducts The current object (for fluent API support)
     */
    public function removeShopKit(ChildShopKit $shopKit)
    {
        if ($this->getShopKits()->contains($shopKit)) {
            $pos = $this->collShopKits->search($shopKit);
            $this->collShopKits->remove($pos);
            if (null === $this->shopKitsScheduledForDeletion) {
                $this->shopKitsScheduledForDeletion = clone $this->collShopKits;
                $this->shopKitsScheduledForDeletion->clear();
            }
            $this->shopKitsScheduledForDeletion[]= $shopKit;
            $shopKit->setSProducts(null);
        }

        return $this;
    }

    /**
     * Clears out the collShopKitProducts collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addShopKitProducts()
     */
    public function clearShopKitProducts()
    {
        $this->collShopKitProducts = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collShopKitProducts collection loaded partially.
     */
    public function resetPartialShopKitProducts($v = true)
    {
        $this->collShopKitProductsPartial = $v;
    }

    /**
     * Initializes the collShopKitProducts collection.
     *
     * By default this just sets the collShopKitProducts collection to an empty array (like clearcollShopKitProducts());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initShopKitProducts($overrideExisting = true)
    {
        if (null !== $this->collShopKitProducts && !$overrideExisting) {
            return;
        }
        $this->collShopKitProducts = new ObjectCollection();
        $this->collShopKitProducts->setModel('\ShopKitProduct');
    }

    /**
     * Gets an array of ChildShopKitProduct objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildSProducts is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildShopKitProduct[] List of ChildShopKitProduct objects
     * @throws PropelException
     */
    public function getShopKitProducts(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collShopKitProductsPartial && !$this->isNew();
        if (null === $this->collShopKitProducts || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collShopKitProducts) {
                // return empty collection
                $this->initShopKitProducts();
            } else {
                $collShopKitProducts = ChildShopKitProductQuery::create(null, $criteria)
                    ->filterBySProducts($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collShopKitProductsPartial && count($collShopKitProducts)) {
                        $this->initShopKitProducts(false);

                        foreach ($collShopKitProducts as $obj) {
                            if (false == $this->collShopKitProducts->contains($obj)) {
                                $this->collShopKitProducts->append($obj);
                            }
                        }

                        $this->collShopKitProductsPartial = true;
                    }

                    return $collShopKitProducts;
                }

                if ($partial && $this->collShopKitProducts) {
                    foreach ($this->collShopKitProducts as $obj) {
                        if ($obj->isNew()) {
                            $collShopKitProducts[] = $obj;
                        }
                    }
                }

                $this->collShopKitProducts = $collShopKitProducts;
                $this->collShopKitProductsPartial = false;
            }
        }

        return $this->collShopKitProducts;
    }

    /**
     * Sets a collection of ChildShopKitProduct objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $shopKitProducts A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildSProducts The current object (for fluent API support)
     */
    public function setShopKitProducts(Collection $shopKitProducts, ConnectionInterface $con = null)
    {
        /** @var ChildShopKitProduct[] $shopKitProductsToDelete */
        $shopKitProductsToDelete = $this->getShopKitProducts(new Criteria(), $con)->diff($shopKitProducts);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->shopKitProductsScheduledForDeletion = clone $shopKitProductsToDelete;

        foreach ($shopKitProductsToDelete as $shopKitProductRemoved) {
            $shopKitProductRemoved->setSProducts(null);
        }

        $this->collShopKitProducts = null;
        foreach ($shopKitProducts as $shopKitProduct) {
            $this->addShopKitProduct($shopKitProduct);
        }

        $this->collShopKitProducts = $shopKitProducts;
        $this->collShopKitProductsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related ShopKitProduct objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related ShopKitProduct objects.
     * @throws PropelException
     */
    public function countShopKitProducts(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collShopKitProductsPartial && !$this->isNew();
        if (null === $this->collShopKitProducts || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collShopKitProducts) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getShopKitProducts());
            }

            $query = ChildShopKitProductQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterBySProducts($this)
                ->count($con);
        }

        return count($this->collShopKitProducts);
    }

    /**
     * Method called to associate a ChildShopKitProduct object to this object
     * through the ChildShopKitProduct foreign key attribute.
     *
     * @param  ChildShopKitProduct $l ChildShopKitProduct
     * @return $this|\SProducts The current object (for fluent API support)
     */
    public function addShopKitProduct(ChildShopKitProduct $l)
    {
        if ($this->collShopKitProducts === null) {
            $this->initShopKitProducts();
            $this->collShopKitProductsPartial = true;
        }

        if (!$this->collShopKitProducts->contains($l)) {
            $this->doAddShopKitProduct($l);
        }

        return $this;
    }

    /**
     * @param ChildShopKitProduct $shopKitProduct The ChildShopKitProduct object to add.
     */
    protected function doAddShopKitProduct(ChildShopKitProduct $shopKitProduct)
    {
        $this->collShopKitProducts[]= $shopKitProduct;
        $shopKitProduct->setSProducts($this);
    }

    /**
     * @param  ChildShopKitProduct $shopKitProduct The ChildShopKitProduct object to remove.
     * @return $this|ChildSProducts The current object (for fluent API support)
     */
    public function removeShopKitProduct(ChildShopKitProduct $shopKitProduct)
    {
        if ($this->getShopKitProducts()->contains($shopKitProduct)) {
            $pos = $this->collShopKitProducts->search($shopKitProduct);
            $this->collShopKitProducts->remove($pos);
            if (null === $this->shopKitProductsScheduledForDeletion) {
                $this->shopKitProductsScheduledForDeletion = clone $this->collShopKitProducts;
                $this->shopKitProductsScheduledForDeletion->clear();
            }
            $this->shopKitProductsScheduledForDeletion[]= clone $shopKitProduct;
            $shopKitProduct->setSProducts(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this SProducts is new, it will return
     * an empty collection; or if this SProducts has previously
     * been saved, it will retrieve related ShopKitProducts from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in SProducts.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildShopKitProduct[] List of ChildShopKitProduct objects
     */
    public function getShopKitProductsJoinSProductVariants(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildShopKitProductQuery::create(null, $criteria);
        $query->joinWith('SProductVariants', $joinBehavior);

        return $this->getShopKitProducts($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this SProducts is new, it will return
     * an empty collection; or if this SProducts has previously
     * been saved, it will retrieve related ShopKitProducts from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in SProducts.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildShopKitProduct[] List of ChildShopKitProduct objects
     */
    public function getShopKitProductsJoinShopKit(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildShopKitProductQuery::create(null, $criteria);
        $query->joinWith('ShopKit', $joinBehavior);

        return $this->getShopKitProducts($query, $con);
    }

    /**
     * Clears out the collSProductsI18ns collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addSProductsI18ns()
     */
    public function clearSProductsI18ns()
    {
        $this->collSProductsI18ns = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collSProductsI18ns collection loaded partially.
     */
    public function resetPartialSProductsI18ns($v = true)
    {
        $this->collSProductsI18nsPartial = $v;
    }

    /**
     * Initializes the collSProductsI18ns collection.
     *
     * By default this just sets the collSProductsI18ns collection to an empty array (like clearcollSProductsI18ns());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initSProductsI18ns($overrideExisting = true)
    {
        if (null !== $this->collSProductsI18ns && !$overrideExisting) {
            return;
        }
        $this->collSProductsI18ns = new ObjectCollection();
        $this->collSProductsI18ns->setModel('\SProductsI18n');
    }

    /**
     * Gets an array of ChildSProductsI18n objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildSProducts is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildSProductsI18n[] List of ChildSProductsI18n objects
     * @throws PropelException
     */
    public function getSProductsI18ns(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collSProductsI18nsPartial && !$this->isNew();
        if (null === $this->collSProductsI18ns || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collSProductsI18ns) {
                // return empty collection
                $this->initSProductsI18ns();
            } else {
                $collSProductsI18ns = ChildSProductsI18nQuery::create(null, $criteria)
                    ->filterBySProducts($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collSProductsI18nsPartial && count($collSProductsI18ns)) {
                        $this->initSProductsI18ns(false);

                        foreach ($collSProductsI18ns as $obj) {
                            if (false == $this->collSProductsI18ns->contains($obj)) {
                                $this->collSProductsI18ns->append($obj);
                            }
                        }

                        $this->collSProductsI18nsPartial = true;
                    }

                    return $collSProductsI18ns;
                }

                if ($partial && $this->collSProductsI18ns) {
                    foreach ($this->collSProductsI18ns as $obj) {
                        if ($obj->isNew()) {
                            $collSProductsI18ns[] = $obj;
                        }
                    }
                }

                $this->collSProductsI18ns = $collSProductsI18ns;
                $this->collSProductsI18nsPartial = false;
            }
        }

        return $this->collSProductsI18ns;
    }

    /**
     * Sets a collection of ChildSProductsI18n objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $sProductsI18ns A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildSProducts The current object (for fluent API support)
     */
    public function setSProductsI18ns(Collection $sProductsI18ns, ConnectionInterface $con = null)
    {
        /** @var ChildSProductsI18n[] $sProductsI18nsToDelete */
        $sProductsI18nsToDelete = $this->getSProductsI18ns(new Criteria(), $con)->diff($sProductsI18ns);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->sProductsI18nsScheduledForDeletion = clone $sProductsI18nsToDelete;

        foreach ($sProductsI18nsToDelete as $sProductsI18nRemoved) {
            $sProductsI18nRemoved->setSProducts(null);
        }

        $this->collSProductsI18ns = null;
        foreach ($sProductsI18ns as $sProductsI18n) {
            $this->addSProductsI18n($sProductsI18n);
        }

        $this->collSProductsI18ns = $sProductsI18ns;
        $this->collSProductsI18nsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related SProductsI18n objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related SProductsI18n objects.
     * @throws PropelException
     */
    public function countSProductsI18ns(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collSProductsI18nsPartial && !$this->isNew();
        if (null === $this->collSProductsI18ns || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collSProductsI18ns) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getSProductsI18ns());
            }

            $query = ChildSProductsI18nQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterBySProducts($this)
                ->count($con);
        }

        return count($this->collSProductsI18ns);
    }

    /**
     * Method called to associate a ChildSProductsI18n object to this object
     * through the ChildSProductsI18n foreign key attribute.
     *
     * @param  ChildSProductsI18n $l ChildSProductsI18n
     * @return $this|\SProducts The current object (for fluent API support)
     */
    public function addSProductsI18n(ChildSProductsI18n $l)
    {
        if ($l && $locale = $l->getLocale()) {
            $this->setLocale($locale);
            $this->currentTranslations[$locale] = $l;
        }
        if ($this->collSProductsI18ns === null) {
            $this->initSProductsI18ns();
            $this->collSProductsI18nsPartial = true;
        }

        if (!$this->collSProductsI18ns->contains($l)) {
            $this->doAddSProductsI18n($l);
        }

        return $this;
    }

    /**
     * @param ChildSProductsI18n $sProductsI18n The ChildSProductsI18n object to add.
     */
    protected function doAddSProductsI18n(ChildSProductsI18n $sProductsI18n)
    {
        $this->collSProductsI18ns[]= $sProductsI18n;
        $sProductsI18n->setSProducts($this);
    }

    /**
     * @param  ChildSProductsI18n $sProductsI18n The ChildSProductsI18n object to remove.
     * @return $this|ChildSProducts The current object (for fluent API support)
     */
    public function removeSProductsI18n(ChildSProductsI18n $sProductsI18n)
    {
        if ($this->getSProductsI18ns()->contains($sProductsI18n)) {
            $pos = $this->collSProductsI18ns->search($sProductsI18n);
            $this->collSProductsI18ns->remove($pos);
            if (null === $this->sProductsI18nsScheduledForDeletion) {
                $this->sProductsI18nsScheduledForDeletion = clone $this->collSProductsI18ns;
                $this->sProductsI18nsScheduledForDeletion->clear();
            }
            $this->sProductsI18nsScheduledForDeletion[]= clone $sProductsI18n;
            $sProductsI18n->setSProducts(null);
        }

        return $this;
    }

    /**
     * Clears out the collSProductImagess collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addSProductImagess()
     */
    public function clearSProductImagess()
    {
        $this->collSProductImagess = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collSProductImagess collection loaded partially.
     */
    public function resetPartialSProductImagess($v = true)
    {
        $this->collSProductImagessPartial = $v;
    }

    /**
     * Initializes the collSProductImagess collection.
     *
     * By default this just sets the collSProductImagess collection to an empty array (like clearcollSProductImagess());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initSProductImagess($overrideExisting = true)
    {
        if (null !== $this->collSProductImagess && !$overrideExisting) {
            return;
        }
        $this->collSProductImagess = new ObjectCollection();
        $this->collSProductImagess->setModel('\SProductImages');
    }

    /**
     * Gets an array of ChildSProductImages objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildSProducts is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildSProductImages[] List of ChildSProductImages objects
     * @throws PropelException
     */
    public function getSProductImagess(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collSProductImagessPartial && !$this->isNew();
        if (null === $this->collSProductImagess || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collSProductImagess) {
                // return empty collection
                $this->initSProductImagess();
            } else {
                $collSProductImagess = ChildSProductImagesQuery::create(null, $criteria)
                    ->filterBySProducts($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collSProductImagessPartial && count($collSProductImagess)) {
                        $this->initSProductImagess(false);

                        foreach ($collSProductImagess as $obj) {
                            if (false == $this->collSProductImagess->contains($obj)) {
                                $this->collSProductImagess->append($obj);
                            }
                        }

                        $this->collSProductImagessPartial = true;
                    }

                    return $collSProductImagess;
                }

                if ($partial && $this->collSProductImagess) {
                    foreach ($this->collSProductImagess as $obj) {
                        if ($obj->isNew()) {
                            $collSProductImagess[] = $obj;
                        }
                    }
                }

                $this->collSProductImagess = $collSProductImagess;
                $this->collSProductImagessPartial = false;
            }
        }

        return $this->collSProductImagess;
    }

    /**
     * Sets a collection of ChildSProductImages objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $sProductImagess A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildSProducts The current object (for fluent API support)
     */
    public function setSProductImagess(Collection $sProductImagess, ConnectionInterface $con = null)
    {
        /** @var ChildSProductImages[] $sProductImagessToDelete */
        $sProductImagessToDelete = $this->getSProductImagess(new Criteria(), $con)->diff($sProductImagess);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->sProductImagessScheduledForDeletion = clone $sProductImagessToDelete;

        foreach ($sProductImagessToDelete as $sProductImagesRemoved) {
            $sProductImagesRemoved->setSProducts(null);
        }

        $this->collSProductImagess = null;
        foreach ($sProductImagess as $sProductImages) {
            $this->addSProductImages($sProductImages);
        }

        $this->collSProductImagess = $sProductImagess;
        $this->collSProductImagessPartial = false;

        return $this;
    }

    /**
     * Returns the number of related SProductImages objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related SProductImages objects.
     * @throws PropelException
     */
    public function countSProductImagess(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collSProductImagessPartial && !$this->isNew();
        if (null === $this->collSProductImagess || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collSProductImagess) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getSProductImagess());
            }

            $query = ChildSProductImagesQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterBySProducts($this)
                ->count($con);
        }

        return count($this->collSProductImagess);
    }

    /**
     * Method called to associate a ChildSProductImages object to this object
     * through the ChildSProductImages foreign key attribute.
     *
     * @param  ChildSProductImages $l ChildSProductImages
     * @return $this|\SProducts The current object (for fluent API support)
     */
    public function addSProductImages(ChildSProductImages $l)
    {
        if ($this->collSProductImagess === null) {
            $this->initSProductImagess();
            $this->collSProductImagessPartial = true;
        }

        if (!$this->collSProductImagess->contains($l)) {
            $this->doAddSProductImages($l);
        }

        return $this;
    }

    /**
     * @param ChildSProductImages $sProductImages The ChildSProductImages object to add.
     */
    protected function doAddSProductImages(ChildSProductImages $sProductImages)
    {
        $this->collSProductImagess[]= $sProductImages;
        $sProductImages->setSProducts($this);
    }

    /**
     * @param  ChildSProductImages $sProductImages The ChildSProductImages object to remove.
     * @return $this|ChildSProducts The current object (for fluent API support)
     */
    public function removeSProductImages(ChildSProductImages $sProductImages)
    {
        if ($this->getSProductImagess()->contains($sProductImages)) {
            $pos = $this->collSProductImagess->search($sProductImages);
            $this->collSProductImagess->remove($pos);
            if (null === $this->sProductImagessScheduledForDeletion) {
                $this->sProductImagessScheduledForDeletion = clone $this->collSProductImagess;
                $this->sProductImagessScheduledForDeletion->clear();
            }
            $this->sProductImagessScheduledForDeletion[]= clone $sProductImages;
            $sProductImages->setSProducts(null);
        }

        return $this;
    }

    /**
     * Clears out the collProductVariants collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addProductVariants()
     */
    public function clearProductVariants()
    {
        $this->collProductVariants = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collProductVariants collection loaded partially.
     */
    public function resetPartialProductVariants($v = true)
    {
        $this->collProductVariantsPartial = $v;
    }

    /**
     * Initializes the collProductVariants collection.
     *
     * By default this just sets the collProductVariants collection to an empty array (like clearcollProductVariants());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initProductVariants($overrideExisting = true)
    {
        if (null !== $this->collProductVariants && !$overrideExisting) {
            return;
        }
        $this->collProductVariants = new ObjectCollection();
        $this->collProductVariants->setModel('\SProductVariants');
    }

    /**
     * Gets an array of ChildSProductVariants objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildSProducts is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildSProductVariants[] List of ChildSProductVariants objects
     * @throws PropelException
     */
    public function getProductVariants(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collProductVariantsPartial && !$this->isNew();
        if (null === $this->collProductVariants || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collProductVariants) {
                // return empty collection
                $this->initProductVariants();
            } else {
                $collProductVariants = ChildSProductVariantsQuery::create(null, $criteria)
                    ->filterBySProducts($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collProductVariantsPartial && count($collProductVariants)) {
                        $this->initProductVariants(false);

                        foreach ($collProductVariants as $obj) {
                            if (false == $this->collProductVariants->contains($obj)) {
                                $this->collProductVariants->append($obj);
                            }
                        }

                        $this->collProductVariantsPartial = true;
                    }

                    return $collProductVariants;
                }

                if ($partial && $this->collProductVariants) {
                    foreach ($this->collProductVariants as $obj) {
                        if ($obj->isNew()) {
                            $collProductVariants[] = $obj;
                        }
                    }
                }

                $this->collProductVariants = $collProductVariants;
                $this->collProductVariantsPartial = false;
            }
        }

        return $this->collProductVariants;
    }

    /**
     * Sets a collection of ChildSProductVariants objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $productVariants A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildSProducts The current object (for fluent API support)
     */
    public function setProductVariants(Collection $productVariants, ConnectionInterface $con = null)
    {
        /** @var ChildSProductVariants[] $productVariantsToDelete */
        $productVariantsToDelete = $this->getProductVariants(new Criteria(), $con)->diff($productVariants);


        $this->productVariantsScheduledForDeletion = $productVariantsToDelete;

        foreach ($productVariantsToDelete as $productVariantRemoved) {
            $productVariantRemoved->setSProducts(null);
        }

        $this->collProductVariants = null;
        foreach ($productVariants as $productVariant) {
            $this->addProductVariant($productVariant);
        }

        $this->collProductVariants = $productVariants;
        $this->collProductVariantsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related SProductVariants objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related SProductVariants objects.
     * @throws PropelException
     */
    public function countProductVariants(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collProductVariantsPartial && !$this->isNew();
        if (null === $this->collProductVariants || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collProductVariants) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getProductVariants());
            }

            $query = ChildSProductVariantsQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterBySProducts($this)
                ->count($con);
        }

        return count($this->collProductVariants);
    }

    /**
     * Method called to associate a ChildSProductVariants object to this object
     * through the ChildSProductVariants foreign key attribute.
     *
     * @param  ChildSProductVariants $l ChildSProductVariants
     * @return $this|\SProducts The current object (for fluent API support)
     */
    public function addProductVariant(ChildSProductVariants $l)
    {
        if ($this->collProductVariants === null) {
            $this->initProductVariants();
            $this->collProductVariantsPartial = true;
        }

        if (!$this->collProductVariants->contains($l)) {
            $this->doAddProductVariant($l);
        }

        return $this;
    }

    /**
     * @param ChildSProductVariants $productVariant The ChildSProductVariants object to add.
     */
    protected function doAddProductVariant(ChildSProductVariants $productVariant)
    {
        $this->collProductVariants[]= $productVariant;
        $productVariant->setSProducts($this);
    }

    /**
     * @param  ChildSProductVariants $productVariant The ChildSProductVariants object to remove.
     * @return $this|ChildSProducts The current object (for fluent API support)
     */
    public function removeProductVariant(ChildSProductVariants $productVariant)
    {
        if ($this->getProductVariants()->contains($productVariant)) {
            $pos = $this->collProductVariants->search($productVariant);
            $this->collProductVariants->remove($pos);
            if (null === $this->productVariantsScheduledForDeletion) {
                $this->productVariantsScheduledForDeletion = clone $this->collProductVariants;
                $this->productVariantsScheduledForDeletion->clear();
            }
            $this->productVariantsScheduledForDeletion[]= clone $productVariant;
            $productVariant->setSProducts(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this SProducts is new, it will return
     * an empty collection; or if this SProducts has previously
     * been saved, it will retrieve related ProductVariants from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in SProducts.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildSProductVariants[] List of ChildSProductVariants objects
     */
    public function getProductVariantsJoinSCurrencies(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildSProductVariantsQuery::create(null, $criteria);
        $query->joinWith('SCurrencies', $joinBehavior);

        return $this->getProductVariants($query, $con);
    }

    /**
     * Clears out the collSWarehouseDatas collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addSWarehouseDatas()
     */
    public function clearSWarehouseDatas()
    {
        $this->collSWarehouseDatas = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collSWarehouseDatas collection loaded partially.
     */
    public function resetPartialSWarehouseDatas($v = true)
    {
        $this->collSWarehouseDatasPartial = $v;
    }

    /**
     * Initializes the collSWarehouseDatas collection.
     *
     * By default this just sets the collSWarehouseDatas collection to an empty array (like clearcollSWarehouseDatas());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initSWarehouseDatas($overrideExisting = true)
    {
        if (null !== $this->collSWarehouseDatas && !$overrideExisting) {
            return;
        }
        $this->collSWarehouseDatas = new ObjectCollection();
        $this->collSWarehouseDatas->setModel('\SWarehouseData');
    }

    /**
     * Gets an array of ChildSWarehouseData objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildSProducts is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildSWarehouseData[] List of ChildSWarehouseData objects
     * @throws PropelException
     */
    public function getSWarehouseDatas(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collSWarehouseDatasPartial && !$this->isNew();
        if (null === $this->collSWarehouseDatas || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collSWarehouseDatas) {
                // return empty collection
                $this->initSWarehouseDatas();
            } else {
                $collSWarehouseDatas = ChildSWarehouseDataQuery::create(null, $criteria)
                    ->filterBySProducts($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collSWarehouseDatasPartial && count($collSWarehouseDatas)) {
                        $this->initSWarehouseDatas(false);

                        foreach ($collSWarehouseDatas as $obj) {
                            if (false == $this->collSWarehouseDatas->contains($obj)) {
                                $this->collSWarehouseDatas->append($obj);
                            }
                        }

                        $this->collSWarehouseDatasPartial = true;
                    }

                    return $collSWarehouseDatas;
                }

                if ($partial && $this->collSWarehouseDatas) {
                    foreach ($this->collSWarehouseDatas as $obj) {
                        if ($obj->isNew()) {
                            $collSWarehouseDatas[] = $obj;
                        }
                    }
                }

                $this->collSWarehouseDatas = $collSWarehouseDatas;
                $this->collSWarehouseDatasPartial = false;
            }
        }

        return $this->collSWarehouseDatas;
    }

    /**
     * Sets a collection of ChildSWarehouseData objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $sWarehouseDatas A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildSProducts The current object (for fluent API support)
     */
    public function setSWarehouseDatas(Collection $sWarehouseDatas, ConnectionInterface $con = null)
    {
        /** @var ChildSWarehouseData[] $sWarehouseDatasToDelete */
        $sWarehouseDatasToDelete = $this->getSWarehouseDatas(new Criteria(), $con)->diff($sWarehouseDatas);


        $this->sWarehouseDatasScheduledForDeletion = $sWarehouseDatasToDelete;

        foreach ($sWarehouseDatasToDelete as $sWarehouseDataRemoved) {
            $sWarehouseDataRemoved->setSProducts(null);
        }

        $this->collSWarehouseDatas = null;
        foreach ($sWarehouseDatas as $sWarehouseData) {
            $this->addSWarehouseData($sWarehouseData);
        }

        $this->collSWarehouseDatas = $sWarehouseDatas;
        $this->collSWarehouseDatasPartial = false;

        return $this;
    }

    /**
     * Returns the number of related SWarehouseData objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related SWarehouseData objects.
     * @throws PropelException
     */
    public function countSWarehouseDatas(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collSWarehouseDatasPartial && !$this->isNew();
        if (null === $this->collSWarehouseDatas || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collSWarehouseDatas) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getSWarehouseDatas());
            }

            $query = ChildSWarehouseDataQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterBySProducts($this)
                ->count($con);
        }

        return count($this->collSWarehouseDatas);
    }

    /**
     * Method called to associate a ChildSWarehouseData object to this object
     * through the ChildSWarehouseData foreign key attribute.
     *
     * @param  ChildSWarehouseData $l ChildSWarehouseData
     * @return $this|\SProducts The current object (for fluent API support)
     */
    public function addSWarehouseData(ChildSWarehouseData $l)
    {
        if ($this->collSWarehouseDatas === null) {
            $this->initSWarehouseDatas();
            $this->collSWarehouseDatasPartial = true;
        }

        if (!$this->collSWarehouseDatas->contains($l)) {
            $this->doAddSWarehouseData($l);
        }

        return $this;
    }

    /**
     * @param ChildSWarehouseData $sWarehouseData The ChildSWarehouseData object to add.
     */
    protected function doAddSWarehouseData(ChildSWarehouseData $sWarehouseData)
    {
        $this->collSWarehouseDatas[]= $sWarehouseData;
        $sWarehouseData->setSProducts($this);
    }

    /**
     * @param  ChildSWarehouseData $sWarehouseData The ChildSWarehouseData object to remove.
     * @return $this|ChildSProducts The current object (for fluent API support)
     */
    public function removeSWarehouseData(ChildSWarehouseData $sWarehouseData)
    {
        if ($this->getSWarehouseDatas()->contains($sWarehouseData)) {
            $pos = $this->collSWarehouseDatas->search($sWarehouseData);
            $this->collSWarehouseDatas->remove($pos);
            if (null === $this->sWarehouseDatasScheduledForDeletion) {
                $this->sWarehouseDatasScheduledForDeletion = clone $this->collSWarehouseDatas;
                $this->sWarehouseDatasScheduledForDeletion->clear();
            }
            $this->sWarehouseDatasScheduledForDeletion[]= clone $sWarehouseData;
            $sWarehouseData->setSProducts(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this SProducts is new, it will return
     * an empty collection; or if this SProducts has previously
     * been saved, it will retrieve related SWarehouseDatas from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in SProducts.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildSWarehouseData[] List of ChildSWarehouseData objects
     */
    public function getSWarehouseDatasJoinSWarehouses(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildSWarehouseDataQuery::create(null, $criteria);
        $query->joinWith('SWarehouses', $joinBehavior);

        return $this->getSWarehouseDatas($query, $con);
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
     * If this ChildSProducts is new, it will return
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
                    ->filterByProduct($this)
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
     * @return $this|ChildSProducts The current object (for fluent API support)
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
            $shopProductCategoriesRemoved->setProduct(null);
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
                ->filterByProduct($this)
                ->count($con);
        }

        return count($this->collShopProductCategoriess);
    }

    /**
     * Method called to associate a ChildShopProductCategories object to this object
     * through the ChildShopProductCategories foreign key attribute.
     *
     * @param  ChildShopProductCategories $l ChildShopProductCategories
     * @return $this|\SProducts The current object (for fluent API support)
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
        $shopProductCategories->setProduct($this);
    }

    /**
     * @param  ChildShopProductCategories $shopProductCategories The ChildShopProductCategories object to remove.
     * @return $this|ChildSProducts The current object (for fluent API support)
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
            $shopProductCategories->setProduct(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this SProducts is new, it will return
     * an empty collection; or if this SProducts has previously
     * been saved, it will retrieve related ShopProductCategoriess from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in SProducts.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildShopProductCategories[] List of ChildShopProductCategories objects
     */
    public function getShopProductCategoriessJoinCategory(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildShopProductCategoriesQuery::create(null, $criteria);
        $query->joinWith('Category', $joinBehavior);

        return $this->getShopProductCategoriess($query, $con);
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
     * If this ChildSProducts is new, it will return
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
                    ->filterByProduct($this)
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
     * @return $this|ChildSProducts The current object (for fluent API support)
     */
    public function setSProductPropertiesDatas(Collection $sProductPropertiesDatas, ConnectionInterface $con = null)
    {
        /** @var ChildSProductPropertiesData[] $sProductPropertiesDatasToDelete */
        $sProductPropertiesDatasToDelete = $this->getSProductPropertiesDatas(new Criteria(), $con)->diff($sProductPropertiesDatas);


        $this->sProductPropertiesDatasScheduledForDeletion = $sProductPropertiesDatasToDelete;

        foreach ($sProductPropertiesDatasToDelete as $sProductPropertiesDataRemoved) {
            $sProductPropertiesDataRemoved->setProduct(null);
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
                ->filterByProduct($this)
                ->count($con);
        }

        return count($this->collSProductPropertiesDatas);
    }

    /**
     * Method called to associate a ChildSProductPropertiesData object to this object
     * through the ChildSProductPropertiesData foreign key attribute.
     *
     * @param  ChildSProductPropertiesData $l ChildSProductPropertiesData
     * @return $this|\SProducts The current object (for fluent API support)
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
        $sProductPropertiesData->setProduct($this);
    }

    /**
     * @param  ChildSProductPropertiesData $sProductPropertiesData The ChildSProductPropertiesData object to remove.
     * @return $this|ChildSProducts The current object (for fluent API support)
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
            $sProductPropertiesData->setProduct(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this SProducts is new, it will return
     * an empty collection; or if this SProducts has previously
     * been saved, it will retrieve related SProductPropertiesDatas from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in SProducts.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildSProductPropertiesData[] List of ChildSProductPropertiesData objects
     */
    public function getSProductPropertiesDatasJoinSProperties(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildSProductPropertiesDataQuery::create(null, $criteria);
        $query->joinWith('SProperties', $joinBehavior);

        return $this->getSProductPropertiesDatas($query, $con);
    }

    /**
     * Clears out the collSNotificationss collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addSNotificationss()
     */
    public function clearSNotificationss()
    {
        $this->collSNotificationss = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collSNotificationss collection loaded partially.
     */
    public function resetPartialSNotificationss($v = true)
    {
        $this->collSNotificationssPartial = $v;
    }

    /**
     * Initializes the collSNotificationss collection.
     *
     * By default this just sets the collSNotificationss collection to an empty array (like clearcollSNotificationss());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initSNotificationss($overrideExisting = true)
    {
        if (null !== $this->collSNotificationss && !$overrideExisting) {
            return;
        }
        $this->collSNotificationss = new ObjectCollection();
        $this->collSNotificationss->setModel('\SNotifications');
    }

    /**
     * Gets an array of ChildSNotifications objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildSProducts is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildSNotifications[] List of ChildSNotifications objects
     * @throws PropelException
     */
    public function getSNotificationss(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collSNotificationssPartial && !$this->isNew();
        if (null === $this->collSNotificationss || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collSNotificationss) {
                // return empty collection
                $this->initSNotificationss();
            } else {
                $collSNotificationss = ChildSNotificationsQuery::create(null, $criteria)
                    ->filterBySProducts($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collSNotificationssPartial && count($collSNotificationss)) {
                        $this->initSNotificationss(false);

                        foreach ($collSNotificationss as $obj) {
                            if (false == $this->collSNotificationss->contains($obj)) {
                                $this->collSNotificationss->append($obj);
                            }
                        }

                        $this->collSNotificationssPartial = true;
                    }

                    return $collSNotificationss;
                }

                if ($partial && $this->collSNotificationss) {
                    foreach ($this->collSNotificationss as $obj) {
                        if ($obj->isNew()) {
                            $collSNotificationss[] = $obj;
                        }
                    }
                }

                $this->collSNotificationss = $collSNotificationss;
                $this->collSNotificationssPartial = false;
            }
        }

        return $this->collSNotificationss;
    }

    /**
     * Sets a collection of ChildSNotifications objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $sNotificationss A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildSProducts The current object (for fluent API support)
     */
    public function setSNotificationss(Collection $sNotificationss, ConnectionInterface $con = null)
    {
        /** @var ChildSNotifications[] $sNotificationssToDelete */
        $sNotificationssToDelete = $this->getSNotificationss(new Criteria(), $con)->diff($sNotificationss);


        $this->sNotificationssScheduledForDeletion = $sNotificationssToDelete;

        foreach ($sNotificationssToDelete as $sNotificationsRemoved) {
            $sNotificationsRemoved->setSProducts(null);
        }

        $this->collSNotificationss = null;
        foreach ($sNotificationss as $sNotifications) {
            $this->addSNotifications($sNotifications);
        }

        $this->collSNotificationss = $sNotificationss;
        $this->collSNotificationssPartial = false;

        return $this;
    }

    /**
     * Returns the number of related SNotifications objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related SNotifications objects.
     * @throws PropelException
     */
    public function countSNotificationss(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collSNotificationssPartial && !$this->isNew();
        if (null === $this->collSNotificationss || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collSNotificationss) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getSNotificationss());
            }

            $query = ChildSNotificationsQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterBySProducts($this)
                ->count($con);
        }

        return count($this->collSNotificationss);
    }

    /**
     * Method called to associate a ChildSNotifications object to this object
     * through the ChildSNotifications foreign key attribute.
     *
     * @param  ChildSNotifications $l ChildSNotifications
     * @return $this|\SProducts The current object (for fluent API support)
     */
    public function addSNotifications(ChildSNotifications $l)
    {
        if ($this->collSNotificationss === null) {
            $this->initSNotificationss();
            $this->collSNotificationssPartial = true;
        }

        if (!$this->collSNotificationss->contains($l)) {
            $this->doAddSNotifications($l);
        }

        return $this;
    }

    /**
     * @param ChildSNotifications $sNotifications The ChildSNotifications object to add.
     */
    protected function doAddSNotifications(ChildSNotifications $sNotifications)
    {
        $this->collSNotificationss[]= $sNotifications;
        $sNotifications->setSProducts($this);
    }

    /**
     * @param  ChildSNotifications $sNotifications The ChildSNotifications object to remove.
     * @return $this|ChildSProducts The current object (for fluent API support)
     */
    public function removeSNotifications(ChildSNotifications $sNotifications)
    {
        if ($this->getSNotificationss()->contains($sNotifications)) {
            $pos = $this->collSNotificationss->search($sNotifications);
            $this->collSNotificationss->remove($pos);
            if (null === $this->sNotificationssScheduledForDeletion) {
                $this->sNotificationssScheduledForDeletion = clone $this->collSNotificationss;
                $this->sNotificationssScheduledForDeletion->clear();
            }
            $this->sNotificationssScheduledForDeletion[]= clone $sNotifications;
            $sNotifications->setSProducts(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this SProducts is new, it will return
     * an empty collection; or if this SProducts has previously
     * been saved, it will retrieve related SNotificationss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in SProducts.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildSNotifications[] List of ChildSNotifications objects
     */
    public function getSNotificationssJoinSProductVariants(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildSNotificationsQuery::create(null, $criteria);
        $query->joinWith('SProductVariants', $joinBehavior);

        return $this->getSNotificationss($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this SProducts is new, it will return
     * an empty collection; or if this SProducts has previously
     * been saved, it will retrieve related SNotificationss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in SProducts.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildSNotifications[] List of ChildSNotifications objects
     */
    public function getSNotificationssJoinSNotificationStatuses(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildSNotificationsQuery::create(null, $criteria);
        $query->joinWith('SNotificationStatuses', $joinBehavior);

        return $this->getSNotificationss($query, $con);
    }

    /**
     * Clears out the collSOrderProductss collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addSOrderProductss()
     */
    public function clearSOrderProductss()
    {
        $this->collSOrderProductss = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collSOrderProductss collection loaded partially.
     */
    public function resetPartialSOrderProductss($v = true)
    {
        $this->collSOrderProductssPartial = $v;
    }

    /**
     * Initializes the collSOrderProductss collection.
     *
     * By default this just sets the collSOrderProductss collection to an empty array (like clearcollSOrderProductss());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initSOrderProductss($overrideExisting = true)
    {
        if (null !== $this->collSOrderProductss && !$overrideExisting) {
            return;
        }
        $this->collSOrderProductss = new ObjectCollection();
        $this->collSOrderProductss->setModel('\SOrderProducts');
    }

    /**
     * Gets an array of ChildSOrderProducts objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildSProducts is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildSOrderProducts[] List of ChildSOrderProducts objects
     * @throws PropelException
     */
    public function getSOrderProductss(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collSOrderProductssPartial && !$this->isNew();
        if (null === $this->collSOrderProductss || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collSOrderProductss) {
                // return empty collection
                $this->initSOrderProductss();
            } else {
                $collSOrderProductss = ChildSOrderProductsQuery::create(null, $criteria)
                    ->filterBySProducts($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collSOrderProductssPartial && count($collSOrderProductss)) {
                        $this->initSOrderProductss(false);

                        foreach ($collSOrderProductss as $obj) {
                            if (false == $this->collSOrderProductss->contains($obj)) {
                                $this->collSOrderProductss->append($obj);
                            }
                        }

                        $this->collSOrderProductssPartial = true;
                    }

                    return $collSOrderProductss;
                }

                if ($partial && $this->collSOrderProductss) {
                    foreach ($this->collSOrderProductss as $obj) {
                        if ($obj->isNew()) {
                            $collSOrderProductss[] = $obj;
                        }
                    }
                }

                $this->collSOrderProductss = $collSOrderProductss;
                $this->collSOrderProductssPartial = false;
            }
        }

        return $this->collSOrderProductss;
    }

    /**
     * Sets a collection of ChildSOrderProducts objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $sOrderProductss A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildSProducts The current object (for fluent API support)
     */
    public function setSOrderProductss(Collection $sOrderProductss, ConnectionInterface $con = null)
    {
        /** @var ChildSOrderProducts[] $sOrderProductssToDelete */
        $sOrderProductssToDelete = $this->getSOrderProductss(new Criteria(), $con)->diff($sOrderProductss);


        $this->sOrderProductssScheduledForDeletion = $sOrderProductssToDelete;

        foreach ($sOrderProductssToDelete as $sOrderProductsRemoved) {
            $sOrderProductsRemoved->setSProducts(null);
        }

        $this->collSOrderProductss = null;
        foreach ($sOrderProductss as $sOrderProducts) {
            $this->addSOrderProducts($sOrderProducts);
        }

        $this->collSOrderProductss = $sOrderProductss;
        $this->collSOrderProductssPartial = false;

        return $this;
    }

    /**
     * Returns the number of related SOrderProducts objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related SOrderProducts objects.
     * @throws PropelException
     */
    public function countSOrderProductss(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collSOrderProductssPartial && !$this->isNew();
        if (null === $this->collSOrderProductss || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collSOrderProductss) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getSOrderProductss());
            }

            $query = ChildSOrderProductsQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterBySProducts($this)
                ->count($con);
        }

        return count($this->collSOrderProductss);
    }

    /**
     * Method called to associate a ChildSOrderProducts object to this object
     * through the ChildSOrderProducts foreign key attribute.
     *
     * @param  ChildSOrderProducts $l ChildSOrderProducts
     * @return $this|\SProducts The current object (for fluent API support)
     */
    public function addSOrderProducts(ChildSOrderProducts $l)
    {
        if ($this->collSOrderProductss === null) {
            $this->initSOrderProductss();
            $this->collSOrderProductssPartial = true;
        }

        if (!$this->collSOrderProductss->contains($l)) {
            $this->doAddSOrderProducts($l);
        }

        return $this;
    }

    /**
     * @param ChildSOrderProducts $sOrderProducts The ChildSOrderProducts object to add.
     */
    protected function doAddSOrderProducts(ChildSOrderProducts $sOrderProducts)
    {
        $this->collSOrderProductss[]= $sOrderProducts;
        $sOrderProducts->setSProducts($this);
    }

    /**
     * @param  ChildSOrderProducts $sOrderProducts The ChildSOrderProducts object to remove.
     * @return $this|ChildSProducts The current object (for fluent API support)
     */
    public function removeSOrderProducts(ChildSOrderProducts $sOrderProducts)
    {
        if ($this->getSOrderProductss()->contains($sOrderProducts)) {
            $pos = $this->collSOrderProductss->search($sOrderProducts);
            $this->collSOrderProductss->remove($pos);
            if (null === $this->sOrderProductssScheduledForDeletion) {
                $this->sOrderProductssScheduledForDeletion = clone $this->collSOrderProductss;
                $this->sOrderProductssScheduledForDeletion->clear();
            }
            $this->sOrderProductssScheduledForDeletion[]= clone $sOrderProducts;
            $sOrderProducts->setSProducts(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this SProducts is new, it will return
     * an empty collection; or if this SProducts has previously
     * been saved, it will retrieve related SOrderProductss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in SProducts.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildSOrderProducts[] List of ChildSOrderProducts objects
     */
    public function getSOrderProductssJoinSProductVariants(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildSOrderProductsQuery::create(null, $criteria);
        $query->joinWith('SProductVariants', $joinBehavior);

        return $this->getSOrderProductss($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this SProducts is new, it will return
     * an empty collection; or if this SProducts has previously
     * been saved, it will retrieve related SOrderProductss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in SProducts.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildSOrderProducts[] List of ChildSOrderProducts objects
     */
    public function getSOrderProductssJoinSOrders(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildSOrderProductsQuery::create(null, $criteria);
        $query->joinWith('SOrders', $joinBehavior);

        return $this->getSOrderProductss($query, $con);
    }

    /**
     * Gets a single ChildSProductsRating object, which is related to this object by a one-to-one relationship.
     *
     * @param  ConnectionInterface $con optional connection object
     * @return ChildSProductsRating
     * @throws PropelException
     */
    public function getSProductsRating(ConnectionInterface $con = null)
    {

        if ($this->singleSProductsRating === null && !$this->isNew()) {
            $this->singleSProductsRating = ChildSProductsRatingQuery::create()->findPk($this->getPrimaryKey(), $con);
        }

        return $this->singleSProductsRating;
    }

    /**
     * Sets a single ChildSProductsRating object as related to this object by a one-to-one relationship.
     *
     * @param  ChildSProductsRating $v ChildSProductsRating
     * @return $this|\SProducts The current object (for fluent API support)
     * @throws PropelException
     */
    public function setSProductsRating(ChildSProductsRating $v = null)
    {
        $this->singleSProductsRating = $v;

        // Make sure that that the passed-in ChildSProductsRating isn't already associated with this object
        if ($v !== null && $v->getSProducts(null, false) === null) {
            $v->setSProducts($this);
        }

        return $this;
    }

    /**
     * Clears out the collCategories collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addCategories()
     */
    public function clearCategories()
    {
        $this->collCategories = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Initializes the collCategories crossRef collection.
     *
     * By default this just sets the collCategories collection to an empty collection (like clearCategories());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initCategories()
    {
        $this->collCategories = new ObjectCollection();
        $this->collCategoriesPartial = true;

        $this->collCategories->setModel('\SCategory');
    }

    /**
     * Checks if the collCategories collection is loaded.
     *
     * @return bool
     */
    public function isCategoriesLoaded()
    {
        return null !== $this->collCategories;
    }

    /**
     * Gets a collection of ChildSCategory objects related by a many-to-many relationship
     * to the current object by way of the shop_product_categories cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildSProducts is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return ObjectCollection|ChildSCategory[] List of ChildSCategory objects
     */
    public function getCategories(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collCategoriesPartial && !$this->isNew();
        if (null === $this->collCategories || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collCategories) {
                    $this->initCategories();
                }
            } else {

                $query = ChildSCategoryQuery::create(null, $criteria)
                    ->filterByProduct($this);
                $collCategories = $query->find($con);
                if (null !== $criteria) {
                    return $collCategories;
                }

                if ($partial && $this->collCategories) {
                    //make sure that already added objects gets added to the list of the database.
                    foreach ($this->collCategories as $obj) {
                        if (!$collCategories->contains($obj)) {
                            $collCategories[] = $obj;
                        }
                    }
                }

                $this->collCategories = $collCategories;
                $this->collCategoriesPartial = false;
            }
        }

        return $this->collCategories;
    }

    /**
     * Sets a collection of SCategory objects related by a many-to-many relationship
     * to the current object by way of the shop_product_categories cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param  Collection $categories A Propel collection.
     * @param  ConnectionInterface $con Optional connection object
     * @return $this|ChildSProducts The current object (for fluent API support)
     */
    public function setCategories(Collection $categories, ConnectionInterface $con = null)
    {
        $this->clearCategories();
        $currentCategories = $this->getCategories();

        $categoriesScheduledForDeletion = $currentCategories->diff($categories);

        foreach ($categoriesScheduledForDeletion as $toDelete) {
            $this->removeCategory($toDelete);
        }

        foreach ($categories as $category) {
            if (!$currentCategories->contains($category)) {
                $this->doAddCategory($category);
            }
        }

        $this->collCategoriesPartial = false;
        $this->collCategories = $categories;

        return $this;
    }

    /**
     * Gets the number of SCategory objects related by a many-to-many relationship
     * to the current object by way of the shop_product_categories cross-reference table.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      boolean $distinct Set to true to force count distinct
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return int the number of related SCategory objects
     */
    public function countCategories(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collCategoriesPartial && !$this->isNew();
        if (null === $this->collCategories || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collCategories) {
                return 0;
            } else {

                if ($partial && !$criteria) {
                    return count($this->getCategories());
                }

                $query = ChildSCategoryQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByProduct($this)
                    ->count($con);
            }
        } else {
            return count($this->collCategories);
        }
    }

    /**
     * Associate a ChildSCategory to this object
     * through the shop_product_categories cross reference table.
     *
     * @param ChildSCategory $category
     * @return ChildSProducts The current object (for fluent API support)
     */
    public function addCategory(ChildSCategory $category)
    {
        if ($this->collCategories === null) {
            $this->initCategories();
        }

        if (!$this->getCategories()->contains($category)) {
            // only add it if the **same** object is not already associated
            $this->collCategories->push($category);
            $this->doAddCategory($category);
        }

        return $this;
    }

    /**
     *
     * @param ChildSCategory $category
     */
    protected function doAddCategory(ChildSCategory $category)
    {
        $shopProductCategories = new ChildShopProductCategories();

        $shopProductCategories->setCategory($category);

        $shopProductCategories->setProduct($this);

        $this->addShopProductCategories($shopProductCategories);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if (!$category->isProductsLoaded()) {
            $category->initProducts();
            $category->getProducts()->push($this);
        } elseif (!$category->getProducts()->contains($this)) {
            $category->getProducts()->push($this);
        }

    }

    /**
     * Remove category of this object
     * through the shop_product_categories cross reference table.
     *
     * @param ChildSCategory $category
     * @return ChildSProducts The current object (for fluent API support)
     */
    public function removeCategory(ChildSCategory $category)
    {
        if ($this->getCategories()->contains($category)) { $shopProductCategories = new ChildShopProductCategories();

            $shopProductCategories->setCategory($category);
            if ($category->isProductsLoaded()) {
                //remove the back reference if available
                $category->getProducts()->removeObject($this);
            }

            $shopProductCategories->setProduct($this);
            $this->removeShopProductCategories(clone $shopProductCategories);
            $shopProductCategories->clear();

            $this->collCategories->remove($this->collCategories->search($category));

            if (null === $this->categoriesScheduledForDeletion) {
                $this->categoriesScheduledForDeletion = clone $this->collCategories;
                $this->categoriesScheduledForDeletion->clear();
            }

            $this->categoriesScheduledForDeletion->push($category);
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
        if (null !== $this->aBrand) {
            $this->aBrand->removeSProducts($this);
        }
        if (null !== $this->aMainCategory) {
            $this->aMainCategory->removeSProducts($this);
        }
        $this->id = null;
        $this->user_id = null;
        $this->external_id = null;
        $this->url = null;
        $this->active = null;
        $this->hit = null;
        $this->hot = null;
        $this->action = null;
        $this->brand_id = null;
        $this->category_id = null;
        $this->related_products = null;
        $this->old_price = null;
        $this->created = null;
        $this->updated = null;
        $this->views = null;
        $this->added_to_cart_count = null;
        $this->enable_comments = null;
        $this->tpl = null;
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
            if ($this->collShopKits) {
                foreach ($this->collShopKits as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collShopKitProducts) {
                foreach ($this->collShopKitProducts as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collSProductsI18ns) {
                foreach ($this->collSProductsI18ns as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collSProductImagess) {
                foreach ($this->collSProductImagess as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collProductVariants) {
                foreach ($this->collProductVariants as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collSWarehouseDatas) {
                foreach ($this->collSWarehouseDatas as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collShopProductCategoriess) {
                foreach ($this->collShopProductCategoriess as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collSProductPropertiesDatas) {
                foreach ($this->collSProductPropertiesDatas as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collSNotificationss) {
                foreach ($this->collSNotificationss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collSOrderProductss) {
                foreach ($this->collSOrderProductss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->singleSProductsRating) {
                $this->singleSProductsRating->clearAllReferences($deep);
            }
            if ($this->collCategories) {
                foreach ($this->collCategories as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        // i18n behavior
        $this->currentLocale = 'ru';
        $this->currentTranslations = null;

        $this->collShopKits = null;
        $this->collShopKitProducts = null;
        $this->collSProductsI18ns = null;
        $this->collSProductImagess = null;
        $this->collProductVariants = null;
        $this->collSWarehouseDatas = null;
        $this->collShopProductCategoriess = null;
        $this->collSProductPropertiesDatas = null;
        $this->collSNotificationss = null;
        $this->collSOrderProductss = null;
        $this->singleSProductsRating = null;
        $this->collCategories = null;
        $this->aBrand = null;
        $this->aMainCategory = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(SProductsTableMap::DEFAULT_STRING_FORMAT);
    }

    // i18n behavior

    /**
     * Sets the locale for translations
     *
     * @param     string $locale Locale to use for the translation, e.g. 'fr_FR'
     *
     * @return    $this|ChildSProducts The current object (for fluent API support)
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
     * @return ChildSProductsI18n */
    public function getTranslation($locale = 'ru', ConnectionInterface $con = null)
    {
        if (!isset($this->currentTranslations[$locale])) {
            if (null !== $this->collSProductsI18ns) {
                foreach ($this->collSProductsI18ns as $translation) {
                    if ($translation->getLocale() == $locale) {
                        $this->currentTranslations[$locale] = $translation;

                        return $translation;
                    }
                }
            }
            if ($this->isNew()) {
                $translation = new ChildSProductsI18n();
                $translation->setLocale($locale);
            } else {
                $translation = ChildSProductsI18nQuery::create()
                    ->filterByPrimaryKey(array($this->getPrimaryKey(), $locale))
                    ->findOneOrCreate($con);
                $this->currentTranslations[$locale] = $translation;
            }
            $this->addSProductsI18n($translation);
        }

        return $this->currentTranslations[$locale];
    }

    /**
     * Remove the translation for a given locale
     *
     * @param     string $locale Locale to use for the translation, e.g. 'fr_FR'
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return    $this|ChildSProducts The current object (for fluent API support)
     */
    public function removeTranslation($locale = 'ru', ConnectionInterface $con = null)
    {
        if (!$this->isNew()) {
            ChildSProductsI18nQuery::create()
                ->filterByPrimaryKey(array($this->getPrimaryKey(), $locale))
                ->delete($con);
        }
        if (isset($this->currentTranslations[$locale])) {
            unset($this->currentTranslations[$locale]);
        }
        foreach ($this->collSProductsI18ns as $key => $translation) {
            if ($translation->getLocale() == $locale) {
                unset($this->collSProductsI18ns[$key]);
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
     * @return ChildSProductsI18n */
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
         * @return $this|\SProductsI18n The current object (for fluent API support)
         */
        public function setName($v)
        {    $this->getCurrentTranslation()->setName($v);

        return $this;
    }


        /**
         * Get the [short_description] column value.
         *
         * @return string
         */
        public function getShortDescription()
        {
        return $this->getCurrentTranslation()->getShortDescription();
    }


        /**
         * Set the value of [short_description] column.
         *
         * @param string $v new value
         * @return $this|\SProductsI18n The current object (for fluent API support)
         */
        public function setShortDescription($v)
        {    $this->getCurrentTranslation()->setShortDescription($v);

        return $this;
    }


        /**
         * Get the [full_description] column value.
         *
         * @return string
         */
        public function getFullDescription()
        {
        return $this->getCurrentTranslation()->getFullDescription();
    }


        /**
         * Set the value of [full_description] column.
         *
         * @param string $v new value
         * @return $this|\SProductsI18n The current object (for fluent API support)
         */
        public function setFullDescription($v)
        {    $this->getCurrentTranslation()->setFullDescription($v);

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
         * @return $this|\SProductsI18n The current object (for fluent API support)
         */
        public function setMetaTitle($v)
        {    $this->getCurrentTranslation()->setMetaTitle($v);

        return $this;
    }


        /**
         * Get the [meta_description] column value.
         *
         * @return string
         */
        public function getMetaDescription()
        {
        return $this->getCurrentTranslation()->getMetaDescription();
    }


        /**
         * Set the value of [meta_description] column.
         *
         * @param string $v new value
         * @return $this|\SProductsI18n The current object (for fluent API support)
         */
        public function setMetaDescription($v)
        {    $this->getCurrentTranslation()->setMetaDescription($v);

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
         * @return $this|\SProductsI18n The current object (for fluent API support)
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
