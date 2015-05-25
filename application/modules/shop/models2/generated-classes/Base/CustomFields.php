<?php

namespace Base;

use \CustomFields as ChildCustomFields;
use \CustomFieldsI18n as ChildCustomFieldsI18n;
use \CustomFieldsI18nQuery as ChildCustomFieldsI18nQuery;
use \CustomFieldsQuery as ChildCustomFieldsQuery;
use \Exception;
use \PDO;
use Map\CustomFieldsTableMap;
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
 * Base class that represents a row from the 'custom_fields' table.
 *
 *
 *
* @package    propel.generator..Base
*/
abstract class CustomFields extends PropelBaseModelClass implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\CustomFieldsTableMap';


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
     * The value for the entity field.
     * @var        string
     */
    protected $entity;

    /**
     * The value for the field_type_id field.
     * @var        int
     */
    protected $field_type_id;

    /**
     * The value for the field_name field.
     * @var        string
     */
    protected $field_name;

    /**
     * The value for the is_required field.
     * Note: this column has a database default value of: true
     * @var        boolean
     */
    protected $is_required;

    /**
     * The value for the is_active field.
     * Note: this column has a database default value of: true
     * @var        boolean
     */
    protected $is_active;

    /**
     * The value for the options field.
     * @var        string
     */
    protected $options;

    /**
     * The value for the is_private field.
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $is_private;

    /**
     * The value for the validators field.
     * @var        string
     */
    protected $validators;

    /**
     * The value for the classes field.
     * @var        string
     */
    protected $classes;

    /**
     * The value for the position field.
     * @var        int
     */
    protected $position;

    /**
     * @var        ObjectCollection|ChildCustomFieldsI18n[] Collection to store aggregation of ChildCustomFieldsI18n objects.
     */
    protected $collCustomFieldsI18ns;
    protected $collCustomFieldsI18nsPartial;

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
     * @var        array[ChildCustomFieldsI18n]
     */
    protected $currentTranslations;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildCustomFieldsI18n[]
     */
    protected $customFieldsI18nsScheduledForDeletion = null;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see __construct()
     */
    public function applyDefaultValues()
    {
        $this->is_required = true;
        $this->is_active = true;
        $this->is_private = false;
    }

    /**
     * Initializes internal state of Base\CustomFields object.
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
     * Compares this with another <code>CustomFields</code> instance.  If
     * <code>obj</code> is an instance of <code>CustomFields</code>, delegates to
     * <code>equals(CustomFields)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|CustomFields The current object, for fluid interface
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
     * Get the [entity] column value.
     *
     * @return string
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * Get the [field_type_id] column value.
     *
     * @return int
     */
    public function gettypeId()
    {
        return $this->field_type_id;
    }

    /**
     * Get the [field_name] column value.
     *
     * @return string
     */
    public function getname()
    {
        return $this->field_name;
    }

    /**
     * Get the [is_required] column value.
     *
     * @return boolean
     */
    public function getIsRequired()
    {
        return $this->is_required;
    }

    /**
     * Get the [is_required] column value.
     *
     * @return boolean
     */
    public function isRequired()
    {
        return $this->getIsRequired();
    }

    /**
     * Get the [is_active] column value.
     *
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->is_active;
    }

    /**
     * Get the [is_active] column value.
     *
     * @return boolean
     */
    public function isActive()
    {
        return $this->getIsActive();
    }

    /**
     * Get the [options] column value.
     *
     * @return string
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Get the [is_private] column value.
     *
     * @return boolean
     */
    public function getIsPrivate()
    {
        return $this->is_private;
    }

    /**
     * Get the [is_private] column value.
     *
     * @return boolean
     */
    public function isPrivate()
    {
        return $this->getIsPrivate();
    }

    /**
     * Get the [validators] column value.
     *
     * @return string
     */
    public function getValidators()
    {
        return $this->validators;
    }

    /**
     * Get the [classes] column value.
     *
     * @return string
     */
    public function getclasses()
    {
        return $this->classes;
    }

    /**
     * Get the [position] column value.
     *
     * @return int
     */
    public function getposition()
    {
        return $this->position;
    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return $this|\CustomFields The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[CustomFieldsTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [entity] column.
     *
     * @param string $v new value
     * @return $this|\CustomFields The current object (for fluent API support)
     */
    public function setEntity($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->entity !== $v) {
            $this->entity = $v;
            $this->modifiedColumns[CustomFieldsTableMap::COL_ENTITY] = true;
        }

        return $this;
    } // setEntity()

    /**
     * Set the value of [field_type_id] column.
     *
     * @param int $v new value
     * @return $this|\CustomFields The current object (for fluent API support)
     */
    public function settypeId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->field_type_id !== $v) {
            $this->field_type_id = $v;
            $this->modifiedColumns[CustomFieldsTableMap::COL_FIELD_TYPE_ID] = true;
        }

        return $this;
    } // settypeId()

    /**
     * Set the value of [field_name] column.
     *
     * @param string $v new value
     * @return $this|\CustomFields The current object (for fluent API support)
     */
    public function setname($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->field_name !== $v) {
            $this->field_name = $v;
            $this->modifiedColumns[CustomFieldsTableMap::COL_FIELD_NAME] = true;
        }

        return $this;
    } // setname()

    /**
     * Sets the value of the [is_required] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\CustomFields The current object (for fluent API support)
     */
    public function setIsRequired($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->is_required !== $v) {
            $this->is_required = $v;
            $this->modifiedColumns[CustomFieldsTableMap::COL_IS_REQUIRED] = true;
        }

        return $this;
    } // setIsRequired()

    /**
     * Sets the value of the [is_active] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\CustomFields The current object (for fluent API support)
     */
    public function setIsActive($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->is_active !== $v) {
            $this->is_active = $v;
            $this->modifiedColumns[CustomFieldsTableMap::COL_IS_ACTIVE] = true;
        }

        return $this;
    } // setIsActive()

    /**
     * Set the value of [options] column.
     *
     * @param string $v new value
     * @return $this|\CustomFields The current object (for fluent API support)
     */
    public function setOptions($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->options !== $v) {
            $this->options = $v;
            $this->modifiedColumns[CustomFieldsTableMap::COL_OPTIONS] = true;
        }

        return $this;
    } // setOptions()

    /**
     * Sets the value of the [is_private] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\CustomFields The current object (for fluent API support)
     */
    public function setIsPrivate($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->is_private !== $v) {
            $this->is_private = $v;
            $this->modifiedColumns[CustomFieldsTableMap::COL_IS_PRIVATE] = true;
        }

        return $this;
    } // setIsPrivate()

    /**
     * Set the value of [validators] column.
     *
     * @param string $v new value
     * @return $this|\CustomFields The current object (for fluent API support)
     */
    public function setValidators($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->validators !== $v) {
            $this->validators = $v;
            $this->modifiedColumns[CustomFieldsTableMap::COL_VALIDATORS] = true;
        }

        return $this;
    } // setValidators()

    /**
     * Set the value of [classes] column.
     *
     * @param string $v new value
     * @return $this|\CustomFields The current object (for fluent API support)
     */
    public function setclasses($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->classes !== $v) {
            $this->classes = $v;
            $this->modifiedColumns[CustomFieldsTableMap::COL_CLASSES] = true;
        }

        return $this;
    } // setclasses()

    /**
     * Set the value of [position] column.
     *
     * @param int $v new value
     * @return $this|\CustomFields The current object (for fluent API support)
     */
    public function setposition($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->position !== $v) {
            $this->position = $v;
            $this->modifiedColumns[CustomFieldsTableMap::COL_POSITION] = true;
        }

        return $this;
    } // setposition()

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
            if ($this->is_required !== true) {
                return false;
            }

            if ($this->is_active !== true) {
                return false;
            }

            if ($this->is_private !== false) {
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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : CustomFieldsTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : CustomFieldsTableMap::translateFieldName('Entity', TableMap::TYPE_PHPNAME, $indexType)];
            $this->entity = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : CustomFieldsTableMap::translateFieldName('typeId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->field_type_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : CustomFieldsTableMap::translateFieldName('name', TableMap::TYPE_PHPNAME, $indexType)];
            $this->field_name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : CustomFieldsTableMap::translateFieldName('IsRequired', TableMap::TYPE_PHPNAME, $indexType)];
            $this->is_required = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : CustomFieldsTableMap::translateFieldName('IsActive', TableMap::TYPE_PHPNAME, $indexType)];
            $this->is_active = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : CustomFieldsTableMap::translateFieldName('Options', TableMap::TYPE_PHPNAME, $indexType)];
            $this->options = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : CustomFieldsTableMap::translateFieldName('IsPrivate', TableMap::TYPE_PHPNAME, $indexType)];
            $this->is_private = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : CustomFieldsTableMap::translateFieldName('Validators', TableMap::TYPE_PHPNAME, $indexType)];
            $this->validators = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : CustomFieldsTableMap::translateFieldName('classes', TableMap::TYPE_PHPNAME, $indexType)];
            $this->classes = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 10 + $startcol : CustomFieldsTableMap::translateFieldName('position', TableMap::TYPE_PHPNAME, $indexType)];
            $this->position = (null !== $col) ? (int) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 11; // 11 = CustomFieldsTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\CustomFields'), 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(CustomFieldsTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildCustomFieldsQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collCustomFieldsI18ns = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see CustomFields::setDeleted()
     * @see CustomFields::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(CustomFieldsTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildCustomFieldsQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(CustomFieldsTableMap::DATABASE_NAME);
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
                CustomFieldsTableMap::addInstanceToPool($this);
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

            if ($this->customFieldsI18nsScheduledForDeletion !== null) {
                if (!$this->customFieldsI18nsScheduledForDeletion->isEmpty()) {
                    \CustomFieldsI18nQuery::create()
                        ->filterByPrimaryKeys($this->customFieldsI18nsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->customFieldsI18nsScheduledForDeletion = null;
                }
            }

            if ($this->collCustomFieldsI18ns !== null) {
                foreach ($this->collCustomFieldsI18ns as $referrerFK) {
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

        $this->modifiedColumns[CustomFieldsTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . CustomFieldsTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(CustomFieldsTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(CustomFieldsTableMap::COL_ENTITY)) {
            $modifiedColumns[':p' . $index++]  = 'entity';
        }
        if ($this->isColumnModified(CustomFieldsTableMap::COL_FIELD_TYPE_ID)) {
            $modifiedColumns[':p' . $index++]  = 'field_type_id';
        }
        if ($this->isColumnModified(CustomFieldsTableMap::COL_FIELD_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'field_name';
        }
        if ($this->isColumnModified(CustomFieldsTableMap::COL_IS_REQUIRED)) {
            $modifiedColumns[':p' . $index++]  = 'is_required';
        }
        if ($this->isColumnModified(CustomFieldsTableMap::COL_IS_ACTIVE)) {
            $modifiedColumns[':p' . $index++]  = 'is_active';
        }
        if ($this->isColumnModified(CustomFieldsTableMap::COL_OPTIONS)) {
            $modifiedColumns[':p' . $index++]  = 'options';
        }
        if ($this->isColumnModified(CustomFieldsTableMap::COL_IS_PRIVATE)) {
            $modifiedColumns[':p' . $index++]  = 'is_private';
        }
        if ($this->isColumnModified(CustomFieldsTableMap::COL_VALIDATORS)) {
            $modifiedColumns[':p' . $index++]  = 'validators';
        }
        if ($this->isColumnModified(CustomFieldsTableMap::COL_CLASSES)) {
            $modifiedColumns[':p' . $index++]  = 'classes';
        }
        if ($this->isColumnModified(CustomFieldsTableMap::COL_POSITION)) {
            $modifiedColumns[':p' . $index++]  = 'position';
        }

        $sql = sprintf(
            'INSERT INTO custom_fields (%s) VALUES (%s)',
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
                    case 'entity':
                        $stmt->bindValue($identifier, $this->entity, PDO::PARAM_STR);
                        break;
                    case 'field_type_id':
                        $stmt->bindValue($identifier, $this->field_type_id, PDO::PARAM_INT);
                        break;
                    case 'field_name':
                        $stmt->bindValue($identifier, $this->field_name, PDO::PARAM_STR);
                        break;
                    case 'is_required':
                        $stmt->bindValue($identifier, (int) $this->is_required, PDO::PARAM_INT);
                        break;
                    case 'is_active':
                        $stmt->bindValue($identifier, (int) $this->is_active, PDO::PARAM_INT);
                        break;
                    case 'options':
                        $stmt->bindValue($identifier, $this->options, PDO::PARAM_STR);
                        break;
                    case 'is_private':
                        $stmt->bindValue($identifier, (int) $this->is_private, PDO::PARAM_INT);
                        break;
                    case 'validators':
                        $stmt->bindValue($identifier, $this->validators, PDO::PARAM_STR);
                        break;
                    case 'classes':
                        $stmt->bindValue($identifier, $this->classes, PDO::PARAM_STR);
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
        $pos = CustomFieldsTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getEntity();
                break;
            case 2:
                return $this->gettypeId();
                break;
            case 3:
                return $this->getname();
                break;
            case 4:
                return $this->getIsRequired();
                break;
            case 5:
                return $this->getIsActive();
                break;
            case 6:
                return $this->getOptions();
                break;
            case 7:
                return $this->getIsPrivate();
                break;
            case 8:
                return $this->getValidators();
                break;
            case 9:
                return $this->getclasses();
                break;
            case 10:
                return $this->getposition();
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

        if (isset($alreadyDumpedObjects['CustomFields'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['CustomFields'][$this->hashCode()] = true;
        $keys = CustomFieldsTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getEntity(),
            $keys[2] => $this->gettypeId(),
            $keys[3] => $this->getname(),
            $keys[4] => $this->getIsRequired(),
            $keys[5] => $this->getIsActive(),
            $keys[6] => $this->getOptions(),
            $keys[7] => $this->getIsPrivate(),
            $keys[8] => $this->getValidators(),
            $keys[9] => $this->getclasses(),
            $keys[10] => $this->getposition(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->collCustomFieldsI18ns) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'customFieldsI18ns';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'custom_fields_i18ns';
                        break;
                    default:
                        $key = 'CustomFieldsI18ns';
                }

                $result[$key] = $this->collCustomFieldsI18ns->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\CustomFields
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = CustomFieldsTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\CustomFields
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setEntity($value);
                break;
            case 2:
                $this->settypeId($value);
                break;
            case 3:
                $this->setname($value);
                break;
            case 4:
                $this->setIsRequired($value);
                break;
            case 5:
                $this->setIsActive($value);
                break;
            case 6:
                $this->setOptions($value);
                break;
            case 7:
                $this->setIsPrivate($value);
                break;
            case 8:
                $this->setValidators($value);
                break;
            case 9:
                $this->setclasses($value);
                break;
            case 10:
                $this->setposition($value);
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
        $keys = CustomFieldsTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setEntity($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->settypeId($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setname($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setIsRequired($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setIsActive($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setOptions($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setIsPrivate($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setValidators($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setclasses($arr[$keys[9]]);
        }
        if (array_key_exists($keys[10], $arr)) {
            $this->setposition($arr[$keys[10]]);
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
     * @return $this|\CustomFields The current object, for fluid interface
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
        $criteria = new Criteria(CustomFieldsTableMap::DATABASE_NAME);

        if ($this->isColumnModified(CustomFieldsTableMap::COL_ID)) {
            $criteria->add(CustomFieldsTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(CustomFieldsTableMap::COL_ENTITY)) {
            $criteria->add(CustomFieldsTableMap::COL_ENTITY, $this->entity);
        }
        if ($this->isColumnModified(CustomFieldsTableMap::COL_FIELD_TYPE_ID)) {
            $criteria->add(CustomFieldsTableMap::COL_FIELD_TYPE_ID, $this->field_type_id);
        }
        if ($this->isColumnModified(CustomFieldsTableMap::COL_FIELD_NAME)) {
            $criteria->add(CustomFieldsTableMap::COL_FIELD_NAME, $this->field_name);
        }
        if ($this->isColumnModified(CustomFieldsTableMap::COL_IS_REQUIRED)) {
            $criteria->add(CustomFieldsTableMap::COL_IS_REQUIRED, $this->is_required);
        }
        if ($this->isColumnModified(CustomFieldsTableMap::COL_IS_ACTIVE)) {
            $criteria->add(CustomFieldsTableMap::COL_IS_ACTIVE, $this->is_active);
        }
        if ($this->isColumnModified(CustomFieldsTableMap::COL_OPTIONS)) {
            $criteria->add(CustomFieldsTableMap::COL_OPTIONS, $this->options);
        }
        if ($this->isColumnModified(CustomFieldsTableMap::COL_IS_PRIVATE)) {
            $criteria->add(CustomFieldsTableMap::COL_IS_PRIVATE, $this->is_private);
        }
        if ($this->isColumnModified(CustomFieldsTableMap::COL_VALIDATORS)) {
            $criteria->add(CustomFieldsTableMap::COL_VALIDATORS, $this->validators);
        }
        if ($this->isColumnModified(CustomFieldsTableMap::COL_CLASSES)) {
            $criteria->add(CustomFieldsTableMap::COL_CLASSES, $this->classes);
        }
        if ($this->isColumnModified(CustomFieldsTableMap::COL_POSITION)) {
            $criteria->add(CustomFieldsTableMap::COL_POSITION, $this->position);
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
        $criteria = ChildCustomFieldsQuery::create();
        $criteria->add(CustomFieldsTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \CustomFields (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setEntity($this->getEntity());
        $copyObj->settypeId($this->gettypeId());
        $copyObj->setname($this->getname());
        $copyObj->setIsRequired($this->getIsRequired());
        $copyObj->setIsActive($this->getIsActive());
        $copyObj->setOptions($this->getOptions());
        $copyObj->setIsPrivate($this->getIsPrivate());
        $copyObj->setValidators($this->getValidators());
        $copyObj->setclasses($this->getclasses());
        $copyObj->setposition($this->getposition());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getCustomFieldsI18ns() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addCustomFieldsI18n($relObj->copy($deepCopy));
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
     * @return \CustomFields Clone of current object.
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
        if ('CustomFieldsI18n' == $relationName) {
            return $this->initCustomFieldsI18ns();
        }
    }

    /**
     * Clears out the collCustomFieldsI18ns collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addCustomFieldsI18ns()
     */
    public function clearCustomFieldsI18ns()
    {
        $this->collCustomFieldsI18ns = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collCustomFieldsI18ns collection loaded partially.
     */
    public function resetPartialCustomFieldsI18ns($v = true)
    {
        $this->collCustomFieldsI18nsPartial = $v;
    }

    /**
     * Initializes the collCustomFieldsI18ns collection.
     *
     * By default this just sets the collCustomFieldsI18ns collection to an empty array (like clearcollCustomFieldsI18ns());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initCustomFieldsI18ns($overrideExisting = true)
    {
        if (null !== $this->collCustomFieldsI18ns && !$overrideExisting) {
            return;
        }
        $this->collCustomFieldsI18ns = new ObjectCollection();
        $this->collCustomFieldsI18ns->setModel('\CustomFieldsI18n');
    }

    /**
     * Gets an array of ChildCustomFieldsI18n objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildCustomFields is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildCustomFieldsI18n[] List of ChildCustomFieldsI18n objects
     * @throws PropelException
     */
    public function getCustomFieldsI18ns(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collCustomFieldsI18nsPartial && !$this->isNew();
        if (null === $this->collCustomFieldsI18ns || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collCustomFieldsI18ns) {
                // return empty collection
                $this->initCustomFieldsI18ns();
            } else {
                $collCustomFieldsI18ns = ChildCustomFieldsI18nQuery::create(null, $criteria)
                    ->filterByCustomFields($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collCustomFieldsI18nsPartial && count($collCustomFieldsI18ns)) {
                        $this->initCustomFieldsI18ns(false);

                        foreach ($collCustomFieldsI18ns as $obj) {
                            if (false == $this->collCustomFieldsI18ns->contains($obj)) {
                                $this->collCustomFieldsI18ns->append($obj);
                            }
                        }

                        $this->collCustomFieldsI18nsPartial = true;
                    }

                    return $collCustomFieldsI18ns;
                }

                if ($partial && $this->collCustomFieldsI18ns) {
                    foreach ($this->collCustomFieldsI18ns as $obj) {
                        if ($obj->isNew()) {
                            $collCustomFieldsI18ns[] = $obj;
                        }
                    }
                }

                $this->collCustomFieldsI18ns = $collCustomFieldsI18ns;
                $this->collCustomFieldsI18nsPartial = false;
            }
        }

        return $this->collCustomFieldsI18ns;
    }

    /**
     * Sets a collection of ChildCustomFieldsI18n objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $customFieldsI18ns A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildCustomFields The current object (for fluent API support)
     */
    public function setCustomFieldsI18ns(Collection $customFieldsI18ns, ConnectionInterface $con = null)
    {
        /** @var ChildCustomFieldsI18n[] $customFieldsI18nsToDelete */
        $customFieldsI18nsToDelete = $this->getCustomFieldsI18ns(new Criteria(), $con)->diff($customFieldsI18ns);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->customFieldsI18nsScheduledForDeletion = clone $customFieldsI18nsToDelete;

        foreach ($customFieldsI18nsToDelete as $customFieldsI18nRemoved) {
            $customFieldsI18nRemoved->setCustomFields(null);
        }

        $this->collCustomFieldsI18ns = null;
        foreach ($customFieldsI18ns as $customFieldsI18n) {
            $this->addCustomFieldsI18n($customFieldsI18n);
        }

        $this->collCustomFieldsI18ns = $customFieldsI18ns;
        $this->collCustomFieldsI18nsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related CustomFieldsI18n objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related CustomFieldsI18n objects.
     * @throws PropelException
     */
    public function countCustomFieldsI18ns(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collCustomFieldsI18nsPartial && !$this->isNew();
        if (null === $this->collCustomFieldsI18ns || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collCustomFieldsI18ns) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getCustomFieldsI18ns());
            }

            $query = ChildCustomFieldsI18nQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCustomFields($this)
                ->count($con);
        }

        return count($this->collCustomFieldsI18ns);
    }

    /**
     * Method called to associate a ChildCustomFieldsI18n object to this object
     * through the ChildCustomFieldsI18n foreign key attribute.
     *
     * @param  ChildCustomFieldsI18n $l ChildCustomFieldsI18n
     * @return $this|\CustomFields The current object (for fluent API support)
     */
    public function addCustomFieldsI18n(ChildCustomFieldsI18n $l)
    {
        if ($l && $locale = $l->getLocale()) {
            $this->setLocale($locale);
            $this->currentTranslations[$locale] = $l;
        }
        if ($this->collCustomFieldsI18ns === null) {
            $this->initCustomFieldsI18ns();
            $this->collCustomFieldsI18nsPartial = true;
        }

        if (!$this->collCustomFieldsI18ns->contains($l)) {
            $this->doAddCustomFieldsI18n($l);
        }

        return $this;
    }

    /**
     * @param ChildCustomFieldsI18n $customFieldsI18n The ChildCustomFieldsI18n object to add.
     */
    protected function doAddCustomFieldsI18n(ChildCustomFieldsI18n $customFieldsI18n)
    {
        $this->collCustomFieldsI18ns[]= $customFieldsI18n;
        $customFieldsI18n->setCustomFields($this);
    }

    /**
     * @param  ChildCustomFieldsI18n $customFieldsI18n The ChildCustomFieldsI18n object to remove.
     * @return $this|ChildCustomFields The current object (for fluent API support)
     */
    public function removeCustomFieldsI18n(ChildCustomFieldsI18n $customFieldsI18n)
    {
        if ($this->getCustomFieldsI18ns()->contains($customFieldsI18n)) {
            $pos = $this->collCustomFieldsI18ns->search($customFieldsI18n);
            $this->collCustomFieldsI18ns->remove($pos);
            if (null === $this->customFieldsI18nsScheduledForDeletion) {
                $this->customFieldsI18nsScheduledForDeletion = clone $this->collCustomFieldsI18ns;
                $this->customFieldsI18nsScheduledForDeletion->clear();
            }
            $this->customFieldsI18nsScheduledForDeletion[]= clone $customFieldsI18n;
            $customFieldsI18n->setCustomFields(null);
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
        $this->entity = null;
        $this->field_type_id = null;
        $this->field_name = null;
        $this->is_required = null;
        $this->is_active = null;
        $this->options = null;
        $this->is_private = null;
        $this->validators = null;
        $this->classes = null;
        $this->position = null;
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
            if ($this->collCustomFieldsI18ns) {
                foreach ($this->collCustomFieldsI18ns as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        // i18n behavior
        $this->currentLocale = 'ru';
        $this->currentTranslations = null;

        $this->collCustomFieldsI18ns = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(CustomFieldsTableMap::DEFAULT_STRING_FORMAT);
    }

    // i18n behavior

    /**
     * Sets the locale for translations
     *
     * @param     string $locale Locale to use for the translation, e.g. 'fr_FR'
     *
     * @return    $this|ChildCustomFields The current object (for fluent API support)
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
     * @return ChildCustomFieldsI18n */
    public function getTranslation($locale = 'ru', ConnectionInterface $con = null)
    {
        if (!isset($this->currentTranslations[$locale])) {
            if (null !== $this->collCustomFieldsI18ns) {
                foreach ($this->collCustomFieldsI18ns as $translation) {
                    if ($translation->getLocale() == $locale) {
                        $this->currentTranslations[$locale] = $translation;

                        return $translation;
                    }
                }
            }
            if ($this->isNew()) {
                $translation = new ChildCustomFieldsI18n();
                $translation->setLocale($locale);
            } else {
                $translation = ChildCustomFieldsI18nQuery::create()
                    ->filterByPrimaryKey(array($this->getPrimaryKey(), $locale))
                    ->findOneOrCreate($con);
                $this->currentTranslations[$locale] = $translation;
            }
            $this->addCustomFieldsI18n($translation);
        }

        return $this->currentTranslations[$locale];
    }

    /**
     * Remove the translation for a given locale
     *
     * @param     string $locale Locale to use for the translation, e.g. 'fr_FR'
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return    $this|ChildCustomFields The current object (for fluent API support)
     */
    public function removeTranslation($locale = 'ru', ConnectionInterface $con = null)
    {
        if (!$this->isNew()) {
            ChildCustomFieldsI18nQuery::create()
                ->filterByPrimaryKey(array($this->getPrimaryKey(), $locale))
                ->delete($con);
        }
        if (isset($this->currentTranslations[$locale])) {
            unset($this->currentTranslations[$locale]);
        }
        foreach ($this->collCustomFieldsI18ns as $key => $translation) {
            if ($translation->getLocale() == $locale) {
                unset($this->collCustomFieldsI18ns[$key]);
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
     * @return ChildCustomFieldsI18n */
    public function getCurrentTranslation(ConnectionInterface $con = null)
    {
        return $this->getTranslation($this->getLocale(), $con);
    }


        /**
         * Get the [field_label] column value.
         *
         * @return string
         */
        public function getFieldLabel()
        {
        return $this->getCurrentTranslation()->getFieldLabel();
    }


        /**
         * Set the value of [field_label] column.
         *
         * @param string $v new value
         * @return $this|\CustomFieldsI18n The current object (for fluent API support)
         */
        public function setFieldLabel($v)
        {    $this->getCurrentTranslation()->setFieldLabel($v);

        return $this;
    }


        /**
         * Get the [field_description] column value.
         *
         * @return string
         */
        public function getFieldDescription()
        {
        return $this->getCurrentTranslation()->getFieldDescription();
    }


        /**
         * Set the value of [field_description] column.
         *
         * @param string $v new value
         * @return $this|\CustomFieldsI18n The current object (for fluent API support)
         */
        public function setFieldDescription($v)
        {    $this->getCurrentTranslation()->setFieldDescription($v);

        return $this;
    }


        /**
         * Get the [possible_values] column value.
         *
         * @return string
         */
        public function getPossibleValues()
        {
        return $this->getCurrentTranslation()->getPossibleValues();
    }


        /**
         * Set the value of [possible_values] column.
         *
         * @param string $v new value
         * @return $this|\CustomFieldsI18n The current object (for fluent API support)
         */
        public function setPossibleValues($v)
        {    $this->getCurrentTranslation()->setPossibleValues($v);

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
