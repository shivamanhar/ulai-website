<?php

namespace Base;

use \SBrands as ChildSBrands;
use \SBrandsI18n as ChildSBrandsI18n;
use \SBrandsI18nQuery as ChildSBrandsI18nQuery;
use \SBrandsQuery as ChildSBrandsQuery;
use \SProducts as ChildSProducts;
use \SProductsQuery as ChildSProductsQuery;
use \Exception;
use \PDO;
use Map\SBrandsTableMap;
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
 * Base class that represents a row from the 'shop_brands' table.
 *
 *
 *
* @package    propel.generator..Base
*/
abstract class SBrands extends PropelBaseModelClass implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\SBrandsTableMap';


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
     * The value for the url field.
     * @var        string
     */
    protected $url;

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
     * @var        ObjectCollection|ChildSProducts[] Collection to store aggregation of ChildSProducts objects.
     */
    protected $collSProductss;
    protected $collSProductssPartial;

    /**
     * @var        ObjectCollection|ChildSBrandsI18n[] Collection to store aggregation of ChildSBrandsI18n objects.
     */
    protected $collSBrandsI18ns;
    protected $collSBrandsI18nsPartial;

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
     * @var        array[ChildSBrandsI18n]
     */
    protected $currentTranslations;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildSProducts[]
     */
    protected $sProductssScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildSBrandsI18n[]
     */
    protected $sBrandsI18nsScheduledForDeletion = null;

    /**
     * Initializes internal state of Base\SBrands object.
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
     * Compares this with another <code>SBrands</code> instance.  If
     * <code>obj</code> is an instance of <code>SBrands</code>, delegates to
     * <code>equals(SBrands)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|SBrands The current object, for fluid interface
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
     * Get the [url] column value.
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
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
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return $this|\SBrands The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[SBrandsTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [url] column.
     *
     * @param string $v new value
     * @return $this|\SBrands The current object (for fluent API support)
     */
    public function setUrl($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->url !== $v) {
            $this->url = $v;
            $this->modifiedColumns[SBrandsTableMap::COL_URL] = true;
        }

        return $this;
    } // setUrl()

    /**
     * Set the value of [image] column.
     *
     * @param string $v new value
     * @return $this|\SBrands The current object (for fluent API support)
     */
    public function setImage($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->image !== $v) {
            $this->image = $v;
            $this->modifiedColumns[SBrandsTableMap::COL_IMAGE] = true;
        }

        return $this;
    } // setImage()

    /**
     * Set the value of [position] column.
     *
     * @param int $v new value
     * @return $this|\SBrands The current object (for fluent API support)
     */
    public function setPosition($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->position !== $v) {
            $this->position = $v;
            $this->modifiedColumns[SBrandsTableMap::COL_POSITION] = true;
        }

        return $this;
    } // setPosition()

    /**
     * Set the value of [created] column.
     *
     * @param int $v new value
     * @return $this|\SBrands The current object (for fluent API support)
     */
    public function setCreated($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->created !== $v) {
            $this->created = $v;
            $this->modifiedColumns[SBrandsTableMap::COL_CREATED] = true;
        }

        return $this;
    } // setCreated()

    /**
     * Set the value of [updated] column.
     *
     * @param int $v new value
     * @return $this|\SBrands The current object (for fluent API support)
     */
    public function setUpdated($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->updated !== $v) {
            $this->updated = $v;
            $this->modifiedColumns[SBrandsTableMap::COL_UPDATED] = true;
        }

        return $this;
    } // setUpdated()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : SBrandsTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : SBrandsTableMap::translateFieldName('Url', TableMap::TYPE_PHPNAME, $indexType)];
            $this->url = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : SBrandsTableMap::translateFieldName('Image', TableMap::TYPE_PHPNAME, $indexType)];
            $this->image = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : SBrandsTableMap::translateFieldName('Position', TableMap::TYPE_PHPNAME, $indexType)];
            $this->position = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : SBrandsTableMap::translateFieldName('Created', TableMap::TYPE_PHPNAME, $indexType)];
            $this->created = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : SBrandsTableMap::translateFieldName('Updated', TableMap::TYPE_PHPNAME, $indexType)];
            $this->updated = (null !== $col) ? (int) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 6; // 6 = SBrandsTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\SBrands'), 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(SBrandsTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildSBrandsQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collSProductss = null;

            $this->collSBrandsI18ns = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see SBrands::setDeleted()
     * @see SBrands::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(SBrandsTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildSBrandsQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(SBrandsTableMap::DATABASE_NAME);
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
                SBrandsTableMap::addInstanceToPool($this);
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

            if ($this->sProductssScheduledForDeletion !== null) {
                if (!$this->sProductssScheduledForDeletion->isEmpty()) {
                    foreach ($this->sProductssScheduledForDeletion as $sProducts) {
                        // need to save related object because we set the relation to null
                        $sProducts->save($con);
                    }
                    $this->sProductssScheduledForDeletion = null;
                }
            }

            if ($this->collSProductss !== null) {
                foreach ($this->collSProductss as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->sBrandsI18nsScheduledForDeletion !== null) {
                if (!$this->sBrandsI18nsScheduledForDeletion->isEmpty()) {
                    \SBrandsI18nQuery::create()
                        ->filterByPrimaryKeys($this->sBrandsI18nsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->sBrandsI18nsScheduledForDeletion = null;
                }
            }

            if ($this->collSBrandsI18ns !== null) {
                foreach ($this->collSBrandsI18ns as $referrerFK) {
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

        $this->modifiedColumns[SBrandsTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . SBrandsTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(SBrandsTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(SBrandsTableMap::COL_URL)) {
            $modifiedColumns[':p' . $index++]  = 'url';
        }
        if ($this->isColumnModified(SBrandsTableMap::COL_IMAGE)) {
            $modifiedColumns[':p' . $index++]  = 'image';
        }
        if ($this->isColumnModified(SBrandsTableMap::COL_POSITION)) {
            $modifiedColumns[':p' . $index++]  = 'position';
        }
        if ($this->isColumnModified(SBrandsTableMap::COL_CREATED)) {
            $modifiedColumns[':p' . $index++]  = 'created';
        }
        if ($this->isColumnModified(SBrandsTableMap::COL_UPDATED)) {
            $modifiedColumns[':p' . $index++]  = 'updated';
        }

        $sql = sprintf(
            'INSERT INTO shop_brands (%s) VALUES (%s)',
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
                    case 'url':
                        $stmt->bindValue($identifier, $this->url, PDO::PARAM_STR);
                        break;
                    case 'image':
                        $stmt->bindValue($identifier, $this->image, PDO::PARAM_STR);
                        break;
                    case 'position':
                        $stmt->bindValue($identifier, $this->position, PDO::PARAM_INT);
                        break;
                    case 'created':
                        $stmt->bindValue($identifier, $this->created, PDO::PARAM_INT);
                        break;
                    case 'updated':
                        $stmt->bindValue($identifier, $this->updated, PDO::PARAM_INT);
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
        $pos = SBrandsTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getUrl();
                break;
            case 2:
                return $this->getImage();
                break;
            case 3:
                return $this->getPosition();
                break;
            case 4:
                return $this->getCreated();
                break;
            case 5:
                return $this->getUpdated();
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

        if (isset($alreadyDumpedObjects['SBrands'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['SBrands'][$this->hashCode()] = true;
        $keys = SBrandsTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getUrl(),
            $keys[2] => $this->getImage(),
            $keys[3] => $this->getPosition(),
            $keys[4] => $this->getCreated(),
            $keys[5] => $this->getUpdated(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->collSProductss) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'sProductss';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'shop_productss';
                        break;
                    default:
                        $key = 'SProductss';
                }

                $result[$key] = $this->collSProductss->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collSBrandsI18ns) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'sBrandsI18ns';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'shop_brands_i18ns';
                        break;
                    default:
                        $key = 'SBrandsI18ns';
                }

                $result[$key] = $this->collSBrandsI18ns->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\SBrands
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = SBrandsTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\SBrands
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setUrl($value);
                break;
            case 2:
                $this->setImage($value);
                break;
            case 3:
                $this->setPosition($value);
                break;
            case 4:
                $this->setCreated($value);
                break;
            case 5:
                $this->setUpdated($value);
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
        $keys = SBrandsTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setUrl($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setImage($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setPosition($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setCreated($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setUpdated($arr[$keys[5]]);
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
     * @return $this|\SBrands The current object, for fluid interface
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
        $criteria = new Criteria(SBrandsTableMap::DATABASE_NAME);

        if ($this->isColumnModified(SBrandsTableMap::COL_ID)) {
            $criteria->add(SBrandsTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(SBrandsTableMap::COL_URL)) {
            $criteria->add(SBrandsTableMap::COL_URL, $this->url);
        }
        if ($this->isColumnModified(SBrandsTableMap::COL_IMAGE)) {
            $criteria->add(SBrandsTableMap::COL_IMAGE, $this->image);
        }
        if ($this->isColumnModified(SBrandsTableMap::COL_POSITION)) {
            $criteria->add(SBrandsTableMap::COL_POSITION, $this->position);
        }
        if ($this->isColumnModified(SBrandsTableMap::COL_CREATED)) {
            $criteria->add(SBrandsTableMap::COL_CREATED, $this->created);
        }
        if ($this->isColumnModified(SBrandsTableMap::COL_UPDATED)) {
            $criteria->add(SBrandsTableMap::COL_UPDATED, $this->updated);
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
        $criteria = ChildSBrandsQuery::create();
        $criteria->add(SBrandsTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \SBrands (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setUrl($this->getUrl());
        $copyObj->setImage($this->getImage());
        $copyObj->setPosition($this->getPosition());
        $copyObj->setCreated($this->getCreated());
        $copyObj->setUpdated($this->getUpdated());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getSProductss() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addSProducts($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getSBrandsI18ns() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addSBrandsI18n($relObj->copy($deepCopy));
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
     * @return \SBrands Clone of current object.
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
        if ('SProducts' == $relationName) {
            return $this->initSProductss();
        }
        if ('SBrandsI18n' == $relationName) {
            return $this->initSBrandsI18ns();
        }
    }

    /**
     * Clears out the collSProductss collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addSProductss()
     */
    public function clearSProductss()
    {
        $this->collSProductss = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collSProductss collection loaded partially.
     */
    public function resetPartialSProductss($v = true)
    {
        $this->collSProductssPartial = $v;
    }

    /**
     * Initializes the collSProductss collection.
     *
     * By default this just sets the collSProductss collection to an empty array (like clearcollSProductss());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initSProductss($overrideExisting = true)
    {
        if (null !== $this->collSProductss && !$overrideExisting) {
            return;
        }
        $this->collSProductss = new ObjectCollection();
        $this->collSProductss->setModel('\SProducts');
    }

    /**
     * Gets an array of ChildSProducts objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildSBrands is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildSProducts[] List of ChildSProducts objects
     * @throws PropelException
     */
    public function getSProductss(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collSProductssPartial && !$this->isNew();
        if (null === $this->collSProductss || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collSProductss) {
                // return empty collection
                $this->initSProductss();
            } else {
                $collSProductss = ChildSProductsQuery::create(null, $criteria)
                    ->filterByBrand($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collSProductssPartial && count($collSProductss)) {
                        $this->initSProductss(false);

                        foreach ($collSProductss as $obj) {
                            if (false == $this->collSProductss->contains($obj)) {
                                $this->collSProductss->append($obj);
                            }
                        }

                        $this->collSProductssPartial = true;
                    }

                    return $collSProductss;
                }

                if ($partial && $this->collSProductss) {
                    foreach ($this->collSProductss as $obj) {
                        if ($obj->isNew()) {
                            $collSProductss[] = $obj;
                        }
                    }
                }

                $this->collSProductss = $collSProductss;
                $this->collSProductssPartial = false;
            }
        }

        return $this->collSProductss;
    }

    /**
     * Sets a collection of ChildSProducts objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $sProductss A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildSBrands The current object (for fluent API support)
     */
    public function setSProductss(Collection $sProductss, ConnectionInterface $con = null)
    {
        /** @var ChildSProducts[] $sProductssToDelete */
        $sProductssToDelete = $this->getSProductss(new Criteria(), $con)->diff($sProductss);


        $this->sProductssScheduledForDeletion = $sProductssToDelete;

        foreach ($sProductssToDelete as $sProductsRemoved) {
            $sProductsRemoved->setBrand(null);
        }

        $this->collSProductss = null;
        foreach ($sProductss as $sProducts) {
            $this->addSProducts($sProducts);
        }

        $this->collSProductss = $sProductss;
        $this->collSProductssPartial = false;

        return $this;
    }

    /**
     * Returns the number of related SProducts objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related SProducts objects.
     * @throws PropelException
     */
    public function countSProductss(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collSProductssPartial && !$this->isNew();
        if (null === $this->collSProductss || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collSProductss) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getSProductss());
            }

            $query = ChildSProductsQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByBrand($this)
                ->count($con);
        }

        return count($this->collSProductss);
    }

    /**
     * Method called to associate a ChildSProducts object to this object
     * through the ChildSProducts foreign key attribute.
     *
     * @param  ChildSProducts $l ChildSProducts
     * @return $this|\SBrands The current object (for fluent API support)
     */
    public function addSProducts(ChildSProducts $l)
    {
        if ($this->collSProductss === null) {
            $this->initSProductss();
            $this->collSProductssPartial = true;
        }

        if (!$this->collSProductss->contains($l)) {
            $this->doAddSProducts($l);
        }

        return $this;
    }

    /**
     * @param ChildSProducts $sProducts The ChildSProducts object to add.
     */
    protected function doAddSProducts(ChildSProducts $sProducts)
    {
        $this->collSProductss[]= $sProducts;
        $sProducts->setBrand($this);
    }

    /**
     * @param  ChildSProducts $sProducts The ChildSProducts object to remove.
     * @return $this|ChildSBrands The current object (for fluent API support)
     */
    public function removeSProducts(ChildSProducts $sProducts)
    {
        if ($this->getSProductss()->contains($sProducts)) {
            $pos = $this->collSProductss->search($sProducts);
            $this->collSProductss->remove($pos);
            if (null === $this->sProductssScheduledForDeletion) {
                $this->sProductssScheduledForDeletion = clone $this->collSProductss;
                $this->sProductssScheduledForDeletion->clear();
            }
            $this->sProductssScheduledForDeletion[]= $sProducts;
            $sProducts->setBrand(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this SBrands is new, it will return
     * an empty collection; or if this SBrands has previously
     * been saved, it will retrieve related SProductss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in SBrands.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildSProducts[] List of ChildSProducts objects
     */
    public function getSProductssJoinMainCategory(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildSProductsQuery::create(null, $criteria);
        $query->joinWith('MainCategory', $joinBehavior);

        return $this->getSProductss($query, $con);
    }

    /**
     * Clears out the collSBrandsI18ns collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addSBrandsI18ns()
     */
    public function clearSBrandsI18ns()
    {
        $this->collSBrandsI18ns = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collSBrandsI18ns collection loaded partially.
     */
    public function resetPartialSBrandsI18ns($v = true)
    {
        $this->collSBrandsI18nsPartial = $v;
    }

    /**
     * Initializes the collSBrandsI18ns collection.
     *
     * By default this just sets the collSBrandsI18ns collection to an empty array (like clearcollSBrandsI18ns());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initSBrandsI18ns($overrideExisting = true)
    {
        if (null !== $this->collSBrandsI18ns && !$overrideExisting) {
            return;
        }
        $this->collSBrandsI18ns = new ObjectCollection();
        $this->collSBrandsI18ns->setModel('\SBrandsI18n');
    }

    /**
     * Gets an array of ChildSBrandsI18n objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildSBrands is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildSBrandsI18n[] List of ChildSBrandsI18n objects
     * @throws PropelException
     */
    public function getSBrandsI18ns(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collSBrandsI18nsPartial && !$this->isNew();
        if (null === $this->collSBrandsI18ns || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collSBrandsI18ns) {
                // return empty collection
                $this->initSBrandsI18ns();
            } else {
                $collSBrandsI18ns = ChildSBrandsI18nQuery::create(null, $criteria)
                    ->filterBySBrands($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collSBrandsI18nsPartial && count($collSBrandsI18ns)) {
                        $this->initSBrandsI18ns(false);

                        foreach ($collSBrandsI18ns as $obj) {
                            if (false == $this->collSBrandsI18ns->contains($obj)) {
                                $this->collSBrandsI18ns->append($obj);
                            }
                        }

                        $this->collSBrandsI18nsPartial = true;
                    }

                    return $collSBrandsI18ns;
                }

                if ($partial && $this->collSBrandsI18ns) {
                    foreach ($this->collSBrandsI18ns as $obj) {
                        if ($obj->isNew()) {
                            $collSBrandsI18ns[] = $obj;
                        }
                    }
                }

                $this->collSBrandsI18ns = $collSBrandsI18ns;
                $this->collSBrandsI18nsPartial = false;
            }
        }

        return $this->collSBrandsI18ns;
    }

    /**
     * Sets a collection of ChildSBrandsI18n objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $sBrandsI18ns A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildSBrands The current object (for fluent API support)
     */
    public function setSBrandsI18ns(Collection $sBrandsI18ns, ConnectionInterface $con = null)
    {
        /** @var ChildSBrandsI18n[] $sBrandsI18nsToDelete */
        $sBrandsI18nsToDelete = $this->getSBrandsI18ns(new Criteria(), $con)->diff($sBrandsI18ns);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->sBrandsI18nsScheduledForDeletion = clone $sBrandsI18nsToDelete;

        foreach ($sBrandsI18nsToDelete as $sBrandsI18nRemoved) {
            $sBrandsI18nRemoved->setSBrands(null);
        }

        $this->collSBrandsI18ns = null;
        foreach ($sBrandsI18ns as $sBrandsI18n) {
            $this->addSBrandsI18n($sBrandsI18n);
        }

        $this->collSBrandsI18ns = $sBrandsI18ns;
        $this->collSBrandsI18nsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related SBrandsI18n objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related SBrandsI18n objects.
     * @throws PropelException
     */
    public function countSBrandsI18ns(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collSBrandsI18nsPartial && !$this->isNew();
        if (null === $this->collSBrandsI18ns || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collSBrandsI18ns) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getSBrandsI18ns());
            }

            $query = ChildSBrandsI18nQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterBySBrands($this)
                ->count($con);
        }

        return count($this->collSBrandsI18ns);
    }

    /**
     * Method called to associate a ChildSBrandsI18n object to this object
     * through the ChildSBrandsI18n foreign key attribute.
     *
     * @param  ChildSBrandsI18n $l ChildSBrandsI18n
     * @return $this|\SBrands The current object (for fluent API support)
     */
    public function addSBrandsI18n(ChildSBrandsI18n $l)
    {
        if ($l && $locale = $l->getLocale()) {
            $this->setLocale($locale);
            $this->currentTranslations[$locale] = $l;
        }
        if ($this->collSBrandsI18ns === null) {
            $this->initSBrandsI18ns();
            $this->collSBrandsI18nsPartial = true;
        }

        if (!$this->collSBrandsI18ns->contains($l)) {
            $this->doAddSBrandsI18n($l);
        }

        return $this;
    }

    /**
     * @param ChildSBrandsI18n $sBrandsI18n The ChildSBrandsI18n object to add.
     */
    protected function doAddSBrandsI18n(ChildSBrandsI18n $sBrandsI18n)
    {
        $this->collSBrandsI18ns[]= $sBrandsI18n;
        $sBrandsI18n->setSBrands($this);
    }

    /**
     * @param  ChildSBrandsI18n $sBrandsI18n The ChildSBrandsI18n object to remove.
     * @return $this|ChildSBrands The current object (for fluent API support)
     */
    public function removeSBrandsI18n(ChildSBrandsI18n $sBrandsI18n)
    {
        if ($this->getSBrandsI18ns()->contains($sBrandsI18n)) {
            $pos = $this->collSBrandsI18ns->search($sBrandsI18n);
            $this->collSBrandsI18ns->remove($pos);
            if (null === $this->sBrandsI18nsScheduledForDeletion) {
                $this->sBrandsI18nsScheduledForDeletion = clone $this->collSBrandsI18ns;
                $this->sBrandsI18nsScheduledForDeletion->clear();
            }
            $this->sBrandsI18nsScheduledForDeletion[]= clone $sBrandsI18n;
            $sBrandsI18n->setSBrands(null);
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
        $this->url = null;
        $this->image = null;
        $this->position = null;
        $this->created = null;
        $this->updated = null;
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
            if ($this->collSProductss) {
                foreach ($this->collSProductss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collSBrandsI18ns) {
                foreach ($this->collSBrandsI18ns as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        // i18n behavior
        $this->currentLocale = 'ru';
        $this->currentTranslations = null;

        $this->collSProductss = null;
        $this->collSBrandsI18ns = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(SBrandsTableMap::DEFAULT_STRING_FORMAT);
    }

    // i18n behavior

    /**
     * Sets the locale for translations
     *
     * @param     string $locale Locale to use for the translation, e.g. 'fr_FR'
     *
     * @return    $this|ChildSBrands The current object (for fluent API support)
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
     * @return ChildSBrandsI18n */
    public function getTranslation($locale = 'ru', ConnectionInterface $con = null)
    {
        if (!isset($this->currentTranslations[$locale])) {
            if (null !== $this->collSBrandsI18ns) {
                foreach ($this->collSBrandsI18ns as $translation) {
                    if ($translation->getLocale() == $locale) {
                        $this->currentTranslations[$locale] = $translation;

                        return $translation;
                    }
                }
            }
            if ($this->isNew()) {
                $translation = new ChildSBrandsI18n();
                $translation->setLocale($locale);
            } else {
                $translation = ChildSBrandsI18nQuery::create()
                    ->filterByPrimaryKey(array($this->getPrimaryKey(), $locale))
                    ->findOneOrCreate($con);
                $this->currentTranslations[$locale] = $translation;
            }
            $this->addSBrandsI18n($translation);
        }

        return $this->currentTranslations[$locale];
    }

    /**
     * Remove the translation for a given locale
     *
     * @param     string $locale Locale to use for the translation, e.g. 'fr_FR'
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return    $this|ChildSBrands The current object (for fluent API support)
     */
    public function removeTranslation($locale = 'ru', ConnectionInterface $con = null)
    {
        if (!$this->isNew()) {
            ChildSBrandsI18nQuery::create()
                ->filterByPrimaryKey(array($this->getPrimaryKey(), $locale))
                ->delete($con);
        }
        if (isset($this->currentTranslations[$locale])) {
            unset($this->currentTranslations[$locale]);
        }
        foreach ($this->collSBrandsI18ns as $key => $translation) {
            if ($translation->getLocale() == $locale) {
                unset($this->collSBrandsI18ns[$key]);
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
     * @return ChildSBrandsI18n */
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
         * @return $this|\SBrandsI18n The current object (for fluent API support)
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
         * @return $this|\SBrandsI18n The current object (for fluent API support)
         */
        public function setDescription($v)
        {    $this->getCurrentTranslation()->setDescription($v);

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
         * @return $this|\SBrandsI18n The current object (for fluent API support)
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
         * @return $this|\SBrandsI18n The current object (for fluent API support)
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
         * @return $this|\SBrandsI18n The current object (for fluent API support)
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
