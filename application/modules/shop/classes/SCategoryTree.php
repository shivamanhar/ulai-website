<?php

/**
 * Create category tree. This class will add to each tree element next virtual columns: Level, Subtree, FullUriPath.
 *
 * @package Shop
 * @version $id$
 * @author <dev
 */
class SCategoryTree {
    // Single-dimensional array tree. Default mode.
    // In this mode each array key is category id.

    const MODE_SINGLE = 0;
    // Multi-dimensional array tree.
    const MODE_MULTI = 1;

    public $categories = NULL;
    public $tree = NULL;
    public $categoryUrlPrefix = '/shop/category/'; // Url prefix for links in UL tree. See $this->ul().
    public $loadUnactive = false;
    protected $multi = false;
    protected $level = -1;
    protected $path = array();
    protected $pathIds = array();
    private $_initialized = false;

    public function __construct() {
        $defaultLanguage = getDefaultLanguage();
        $currentLocale = MY_Controller::getCurrentLocale();

        if ($currentLocale != $defaultLanguage['identif']) {
            $this->categoryUrlPrefix = '/' . $currentLocale . $this->categoryUrlPrefix;
        }
      
    }

    /**
     * Creates tree of categories
     * @param int $mode 1 - one dimentional data-array, 2 - tree
     * @return array
     */
    public function getTree($mode = self::MODE_SINGLE, $active = FALSE) {
        // inluding "misleading" category item type
        require_once __DIR__ . DIRECTORY_SEPARATOR . 'DataTypes' . DIRECTORY_SEPARATOR . 'CategoryItem.php';
        // getting data only once

        $this->categories = array();
        // getting categories data 
        $ci = &get_instance();
        $locale = MY_Controller::getCurrentLocale();
        $result = $ci->db
                ->join('shop_category_i18n', "shop_category_i18n.id=shop_category.id AND shop_category_i18n.locale='{$locale}'", 'full')
                ->order_by('position', 'asc')
                ->get('shop_category');

        // creating data-array
        $sort = FALSE;
        $positions = array();

        // Prepare array where key - category id, value - category array 
        $categoriesIds = array();
        foreach ($result->result_array() as $category) {
            $categoriesIds[$category['id']] = $category;
        }

        foreach ($result->result_array() as $row) {
            if ($active) {
                if ($row['active'] != 1) {
                    continue;
                }
                $fullPathIds = unserialize($row['full_path_ids']);
                if (!empty($fullPathIds)) {
                    foreach ($fullPathIds as $parentId) {
                        if ($categoriesIds[$parentId]['active'] != 1) {
                            continue 2;
                        }
                    }
                }
            }
            $row['full_path_ids'] = unserialize($row['full_path_ids']);
            //unset($row['description']);
            $this->categories[$row['id']] = new CategoryItem($row);
            if (is_null($row['position']) || in_array($row['position'], $positions)) {
                // if even one of categories don't have position, array must be resorted
                $sort = TRUE;
            }
            $positions[] = $row['position'];
        }
            
        
        if ($sort == TRUE) {
            if (is_null($this->tree)) {                
                $this->tree = $this->getSubTree(0);
            }

            $this->categories = array();
            
            $this->resortCategories($this->tree);
            $this->setEmptyPositions();
        }

        if ($mode == self::MODE_SINGLE) {
            return $this->categories;
        } else {
            if (is_null($this->tree)) {
                $this->tree = $this->getSubTree(0);
            }
            return $this->tree;
        }
    }

    /**
     * Filling empty position categories - it causes them to sort 
     * the array each time and slow down page loading
     * Runs only when some of category don't have position (once)
     */
    private function setEmptyPositions() {
        $updateData = array();
        $i = 1;
        foreach ($this->categories as $categoryData) {
            $updateData[] = array(
                'id' => $categoryData['id'],
                'position' => $i,
            );
            $i++;
        }
        $ci = &get_instance();
        $ci->db->update_batch('shop_category', $updateData, 'id');
    }

    /**
     * Building new array with new category positions
     * @param array $tree
     */
    protected function resortCategories(array $tree) {
        foreach ($tree as $categoryId => $categoryData) {
            $subtree = FALSE;
            if (isset($categoryData['subtree'])) {
                if (count($categoryData['subtree']) > 0) {
                    $subtree = $categoryData['subtree'];
                    unset($categoryData['subtree']);
                }
            }
            $this->categories[$categoryId] = $categoryData;
            if ($subtree !== FALSE) {
                $this->resortCategories($subtree);
            }
        }
    }

    /**
     * Ceating tree of specified category (recursive)
     * @param int $parentId id of category which subtree needs to be formed
     * @return array
     */
    protected function getSubTree($parentId = 0) {
        $tree = array();
        foreach ($this->categories as $id => $categoryData) {
            if ($categoryData['parent_id'] == $parentId) {
                $tree[$id] = clone $categoryData;
                $subTree = $this->getSubTree($id);
                if (count($subTree))
                    $tree[$id]['subtree'] = $subTree;
            }
        }
        return $tree;
    }

    /**
     * @deprecated since version 4.5.2
     * @param type $mode
     * @return type
     */
    public function getTree_($mode = SCategoryTree::MODE_SINGLE, $locale = NULL) {
        $this->loadCategories($locale);
        // Set tree mode
        $this->multi = (bool) $mode;
        $this->tree = $this->createTree();
        return $this->tree;
    }

    /**
     * Create categories multidimensional tree array.
     * @deprecated since version 4.5.2
     * @access public
     * @return array
     */
    public function createTree($ownerId = null) {
        $result = array();

        /**
         *  Loop only thru categories with parent_id NULL. eg. root categories.
         */
        $this->level++;
        foreach ($this->categories as $category) {
            if ($category->getParentId() == $ownerId) {
                // Add categor url to full path.
                $this->path[] = $category->getUrl();
                $this->pathIds[] = $category->getId();

                $category->setVirtualColumn('level', $this->level);
                $category->setVirtualColumn('fullUriPath', $this->path); // Full uri path to category
                $category->setVirtualColumn('fullPathIdsVirtual', $this->pathIds);

                if ($this->multi === true) {
                    $category->setVirtualColumn('subtree', $this->createTree($category->getId()));
                    $result[] = $category;
                } else {
                    $result[$category->getId()] = $category;
                    $subtree = $this->createTree($category->getId());

                    foreach ($subtree as $key)
                        $result[$key->getId()] = $key;
                }

                // Decrease full path for one element.
                array_pop($this->path);
                array_pop($this->pathIds);
            }
        }
        $this->level--;

        return $result;
    }

    public function setLoadUnactive($val) {
        $this->loadUnactive = $val;
    }

    /**
     * Load categories list
     *
     * @access public
     */
    public function loadCategories($locale = NULL) {
        $locale = $locale ? $locale : MY_Controller::getCurrentLocale();

        if ($this->loadUnactive == TRUE) {
            $this->categories = SCategoryQuery::create()->joinWithI18n($locale, Propel\Runtime\ActiveQuery\Criteria::JOIN)->orderByPosition('ASC')->find();
        } else {
            $this->categories = SCategoryQuery::create()->joinWithI18n($locale, Propel\Runtime\ActiveQuery\Criteria::JOIN)->orderByPosition('ASC')->filterByActive(TRUE)->find();
        }        

        return $this;
    }

    /**
     * Remove category orphans after deleting some category
     *
     * @access public
     * @return integer number of delete categories
     */
    public function removeOrphans() {
        $orphans = array();

        // Reload categories array
        $this->loadCategories();
        $tree = $this->getTree();

        foreach ($this->categories as $category) {
            if (!isset($tree[$category->getParentId()]) && $category->getParentId() != 0) {
                array_push($orphans, $category->getId());
                $category->delete();
            }
        }

        return sizeof($orphans);
    }

    /**
     * Create UL list
     *
     * @access public
     * @return string
     */
    public function ul($activeID = null) {
        if ($activeID === null && ShopCore::$currentCategory instanceof SCategory) {
            $activeID = ShopCore::$currentCategory->getId();
        }


        echo $this->_walkArrayTitleWithNew(ShopCore::app()->SCategoryTree->getTree(SCategoryTree::MODE_MULTI), $activeID);
    }

    /**
     * _walkArrayTitleWith
     *
     * @access protected
     */
    protected function _walkArrayTitleWithNew($array, $activeID = null, $level = 0, $scName = null) {
        $html = '';
        if ($level == 0)
            $html .='
                <div class="frame-frame-menu-main">
                    <div class="frame-menu-main">
                        <div class="nav menu-main center not-js">
                            <table>
                                <tbody>
                                    <tr>';


        switch ($level) {
            case 0:
                foreach ($array as $key) {
                    $html .= '<td><div class="frame-item-menu">
                                <div><a href="' . $this->categoryUrlPrefix . $key->getFullPath() . '" class="title"><span class="helper"></span><span class="title-text">' . ShopCore::encode($key->getName()) . '</span></a></div>';
                    if (sizeof($key->getSubtree())) {
                        $html .= '<ul>';
                        $html .= $this->_walkArrayTitleWithNew($key->getSubtree(), $activeID, $level + 1, $key->getName());
                        $html .= '</ul>';
                    }

                    $html .= '</div></td>';
                }
                break;

            case 1:
                foreach ($array as $key) {
                    if (sizeof($key->getSubtree()))
                        $html .= '<li class="hasSub">';
                    else
                        $html .= '<li>';
                    $html .= '<a href="' . $this->categoryUrlPrefix . $key->getFullPath() . '"><span class="helper"></span>
                                <span>' . ShopCore::encode($key->getName()) . '</span></a>';
                    if (count($key->getSubtree())) {
                        $html .= '<div><ul>';
                        $html .= $this->_walkArrayTitleWithNew($key->getSubtree(), $activeID, $level + 1, $key->getName());
                        $html .= '</ul></div>';
                    }

                    $html .= '</li>';
                }
                break;

            case 2:
                foreach ($array as $key) {
                    $subtree = $key->getSubtree();
                    if (count($subtree)) {
                        $html .= '<li><span class="title">
                            <a href="' . $this->categoryUrlPrefix . $key->getFullPath() . '">' . ShopCore::encode($key->getName()) . '</a>';
                        $html .= '</span><ul>';

                        foreach ($subtree as $c)
                            $html .= '<li><a href="' . $this->categoryUrlPrefix . $c->getFullPath() . '">' . ShopCore::encode($c->getName()) . '</a></li>';
                        $html .= '</ul></li>';
                    } else {
                        $html .= '<li>
                            <a href="' . $this->categoryUrlPrefix . $key->getFullPath() . '">' . ShopCore::encode($key->getName()) . '</a>';
                        $html .= '</li>';
                    }
                }
                break;
        }


        if ($level == 0)
            $html .='              </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>';


        return $html;
    }

    /**
     * _walkArray
     *
     * @access protected
     */
    protected function _walkArray($array, $activeID = null) {
        foreach ($array as $key) {
            if ($key->getId() == $activeID)
                echo '<li>' . ShopCore::encode($key->getName()) . '</a>';
            else
                echo '<li><a href="' . $this->categoryUrlPrefix . $key->getFullPath() . '">' . ShopCore::encode($key->getName()) . '</a>';

            if (sizeof($key->getSubtree())) {
                echo '<ul>';
                $this->_walkArray($key->getSubtree(), $activeID);
                echo '</ul>';
            }
            echo '</li>';
        }
    }

    public function getSubcategories($categoryID = 0) {
        $categories = ShopCore::app()->SCategoryTree->createTree($categoryID);
        $ret = array();

        if (sizeof($categories)) {
            foreach ($categories as $category) {
                $ret[$category->getID()]['name'] = ShopCore::encode($category->getName());
//                $ret[$category->getID()]['link'] = $category->getFullPath();
//                $ret[$category->getID()]['link'] = $this->categoryUrlPrefix . $category->getFullPath();
                $ret[$category->getID()]['link'] = $category->getFullPath();
                $ret[$category->getID()]['parent_id'] = $category->getParentId();
                $ret[$category->getID()]['active'] = $category->getActive();
            }
        }

        return $ret;
    }

    /**
     * Create UL list
     *
     * @access public
     * @return string
     */
    public function ulWithTitle($activeID = null) {
        if ($activeID === null && ShopCore::$currentCategory instanceof SCategory) {
            $activeID = ShopCore::$currentCategory->getId();
        }

        ob_start();
        $this->_walkArrayTitleWith(ShopCore::app()->SCategoryTree->getTree(SCategoryTree::MODE_MULTI), $activeID);
        return ob_get_clean();
    }

    public function ulWithTitleMobile($activeID = null) {
        if ($activeID === null && ShopCore::$currentCategory instanceof SCategory) {
            $activeID = ShopCore::$currentCategory->getId();
        }

        ob_start();
        $this->_walkArrayTitleWithMobile(ShopCore::app()->SCategoryTree->getTree(SCategoryTree::MODE_MULTI), $activeID);
        return ob_get_clean();
    }

    /**
     * _walkArrayTitleWith
     *
     * @access protected
     */
    protected function _walkArrayTitleWith($array, $activeID = null, $noLi = FALSE, $scName = null) {
        if ($noLi)
            echo '<li><span class="title">' . $scName . '</span>';

        foreach ($array as $key) {

            $hot = '';
            foreach ($key->getSProductss() as $k) {
                if ($k->hot > 0) {
                    $hot = '<span class="newCategory">new</span>';
                }
            }

            if (!$noLi)
                if ($key->getId() == $activeID)
                    echo '<li class="active">';
                else
                    echo '<li>';
            //echo '<li><a href="' . $this->categoryUrlPrefix . $key->getFullPath() . '">' . ShopCore::encode($key->getName()) . $hot . '</a>';
            echo '<li>';
            if (count($key->getSProductss()) > 0)
                echo '<a href="' . $this->categoryUrlPrefix . $key->getFullPath() . '">' . ShopCore::encode($key->getName()) . $hot . '</a>';
            else
                echo '<a href="' . $this->categoryUrlPrefix . $key->getFullPath() . '">' . ShopCore::encode($key->getName()) . $hot . '</a>';

            if (sizeof($key->getSubtree())) {
                echo '<ul>';
                $this->_walkArrayTitleWith($key->getSubtree(), $activeID, TRUE, $key->getName());
                echo '</ul></li>';
            }

            if (!$noLi)
                echo '</li>';
        }
        if ($noLi)
            echo '</li>';
    }

    /**
     * _walkArrayTitleWithMobile
     *
     * @access protected
     */
    protected function _walkArrayTitleWithMobile($array, $activeID = null, $noLi = FALSE, $scName = null) {
        if ($noLi)
            echo '<li><div class="title">' . $scName . '</div>';

        foreach ($array as $key) {

            $hot = '';
            foreach ($key->getSProductss() as $k) {
                if ($k->hot > 0) {
                    $hot = '<span class="newCategory">new</span>';
                }
            }

            if (!$noLi)
                if ($key->getId() == $activeID)
                    echo '<li class="active">';
                else
                    echo '<li>';
            echo '<span class="pointer">
                    <span class="f_l"><span class="helper"></span><span class="v-a_m">' . ShopCore::encode($key->getName()) . $hot . '</span></span>
                    <span class="arrow_frame">
                        <span class="helper"></span>
                        <span class="icon arrow v-a_m"></span>
                    </span>
                </span>
                <!--<a href="' . $this->categoryUrlPrefix . $key->getFullPath() . '">' . ShopCore::encode($key->getName()) . $hot . '</a>-->';

            if (sizeof($key->getSubtree())) {
                echo '<ul>';
                $this->_walkArraySubTitleWithMobile($key->getSubtree(), $activeID, FALSE, $key->getName());
                echo '</ul>';
            }

            if (!$noLi)
                echo '</li>';
        }
        if ($noLi)
            echo '</li>';
    }

    protected function _walkArraySubTitleWithMobile($array, $activeID = null, $noLi = FALSE, $scName = null) {
        if ($noLi)
            echo '<li>';

        foreach ($array as $key) {

            $hot = '';
            foreach ($key->getSProductss() as $k) {
                if ($k->hot > 0) {
                    $hot = '<span class="newCategory"> new</span>';
                }
            }

            if (!$noLi)
                if ($key->getId() == $activeID)
                    echo '<li class="active">';
                else
                    echo '<li>';
            echo '<a href="' . $this->categoryUrlPrefix . $key->getFullPath() . '"><span class="list_item"></span><span class="helper"></span><span class="v-a_m">' . ShopCore::encode($key->getName()) . $hot . '</span></a>';

            if (!$noLi)
                echo '</li>';
        }
        if ($noLi)
            echo '</li>';
    }

}

