<?php

namespace Category;

(defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * @property Core $core
 * @property \CI_DB_active_record $db
 */
class RenderMenu extends \CI_Model {

    protected static $_instance;
    public $menu_array = array(); // the root of the menu tree
    public $sub_menu_array = array(); // the list of menu items
    public $select_hidden = FALSE;
    public $arranged_menu_array = array();
    public $activate_by_sub_urls = TRUE;
    public $menu_template_vars = array();
    private $current_uri = "";
    private $stack = array();
    private $errors = array();
    private $expand = array(); // items id to expand
    private $cache_key = '';
    private $cur_level = 0;
    private $level = -1;
    private $levelCategory = 0;
    private $category = array();
    private $productId = NULL;
    private $ownerId = NULL;
    private $noCache = false;
    private $config = array();
    private $tpl_folder = "";
    private $tpl_folder_prefix = "level_";
    private $tpl_file_names = array(
        'container' => 'container',
        'item_default' => 'item_default',
        'item_default_active' => 'item_default_active',
        'item_first' => 'item_first',
        'item_first_active' => 'item_first_active',
        'item_last' => 'item_last',
        'item_last_active' => 'item_last_active',
        'item_one' => 'item_one',
        'item_one_active' => 'item_one_active',
    );

    public function __construct() {
        parent::__construct();
        $this->setConfig();
        $this->current_uri = $this->uri->uri_string();
    }

    /**
     * Returns a new RenderMenu object.
     * @return RenderMenu
     * @access public static
     * @author Kaero
     * @copyright ImageCMS (c) 2013, Kaero <dev
     */
    public static function create() {
        (null !== self::$_instance) OR self::$_instance = new self();
        return self::$_instance;
    }

    public function load($folder = '') {
        $this->tpl_folder = $folder;
        $this->startRenderCategory();
    }

    public function setConfig(array $arg = null) {

        $this->config = array(
            'url.shop.category' => '/shop/category/',
        );
        if ($arg != null) {
            $this->config = array_unique(array_merge($this->config, $arg));
        }
        return $this;
    }

    public function showSubCategories($folder = '', $ownerId = null, $noCache = true) {
        $this->tpl_folder = $folder;
        if ($ownerId != null) {
            $this->ownerId = $ownerId;
        } else {
            $this->ownerId = $this->core->core_data['id'];
        }
        $this->noCache = $noCache;
        $this->startRenderCategory();
    }

    /**
     * @tutorial Shows all categories.
     * @access Public
     * @author PefoliosInc
     * @copyright ImageCMS (c) 2012, <m.mamonchuk
     */
    public function startRenderCategory() {
        $hash = "shop_menu" . $this->tpl_folder . $this->ownerId . \MY_Controller::getCurrentLocale() . \CI_Controller::get_instance()->config->item('template');
        if ($cache_tpl = \Cache_html::get_html($hash) and $this->config['cache'] and ENVIRONMENT == 'production') {
            echo $cache_tpl;
        } else {
            ob_start();
            $this->showMenu();
            $menu = ob_get_clean();
            \Cache_html::set_html($menu, $hash);
            echo $menu;
        }
    }

    /**
     * @return Returns all the categories in the form of templates
     * @access Private
     * @author PefoliosInc
     * @copyright ImageCMS (c) 2012, <m.mamonchuk
     */
    private function showMenu() {

        $this->categorydb();
    }

    /**
     * @return no cache category DB
     * @access Private
     * @author PefoliosInc
     * @copyright ImageCMS (c) 2012, <m.mamonchuk
     */
    private function noCacheCategoryDB() {
        $locale = \MY_Controller::getCurrentLocale();
        $this->db->select('*');
        $this->db->from('shop_category');
        $this->db->where('locale', $locale);
        $this->db->where('active', '1');
        $this->db->order_by('position', 'ASC');
        $this->db->join('shop_category_i18n', 'shop_category_i18n.id = shop_category.id');
        $query = $this->db->get();

        if ($query) {
            $query = $query->result_array();
        } else {
            $query = array();
        }

        return $query;
    }

    /**
     * @return cache category DB
     * @access Private
     * @author PefoliosInc
     * @copyright ImageCMS (c) 2012, <m.mamonchuk
     */
    private function cache_category_db() {
        $locale = \MY_Controller::getCurrentLocale();

        $this->load->driver('cache');
        if (($query = $this->cache->fetch('category_db_' . $locale, 'category')) == null) {
            $this->db->select('*');
            $this->db->from('shop_category');
            $this->db->where('locale', $locale);
            $this->db->where('active', '1');
            $this->db->order_by('position', 'ASC');
            $this->db->join('shop_category_i18n', 'shop_category_i18n.id = shop_category.id');
            $query = $this->db->get();
            
            if ($query) {
                $query = $query->result_array();
            } else {
                $query = array();
            }
            
            $this->cache->store('category_db_' . $locale, $query, false, 'category');
        }
        return $query;
    }

    /**
     * @return Returns an array with the categories.
     * @access Private
     * @author PefoliosInc
     * @copyright ImageCMS (c) 2012, <m.mamonchuk
     */
    private function categorydb() {
        if ($this->noCache == true) {
            $this->category = $this->noCacheCategoryDB();
            $categoryTree = $this->renderCategory($this->ownerId);
            $this->noCache = false;
        } else {
            $this->category = $this->cache_category_db();

            $this->load->driver('cache');
            if (($categoryTree = $this->cache->fetch('categoryTree_' . $this->locale(), 'category')) == null) {
                $categoryTree = $this->renderCategory();
                $this->cache->store('categoryTree_' . $this->locale(), $categoryTree, false, 'category');
            }
        }
        $this->recursionSubCategory($categoryTree, $this->productActive());
    }

    /**
     *
     * @tutorial Function recursively examines the category tree, and passes on the template. Be careful when mutations both! :)
     * @access Private
     * @author PefoliosInc
     * @copyright ImageCMS (c) 2012, <m.mamonchuk
     *
     */
    private function recursionSubCategory($array = NULL, $productActive = NULL, $index = null) {
        if (is_array($array)) {
            foreach ($array as $v) {

                if ($v['subCategory'] != NULL) {
                    $this->recursionSubCategory($v['subCategory'], $productActive, $v['index']);
                } else {
                    $this->template->assign('wrapper', FALSE);
                }
                $data = array(
                    'index' => $index,
                    'id' => $v['id'],
                    'title' => $v['name'],
                    'link' => site_url($this->config['url.shop.category'] . $v['full_path']),
                    'image' => $v['image'],
                    'column' => $v['column']
                );
                if ($productActive == null) {
                    $categoriesPathsArray = $this->returnArrayOfPathsToActiveCategory();
                } else {
                    $categoriesPathsArray = $this->composeCategoriesPaths($productActive);
                }

                if (!is_array($categoriesPathsArray)) {
                    $categoriesPathsArray = array();
                }
                if (in_array($v['full_path'], $categoriesPathsArray)) {
                    $wrappers .= $this->template->fetch('/' . $this->tpl_folder . '/level_' . $v['lvl'] . '/item_default_active', $data);
                } else {
                    $wrappers .= $this->template->fetch('/' . $this->tpl_folder . '/level_' . $v['lvl'] . '/item_default', $data);
                }
            }
            $this->template->assign('wrapper', $wrappers);

            if ($v['lvl'] != 0) {
                $wrapper .= $this->template->fetch('/' . $this->tpl_folder . '/level_' . $v['lvl'] . '/container', $data);
            } else {
                $this->template->display('/' . $this->tpl_folder . '/level_0/container');
            }

            $this->template->assign('wrapper', $wrapper);
        } else {
            log_message('error', 'Class RenderMenyu function recursionSubCategory not received array');
            return false;
        }
    }

    /**
     * Return array of paths to active category
     * @return array|boolean
     */
    public function returnArrayOfPathsToActiveCategory() {
        $uri = $this->current_uri;
        $uriSegmentsArray = explode('/', $this->current_uri);
        if ($this->uri->segment(1) == $this->locale()) {
            unset($uriSegmentsArray[0]);
            unset($uriSegmentsArray[1]);
            unset($uriSegmentsArray[2]);
            $arrayOfPaths = $this->composeCategoriesPaths($uriSegmentsArray);
        } else {
            unset($uriSegmentsArray[0]);
            unset($uriSegmentsArray[1]);
            $arrayOfPaths = $this->composeCategoriesPaths($uriSegmentsArray);
        }

        if ($arrayOfPaths != null) {
            return $arrayOfPaths;
        } else {
            return false;
        }
    }

    /**
     * Compose categories paths to active category
     * @param array $segments
     * @return array|boolean
     */
    private function composeCategoriesPaths($segments = null) {
        if ($segments) {
            $count = count($segments);
            $step = 0;
            while ($step < $count) {

                $arrayOfCategoriesPaths[$step] = implode('/', array_slice($segments, 0, $step + 1));
                $step++;
            }
        }
        return $arrayOfCategoriesPaths;
    }

    public function lang_menu() {

        if ($this->uri->segment(1) == $this->locale()) {
            $url = $this->uri->segment(4);
        } else {
            $url = $this->uri->segment(3);
        }
        return $url;
    }

    public function locale() {
        return \MY_Controller::getCurrentLocale();
    }

    /**
     * @return Tree of all categories.
     * @access Private
     * @author PefoliosInc
     * @copyright ImageCMS (c) 2012, <m.mamonchuk
     */
    private function renderCategory($owner_id = 0) {

        $this->level++;
        $index = 0;
        foreach ($this->category as $value) {

            if ($value['parent_id'] == $owner_id) {
                $index++;
                $value['lvl'] = $this->level;
                $value['index'] = $index;

                $value['subCategory'] = $this->renderCategory($value['id']);
                $categoryTree[] = $value;
            }
        }
        $this->level--;

        return $categoryTree;
    }

    /**
     * @return Product category.
     * @access Private
     * @author PefoliosInc
     * @copyright ImageCMS (c) 2012, <m.mamonchuk
     */
    private function productActive() {
        $productId = $this->core->core_data;

        if ($productId['data_type'] !== 'product') {
            return false;
        }

        $this->db->select('full_path');
        $this->db->from('shop_products');
        $this->db->where('shop_products.id', $productId['id']);
        $this->db->join('shop_category', 'shop_category.id = shop_products.category_id');
        $query = $this->db->get();
        if ($query) {
            $query = $query->result_array();
        } else {
            $query = array();
        }
        $explode = explode('/', $query[0]['full_path']);
        return $explode;
    }

}