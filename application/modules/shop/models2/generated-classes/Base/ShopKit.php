<?php

namespace Base;

use \SProducts as ChildSProducts;
use \SProductsQuery as ChildSProductsQuery;
use \ShopKit as ChildShopKit;
use \ShopKitProduct as ChildShopKitProduct;
use \ShopKitProductQuery as ChildShopKitProductQuery;
use \ShopKitQuery as ChildShopKitQuery;
use \Exception;
use \PDO;
use Map\ShopKitTableMap;
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
 * Base class that represents a row from the 'shop_kit' table.
 *
 *
 *
* @package    propel.generator..Base
*/
abstract class ShopKit extends PropelBaseModelClass implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\ShopKitTableMap';


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
     * The value for the product_id field.
     * @var        int
     */
    protected $product_id;

    /**
     * The value for the active field.
     * Note: this column has a database default value of: true
     * @var        boolean
     */
    protected $active;

    /**
     * The value for the position field.
     * @var        int
     */
    protected $position;

    /**
     * The value for the only_for_logged field.
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $only_for_logged;

    /**
     * @var        ChildSProducts
     */
    protected $aSProducts;

    /**
     * @var        ObjectCollection|ChildShopKitProduct[] Collection to store aggregation of ChildShopKitProduct objects.
     */
    protected $collShopKitProducts;
    protected $collShopKitProductsPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildShopKitProduct[]
     */
    protected $shopKitProductsScheduledForDeletion = null;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see __construct()
     */
    public function applyDefaultValues()
    {
        $this->active = true;
        $this->only_for_logged = false;
    }

    /**
     * Initializes internal state of Base\ShopKit object.
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
     * Compares this with another <code>ShopKit</code> instance.  If
     * <code>obj</code> is an instance of <code>ShopKit</code>, delegates to
     * <code>equals(ShopKit)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|ShopKit The current object, for fluid interface
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
     * Get the [product_id] column value.
     *
     * @return int
     */
    public function getProductId()
    {
        return $this->product_id;
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
     * Get the [position] column value.
     *
     * @return int
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Get the [only_for_logged] column value.
     *
     * @return boolean
     */
    public function getOnlyForLogged()
    {
        return $this->only_for_logged;
    }

    /**
     * Get the [only_for_logged] column value.
     *
     * @return boolean
     */
    public function isOnlyForLogged()
    {
        return $this->getOnlyForLogged();
    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return $this|\ShopKit The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[ShopKitTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [product_id] column.
     *
     * @param int $v new value
     * @return $this|\ShopKit The current object (for fluent API support)
     */
    public function setProductId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->product_id !== $v) {
            $this->product_id = $v;
            $this->modifiedColumns[ShopKitTableMap::COL_PRODUCT_ID] = true;
        }

        if ($this->aSProducts !== null && $this->aSProducts->getId() !== $v) {
            $this->aSProducts = null;
        }

        return $this;
    } // setProductId()

    /**
     * Sets the value of the [active] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\ShopKit The current object (for fluent API support)
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
            $this->modifiedColumns[ShopKitTableMap::COL_ACTIVE] = true;
        }

        return $this;
    } // setActive()

    /**
     * Set the value of [position] column.
     *
     * @param int $v new value
     * @return $this|\ShopKit The current object (for fluent API support)
     */
    public function setPosition($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->position !== $v) {
            $this->position = $v;
            $this->modifiedColumns[ShopKitTableMap::COL_POSITION] = true;
        }

        return $this;
    } // setPosition()

    /**
     * Sets the value of the [only_for_logged] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\ShopKit The current object (for fluent API support)
     */
    public function setOnlyForLogged($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->only_for_logged !== $v) {
            $this->only_for_logged = $v;
            $this->modifiedColumns[ShopKitTableMap::COL_ONLY_FOR_LOGGED] = true;
        }

        return $this;
    } // setOnlyForLogged()

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
            if ($this->active !== true) {
                return false;
            }

            if ($this->only_for_logged !== false) {
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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : ShopKitTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : ShopKitTableMap::translateFieldName('ProductId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->product_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : ShopKitTableMap::translateFieldName('Active', TableMap::TYPE_PHPNAME, $indexType)];
            $this->active = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : ShopKitTableMap::translateFieldName('Position', TableMap::TYPE_PHPNAME, $indexType)];
            $this->position = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : ShopKitTableMap::translateFieldName('OnlyForLogged', TableMap::TYPE_PHPNAME, $indexType)];
            $this->only_for_logged = (null !== $col) ? (boolean) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 5; // 5 = ShopKitTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\ShopKit'), 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(ShopKitTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildShopKitQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aSProducts = null;
            $this->collShopKitProducts = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see ShopKit::setDeleted()
     * @see ShopKit::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(ShopKitTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildShopKitQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(ShopKitTableMap::DATABASE_NAME);
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
                ShopKitTableMap::addInstanceToPool($this);
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

        $this->modifiedColumns[ShopKitTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . ShopKitTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(ShopKitTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(ShopKitTableMap::COL_PRODUCT_ID)) {
            $modifiedColumns[':p' . $index++]  = 'product_id';
        }
        if ($this->isColumnModified(ShopKitTableMap::COL_ACTIVE)) {
            $modifiedColumns[':p' . $index++]  = 'active';
        }
        if ($this->isColumnModified(ShopKitTableMap::COL_POSITION)) {
            $modifiedColumns[':p' . $index++]  = 'position';
        }
        if ($this->isColumnModified(ShopKitTableMap::COL_ONLY_FOR_LOGGED)) {
            $modifiedColumns[':p' . $index++]  = 'only_for_logged';
        }

        $sql = sprintf(
            'INSERT INTO shop_kit (%s) VALUES (%s)',
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
                    case 'product_id':
                        $stmt->bindValue($identifier, $this->product_id, PDO::PARAM_INT);
                        break;
                    case 'active':
                        $stmt->bindValue($identifier, (int) $this->active, PDO::PARAM_INT);
                        break;
                    case 'position':
                        $stmt->bindValue($identifier, $this->position, PDO::PARAM_INT);
                        break;
                    case 'only_for_logged':
                        $stmt->bindValue($identifier, (int) $this->only_for_logged, PDO::PARAM_INT);
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
        $pos = ShopKitTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getProductId();
                break;
            case 2:
                return $this->getActive();
                break;
            case 3:
                return $this->getPosition();
                break;
            case 4:
                return $this->getOnlyForLogged();
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

        if (isset($alreadyDumpedObjects['ShopKit'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['ShopKit'][$this->hashCode()] = true;
        $keys = ShopKitTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getProductId(),
            $keys[2] => $this->getActive(),
            $keys[3] => $this->getPosition(),
            $keys[4] => $this->getOnlyForLogged(),
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
     * @return $this|\ShopKit
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = ShopKitTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\ShopKit
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setProductId($value);
                break;
            case 2:
                $this->setActive($value);
                break;
            case 3:
                $this->setPosition($value);
                break;
            case 4:
                $this->setOnlyForLogged($value);
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
        $keys = ShopKitTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setProductId($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setActive($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setPosition($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setOnlyForLogged($arr[$keys[4]]);
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
     * @return $this|\ShopKit The current object, for fluid interface
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
        $criteria = new Criteria(ShopKitTableMap::DATABASE_NAME);

        if ($this->isColumnModified(ShopKitTableMap::COL_ID)) {
            $criteria->add(ShopKitTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(ShopKitTableMap::COL_PRODUCT_ID)) {
            $criteria->add(ShopKitTableMap::COL_PRODUCT_ID, $this->product_id);
        }
        if ($this->isColumnModified(ShopKitTableMap::COL_ACTIVE)) {
            $criteria->add(ShopKitTableMap::COL_ACTIVE, $this->active);
        }
        if ($this->isColumnModified(ShopKitTableMap::COL_POSITION)) {
            $criteria->add(ShopKitTableMap::COL_POSITION, $this->position);
        }
        if ($this->isColumnModified(ShopKitTableMap::COL_ONLY_FOR_LOGGED)) {
            $criteria->add(ShopKitTableMap::COL_ONLY_FOR_LOGGED, $this->only_for_logged);
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
        $criteria = ChildShopKitQuery::create();
        $criteria->add(ShopKitTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \ShopKit (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setProductId($this->getProductId());
        $copyObj->setActive($this->getActive());
        $copyObj->setPosition($this->getPosition());
        $copyObj->setOnlyForLogged($this->getOnlyForLogged());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getShopKitProducts() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addShopKitProduct($relObj->copy($deepCopy));
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
     * @return \ShopKit Clone of current object.
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
     * @return $this|\ShopKit The current object (for fluent API support)
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
            $v->addShopKit($this);
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
                $this->aSProducts->addShopKits($this);
             */
        }

        return $this->aSProducts;
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
     * If this ChildShopKit is new, it will return
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
                    ->filterByShopKit($this)
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
     * @return $this|ChildShopKit The current object (for fluent API support)
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
            $shopKitProductRemoved->setShopKit(null);
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
                ->filterByShopKit($this)
                ->count($con);
        }

        return count($this->collShopKitProducts);
    }

    /**
     * Method called to associate a ChildShopKitProduct object to this object
     * through the ChildShopKitProduct foreign key attribute.
     *
     * @param  ChildShopKitProduct $l ChildShopKitProduct
     * @return $this|\ShopKit The current object (for fluent API support)
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
        $shopKitProduct->setShopKit($this);
    }

    /**
     * @param  ChildShopKitProduct $shopKitProduct The ChildShopKitProduct object to remove.
     * @return $this|ChildShopKit The current object (for fluent API support)
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
            $shopKitProduct->setShopKit(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this ShopKit is new, it will return
     * an empty collection; or if this ShopKit has previously
     * been saved, it will retrieve related ShopKitProducts from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in ShopKit.
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
     * Otherwise if this ShopKit is new, it will return
     * an empty collection; or if this ShopKit has previously
     * been saved, it will retrieve related ShopKitProducts from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in ShopKit.
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
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aSProducts) {
            $this->aSProducts->removeShopKit($this);
        }
        $this->id = null;
        $this->product_id = null;
        $this->active = null;
        $this->position = null;
        $this->only_for_logged = null;
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
            if ($this->collShopKitProducts) {
                foreach ($this->collShopKitProducts as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collShopKitProducts = null;
        $this->aSProducts = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(ShopKitTableMap::DEFAULT_STRING_FORMAT);
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
