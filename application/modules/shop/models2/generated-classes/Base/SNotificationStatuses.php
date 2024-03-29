<?php

namespace Base;

use \SNotificationStatuses as ChildSNotificationStatuses;
use \SNotificationStatusesI18n as ChildSNotificationStatusesI18n;
use \SNotificationStatusesI18nQuery as ChildSNotificationStatusesI18nQuery;
use \SNotificationStatusesQuery as ChildSNotificationStatusesQuery;
use \SNotifications as ChildSNotifications;
use \SNotificationsQuery as ChildSNotificationsQuery;
use \Exception;
use \PDO;
use Map\SNotificationStatusesTableMap;
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
 * Base class that represents a row from the 'shop_notification_statuses' table.
 *
 *
 *
* @package    propel.generator..Base
*/
abstract class SNotificationStatuses extends PropelBaseModelClass implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\SNotificationStatusesTableMap';


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
     * The value for the position field.
     * @var        int
     */
    protected $position;

    /**
     * @var        ObjectCollection|ChildSNotifications[] Collection to store aggregation of ChildSNotifications objects.
     */
    protected $collSNotificationss;
    protected $collSNotificationssPartial;

    /**
     * @var        ObjectCollection|ChildSNotificationStatusesI18n[] Collection to store aggregation of ChildSNotificationStatusesI18n objects.
     */
    protected $collSNotificationStatusesI18ns;
    protected $collSNotificationStatusesI18nsPartial;

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
     * @var        array[ChildSNotificationStatusesI18n]
     */
    protected $currentTranslations;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildSNotifications[]
     */
    protected $sNotificationssScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildSNotificationStatusesI18n[]
     */
    protected $sNotificationStatusesI18nsScheduledForDeletion = null;

    /**
     * Initializes internal state of Base\SNotificationStatuses object.
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
     * Compares this with another <code>SNotificationStatuses</code> instance.  If
     * <code>obj</code> is an instance of <code>SNotificationStatuses</code>, delegates to
     * <code>equals(SNotificationStatuses)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|SNotificationStatuses The current object, for fluid interface
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
     * @return $this|\SNotificationStatuses The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[SNotificationStatusesTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [position] column.
     *
     * @param int $v new value
     * @return $this|\SNotificationStatuses The current object (for fluent API support)
     */
    public function setPosition($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->position !== $v) {
            $this->position = $v;
            $this->modifiedColumns[SNotificationStatusesTableMap::COL_POSITION] = true;
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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : SNotificationStatusesTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : SNotificationStatusesTableMap::translateFieldName('Position', TableMap::TYPE_PHPNAME, $indexType)];
            $this->position = (null !== $col) ? (int) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 2; // 2 = SNotificationStatusesTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\SNotificationStatuses'), 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(SNotificationStatusesTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildSNotificationStatusesQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collSNotificationss = null;

            $this->collSNotificationStatusesI18ns = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see SNotificationStatuses::setDeleted()
     * @see SNotificationStatuses::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(SNotificationStatusesTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildSNotificationStatusesQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(SNotificationStatusesTableMap::DATABASE_NAME);
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
                SNotificationStatusesTableMap::addInstanceToPool($this);
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

            if ($this->sNotificationStatusesI18nsScheduledForDeletion !== null) {
                if (!$this->sNotificationStatusesI18nsScheduledForDeletion->isEmpty()) {
                    \SNotificationStatusesI18nQuery::create()
                        ->filterByPrimaryKeys($this->sNotificationStatusesI18nsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->sNotificationStatusesI18nsScheduledForDeletion = null;
                }
            }

            if ($this->collSNotificationStatusesI18ns !== null) {
                foreach ($this->collSNotificationStatusesI18ns as $referrerFK) {
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

        $this->modifiedColumns[SNotificationStatusesTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . SNotificationStatusesTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(SNotificationStatusesTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(SNotificationStatusesTableMap::COL_POSITION)) {
            $modifiedColumns[':p' . $index++]  = 'position';
        }

        $sql = sprintf(
            'INSERT INTO shop_notification_statuses (%s) VALUES (%s)',
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
        $pos = SNotificationStatusesTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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

        if (isset($alreadyDumpedObjects['SNotificationStatuses'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['SNotificationStatuses'][$this->hashCode()] = true;
        $keys = SNotificationStatusesTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getPosition(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
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
            if (null !== $this->collSNotificationStatusesI18ns) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'sNotificationStatusesI18ns';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'shop_notification_statuses_i18ns';
                        break;
                    default:
                        $key = 'SNotificationStatusesI18ns';
                }

                $result[$key] = $this->collSNotificationStatusesI18ns->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\SNotificationStatuses
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = SNotificationStatusesTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\SNotificationStatuses
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
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
        $keys = SNotificationStatusesTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setPosition($arr[$keys[1]]);
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
     * @return $this|\SNotificationStatuses The current object, for fluid interface
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
        $criteria = new Criteria(SNotificationStatusesTableMap::DATABASE_NAME);

        if ($this->isColumnModified(SNotificationStatusesTableMap::COL_ID)) {
            $criteria->add(SNotificationStatusesTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(SNotificationStatusesTableMap::COL_POSITION)) {
            $criteria->add(SNotificationStatusesTableMap::COL_POSITION, $this->position);
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
        $criteria = ChildSNotificationStatusesQuery::create();
        $criteria->add(SNotificationStatusesTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \SNotificationStatuses (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setPosition($this->getPosition());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getSNotificationss() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addSNotifications($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getSNotificationStatusesI18ns() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addSNotificationStatusesI18n($relObj->copy($deepCopy));
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
     * @return \SNotificationStatuses Clone of current object.
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
        if ('SNotifications' == $relationName) {
            return $this->initSNotificationss();
        }
        if ('SNotificationStatusesI18n' == $relationName) {
            return $this->initSNotificationStatusesI18ns();
        }
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
     * If this ChildSNotificationStatuses is new, it will return
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
                    ->filterBySNotificationStatuses($this)
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
     * @return $this|ChildSNotificationStatuses The current object (for fluent API support)
     */
    public function setSNotificationss(Collection $sNotificationss, ConnectionInterface $con = null)
    {
        /** @var ChildSNotifications[] $sNotificationssToDelete */
        $sNotificationssToDelete = $this->getSNotificationss(new Criteria(), $con)->diff($sNotificationss);


        $this->sNotificationssScheduledForDeletion = $sNotificationssToDelete;

        foreach ($sNotificationssToDelete as $sNotificationsRemoved) {
            $sNotificationsRemoved->setSNotificationStatuses(null);
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
                ->filterBySNotificationStatuses($this)
                ->count($con);
        }

        return count($this->collSNotificationss);
    }

    /**
     * Method called to associate a ChildSNotifications object to this object
     * through the ChildSNotifications foreign key attribute.
     *
     * @param  ChildSNotifications $l ChildSNotifications
     * @return $this|\SNotificationStatuses The current object (for fluent API support)
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
        $sNotifications->setSNotificationStatuses($this);
    }

    /**
     * @param  ChildSNotifications $sNotifications The ChildSNotifications object to remove.
     * @return $this|ChildSNotificationStatuses The current object (for fluent API support)
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
            $sNotifications->setSNotificationStatuses(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this SNotificationStatuses is new, it will return
     * an empty collection; or if this SNotificationStatuses has previously
     * been saved, it will retrieve related SNotificationss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in SNotificationStatuses.
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
     * Otherwise if this SNotificationStatuses is new, it will return
     * an empty collection; or if this SNotificationStatuses has previously
     * been saved, it will retrieve related SNotificationss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in SNotificationStatuses.
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
     * Clears out the collSNotificationStatusesI18ns collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addSNotificationStatusesI18ns()
     */
    public function clearSNotificationStatusesI18ns()
    {
        $this->collSNotificationStatusesI18ns = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collSNotificationStatusesI18ns collection loaded partially.
     */
    public function resetPartialSNotificationStatusesI18ns($v = true)
    {
        $this->collSNotificationStatusesI18nsPartial = $v;
    }

    /**
     * Initializes the collSNotificationStatusesI18ns collection.
     *
     * By default this just sets the collSNotificationStatusesI18ns collection to an empty array (like clearcollSNotificationStatusesI18ns());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initSNotificationStatusesI18ns($overrideExisting = true)
    {
        if (null !== $this->collSNotificationStatusesI18ns && !$overrideExisting) {
            return;
        }
        $this->collSNotificationStatusesI18ns = new ObjectCollection();
        $this->collSNotificationStatusesI18ns->setModel('\SNotificationStatusesI18n');
    }

    /**
     * Gets an array of ChildSNotificationStatusesI18n objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildSNotificationStatuses is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildSNotificationStatusesI18n[] List of ChildSNotificationStatusesI18n objects
     * @throws PropelException
     */
    public function getSNotificationStatusesI18ns(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collSNotificationStatusesI18nsPartial && !$this->isNew();
        if (null === $this->collSNotificationStatusesI18ns || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collSNotificationStatusesI18ns) {
                // return empty collection
                $this->initSNotificationStatusesI18ns();
            } else {
                $collSNotificationStatusesI18ns = ChildSNotificationStatusesI18nQuery::create(null, $criteria)
                    ->filterBySNotificationStatuses($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collSNotificationStatusesI18nsPartial && count($collSNotificationStatusesI18ns)) {
                        $this->initSNotificationStatusesI18ns(false);

                        foreach ($collSNotificationStatusesI18ns as $obj) {
                            if (false == $this->collSNotificationStatusesI18ns->contains($obj)) {
                                $this->collSNotificationStatusesI18ns->append($obj);
                            }
                        }

                        $this->collSNotificationStatusesI18nsPartial = true;
                    }

                    return $collSNotificationStatusesI18ns;
                }

                if ($partial && $this->collSNotificationStatusesI18ns) {
                    foreach ($this->collSNotificationStatusesI18ns as $obj) {
                        if ($obj->isNew()) {
                            $collSNotificationStatusesI18ns[] = $obj;
                        }
                    }
                }

                $this->collSNotificationStatusesI18ns = $collSNotificationStatusesI18ns;
                $this->collSNotificationStatusesI18nsPartial = false;
            }
        }

        return $this->collSNotificationStatusesI18ns;
    }

    /**
     * Sets a collection of ChildSNotificationStatusesI18n objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $sNotificationStatusesI18ns A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildSNotificationStatuses The current object (for fluent API support)
     */
    public function setSNotificationStatusesI18ns(Collection $sNotificationStatusesI18ns, ConnectionInterface $con = null)
    {
        /** @var ChildSNotificationStatusesI18n[] $sNotificationStatusesI18nsToDelete */
        $sNotificationStatusesI18nsToDelete = $this->getSNotificationStatusesI18ns(new Criteria(), $con)->diff($sNotificationStatusesI18ns);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->sNotificationStatusesI18nsScheduledForDeletion = clone $sNotificationStatusesI18nsToDelete;

        foreach ($sNotificationStatusesI18nsToDelete as $sNotificationStatusesI18nRemoved) {
            $sNotificationStatusesI18nRemoved->setSNotificationStatuses(null);
        }

        $this->collSNotificationStatusesI18ns = null;
        foreach ($sNotificationStatusesI18ns as $sNotificationStatusesI18n) {
            $this->addSNotificationStatusesI18n($sNotificationStatusesI18n);
        }

        $this->collSNotificationStatusesI18ns = $sNotificationStatusesI18ns;
        $this->collSNotificationStatusesI18nsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related SNotificationStatusesI18n objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related SNotificationStatusesI18n objects.
     * @throws PropelException
     */
    public function countSNotificationStatusesI18ns(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collSNotificationStatusesI18nsPartial && !$this->isNew();
        if (null === $this->collSNotificationStatusesI18ns || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collSNotificationStatusesI18ns) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getSNotificationStatusesI18ns());
            }

            $query = ChildSNotificationStatusesI18nQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterBySNotificationStatuses($this)
                ->count($con);
        }

        return count($this->collSNotificationStatusesI18ns);
    }

    /**
     * Method called to associate a ChildSNotificationStatusesI18n object to this object
     * through the ChildSNotificationStatusesI18n foreign key attribute.
     *
     * @param  ChildSNotificationStatusesI18n $l ChildSNotificationStatusesI18n
     * @return $this|\SNotificationStatuses The current object (for fluent API support)
     */
    public function addSNotificationStatusesI18n(ChildSNotificationStatusesI18n $l)
    {
        if ($l && $locale = $l->getLocale()) {
            $this->setLocale($locale);
            $this->currentTranslations[$locale] = $l;
        }
        if ($this->collSNotificationStatusesI18ns === null) {
            $this->initSNotificationStatusesI18ns();
            $this->collSNotificationStatusesI18nsPartial = true;
        }

        if (!$this->collSNotificationStatusesI18ns->contains($l)) {
            $this->doAddSNotificationStatusesI18n($l);
        }

        return $this;
    }

    /**
     * @param ChildSNotificationStatusesI18n $sNotificationStatusesI18n The ChildSNotificationStatusesI18n object to add.
     */
    protected function doAddSNotificationStatusesI18n(ChildSNotificationStatusesI18n $sNotificationStatusesI18n)
    {
        $this->collSNotificationStatusesI18ns[]= $sNotificationStatusesI18n;
        $sNotificationStatusesI18n->setSNotificationStatuses($this);
    }

    /**
     * @param  ChildSNotificationStatusesI18n $sNotificationStatusesI18n The ChildSNotificationStatusesI18n object to remove.
     * @return $this|ChildSNotificationStatuses The current object (for fluent API support)
     */
    public function removeSNotificationStatusesI18n(ChildSNotificationStatusesI18n $sNotificationStatusesI18n)
    {
        if ($this->getSNotificationStatusesI18ns()->contains($sNotificationStatusesI18n)) {
            $pos = $this->collSNotificationStatusesI18ns->search($sNotificationStatusesI18n);
            $this->collSNotificationStatusesI18ns->remove($pos);
            if (null === $this->sNotificationStatusesI18nsScheduledForDeletion) {
                $this->sNotificationStatusesI18nsScheduledForDeletion = clone $this->collSNotificationStatusesI18ns;
                $this->sNotificationStatusesI18nsScheduledForDeletion->clear();
            }
            $this->sNotificationStatusesI18nsScheduledForDeletion[]= clone $sNotificationStatusesI18n;
            $sNotificationStatusesI18n->setSNotificationStatuses(null);
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
            if ($this->collSNotificationss) {
                foreach ($this->collSNotificationss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collSNotificationStatusesI18ns) {
                foreach ($this->collSNotificationStatusesI18ns as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        // i18n behavior
        $this->currentLocale = 'ru';
        $this->currentTranslations = null;

        $this->collSNotificationss = null;
        $this->collSNotificationStatusesI18ns = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(SNotificationStatusesTableMap::DEFAULT_STRING_FORMAT);
    }

    // i18n behavior

    /**
     * Sets the locale for translations
     *
     * @param     string $locale Locale to use for the translation, e.g. 'fr_FR'
     *
     * @return    $this|ChildSNotificationStatuses The current object (for fluent API support)
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
     * @return ChildSNotificationStatusesI18n */
    public function getTranslation($locale = 'ru', ConnectionInterface $con = null)
    {
        if (!isset($this->currentTranslations[$locale])) {
            if (null !== $this->collSNotificationStatusesI18ns) {
                foreach ($this->collSNotificationStatusesI18ns as $translation) {
                    if ($translation->getLocale() == $locale) {
                        $this->currentTranslations[$locale] = $translation;

                        return $translation;
                    }
                }
            }
            if ($this->isNew()) {
                $translation = new ChildSNotificationStatusesI18n();
                $translation->setLocale($locale);
            } else {
                $translation = ChildSNotificationStatusesI18nQuery::create()
                    ->filterByPrimaryKey(array($this->getPrimaryKey(), $locale))
                    ->findOneOrCreate($con);
                $this->currentTranslations[$locale] = $translation;
            }
            $this->addSNotificationStatusesI18n($translation);
        }

        return $this->currentTranslations[$locale];
    }

    /**
     * Remove the translation for a given locale
     *
     * @param     string $locale Locale to use for the translation, e.g. 'fr_FR'
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return    $this|ChildSNotificationStatuses The current object (for fluent API support)
     */
    public function removeTranslation($locale = 'ru', ConnectionInterface $con = null)
    {
        if (!$this->isNew()) {
            ChildSNotificationStatusesI18nQuery::create()
                ->filterByPrimaryKey(array($this->getPrimaryKey(), $locale))
                ->delete($con);
        }
        if (isset($this->currentTranslations[$locale])) {
            unset($this->currentTranslations[$locale]);
        }
        foreach ($this->collSNotificationStatusesI18ns as $key => $translation) {
            if ($translation->getLocale() == $locale) {
                unset($this->collSNotificationStatusesI18ns[$key]);
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
     * @return ChildSNotificationStatusesI18n */
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
         * @return $this|\SNotificationStatusesI18n The current object (for fluent API support)
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
