<?php

namespace Base;

use \SDeliveryMethods as ChildSDeliveryMethods;
use \SDeliveryMethodsQuery as ChildSDeliveryMethodsQuery;
use \SOrderProducts as ChildSOrderProducts;
use \SOrderProductsQuery as ChildSOrderProductsQuery;
use \SOrderStatusHistory as ChildSOrderStatusHistory;
use \SOrderStatusHistoryQuery as ChildSOrderStatusHistoryQuery;
use \SOrderStatuses as ChildSOrderStatuses;
use \SOrderStatusesQuery as ChildSOrderStatusesQuery;
use \SOrders as ChildSOrders;
use \SOrdersQuery as ChildSOrdersQuery;
use \SPaymentMethods as ChildSPaymentMethods;
use \SPaymentMethodsQuery as ChildSPaymentMethodsQuery;
use \Exception;
use \PDO;
use Map\SOrdersTableMap;
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
 * Base class that represents a row from the 'shop_orders' table.
 *
 *
 *
* @package    propel.generator..Base
*/
abstract class SOrders extends PropelBaseModelClass implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\SOrdersTableMap';


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
     * The value for the user_id field.
     * @var        int
     */
    protected $user_id;

    /**
     * The value for the order_key field.
     * @var        string
     */
    protected $order_key;

    /**
     * The value for the delivery_method field.
     * @var        int
     */
    protected $delivery_method;

    /**
     * The value for the delivery_price field.
     * @var        string
     */
    protected $delivery_price;

    /**
     * The value for the payment_method field.
     * @var        int
     */
    protected $payment_method;

    /**
     * The value for the status field.
     * @var        int
     */
    protected $status;

    /**
     * The value for the paid field.
     * @var        boolean
     */
    protected $paid;

    /**
     * The value for the user_full_name field.
     * @var        string
     */
    protected $user_full_name;

    /**
     * The value for the user_surname field.
     * @var        string
     */
    protected $user_surname;

    /**
     * The value for the user_email field.
     * @var        string
     */
    protected $user_email;

    /**
     * The value for the user_phone field.
     * @var        string
     */
    protected $user_phone;

    /**
     * The value for the user_deliver_to field.
     * @var        string
     */
    protected $user_deliver_to;

    /**
     * The value for the user_comment field.
     * @var        string
     */
    protected $user_comment;

    /**
     * The value for the date_created field.
     * @var        int
     */
    protected $date_created;

    /**
     * The value for the date_updated field.
     * @var        int
     */
    protected $date_updated;

    /**
     * The value for the user_ip field.
     * @var        string
     */
    protected $user_ip;

    /**
     * The value for the total_price field.
     * @var        string
     */
    protected $total_price;

    /**
     * The value for the external_id field.
     * @var        string
     */
    protected $external_id;

    /**
     * The value for the gift_cert_key field.
     * @var        string
     */
    protected $gift_cert_key;

    /**
     * The value for the discount field.
     * @var        double
     */
    protected $discount;

    /**
     * The value for the gift_cert_price field.
     * @var        double
     */
    protected $gift_cert_price;

    /**
     * The value for the discount_info field.
     * @var        string
     */
    protected $discount_info;

    /**
     * The value for the origin_price field.
     * @var        double
     */
    protected $origin_price;

    /**
     * The value for the comulativ field.
     * @var        double
     */
    protected $comulativ;

    /**
     * @var        ChildSDeliveryMethods
     */
    protected $aSDeliveryMethods;

    /**
     * @var        ChildSPaymentMethods
     */
    protected $aSPaymentMethods;

    /**
     * @var        ChildSOrderStatuses
     */
    protected $aSOrderStatuses;

    /**
     * @var        ObjectCollection|ChildSOrderProducts[] Collection to store aggregation of ChildSOrderProducts objects.
     */
    protected $collSOrderProductss;
    protected $collSOrderProductssPartial;

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

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildSOrderProducts[]
     */
    protected $sOrderProductssScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildSOrderStatusHistory[]
     */
    protected $sOrderStatusHistoriesScheduledForDeletion = null;

    /**
     * Initializes internal state of Base\SOrders object.
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
     * Compares this with another <code>SOrders</code> instance.  If
     * <code>obj</code> is an instance of <code>SOrders</code>, delegates to
     * <code>equals(SOrders)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|SOrders The current object, for fluid interface
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
     * Get the [user_id] column value.
     *
     * @return int
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * Get the [order_key] column value.
     *
     * @return string
     */
    public function getKey()
    {
        return $this->order_key;
    }

    /**
     * Get the [delivery_method] column value.
     *
     * @return int
     */
    public function getDeliveryMethod()
    {
        return $this->delivery_method;
    }

    /**
     * Get the [delivery_price] column value.
     *
     * @return string
     */
    public function getDeliveryPrice()
    {
        return $this->delivery_price;
    }

    /**
     * Get the [payment_method] column value.
     *
     * @return int
     */
    public function getPaymentMethod()
    {
        return $this->payment_method;
    }

    /**
     * Get the [status] column value.
     *
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Get the [paid] column value.
     *
     * @return boolean
     */
    public function getPaid()
    {
        return $this->paid;
    }

    /**
     * Get the [paid] column value.
     *
     * @return boolean
     */
    public function isPaid()
    {
        return $this->getPaid();
    }

    /**
     * Get the [user_full_name] column value.
     *
     * @return string
     */
    public function getUserFullName()
    {
        return $this->user_full_name;
    }

    /**
     * Get the [user_surname] column value.
     *
     * @return string
     */
    public function getUserSurname()
    {
        return $this->user_surname;
    }

    /**
     * Get the [user_email] column value.
     *
     * @return string
     */
    public function getUserEmail()
    {
        return $this->user_email;
    }

    /**
     * Get the [user_phone] column value.
     *
     * @return string
     */
    public function getUserPhone()
    {
        return $this->user_phone;
    }

    /**
     * Get the [user_deliver_to] column value.
     *
     * @return string
     */
    public function getUserDeliverTo()
    {
        return $this->user_deliver_to;
    }

    /**
     * Get the [user_comment] column value.
     *
     * @return string
     */
    public function getUserComment()
    {
        return $this->user_comment;
    }

    /**
     * Get the [date_created] column value.
     *
     * @return int
     */
    public function getDateCreated()
    {
        return $this->date_created;
    }

    /**
     * Get the [date_updated] column value.
     *
     * @return int
     */
    public function getDateUpdated()
    {
        return $this->date_updated;
    }

    /**
     * Get the [user_ip] column value.
     *
     * @return string
     */
    public function getUserIp()
    {
        return $this->user_ip;
    }

    /**
     * Get the [total_price] column value.
     *
     * @return string
     */
    public function getTotalPrice()
    {
        return $this->total_price;
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
     * Get the [gift_cert_key] column value.
     *
     * @return string
     */
    public function getGiftCertKey()
    {
        return $this->gift_cert_key;
    }

    /**
     * Get the [discount] column value.
     *
     * @return double
     */
    public function getDiscount()
    {
        return $this->discount;
    }

    /**
     * Get the [gift_cert_price] column value.
     *
     * @return double
     */
    public function getGiftCertPrice()
    {
        return $this->gift_cert_price;
    }

    /**
     * Get the [discount_info] column value.
     *
     * @return string
     */
    public function getDiscountInfo()
    {
        return $this->discount_info;
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
     * Get the [comulativ] column value.
     *
     * @return double
     */
    public function getComulativ()
    {
        return $this->comulativ;
    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return $this|\SOrders The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[SOrdersTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [user_id] column.
     *
     * @param int $v new value
     * @return $this|\SOrders The current object (for fluent API support)
     */
    public function setUserId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->user_id !== $v) {
            $this->user_id = $v;
            $this->modifiedColumns[SOrdersTableMap::COL_USER_ID] = true;
        }

        return $this;
    } // setUserId()

    /**
     * Set the value of [order_key] column.
     *
     * @param string $v new value
     * @return $this|\SOrders The current object (for fluent API support)
     */
    public function setKey($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->order_key !== $v) {
            $this->order_key = $v;
            $this->modifiedColumns[SOrdersTableMap::COL_ORDER_KEY] = true;
        }

        return $this;
    } // setKey()

    /**
     * Set the value of [delivery_method] column.
     *
     * @param int $v new value
     * @return $this|\SOrders The current object (for fluent API support)
     */
    public function setDeliveryMethod($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->delivery_method !== $v) {
            $this->delivery_method = $v;
            $this->modifiedColumns[SOrdersTableMap::COL_DELIVERY_METHOD] = true;
        }

        if ($this->aSDeliveryMethods !== null && $this->aSDeliveryMethods->getId() !== $v) {
            $this->aSDeliveryMethods = null;
        }

        return $this;
    } // setDeliveryMethod()

    /**
     * Set the value of [delivery_price] column.
     *
     * @param string $v new value
     * @return $this|\SOrders The current object (for fluent API support)
     */
    public function setDeliveryPrice($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->delivery_price !== $v) {
            $this->delivery_price = $v;
            $this->modifiedColumns[SOrdersTableMap::COL_DELIVERY_PRICE] = true;
        }

        return $this;
    } // setDeliveryPrice()

    /**
     * Set the value of [payment_method] column.
     *
     * @param int $v new value
     * @return $this|\SOrders The current object (for fluent API support)
     */
    public function setPaymentMethod($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->payment_method !== $v) {
            $this->payment_method = $v;
            $this->modifiedColumns[SOrdersTableMap::COL_PAYMENT_METHOD] = true;
        }

        if ($this->aSPaymentMethods !== null && $this->aSPaymentMethods->getId() !== $v) {
            $this->aSPaymentMethods = null;
        }

        return $this;
    } // setPaymentMethod()

    /**
     * Set the value of [status] column.
     *
     * @param int $v new value
     * @return $this|\SOrders The current object (for fluent API support)
     */
    public function setStatus($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->status !== $v) {
            $this->status = $v;
            $this->modifiedColumns[SOrdersTableMap::COL_STATUS] = true;
        }

        if ($this->aSOrderStatuses !== null && $this->aSOrderStatuses->getId() !== $v) {
            $this->aSOrderStatuses = null;
        }

        return $this;
    } // setStatus()

    /**
     * Sets the value of the [paid] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\SOrders The current object (for fluent API support)
     */
    public function setPaid($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->paid !== $v) {
            $this->paid = $v;
            $this->modifiedColumns[SOrdersTableMap::COL_PAID] = true;
        }

        return $this;
    } // setPaid()

    /**
     * Set the value of [user_full_name] column.
     *
     * @param string $v new value
     * @return $this|\SOrders The current object (for fluent API support)
     */
    public function setUserFullName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->user_full_name !== $v) {
            $this->user_full_name = $v;
            $this->modifiedColumns[SOrdersTableMap::COL_USER_FULL_NAME] = true;
        }

        return $this;
    } // setUserFullName()

    /**
     * Set the value of [user_surname] column.
     *
     * @param string $v new value
     * @return $this|\SOrders The current object (for fluent API support)
     */
    public function setUserSurname($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->user_surname !== $v) {
            $this->user_surname = $v;
            $this->modifiedColumns[SOrdersTableMap::COL_USER_SURNAME] = true;
        }

        return $this;
    } // setUserSurname()

    /**
     * Set the value of [user_email] column.
     *
     * @param string $v new value
     * @return $this|\SOrders The current object (for fluent API support)
     */
    public function setUserEmail($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->user_email !== $v) {
            $this->user_email = $v;
            $this->modifiedColumns[SOrdersTableMap::COL_USER_EMAIL] = true;
        }

        return $this;
    } // setUserEmail()

    /**
     * Set the value of [user_phone] column.
     *
     * @param string $v new value
     * @return $this|\SOrders The current object (for fluent API support)
     */
    public function setUserPhone($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->user_phone !== $v) {
            $this->user_phone = $v;
            $this->modifiedColumns[SOrdersTableMap::COL_USER_PHONE] = true;
        }

        return $this;
    } // setUserPhone()

    /**
     * Set the value of [user_deliver_to] column.
     *
     * @param string $v new value
     * @return $this|\SOrders The current object (for fluent API support)
     */
    public function setUserDeliverTo($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->user_deliver_to !== $v) {
            $this->user_deliver_to = $v;
            $this->modifiedColumns[SOrdersTableMap::COL_USER_DELIVER_TO] = true;
        }

        return $this;
    } // setUserDeliverTo()

    /**
     * Set the value of [user_comment] column.
     *
     * @param string $v new value
     * @return $this|\SOrders The current object (for fluent API support)
     */
    public function setUserComment($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->user_comment !== $v) {
            $this->user_comment = $v;
            $this->modifiedColumns[SOrdersTableMap::COL_USER_COMMENT] = true;
        }

        return $this;
    } // setUserComment()

    /**
     * Set the value of [date_created] column.
     *
     * @param int $v new value
     * @return $this|\SOrders The current object (for fluent API support)
     */
    public function setDateCreated($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->date_created !== $v) {
            $this->date_created = $v;
            $this->modifiedColumns[SOrdersTableMap::COL_DATE_CREATED] = true;
        }

        return $this;
    } // setDateCreated()

    /**
     * Set the value of [date_updated] column.
     *
     * @param int $v new value
     * @return $this|\SOrders The current object (for fluent API support)
     */
    public function setDateUpdated($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->date_updated !== $v) {
            $this->date_updated = $v;
            $this->modifiedColumns[SOrdersTableMap::COL_DATE_UPDATED] = true;
        }

        return $this;
    } // setDateUpdated()

    /**
     * Set the value of [user_ip] column.
     *
     * @param string $v new value
     * @return $this|\SOrders The current object (for fluent API support)
     */
    public function setUserIp($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->user_ip !== $v) {
            $this->user_ip = $v;
            $this->modifiedColumns[SOrdersTableMap::COL_USER_IP] = true;
        }

        return $this;
    } // setUserIp()

    /**
     * Set the value of [total_price] column.
     *
     * @param string $v new value
     * @return $this|\SOrders The current object (for fluent API support)
     */
    public function setTotalPrice($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->total_price !== $v) {
            $this->total_price = $v;
            $this->modifiedColumns[SOrdersTableMap::COL_TOTAL_PRICE] = true;
        }

        return $this;
    } // setTotalPrice()

    /**
     * Set the value of [external_id] column.
     *
     * @param string $v new value
     * @return $this|\SOrders The current object (for fluent API support)
     */
    public function setExternalId($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->external_id !== $v) {
            $this->external_id = $v;
            $this->modifiedColumns[SOrdersTableMap::COL_EXTERNAL_ID] = true;
        }

        return $this;
    } // setExternalId()

    /**
     * Set the value of [gift_cert_key] column.
     *
     * @param string $v new value
     * @return $this|\SOrders The current object (for fluent API support)
     */
    public function setGiftCertKey($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->gift_cert_key !== $v) {
            $this->gift_cert_key = $v;
            $this->modifiedColumns[SOrdersTableMap::COL_GIFT_CERT_KEY] = true;
        }

        return $this;
    } // setGiftCertKey()

    /**
     * Set the value of [discount] column.
     *
     * @param double $v new value
     * @return $this|\SOrders The current object (for fluent API support)
     */
    public function setDiscount($v)
    {
        if ($v !== null) {
            $v = (double) $v;
        }

        if ($this->discount !== $v) {
            $this->discount = $v;
            $this->modifiedColumns[SOrdersTableMap::COL_DISCOUNT] = true;
        }

        return $this;
    } // setDiscount()

    /**
     * Set the value of [gift_cert_price] column.
     *
     * @param double $v new value
     * @return $this|\SOrders The current object (for fluent API support)
     */
    public function setGiftCertPrice($v)
    {
        if ($v !== null) {
            $v = (double) $v;
        }

        if ($this->gift_cert_price !== $v) {
            $this->gift_cert_price = $v;
            $this->modifiedColumns[SOrdersTableMap::COL_GIFT_CERT_PRICE] = true;
        }

        return $this;
    } // setGiftCertPrice()

    /**
     * Set the value of [discount_info] column.
     *
     * @param string $v new value
     * @return $this|\SOrders The current object (for fluent API support)
     */
    public function setDiscountInfo($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->discount_info !== $v) {
            $this->discount_info = $v;
            $this->modifiedColumns[SOrdersTableMap::COL_DISCOUNT_INFO] = true;
        }

        return $this;
    } // setDiscountInfo()

    /**
     * Set the value of [origin_price] column.
     *
     * @param double $v new value
     * @return $this|\SOrders The current object (for fluent API support)
     */
    public function setOriginPrice($v)
    {
        if ($v !== null) {
            $v = (double) $v;
        }

        if ($this->origin_price !== $v) {
            $this->origin_price = $v;
            $this->modifiedColumns[SOrdersTableMap::COL_ORIGIN_PRICE] = true;
        }

        return $this;
    } // setOriginPrice()

    /**
     * Set the value of [comulativ] column.
     *
     * @param double $v new value
     * @return $this|\SOrders The current object (for fluent API support)
     */
    public function setComulativ($v)
    {
        if ($v !== null) {
            $v = (double) $v;
        }

        if ($this->comulativ !== $v) {
            $this->comulativ = $v;
            $this->modifiedColumns[SOrdersTableMap::COL_COMULATIV] = true;
        }

        return $this;
    } // setComulativ()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : SOrdersTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : SOrdersTableMap::translateFieldName('UserId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->user_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : SOrdersTableMap::translateFieldName('Key', TableMap::TYPE_PHPNAME, $indexType)];
            $this->order_key = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : SOrdersTableMap::translateFieldName('DeliveryMethod', TableMap::TYPE_PHPNAME, $indexType)];
            $this->delivery_method = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : SOrdersTableMap::translateFieldName('DeliveryPrice', TableMap::TYPE_PHPNAME, $indexType)];
            $this->delivery_price = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : SOrdersTableMap::translateFieldName('PaymentMethod', TableMap::TYPE_PHPNAME, $indexType)];
            $this->payment_method = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : SOrdersTableMap::translateFieldName('Status', TableMap::TYPE_PHPNAME, $indexType)];
            $this->status = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : SOrdersTableMap::translateFieldName('Paid', TableMap::TYPE_PHPNAME, $indexType)];
            $this->paid = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : SOrdersTableMap::translateFieldName('UserFullName', TableMap::TYPE_PHPNAME, $indexType)];
            $this->user_full_name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : SOrdersTableMap::translateFieldName('UserSurname', TableMap::TYPE_PHPNAME, $indexType)];
            $this->user_surname = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 10 + $startcol : SOrdersTableMap::translateFieldName('UserEmail', TableMap::TYPE_PHPNAME, $indexType)];
            $this->user_email = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 11 + $startcol : SOrdersTableMap::translateFieldName('UserPhone', TableMap::TYPE_PHPNAME, $indexType)];
            $this->user_phone = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 12 + $startcol : SOrdersTableMap::translateFieldName('UserDeliverTo', TableMap::TYPE_PHPNAME, $indexType)];
            $this->user_deliver_to = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 13 + $startcol : SOrdersTableMap::translateFieldName('UserComment', TableMap::TYPE_PHPNAME, $indexType)];
            $this->user_comment = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 14 + $startcol : SOrdersTableMap::translateFieldName('DateCreated', TableMap::TYPE_PHPNAME, $indexType)];
            $this->date_created = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 15 + $startcol : SOrdersTableMap::translateFieldName('DateUpdated', TableMap::TYPE_PHPNAME, $indexType)];
            $this->date_updated = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 16 + $startcol : SOrdersTableMap::translateFieldName('UserIp', TableMap::TYPE_PHPNAME, $indexType)];
            $this->user_ip = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 17 + $startcol : SOrdersTableMap::translateFieldName('TotalPrice', TableMap::TYPE_PHPNAME, $indexType)];
            $this->total_price = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 18 + $startcol : SOrdersTableMap::translateFieldName('ExternalId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->external_id = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 19 + $startcol : SOrdersTableMap::translateFieldName('GiftCertKey', TableMap::TYPE_PHPNAME, $indexType)];
            $this->gift_cert_key = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 20 + $startcol : SOrdersTableMap::translateFieldName('Discount', TableMap::TYPE_PHPNAME, $indexType)];
            $this->discount = (null !== $col) ? (double) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 21 + $startcol : SOrdersTableMap::translateFieldName('GiftCertPrice', TableMap::TYPE_PHPNAME, $indexType)];
            $this->gift_cert_price = (null !== $col) ? (double) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 22 + $startcol : SOrdersTableMap::translateFieldName('DiscountInfo', TableMap::TYPE_PHPNAME, $indexType)];
            $this->discount_info = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 23 + $startcol : SOrdersTableMap::translateFieldName('OriginPrice', TableMap::TYPE_PHPNAME, $indexType)];
            $this->origin_price = (null !== $col) ? (double) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 24 + $startcol : SOrdersTableMap::translateFieldName('Comulativ', TableMap::TYPE_PHPNAME, $indexType)];
            $this->comulativ = (null !== $col) ? (double) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 25; // 25 = SOrdersTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\SOrders'), 0, $e);
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
        if ($this->aSDeliveryMethods !== null && $this->delivery_method !== $this->aSDeliveryMethods->getId()) {
            $this->aSDeliveryMethods = null;
        }
        if ($this->aSPaymentMethods !== null && $this->payment_method !== $this->aSPaymentMethods->getId()) {
            $this->aSPaymentMethods = null;
        }
        if ($this->aSOrderStatuses !== null && $this->status !== $this->aSOrderStatuses->getId()) {
            $this->aSOrderStatuses = null;
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
            $con = Propel::getServiceContainer()->getReadConnection(SOrdersTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildSOrdersQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aSDeliveryMethods = null;
            $this->aSPaymentMethods = null;
            $this->aSOrderStatuses = null;
            $this->collSOrderProductss = null;

            $this->collSOrderStatusHistories = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see SOrders::setDeleted()
     * @see SOrders::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(SOrdersTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildSOrdersQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(SOrdersTableMap::DATABASE_NAME);
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
                SOrdersTableMap::addInstanceToPool($this);
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

            if ($this->aSDeliveryMethods !== null) {
                if ($this->aSDeliveryMethods->isModified() || $this->aSDeliveryMethods->isNew()) {
                    $affectedRows += $this->aSDeliveryMethods->save($con);
                }
                $this->setSDeliveryMethods($this->aSDeliveryMethods);
            }

            if ($this->aSPaymentMethods !== null) {
                if ($this->aSPaymentMethods->isModified() || $this->aSPaymentMethods->isNew()) {
                    $affectedRows += $this->aSPaymentMethods->save($con);
                }
                $this->setSPaymentMethods($this->aSPaymentMethods);
            }

            if ($this->aSOrderStatuses !== null) {
                if ($this->aSOrderStatuses->isModified() || $this->aSOrderStatuses->isNew()) {
                    $affectedRows += $this->aSOrderStatuses->save($con);
                }
                $this->setSOrderStatuses($this->aSOrderStatuses);
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

            if ($this->sOrderStatusHistoriesScheduledForDeletion !== null) {
                if (!$this->sOrderStatusHistoriesScheduledForDeletion->isEmpty()) {
                    \SOrderStatusHistoryQuery::create()
                        ->filterByPrimaryKeys($this->sOrderStatusHistoriesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
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

        $this->modifiedColumns[SOrdersTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . SOrdersTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(SOrdersTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(SOrdersTableMap::COL_USER_ID)) {
            $modifiedColumns[':p' . $index++]  = 'user_id';
        }
        if ($this->isColumnModified(SOrdersTableMap::COL_ORDER_KEY)) {
            $modifiedColumns[':p' . $index++]  = 'order_key';
        }
        if ($this->isColumnModified(SOrdersTableMap::COL_DELIVERY_METHOD)) {
            $modifiedColumns[':p' . $index++]  = 'delivery_method';
        }
        if ($this->isColumnModified(SOrdersTableMap::COL_DELIVERY_PRICE)) {
            $modifiedColumns[':p' . $index++]  = 'delivery_price';
        }
        if ($this->isColumnModified(SOrdersTableMap::COL_PAYMENT_METHOD)) {
            $modifiedColumns[':p' . $index++]  = 'payment_method';
        }
        if ($this->isColumnModified(SOrdersTableMap::COL_STATUS)) {
            $modifiedColumns[':p' . $index++]  = 'status';
        }
        if ($this->isColumnModified(SOrdersTableMap::COL_PAID)) {
            $modifiedColumns[':p' . $index++]  = 'paid';
        }
        if ($this->isColumnModified(SOrdersTableMap::COL_USER_FULL_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'user_full_name';
        }
        if ($this->isColumnModified(SOrdersTableMap::COL_USER_SURNAME)) {
            $modifiedColumns[':p' . $index++]  = 'user_surname';
        }
        if ($this->isColumnModified(SOrdersTableMap::COL_USER_EMAIL)) {
            $modifiedColumns[':p' . $index++]  = 'user_email';
        }
        if ($this->isColumnModified(SOrdersTableMap::COL_USER_PHONE)) {
            $modifiedColumns[':p' . $index++]  = 'user_phone';
        }
        if ($this->isColumnModified(SOrdersTableMap::COL_USER_DELIVER_TO)) {
            $modifiedColumns[':p' . $index++]  = 'user_deliver_to';
        }
        if ($this->isColumnModified(SOrdersTableMap::COL_USER_COMMENT)) {
            $modifiedColumns[':p' . $index++]  = 'user_comment';
        }
        if ($this->isColumnModified(SOrdersTableMap::COL_DATE_CREATED)) {
            $modifiedColumns[':p' . $index++]  = 'date_created';
        }
        if ($this->isColumnModified(SOrdersTableMap::COL_DATE_UPDATED)) {
            $modifiedColumns[':p' . $index++]  = 'date_updated';
        }
        if ($this->isColumnModified(SOrdersTableMap::COL_USER_IP)) {
            $modifiedColumns[':p' . $index++]  = 'user_ip';
        }
        if ($this->isColumnModified(SOrdersTableMap::COL_TOTAL_PRICE)) {
            $modifiedColumns[':p' . $index++]  = 'total_price';
        }
        if ($this->isColumnModified(SOrdersTableMap::COL_EXTERNAL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'external_id';
        }
        if ($this->isColumnModified(SOrdersTableMap::COL_GIFT_CERT_KEY)) {
            $modifiedColumns[':p' . $index++]  = 'gift_cert_key';
        }
        if ($this->isColumnModified(SOrdersTableMap::COL_DISCOUNT)) {
            $modifiedColumns[':p' . $index++]  = 'discount';
        }
        if ($this->isColumnModified(SOrdersTableMap::COL_GIFT_CERT_PRICE)) {
            $modifiedColumns[':p' . $index++]  = 'gift_cert_price';
        }
        if ($this->isColumnModified(SOrdersTableMap::COL_DISCOUNT_INFO)) {
            $modifiedColumns[':p' . $index++]  = 'discount_info';
        }
        if ($this->isColumnModified(SOrdersTableMap::COL_ORIGIN_PRICE)) {
            $modifiedColumns[':p' . $index++]  = 'origin_price';
        }
        if ($this->isColumnModified(SOrdersTableMap::COL_COMULATIV)) {
            $modifiedColumns[':p' . $index++]  = 'comulativ';
        }

        $sql = sprintf(
            'INSERT INTO shop_orders (%s) VALUES (%s)',
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
                    case 'user_id':
                        $stmt->bindValue($identifier, $this->user_id, PDO::PARAM_INT);
                        break;
                    case 'order_key':
                        $stmt->bindValue($identifier, $this->order_key, PDO::PARAM_STR);
                        break;
                    case 'delivery_method':
                        $stmt->bindValue($identifier, $this->delivery_method, PDO::PARAM_INT);
                        break;
                    case 'delivery_price':
                        $stmt->bindValue($identifier, $this->delivery_price, PDO::PARAM_STR);
                        break;
                    case 'payment_method':
                        $stmt->bindValue($identifier, $this->payment_method, PDO::PARAM_INT);
                        break;
                    case 'status':
                        $stmt->bindValue($identifier, $this->status, PDO::PARAM_INT);
                        break;
                    case 'paid':
                        $stmt->bindValue($identifier, (int) $this->paid, PDO::PARAM_INT);
                        break;
                    case 'user_full_name':
                        $stmt->bindValue($identifier, $this->user_full_name, PDO::PARAM_STR);
                        break;
                    case 'user_surname':
                        $stmt->bindValue($identifier, $this->user_surname, PDO::PARAM_STR);
                        break;
                    case 'user_email':
                        $stmt->bindValue($identifier, $this->user_email, PDO::PARAM_STR);
                        break;
                    case 'user_phone':
                        $stmt->bindValue($identifier, $this->user_phone, PDO::PARAM_STR);
                        break;
                    case 'user_deliver_to':
                        $stmt->bindValue($identifier, $this->user_deliver_to, PDO::PARAM_STR);
                        break;
                    case 'user_comment':
                        $stmt->bindValue($identifier, $this->user_comment, PDO::PARAM_STR);
                        break;
                    case 'date_created':
                        $stmt->bindValue($identifier, $this->date_created, PDO::PARAM_INT);
                        break;
                    case 'date_updated':
                        $stmt->bindValue($identifier, $this->date_updated, PDO::PARAM_INT);
                        break;
                    case 'user_ip':
                        $stmt->bindValue($identifier, $this->user_ip, PDO::PARAM_STR);
                        break;
                    case 'total_price':
                        $stmt->bindValue($identifier, $this->total_price, PDO::PARAM_STR);
                        break;
                    case 'external_id':
                        $stmt->bindValue($identifier, $this->external_id, PDO::PARAM_STR);
                        break;
                    case 'gift_cert_key':
                        $stmt->bindValue($identifier, $this->gift_cert_key, PDO::PARAM_STR);
                        break;
                    case 'discount':
                        $stmt->bindValue($identifier, $this->discount, PDO::PARAM_STR);
                        break;
                    case 'gift_cert_price':
                        $stmt->bindValue($identifier, $this->gift_cert_price, PDO::PARAM_STR);
                        break;
                    case 'discount_info':
                        $stmt->bindValue($identifier, $this->discount_info, PDO::PARAM_STR);
                        break;
                    case 'origin_price':
                        $stmt->bindValue($identifier, $this->origin_price, PDO::PARAM_STR);
                        break;
                    case 'comulativ':
                        $stmt->bindValue($identifier, $this->comulativ, PDO::PARAM_STR);
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
        $pos = SOrdersTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getUserId();
                break;
            case 2:
                return $this->getKey();
                break;
            case 3:
                return $this->getDeliveryMethod();
                break;
            case 4:
                return $this->getDeliveryPrice();
                break;
            case 5:
                return $this->getPaymentMethod();
                break;
            case 6:
                return $this->getStatus();
                break;
            case 7:
                return $this->getPaid();
                break;
            case 8:
                return $this->getUserFullName();
                break;
            case 9:
                return $this->getUserSurname();
                break;
            case 10:
                return $this->getUserEmail();
                break;
            case 11:
                return $this->getUserPhone();
                break;
            case 12:
                return $this->getUserDeliverTo();
                break;
            case 13:
                return $this->getUserComment();
                break;
            case 14:
                return $this->getDateCreated();
                break;
            case 15:
                return $this->getDateUpdated();
                break;
            case 16:
                return $this->getUserIp();
                break;
            case 17:
                return $this->getTotalPrice();
                break;
            case 18:
                return $this->getExternalId();
                break;
            case 19:
                return $this->getGiftCertKey();
                break;
            case 20:
                return $this->getDiscount();
                break;
            case 21:
                return $this->getGiftCertPrice();
                break;
            case 22:
                return $this->getDiscountInfo();
                break;
            case 23:
                return $this->getOriginPrice();
                break;
            case 24:
                return $this->getComulativ();
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

        if (isset($alreadyDumpedObjects['SOrders'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['SOrders'][$this->hashCode()] = true;
        $keys = SOrdersTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getUserId(),
            $keys[2] => $this->getKey(),
            $keys[3] => $this->getDeliveryMethod(),
            $keys[4] => $this->getDeliveryPrice(),
            $keys[5] => $this->getPaymentMethod(),
            $keys[6] => $this->getStatus(),
            $keys[7] => $this->getPaid(),
            $keys[8] => $this->getUserFullName(),
            $keys[9] => $this->getUserSurname(),
            $keys[10] => $this->getUserEmail(),
            $keys[11] => $this->getUserPhone(),
            $keys[12] => $this->getUserDeliverTo(),
            $keys[13] => $this->getUserComment(),
            $keys[14] => $this->getDateCreated(),
            $keys[15] => $this->getDateUpdated(),
            $keys[16] => $this->getUserIp(),
            $keys[17] => $this->getTotalPrice(),
            $keys[18] => $this->getExternalId(),
            $keys[19] => $this->getGiftCertKey(),
            $keys[20] => $this->getDiscount(),
            $keys[21] => $this->getGiftCertPrice(),
            $keys[22] => $this->getDiscountInfo(),
            $keys[23] => $this->getOriginPrice(),
            $keys[24] => $this->getComulativ(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aSDeliveryMethods) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'sDeliveryMethods';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'shop_delivery_methods';
                        break;
                    default:
                        $key = 'SDeliveryMethods';
                }

                $result[$key] = $this->aSDeliveryMethods->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aSPaymentMethods) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'sPaymentMethods';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'shop_payment_methods';
                        break;
                    default:
                        $key = 'SPaymentMethods';
                }

                $result[$key] = $this->aSPaymentMethods->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aSOrderStatuses) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'sOrderStatuses';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'shop_order_statuses';
                        break;
                    default:
                        $key = 'SOrderStatuses';
                }

                $result[$key] = $this->aSOrderStatuses->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
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
     * @return $this|\SOrders
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = SOrdersTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\SOrders
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setUserId($value);
                break;
            case 2:
                $this->setKey($value);
                break;
            case 3:
                $this->setDeliveryMethod($value);
                break;
            case 4:
                $this->setDeliveryPrice($value);
                break;
            case 5:
                $this->setPaymentMethod($value);
                break;
            case 6:
                $this->setStatus($value);
                break;
            case 7:
                $this->setPaid($value);
                break;
            case 8:
                $this->setUserFullName($value);
                break;
            case 9:
                $this->setUserSurname($value);
                break;
            case 10:
                $this->setUserEmail($value);
                break;
            case 11:
                $this->setUserPhone($value);
                break;
            case 12:
                $this->setUserDeliverTo($value);
                break;
            case 13:
                $this->setUserComment($value);
                break;
            case 14:
                $this->setDateCreated($value);
                break;
            case 15:
                $this->setDateUpdated($value);
                break;
            case 16:
                $this->setUserIp($value);
                break;
            case 17:
                $this->setTotalPrice($value);
                break;
            case 18:
                $this->setExternalId($value);
                break;
            case 19:
                $this->setGiftCertKey($value);
                break;
            case 20:
                $this->setDiscount($value);
                break;
            case 21:
                $this->setGiftCertPrice($value);
                break;
            case 22:
                $this->setDiscountInfo($value);
                break;
            case 23:
                $this->setOriginPrice($value);
                break;
            case 24:
                $this->setComulativ($value);
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
        $keys = SOrdersTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setUserId($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setKey($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setDeliveryMethod($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setDeliveryPrice($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setPaymentMethod($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setStatus($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setPaid($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setUserFullName($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setUserSurname($arr[$keys[9]]);
        }
        if (array_key_exists($keys[10], $arr)) {
            $this->setUserEmail($arr[$keys[10]]);
        }
        if (array_key_exists($keys[11], $arr)) {
            $this->setUserPhone($arr[$keys[11]]);
        }
        if (array_key_exists($keys[12], $arr)) {
            $this->setUserDeliverTo($arr[$keys[12]]);
        }
        if (array_key_exists($keys[13], $arr)) {
            $this->setUserComment($arr[$keys[13]]);
        }
        if (array_key_exists($keys[14], $arr)) {
            $this->setDateCreated($arr[$keys[14]]);
        }
        if (array_key_exists($keys[15], $arr)) {
            $this->setDateUpdated($arr[$keys[15]]);
        }
        if (array_key_exists($keys[16], $arr)) {
            $this->setUserIp($arr[$keys[16]]);
        }
        if (array_key_exists($keys[17], $arr)) {
            $this->setTotalPrice($arr[$keys[17]]);
        }
        if (array_key_exists($keys[18], $arr)) {
            $this->setExternalId($arr[$keys[18]]);
        }
        if (array_key_exists($keys[19], $arr)) {
            $this->setGiftCertKey($arr[$keys[19]]);
        }
        if (array_key_exists($keys[20], $arr)) {
            $this->setDiscount($arr[$keys[20]]);
        }
        if (array_key_exists($keys[21], $arr)) {
            $this->setGiftCertPrice($arr[$keys[21]]);
        }
        if (array_key_exists($keys[22], $arr)) {
            $this->setDiscountInfo($arr[$keys[22]]);
        }
        if (array_key_exists($keys[23], $arr)) {
            $this->setOriginPrice($arr[$keys[23]]);
        }
        if (array_key_exists($keys[24], $arr)) {
            $this->setComulativ($arr[$keys[24]]);
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
     * @return $this|\SOrders The current object, for fluid interface
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
        $criteria = new Criteria(SOrdersTableMap::DATABASE_NAME);

        if ($this->isColumnModified(SOrdersTableMap::COL_ID)) {
            $criteria->add(SOrdersTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(SOrdersTableMap::COL_USER_ID)) {
            $criteria->add(SOrdersTableMap::COL_USER_ID, $this->user_id);
        }
        if ($this->isColumnModified(SOrdersTableMap::COL_ORDER_KEY)) {
            $criteria->add(SOrdersTableMap::COL_ORDER_KEY, $this->order_key);
        }
        if ($this->isColumnModified(SOrdersTableMap::COL_DELIVERY_METHOD)) {
            $criteria->add(SOrdersTableMap::COL_DELIVERY_METHOD, $this->delivery_method);
        }
        if ($this->isColumnModified(SOrdersTableMap::COL_DELIVERY_PRICE)) {
            $criteria->add(SOrdersTableMap::COL_DELIVERY_PRICE, $this->delivery_price);
        }
        if ($this->isColumnModified(SOrdersTableMap::COL_PAYMENT_METHOD)) {
            $criteria->add(SOrdersTableMap::COL_PAYMENT_METHOD, $this->payment_method);
        }
        if ($this->isColumnModified(SOrdersTableMap::COL_STATUS)) {
            $criteria->add(SOrdersTableMap::COL_STATUS, $this->status);
        }
        if ($this->isColumnModified(SOrdersTableMap::COL_PAID)) {
            $criteria->add(SOrdersTableMap::COL_PAID, $this->paid);
        }
        if ($this->isColumnModified(SOrdersTableMap::COL_USER_FULL_NAME)) {
            $criteria->add(SOrdersTableMap::COL_USER_FULL_NAME, $this->user_full_name);
        }
        if ($this->isColumnModified(SOrdersTableMap::COL_USER_SURNAME)) {
            $criteria->add(SOrdersTableMap::COL_USER_SURNAME, $this->user_surname);
        }
        if ($this->isColumnModified(SOrdersTableMap::COL_USER_EMAIL)) {
            $criteria->add(SOrdersTableMap::COL_USER_EMAIL, $this->user_email);
        }
        if ($this->isColumnModified(SOrdersTableMap::COL_USER_PHONE)) {
            $criteria->add(SOrdersTableMap::COL_USER_PHONE, $this->user_phone);
        }
        if ($this->isColumnModified(SOrdersTableMap::COL_USER_DELIVER_TO)) {
            $criteria->add(SOrdersTableMap::COL_USER_DELIVER_TO, $this->user_deliver_to);
        }
        if ($this->isColumnModified(SOrdersTableMap::COL_USER_COMMENT)) {
            $criteria->add(SOrdersTableMap::COL_USER_COMMENT, $this->user_comment);
        }
        if ($this->isColumnModified(SOrdersTableMap::COL_DATE_CREATED)) {
            $criteria->add(SOrdersTableMap::COL_DATE_CREATED, $this->date_created);
        }
        if ($this->isColumnModified(SOrdersTableMap::COL_DATE_UPDATED)) {
            $criteria->add(SOrdersTableMap::COL_DATE_UPDATED, $this->date_updated);
        }
        if ($this->isColumnModified(SOrdersTableMap::COL_USER_IP)) {
            $criteria->add(SOrdersTableMap::COL_USER_IP, $this->user_ip);
        }
        if ($this->isColumnModified(SOrdersTableMap::COL_TOTAL_PRICE)) {
            $criteria->add(SOrdersTableMap::COL_TOTAL_PRICE, $this->total_price);
        }
        if ($this->isColumnModified(SOrdersTableMap::COL_EXTERNAL_ID)) {
            $criteria->add(SOrdersTableMap::COL_EXTERNAL_ID, $this->external_id);
        }
        if ($this->isColumnModified(SOrdersTableMap::COL_GIFT_CERT_KEY)) {
            $criteria->add(SOrdersTableMap::COL_GIFT_CERT_KEY, $this->gift_cert_key);
        }
        if ($this->isColumnModified(SOrdersTableMap::COL_DISCOUNT)) {
            $criteria->add(SOrdersTableMap::COL_DISCOUNT, $this->discount);
        }
        if ($this->isColumnModified(SOrdersTableMap::COL_GIFT_CERT_PRICE)) {
            $criteria->add(SOrdersTableMap::COL_GIFT_CERT_PRICE, $this->gift_cert_price);
        }
        if ($this->isColumnModified(SOrdersTableMap::COL_DISCOUNT_INFO)) {
            $criteria->add(SOrdersTableMap::COL_DISCOUNT_INFO, $this->discount_info);
        }
        if ($this->isColumnModified(SOrdersTableMap::COL_ORIGIN_PRICE)) {
            $criteria->add(SOrdersTableMap::COL_ORIGIN_PRICE, $this->origin_price);
        }
        if ($this->isColumnModified(SOrdersTableMap::COL_COMULATIV)) {
            $criteria->add(SOrdersTableMap::COL_COMULATIV, $this->comulativ);
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
        $criteria = ChildSOrdersQuery::create();
        $criteria->add(SOrdersTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \SOrders (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setUserId($this->getUserId());
        $copyObj->setKey($this->getKey());
        $copyObj->setDeliveryMethod($this->getDeliveryMethod());
        $copyObj->setDeliveryPrice($this->getDeliveryPrice());
        $copyObj->setPaymentMethod($this->getPaymentMethod());
        $copyObj->setStatus($this->getStatus());
        $copyObj->setPaid($this->getPaid());
        $copyObj->setUserFullName($this->getUserFullName());
        $copyObj->setUserSurname($this->getUserSurname());
        $copyObj->setUserEmail($this->getUserEmail());
        $copyObj->setUserPhone($this->getUserPhone());
        $copyObj->setUserDeliverTo($this->getUserDeliverTo());
        $copyObj->setUserComment($this->getUserComment());
        $copyObj->setDateCreated($this->getDateCreated());
        $copyObj->setDateUpdated($this->getDateUpdated());
        $copyObj->setUserIp($this->getUserIp());
        $copyObj->setTotalPrice($this->getTotalPrice());
        $copyObj->setExternalId($this->getExternalId());
        $copyObj->setGiftCertKey($this->getGiftCertKey());
        $copyObj->setDiscount($this->getDiscount());
        $copyObj->setGiftCertPrice($this->getGiftCertPrice());
        $copyObj->setDiscountInfo($this->getDiscountInfo());
        $copyObj->setOriginPrice($this->getOriginPrice());
        $copyObj->setComulativ($this->getComulativ());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getSOrderProductss() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addSOrderProducts($relObj->copy($deepCopy));
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
     * @return \SOrders Clone of current object.
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
     * Declares an association between this object and a ChildSDeliveryMethods object.
     *
     * @param  ChildSDeliveryMethods $v
     * @return $this|\SOrders The current object (for fluent API support)
     * @throws PropelException
     */
    public function setSDeliveryMethods(ChildSDeliveryMethods $v = null)
    {
        if ($v === null) {
            $this->setDeliveryMethod(NULL);
        } else {
            $this->setDeliveryMethod($v->getId());
        }

        $this->aSDeliveryMethods = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildSDeliveryMethods object, it will not be re-added.
        if ($v !== null) {
            $v->addSOrders($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildSDeliveryMethods object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildSDeliveryMethods The associated ChildSDeliveryMethods object.
     * @throws PropelException
     */
    public function getSDeliveryMethods(ConnectionInterface $con = null)
    {
        if ($this->aSDeliveryMethods === null && ($this->delivery_method !== null)) {
            $this->aSDeliveryMethods = ChildSDeliveryMethodsQuery::create()->findPk($this->delivery_method, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aSDeliveryMethods->addSOrderss($this);
             */
        }

        return $this->aSDeliveryMethods;
    }

    /**
     * Declares an association between this object and a ChildSPaymentMethods object.
     *
     * @param  ChildSPaymentMethods $v
     * @return $this|\SOrders The current object (for fluent API support)
     * @throws PropelException
     */
    public function setSPaymentMethods(ChildSPaymentMethods $v = null)
    {
        if ($v === null) {
            $this->setPaymentMethod(NULL);
        } else {
            $this->setPaymentMethod($v->getId());
        }

        $this->aSPaymentMethods = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildSPaymentMethods object, it will not be re-added.
        if ($v !== null) {
            $v->addSOrders($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildSPaymentMethods object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildSPaymentMethods The associated ChildSPaymentMethods object.
     * @throws PropelException
     */
    public function getSPaymentMethods(ConnectionInterface $con = null)
    {
        if ($this->aSPaymentMethods === null && ($this->payment_method !== null)) {
            $this->aSPaymentMethods = ChildSPaymentMethodsQuery::create()->findPk($this->payment_method, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aSPaymentMethods->addSOrderss($this);
             */
        }

        return $this->aSPaymentMethods;
    }

    /**
     * Declares an association between this object and a ChildSOrderStatuses object.
     *
     * @param  ChildSOrderStatuses $v
     * @return $this|\SOrders The current object (for fluent API support)
     * @throws PropelException
     */
    public function setSOrderStatuses(ChildSOrderStatuses $v = null)
    {
        if ($v === null) {
            $this->setStatus(NULL);
        } else {
            $this->setStatus($v->getId());
        }

        $this->aSOrderStatuses = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildSOrderStatuses object, it will not be re-added.
        if ($v !== null) {
            $v->addSOrders($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildSOrderStatuses object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildSOrderStatuses The associated ChildSOrderStatuses object.
     * @throws PropelException
     */
    public function getSOrderStatuses(ConnectionInterface $con = null)
    {
        if ($this->aSOrderStatuses === null && ($this->status !== null)) {
            $this->aSOrderStatuses = ChildSOrderStatusesQuery::create()->findPk($this->status, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aSOrderStatuses->addSOrderss($this);
             */
        }

        return $this->aSOrderStatuses;
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
        if ('SOrderProducts' == $relationName) {
            return $this->initSOrderProductss();
        }
        if ('SOrderStatusHistory' == $relationName) {
            return $this->initSOrderStatusHistories();
        }
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
     * If this ChildSOrders is new, it will return
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
                    ->filterBySOrders($this)
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
     * @return $this|ChildSOrders The current object (for fluent API support)
     */
    public function setSOrderProductss(Collection $sOrderProductss, ConnectionInterface $con = null)
    {
        /** @var ChildSOrderProducts[] $sOrderProductssToDelete */
        $sOrderProductssToDelete = $this->getSOrderProductss(new Criteria(), $con)->diff($sOrderProductss);


        $this->sOrderProductssScheduledForDeletion = $sOrderProductssToDelete;

        foreach ($sOrderProductssToDelete as $sOrderProductsRemoved) {
            $sOrderProductsRemoved->setSOrders(null);
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
                ->filterBySOrders($this)
                ->count($con);
        }

        return count($this->collSOrderProductss);
    }

    /**
     * Method called to associate a ChildSOrderProducts object to this object
     * through the ChildSOrderProducts foreign key attribute.
     *
     * @param  ChildSOrderProducts $l ChildSOrderProducts
     * @return $this|\SOrders The current object (for fluent API support)
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
        $sOrderProducts->setSOrders($this);
    }

    /**
     * @param  ChildSOrderProducts $sOrderProducts The ChildSOrderProducts object to remove.
     * @return $this|ChildSOrders The current object (for fluent API support)
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
            $sOrderProducts->setSOrders(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this SOrders is new, it will return
     * an empty collection; or if this SOrders has previously
     * been saved, it will retrieve related SOrderProductss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in SOrders.
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
     * Otherwise if this SOrders is new, it will return
     * an empty collection; or if this SOrders has previously
     * been saved, it will retrieve related SOrderProductss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in SOrders.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildSOrderProducts[] List of ChildSOrderProducts objects
     */
    public function getSOrderProductssJoinSProductVariants(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildSOrderProductsQuery::create(null, $criteria);
        $query->joinWith('SProductVariants', $joinBehavior);

        return $this->getSOrderProductss($query, $con);
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
     * If this ChildSOrders is new, it will return
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
                    ->filterBySOrders($this)
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
     * @return $this|ChildSOrders The current object (for fluent API support)
     */
    public function setSOrderStatusHistories(Collection $sOrderStatusHistories, ConnectionInterface $con = null)
    {
        /** @var ChildSOrderStatusHistory[] $sOrderStatusHistoriesToDelete */
        $sOrderStatusHistoriesToDelete = $this->getSOrderStatusHistories(new Criteria(), $con)->diff($sOrderStatusHistories);


        $this->sOrderStatusHistoriesScheduledForDeletion = $sOrderStatusHistoriesToDelete;

        foreach ($sOrderStatusHistoriesToDelete as $sOrderStatusHistoryRemoved) {
            $sOrderStatusHistoryRemoved->setSOrders(null);
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
                ->filterBySOrders($this)
                ->count($con);
        }

        return count($this->collSOrderStatusHistories);
    }

    /**
     * Method called to associate a ChildSOrderStatusHistory object to this object
     * through the ChildSOrderStatusHistory foreign key attribute.
     *
     * @param  ChildSOrderStatusHistory $l ChildSOrderStatusHistory
     * @return $this|\SOrders The current object (for fluent API support)
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
        $sOrderStatusHistory->setSOrders($this);
    }

    /**
     * @param  ChildSOrderStatusHistory $sOrderStatusHistory The ChildSOrderStatusHistory object to remove.
     * @return $this|ChildSOrders The current object (for fluent API support)
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
            $this->sOrderStatusHistoriesScheduledForDeletion[]= clone $sOrderStatusHistory;
            $sOrderStatusHistory->setSOrders(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this SOrders is new, it will return
     * an empty collection; or if this SOrders has previously
     * been saved, it will retrieve related SOrderStatusHistories from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in SOrders.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildSOrderStatusHistory[] List of ChildSOrderStatusHistory objects
     */
    public function getSOrderStatusHistoriesJoinSOrderStatuses(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildSOrderStatusHistoryQuery::create(null, $criteria);
        $query->joinWith('SOrderStatuses', $joinBehavior);

        return $this->getSOrderStatusHistories($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aSDeliveryMethods) {
            $this->aSDeliveryMethods->removeSOrders($this);
        }
        if (null !== $this->aSPaymentMethods) {
            $this->aSPaymentMethods->removeSOrders($this);
        }
        if (null !== $this->aSOrderStatuses) {
            $this->aSOrderStatuses->removeSOrders($this);
        }
        $this->id = null;
        $this->user_id = null;
        $this->order_key = null;
        $this->delivery_method = null;
        $this->delivery_price = null;
        $this->payment_method = null;
        $this->status = null;
        $this->paid = null;
        $this->user_full_name = null;
        $this->user_surname = null;
        $this->user_email = null;
        $this->user_phone = null;
        $this->user_deliver_to = null;
        $this->user_comment = null;
        $this->date_created = null;
        $this->date_updated = null;
        $this->user_ip = null;
        $this->total_price = null;
        $this->external_id = null;
        $this->gift_cert_key = null;
        $this->discount = null;
        $this->gift_cert_price = null;
        $this->discount_info = null;
        $this->origin_price = null;
        $this->comulativ = null;
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
            if ($this->collSOrderProductss) {
                foreach ($this->collSOrderProductss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collSOrderStatusHistories) {
                foreach ($this->collSOrderStatusHistories as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collSOrderProductss = null;
        $this->collSOrderStatusHistories = null;
        $this->aSDeliveryMethods = null;
        $this->aSPaymentMethods = null;
        $this->aSOrderStatuses = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(SOrdersTableMap::DEFAULT_STRING_FORMAT);
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
