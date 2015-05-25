<?php

namespace Base;

use \SUserProfileQuery as ChildSUserProfileQuery;
use \DateTime;
use \Exception;
use \PDO;
use Map\SUserProfileTableMap;
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
use Propel\Runtime\Util\PropelDateTime;

/**
 * Base class that represents a row from the 'users' table.
 *
 *
 *
* @package    propel.generator..Base
*/
abstract class SUserProfile extends PropelBaseModelClass implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\SUserProfileTableMap';


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
     * The value for the role_id field.
     * @var        int
     */
    protected $role_id;

    /**
     * The value for the username field.
     * @var        string
     */
    protected $username;

    /**
     * The value for the password field.
     * @var        string
     */
    protected $password;

    /**
     * The value for the email field.
     * @var        string
     */
    protected $email;

    /**
     * The value for the address field.
     * @var        string
     */
    protected $address;

    /**
     * The value for the phone field.
     * @var        string
     */
    protected $phone;

    /**
     * The value for the banned field.
     * @var        int
     */
    protected $banned;

    /**
     * The value for the ban_reason field.
     * @var        string
     */
    protected $ban_reason;

    /**
     * The value for the newpass field.
     * @var        string
     */
    protected $newpass;

    /**
     * The value for the newpass_key field.
     * @var        string
     */
    protected $newpass_key;

    /**
     * The value for the newpass_time field.
     * @var        int
     */
    protected $newpass_time;

    /**
     * The value for the created field.
     * @var        int
     */
    protected $created;

    /**
     * The value for the last_ip field.
     * @var        string
     */
    protected $last_ip;

    /**
     * The value for the last_login field.
     * @var        int
     */
    protected $last_login;

    /**
     * The value for the modified field.
     * @var        \DateTime
     */
    protected $modified;

    /**
     * The value for the cart_data field.
     * @var        string
     */
    protected $cart_data;

    /**
     * The value for the wish_list_data field.
     * @var        string
     */
    protected $wish_list_data;

    /**
     * The value for the key field.
     * @var        string
     */
    protected $key;

    /**
     * The value for the amout field.
     * @var        string
     */
    protected $amout;

    /**
     * The value for the discount field.
     * @var        string
     */
    protected $discount;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * Initializes internal state of Base\SUserProfile object.
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
     * Compares this with another <code>SUserProfile</code> instance.  If
     * <code>obj</code> is an instance of <code>SUserProfile</code>, delegates to
     * <code>equals(SUserProfile)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|SUserProfile The current object, for fluid interface
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
     * Get the [role_id] column value.
     *
     * @return int
     */
    public function getRoleId()
    {
        return $this->role_id;
    }

    /**
     * Get the [username] column value.
     *
     * @return string
     */
    public function getName()
    {
        return $this->username;
    }

    /**
     * Get the [password] column value.
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Get the [email] column value.
     *
     * @return string
     */
    public function getUserEmail()
    {
        return $this->email;
    }

    /**
     * Get the [address] column value.
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Get the [phone] column value.
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Get the [banned] column value.
     *
     * @return int
     */
    public function getBanned()
    {
        return $this->banned;
    }

    /**
     * Get the [ban_reason] column value.
     *
     * @return string
     */
    public function getBanReason()
    {
        return $this->ban_reason;
    }

    /**
     * Get the [newpass] column value.
     *
     * @return string
     */
    public function getNewpass()
    {
        return $this->newpass;
    }

    /**
     * Get the [newpass_key] column value.
     *
     * @return string
     */
    public function getNewpassKey()
    {
        return $this->newpass_key;
    }

    /**
     * Get the [newpass_time] column value.
     *
     * @return int
     */
    public function getNewpassTime()
    {
        return $this->newpass_time;
    }

    /**
     * Get the [created] column value.
     *
     * @return int
     */
    public function getDateCreated()
    {
        return $this->created;
    }

    /**
     * Get the [last_ip] column value.
     *
     * @return string
     */
    public function getLastIp()
    {
        return $this->last_ip;
    }

    /**
     * Get the [last_login] column value.
     *
     * @return int
     */
    public function getLastLogin()
    {
        return $this->last_login;
    }

    /**
     * Get the [optionally formatted] temporal [modified] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getModified($format = NULL)
    {
        if ($format === null) {
            return $this->modified;
        } else {
            return $this->modified instanceof \DateTime ? $this->modified->format($format) : null;
        }
    }

    /**
     * Get the [cart_data] column value.
     *
     * @return string
     */
    public function getCartData()
    {
        return $this->cart_data;
    }

    /**
     * Get the [wish_list_data] column value.
     *
     * @return string
     */
    public function getWishListData()
    {
        return $this->wish_list_data;
    }

    /**
     * Get the [key] column value.
     *
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Get the [amout] column value.
     *
     * @return string
     */
    public function getAmout()
    {
        return $this->amout;
    }

    /**
     * Get the [discount] column value.
     *
     * @return string
     */
    public function getDiscount()
    {
        return $this->discount;
    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return $this|\SUserProfile The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[SUserProfileTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [role_id] column.
     *
     * @param int $v new value
     * @return $this|\SUserProfile The current object (for fluent API support)
     */
    public function setRoleId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->role_id !== $v) {
            $this->role_id = $v;
            $this->modifiedColumns[SUserProfileTableMap::COL_ROLE_ID] = true;
        }

        return $this;
    } // setRoleId()

    /**
     * Set the value of [username] column.
     *
     * @param string $v new value
     * @return $this|\SUserProfile The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->username !== $v) {
            $this->username = $v;
            $this->modifiedColumns[SUserProfileTableMap::COL_USERNAME] = true;
        }

        return $this;
    } // setName()

    /**
     * Set the value of [password] column.
     *
     * @param string $v new value
     * @return $this|\SUserProfile The current object (for fluent API support)
     */
    public function setPassword($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->password !== $v) {
            $this->password = $v;
            $this->modifiedColumns[SUserProfileTableMap::COL_PASSWORD] = true;
        }

        return $this;
    } // setPassword()

    /**
     * Set the value of [email] column.
     *
     * @param string $v new value
     * @return $this|\SUserProfile The current object (for fluent API support)
     */
    public function setUserEmail($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->email !== $v) {
            $this->email = $v;
            $this->modifiedColumns[SUserProfileTableMap::COL_EMAIL] = true;
        }

        return $this;
    } // setUserEmail()

    /**
     * Set the value of [address] column.
     *
     * @param string $v new value
     * @return $this|\SUserProfile The current object (for fluent API support)
     */
    public function setAddress($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->address !== $v) {
            $this->address = $v;
            $this->modifiedColumns[SUserProfileTableMap::COL_ADDRESS] = true;
        }

        return $this;
    } // setAddress()

    /**
     * Set the value of [phone] column.
     *
     * @param string $v new value
     * @return $this|\SUserProfile The current object (for fluent API support)
     */
    public function setPhone($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->phone !== $v) {
            $this->phone = $v;
            $this->modifiedColumns[SUserProfileTableMap::COL_PHONE] = true;
        }

        return $this;
    } // setPhone()

    /**
     * Set the value of [banned] column.
     *
     * @param int $v new value
     * @return $this|\SUserProfile The current object (for fluent API support)
     */
    public function setBanned($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->banned !== $v) {
            $this->banned = $v;
            $this->modifiedColumns[SUserProfileTableMap::COL_BANNED] = true;
        }

        return $this;
    } // setBanned()

    /**
     * Set the value of [ban_reason] column.
     *
     * @param string $v new value
     * @return $this|\SUserProfile The current object (for fluent API support)
     */
    public function setBanReason($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->ban_reason !== $v) {
            $this->ban_reason = $v;
            $this->modifiedColumns[SUserProfileTableMap::COL_BAN_REASON] = true;
        }

        return $this;
    } // setBanReason()

    /**
     * Set the value of [newpass] column.
     *
     * @param string $v new value
     * @return $this|\SUserProfile The current object (for fluent API support)
     */
    public function setNewpass($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->newpass !== $v) {
            $this->newpass = $v;
            $this->modifiedColumns[SUserProfileTableMap::COL_NEWPASS] = true;
        }

        return $this;
    } // setNewpass()

    /**
     * Set the value of [newpass_key] column.
     *
     * @param string $v new value
     * @return $this|\SUserProfile The current object (for fluent API support)
     */
    public function setNewpassKey($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->newpass_key !== $v) {
            $this->newpass_key = $v;
            $this->modifiedColumns[SUserProfileTableMap::COL_NEWPASS_KEY] = true;
        }

        return $this;
    } // setNewpassKey()

    /**
     * Set the value of [newpass_time] column.
     *
     * @param int $v new value
     * @return $this|\SUserProfile The current object (for fluent API support)
     */
    public function setNewpassTime($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->newpass_time !== $v) {
            $this->newpass_time = $v;
            $this->modifiedColumns[SUserProfileTableMap::COL_NEWPASS_TIME] = true;
        }

        return $this;
    } // setNewpassTime()

    /**
     * Set the value of [created] column.
     *
     * @param int $v new value
     * @return $this|\SUserProfile The current object (for fluent API support)
     */
    public function setDateCreated($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->created !== $v) {
            $this->created = $v;
            $this->modifiedColumns[SUserProfileTableMap::COL_CREATED] = true;
        }

        return $this;
    } // setDateCreated()

    /**
     * Set the value of [last_ip] column.
     *
     * @param string $v new value
     * @return $this|\SUserProfile The current object (for fluent API support)
     */
    public function setLastIp($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->last_ip !== $v) {
            $this->last_ip = $v;
            $this->modifiedColumns[SUserProfileTableMap::COL_LAST_IP] = true;
        }

        return $this;
    } // setLastIp()

    /**
     * Set the value of [last_login] column.
     *
     * @param int $v new value
     * @return $this|\SUserProfile The current object (for fluent API support)
     */
    public function setLastLogin($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->last_login !== $v) {
            $this->last_login = $v;
            $this->modifiedColumns[SUserProfileTableMap::COL_LAST_LOGIN] = true;
        }

        return $this;
    } // setLastLogin()

    /**
     * Sets the value of [modified] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\SUserProfile The current object (for fluent API support)
     */
    public function setModified($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->modified !== null || $dt !== null) {
            if ($dt !== $this->modified) {
                $this->modified = $dt;
                $this->modifiedColumns[SUserProfileTableMap::COL_MODIFIED] = true;
            }
        } // if either are not null

        return $this;
    } // setModified()

    /**
     * Set the value of [cart_data] column.
     *
     * @param string $v new value
     * @return $this|\SUserProfile The current object (for fluent API support)
     */
    public function setCartData($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->cart_data !== $v) {
            $this->cart_data = $v;
            $this->modifiedColumns[SUserProfileTableMap::COL_CART_DATA] = true;
        }

        return $this;
    } // setCartData()

    /**
     * Set the value of [wish_list_data] column.
     *
     * @param string $v new value
     * @return $this|\SUserProfile The current object (for fluent API support)
     */
    public function setWishListData($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->wish_list_data !== $v) {
            $this->wish_list_data = $v;
            $this->modifiedColumns[SUserProfileTableMap::COL_WISH_LIST_DATA] = true;
        }

        return $this;
    } // setWishListData()

    /**
     * Set the value of [key] column.
     *
     * @param string $v new value
     * @return $this|\SUserProfile The current object (for fluent API support)
     */
    public function setKey($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->key !== $v) {
            $this->key = $v;
            $this->modifiedColumns[SUserProfileTableMap::COL_KEY] = true;
        }

        return $this;
    } // setKey()

    /**
     * Set the value of [amout] column.
     *
     * @param string $v new value
     * @return $this|\SUserProfile The current object (for fluent API support)
     */
    public function setAmout($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->amout !== $v) {
            $this->amout = $v;
            $this->modifiedColumns[SUserProfileTableMap::COL_AMOUT] = true;
        }

        return $this;
    } // setAmout()

    /**
     * Set the value of [discount] column.
     *
     * @param string $v new value
     * @return $this|\SUserProfile The current object (for fluent API support)
     */
    public function setDiscount($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->discount !== $v) {
            $this->discount = $v;
            $this->modifiedColumns[SUserProfileTableMap::COL_DISCOUNT] = true;
        }

        return $this;
    } // setDiscount()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : SUserProfileTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : SUserProfileTableMap::translateFieldName('RoleId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->role_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : SUserProfileTableMap::translateFieldName('Name', TableMap::TYPE_PHPNAME, $indexType)];
            $this->username = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : SUserProfileTableMap::translateFieldName('Password', TableMap::TYPE_PHPNAME, $indexType)];
            $this->password = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : SUserProfileTableMap::translateFieldName('UserEmail', TableMap::TYPE_PHPNAME, $indexType)];
            $this->email = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : SUserProfileTableMap::translateFieldName('Address', TableMap::TYPE_PHPNAME, $indexType)];
            $this->address = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : SUserProfileTableMap::translateFieldName('Phone', TableMap::TYPE_PHPNAME, $indexType)];
            $this->phone = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : SUserProfileTableMap::translateFieldName('Banned', TableMap::TYPE_PHPNAME, $indexType)];
            $this->banned = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : SUserProfileTableMap::translateFieldName('BanReason', TableMap::TYPE_PHPNAME, $indexType)];
            $this->ban_reason = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : SUserProfileTableMap::translateFieldName('Newpass', TableMap::TYPE_PHPNAME, $indexType)];
            $this->newpass = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 10 + $startcol : SUserProfileTableMap::translateFieldName('NewpassKey', TableMap::TYPE_PHPNAME, $indexType)];
            $this->newpass_key = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 11 + $startcol : SUserProfileTableMap::translateFieldName('NewpassTime', TableMap::TYPE_PHPNAME, $indexType)];
            $this->newpass_time = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 12 + $startcol : SUserProfileTableMap::translateFieldName('DateCreated', TableMap::TYPE_PHPNAME, $indexType)];
            $this->created = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 13 + $startcol : SUserProfileTableMap::translateFieldName('LastIp', TableMap::TYPE_PHPNAME, $indexType)];
            $this->last_ip = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 14 + $startcol : SUserProfileTableMap::translateFieldName('LastLogin', TableMap::TYPE_PHPNAME, $indexType)];
            $this->last_login = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 15 + $startcol : SUserProfileTableMap::translateFieldName('Modified', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->modified = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 16 + $startcol : SUserProfileTableMap::translateFieldName('CartData', TableMap::TYPE_PHPNAME, $indexType)];
            $this->cart_data = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 17 + $startcol : SUserProfileTableMap::translateFieldName('WishListData', TableMap::TYPE_PHPNAME, $indexType)];
            $this->wish_list_data = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 18 + $startcol : SUserProfileTableMap::translateFieldName('Key', TableMap::TYPE_PHPNAME, $indexType)];
            $this->key = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 19 + $startcol : SUserProfileTableMap::translateFieldName('Amout', TableMap::TYPE_PHPNAME, $indexType)];
            $this->amout = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 20 + $startcol : SUserProfileTableMap::translateFieldName('Discount', TableMap::TYPE_PHPNAME, $indexType)];
            $this->discount = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 21; // 21 = SUserProfileTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\SUserProfile'), 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(SUserProfileTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildSUserProfileQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see SUserProfile::setDeleted()
     * @see SUserProfile::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(SUserProfileTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildSUserProfileQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(SUserProfileTableMap::DATABASE_NAME);
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
                SUserProfileTableMap::addInstanceToPool($this);
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

        $this->modifiedColumns[SUserProfileTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . SUserProfileTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(SUserProfileTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(SUserProfileTableMap::COL_ROLE_ID)) {
            $modifiedColumns[':p' . $index++]  = 'role_id';
        }
        if ($this->isColumnModified(SUserProfileTableMap::COL_USERNAME)) {
            $modifiedColumns[':p' . $index++]  = 'username';
        }
        if ($this->isColumnModified(SUserProfileTableMap::COL_PASSWORD)) {
            $modifiedColumns[':p' . $index++]  = 'password';
        }
        if ($this->isColumnModified(SUserProfileTableMap::COL_EMAIL)) {
            $modifiedColumns[':p' . $index++]  = 'email';
        }
        if ($this->isColumnModified(SUserProfileTableMap::COL_ADDRESS)) {
            $modifiedColumns[':p' . $index++]  = 'address';
        }
        if ($this->isColumnModified(SUserProfileTableMap::COL_PHONE)) {
            $modifiedColumns[':p' . $index++]  = 'phone';
        }
        if ($this->isColumnModified(SUserProfileTableMap::COL_BANNED)) {
            $modifiedColumns[':p' . $index++]  = 'banned';
        }
        if ($this->isColumnModified(SUserProfileTableMap::COL_BAN_REASON)) {
            $modifiedColumns[':p' . $index++]  = 'ban_reason';
        }
        if ($this->isColumnModified(SUserProfileTableMap::COL_NEWPASS)) {
            $modifiedColumns[':p' . $index++]  = 'newpass';
        }
        if ($this->isColumnModified(SUserProfileTableMap::COL_NEWPASS_KEY)) {
            $modifiedColumns[':p' . $index++]  = 'newpass_key';
        }
        if ($this->isColumnModified(SUserProfileTableMap::COL_NEWPASS_TIME)) {
            $modifiedColumns[':p' . $index++]  = 'newpass_time';
        }
        if ($this->isColumnModified(SUserProfileTableMap::COL_CREATED)) {
            $modifiedColumns[':p' . $index++]  = 'created';
        }
        if ($this->isColumnModified(SUserProfileTableMap::COL_LAST_IP)) {
            $modifiedColumns[':p' . $index++]  = 'last_ip';
        }
        if ($this->isColumnModified(SUserProfileTableMap::COL_LAST_LOGIN)) {
            $modifiedColumns[':p' . $index++]  = 'last_login';
        }
        if ($this->isColumnModified(SUserProfileTableMap::COL_MODIFIED)) {
            $modifiedColumns[':p' . $index++]  = 'modified';
        }
        if ($this->isColumnModified(SUserProfileTableMap::COL_CART_DATA)) {
            $modifiedColumns[':p' . $index++]  = 'cart_data';
        }
        if ($this->isColumnModified(SUserProfileTableMap::COL_WISH_LIST_DATA)) {
            $modifiedColumns[':p' . $index++]  = 'wish_list_data';
        }
        if ($this->isColumnModified(SUserProfileTableMap::COL_KEY)) {
            $modifiedColumns[':p' . $index++]  = 'key';
        }
        if ($this->isColumnModified(SUserProfileTableMap::COL_AMOUT)) {
            $modifiedColumns[':p' . $index++]  = 'amout';
        }
        if ($this->isColumnModified(SUserProfileTableMap::COL_DISCOUNT)) {
            $modifiedColumns[':p' . $index++]  = 'discount';
        }

        $sql = sprintf(
            'INSERT INTO users (%s) VALUES (%s)',
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
                    case 'role_id':
                        $stmt->bindValue($identifier, $this->role_id, PDO::PARAM_INT);
                        break;
                    case 'username':
                        $stmt->bindValue($identifier, $this->username, PDO::PARAM_STR);
                        break;
                    case 'password':
                        $stmt->bindValue($identifier, $this->password, PDO::PARAM_STR);
                        break;
                    case 'email':
                        $stmt->bindValue($identifier, $this->email, PDO::PARAM_STR);
                        break;
                    case 'address':
                        $stmt->bindValue($identifier, $this->address, PDO::PARAM_STR);
                        break;
                    case 'phone':
                        $stmt->bindValue($identifier, $this->phone, PDO::PARAM_STR);
                        break;
                    case 'banned':
                        $stmt->bindValue($identifier, $this->banned, PDO::PARAM_INT);
                        break;
                    case 'ban_reason':
                        $stmt->bindValue($identifier, $this->ban_reason, PDO::PARAM_STR);
                        break;
                    case 'newpass':
                        $stmt->bindValue($identifier, $this->newpass, PDO::PARAM_STR);
                        break;
                    case 'newpass_key':
                        $stmt->bindValue($identifier, $this->newpass_key, PDO::PARAM_STR);
                        break;
                    case 'newpass_time':
                        $stmt->bindValue($identifier, $this->newpass_time, PDO::PARAM_INT);
                        break;
                    case 'created':
                        $stmt->bindValue($identifier, $this->created, PDO::PARAM_INT);
                        break;
                    case 'last_ip':
                        $stmt->bindValue($identifier, $this->last_ip, PDO::PARAM_STR);
                        break;
                    case 'last_login':
                        $stmt->bindValue($identifier, $this->last_login, PDO::PARAM_INT);
                        break;
                    case 'modified':
                        $stmt->bindValue($identifier, $this->modified ? $this->modified->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case 'cart_data':
                        $stmt->bindValue($identifier, $this->cart_data, PDO::PARAM_STR);
                        break;
                    case 'wish_list_data':
                        $stmt->bindValue($identifier, $this->wish_list_data, PDO::PARAM_STR);
                        break;
                    case 'key':
                        $stmt->bindValue($identifier, $this->key, PDO::PARAM_STR);
                        break;
                    case 'amout':
                        $stmt->bindValue($identifier, $this->amout, PDO::PARAM_STR);
                        break;
                    case 'discount':
                        $stmt->bindValue($identifier, $this->discount, PDO::PARAM_STR);
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
        $pos = SUserProfileTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getRoleId();
                break;
            case 2:
                return $this->getName();
                break;
            case 3:
                return $this->getPassword();
                break;
            case 4:
                return $this->getUserEmail();
                break;
            case 5:
                return $this->getAddress();
                break;
            case 6:
                return $this->getPhone();
                break;
            case 7:
                return $this->getBanned();
                break;
            case 8:
                return $this->getBanReason();
                break;
            case 9:
                return $this->getNewpass();
                break;
            case 10:
                return $this->getNewpassKey();
                break;
            case 11:
                return $this->getNewpassTime();
                break;
            case 12:
                return $this->getDateCreated();
                break;
            case 13:
                return $this->getLastIp();
                break;
            case 14:
                return $this->getLastLogin();
                break;
            case 15:
                return $this->getModified();
                break;
            case 16:
                return $this->getCartData();
                break;
            case 17:
                return $this->getWishListData();
                break;
            case 18:
                return $this->getKey();
                break;
            case 19:
                return $this->getAmout();
                break;
            case 20:
                return $this->getDiscount();
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
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = TableMap::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array())
    {

        if (isset($alreadyDumpedObjects['SUserProfile'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['SUserProfile'][$this->hashCode()] = true;
        $keys = SUserProfileTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getRoleId(),
            $keys[2] => $this->getName(),
            $keys[3] => $this->getPassword(),
            $keys[4] => $this->getUserEmail(),
            $keys[5] => $this->getAddress(),
            $keys[6] => $this->getPhone(),
            $keys[7] => $this->getBanned(),
            $keys[8] => $this->getBanReason(),
            $keys[9] => $this->getNewpass(),
            $keys[10] => $this->getNewpassKey(),
            $keys[11] => $this->getNewpassTime(),
            $keys[12] => $this->getDateCreated(),
            $keys[13] => $this->getLastIp(),
            $keys[14] => $this->getLastLogin(),
            $keys[15] => $this->getModified(),
            $keys[16] => $this->getCartData(),
            $keys[17] => $this->getWishListData(),
            $keys[18] => $this->getKey(),
            $keys[19] => $this->getAmout(),
            $keys[20] => $this->getDiscount(),
        );

        $utc = new \DateTimeZone('utc');
        if ($result[$keys[15]] instanceof \DateTime) {
            // When changing timezone we don't want to change existing instances
            $dateTime = clone $result[$keys[15]];
            $result[$keys[15]] = $dateTime->setTimezone($utc)->format('Y-m-d\TH:i:s\Z');
        }

        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
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
     * @return $this|\SUserProfile
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = SUserProfileTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\SUserProfile
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setRoleId($value);
                break;
            case 2:
                $this->setName($value);
                break;
            case 3:
                $this->setPassword($value);
                break;
            case 4:
                $this->setUserEmail($value);
                break;
            case 5:
                $this->setAddress($value);
                break;
            case 6:
                $this->setPhone($value);
                break;
            case 7:
                $this->setBanned($value);
                break;
            case 8:
                $this->setBanReason($value);
                break;
            case 9:
                $this->setNewpass($value);
                break;
            case 10:
                $this->setNewpassKey($value);
                break;
            case 11:
                $this->setNewpassTime($value);
                break;
            case 12:
                $this->setDateCreated($value);
                break;
            case 13:
                $this->setLastIp($value);
                break;
            case 14:
                $this->setLastLogin($value);
                break;
            case 15:
                $this->setModified($value);
                break;
            case 16:
                $this->setCartData($value);
                break;
            case 17:
                $this->setWishListData($value);
                break;
            case 18:
                $this->setKey($value);
                break;
            case 19:
                $this->setAmout($value);
                break;
            case 20:
                $this->setDiscount($value);
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
        $keys = SUserProfileTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setRoleId($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setName($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setPassword($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setUserEmail($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setAddress($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setPhone($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setBanned($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setBanReason($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setNewpass($arr[$keys[9]]);
        }
        if (array_key_exists($keys[10], $arr)) {
            $this->setNewpassKey($arr[$keys[10]]);
        }
        if (array_key_exists($keys[11], $arr)) {
            $this->setNewpassTime($arr[$keys[11]]);
        }
        if (array_key_exists($keys[12], $arr)) {
            $this->setDateCreated($arr[$keys[12]]);
        }
        if (array_key_exists($keys[13], $arr)) {
            $this->setLastIp($arr[$keys[13]]);
        }
        if (array_key_exists($keys[14], $arr)) {
            $this->setLastLogin($arr[$keys[14]]);
        }
        if (array_key_exists($keys[15], $arr)) {
            $this->setModified($arr[$keys[15]]);
        }
        if (array_key_exists($keys[16], $arr)) {
            $this->setCartData($arr[$keys[16]]);
        }
        if (array_key_exists($keys[17], $arr)) {
            $this->setWishListData($arr[$keys[17]]);
        }
        if (array_key_exists($keys[18], $arr)) {
            $this->setKey($arr[$keys[18]]);
        }
        if (array_key_exists($keys[19], $arr)) {
            $this->setAmout($arr[$keys[19]]);
        }
        if (array_key_exists($keys[20], $arr)) {
            $this->setDiscount($arr[$keys[20]]);
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
     * @return $this|\SUserProfile The current object, for fluid interface
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
        $criteria = new Criteria(SUserProfileTableMap::DATABASE_NAME);

        if ($this->isColumnModified(SUserProfileTableMap::COL_ID)) {
            $criteria->add(SUserProfileTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(SUserProfileTableMap::COL_ROLE_ID)) {
            $criteria->add(SUserProfileTableMap::COL_ROLE_ID, $this->role_id);
        }
        if ($this->isColumnModified(SUserProfileTableMap::COL_USERNAME)) {
            $criteria->add(SUserProfileTableMap::COL_USERNAME, $this->username);
        }
        if ($this->isColumnModified(SUserProfileTableMap::COL_PASSWORD)) {
            $criteria->add(SUserProfileTableMap::COL_PASSWORD, $this->password);
        }
        if ($this->isColumnModified(SUserProfileTableMap::COL_EMAIL)) {
            $criteria->add(SUserProfileTableMap::COL_EMAIL, $this->email);
        }
        if ($this->isColumnModified(SUserProfileTableMap::COL_ADDRESS)) {
            $criteria->add(SUserProfileTableMap::COL_ADDRESS, $this->address);
        }
        if ($this->isColumnModified(SUserProfileTableMap::COL_PHONE)) {
            $criteria->add(SUserProfileTableMap::COL_PHONE, $this->phone);
        }
        if ($this->isColumnModified(SUserProfileTableMap::COL_BANNED)) {
            $criteria->add(SUserProfileTableMap::COL_BANNED, $this->banned);
        }
        if ($this->isColumnModified(SUserProfileTableMap::COL_BAN_REASON)) {
            $criteria->add(SUserProfileTableMap::COL_BAN_REASON, $this->ban_reason);
        }
        if ($this->isColumnModified(SUserProfileTableMap::COL_NEWPASS)) {
            $criteria->add(SUserProfileTableMap::COL_NEWPASS, $this->newpass);
        }
        if ($this->isColumnModified(SUserProfileTableMap::COL_NEWPASS_KEY)) {
            $criteria->add(SUserProfileTableMap::COL_NEWPASS_KEY, $this->newpass_key);
        }
        if ($this->isColumnModified(SUserProfileTableMap::COL_NEWPASS_TIME)) {
            $criteria->add(SUserProfileTableMap::COL_NEWPASS_TIME, $this->newpass_time);
        }
        if ($this->isColumnModified(SUserProfileTableMap::COL_CREATED)) {
            $criteria->add(SUserProfileTableMap::COL_CREATED, $this->created);
        }
        if ($this->isColumnModified(SUserProfileTableMap::COL_LAST_IP)) {
            $criteria->add(SUserProfileTableMap::COL_LAST_IP, $this->last_ip);
        }
        if ($this->isColumnModified(SUserProfileTableMap::COL_LAST_LOGIN)) {
            $criteria->add(SUserProfileTableMap::COL_LAST_LOGIN, $this->last_login);
        }
        if ($this->isColumnModified(SUserProfileTableMap::COL_MODIFIED)) {
            $criteria->add(SUserProfileTableMap::COL_MODIFIED, $this->modified);
        }
        if ($this->isColumnModified(SUserProfileTableMap::COL_CART_DATA)) {
            $criteria->add(SUserProfileTableMap::COL_CART_DATA, $this->cart_data);
        }
        if ($this->isColumnModified(SUserProfileTableMap::COL_WISH_LIST_DATA)) {
            $criteria->add(SUserProfileTableMap::COL_WISH_LIST_DATA, $this->wish_list_data);
        }
        if ($this->isColumnModified(SUserProfileTableMap::COL_KEY)) {
            $criteria->add(SUserProfileTableMap::COL_KEY, $this->key);
        }
        if ($this->isColumnModified(SUserProfileTableMap::COL_AMOUT)) {
            $criteria->add(SUserProfileTableMap::COL_AMOUT, $this->amout);
        }
        if ($this->isColumnModified(SUserProfileTableMap::COL_DISCOUNT)) {
            $criteria->add(SUserProfileTableMap::COL_DISCOUNT, $this->discount);
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
        $criteria = ChildSUserProfileQuery::create();
        $criteria->add(SUserProfileTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \SUserProfile (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setRoleId($this->getRoleId());
        $copyObj->setName($this->getName());
        $copyObj->setPassword($this->getPassword());
        $copyObj->setUserEmail($this->getUserEmail());
        $copyObj->setAddress($this->getAddress());
        $copyObj->setPhone($this->getPhone());
        $copyObj->setBanned($this->getBanned());
        $copyObj->setBanReason($this->getBanReason());
        $copyObj->setNewpass($this->getNewpass());
        $copyObj->setNewpassKey($this->getNewpassKey());
        $copyObj->setNewpassTime($this->getNewpassTime());
        $copyObj->setDateCreated($this->getDateCreated());
        $copyObj->setLastIp($this->getLastIp());
        $copyObj->setLastLogin($this->getLastLogin());
        $copyObj->setModified($this->getModified());
        $copyObj->setCartData($this->getCartData());
        $copyObj->setWishListData($this->getWishListData());
        $copyObj->setKey($this->getKey());
        $copyObj->setAmout($this->getAmout());
        $copyObj->setDiscount($this->getDiscount());
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
     * @return \SUserProfile Clone of current object.
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
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        $this->id = null;
        $this->role_id = null;
        $this->username = null;
        $this->password = null;
        $this->email = null;
        $this->address = null;
        $this->phone = null;
        $this->banned = null;
        $this->ban_reason = null;
        $this->newpass = null;
        $this->newpass_key = null;
        $this->newpass_time = null;
        $this->created = null;
        $this->last_ip = null;
        $this->last_login = null;
        $this->modified = null;
        $this->cart_data = null;
        $this->wish_list_data = null;
        $this->key = null;
        $this->amout = null;
        $this->discount = null;
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

    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(SUserProfileTableMap::DEFAULT_STRING_FORMAT);
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
