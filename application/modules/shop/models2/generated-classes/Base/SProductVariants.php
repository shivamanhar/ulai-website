<?php

namespace Base;

use \SCurrencies as ChildSCurrencies;
use \SCurrenciesQuery as ChildSCurrenciesQuery;
use \SNotifications as ChildSNotifications;
use \SNotificationsQuery as ChildSNotificationsQuery;
use \SOrderProducts as ChildSOrderProducts;
use \SOrderProductsQuery as ChildSOrderProductsQuery;
use \SProductVariants as ChildSProductVariants;
use \SProductVariantsI18n as ChildSProductVariantsI18n;
use \SProductVariantsI18nQuery as ChildSProductVariantsI18nQuery;
use \SProductVariantsQuery as ChildSProductVariantsQuery;
use \SProducts as ChildSProducts;
use \SProductsQuery as ChildSProductsQuery;
use \ShopKitProduct as ChildShopKitProduct;
use \ShopKitProductQuery as ChildShopKitProductQuery;
use \Exception;
use \PDO;
use Map\SProductVariantsTableMap;
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
 * Base class that represents a row from the 'shop_product_variants' table.
 *
 *
 *
* @package    propel.generator..Base
*/
abstract class SProductVariants extends PropelBaseModelClass implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\SProductVariantsTableMap';


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
     * The value for the product_id field.
     * @var        int
     */
    protected $product_id;

    /**
     * The value for the price field.
     * @var        double
     */
    protected $price;

    /**
     * The value for the number field.
     * @var        string
     */
    protected $number;

    /**
     * The value for the stock field.
     * @var        int
     */
    protected $stock;

    /**
     * The value for the mainimage field.
     * @var        string
     */
    protected $mainimage;

    /**
     * The value for the position field.
     * @var        int
     */
    protected $position;

    /**
     * The value for the currency field.
     * @var        int
     */
    protected $currency;

    /**
     * The value for the price_in_main field.
     * @var        string
     */
    protected $price_in_main;

    /**
     * @var        ChildSProducts
     */
    protected $aSProducts;

    /**
     * @var        ChildSCurrencies
     */
    protected $aSCurrencies;

    /**
     * @var        ObjectCollection|ChildShopKitProduct[] Collection to store aggregation of ChildShopKitProduct objects.
     */
    protected $collShopKitProducts;
    protected $collShopKitProductsPartial;

    /**
     * @var        ObjectCollection|ChildSProductVariantsI18n[] Collection to store aggregation of ChildSProductVariantsI18n objects.
     */
    protected $collSProductVariantsI18ns;
    protected $collSProductVariantsI18nsPartial;

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
     * @var        array[ChildSProductVariantsI18n]
     */
    protected $currentTranslations;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildShopKitProduct[]
     */
    protected $shopKitProductsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildSProductVariantsI18n[]
     */
    protected $sProductVariantsI18nsScheduledForDeletion = null;

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
     * Initializes internal state of Base\SProductVariants object.
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
     * Compares this with another <code>SProductVariants</code> instance.  If
     * <code>obj</code> is an instance of <code>SProductVariants</code>, delegates to
     * <code>equals(SProductVariants)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|SProductVariants The current object, for fluid interface
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
     * Get the [product_id] column value.
     *
     * @return int
     */
    public function getProductId()
    {
        return $this->product_id;
    }

    /**
     * Get the [price] column value.
     *
     * @return double
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Get the [number] column value.
     *
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Get the [stock] column value.
     *
     * @return int
     */
    public function getStock()
    {
        return $this->stock;
    }

    /**
     * Get the [mainimage] column value.
     *
     * @return string
     */
    public function getMainimage()
    {
        return $this->mainimage;
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
     * Get the [currency] column value.
     *
     * @return int
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * Get the [price_in_main] column value.
     *
     * @return string
     */
    public function getPriceInMain()
    {
        return $this->price_in_main;
    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return $this|\SProductVariants The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[SProductVariantsTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [external_id] column.
     *
     * @param string $v new value
     * @return $this|\SProductVariants The current object (for fluent API support)
     */
    public function setExternalId($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->external_id !== $v) {
            $this->external_id = $v;
            $this->modifiedColumns[SProductVariantsTableMap::COL_EXTERNAL_ID] = true;
        }

        return $this;
    } // setExternalId()

    /**
     * Set the value of [product_id] column.
     *
     * @param int $v new value
     * @return $this|\SProductVariants The current object (for fluent API support)
     */
    public function setProductId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->product_id !== $v) {
            $this->product_id = $v;
            $this->modifiedColumns[SProductVariantsTableMap::COL_PRODUCT_ID] = true;
        }

        if ($this->aSProducts !== null && $this->aSProducts->getId() !== $v) {
            $this->aSProducts = null;
        }

        return $this;
    } // setProductId()

    /**
     * Set the value of [price] column.
     *
     * @param double $v new value
     * @return $this|\SProductVariants The current object (for fluent API support)
     */
    public function setPrice($v)
    {
        if ($v !== null) {
            $v = (double) $v;
        }

        if ($this->price !== $v) {
            $this->price = $v;
            $this->modifiedColumns[SProductVariantsTableMap::COL_PRICE] = true;
        }

        return $this;
    } // setPrice()

    /**
     * Set the value of [number] column.
     *
     * @param string $v new value
     * @return $this|\SProductVariants The current object (for fluent API support)
     */
    public function setNumber($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->number !== $v) {
            $this->number = $v;
            $this->modifiedColumns[SProductVariantsTableMap::COL_NUMBER] = true;
        }

        return $this;
    } // setNumber()

    /**
     * Set the value of [stock] column.
     *
     * @param int $v new value
     * @return $this|\SProductVariants The current object (for fluent API support)
     */
    public function setStock($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->stock !== $v) {
            $this->stock = $v;
            $this->modifiedColumns[SProductVariantsTableMap::COL_STOCK] = true;
        }

        return $this;
    } // setStock()

    /**
     * Set the value of [mainimage] column.
     *
     * @param string $v new value
     * @return $this|\SProductVariants The current object (for fluent API support)
     */
    public function setMainimage($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->mainimage !== $v) {
            $this->mainimage = $v;
            $this->modifiedColumns[SProductVariantsTableMap::COL_MAINIMAGE] = true;
        }

        return $this;
    } // setMainimage()

    /**
     * Set the value of [position] column.
     *
     * @param int $v new value
     * @return $this|\SProductVariants The current object (for fluent API support)
     */
    public function setPosition($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->position !== $v) {
            $this->position = $v;
            $this->modifiedColumns[SProductVariantsTableMap::COL_POSITION] = true;
        }

        return $this;
    } // setPosition()

    /**
     * Set the value of [currency] column.
     *
     * @param int $v new value
     * @return $this|\SProductVariants The current object (for fluent API support)
     */
    public function setCurrency($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->currency !== $v) {
            $this->currency = $v;
            $this->modifiedColumns[SProductVariantsTableMap::COL_CURRENCY] = true;
        }

        if ($this->aSCurrencies !== null && $this->aSCurrencies->getId() !== $v) {
            $this->aSCurrencies = null;
        }

        return $this;
    } // setCurrency()

    /**
     * Set the value of [price_in_main] column.
     *
     * @param string $v new value
     * @return $this|\SProductVariants The current object (for fluent API support)
     */
    public function setPriceInMain($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->price_in_main !== $v) {
            $this->price_in_main = $v;
            $this->modifiedColumns[SProductVariantsTableMap::COL_PRICE_IN_MAIN] = true;
        }

        return $this;
    } // setPriceInMain()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : SProductVariantsTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : SProductVariantsTableMap::translateFieldName('ExternalId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->external_id = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : SProductVariantsTableMap::translateFieldName('ProductId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->product_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : SProductVariantsTableMap::translateFieldName('Price', TableMap::TYPE_PHPNAME, $indexType)];
            $this->price = (null !== $col) ? (double) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : SProductVariantsTableMap::translateFieldName('Number', TableMap::TYPE_PHPNAME, $indexType)];
            $this->number = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : SProductVariantsTableMap::translateFieldName('Stock', TableMap::TYPE_PHPNAME, $indexType)];
            $this->stock = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : SProductVariantsTableMap::translateFieldName('Mainimage', TableMap::TYPE_PHPNAME, $indexType)];
            $this->mainimage = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : SProductVariantsTableMap::translateFieldName('Position', TableMap::TYPE_PHPNAME, $indexType)];
            $this->position = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : SProductVariantsTableMap::translateFieldName('Currency', TableMap::TYPE_PHPNAME, $indexType)];
            $this->currency = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : SProductVariantsTableMap::translateFieldName('PriceInMain', TableMap::TYPE_PHPNAME, $indexType)];
            $this->price_in_main = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 10; // 10 = SProductVariantsTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\SProductVariants'), 0, $e);
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
        if ($this->aSProducts !== null && $this->product_id !== $this->aSProducts->getId()) {
            $this->aSProducts = null;
        }
        if ($this->aSCurrencies !== null && $this->currency !== $this->aSCurrencies->getId()) {
            $this->aSCurrencies = null;
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
            $con = Propel::getServiceContainer()->getReadConnection(SProductVariantsTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildSProductVariantsQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aSProducts = null;
            $this->aSCurrencies = null;
            $this->collShopKitProducts = null;

            $this->collSProductVariantsI18ns = null;

            $this->collSNotificationss = null;

            $this->collSOrderProductss = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see SProductVariants::setDeleted()
     * @see SProductVariants::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(SProductVariantsTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildSProductVariantsQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(SProductVariantsTableMap::DATABASE_NAME);
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
                SProductVariantsTableMap::addInstanceToPool($this);
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

            if ($this->aSProducts !== null) {
                if ($this->aSProducts->isModified() || $this->aSProducts->isNew()) {
                    $affectedRows += $this->aSProducts->save($con);
                }
                $this->setSProducts($this->aSProducts);
            }

            if ($this->aSCurrencies !== null) {
                if ($this->aSCurrencies->isModified() || $this->aSCurrencies->isNew()) {
                    $affectedRows += $this->aSCurrencies->save($con);
                }
                $this->setSCurrencies($this->aSCurrencies);
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

            if ($this->sProductVariantsI18nsScheduledForDeletion !== null) {
                if (!$this->sProductVariantsI18nsScheduledForDeletion->isEmpty()) {
                    \SProductVariantsI18nQuery::create()
                        ->filterByPrimaryKeys($this->sProductVariantsI18nsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->sProductVariantsI18nsScheduledForDeletion = null;
                }
            }

            if ($this->collSProductVariantsI18ns !== null) {
                foreach ($this->collSProductVariantsI18ns as $referrerFK) {
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

        $this->modifiedColumns[SProductVariantsTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . SProductVariantsTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(SProductVariantsTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(SProductVariantsTableMap::COL_EXTERNAL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'external_id';
        }
        if ($this->isColumnModified(SProductVariantsTableMap::COL_PRODUCT_ID)) {
            $modifiedColumns[':p' . $index++]  = 'product_id';
        }
        if ($this->isColumnModified(SProductVariantsTableMap::COL_PRICE)) {
            $modifiedColumns[':p' . $index++]  = 'price';
        }
        if ($this->isColumnModified(SProductVariantsTableMap::COL_NUMBER)) {
            $modifiedColumns[':p' . $index++]  = 'number';
        }
        if ($this->isColumnModified(SProductVariantsTableMap::COL_STOCK)) {
            $modifiedColumns[':p' . $index++]  = 'stock';
        }
        if ($this->isColumnModified(SProductVariantsTableMap::COL_MAINIMAGE)) {
            $modifiedColumns[':p' . $index++]  = 'mainImage';
        }
        if ($this->isColumnModified(SProductVariantsTableMap::COL_POSITION)) {
            $modifiedColumns[':p' . $index++]  = 'position';
        }
        if ($this->isColumnModified(SProductVariantsTableMap::COL_CURRENCY)) {
            $modifiedColumns[':p' . $index++]  = 'currency';
        }
        if ($this->isColumnModified(SProductVariantsTableMap::COL_PRICE_IN_MAIN)) {
            $modifiedColumns[':p' . $index++]  = 'price_in_main';
        }

        $sql = sprintf(
            'INSERT INTO shop_product_variants (%s) VALUES (%s)',
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
                    case 'product_id':
                        $stmt->bindValue($identifier, $this->product_id, PDO::PARAM_INT);
                        break;
                    case 'price':
                        $stmt->bindValue($identifier, $this->price, PDO::PARAM_STR);
                        break;
                    case 'number':
                        $stmt->bindValue($identifier, $this->number, PDO::PARAM_STR);
                        break;
                    case 'stock':
                        $stmt->bindValue($identifier, $this->stock, PDO::PARAM_INT);
                        break;
                    case 'mainImage':
                        $stmt->bindValue($identifier, $this->mainimage, PDO::PARAM_STR);
                        break;
                    case 'position':
                        $stmt->bindValue($identifier, $this->position, PDO::PARAM_INT);
                        break;
                    case 'currency':
                        $stmt->bindValue($identifier, $this->currency, PDO::PARAM_INT);
                        break;
                    case 'price_in_main':
                        $stmt->bindValue($identifier, $this->price_in_main, PDO::PARAM_STR);
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
        $pos = SProductVariantsTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getProductId();
                break;
            case 3:
                return $this->getPrice();
                break;
            case 4:
                return $this->getNumber();
                break;
            case 5:
                return $this->getStock();
                break;
            case 6:
                return $this->getMainimage();
                break;
            case 7:
                return $this->getPosition();
                break;
            case 8:
                return $this->getCurrency();
                break;
            case 9:
                return $this->getPriceInMain();
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

        if (isset($alreadyDumpedObjects['SProductVariants'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['SProductVariants'][$this->hashCode()] = true;
        $keys = SProductVariantsTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getExternalId(),
            $keys[2] => $this->getProductId(),
            $keys[3] => $this->getPrice(),
            $keys[4] => $this->getNumber(),
            $keys[5] => $this->getStock(),
            $keys[6] => $this->getMainimage(),
            $keys[7] => $this->getPosition(),
            $keys[8] => $this->getCurrency(),
            $keys[9] => $this->getPriceInMain(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aSProducts) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'sProducts';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'shop_products';
                        break;
                    default:
                        $key = 'SProducts';
                }

                $result[$key] = $this->aSProducts->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aSCurrencies) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'sCurrencies';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'shop_currencies';
                        break;
                    default:
                        $key = 'SCurrencies';
                }

                $result[$key] = $this->aSCurrencies->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
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
            if (null !== $this->collSProductVariantsI18ns) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'sProductVariantsI18ns';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'shop_product_variants_i18ns';
                        break;
                    default:
                        $key = 'SProductVariantsI18ns';
                }

                $result[$key] = $this->collSProductVariantsI18ns->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\SProductVariants
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = SProductVariantsTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\SProductVariants
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
                $this->setProductId($value);
                break;
            case 3:
                $this->setPrice($value);
                break;
            case 4:
                $this->setNumber($value);
                break;
            case 5:
                $this->setStock($value);
                break;
            case 6:
                $this->setMainimage($value);
                break;
            case 7:
                $this->setPosition($value);
                break;
            case 8:
                $this->setCurrency($value);
                break;
            case 9:
                $this->setPriceInMain($value);
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
        $keys = SProductVariantsTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setExternalId($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setProductId($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setPrice($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setNumber($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setStock($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setMainimage($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setPosition($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setCurrency($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setPriceInMain($arr[$keys[9]]);
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
     * @return $this|\SProductVariants The current object, for fluid interface
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
        $criteria = new Criteria(SProductVariantsTableMap::DATABASE_NAME);

        if ($this->isColumnModified(SProductVariantsTableMap::COL_ID)) {
            $criteria->add(SProductVariantsTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(SProductVariantsTableMap::COL_EXTERNAL_ID)) {
            $criteria->add(SProductVariantsTableMap::COL_EXTERNAL_ID, $this->external_id);
        }
        if ($this->isColumnModified(SProductVariantsTableMap::COL_PRODUCT_ID)) {
            $criteria->add(SProductVariantsTableMap::COL_PRODUCT_ID, $this->product_id);
        }
        if ($this->isColumnModified(SProductVariantsTableMap::COL_PRICE)) {
            $criteria->add(SProductVariantsTableMap::COL_PRICE, $this->price);
        }
        if ($this->isColumnModified(SProductVariantsTableMap::COL_NUMBER)) {
            $criteria->add(SProductVariantsTableMap::COL_NUMBER, $this->number);
        }
        if ($this->isColumnModified(SProductVariantsTableMap::COL_STOCK)) {
            $criteria->add(SProductVariantsTableMap::COL_STOCK, $this->stock);
        }
        if ($this->isColumnModified(SProductVariantsTableMap::COL_MAINIMAGE)) {
            $criteria->add(SProductVariantsTableMap::COL_MAINIMAGE, $this->mainimage);
        }
        if ($this->isColumnModified(SProductVariantsTableMap::COL_POSITION)) {
            $criteria->add(SProductVariantsTableMap::COL_POSITION, $this->position);
        }
        if ($this->isColumnModified(SProductVariantsTableMap::COL_CURRENCY)) {
            $criteria->add(SProductVariantsTableMap::COL_CURRENCY, $this->currency);
        }
        if ($this->isColumnModified(SProductVariantsTableMap::COL_PRICE_IN_MAIN)) {
            $criteria->add(SProductVariantsTableMap::COL_PRICE_IN_MAIN, $this->price_in_main);
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
        $criteria = ChildSProductVariantsQuery::create();
        $criteria->add(SProductVariantsTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \SProductVariants (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setExternalId($this->getExternalId());
        $copyObj->setProductId($this->getProductId());
        $copyObj->setPrice($this->getPrice());
        $copyObj->setNumber($this->getNumber());
        $copyObj->setStock($this->getStock());
        $copyObj->setMainimage($this->getMainimage());
        $copyObj->setPosition($this->getPosition());
        $copyObj->setCurrency($this->getCurrency());
        $copyObj->setPriceInMain($this->getPriceInMain());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getShopKitProducts() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addShopKitProduct($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getSProductVariantsI18ns() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addSProductVariantsI18n($relObj->copy($deepCopy));
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
     * @return \SProductVariants Clone of current object.
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
     * Declares an association between this object and a ChildSProducts object.
     *
     * @param  ChildSProducts $v
     * @return $this|\SProductVariants The current object (for fluent API support)
     * @throws PropelException
     */
    public function setSProducts(ChildSProducts $v = null)
    {
        if ($v === null) {
            $this->setProductId(NULL);
        } else {
            $this->setProductId($v->getId());
        }

        $this->aSProducts = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildSProducts object, it will not be re-added.
        if ($v !== null) {
            $v->addProductVariant($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildSProducts object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildSProducts The associated ChildSProducts object.
     * @throws PropelException
     */
    public function getSProducts(ConnectionInterface $con = null)
    {
        if ($this->aSProducts === null && ($this->product_id !== null)) {
            $this->aSProducts = ChildSProductsQuery::create()->findPk($this->product_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aSProducts->addProductVariants($this);
             */
        }

        return $this->aSProducts;
    }

    /**
     * Declares an association between this object and a ChildSCurrencies object.
     *
     * @param  ChildSCurrencies $v
     * @return $this|\SProductVariants The current object (for fluent API support)
     * @throws PropelException
     */
    public function setSCurrencies(ChildSCurrencies $v = null)
    {
        if ($v === null) {
            $this->setCurrency(NULL);
        } else {
            $this->setCurrency($v->getId());
        }

        $this->aSCurrencies = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildSCurrencies object, it will not be re-added.
        if ($v !== null) {
            $v->addCurrency($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildSCurrencies object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildSCurrencies The associated ChildSCurrencies object.
     * @throws PropelException
     */
    public function getSCurrencies(ConnectionInterface $con = null)
    {
        if ($this->aSCurrencies === null && ($this->currency !== null)) {
            $this->aSCurrencies = ChildSCurrenciesQuery::create()->findPk($this->currency, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aSCurrencies->addCurrencies($this);
             */
        }

        return $this->aSCurrencies;
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
        if ('ShopKitProduct' == $relationName) {
            return $this->initShopKitProducts();
        }
        if ('SProductVariantsI18n' == $relationName) {
            return $this->initSProductVariantsI18ns();
        }
        if ('SNotifications' == $relationName) {
            return $this->initSNotificationss();
        }
        if ('SOrderProducts' == $relationName) {
            return $this->initSOrderProductss();
        }
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
     * If this ChildSProductVariants is new, it will return
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
                    ->filterBySProductVariants($this)
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
     * @return $this|ChildSProductVariants The current object (for fluent API support)
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
            $shopKitProductRemoved->setSProductVariants(null);
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
                ->filterBySProductVariants($this)
                ->count($con);
        }

        return count($this->collShopKitProducts);
    }

    /**
     * Method called to associate a ChildShopKitProduct object to this object
     * through the ChildShopKitProduct foreign key attribute.
     *
     * @param  ChildShopKitProduct $l ChildShopKitProduct
     * @return $this|\SProductVariants The current object (for fluent API support)
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
        $shopKitProduct->setSProductVariants($this);
    }

    /**
     * @param  ChildShopKitProduct $shopKitProduct The ChildShopKitProduct object to remove.
     * @return $this|ChildSProductVariants The current object (for fluent API support)
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
            $shopKitProduct->setSProductVariants(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this SProductVariants is new, it will return
     * an empty collection; or if this SProductVariants has previously
     * been saved, it will retrieve related ShopKitProducts from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in SProductVariants.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildShopKitProduct[] List of ChildShopKitProduct objects
     */
    public function getShopKitProductsJoinSProducts(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildShopKitProductQuery::create(null, $criteria);
        $query->joinWith('SProducts', $joinBehavior);

        return $this->getShopKitProducts($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this SProductVariants is new, it will return
     * an empty collection; or if this SProductVariants has previously
     * been saved, it will retrieve related ShopKitProducts from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in SProductVariants.
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
     * Clears out the collSProductVariantsI18ns collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addSProductVariantsI18ns()
     */
    public function clearSProductVariantsI18ns()
    {
        $this->collSProductVariantsI18ns = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collSProductVariantsI18ns collection loaded partially.
     */
    public function resetPartialSProductVariantsI18ns($v = true)
    {
        $this->collSProductVariantsI18nsPartial = $v;
    }

    /**
     * Initializes the collSProductVariantsI18ns collection.
     *
     * By default this just sets the collSProductVariantsI18ns collection to an empty array (like clearcollSProductVariantsI18ns());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initSProductVariantsI18ns($overrideExisting = true)
    {
        if (null !== $this->collSProductVariantsI18ns && !$overrideExisting) {
            return;
        }
        $this->collSProductVariantsI18ns = new ObjectCollection();
        $this->collSProductVariantsI18ns->setModel('\SProductVariantsI18n');
    }

    /**
     * Gets an array of ChildSProductVariantsI18n objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildSProductVariants is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildSProductVariantsI18n[] List of ChildSProductVariantsI18n objects
     * @throws PropelException
     */
    public function getSProductVariantsI18ns(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collSProductVariantsI18nsPartial && !$this->isNew();
        if (null === $this->collSProductVariantsI18ns || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collSProductVariantsI18ns) {
                // return empty collection
                $this->initSProductVariantsI18ns();
            } else {
                $collSProductVariantsI18ns = ChildSProductVariantsI18nQuery::create(null, $criteria)
                    ->filterBySProductVariants($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collSProductVariantsI18nsPartial && count($collSProductVariantsI18ns)) {
                        $this->initSProductVariantsI18ns(false);

                        foreach ($collSProductVariantsI18ns as $obj) {
                            if (false == $this->collSProductVariantsI18ns->contains($obj)) {
                                $this->collSProductVariantsI18ns->append($obj);
                            }
                        }

                        $this->collSProductVariantsI18nsPartial = true;
                    }

                    return $collSProductVariantsI18ns;
                }

                if ($partial && $this->collSProductVariantsI18ns) {
                    foreach ($this->collSProductVariantsI18ns as $obj) {
                        if ($obj->isNew()) {
                            $collSProductVariantsI18ns[] = $obj;
                        }
                    }
                }

                $this->collSProductVariantsI18ns = $collSProductVariantsI18ns;
                $this->collSProductVariantsI18nsPartial = false;
            }
        }

        return $this->collSProductVariantsI18ns;
    }

    /**
     * Sets a collection of ChildSProductVariantsI18n objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $sProductVariantsI18ns A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildSProductVariants The current object (for fluent API support)
     */
    public function setSProductVariantsI18ns(Collection $sProductVariantsI18ns, ConnectionInterface $con = null)
    {
        /** @var ChildSProductVariantsI18n[] $sProductVariantsI18nsToDelete */
        $sProductVariantsI18nsToDelete = $this->getSProductVariantsI18ns(new Criteria(), $con)->diff($sProductVariantsI18ns);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->sProductVariantsI18nsScheduledForDeletion = clone $sProductVariantsI18nsToDelete;

        foreach ($sProductVariantsI18nsToDelete as $sProductVariantsI18nRemoved) {
            $sProductVariantsI18nRemoved->setSProductVariants(null);
        }

        $this->collSProductVariantsI18ns = null;
        foreach ($sProductVariantsI18ns as $sProductVariantsI18n) {
            $this->addSProductVariantsI18n($sProductVariantsI18n);
        }

        $this->collSProductVariantsI18ns = $sProductVariantsI18ns;
        $this->collSProductVariantsI18nsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related SProductVariantsI18n objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related SProductVariantsI18n objects.
     * @throws PropelException
     */
    public function countSProductVariantsI18ns(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collSProductVariantsI18nsPartial && !$this->isNew();
        if (null === $this->collSProductVariantsI18ns || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collSProductVariantsI18ns) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getSProductVariantsI18ns());
            }

            $query = ChildSProductVariantsI18nQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterBySProductVariants($this)
                ->count($con);
        }

        return count($this->collSProductVariantsI18ns);
    }

    /**
     * Method called to associate a ChildSProductVariantsI18n object to this object
     * through the ChildSProductVariantsI18n foreign key attribute.
     *
     * @param  ChildSProductVariantsI18n $l ChildSProductVariantsI18n
     * @return $this|\SProductVariants The current object (for fluent API support)
     */
    public function addSProductVariantsI18n(ChildSProductVariantsI18n $l)
    {
        if ($l && $locale = $l->getLocale()) {
            $this->setLocale($locale);
            $this->currentTranslations[$locale] = $l;
        }
        if ($this->collSProductVariantsI18ns === null) {
            $this->initSProductVariantsI18ns();
            $this->collSProductVariantsI18nsPartial = true;
        }

        if (!$this->collSProductVariantsI18ns->contains($l)) {
            $this->doAddSProductVariantsI18n($l);
        }

        return $this;
    }

    /**
     * @param ChildSProductVariantsI18n $sProductVariantsI18n The ChildSProductVariantsI18n object to add.
     */
    protected function doAddSProductVariantsI18n(ChildSProductVariantsI18n $sProductVariantsI18n)
    {
        $this->collSProductVariantsI18ns[]= $sProductVariantsI18n;
        $sProductVariantsI18n->setSProductVariants($this);
    }

    /**
     * @param  ChildSProductVariantsI18n $sProductVariantsI18n The ChildSProductVariantsI18n object to remove.
     * @return $this|ChildSProductVariants The current object (for fluent API support)
     */
    public function removeSProductVariantsI18n(ChildSProductVariantsI18n $sProductVariantsI18n)
    {
        if ($this->getSProductVariantsI18ns()->contains($sProductVariantsI18n)) {
            $pos = $this->collSProductVariantsI18ns->search($sProductVariantsI18n);
            $this->collSProductVariantsI18ns->remove($pos);
            if (null === $this->sProductVariantsI18nsScheduledForDeletion) {
                $this->sProductVariantsI18nsScheduledForDeletion = clone $this->collSProductVariantsI18ns;
                $this->sProductVariantsI18nsScheduledForDeletion->clear();
            }
            $this->sProductVariantsI18nsScheduledForDeletion[]= clone $sProductVariantsI18n;
            $sProductVariantsI18n->setSProductVariants(null);
        }

        return $this;
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
     * If this ChildSProductVariants is new, it will return
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
                    ->filterBySProductVariants($this)
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
     * @return $this|ChildSProductVariants The current object (for fluent API support)
     */
    public function setSNotificationss(Collection $sNotificationss, ConnectionInterface $con = null)
    {
        /** @var ChildSNotifications[] $sNotificationssToDelete */
        $sNotificationssToDelete = $this->getSNotificationss(new Criteria(), $con)->diff($sNotificationss);


        $this->sNotificationssScheduledForDeletion = $sNotificationssToDelete;

        foreach ($sNotificationssToDelete as $sNotificationsRemoved) {
            $sNotificationsRemoved->setSProductVariants(null);
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
                ->filterBySProductVariants($this)
                ->count($con);
        }

        return count($this->collSNotificationss);
    }

    /**
     * Method called to associate a ChildSNotifications object to this object
     * through the ChildSNotifications foreign key attribute.
     *
     * @param  ChildSNotifications $l ChildSNotifications
     * @return $this|\SProductVariants The current object (for fluent API support)
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
        $sNotifications->setSProductVariants($this);
    }

    /**
     * @param  ChildSNotifications $sNotifications The ChildSNotifications object to remove.
     * @return $this|ChildSProductVariants The current object (for fluent API support)
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
            $sNotifications->setSProductVariants(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this SProductVariants is new, it will return
     * an empty collection; or if this SProductVariants has previously
     * been saved, it will retrieve related SNotificationss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in SProductVariants.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildSNotifications[] List of ChildSNotifications objects
     */
    public function getSNotificationssJoinSProducts(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildSNotificationsQuery::create(null, $criteria);
        $query->joinWith('SProducts', $joinBehavior);

        return $this->getSNotificationss($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this SProductVariants is new, it will return
     * an empty collection; or if this SProductVariants has previously
     * been saved, it will retrieve related SNotificationss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in SProductVariants.
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
     * If this ChildSProductVariants is new, it will return
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
                    ->filterBySProductVariants($this)
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
     * @return $this|ChildSProductVariants The current object (for fluent API support)
     */
    public function setSOrderProductss(Collection $sOrderProductss, ConnectionInterface $con = null)
    {
        /** @var ChildSOrderProducts[] $sOrderProductssToDelete */
        $sOrderProductssToDelete = $this->getSOrderProductss(new Criteria(), $con)->diff($sOrderProductss);


        $this->sOrderProductssScheduledForDeletion = $sOrderProductssToDelete;

        foreach ($sOrderProductssToDelete as $sOrderProductsRemoved) {
            $sOrderProductsRemoved->setSProductVariants(null);
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
                ->filterBySProductVariants($this)
                ->count($con);
        }

        return count($this->collSOrderProductss);
    }

    /**
     * Method called to associate a ChildSOrderProducts object to this object
     * through the ChildSOrderProducts foreign key attribute.
     *
     * @param  ChildSOrderProducts $l ChildSOrderProducts
     * @return $this|\SProductVariants The current object (for fluent API support)
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
        $sOrderProducts->setSProductVariants($this);
    }

    /**
     * @param  ChildSOrderProducts $sOrderProducts The ChildSOrderProducts object to remove.
     * @return $this|ChildSProductVariants The current object (for fluent API support)
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
            $sOrderProducts->setSProductVariants(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this SProductVariants is new, it will return
     * an empty collection; or if this SProductVariants has previously
     * been saved, it will retrieve related SOrderProductss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in SProductVariants.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildSOrderProducts[] List of ChildSOrderProducts objects
     */
    public function getSOrderProductssJoinSProducts(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildSOrderProductsQuery::create(null, $criteria);
        $query->joinWith('SProducts', $joinBehavior);

        return $this->getSOrderProductss($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this SProductVariants is new, it will return
     * an empty collection; or if this SProductVariants has previously
     * been saved, it will retrieve related SOrderProductss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in SProductVariants.
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
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aSProducts) {
            $this->aSProducts->removeProductVariant($this);
        }
        if (null !== $this->aSCurrencies) {
            $this->aSCurrencies->removeCurrency($this);
        }
        $this->id = null;
        $this->external_id = null;
        $this->product_id = null;
        $this->price = null;
        $this->number = null;
        $this->stock = null;
        $this->mainimage = null;
        $this->position = null;
        $this->currency = null;
        $this->price_in_main = null;
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
            if ($this->collShopKitProducts) {
                foreach ($this->collShopKitProducts as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collSProductVariantsI18ns) {
                foreach ($this->collSProductVariantsI18ns as $o) {
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
        } // if ($deep)

        // i18n behavior
        $this->currentLocale = 'ru';
        $this->currentTranslations = null;

        $this->collShopKitProducts = null;
        $this->collSProductVariantsI18ns = null;
        $this->collSNotificationss = null;
        $this->collSOrderProductss = null;
        $this->aSProducts = null;
        $this->aSCurrencies = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(SProductVariantsTableMap::DEFAULT_STRING_FORMAT);
    }

    // i18n behavior

    /**
     * Sets the locale for translations
     *
     * @param     string $locale Locale to use for the translation, e.g. 'fr_FR'
     *
     * @return    $this|ChildSProductVariants The current object (for fluent API support)
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
     * @return ChildSProductVariantsI18n */
    public function getTranslation($locale = 'ru', ConnectionInterface $con = null)
    {
        if (!isset($this->currentTranslations[$locale])) {
            if (null !== $this->collSProductVariantsI18ns) {
                foreach ($this->collSProductVariantsI18ns as $translation) {
                    if ($translation->getLocale() == $locale) {
                        $this->currentTranslations[$locale] = $translation;

                        return $translation;
                    }
                }
            }
            if ($this->isNew()) {
                $translation = new ChildSProductVariantsI18n();
                $translation->setLocale($locale);
            } else {
                $translation = ChildSProductVariantsI18nQuery::create()
                    ->filterByPrimaryKey(array($this->getPrimaryKey(), $locale))
                    ->findOneOrCreate($con);
                $this->currentTranslations[$locale] = $translation;
            }
            $this->addSProductVariantsI18n($translation);
        }

        return $this->currentTranslations[$locale];
    }

    /**
     * Remove the translation for a given locale
     *
     * @param     string $locale Locale to use for the translation, e.g. 'fr_FR'
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return    $this|ChildSProductVariants The current object (for fluent API support)
     */
    public function removeTranslation($locale = 'ru', ConnectionInterface $con = null)
    {
        if (!$this->isNew()) {
            ChildSProductVariantsI18nQuery::create()
                ->filterByPrimaryKey(array($this->getPrimaryKey(), $locale))
                ->delete($con);
        }
        if (isset($this->currentTranslations[$locale])) {
            unset($this->currentTranslations[$locale]);
        }
        foreach ($this->collSProductVariantsI18ns as $key => $translation) {
            if ($translation->getLocale() == $locale) {
                unset($this->collSProductVariantsI18ns[$key]);
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
     * @return ChildSProductVariantsI18n */
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
         * @return $this|\SProductVariantsI18n The current object (for fluent API support)
         */
        public function setName($v)
        {    $this->getCurrentTranslation()->setName($v);

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
