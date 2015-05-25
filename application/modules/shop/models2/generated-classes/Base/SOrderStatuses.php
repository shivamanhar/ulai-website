<?php

namespace Base;

use \SOrderStatusHistory as ChildSOrderStatusHistory;
use \SOrderStatusHistoryQuery as ChildSOrderStatusHistoryQuery;
use \SOrderStatuses as ChildSOrderStatuses;
use \SOrderStatusesI18n as ChildSOrderStatusesI18n;
use \SOrderStatusesI18nQuery as ChildSOrderStatusesI18nQuery;
use \SOrderStatusesQuery as ChildSOrderStatusesQuery;
use \SOrders as ChildSOrders;
use \SOrdersQuery as ChildSOrdersQuery;
use \Exception;
use \PDO;
use Map\SOrderStatusesTableMap;
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
 * Base class that represents a row from the 'shop_order_statuses' table.
 *
 *
 *
* @package    propel.generator..Base
*/
abstract class SOrderStatuses extends PropelBaseModelClass implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\SOrderStatusesTableMap';


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
     * The value for the color field.
     * @var        string
     */
    protected $color;

    /**
     * The value for the fontcolor field.
     * @var        string
     */
    protected $fontcolor;

    /**
     * The value for the position field.
     * @var        int
     */
    protected $position;

    /**
     * @var        ObjectCollection|ChildSOrderStatusesI18n[] Collection to store aggregation of ChildSOrderStatusesI18n objects.
     */
    protected $collSOrderStatusesI18ns;
    protected $collSOrderStatusesI18nsPartial;

    /**
     * @var        ObjectCollection|ChildSOrders[] Collection to store aggregation of ChildSOrders objects.
     */
    protected $collSOrderss;
    protected $collSOrderssPartial;

    /**
     * @var        ObjectCollection|ChildSOrderStatusHistory[] Collection to store aggregation of ChildSOrderStatusHistory objects.
     */
    protected $collSOrderStatusHistories;
    protected $collSOrderStatusHistoriesPartial;

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
     * @var        array[ChildSOrderStatusesI18n]
     */
    protected $currentTranslations;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildSOrderStatusesI18n[]
     */
    protected $sOrderStatusesI18nsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildSOrders[]
     */
    protected $sOrderssScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildSOrderStatusHistory[]
     */
    protected $sOrderStatusHistoriesScheduledForDeletion = null;

    /**
     * Initializes internal state of Base\SOrderStatuses object.
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
     * Compares this with another <code>SOrderStatuses</code> instance.  If
     * <code>obj</code> is an instance of <code>SOrderStatuses</code>, delegates to
     * <code>equals(SOrderStatuses)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|SOrderStatuses The current object, for fluid interface
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
     * Get the [color] column value.
     *
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Get the [fontcolor] column value.
     *
     * @return string
     */
    public function getFontcolor()
    {
        return $this->fontcolor;
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
     * @return $this|\SOrderStatuses The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[SOrderStatusesTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [color] column.
     *
     * @param string $v new value
     * @return $this|\SOrderStatuses The current object (for fluent API support)
     */
    public function setColor($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->color !== $v) {
            $this->color = $v;
            $this->modifiedColumns[SOrderStatusesTableMap::COL_COLOR] = true;
        }

        return $this;
    } // setColor()

    /**
     * Set the value of [fontcolor] column.
     *
     * @param string $v new value
     * @return $this|\SOrderStatuses The current object (for fluent API support)
     */
    public function setFontcolor($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->fontcolor !== $v) {
            $this->fontcolor = $v;
            $this->modifiedColumns[SOrderStatusesTableMap::COL_FONTCOLOR] = true;
        }

        return $this;
    } // setFontcolor()

    /**
     * Set the value of [position] column.
     *
     * @param int $v new value
     * @return $this|\SOrderStatuses The current object (for fluent API support)
     */
    public function setPosition($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->position !== $v) {
            $this->position = $v;
            $this->modifiedColumns[SOrderStatusesTableMap::COL_POSITION] = true;
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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : SOrderStatusesTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : SOrderStatusesTableMap::translateFieldName('Color', TableMap::TYPE_PHPNAME, $indexType)];
            $this->color = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : SOrderStatusesTableMap::translateFieldName('Fontcolor', TableMap::TYPE_PHPNAME, $indexType)];
            $this->fontcolor = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : SOrderStatusesTableMap::translateFieldName('Position', TableMap::TYPE_PHPNAME, $indexType)];
            $this->position = (null !== $col) ? (int) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 4; // 4 = SOrderStatusesTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\SOrderStatuses'), 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(SOrderStatusesTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildSOrderStatusesQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collSOrderStatusesI18ns = null;

            $this->collSOrderss = null;

            $this->collSOrderStatusHistories = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see SOrderStatuses::setDeleted()
     * @see SOrderStatuses::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(SOrderStatusesTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildSOrderStatusesQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(SOrderStatusesTableMap::DATABASE_NAME);
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
                SOrderStatusesTableMap::addInstanceToPool($this);
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

            if ($this->sOrderStatusesI18nsScheduledForDeletion !== null) {
                if (!$this->sOrderStatusesI18nsScheduledForDeletion->isEmpty()) {
                    \SOrderStatusesI18nQuery::create()
                        ->filterByPrimaryKeys($this->sOrderStatusesI18nsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->sOrderStatusesI18nsScheduledForDeletion = null;
                }
            }

            if ($this->collSOrderStatusesI18ns !== null) {
                foreach ($this->collSOrderStatusesI18ns as $referrerFK) {
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

            if ($this->sOrderStatusHistoriesScheduledForDeletion !== null) {
                if (!$this->sOrderStatusHistoriesScheduledForDeletion->isEmpty()) {
                    foreach ($this->sOrderStatusHistoriesScheduledForDeletion as $sOrderStatusHistory) {
                        // need to save related object because we set the relation to null
                        $sOrderStatusHistory->save($con);
                    }
                    $this->sOrderStatusHistoriesScheduledForDeletion = null;
                }
            }

            if ($this->collSOrderStatusHistories !== null) {
                foreach ($this->collSOrderStatusHistories as $referrerFK) {
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

        $this->modifiedColumns[SOrderStatusesTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . SOrderStatusesTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(SOrderStatusesTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(SOrderStatusesTableMap::COL_COLOR)) {
            $modifiedColumns[':p' . $index++]  = 'color';
        }
        if ($this->isColumnModified(SOrderStatusesTableMap::COL_FONTCOLOR)) {
            $modifiedColumns[':p' . $index++]  = 'fontcolor';
        }
        if ($this->isColumnModified(SOrderStatusesTableMap::COL_POSITION)) {
            $modifiedColumns[':p' . $index++]  = 'position';
        }

        $sql = sprintf(
            'INSERT INTO shop_order_statuses (%s) VALUES (%s)',
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
                    case 'color':
                        $stmt->bindValue($identifier, $this->color, PDO::PARAM_STR);
                        break;
                    case 'fontcolor':
                        $stmt->bindValue($identifier, $this->fontcolor, PDO::PARAM_STR);
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
        $pos = SOrderStatusesTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getColor();
                break;
            case 2:
                return $this->getFontcolor();
                break;
            case 3:
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

        if (isset($alreadyDumpedObjects['SOrderStatuses'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['SOrderStatuses'][$this->hashCode()] = true;
        $keys = SOrderStatusesTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getColor(),
            $keys[2] => $this->getFontcolor(),
            $keys[3] => $this->getPosition(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->collSOrderStatusesI18ns) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'sOrderStatusesI18ns';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'shop_order_statuses_i18ns';
                        break;
                    default:
                        $key = 'SOrderStatusesI18ns';
                }

                $result[$key] = $this->collSOrderStatusesI18ns->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
            if (null !== $this->collSOrderStatusHistories) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'sOrderStatusHistories';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'shop_orders_status_histories';
                        break;
                    default:
                        $key = 'SOrderStatusHistories';
                }

                $result[$key] = $this->collSOrderStatusHistories->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\SOrderStatuses
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = SOrderStatusesTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\SOrderStatuses
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setColor($value);
                break;
            case 2:
                $this->setFontcolor($value);
                break;
            case 3:
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
        $keys = SOrderStatusesTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setColor($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setFontcolor($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setPosition($arr[$keys[3]]);
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
     * @return $this|\SOrderStatuses The current object, for fluid interface
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
        $criteria = new Criteria(SOrderStatusesTableMap::DATABASE_NAME);

        if ($this->isColumnModified(SOrderStatusesTableMap::COL_ID)) {
            $criteria->add(SOrderStatusesTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(SOrderStatusesTableMap::COL_COLOR)) {
            $criteria->add(SOrderStatusesTableMap::COL_COLOR, $this->color);
        }
        if ($this->isColumnModified(SOrderStatusesTableMap::COL_FONTCOLOR)) {
            $criteria->add(SOrderStatusesTableMap::COL_FONTCOLOR, $this->fontcolor);
        }
        if ($this->isColumnModified(SOrderStatusesTableMap::COL_POSITION)) {
            $criteria->add(SOrderStatusesTableMap::COL_POSITION, $this->position);
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
        $criteria = ChildSOrderStatusesQuery::create();
        $criteria->add(SOrderStatusesTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \SOrderStatuses (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setColor($this->getColor());
        $copyObj->setFontcolor($this->getFontcolor());
        $copyObj->setPosition($this->getPosition());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getSOrderStatusesI18ns() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addSOrderStatusesI18n($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getSOrderss() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addSOrders($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getSOrderStatusHistories() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addSOrderStatusHistory($relObj->copy($deepCopy));
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
     * @return \SOrderStatuses Clone of current object.
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
        if ('SOrderStatusesI18n' == $relationName) {
            return $this->initSOrderStatusesI18ns();
        }
        if ('SOrders' == $relationName) {
            return $this->initSOrderss();
        }
        if ('SOrderStatusHistory' == $relationName) {
            return $this->initSOrderStatusHistories();
        }
    }

    /**
     * Clears out the collSOrderStatusesI18ns collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addSOrderStatusesI18ns()
     */
    public function clearSOrderStatusesI18ns()
    {
        $this->collSOrderStatusesI18ns = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collSOrderStatusesI18ns collection loaded partially.
     */
    public function resetPartialSOrderStatusesI18ns($v = true)
    {
        $this->collSOrderStatusesI18nsPartial = $v;
    }

    /**
     * Initializes the collSOrderStatusesI18ns collection.
     *
     * By default this just sets the collSOrderStatusesI18ns collection to an empty array (like clearcollSOrderStatusesI18ns());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initSOrderStatusesI18ns($overrideExisting = true)
    {
        if (null !== $this->collSOrderStatusesI18ns && !$overrideExisting) {
            return;
        }
        $this->collSOrderStatusesI18ns = new ObjectCollection();
        $this->collSOrderStatusesI18ns->setModel('\SOrderStatusesI18n');
    }

    /**
     * Gets an array of ChildSOrderStatusesI18n objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildSOrderStatuses is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildSOrderStatusesI18n[] List of ChildSOrderStatusesI18n objects
     * @throws PropelException
     */
    public function getSOrderStatusesI18ns(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collSOrderStatusesI18nsPartial && !$this->isNew();
        if (null === $this->collSOrderStatusesI18ns || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collSOrderStatusesI18ns) {
                // return empty collection
                $this->initSOrderStatusesI18ns();
            } else {
                $collSOrderStatusesI18ns = ChildSOrderStatusesI18nQuery::create(null, $criteria)
                    ->filterBySOrderStatuses($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collSOrderStatusesI18nsPartial && count($collSOrderStatusesI18ns)) {
                        $this->initSOrderStatusesI18ns(false);

                        foreach ($collSOrderStatusesI18ns as $obj) {
                            if (false == $this->collSOrderStatusesI18ns->contains($obj)) {
                                $this->collSOrderStatusesI18ns->append($obj);
                            }
                        }

                        $this->collSOrderStatusesI18nsPartial = true;
                    }

                    return $collSOrderStatusesI18ns;
                }

                if ($partial && $this->collSOrderStatusesI18ns) {
                    foreach ($this->collSOrderStatusesI18ns as $obj) {
                        if ($obj->isNew()) {
                            $collSOrderStatusesI18ns[] = $obj;
                        }
                    }
                }

                $this->collSOrderStatusesI18ns = $collSOrderStatusesI18ns;
                $this->collSOrderStatusesI18nsPartial = false;
            }
        }

        return $this->collSOrderStatusesI18ns;
    }

    /**
     * Sets a collection of ChildSOrderStatusesI18n objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $sOrderStatusesI18ns A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildSOrderStatuses The current object (for fluent API support)
     */
    public function setSOrderStatusesI18ns(Collection $sOrderStatusesI18ns, ConnectionInterface $con = null)
    {
        /** @var ChildSOrderStatusesI18n[] $sOrderStatusesI18nsToDelete */
        $sOrderStatusesI18nsToDelete = $this->getSOrderStatusesI18ns(new Criteria(), $con)->diff($sOrderStatusesI18ns);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->sOrderStatusesI18nsScheduledForDeletion = clone $sOrderStatusesI18nsToDelete;

        foreach ($sOrderStatusesI18nsToDelete as $sOrderStatusesI18nRemoved) {
            $sOrderStatusesI18nRemoved->setSOrderStatuses(null);
        }

        $this->collSOrderStatusesI18ns = null;
        foreach ($sOrderStatusesI18ns as $sOrderStatusesI18n) {
            $this->addSOrderStatusesI18n($sOrderStatusesI18n);
        }

        $this->collSOrderStatusesI18ns = $sOrderStatusesI18ns;
        $this->collSOrderStatusesI18nsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related SOrderStatusesI18n objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related SOrderStatusesI18n objects.
     * @throws PropelException
     */
    public function countSOrderStatusesI18ns(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collSOrderStatusesI18nsPartial && !$this->isNew();
        if (null === $this->collSOrderStatusesI18ns || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collSOrderStatusesI18ns) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getSOrderStatusesI18ns());
            }

            $query = ChildSOrderStatusesI18nQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterBySOrderStatuses($this)
                ->count($con);
        }

        return count($this->collSOrderStatusesI18ns);
    }

    /**
     * Method called to associate a ChildSOrderStatusesI18n object to this object
     * through the ChildSOrderStatusesI18n foreign key attribute.
     *
     * @param  ChildSOrderStatusesI18n $l ChildSOrderStatusesI18n
     * @return $this|\SOrderStatuses The current object (for fluent API support)
     */
    public function addSOrderStatusesI18n(ChildSOrderStatusesI18n $l)
    {
        if ($l && $locale = $l->getLocale()) {
            $this->setLocale($locale);
            $this->currentTranslations[$locale] = $l;
        }
        if ($this->collSOrderStatusesI18ns === null) {
            $this->initSOrderStatusesI18ns();
            $this->collSOrderStatusesI18nsPartial = true;
        }

        if (!$this->collSOrderStatusesI18ns->contains($l)) {
            $this->doAddSOrderStatusesI18n($l);
        }

        return $this;
    }

    /**
     * @param ChildSOrderStatusesI18n $sOrderStatusesI18n The ChildSOrderStatusesI18n object to add.
     */
    protected function doAddSOrderStatusesI18n(ChildSOrderStatusesI18n $sOrderStatusesI18n)
    {
        $this->collSOrderStatusesI18ns[]= $sOrderStatusesI18n;
        $sOrderStatusesI18n->setSOrderStatuses($this);
    }

    /**
     * @param  ChildSOrderStatusesI18n $sOrderStatusesI18n The ChildSOrderStatusesI18n object to remove.
     * @return $this|ChildSOrderStatuses The current object (for fluent API support)
     */
    public function removeSOrderStatusesI18n(ChildSOrderStatusesI18n $sOrderStatusesI18n)
    {
        if ($this->getSOrderStatusesI18ns()->contains($sOrderStatusesI18n)) {
            $pos = $this->collSOrderStatusesI18ns->search($sOrderStatusesI18n);
            $this->collSOrderStatusesI18ns->remove($pos);
            if (null === $this->sOrderStatusesI18nsScheduledForDeletion) {
                $this->sOrderStatusesI18nsScheduledForDeletion = clone $this->collSOrderStatusesI18ns;
                $this->sOrderStatusesI18nsScheduledForDeletion->clear();
            }
            $this->sOrderStatusesI18nsScheduledForDeletion[]= clone $sOrderStatusesI18n;
            $sOrderStatusesI18n->setSOrderStatuses(null);
        }

        return $this;
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
     * If this ChildSOrderStatuses is new, it will return
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
                    ->filterBySOrderStatuses($this)
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
     * @return $this|ChildSOrderStatuses The current object (for fluent API support)
     */
    public function setSOrderss(Collection $sOrderss, ConnectionInterface $con = null)
    {
        /** @var ChildSOrders[] $sOrderssToDelete */
        $sOrderssToDelete = $this->getSOrderss(new Criteria(), $con)->diff($sOrderss);


        $this->sOrderssScheduledForDeletion = $sOrderssToDelete;

        foreach ($sOrderssToDelete as $sOrdersRemoved) {
            $sOrdersRemoved->setSOrderStatuses(null);
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
                ->filterBySOrderStatuses($this)
                ->count($con);
        }

        return count($this->collSOrderss);
    }

    /**
     * Method called to associate a ChildSOrders object to this object
     * through the ChildSOrders foreign key attribute.
     *
     * @param  ChildSOrders $l ChildSOrders
     * @return $this|\SOrderStatuses The current object (for fluent API support)
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
        $sOrders->setSOrderStatuses($this);
    }

    /**
     * @param  ChildSOrders $sOrders The ChildSOrders object to remove.
     * @return $this|ChildSOrderStatuses The current object (for fluent API support)
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
            $sOrders->setSOrderStatuses(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this SOrderStatuses is new, it will return
     * an empty collection; or if this SOrderStatuses has previously
     * been saved, it will retrieve related SOrderss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in SOrderStatuses.
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
     * Otherwise if this SOrderStatuses is new, it will return
     * an empty collection; or if this SOrderStatuses has previously
     * been saved, it will retrieve related SOrderss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in SOrderStatuses.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildSOrders[] List of ChildSOrders objects
     */
    public function getSOrderssJoinSPaymentMethods(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildSOrdersQuery::create(null, $criteria);
        $query->joinWith('SPaymentMethods', $joinBehavior);

        return $this->getSOrderss($query, $con);
    }

    /**
     * Clears out the collSOrderStatusHistories collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addSOrderStatusHistories()
     */
    public function clearSOrderStatusHistories()
    {
        $this->collSOrderStatusHistories = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collSOrderStatusHistories collection loaded partially.
     */
    public function resetPartialSOrderStatusHistories($v = true)
    {
        $this->collSOrderStatusHistoriesPartial = $v;
    }

    /**
     * Initializes the collSOrderStatusHistories collection.
     *
     * By default this just sets the collSOrderStatusHistories collection to an empty array (like clearcollSOrderStatusHistories());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initSOrderStatusHistories($overrideExisting = true)
    {
        if (null !== $this->collSOrderStatusHistories && !$overrideExisting) {
            return;
        }
        $this->collSOrderStatusHistories = new ObjectCollection();
        $this->collSOrderStatusHistories->setModel('\SOrderStatusHistory');
    }

    /**
     * Gets an array of ChildSOrderStatusHistory objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildSOrderStatuses is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildSOrderStatusHistory[] List of ChildSOrderStatusHistory objects
     * @throws PropelException
     */
    public function getSOrderStatusHistories(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collSOrderStatusHistoriesPartial && !$this->isNew();
        if (null === $this->collSOrderStatusHistories || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collSOrderStatusHistories) {
                // return empty collection
                $this->initSOrderStatusHistories();
            } else {
                $collSOrderStatusHistories = ChildSOrderStatusHistoryQuery::create(null, $criteria)
                    ->filterBySOrderStatuses($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collSOrderStatusHistoriesPartial && count($collSOrderStatusHistories)) {
                        $this->initSOrderStatusHistories(false);

                        foreach ($collSOrderStatusHistories as $obj) {
                            if (false == $this->collSOrderStatusHistories->contains($obj)) {
                                $this->collSOrderStatusHistories->append($obj);
                            }
                        }

                        $this->collSOrderStatusHistoriesPartial = true;
                    }

                    return $collSOrderStatusHistories;
                }

                if ($partial && $this->collSOrderStatusHistories) {
                    foreach ($this->collSOrderStatusHistories as $obj) {
                        if ($obj->isNew()) {
                            $collSOrderStatusHistories[] = $obj;
                        }
                    }
                }

                $this->collSOrderStatusHistories = $collSOrderStatusHistories;
                $this->collSOrderStatusHistoriesPartial = false;
            }
        }

        return $this->collSOrderStatusHistories;
    }

    /**
     * Sets a collection of ChildSOrderStatusHistory objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $sOrderStatusHistories A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildSOrderStatuses The current object (for fluent API support)
     */
    public function setSOrderStatusHistories(Collection $sOrderStatusHistories, ConnectionInterface $con = null)
    {
        /** @var ChildSOrderStatusHistory[] $sOrderStatusHistoriesToDelete */
        $sOrderStatusHistoriesToDelete = $this->getSOrderStatusHistories(new Criteria(), $con)->diff($sOrderStatusHistories);


        $this->sOrderStatusHistoriesScheduledForDeletion = $sOrderStatusHistoriesToDelete;

        foreach ($sOrderStatusHistoriesToDelete as $sOrderStatusHistoryRemoved) {
            $sOrderStatusHistoryRemoved->setSOrderStatuses(null);
        }

        $this->collSOrderStatusHistories = null;
        foreach ($sOrderStatusHistories as $sOrderStatusHistory) {
            $this->addSOrderStatusHistory($sOrderStatusHistory);
        }

        $this->collSOrderStatusHistories = $sOrderStatusHistories;
        $this->collSOrderStatusHistoriesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related SOrderStatusHistory objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related SOrderStatusHistory objects.
     * @throws PropelException
     */
    public function countSOrderStatusHistories(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collSOrderStatusHistoriesPartial && !$this->isNew();
        if (null === $this->collSOrderStatusHistories || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collSOrderStatusHistories) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getSOrderStatusHistories());
            }

            $query = ChildSOrderStatusHistoryQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterBySOrderStatuses($this)
                ->count($con);
        }

        return count($this->collSOrderStatusHistories);
    }

    /**
     * Method called to associate a ChildSOrderStatusHistory object to this object
     * through the ChildSOrderStatusHistory foreign key attribute.
     *
     * @param  ChildSOrderStatusHistory $l ChildSOrderStatusHistory
     * @return $this|\SOrderStatuses The current object (for fluent API support)
     */
    public function addSOrderStatusHistory(ChildSOrderStatusHistory $l)
    {
        if ($this->collSOrderStatusHistories === null) {
            $this->initSOrderStatusHistories();
            $this->collSOrderStatusHistoriesPartial = true;
        }

        if (!$this->collSOrderStatusHistories->contains($l)) {
            $this->doAddSOrderStatusHistory($l);
        }

        return $this;
    }

    /**
     * @param ChildSOrderStatusHistory $sOrderStatusHistory The ChildSOrderStatusHistory object to add.
     */
    protected function doAddSOrderStatusHistory(ChildSOrderStatusHistory $sOrderStatusHistory)
    {
        $this->collSOrderStatusHistories[]= $sOrderStatusHistory;
        $sOrderStatusHistory->setSOrderStatuses($this);
    }

    /**
     * @param  ChildSOrderStatusHistory $sOrderStatusHistory The ChildSOrderStatusHistory object to remove.
     * @return $this|ChildSOrderStatuses The current object (for fluent API support)
     */
    public function removeSOrderStatusHistory(ChildSOrderStatusHistory $sOrderStatusHistory)
    {
        if ($this->getSOrderStatusHistories()->contains($sOrderStatusHistory)) {
            $pos = $this->collSOrderStatusHistories->search($sOrderStatusHistory);
            $this->collSOrderStatusHistories->remove($pos);
            if (null === $this->sOrderStatusHistoriesScheduledForDeletion) {
                $this->sOrderStatusHistoriesScheduledForDeletion = clone $this->collSOrderStatusHistories;
                $this->sOrderStatusHistoriesScheduledForDeletion->clear();
            }
            $this->sOrderStatusHistoriesScheduledForDeletion[]= $sOrderStatusHistory;
            $sOrderStatusHistory->setSOrderStatuses(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this SOrderStatuses is new, it will return
     * an empty collection; or if this SOrderStatuses has previously
     * been saved, it will retrieve related SOrderStatusHistories from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in SOrderStatuses.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildSOrderStatusHistory[] List of ChildSOrderStatusHistory objects
     */
    public function getSOrderStatusHistoriesJoinSOrders(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildSOrderStatusHistoryQuery::create(null, $criteria);
        $query->joinWith('SOrders', $joinBehavior);

        return $this->getSOrderStatusHistories($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        $this->id = null;
        $this->color = null;
        $this->fontcolor = null;
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
            if ($this->collSOrderStatusesI18ns) {
                foreach ($this->collSOrderStatusesI18ns as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collSOrderss) {
                foreach ($this->collSOrderss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collSOrderStatusHistories) {
                foreach ($this->collSOrderStatusHistories as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        // i18n behavior
        $this->currentLocale = 'ru';
        $this->currentTranslations = null;

        $this->collSOrderStatusesI18ns = null;
        $this->collSOrderss = null;
        $this->collSOrderStatusHistories = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(SOrderStatusesTableMap::DEFAULT_STRING_FORMAT);
    }

    // i18n behavior

    /**
     * Sets the locale for translations
     *
     * @param     string $locale Locale to use for the translation, e.g. 'fr_FR'
     *
     * @return    $this|ChildSOrderStatuses The current object (for fluent API support)
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
     * @return ChildSOrderStatusesI18n */
    public function getTranslation($locale = 'ru', ConnectionInterface $con = null)
    {
        if (!isset($this->currentTranslations[$locale])) {
            if (null !== $this->collSOrderStatusesI18ns) {
                foreach ($this->collSOrderStatusesI18ns as $translation) {
                    if ($translation->getLocale() == $locale) {
                        $this->currentTranslations[$locale] = $translation;

                        return $translation;
                    }
                }
            }
            if ($this->isNew()) {
                $translation = new ChildSOrderStatusesI18n();
                $translation->setLocale($locale);
            } else {
                $translation = ChildSOrderStatusesI18nQuery::create()
                    ->filterByPrimaryKey(array($this->getPrimaryKey(), $locale))
                    ->findOneOrCreate($con);
                $this->currentTranslations[$locale] = $translation;
            }
            $this->addSOrderStatusesI18n($translation);
        }

        return $this->currentTranslations[$locale];
    }

    /**
     * Remove the translation for a given locale
     *
     * @param     string $locale Locale to use for the translation, e.g. 'fr_FR'
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return    $this|ChildSOrderStatuses The current object (for fluent API support)
     */
    public function removeTranslation($locale = 'ru', ConnectionInterface $con = null)
    {
        if (!$this->isNew()) {
            ChildSOrderStatusesI18nQuery::create()
                ->filterByPrimaryKey(array($this->getPrimaryKey(), $locale))
                ->delete($con);
        }
        if (isset($this->currentTranslations[$locale])) {
            unset($this->currentTranslations[$locale]);
        }
        foreach ($this->collSOrderStatusesI18ns as $key => $translation) {
            if ($translation->getLocale() == $locale) {
                unset($this->collSOrderStatusesI18ns[$key]);
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
     * @return ChildSOrderStatusesI18n */
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
         * @return $this|\SOrderStatusesI18n The current object (for fluent API support)
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
