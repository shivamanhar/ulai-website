<?php

namespace Base;

use \SCallbackStatuses as ChildSCallbackStatuses;
use \SCallbackStatusesI18n as ChildSCallbackStatusesI18n;
use \SCallbackStatusesI18nQuery as ChildSCallbackStatusesI18nQuery;
use \SCallbackStatusesQuery as ChildSCallbackStatusesQuery;
use \SCallbacks as ChildSCallbacks;
use \SCallbacksQuery as ChildSCallbacksQuery;
use \Exception;
use \PDO;
use Map\SCallbackStatusesTableMap;
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
 * Base class that represents a row from the 'shop_callbacks_statuses' table.
 *
 *
 *
* @package    propel.generator..Base
*/
abstract class SCallbackStatuses extends PropelBaseModelClass implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\SCallbackStatusesTableMap';


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
     * The value for the is_default field.
     * @var        boolean
     */
    protected $is_default;

    /**
     * @var        ObjectCollection|ChildSCallbacks[] Collection to store aggregation of ChildSCallbacks objects.
     */
    protected $collSCallbackss;
    protected $collSCallbackssPartial;

    /**
     * @var        ObjectCollection|ChildSCallbackStatusesI18n[] Collection to store aggregation of ChildSCallbackStatusesI18n objects.
     */
    protected $collSCallbackStatusesI18ns;
    protected $collSCallbackStatusesI18nsPartial;

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
     * @var        array[ChildSCallbackStatusesI18n]
     */
    protected $currentTranslations;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildSCallbacks[]
     */
    protected $sCallbackssScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildSCallbackStatusesI18n[]
     */
    protected $sCallbackStatusesI18nsScheduledForDeletion = null;

    /**
     * Initializes internal state of Base\SCallbackStatuses object.
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
     * Compares this with another <code>SCallbackStatuses</code> instance.  If
     * <code>obj</code> is an instance of <code>SCallbackStatuses</code>, delegates to
     * <code>equals(SCallbackStatuses)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|SCallbackStatuses The current object, for fluid interface
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
     * Get the [is_default] column value.
     *
     * @return boolean
     */
    public function getIsDefault()
    {
        return $this->is_default;
    }

    /**
     * Get the [is_default] column value.
     *
     * @return boolean
     */
    public function isDefault()
    {
        return $this->getIsDefault();
    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return $this|\SCallbackStatuses The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[SCallbackStatusesTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Sets the value of the [is_default] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\SCallbackStatuses The current object (for fluent API support)
     */
    public function setIsDefault($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->is_default !== $v) {
            $this->is_default = $v;
            $this->modifiedColumns[SCallbackStatusesTableMap::COL_IS_DEFAULT] = true;
        }

        return $this;
    } // setIsDefault()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : SCallbackStatusesTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : SCallbackStatusesTableMap::translateFieldName('IsDefault', TableMap::TYPE_PHPNAME, $indexType)];
            $this->is_default = (null !== $col) ? (boolean) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 2; // 2 = SCallbackStatusesTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\SCallbackStatuses'), 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(SCallbackStatusesTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildSCallbackStatusesQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collSCallbackss = null;

            $this->collSCallbackStatusesI18ns = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see SCallbackStatuses::setDeleted()
     * @see SCallbackStatuses::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(SCallbackStatusesTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildSCallbackStatusesQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(SCallbackStatusesTableMap::DATABASE_NAME);
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
                SCallbackStatusesTableMap::addInstanceToPool($this);
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

            if ($this->sCallbackssScheduledForDeletion !== null) {
                if (!$this->sCallbackssScheduledForDeletion->isEmpty()) {
                    foreach ($this->sCallbackssScheduledForDeletion as $sCallbacks) {
                        // need to save related object because we set the relation to null
                        $sCallbacks->save($con);
                    }
                    $this->sCallbackssScheduledForDeletion = null;
                }
            }

            if ($this->collSCallbackss !== null) {
                foreach ($this->collSCallbackss as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->sCallbackStatusesI18nsScheduledForDeletion !== null) {
                if (!$this->sCallbackStatusesI18nsScheduledForDeletion->isEmpty()) {
                    \SCallbackStatusesI18nQuery::create()
                        ->filterByPrimaryKeys($this->sCallbackStatusesI18nsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->sCallbackStatusesI18nsScheduledForDeletion = null;
                }
            }

            if ($this->collSCallbackStatusesI18ns !== null) {
                foreach ($this->collSCallbackStatusesI18ns as $referrerFK) {
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

        $this->modifiedColumns[SCallbackStatusesTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . SCallbackStatusesTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(SCallbackStatusesTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(SCallbackStatusesTableMap::COL_IS_DEFAULT)) {
            $modifiedColumns[':p' . $index++]  = 'is_default';
        }

        $sql = sprintf(
            'INSERT INTO shop_callbacks_statuses (%s) VALUES (%s)',
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
                    case 'is_default':
                        $stmt->bindValue($identifier, (int) $this->is_default, PDO::PARAM_INT);
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
        $pos = SCallbackStatusesTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getIsDefault();
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

        if (isset($alreadyDumpedObjects['SCallbackStatuses'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['SCallbackStatuses'][$this->hashCode()] = true;
        $keys = SCallbackStatusesTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getIsDefault(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->collSCallbackss) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'sCallbackss';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'shop_callbackss';
                        break;
                    default:
                        $key = 'SCallbackss';
                }

                $result[$key] = $this->collSCallbackss->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collSCallbackStatusesI18ns) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'sCallbackStatusesI18ns';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'shop_callbacks_statuses_i18ns';
                        break;
                    default:
                        $key = 'SCallbackStatusesI18ns';
                }

                $result[$key] = $this->collSCallbackStatusesI18ns->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\SCallbackStatuses
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = SCallbackStatusesTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\SCallbackStatuses
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setIsDefault($value);
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
        $keys = SCallbackStatusesTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setIsDefault($arr[$keys[1]]);
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
     * @return $this|\SCallbackStatuses The current object, for fluid interface
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
        $criteria = new Criteria(SCallbackStatusesTableMap::DATABASE_NAME);

        if ($this->isColumnModified(SCallbackStatusesTableMap::COL_ID)) {
            $criteria->add(SCallbackStatusesTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(SCallbackStatusesTableMap::COL_IS_DEFAULT)) {
            $criteria->add(SCallbackStatusesTableMap::COL_IS_DEFAULT, $this->is_default);
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
        $criteria = ChildSCallbackStatusesQuery::create();
        $criteria->add(SCallbackStatusesTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \SCallbackStatuses (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setIsDefault($this->getIsDefault());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getSCallbackss() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addSCallbacks($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getSCallbackStatusesI18ns() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addSCallbackStatusesI18n($relObj->copy($deepCopy));
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
     * @return \SCallbackStatuses Clone of current object.
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
        if ('SCallbacks' == $relationName) {
            return $this->initSCallbackss();
        }
        if ('SCallbackStatusesI18n' == $relationName) {
            return $this->initSCallbackStatusesI18ns();
        }
    }

    /**
     * Clears out the collSCallbackss collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addSCallbackss()
     */
    public function clearSCallbackss()
    {
        $this->collSCallbackss = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collSCallbackss collection loaded partially.
     */
    public function resetPartialSCallbackss($v = true)
    {
        $this->collSCallbackssPartial = $v;
    }

    /**
     * Initializes the collSCallbackss collection.
     *
     * By default this just sets the collSCallbackss collection to an empty array (like clearcollSCallbackss());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initSCallbackss($overrideExisting = true)
    {
        if (null !== $this->collSCallbackss && !$overrideExisting) {
            return;
        }
        $this->collSCallbackss = new ObjectCollection();
        $this->collSCallbackss->setModel('\SCallbacks');
    }

    /**
     * Gets an array of ChildSCallbacks objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildSCallbackStatuses is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildSCallbacks[] List of ChildSCallbacks objects
     * @throws PropelException
     */
    public function getSCallbackss(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collSCallbackssPartial && !$this->isNew();
        if (null === $this->collSCallbackss || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collSCallbackss) {
                // return empty collection
                $this->initSCallbackss();
            } else {
                $collSCallbackss = ChildSCallbacksQuery::create(null, $criteria)
                    ->filterBySCallbackStatuses($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collSCallbackssPartial && count($collSCallbackss)) {
                        $this->initSCallbackss(false);

                        foreach ($collSCallbackss as $obj) {
                            if (false == $this->collSCallbackss->contains($obj)) {
                                $this->collSCallbackss->append($obj);
                            }
                        }

                        $this->collSCallbackssPartial = true;
                    }

                    return $collSCallbackss;
                }

                if ($partial && $this->collSCallbackss) {
                    foreach ($this->collSCallbackss as $obj) {
                        if ($obj->isNew()) {
                            $collSCallbackss[] = $obj;
                        }
                    }
                }

                $this->collSCallbackss = $collSCallbackss;
                $this->collSCallbackssPartial = false;
            }
        }

        return $this->collSCallbackss;
    }

    /**
     * Sets a collection of ChildSCallbacks objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $sCallbackss A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildSCallbackStatuses The current object (for fluent API support)
     */
    public function setSCallbackss(Collection $sCallbackss, ConnectionInterface $con = null)
    {
        /** @var ChildSCallbacks[] $sCallbackssToDelete */
        $sCallbackssToDelete = $this->getSCallbackss(new Criteria(), $con)->diff($sCallbackss);


        $this->sCallbackssScheduledForDeletion = $sCallbackssToDelete;

        foreach ($sCallbackssToDelete as $sCallbacksRemoved) {
            $sCallbacksRemoved->setSCallbackStatuses(null);
        }

        $this->collSCallbackss = null;
        foreach ($sCallbackss as $sCallbacks) {
            $this->addSCallbacks($sCallbacks);
        }

        $this->collSCallbackss = $sCallbackss;
        $this->collSCallbackssPartial = false;

        return $this;
    }

    /**
     * Returns the number of related SCallbacks objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related SCallbacks objects.
     * @throws PropelException
     */
    public function countSCallbackss(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collSCallbackssPartial && !$this->isNew();
        if (null === $this->collSCallbackss || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collSCallbackss) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getSCallbackss());
            }

            $query = ChildSCallbacksQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterBySCallbackStatuses($this)
                ->count($con);
        }

        return count($this->collSCallbackss);
    }

    /**
     * Method called to associate a ChildSCallbacks object to this object
     * through the ChildSCallbacks foreign key attribute.
     *
     * @param  ChildSCallbacks $l ChildSCallbacks
     * @return $this|\SCallbackStatuses The current object (for fluent API support)
     */
    public function addSCallbacks(ChildSCallbacks $l)
    {
        if ($this->collSCallbackss === null) {
            $this->initSCallbackss();
            $this->collSCallbackssPartial = true;
        }

        if (!$this->collSCallbackss->contains($l)) {
            $this->doAddSCallbacks($l);
        }

        return $this;
    }

    /**
     * @param ChildSCallbacks $sCallbacks The ChildSCallbacks object to add.
     */
    protected function doAddSCallbacks(ChildSCallbacks $sCallbacks)
    {
        $this->collSCallbackss[]= $sCallbacks;
        $sCallbacks->setSCallbackStatuses($this);
    }

    /**
     * @param  ChildSCallbacks $sCallbacks The ChildSCallbacks object to remove.
     * @return $this|ChildSCallbackStatuses The current object (for fluent API support)
     */
    public function removeSCallbacks(ChildSCallbacks $sCallbacks)
    {
        if ($this->getSCallbackss()->contains($sCallbacks)) {
            $pos = $this->collSCallbackss->search($sCallbacks);
            $this->collSCallbackss->remove($pos);
            if (null === $this->sCallbackssScheduledForDeletion) {
                $this->sCallbackssScheduledForDeletion = clone $this->collSCallbackss;
                $this->sCallbackssScheduledForDeletion->clear();
            }
            $this->sCallbackssScheduledForDeletion[]= $sCallbacks;
            $sCallbacks->setSCallbackStatuses(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this SCallbackStatuses is new, it will return
     * an empty collection; or if this SCallbackStatuses has previously
     * been saved, it will retrieve related SCallbackss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in SCallbackStatuses.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildSCallbacks[] List of ChildSCallbacks objects
     */
    public function getSCallbackssJoinSCallbackThemes(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildSCallbacksQuery::create(null, $criteria);
        $query->joinWith('SCallbackThemes', $joinBehavior);

        return $this->getSCallbackss($query, $con);
    }

    /**
     * Clears out the collSCallbackStatusesI18ns collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addSCallbackStatusesI18ns()
     */
    public function clearSCallbackStatusesI18ns()
    {
        $this->collSCallbackStatusesI18ns = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collSCallbackStatusesI18ns collection loaded partially.
     */
    public function resetPartialSCallbackStatusesI18ns($v = true)
    {
        $this->collSCallbackStatusesI18nsPartial = $v;
    }

    /**
     * Initializes the collSCallbackStatusesI18ns collection.
     *
     * By default this just sets the collSCallbackStatusesI18ns collection to an empty array (like clearcollSCallbackStatusesI18ns());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initSCallbackStatusesI18ns($overrideExisting = true)
    {
        if (null !== $this->collSCallbackStatusesI18ns && !$overrideExisting) {
            return;
        }
        $this->collSCallbackStatusesI18ns = new ObjectCollection();
        $this->collSCallbackStatusesI18ns->setModel('\SCallbackStatusesI18n');
    }

    /**
     * Gets an array of ChildSCallbackStatusesI18n objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildSCallbackStatuses is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildSCallbackStatusesI18n[] List of ChildSCallbackStatusesI18n objects
     * @throws PropelException
     */
    public function getSCallbackStatusesI18ns(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collSCallbackStatusesI18nsPartial && !$this->isNew();
        if (null === $this->collSCallbackStatusesI18ns || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collSCallbackStatusesI18ns) {
                // return empty collection
                $this->initSCallbackStatusesI18ns();
            } else {
                $collSCallbackStatusesI18ns = ChildSCallbackStatusesI18nQuery::create(null, $criteria)
                    ->filterBySCallbackStatuses($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collSCallbackStatusesI18nsPartial && count($collSCallbackStatusesI18ns)) {
                        $this->initSCallbackStatusesI18ns(false);

                        foreach ($collSCallbackStatusesI18ns as $obj) {
                            if (false == $this->collSCallbackStatusesI18ns->contains($obj)) {
                                $this->collSCallbackStatusesI18ns->append($obj);
                            }
                        }

                        $this->collSCallbackStatusesI18nsPartial = true;
                    }

                    return $collSCallbackStatusesI18ns;
                }

                if ($partial && $this->collSCallbackStatusesI18ns) {
                    foreach ($this->collSCallbackStatusesI18ns as $obj) {
                        if ($obj->isNew()) {
                            $collSCallbackStatusesI18ns[] = $obj;
                        }
                    }
                }

                $this->collSCallbackStatusesI18ns = $collSCallbackStatusesI18ns;
                $this->collSCallbackStatusesI18nsPartial = false;
            }
        }

        return $this->collSCallbackStatusesI18ns;
    }

    /**
     * Sets a collection of ChildSCallbackStatusesI18n objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $sCallbackStatusesI18ns A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildSCallbackStatuses The current object (for fluent API support)
     */
    public function setSCallbackStatusesI18ns(Collection $sCallbackStatusesI18ns, ConnectionInterface $con = null)
    {
        /** @var ChildSCallbackStatusesI18n[] $sCallbackStatusesI18nsToDelete */
        $sCallbackStatusesI18nsToDelete = $this->getSCallbackStatusesI18ns(new Criteria(), $con)->diff($sCallbackStatusesI18ns);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->sCallbackStatusesI18nsScheduledForDeletion = clone $sCallbackStatusesI18nsToDelete;

        foreach ($sCallbackStatusesI18nsToDelete as $sCallbackStatusesI18nRemoved) {
            $sCallbackStatusesI18nRemoved->setSCallbackStatuses(null);
        }

        $this->collSCallbackStatusesI18ns = null;
        foreach ($sCallbackStatusesI18ns as $sCallbackStatusesI18n) {
            $this->addSCallbackStatusesI18n($sCallbackStatusesI18n);
        }

        $this->collSCallbackStatusesI18ns = $sCallbackStatusesI18ns;
        $this->collSCallbackStatusesI18nsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related SCallbackStatusesI18n objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related SCallbackStatusesI18n objects.
     * @throws PropelException
     */
    public function countSCallbackStatusesI18ns(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collSCallbackStatusesI18nsPartial && !$this->isNew();
        if (null === $this->collSCallbackStatusesI18ns || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collSCallbackStatusesI18ns) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getSCallbackStatusesI18ns());
            }

            $query = ChildSCallbackStatusesI18nQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterBySCallbackStatuses($this)
                ->count($con);
        }

        return count($this->collSCallbackStatusesI18ns);
    }

    /**
     * Method called to associate a ChildSCallbackStatusesI18n object to this object
     * through the ChildSCallbackStatusesI18n foreign key attribute.
     *
     * @param  ChildSCallbackStatusesI18n $l ChildSCallbackStatusesI18n
     * @return $this|\SCallbackStatuses The current object (for fluent API support)
     */
    public function addSCallbackStatusesI18n(ChildSCallbackStatusesI18n $l)
    {
        if ($l && $locale = $l->getLocale()) {
            $this->setLocale($locale);
            $this->currentTranslations[$locale] = $l;
        }
        if ($this->collSCallbackStatusesI18ns === null) {
            $this->initSCallbackStatusesI18ns();
            $this->collSCallbackStatusesI18nsPartial = true;
        }

        if (!$this->collSCallbackStatusesI18ns->contains($l)) {
            $this->doAddSCallbackStatusesI18n($l);
        }

        return $this;
    }

    /**
     * @param ChildSCallbackStatusesI18n $sCallbackStatusesI18n The ChildSCallbackStatusesI18n object to add.
     */
    protected function doAddSCallbackStatusesI18n(ChildSCallbackStatusesI18n $sCallbackStatusesI18n)
    {
        $this->collSCallbackStatusesI18ns[]= $sCallbackStatusesI18n;
        $sCallbackStatusesI18n->setSCallbackStatuses($this);
    }

    /**
     * @param  ChildSCallbackStatusesI18n $sCallbackStatusesI18n The ChildSCallbackStatusesI18n object to remove.
     * @return $this|ChildSCallbackStatuses The current object (for fluent API support)
     */
    public function removeSCallbackStatusesI18n(ChildSCallbackStatusesI18n $sCallbackStatusesI18n)
    {
        if ($this->getSCallbackStatusesI18ns()->contains($sCallbackStatusesI18n)) {
            $pos = $this->collSCallbackStatusesI18ns->search($sCallbackStatusesI18n);
            $this->collSCallbackStatusesI18ns->remove($pos);
            if (null === $this->sCallbackStatusesI18nsScheduledForDeletion) {
                $this->sCallbackStatusesI18nsScheduledForDeletion = clone $this->collSCallbackStatusesI18ns;
                $this->sCallbackStatusesI18nsScheduledForDeletion->clear();
            }
            $this->sCallbackStatusesI18nsScheduledForDeletion[]= clone $sCallbackStatusesI18n;
            $sCallbackStatusesI18n->setSCallbackStatuses(null);
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
        $this->is_default = null;
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
            if ($this->collSCallbackss) {
                foreach ($this->collSCallbackss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collSCallbackStatusesI18ns) {
                foreach ($this->collSCallbackStatusesI18ns as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        // i18n behavior
        $this->currentLocale = 'ru';
        $this->currentTranslations = null;

        $this->collSCallbackss = null;
        $this->collSCallbackStatusesI18ns = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(SCallbackStatusesTableMap::DEFAULT_STRING_FORMAT);
    }

    // i18n behavior

    /**
     * Sets the locale for translations
     *
     * @param     string $locale Locale to use for the translation, e.g. 'fr_FR'
     *
     * @return    $this|ChildSCallbackStatuses The current object (for fluent API support)
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
     * @return ChildSCallbackStatusesI18n */
    public function getTranslation($locale = 'ru', ConnectionInterface $con = null)
    {
        if (!isset($this->currentTranslations[$locale])) {
            if (null !== $this->collSCallbackStatusesI18ns) {
                foreach ($this->collSCallbackStatusesI18ns as $translation) {
                    if ($translation->getLocale() == $locale) {
                        $this->currentTranslations[$locale] = $translation;

                        return $translation;
                    }
                }
            }
            if ($this->isNew()) {
                $translation = new ChildSCallbackStatusesI18n();
                $translation->setLocale($locale);
            } else {
                $translation = ChildSCallbackStatusesI18nQuery::create()
                    ->filterByPrimaryKey(array($this->getPrimaryKey(), $locale))
                    ->findOneOrCreate($con);
                $this->currentTranslations[$locale] = $translation;
            }
            $this->addSCallbackStatusesI18n($translation);
        }

        return $this->currentTranslations[$locale];
    }

    /**
     * Remove the translation for a given locale
     *
     * @param     string $locale Locale to use for the translation, e.g. 'fr_FR'
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return    $this|ChildSCallbackStatuses The current object (for fluent API support)
     */
    public function removeTranslation($locale = 'ru', ConnectionInterface $con = null)
    {
        if (!$this->isNew()) {
            ChildSCallbackStatusesI18nQuery::create()
                ->filterByPrimaryKey(array($this->getPrimaryKey(), $locale))
                ->delete($con);
        }
        if (isset($this->currentTranslations[$locale])) {
            unset($this->currentTranslations[$locale]);
        }
        foreach ($this->collSCallbackStatusesI18ns as $key => $translation) {
            if ($translation->getLocale() == $locale) {
                unset($this->collSCallbackStatusesI18ns[$key]);
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
     * @return ChildSCallbackStatusesI18n */
    public function getCurrentTranslation(ConnectionInterface $con = null)
    {
        return $this->getTranslation($this->getLocale(), $con);
    }


        /**
         * Get the [text] column value.
         *
         * @return string
         */
        public function getText()
        {
        return $this->getCurrentTranslation()->getText();
    }


        /**
         * Set the value of [text] column.
         *
         * @param string $v new value
         * @return $this|\SCallbackStatusesI18n The current object (for fluent API support)
         */
        public function setText($v)
        {    $this->getCurrentTranslation()->setText($v);

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
