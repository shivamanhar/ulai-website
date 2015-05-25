<?php

/**
 * Base class for for array access type
 * Class is abstract because there is no need create such object - use simple array
 */
abstract class ArrayAccessBase implements ArrayAccess, Countable, Iterator {

    /**
     *
     * @var array
     */
    protected $items;

    /**
     * 
     * @param array $array
     */
    public function __construct(array $array = array()) {
        $this->items = $array;
    }

    public function offsetExists($offset) {
        return key_exists($offset, $this->items);
    }

    public function offsetGet($offset) {
        return $this->items[$offset];
    }

    public function offsetSet($offset, $value) {
        $this->items[$offset] = $value;
    }

    public function offsetUnset($offset) {
        unset($this->items[$offset]);
    }

    public function count() {
        return count($this->items);
    }

    public function current() {
        return current($this->items);
    }

    public function key() {
        return key($this->items);
    }

    public function next() {
        next($this->items);
    }

    public function rewind() {
        reset($this->items);
    }

    public function valid() {
        return isset($this->items[key($this->items)]);
    }

}

?>
