<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . 'ArrayAccessBase.php';

/**
 * Created for capability reason, and imitate propel-object of category
 */
class CategoryItem extends ArrayAccessBase {

    protected static $itemsCollection = [];

    public function __construct(array $array = array()) {
        parent::__construct($array);
        self::$itemsCollection[$array['id']] = $this;
    }

    public function getLevel() {
        return count($this->items['full_path_ids']);
    }

    public function getId() {
        return $this->items['id'];
    }

    public function getName() {
        return $this->items['name'];
    }

    public function getColumn() {
        return $this->items['column'];
    }

    public function getFullPath() {
        return $this->items['full_path'];
    }

    public function getFullUriPath() {
        return $this->items['full_path'];
    }

    public function getFullPathIdsVirtual() {
        return $this->items['full_path_ids'];
    }
    
    public function getFullPathIds() {
        return $this->items['full_path_ids'];
    }

    public function getActive() {
        return $this->items['active'];
    }

    public function getParentId() {
        return $this->items['parent_id'];
    }

    /**
     * 
     * @return CategoryItem
     */
    public function getSCategory() {
        if (isset(self::$itemsCollection[$this->items['parent_id']])) {
            return self::$itemsCollection[$this->items['parent_id']];
        } else {
            return null;
        }
    }

    /**
     * If category is new, then paths will be empty - method creates them
     * @param array $tree1 one-dimention categories array
     */
    public function createPaths(array $tree1 = array()) {
        if (count($tree1) == 0) { // if tree was not passed thrue param
            $tree1 = ShopCore::app()->SCategoryTree->getTree(SCategoryTree::MODE_SINGLE);
        }
        $pathIds = array();
        $pathUrl = array();
        $neededCid = $this->items['id'];
        while ($neededCid != 0) {
            $pathIds[] = $tree1[$neededCid]['id'];
            $pathUrl[] = $tree1[$neededCid]['url'];
            $neededCid = $tree1[$neededCid]['parent_id'];
        }
        array_shift($pathIds); // deleting self id from ids path
        $this->items['full_path_ids'] = serialize(array_reverse($pathIds));
        $this->items['full_path'] = implode('/', array_reverse($pathUrl));
    }

    /**
     * Like StdClass
     * @param type $name
     * @return type
     */
    public function __get($name) {
        return $this->items[$name];
    }

}
