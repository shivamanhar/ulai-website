<?php

namespace Base;

use \SCurrencies as ChildSCurrencies;
use \SCurrenciesQuery as ChildSCurrenciesQuery;
use \SDeliveryMethods as ChildSDeliveryMethods;
use \SDeliveryMethodsQuery as ChildSDeliveryMethodsQuery;
use \SOrders as ChildSOrders;
use \SOrdersQuery as ChildSOrdersQuery;
use \SPaymentMethods as ChildSPaymentMethods;
use \SPaymentMethodsI18n as ChildSPaymentMethodsI18n;
use \SPaymentMethodsI18nQuery as ChildSPaymentMethodsI18nQuery;
use \SPaymentMethodsQuery as ChildSPaymentMethodsQuery;
use \ShopDeliveryMethodsSystems as ChildShopDeliveryMethodsSystems;
use \ShopDeliveryMethodsSystemsQuery as ChildShopDeliveryMethodsSystemsQuery;
use \Exception;
use \PDO;
use Map\SPaymentMethodsTableMap;
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
 * Base class that represents a row from the 'shop_payment_methods' table.
 *
 *
 *
* @package    propel.generator..Base
*/
abstract class SPaymentMethods extends PropelBaseModelClass implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\SPaymentMethodsTableMap';


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
     * The value for the active field.
     * @var        boolean
     */
    protected $active;

    /**
     * The value for the currency_id field.
     * @var        int
     */
    protected $currency_id;

    /**
     * The value for the payment_system_name field.
     * @var        string
     */
    protected $payment_system_name;

    /**
     * The value for the position field.
     * @var        int
     */
    protected $position;

    /**
     * @var        ChildSCurrencies
     */
    protected $aCurrency;

    /**
     * @var        ObjectCollection|ChildShopDeliveryMethodsSystems[] Collection to store aggregation of ChildShopDeliveryMethodsSystems objects.
     */
    protected $collShopDeliveryMethodsSystemss;
    protected $collShopDeliveryMethodsSystemssPartial;

    /**
     * @var        ObjectCollection|ChildSOrders[] Collection to store aggregation of ChildSOrders objects.
     */
    protected $collSOrderss;
    protected $collSOrderssPartial;

    /**
     * @var        ObjectCollection|ChildSPaymentMethodsI18n[] Collection to store aggregation of ChildSPaymentMethodsI18n objects.
     */
    protected $collSPaymentMethodsI18ns;
    protected $collSPaymentMethodsI18nsPartial;

    /**
     * @var        ObjectCollection|ChildSDeliveryMethods[] Cross Collection to store aggregation of ChildSDeliveryMethods objects.
     */
    protected $collSDeliveryMethodss;

    /**
     * @var bool
     */
    protected $collSDeliveryMethodssPartial;

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
     * @var        array[ChildSPaymentMethodsI18n]
     */
    protected $currentTranslations;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildSDeliveryMethods[]
     */
    protected $sDeliveryMethodssScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildShopDeliveryMethodsSystems[]
     */
    protected $shopDeliveryMethodsSystemssScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildSOrders[]
     */
    protected $sOrderssScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildSPaymentMethodsI18n[]
     */
    protected $sPaymentMethodsI18nsScheduledForDeletion = null;

    /**
     * Initializes internal state of Base\SPaymentMethods object.
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
     * Compares this with another <code>SPaymentMethods</code> instance.  If
     * <code>obj</code> is an instance of <code>SPaymentMethods</code>, delegates to
     * <code>equals(SPaymentMethods)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|SPaymentMethods The current object, for fluid interface
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
     * Get the [currency_id] column value.
     *
     * @return int
     */
    public function getCurrencyId()
    {
        return $this->currency_id;
    }

    /**
     * Get the [payment_system_name] column value.
     *
     * @return string
     */
    public function getPaymentSystemName()
    {
        return $this->payment_system_name;
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
     * @return $this|\SPaymentMethods The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[SPaymentMethodsTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Sets the value of the [active] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\SPaymentMethods The current object (for fluent API support)
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
            $this->modifiedColumns[SPaymentMethodsTableMap::COL_ACTIVE] = true;
        }

        return $this;
    } // setActive()

    /**
     * Set the value of [currency_id] column.
     *
     * @param int $v new value
     * @return $this|\SPaymentMethods The current object (for fluent API support)
     */
    public function setCurrencyId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->currency_id !== $v) {
            $this->currency_id = $v;
            $this->modifiedColumns[SPaymentMethodsTableMap::COL_CURRENCY_ID] = true;
        }

        if ($this->aCurrency !== null && $this->aCurrency->getId() !== $v) {
            $this->aCurrency = null;
        }

        return $this;
    } // setCurrencyId()

    /**
     * Set the value of [payment_system_name] column.
     *
     * @param string $v new value
     * @return $this|\SPaymentMethods The current object (for fluent API support)
     */
    public function setPaymentSystemName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->payment_system_name !== $v) {
            $this->payment_system_name = $v;
            $this->modifiedColumns[SPaymentMethodsTableMap::COL_PAYMENT_SYSTEM_NAME] = true;
        }

        return $this;
    } // setPaymentSystemName()

    /**
     * Set the value of [position] column.
     *
     * @param int $v new value
     * @return $this|\SPaymentMethods The current object (for fluent API support)
     */
    public function setPosition($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->position !== $v) {
            $this->position = $v;
            $this->modifiedColumns[SPaymentMethodsTableMap::COL_POSITION] = true;
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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : SPaymentMethodsTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : SPaymentMethodsTableMap::translateFieldName('Active', TableMap::TYPE_PHPNAME, $indexType)];
            $this->active = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : SPaymentMethodsTableMap::translateFieldName('CurrencyId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->currency_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : SPaymentMethodsTableMap::translateFieldName('PaymentSystemName', TableMap::TYPE_PHPNAME, $indexType)];
            $this->payment_system_name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : SPaymentMethodsTableMap::translateFieldName('Position', TableMap::TYPE_PHPNAME, $indexType)];
            $this->position = (null !== $col) ? (int) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 5; // 5 = SPaymentMethodsTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\SPaymentMethods'), 0, $e);
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
        if ($this->aCurrency !== null && $this->currency_id !== $this->aCurrency->getId()) {
            $this->aCurrency = null;
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
            $con = Propel::getServiceContainer()->getReadConnection(SPaymentMethodsTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildSPaymentMethodsQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aCurrency = null;
            $this->collShopDeliveryMethodsSystemss = null;

            $this->collSOrderss = null;

            $this->collSPaymentMethodsI18ns = null;

            $this->collSDeliveryMethodss = null;
        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see SPaymentMethods::setDeleted()
     * @see SPaymentMethods::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(SPaymentMethodsTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildSPaymentMethodsQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(SPaymentMethodsTableMap::DATABASE_NAME);
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
                SPaymentMethodsTableMap::addInstanceToPool($this);
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

            if ($this->aCurrency !== null) {
                if ($this->aCurrency->isModified() || $this->aCurrency->isNew()) {
                    $affectedRows += $this->aCurrency->save($con);
                }
                $this->setCurrency($this->aCurrency);
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

            if ($this->sDeliveryMethodssScheduledForDeletion !== null) {
                if (!$this->sDeliveryMethodssScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    foreach ($this->sDeliveryMethodssScheduledForDeletion as $entry) {
                        $entryPk = [];

                        $entryPk[1] = $this->getId();
                        $entryPk[0] = $entry->getId();
                        $pks[] = $entryPk;
                    }

                    \ShopDeliveryMethodsSystemsQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);

                    $this->sDeliveryMethodssScheduledForDeletion = null;
                }

            }

            if ($this->collSDeliveryMethodss) {
                foreach ($this->collSDeliveryMethodss as $sDeliveryMethods) {
                    if (!$sDeliveryMethods->isDeleted() && ($sDeliveryMethods->isNew() || $sDeliveryMethods->isModified())) {
                        $sDeliveryMethods->save($con);
                    }
                }
            }


            if ($this->shopDeliveryMethodsSystemssScheduledForDeletion !== null) {
                if (!$this->shopDeliveryMethodsSystemssScheduledForDeletion->isEmpty()) {
                    \ShopDeliveryMethodsSystemsQuery::create()
                        ->filterByPrimaryKeys($this->shopDeliveryMethodsSystemssScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->shopDeliveryMethodsSystemssScheduledForDeletion = null;
                }
            }

            if ($this->collShopDeliveryMethodsSystemss !== null) {
                foreach ($this->collShopDeliveryMethodsSystemss as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->sOrderssScheduledForDeletion !== null) {
                if (!$this->sOrderssScheduledForDeletion->isEmpty()) {
                    foreach ($this->sOrderssScheduledForDeletion as $sOrders) {
                        // need to save related object because we set the relation to null
                        $sOrders->save($con);
                    }
                    $this->sOrderssScheduledForDeletion = null;
                }
            }

            if ($this->collSOrderss !== null) {
                foreach ($this->collSOrderss as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->sPaymentMethodsI18nsScheduledForDeletion !== null) {
                if (!$this->sPaymentMethodsI18nsScheduledForDeletion->isEmpty()) {
                    \SPaymentMethodsI18nQuery::create()
                        ->filterByPrimaryKeys($this->sPaymentMethodsI18nsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->sPaymentMethodsI18nsScheduledForDeletion = null;
                }
            }

            if ($this->collSPaymentMethodsI18ns !== null) {
                foreach ($this->collSPaymentMethodsI18ns as $referrerFK) {
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

        $this->modifiedColumns[SPaymentMethodsTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . SPaymentMethodsTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(SPaymentMethodsTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(SPaymentMethodsTableMap::COL_ACTIVE)) {
            $modifiedColumns[':p' . $index++]  = 'active';
        }
        if ($this->isColumnModified(SPaymentMethodsTableMap::COL_CURRENCY_ID)) {
            $modifiedColumns[':p' . $index++]  = 'currency_id';
        }
        if ($this->isColumnModified(SPaymentMethodsTableMap::COL_PAYMENT_SYSTEM_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'payment_system_name';
        }
        if ($this->isColumnModified(SPaymentMethodsTableMap::COL_POSITION)) {
            $modifiedColumns[':p' . $index++]  = 'position';
        }

        $sql = sprintf(
            'INSERT INTO shop_payment_methods (%s) VALUES (%s)',
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
                    case 'active':
                        $stmt->bindValue($identifier, (int) $this->active, PDO::PARAM_INT);
                        break;
                    case 'currency_id':
                        $stmt->bindValue($identifier, $this->currency_id, PDO::PARAM_INT);
                        break;
                    case 'payment_system_name':
                        $stmt->bindValue($identifier, $this->payment_system_name, PDO::PARAM_STR);
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
        $pos = SPaymentMethodsTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getActive();
                break;
            case 2:
                return $this->getCurrencyId();
                break;
            case 3:
                return $this->getPaymentSystemName();
                break;
            case 4:
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

        if (isset($alreadyDumpedObjects['SPaymentMethods'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['SPaymentMethods'][$this->hashCode()] = true;
        $keys = SPaymentMethodsTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getActive(),
            $keys[2] => $this->getCurrencyId(),
            $keys[3] => $this->getPaymentSystemName(),
            $keys[4] => $this->getPosition(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aCurrency) {

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

                $result[$key] = $this->aCurrency->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collShopDeliveryMethodsSystemss) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'shopDeliveryMethodsSystemss';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'shop_delivery_methods_systemss';
                        break;
                    default:
                        $key = 'ShopDeliveryMethodsSystemss';
                }

                $result[$key] = $this->collShopDeliveryMethodsSystemss->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collSOrderss) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'sOrderss';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'shop_orderss';
                        break;
                    default:
                        $key = 'SOrderss';
                }

                $result[$key] = $this->collSOrderss->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collSPaymentMethodsI18ns) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'sPaymentMethodsI18ns';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'shop_payment_methods_i18ns';
                        break;
                    default:
                        $key = 'SPaymentMethodsI18ns';
                }

                $result[$key] = $this->collSPaymentMethodsI18ns->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\SPaymentMethods
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = SPaymentMethodsTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\SPaymentMethods
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setActive($value);
                break;
            case 2:
                $this->setCurrencyId($value);
                break;
            case 3:
                $this->setPaymentSystemName($value);
                break;
            case 4:
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
        $keys = SPaymentMethodsTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setActive($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setCurrencyId($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setPaymentSystemName($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setPosition($arr[$keys[4]]);
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
     * @return $this|\SPaymentMethods The current object, for fluid interface
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
        $criteria = new Criteria(SPaymentMethodsTableMap::DATABASE_NAME);

        if ($this->isColumnModified(SPaymentMethodsTableMap::COL_ID)) {
            $criteria->add(SPaymentMethodsTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(SPaymentMethodsTableMap::COL_ACTIVE)) {
            $criteria->add(SPaymentMethodsTableMap::COL_ACTIVE, $this->active);
        }
        if ($this->isColumnModified(SPaymentMethodsTableMap::COL_CURRENCY_ID)) {
            $criteria->add(SPaymentMethodsTableMap::COL_CURRENCY_ID, $this->currency_id);
        }
        if ($this->isColumnModified(SPaymentMethodsTableMap::COL_PAYMENT_SYSTEM_NAME)) {
            $criteria->add(SPaymentMethodsTableMap::COL_PAYMENT_SYSTEM_NAME, $this->payment_system_name);
        }
        if ($this->isColumnModified(SPaymentMethodsTableMap::COL_POSITION)) {
            $criteria->add(SPaymentMethodsTableMap::COL_POSITION, $this->position);
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
        $criteria = ChildSPaymentMethodsQuery::create();
        $criteria->add(SPaymentMethodsTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \SPaymentMethods (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setActive($this->getActive());
        $copyObj->setCurrencyId($this->getCurrencyId());
        $copyObj->setPaymentSystemName($this->getPaymentSystemName());
        $copyObj->setPosition($this->getPosition());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getShopDeliveryMethodsSystemss() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addShopDeliveryMethodsSystems($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getSOrderss() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addSOrders($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getSPaymentMethodsI18ns() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addSPaymentMethodsI18n($relObj->copy($deepCopy));
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
     * @return \SPaymentMethods Clone of current object.
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
     * Declares an association between this object and a ChildSCurrencies object.
     *
     * @param  ChildSCurrencies $v
     * @return $this|\SPaymentMethods The current object (for fluent API support)
     * @throws PropelException
     */
    public function setCurrency(ChildSCurrencies $v = null)
    {
        if ($v === null) {
            $this->setCurrencyId(NULL);
        } else {
            $this->setCurrencyId($v->getId());
        }

        $this->aCurrency = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildSCurrencies object, it will not be re-added.
        if ($v !== null) {
            $v->addSPaymentMethods($this);
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
    public function getCurrency(ConnectionInterface $con = null)
    {
        if ($this->aCurrency === null && ($this->currency_id !== null)) {
            $this->aCurrency = ChildSCurrenciesQuery::create()->findPk($this->currency_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aCurrency->addSPaymentMethodss($this);
             */
        }

        return $this->aCurrency;
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
        if ('ShopDeliveryMethodsSystems' == $relationName) {
            return $this->initShopDeliveryMethodsSystemss();
        }
        if ('SOrders' == $relationName) {
            return $this->initSOrderss();
        }
        if ('SPaymentMethodsI18n' == $relationName) {
            return $this->initSPaymentMethodsI18ns();
        }
    }

    /**
     * Clears out the collShopDeliveryMethodsSystemss collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addShopDeliveryMethodsSystemss()
     */
    public function clearShopDeliveryMethodsSystemss()
    {
        $this->collShopDeliveryMethodsSystemss = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collShopDeliveryMethodsSystemss collection loaded partially.
     */
    public function resetPartialShopDeliveryMethodsSystemss($v = true)
    {
        $this->collShopDeliveryMethodsSystemssPartial = $v;
    }

    /**
     * Initializes the collShopDeliveryMethodsSystemss collection.
     *
     * By default this just sets the collShopDeliveryMethodsSystemss collection to an empty array (like clearcollShopDeliveryMethodsSystemss());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initShopDeliveryMethodsSystemss($overrideExisting = true)
    {
        if (null !== $this->collShopDeliveryMethodsSystemss && !$overrideExisting) {
            return;
        }
        $this->collShopDeliveryMethodsSystemss = new ObjectCollection();
        $this->collShopDeliveryMethodsSystemss->setModel('\ShopDeliveryMethodsSystems');
    }

    /**
     * Gets an array of ChildShopDeliveryMethodsSystems objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildSPaymentMethods is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildShopDeliveryMethodsSystems[] List of ChildShopDeliveryMethodsSystems objects
     * @throws PropelException
     */
    public function getShopDeliveryMethodsSystemss(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collShopDeliveryMethodsSystemssPartial && !$this->isNew();
        if (null === $this->collShopDeliveryMethodsSystemss || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collShopDeliveryMethodsSystemss) {
                // return empty collection
                $this->initShopDeliveryMethodsSystemss();
            } else {
                $collShopDeliveryMethodsSystemss = ChildShopDeliveryMethodsSystemsQuery::create(null, $criteria)
                    ->filterByPaymentMethods($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collShopDeliveryMethodsSystemssPartial && count($collShopDeliveryMethodsSystemss)) {
                        $this->initShopDeliveryMethodsSystemss(false);

                        foreach ($collShopDeliveryMethodsSystemss as $obj) {
                            if (false == $this->collShopDeliveryMethodsSystemss->contains($obj)) {
                                $this->collShopDeliveryMethodsSystemss->append($obj);
                            }
                        }

                        $this->collShopDeliveryMethodsSystemssPartial = true;
                    }

                    return $collShopDeliveryMethodsSystemss;
                }

                if ($partial && $this->collShopDeliveryMethodsSystemss) {
                    foreach ($this->collShopDeliveryMethodsSystemss as $obj) {
                        if ($obj->isNew()) {
                            $collShopDeliveryMethodsSystemss[] = $obj;
                        }
                    }
                }

                $this->collShopDeliveryMethodsSystemss = $collShopDeliveryMethodsSystemss;
                $this->collShopDeliveryMethodsSystemssPartial = false;
            }
        }

        return $this->collShopDeliveryMethodsSystemss;
    }

    /**
     * Sets a collection of ChildShopDeliveryMethodsSystems objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $shopDeliveryMethodsSystemss A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildSPaymentMethods The current object (for fluent API support)
     */
    public function setShopDeliveryMethodsSystemss(Collection $shopDeliveryMethodsSystemss, ConnectionInterface $con = null)
    {
        /** @var ChildShopDeliveryMethodsSystems[] $shopDeliveryMethodsSystemssToDelete */
        $shopDeliveryMethodsSystemssToDelete = $this->getShopDeliveryMethodsSystemss(new Criteria(), $con)->diff($shopDeliveryMethodsSystemss);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->shopDeliveryMethodsSystemssScheduledForDeletion = clone $shopDeliveryMethodsSystemssToDelete;

        foreach ($shopDeliveryMethodsSystemssToDelete as $shopDeliveryMethodsSystemsRemoved) {
            $shopDeliveryMethodsSystemsRemoved->setPaymentMethods(null);
        }

        $this->collShopDeliveryMethodsSystemss = null;
        foreach ($shopDeliveryMethodsSystemss as $shopDeliveryMethodsSystems) {
            $this->addShopDeliveryMethodsSystems($shopDeliveryMethodsSystems);
        }

        $this->collShopDeliveryMethodsSystemss = $shopDeliveryMethodsSystemss;
        $this->collShopDeliveryMethodsSystemssPartial = false;

        return $this;
    }

    /**
     * Returns the number of related ShopDeliveryMethodsSystems objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related ShopDeliveryMethodsSystems objects.
     * @throws PropelException
     */
    public function countShopDeliveryMethodsSystemss(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collShopDeliveryMethodsSystemssPartial && !$this->isNew();
        if (null === $this->collShopDeliveryMethodsSystemss || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collShopDeliveryMethodsSystemss) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getShopDeliveryMethodsSystemss());
            }

            $query = ChildShopDeliveryMethodsSystemsQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByPaymentMethods($this)
                ->count($con);
        }

        return count($this->collShopDeliveryMethodsSystemss);
    }

    /**
     * Method called to associate a ChildShopDeliveryMethodsSystems object to this object
     * through the ChildShopDeliveryMethodsSystems foreign key attribute.
     *
     * @param  ChildShopDeliveryMethodsSystems $l ChildShopDeliveryMethodsSystems
     * @return $this|\SPaymentMethods The current object (for fluent API support)
     */
    public function addShopDeliveryMethodsSystems(ChildShopDeliveryMethodsSystems $l)
    {
        if ($this->collShopDeliveryMethodsSystemss === null) {
            $this->initShopDeliveryMethodsSystemss();
            $this->collShopDeliveryMethodsSystemssPartial = true;
        }

        if (!$this->collShopDeliveryMethodsSystemss->contains($l)) {
            $this->doAddShopDeliveryMethodsSystems($l);
        }

        return $this;
    }

    /**
     * @param ChildShopDeliveryMethodsSystems $shopDeliveryMethodsSystems The ChildShopDeliveryMethodsSystems object to add.
     */
    protected function doAddShopDeliveryMethodsSystems(ChildShopDeliveryMethodsSystems $shopDeliveryMethodsSystems)
    {
        $this->collShopDeliveryMethodsSystemss[]= $shopDeliveryMethodsSystems;
        $shopDeliveryMethodsSystems->setPaymentMethods($this);
    }

    /**
     * @param  ChildShopDeliveryMethodsSystems $shopDeliveryMethodsSystems The ChildShopDeliveryMethodsSystems object to remove.
     * @return $this|ChildSPaymentMethods The current object (for fluent API support)
     */
    public function removeShopDeliveryMethodsSystems(ChildShopDeliveryMethodsSystems $shopDeliveryMethodsSystems)
    {
        if ($this->getShopDeliveryMethodsSystemss()->contains($shopDeliveryMethodsSystems)) {
            $pos = $this->collShopDeliveryMethodsSystemss->search($shopDeliveryMethodsSystems);
            $this->collShopDeliveryMethodsSystemss->remove($pos);
            if (null === $this->shopDeliveryMethodsSystemssScheduledForDeletion) {
                $this->shopDeliveryMethodsSystemssScheduledForDeletion = clone $this->collShopDeliveryMethodsSystemss;
                $this->shopDeliveryMethodsSystemssScheduledForDeletion->clear();
            }
            $this->shopDeliveryMethodsSystemssScheduledForDeletion[]= clone $shopDeliveryMethodsSystems;
            $shopDeliveryMethodsSystems->setPaymentMethods(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this SPaymentMethods is new, it will return
     * an empty collection; or if this SPaymentMethods has previously
     * been saved, it will retrieve related ShopDeliveryMethodsSystemss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in SPaymentMethods.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildShopDeliveryMethodsSystems[] List of ChildShopDeliveryMethodsSystems objects
     */
    public function getShopDeliveryMethodsSystemssJoinSDeliveryMethods(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildShopDeliveryMethodsSystemsQuery::create(null, $criteria);
        $query->joinWith('SDeliveryMethods', $joinBehavior);

        return $this->getShopDeliveryMethodsSystemss($query, $con);
    }

    /**
     * Clears out the collSOrderss collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addSOrderss()
     */
    public function clearSOrderss()
    {
        $this->collSOrderss = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collSOrderss collection loaded partially.
     */
    public function resetPartialSOrderss($v = true)
    {
        $this->collSOrderssPartial = $v;
    }

    /**
     * Initializes the collSOrderss collection.
     *
     * By default this just sets the collSOrderss collection to an empty array (like clearcollSOrderss());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initSOrderss($overrideExisting = true)
    {
        if (null !== $this->collSOrderss && !$overrideExisting) {
            return;
        }
        $this->collSOrderss = new ObjectCollection();
        $this->collSOrderss->setModel('\SOrders');
    }

    /**
     * Gets an array of ChildSOrders objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildSPaymentMethods is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildSOrders[] List of ChildSOrders objects
     * @throws PropelException
     */
    public function getSOrderss(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collSOrderssPartial && !$this->isNew();
        if (null === $this->collSOrderss || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collSOrderss) {
                // return empty collection
                $this->initSOrderss();
            } else {
                $collSOrderss = ChildSOrdersQuery::create(null, $criteria)
                    ->filterBySPaymentMethods($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collSOrderssPartial && count($collSOrderss)) {
                        $this->initSOrderss(false);

                        foreach ($collSOrderss as $obj) {
                            if (false == $this->collSOrderss->contains($obj)) {
                                $this->collSOrderss->append($obj);
                            }
                        }

                        $this->collSOrderssPartial = true;
                    }

                    return $collSOrderss;
                }

                if ($partial && $this->collSOrderss) {
                    foreach ($this->collSOrderss as $obj) {
                        if ($obj->isNew()) {
                            $collSOrderss[] = $obj;
                        }
                    }
                }

                $this->collSOrderss = $collSOrderss;
                $this->collSOrderssPartial = false;
            }
        }

        return $this->collSOrderss;
    }

    /**
     * Sets a collection of ChildSOrders objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $sOrderss A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildSPaymentMethods The current object (for fluent API support)
     */
    public function setSOrderss(Collection $sOrderss, ConnectionInterface $con = null)
    {
        /** @var ChildSOrders[] $sOrderssToDelete */
        $sOrderssToDelete = $this->getSOrderss(new Criteria(), $con)->diff($sOrderss);


        $this->sOrderssScheduledForDeletion = $sOrderssToDelete;

        foreach ($sOrderssToDelete as $sOrdersRemoved) {
            $sOrdersRemoved->setSPaymentMethods(null);
        }

        $this->collSOrderss = null;
        foreach ($sOrderss as $sOrders) {
            $this->addSOrders($sOrders);
        }

        $this->collSOrderss = $sOrderss;
        $this->collSOrderssPartial = false;

        return $this;
    }

    /**
     * Returns the number of related SOrders objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related SOrders objects.
     * @throws PropelException
     */
    public function countSOrderss(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collSOrderssPartial && !$this->isNew();
        if (null === $this->collSOrderss || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collSOrderss) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getSOrderss());
            }

            $query = ChildSOrdersQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterBySPaymentMethods($this)
                ->count($con);
        }

        return count($this->collSOrderss);
    }

    /**
     * Method called to associate a ChildSOrders object to this object
     * through the ChildSOrders foreign key attribute.
     *
     * @param  ChildSOrders $l ChildSOrders
     * @return $this|\SPaymentMethods The current object (for fluent API support)
     */
    public function addSOrders(ChildSOrders $l)
    {
        if ($this->collSOrderss === null) {
            $this->initSOrderss();
            $this->collSOrderssPartial = true;
        }

        if (!$this->collSOrderss->contains($l)) {
            $this->doAddSOrders($l);
        }

        return $this;
    }

    /**
     * @param ChildSOrders $sOrders The ChildSOrders object to add.
     */
    protected function doAddSOrders(ChildSOrders $sOrders)
    {
        $this->collSOrderss[]= $sOrders;
        $sOrders->setSPaymentMethods($this);
    }

    /**
     * @param  ChildSOrders $sOrders The ChildSOrders object to remove.
     * @return $this|ChildSPaymentMethods The current object (for fluent API support)
     */
    public function removeSOrders(ChildSOrders $sOrders)
    {
        if ($this->getSOrderss()->contains($sOrders)) {
            $pos = $this->collSOrderss->search($sOrders);
            $this->collSOrderss->remove($pos);
            if (null === $this->sOrderssScheduledForDeletion) {
                $this->sOrderssScheduledForDeletion = clone $this->collSOrderss;
                $this->sOrderssScheduledForDeletion->clear();
            }
            $this->sOrderssScheduledForDeletion[]= $sOrders;
            $sOrders->setSPaymentMethods(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this SPaymentMethods is new, it will return
     * an empty collection; or if this SPaymentMethods has previously
     * been saved, it will retrieve related SOrderss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in SPaymentMethods.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildSOrders[] List of ChildSOrders objects
     */
    public function getSOrderssJoinSDeliveryMethods(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildSOrdersQuery::create(null, $criteria);
        $query->joinWith('SDeliveryMethods', $joinBehavior);

        return $this->getSOrderss($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this SPaymentMethods is new, it will return
     * an empty collection; or if this SPaymentMethods has previously
     * been saved, it will retrieve related SOrderss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in SPaymentMethods.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildSOrders[] List of ChildSOrders objects
     */
    public function getSOrderssJoinSOrderStatuses(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildSOrdersQuery::create(null, $criteria);
        $query->joinWith('SOrderStatuses', $joinBehavior);

        return $this->getSOrderss($query, $con);
    }

    /**
     * Clears out the collSPaymentMethodsI18ns collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addSPaymentMethodsI18ns()
     */
    public function clearSPaymentMethodsI18ns()
    {
        $this->collSPaymentMethodsI18ns = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collSPaymentMethodsI18ns collection loaded partially.
     */
    public function resetPartialSPaymentMethodsI18ns($v = true)
    {
        $this->collSPaymentMethodsI18nsPartial = $v;
    }

    /**
     * Initializes the collSPaymentMethodsI18ns collection.
     *
     * By default this just sets the collSPaymentMethodsI18ns collection to an empty array (like clearcollSPaymentMethodsI18ns());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initSPaymentMethodsI18ns($overrideExisting = true)
    {
        if (null !== $this->collSPaymentMethodsI18ns && !$overrideExisting) {
            return;
        }
        $this->collSPaymentMethodsI18ns = new ObjectCollection();
        $this->collSPaymentMethodsI18ns->setModel('\SPaymentMethodsI18n');
    }

    /**
     * Gets an array of ChildSPaymentMethodsI18n objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildSPaymentMethods is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildSPaymentMethodsI18n[] List of ChildSPaymentMethodsI18n objects
     * @throws PropelException
     */
    public function getSPaymentMethodsI18ns(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collSPaymentMethodsI18nsPartial && !$this->isNew();
        if (null === $this->collSPaymentMethodsI18ns || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collSPaymentMethodsI18ns) {
                // return empty collection
                $this->initSPaymentMethodsI18ns();
            } else {
                $collSPaymentMethodsI18ns = ChildSPaymentMethodsI18nQuery::create(null, $criteria)
                    ->filterBySPaymentMethods($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collSPaymentMethodsI18nsPartial && count($collSPaymentMethodsI18ns)) {
                        $this->initSPaymentMethodsI18ns(false);

                        foreach ($collSPaymentMethodsI18ns as $obj) {
                            if (false == $this->collSPaymentMethodsI18ns->contains($obj)) {
                                $this->collSPaymentMethodsI18ns->append($obj);
                            }
                        }

                        $this->collSPaymentMethodsI18nsPartial = true;
                    }

                    return $collSPaymentMethodsI18ns;
                }

                if ($partial && $this->collSPaymentMethodsI18ns) {
                    foreach ($this->collSPaymentMethodsI18ns as $obj) {
                        if ($obj->isNew()) {
                            $collSPaymentMethodsI18ns[] = $obj;
                        }
                    }
                }

                $this->collSPaymentMethodsI18ns = $collSPaymentMethodsI18ns;
                $this->collSPaymentMethodsI18nsPartial = false;
            }
        }

        return $this->collSPaymentMethodsI18ns;
    }

    /**
     * Sets a collection of ChildSPaymentMethodsI18n objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $sPaymentMethodsI18ns A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildSPaymentMethods The current object (for fluent API support)
     */
    public function setSPaymentMethodsI18ns(Collection $sPaymentMethodsI18ns, ConnectionInterface $con = null)
    {
        /** @var ChildSPaymentMethodsI18n[] $sPaymentMethodsI18nsToDelete */
        $sPaymentMethodsI18nsToDelete = $this->getSPaymentMethodsI18ns(new Criteria(), $con)->diff($sPaymentMethodsI18ns);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->sPaymentMethodsI18nsScheduledForDeletion = clone $sPaymentMethodsI18nsToDelete;

        foreach ($sPaymentMethodsI18nsToDelete as $sPaymentMethodsI18nRemoved) {
            $sPaymentMethodsI18nRemoved->setSPaymentMethods(null);
        }

        $this->collSPaymentMethodsI18ns = null;
        foreach ($sPaymentMethodsI18ns as $sPaymentMethodsI18n) {
            $this->addSPaymentMethodsI18n($sPaymentMethodsI18n);
        }

        $this->collSPaymentMethodsI18ns = $sPaymentMethodsI18ns;
        $this->collSPaymentMethodsI18nsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related SPaymentMethodsI18n objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related SPaymentMethodsI18n objects.
     * @throws PropelException
     */
    public function countSPaymentMethodsI18ns(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collSPaymentMethodsI18nsPartial && !$this->isNew();
        if (null === $this->collSPaymentMethodsI18ns || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collSPaymentMethodsI18ns) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getSPaymentMethodsI18ns());
            }

            $query = ChildSPaymentMethodsI18nQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterBySPaymentMethods($this)
                ->count($con);
        }

        return count($this->collSPaymentMethodsI18ns);
    }

    /**
     * Method called to associate a ChildSPaymentMethodsI18n object to this object
     * through the ChildSPaymentMethodsI18n foreign key attribute.
     *
     * @param  ChildSPaymentMethodsI18n $l ChildSPaymentMethodsI18n
     * @return $this|\SPaymentMethods The current object (for fluent API support)
     */
    public function addSPaymentMethodsI18n(ChildSPaymentMethodsI18n $l)
    {
        if ($l && $locale = $l->getLocale()) {
            $this->setLocale($locale);
            $this->currentTranslations[$locale] = $l;
        }
        if ($this->collSPaymentMethodsI18ns === null) {
            $this->initSPaymentMethodsI18ns();
            $this->collSPaymentMethodsI18nsPartial = true;
        }

        if (!$this->collSPaymentMethodsI18ns->contains($l)) {
            $this->doAddSPaymentMethodsI18n($l);
        }

        return $this;
    }

    /**
     * @param ChildSPaymentMethodsI18n $sPaymentMethodsI18n The ChildSPaymentMethodsI18n object to add.
     */
    protected function doAddSPaymentMethodsI18n(ChildSPaymentMethodsI18n $sPaymentMethodsI18n)
    {
        $this->collSPaymentMethodsI18ns[]= $sPaymentMethodsI18n;
        $sPaymentMethodsI18n->setSPaymentMethods($this);
    }

    /**
     * @param  ChildSPaymentMethodsI18n $sPaymentMethodsI18n The ChildSPaymentMethodsI18n object to remove.
     * @return $this|ChildSPaymentMethods The current object (for fluent API support)
     */
    public function removeSPaymentMethodsI18n(ChildSPaymentMethodsI18n $sPaymentMethodsI18n)
    {
        if ($this->getSPaymentMethodsI18ns()->contains($sPaymentMethodsI18n)) {
            $pos = $this->collSPaymentMethodsI18ns->search($sPaymentMethodsI18n);
            $this->collSPaymentMethodsI18ns->remove($pos);
            if (null === $this->sPaymentMethodsI18nsScheduledForDeletion) {
                $this->sPaymentMethodsI18nsScheduledForDeletion = clone $this->collSPaymentMethodsI18ns;
                $this->sPaymentMethodsI18nsScheduledForDeletion->clear();
            }
            $this->sPaymentMethodsI18nsScheduledForDeletion[]= clone $sPaymentMethodsI18n;
            $sPaymentMethodsI18n->setSPaymentMethods(null);
        }

        return $this;
    }

    /**
     * Clears out the collSDeliveryMethodss collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addSDeliveryMethodss()
     */
    public function clearSDeliveryMethodss()
    {
        $this->collSDeliveryMethodss = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Initializes the collSDeliveryMethodss crossRef collection.
     *
     * By default this just sets the collSDeliveryMethodss collection to an empty collection (like clearSDeliveryMethodss());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initSDeliveryMethodss()
    {
        $this->collSDeliveryMethodss = new ObjectCollection();
        $this->collSDeliveryMethodssPartial = true;

        $this->collSDeliveryMethodss->setModel('\SDeliveryMethods');
    }

    /**
     * Checks if the collSDeliveryMethodss collection is loaded.
     *
     * @return bool
     */
    public function isSDeliveryMethodssLoaded()
    {
        return null !== $this->collSDeliveryMethodss;
    }

    /**
     * Gets a collection of ChildSDeliveryMethods objects related by a many-to-many relationship
     * to the current object by way of the shop_delivery_methods_systems cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildSPaymentMethods is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return ObjectCollection|ChildSDeliveryMethods[] List of ChildSDeliveryMethods objects
     */
    public function getSDeliveryMethodss(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collSDeliveryMethodssPartial && !$this->isNew();
        if (null === $this->collSDeliveryMethodss || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collSDeliveryMethodss) {
                    $this->initSDeliveryMethodss();
                }
            } else {

                $query = ChildSDeliveryMethodsQuery::create(null, $criteria)
                    ->filterByPaymentMethods($this);
                $collSDeliveryMethodss = $query->find($con);
                if (null !== $criteria) {
                    return $collSDeliveryMethodss;
                }

                if ($partial && $this->collSDeliveryMethodss) {
                    //make sure that already added objects gets added to the list of the database.
                    foreach ($this->collSDeliveryMethodss as $obj) {
                        if (!$collSDeliveryMethodss->contains($obj)) {
                            $collSDeliveryMethodss[] = $obj;
                        }
                    }
                }

                $this->collSDeliveryMethodss = $collSDeliveryMethodss;
                $this->collSDeliveryMethodssPartial = false;
            }
        }

        return $this->collSDeliveryMethodss;
    }

    /**
     * Sets a collection of SDeliveryMethods objects related by a many-to-many relationship
     * to the current object by way of the shop_delivery_methods_systems cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param  Collection $sDeliveryMethodss A Propel collection.
     * @param  ConnectionInterface $con Optional connection object
     * @return $this|ChildSPaymentMethods The current object (for fluent API support)
     */
    public function setSDeliveryMethodss(Collection $sDeliveryMethodss, ConnectionInterface $con = null)
    {
        $this->clearSDeliveryMethodss();
        $currentSDeliveryMethodss = $this->getSDeliveryMethodss();

        $sDeliveryMethodssScheduledForDeletion = $currentSDeliveryMethodss->diff($sDeliveryMethodss);

        foreach ($sDeliveryMethodssScheduledForDeletion as $toDelete) {
            $this->removeSDeliveryMethods($toDelete);
        }

        foreach ($sDeliveryMethodss as $sDeliveryMethods) {
            if (!$currentSDeliveryMethodss->contains($sDeliveryMethods)) {
                $this->doAddSDeliveryMethods($sDeliveryMethods);
            }
        }

        $this->collSDeliveryMethodssPartial = false;
        $this->collSDeliveryMethodss = $sDeliveryMethodss;

        return $this;
    }

    /**
     * Gets the number of SDeliveryMethods objects related by a many-to-many relationship
     * to the current object by way of the shop_delivery_methods_systems cross-reference table.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      boolean $distinct Set to true to force count distinct
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return int the number of related SDeliveryMethods objects
     */
    public function countSDeliveryMethodss(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collSDeliveryMethodssPartial && !$this->isNew();
        if (null === $this->collSDeliveryMethodss || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collSDeliveryMethodss) {
                return 0;
            } else {

                if ($partial && !$criteria) {
                    return count($this->getSDeliveryMethodss());
                }

                $query = ChildSDeliveryMethodsQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByPaymentMethods($this)
                    ->count($con);
            }
        } else {
            return count($this->collSDeliveryMethodss);
        }
    }

    /**
     * Associate a ChildSDeliveryMethods to this object
     * through the shop_delivery_methods_systems cross reference table.
     *
     * @param ChildSDeliveryMethods $sDeliveryMethods
     * @return ChildSPaymentMethods The current object (for fluent API support)
     */
    public function addSDeliveryMethods(ChildSDeliveryMethods $sDeliveryMethods)
    {
        if ($this->collSDeliveryMethodss === null) {
            $this->initSDeliveryMethodss();
        }

        if (!$this->getSDeliveryMethodss()->contains($sDeliveryMethods)) {
            // only add it if the **same** object is not already associated
            $this->collSDeliveryMethodss->push($sDeliveryMethods);
            $this->doAddSDeliveryMethods($sDeliveryMethods);
        }

        return $this;
    }

    /**
     *
     * @param ChildSDeliveryMethods $sDeliveryMethods
     */
    protected function doAddSDeliveryMethods(ChildSDeliveryMethods $sDeliveryMethods)
    {
        $shopDeliveryMethodsSystems = new ChildShopDeliveryMethodsSystems();

        $shopDeliveryMethodsSystems->setSDeliveryMethods($sDeliveryMethods);

        $shopDeliveryMethodsSystems->setPaymentMethods($this);

        $this->addShopDeliveryMethodsSystems($shopDeliveryMethodsSystems);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if (!$sDeliveryMethods->isPaymentMethodssLoaded()) {
            $sDeliveryMethods->initPaymentMethodss();
            $sDeliveryMethods->getPaymentMethodss()->push($this);
        } elseif (!$sDeliveryMethods->getPaymentMethodss()->contains($this)) {
            $sDeliveryMethods->getPaymentMethodss()->push($this);
        }

    }

    /**
     * Remove sDeliveryMethods of this object
     * through the shop_delivery_methods_systems cross reference table.
     *
     * @param ChildSDeliveryMethods $sDeliveryMethods
     * @return ChildSPaymentMethods The current object (for fluent API support)
     */
    public function removeSDeliveryMethods(ChildSDeliveryMethods $sDeliveryMethods)
    {
        if ($this->getSDeliveryMethodss()->contains($sDeliveryMethods)) { $shopDeliveryMethodsSystems = new ChildShopDeliveryMethodsSystems();

            $shopDeliveryMethodsSystems->setSDeliveryMethods($sDeliveryMethods);
            if ($sDeliveryMethods->isPaymentMethodssLoaded()) {
                //remove the back reference if available
                $sDeliveryMethods->getPaymentMethodss()->removeObject($this);
            }

            $shopDeliveryMethodsSystems->setPaymentMethods($this);
            $this->removeShopDeliveryMethodsSystems(clone $shopDeliveryMethodsSystems);
            $shopDeliveryMethodsSystems->clear();

            $this->collSDeliveryMethodss->remove($this->collSDeliveryMethodss->search($sDeliveryMethods));

            if (null === $this->sDeliveryMethodssScheduledForDeletion) {
                $this->sDeliveryMethodssScheduledForDeletion = clone $this->collSDeliveryMethodss;
                $this->sDeliveryMethodssScheduledForDeletion->clear();
            }

            $this->sDeliveryMethodssScheduledForDeletion->push($sDeliveryMethods);
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
        if (null !== $this->aCurrency) {
            $this->aCurrency->removeSPaymentMethods($this);
        }
        $this->id = null;
        $this->active = null;
        $this->currency_id = null;
        $this->payment_system_name = null;
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
            if ($this->collShopDeliveryMethodsSystemss) {
                foreach ($this->collShopDeliveryMethodsSystemss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collSOrderss) {
                foreach ($this->collSOrderss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collSPaymentMethodsI18ns) {
                foreach ($this->collSPaymentMethodsI18ns as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collSDeliveryMethodss) {
                foreach ($this->collSDeliveryMethodss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        // i18n behavior
        $this->currentLocale = 'ru';
        $this->currentTranslations = null;

        $this->collShopDeliveryMethodsSystemss = null;
        $this->collSOrderss = null;
        $this->collSPaymentMethodsI18ns = null;
        $this->collSDeliveryMethodss = null;
        $this->aCurrency = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(SPaymentMethodsTableMap::DEFAULT_STRING_FORMAT);
    }

    // i18n behavior

    /**
     * Sets the locale for translations
     *
     * @param     string $locale Locale to use for the translation, e.g. 'fr_FR'
     *
     * @return    $this|ChildSPaymentMethods The current object (for fluent API support)
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
     * @return ChildSPaymentMethodsI18n */
    public function getTranslation($locale = 'ru', ConnectionInterface $con = null)
    {
        if (!isset($this->currentTranslations[$locale])) {
            if (null !== $this->collSPaymentMethodsI18ns) {
                foreach ($this->collSPaymentMethodsI18ns as $translation) {
                    if ($translation->getLocale() == $locale) {
                        $this->currentTranslations[$locale] = $translation;

                        return $translation;
                    }
                }
            }
            if ($this->isNew()) {
                $translation = new ChildSPaymentMethodsI18n();
                $translation->setLocale($locale);
            } else {
                $translation = ChildSPaymentMethodsI18nQuery::create()
                    ->filterByPrimaryKey(array($this->getPrimaryKey(), $locale))
                    ->findOneOrCreate($con);
                $this->currentTranslations[$locale] = $translation;
            }
            $this->addSPaymentMethodsI18n($translation);
        }

        return $this->currentTranslations[$locale];
    }

    /**
     * Remove the translation for a given locale
     *
     * @param     string $locale Locale to use for the translation, e.g. 'fr_FR'
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return    $this|ChildSPaymentMethods The current object (for fluent API support)
     */
    public function removeTranslation($locale = 'ru', ConnectionInterface $con = null)
    {
        if (!$this->isNew()) {
            ChildSPaymentMethodsI18nQuery::create()
                ->filterByPrimaryKey(array($this->getPrimaryKey(), $locale))
                ->delete($con);
        }
        if (isset($this->currentTranslations[$locale])) {
            unset($this->currentTranslations[$locale]);
        }
        foreach ($this->collSPaymentMethodsI18ns as $key => $translation) {
            if ($translation->getLocale() == $locale) {
                unset($this->collSPaymentMethodsI18ns[$key]);
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
     * @return ChildSPaymentMethodsI18n */
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
         * @return $this|\SPaymentMethodsI18n The current object (for fluent API support)
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
         * @return $this|\SPaymentMethodsI18n The current object (for fluent API support)
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
