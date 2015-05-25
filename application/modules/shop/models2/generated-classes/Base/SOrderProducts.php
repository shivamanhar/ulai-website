<?php

namespace Base;

use \SOrderProductsQuery as ChildSOrderProductsQuery;
use \SOrders as ChildSOrders;
use \SOrdersQuery as ChildSOrdersQuery;
use \SProductVariants as ChildSProductVariants;
use \SProductVariantsQuery as ChildSProductVariantsQuery;
use \SProducts as ChildSProducts;
use \SProductsQuery as ChildSProductsQuery;
use \Exception;
use \PDO;
use Map\SOrderProductsTableMap;
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
 * Base class that represents a row from the 'shop_orders_products' table.
 *
 *
 *
* @package    propel.generator..Base
*/
abstract class SOrderProducts extends PropelBaseModelClass implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\SOrderProductsTableMap';


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
     * The value for the order_id field.
     * @var        int
     */
    protected $order_id;

    /**
     * The value for the kit_id field.
     * @var        int
     */
    protected $kit_id;

    /**
     * The value for the is_main field.
     * @var        boolean
     */
    protected $is_main;

    /**
     * The value for the product_id field.
     * @var        int
     */
    protected $product_id;

    /**
     * The value for the variant_id field.
     * @var        int
     */
    protected $variant_id;

    /**
     * The value for the product_name field.
     * @var        string
     */
    protected $product_name;

    /**
     * The value for the variant_name field.
     * @var        string
     */
    protected $variant_name;

    /**
     * The value for the price field.
     * @var        double
     */
    protected $price;

    /**
     * The value for the origin_price field.
     * @var        double
     */
    protected $origin_price;

    /**
     * The value for the quantity field.
     * @var        int
     */
    protected $quantity;

    /**
     * @var        ChildSProducts
     */
    protected $aSProducts;

    /**
     * @var        ChildSProductVariants
     */
    protected $aSProductVariants;

    /**
     * @var        ChildSOrders
     */
    protected $aSOrders;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * Initializes internal state of Base\SOrderProducts object.
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
     * Compares this with another <code>SOrderProducts</code> instance.  If
     * <code>obj</code> is an instance of <code>SOrderProducts</code>, delegates to
     * <code>equals(SOrderProducts)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|SOrderProducts The current object, for fluid interface
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
     * Get the [order_id] column value.
     *
     * @return int
     */
    public function getOrderId()
    {
        return $this->order_id;
    }

    /**
     * Get the [kit_id] column value.
     *
     * @return int
     */
    public function getKitId()
    {
        return $this->kit_id;
    }

    /**
     * Get the [is_main] column value.
     *
     * @return boolean
     */
    public function getIsMain()
    {
        return $this->is_main;
    }

    /**
     * Get the [is_main] column value.
     *
     * @return boolean
     */
    public function isMain()
    {
        return $this->getIsMain();
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
     * Get the [variant_id] column value.
     *
     * @return int
     */
    public function getVariantId()
    {
        return $this->variant_id;
    }

    /**
     * Get the [product_name] column value.
     *
     * @return string
     */
    public function getProductName()
    {
        return $this->product_name;
    }

    /**
     * Get the [variant_name] column value.
     *
     * @return string
     */
    public function getVariantName()
    {
        return $this->variant_name;
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
     * Get the [origin_price] column value.
     *
     * @return double
     */
    public function getOriginPrice()
    {
        return $this->origin_price;
    }

    /**
     * Get the [quantity] column value.
     *
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return $this|\SOrderProducts The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[SOrderProductsTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [order_id] column.
     *
     * @param int $v new value
     * @return $this|\SOrderProducts The current object (for fluent API support)
     */
    public function setOrderId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->order_id !== $v) {
            $this->order_id = $v;
            $this->modifiedColumns[SOrderProductsTableMap::COL_ORDER_ID] = true;
        }

        if ($this->aSOrders !== null && $this->aSOrders->getId() !== $v) {
            $this->aSOrders = null;
        }

        return $this;
    } // setOrderId()

    /**
     * Set the value of [kit_id] column.
     *
     * @param int $v new value
     * @return $this|\SOrderProducts The current object (for fluent API support)
     */
    public function setKitId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->kit_id !== $v) {
            $this->kit_id = $v;
            $this->modifiedColumns[SOrderProductsTableMap::COL_KIT_ID] = true;
        }

        return $this;
    } // setKitId()

    /**
     * Sets the value of the [is_main] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\SOrderProducts The current object (for fluent API support)
     */
    public function setIsMain($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->is_main !== $v) {
            $this->is_main = $v;
            $this->modifiedColumns[SOrderProductsTableMap::COL_IS_MAIN] = true;
        }

        return $this;
    } // setIsMain()

    /**
     * Set the value of [product_id] column.
     *
     * @param int $v new value
     * @return $this|\SOrderProducts The current object (for fluent API support)
     */
    public function setProductId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->product_id !== $v) {
            $this->product_id = $v;
            $this->modifiedColumns[SOrderProductsTableMap::COL_PRODUCT_ID] = true;
        }

        if ($this->aSProducts !== null && $this->aSProducts->getId() !== $v) {
            $this->aSProducts = null;
        }

        return $this;
    } // setProductId()

    /**
     * Set the value of [variant_id] column.
     *
     * @param int $v new value
     * @return $this|\SOrderProducts The current object (for fluent API support)
     */
    public function setVariantId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->variant_id !== $v) {
            $this->variant_id = $v;
            $this->modifiedColumns[SOrderProductsTableMap::COL_VARIANT_ID] = true;
        }

        if ($this->aSProductVariants !== null && $this->aSProductVariants->getId() !== $v) {
            $this->aSProductVariants = null;
        }

        return $this;
    } // setVariantId()

    /**
     * Set the value of [product_name] column.
     *
     * @param string $v new value
     * @return $this|\SOrderProducts The current object (for fluent API support)
     */
    public function setProductName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->product_name !== $v) {
            $this->product_name = $v;
            $this->modifiedColumns[SOrderProductsTableMap::COL_PRODUCT_NAME] = true;
        }

        return $this;
    } // setProductName()

    /**
     * Set the value of [variant_name] column.
     *
     * @param string $v new value
     * @return $this|\SOrderProducts The current object (for fluent API support)
     */
    public function setVariantName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->variant_name !== $v) {
            $this->variant_name = $v;
            $this->modifiedColumns[SOrderProductsTableMap::COL_VARIANT_NAME] = true;
        }

        return $this;
    } // setVariantName()

    /**
     * Set the value of [price] column.
     *
     * @param double $v new value
     * @return $this|\SOrderProducts The current object (for fluent API support)
     */
    public function setPrice($v)
    {
        if ($v !== null) {
            $v = (double) $v;
        }

        if ($this->price !== $v) {
            $this->price = $v;
            $this->modifiedColumns[SOrderProductsTableMap::COL_PRICE] = true;
        }

        return $this;
    } // setPrice()

    /**
     * Set the value of [origin_price] column.
     *
     * @param double $v new value
     * @return $this|\SOrderProducts The current object (for fluent API support)
     */
    public function setOriginPrice($v)
    {
        if ($v !== null) {
            $v = (double) $v;
        }

        if ($this->origin_price !== $v) {
            $this->origin_price = $v;
            $this->modifiedColumns[SOrderProductsTableMap::COL_ORIGIN_PRICE] = true;
        }

        return $this;
    } // setOriginPrice()

    /**
     * Set the value of [quantity] column.
     *
     * @param int $v new value
     * @return $this|\SOrderProducts The current object (for fluent API support)
     */
    public function setQuantity($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->quantity !== $v) {
            $this->quantity = $v;
            $this->modifiedColumns[SOrderProductsTableMap::COL_QUANTITY] = true;
        }

        return $this;
    } // setQuantity()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : SOrderProductsTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : SOrderProductsTableMap::translateFieldName('OrderId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->order_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : SOrderProductsTableMap::translateFieldName('KitId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->kit_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : SOrderProductsTableMap::translateFieldName('IsMain', TableMap::TYPE_PHPNAME, $indexType)];
            $this->is_main = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : SOrderProductsTableMap::translateFieldName('ProductId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->product_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : SOrderProductsTableMap::translateFieldName('VariantId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->variant_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : SOrderProductsTableMap::translateFieldName('ProductName', TableMap::TYPE_PHPNAME, $indexType)];
            $this->product_name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : SOrderProductsTableMap::translateFieldName('VariantName', TableMap::TYPE_PHPNAME, $indexType)];
            $this->variant_name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : SOrderProductsTableMap::translateFieldName('Price', TableMap::TYPE_PHPNAME, $indexType)];
            $this->price = (null !== $col) ? (double) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : SOrderProductsTableMap::translateFieldName('OriginPrice', TableMap::TYPE_PHPNAME, $indexType)];
            $this->origin_price = (null !== $col) ? (double) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 10 + $startcol : SOrderProductsTableMap::translateFieldName('Quantity', TableMap::TYPE_PHPNAME, $indexType)];
            $this->quantity = (null !== $col) ? (int) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 11; // 11 = SOrderProductsTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\SOrderProducts'), 0, $e);
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
        if ($this->aSOrders !== null && $this->order_id !== $this->aSOrders->getId()) {
            $this->aSOrders = null;
        }
        if ($this->aSProducts !== null && $this->product_id !== $this->aSProducts->getId()) {
            $this->aSProducts = null;
        }
        if ($this->aSProductVariants !== null && $this->variant_id !== $this->aSProductVariants->getId()) {
            $this->aSProductVariants = null;
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
            $con = Propel::getServiceContainer()->getReadConnection(SOrderProductsTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildSOrderProductsQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aSProducts = null;
            $this->aSProductVariants = null;
            $this->aSOrders = null;
        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see SOrderProducts::setDeleted()
     * @see SOrderProducts::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(SOrderProductsTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildSOrderProductsQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(SOrderProductsTableMap::DATABASE_NAME);
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
                SOrderProductsTableMap::addInstanceToPool($this);
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

            if ($this->aSProductVariants !== null) {
                if ($this->aSProductVariants->isModified() || $this->aSProductVariants->isNew()) {
                    $affectedRows += $this->aSProductVariants->save($con);
                }
                $this->setSProductVariants($this->aSProductVariants);
            }

            if ($this->aSOrders !== null) {
                if ($this->aSOrders->isModified() || $this->aSOrders->isNew()) {
                    $affectedRows += $this->aSOrders->save($con);
                }
                $this->setSOrders($this->aSOrders);
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

        $this->modifiedColumns[SOrderProductsTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . SOrderProductsTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(SOrderProductsTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(SOrderProductsTableMap::COL_ORDER_ID)) {
            $modifiedColumns[':p' . $index++]  = 'order_id';
        }
        if ($this->isColumnModified(SOrderProductsTableMap::COL_KIT_ID)) {
            $modifiedColumns[':p' . $index++]  = 'kit_id';
        }
        if ($this->isColumnModified(SOrderProductsTableMap::COL_IS_MAIN)) {
            $modifiedColumns[':p' . $index++]  = 'is_main';
        }
        if ($this->isColumnModified(SOrderProductsTableMap::COL_PRODUCT_ID)) {
            $modifiedColumns[':p' . $index++]  = 'product_id';
        }
        if ($this->isColumnModified(SOrderProductsTableMap::COL_VARIANT_ID)) {
            $modifiedColumns[':p' . $index++]  = 'variant_id';
        }
        if ($this->isColumnModified(SOrderProductsTableMap::COL_PRODUCT_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'product_name';
        }
        if ($this->isColumnModified(SOrderProductsTableMap::COL_VARIANT_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'variant_name';
        }
        if ($this->isColumnModified(SOrderProductsTableMap::COL_PRICE)) {
            $modifiedColumns[':p' . $index++]  = 'price';
        }
        if ($this->isColumnModified(SOrderProductsTableMap::COL_ORIGIN_PRICE)) {
            $modifiedColumns[':p' . $index++]  = 'origin_price';
        }
        if ($this->isColumnModified(SOrderProductsTableMap::COL_QUANTITY)) {
            $modifiedColumns[':p' . $index++]  = 'quantity';
        }

        $sql = sprintf(
            'INSERT INTO shop_orders_products (%s) VALUES (%s)',
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
                    case 'order_id':
                        $stmt->bindValue($identifier, $this->order_id, PDO::PARAM_INT);
                        break;
                    case 'kit_id':
                        $stmt->bindValue($identifier, $this->kit_id, PDO::PARAM_INT);
                        break;
                    case 'is_main':
                        $stmt->bindValue($identifier, (int) $this->is_main, PDO::PARAM_INT);
                        break;
                    case 'product_id':
                        $stmt->bindValue($identifier, $this->product_id, PDO::PARAM_INT);
                        break;
                    case 'variant_id':
                        $stmt->bindValue($identifier, $this->variant_id, PDO::PARAM_INT);
                        break;
                    case 'product_name':
                        $stmt->bindValue($identifier, $this->product_name, PDO::PARAM_STR);
                        break;
                    case 'variant_name':
                        $stmt->bindValue($identifier, $this->variant_name, PDO::PARAM_STR);
                        break;
                    case 'price':
                        $stmt->bindValue($identifier, $this->price, PDO::PARAM_STR);
                        break;
                    case 'origin_price':
                        $stmt->bindValue($identifier, $this->origin_price, PDO::PARAM_STR);
                        break;
                    case 'quantity':
                        $stmt->bindValue($identifier, $this->quantity, PDO::PARAM_INT);
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
        $pos = SOrderProductsTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getOrderId();
                break;
            case 2:
                return $this->getKitId();
                break;
            case 3:
                return $this->getIsMain();
                break;
            case 4:
                return $this->getProductId();
                break;
            case 5:
                return $this->getVariantId();
                break;
            case 6:
                return $this->getProductName();
                break;
            case 7:
                return $this->getVariantName();
                break;
            case 8:
                return $this->getPrice();
                break;
            case 9:
                return $this->getOriginPrice();
                break;
            case 10:
                return $this->getQuantity();
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

        if (isset($alreadyDumpedObjects['SOrderProducts'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['SOrderProducts'][$this->hashCode()] = true;
        $keys = SOrderProductsTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getOrderId(),
            $keys[2] => $this->getKitId(),
            $keys[3] => $this->getIsMain(),
            $keys[4] => $this->getProductId(),
            $keys[5] => $this->getVariantId(),
            $keys[6] => $this->getProductName(),
            $keys[7] => $this->getVariantName(),
            $keys[8] => $this->getPrice(),
            $keys[9] => $this->getOriginPrice(),
            $keys[10] => $this->getQuantity(),
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
            if (null !== $this->aSProductVariants) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'sProductVariants';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'shop_product_variants';
                        break;
                    default:
                        $key = 'SProductVariants';
                }

                $result[$key] = $this->aSProductVariants->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aSOrders) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'sOrders';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'shop_orders';
                        break;
                    default:
                        $key = 'SOrders';
                }

                $result[$key] = $this->aSOrders->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
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
     * @return $this|\SOrderProducts
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = SOrderProductsTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\SOrderProducts
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setOrderId($value);
                break;
            case 2:
                $this->setKitId($value);
                break;
            case 3:
                $this->setIsMain($value);
                break;
            case 4:
                $this->setProductId($value);
                break;
            case 5:
                $this->setVariantId($value);
                break;
            case 6:
                $this->setProductName($value);
                break;
            case 7:
                $this->setVariantName($value);
                break;
            case 8:
                $this->setPrice($value);
                break;
            case 9:
                $this->setOriginPrice($value);
                break;
            case 10:
                $this->setQuantity($value);
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
        $keys = SOrderProductsTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setOrderId($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setKitId($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setIsMain($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setProductId($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setVariantId($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setProductName($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setVariantName($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setPrice($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setOriginPrice($arr[$keys[9]]);
        }
        if (array_key_exists($keys[10], $arr)) {
            $this->setQuantity($arr[$keys[10]]);
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
     * @return $this|\SOrderProducts The current object, for fluid interface
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
        $criteria = new Criteria(SOrderProductsTableMap::DATABASE_NAME);

        if ($this->isColumnModified(SOrderProductsTableMap::COL_ID)) {
            $criteria->add(SOrderProductsTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(SOrderProductsTableMap::COL_ORDER_ID)) {
            $criteria->add(SOrderProductsTableMap::COL_ORDER_ID, $this->order_id);
        }
        if ($this->isColumnModified(SOrderProductsTableMap::COL_KIT_ID)) {
            $criteria->add(SOrderProductsTableMap::COL_KIT_ID, $this->kit_id);
        }
        if ($this->isColumnModified(SOrderProductsTableMap::COL_IS_MAIN)) {
            $criteria->add(SOrderProductsTableMap::COL_IS_MAIN, $this->is_main);
        }
        if ($this->isColumnModified(SOrderProductsTableMap::COL_PRODUCT_ID)) {
            $criteria->add(SOrderProductsTableMap::COL_PRODUCT_ID, $this->product_id);
        }
        if ($this->isColumnModified(SOrderProductsTableMap::COL_VARIANT_ID)) {
            $criteria->add(SOrderProductsTableMap::COL_VARIANT_ID, $this->variant_id);
        }
        if ($this->isColumnModified(SOrderProductsTableMap::COL_PRODUCT_NAME)) {
            $criteria->add(SOrderProductsTableMap::COL_PRODUCT_NAME, $this->product_name);
        }
        if ($this->isColumnModified(SOrderProductsTableMap::COL_VARIANT_NAME)) {
            $criteria->add(SOrderProductsTableMap::COL_VARIANT_NAME, $this->variant_name);
        }
        if ($this->isColumnModified(SOrderProductsTableMap::COL_PRICE)) {
            $criteria->add(SOrderProductsTableMap::COL_PRICE, $this->price);
        }
        if ($this->isColumnModified(SOrderProductsTableMap::COL_ORIGIN_PRICE)) {
            $criteria->add(SOrderProductsTableMap::COL_ORIGIN_PRICE, $this->origin_price);
        }
        if ($this->isColumnModified(SOrderProductsTableMap::COL_QUANTITY)) {
            $criteria->add(SOrderProductsTableMap::COL_QUANTITY, $this->quantity);
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
        $criteria = ChildSOrderProductsQuery::create();
        $criteria->add(SOrderProductsTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \SOrderProducts (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setOrderId($this->getOrderId());
        $copyObj->setKitId($this->getKitId());
        $copyObj->setIsMain($this->getIsMain());
        $copyObj->setProductId($this->getProductId());
        $copyObj->setVariantId($this->getVariantId());
        $copyObj->setProductName($this->getProductName());
        $copyObj->setVariantName($this->getVariantName());
        $copyObj->setPrice($this->getPrice());
        $copyObj->setOriginPrice($this->getOriginPrice());
        $copyObj->setQuantity($this->getQuantity());
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
     * @return \SOrderProducts Clone of current object.
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
     * @return $this|\SOrderProducts The current object (for fluent API support)
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
            $v->addSOrderProducts($this);
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
                $this->aSProducts->addSOrderProductss($this);
             */
        }

        return $this->aSProducts;
    }

    /**
     * Declares an association between this object and a ChildSProductVariants object.
     *
     * @param  ChildSProductVariants $v
     * @return $this|\SOrderProducts The current object (for fluent API support)
     * @throws PropelException
     */
    public function setSProductVariants(ChildSProductVariants $v = null)
    {
        if ($v === null) {
            $this->setVariantId(NULL);
        } else {
            $this->setVariantId($v->getId());
        }

        $this->aSProductVariants = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildSProductVariants object, it will not be re-added.
        if ($v !== null) {
            $v->addSOrderProducts($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildSProductVariants object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildSProductVariants The associated ChildSProductVariants object.
     * @throws PropelException
     */
    public function getSProductVariants(ConnectionInterface $con = null)
    {
        if ($this->aSProductVariants === null && ($this->variant_id !== null)) {
            $this->aSProductVariants = ChildSProductVariantsQuery::create()->findPk($this->variant_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aSProductVariants->addSOrderProductss($this);
             */
        }

        return $this->aSProductVariants;
    }

    /**
     * Declares an association between this object and a ChildSOrders object.
     *
     * @param  ChildSOrders $v
     * @return $this|\SOrderProducts The current object (for fluent API support)
     * @throws PropelException
     */
    public function setSOrders(ChildSOrders $v = null)
    {
        if ($v === null) {
            $this->setOrderId(NULL);
        } else {
            $this->setOrderId($v->getId());
        }

        $this->aSOrders = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildSOrders object, it will not be re-added.
        if ($v !== null) {
            $v->addSOrderProducts($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildSOrders object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildSOrders The associated ChildSOrders object.
     * @throws PropelException
     */
    public function getSOrders(ConnectionInterface $con = null)
    {
        if ($this->aSOrders === null && ($this->order_id !== null)) {
            $this->aSOrders = ChildSOrdersQuery::create()->findPk($this->order_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aSOrders->addSOrderProductss($this);
             */
        }

        return $this->aSOrders;
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aSProducts) {
            $this->aSProducts->removeSOrderProducts($this);
        }
        if (null !== $this->aSProductVariants) {
            $this->aSProductVariants->removeSOrderProducts($this);
        }
        if (null !== $this->aSOrders) {
            $this->aSOrders->removeSOrderProducts($this);
        }
        $this->id = null;
        $this->order_id = null;
        $this->kit_id = null;
        $this->is_main = null;
        $this->product_id = null;
        $this->variant_id = null;
        $this->product_name = null;
        $this->variant_name = null;
        $this->price = null;
        $this->origin_price = null;
        $this->quantity = null;
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
        } // if ($deep)

        $this->aSProducts = null;
        $this->aSProductVariants = null;
        $this->aSOrders = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(SOrderProductsTableMap::DEFAULT_STRING_FORMAT);
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
