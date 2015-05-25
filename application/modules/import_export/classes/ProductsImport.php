<?php

namespace import_export\classes;

(defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 *
 * @property \CI_DB_active_record $db
 */
class ProductsImport extends BaseImport {

    /**
     * Class ProductsImport
     * @var ProductsImport 
     */
    protected static $_instance;

    /**
     * Path to the temp origin photo
     * @var string 
     */
    private $imagetemppathOrigin = './uploads/origin/';

    /**
     * Path to the temp addition photo
     * @var string 
     */
    private $imagetemppathAdd = './uploads/origin/additional/';

    /**
     * Path to the origin photo
     * @var string 
     */
    private $imageOriginPath = './uploads/shop/products/origin/';

    /**
     * Path to the addition photo
     * @var string 
     */
    private $imageAddPath = './uploads/shop/products/origin/additional/';

    /**
     * Main currency
     * @var array 
     */
    private $mainCur = array();

    public function __construct() {
        $this->load->helper('translit');
        parent::__construct();
        $this->mainCur = $this->db
                ->get_where('shop_currencies', array('is_default' => '1'))
                ->row_array();
        
        if(!is_dir($this->imagetemppathOrigin)){
            mkdir($this->imagetemppathOrigin, 0777);
            if(!is_dir($this->imagetemppathAdd)){
                mkdir($this->imagetemppathAdd, 0777);                
            }
        }
    }

    /**
     * Start Import process
     * @access public
     * @author Kaero
     * @copyright ImageCMS (c) 2012, Kaero <dev
     */
    public function make() {
        if (ImportBootstrap::hasErrors())
            return FALSE;
        self::create()->processBrands();
        self::create()->startCoreProcess();
    }

    /**
     * Start Core Process
     * @author Kaero
     * @copyright ImageCMS (c) 2012, Kaero <dev
     */
    private function startCoreProcess() {
        foreach (BaseImport::create()->content as $key => $node) {

            $result = $this->db
                    ->limit(1)
                    ->select('shop_product_variants.product_id as ProductId')
                    ->select('shop_products.category_id as SCategoryId')
                    ->select('shop_products_i18n.name as ProductName')
                    ->join('shop_products', 'shop_products.id = shop_product_variants.product_id', 'left outer')
                    ->join('shop_products_i18n', 'shop_products_i18n.id = shop_products.id')
                    ->where('number', $node['num'])
                    ->get('shop_product_variants')
                    ->row();

            $mas[$key] = (!($result instanceof \stdClass)) ?
                    $this->runProductInsertQuery($node) :
                    $this->runProductUpdateQuery($result->ProductId, $node);

            BaseImport::create()->content[$key]['ProductId'] = $mas[$key]['ProductId'];
            $ids[$key] = $mas[$key]['variantId'];
            BaseImport::create()->content[$key]['variantId'] = $mas[$key]['variantId'];
        }

        ImportBootstrap::addMessage(implode('/', $ids), 'content');
        $this->runCopyImages(BaseImport::create()->content);
    }

    /**
     * Run Product Update Query
     * @param array $arg Processed arguments list
     * @return bool
     * @author Kaero
     * @access private
     * @copyright ImageCMS (c) 2012, Kaero <dev
     */
    public function runProductUpdateQuery($productId, $arg) {
        if ($arg['url'] != '')
            $arg['url'] = $this->urlCheck($arg['url'], $productId);

        if ($arg['imgs'] != '')
            $arg['imgs'] = $this->runAditionalImages($arg, $productId);

        if ($arg['name'] == ''){
            \import_export\classes\Logger::create()
                    ->set('Колонка имени товара пустая. ID - '.$productId.' update. - IMPORT');
            return;
        }

        if ($arg['cat'] == ''){
            \import_export\classes\Logger::create()
                    ->set('Колонка категории товара пустая. ID - '.$productId.' update. - IMPORT');
            return;
        }


        /* START product Update query block */
        $prepareNames = $binds = $updateData = array();

        $productAlias = array(
            'act' => 'active',
            'CategoryId' => 'category_id',
            'url' => 'url',
            'oldprc' => 'old_price',
            'hit' => 'hit',
            'hot' => 'hot',
            'action' => 'action',
            'BrandId' => 'brand_id',
            'relp' => 'related_products',
            'mimg' => 'mainImage',
        );

        foreach ($arg as $key => $val)
            if (isset($productAlias[$key])) {
                array_push($prepareNames, $productAlias[$key]);
                $binds[$productAlias[$key]] = $val;
            }

        $prepareNames = array_merge($prepareNames, array('updated'));
        $binds = array_merge($binds, array('updated' => date('U')));

        foreach ($prepareNames as $value)
            $updateData[] = $value . '="' . $binds[$value] . '"';

        $this->db->query('UPDATE shop_products SET ' . implode(',', $updateData) . ' WHERE `id`= ?', array($productId));
        /* END product Update query block */

        /* START product i18n Update query block */
        $prepareNames = $binds = $updateData = array();

        $productAlias = array(
            'name' => 'name',
            'shdesc' => 'short_description',
            'desc' => 'full_description',
            'mett' => 'meta_title',
            'metd' => 'meta_description',
            'metk' => 'meta_keywords');

        foreach ($arg as $key => $val)
            if (isset($productAlias[$key])) {
                array_push($prepareNames, $productAlias[$key]);
                $binds[$productAlias[$key]] = $val;
                $updateData[] = '`' . $productAlias[$key] . '`="' . mysqli_real_escape_string($this->db->conn_id,$val) . '"';
                $insertData[$productAlias[$key]] = $val;
            }

        $checkIdProductI18n = $this->db->where('id',$productId)->where('locale',$this->languages)->get('shop_products_i18n')->row()->id;
        if($checkIdProductI18n){
            $this->db->query('UPDATE shop_products_i18n SET ' . implode(',', $updateData) . ' WHERE `id`= ' . $productId . ' AND `locale`= "' . $this->languages . '"');
        }else{
            $insertData['locale'] = $this->languages;
            $insertData['id'] = $productId;
            $this->db->insert('shop_products_i18n',$insertData);
        }
        /* END product i18n Update query block */

        $this->updateSProductsCategories($arg, $productId);
        $varId = $this->runProductVariantUpdateQuery($arg, $productId);

        return array(
            'ProductId' => $productId,
            'variantId' => $varId);
    }

    /**
     * Run Product Variant Update Query
     * @param array $arg Processed arguments list
     * @param int $productId Product Id for alias
     * @return bool
     * @access private
     * @author Kaero
     * @copyright ImageCMS (c) 2012, Kaero <dev
     */
    private function runProductVariantUpdateQuery(&$arg, &$productId) {
        /* START product variant insert query block */
        if ($arg['name'] == '')
            return;

        $prepareNames = $binds = $updateData = array();

        $productAlias = array(
            'stk' => 'stock',
            'prc' => 'price',
            'num' => 'number');

        if (isset($arg['prc'])) {
            $arg['prc'] = str_replace(',', '.', $arg['prc']);
        }

        foreach ($arg as $key => $val)
            if (isset($productAlias[$key])) {
                array_push($prepareNames, $productAlias[$key]);
                $binds[$productAlias[$key]] = $val;
            }

        $prepareNames = array_merge($prepareNames, array('currency', 'price_in_main'));

        $cur = $this->db->select('id')
                        ->get_where('shop_currencies', array('id' => $arg['cur']))
                        ->row()->id;

        if ($cur == null)
            $cur = $this->mainCur['id'];

        $binds = array_merge($binds, array(
            'currency' => $cur,
            'price_in_main' => $arg['prc']));

        foreach ($prepareNames as $value)
            $updateData[] = $value . '="' . $binds[$value] . '"';

        $this->db->query('UPDATE shop_product_variants SET ' . implode(',', $updateData) . ' WHERE `number`= ? AND `product_id` = ?', array($arg['num'], $productId));

        $variantModel = $this->db->query('SELECT id FROM shop_product_variants WHERE `number` = ? AND `product_id` = ?', array($arg['num'], $productId))->row();
        /* END product variant insert query block */

        /* START product variant i18n insert query block */
        $prepareNames = $binds = $updateData = array();
        $productAlias = (isset($arg['var'])) ? array('var' => 'name') : array('name' => 'name');

        foreach ($arg as $key => $val)
            if (isset($productAlias[$key])) {
                array_push($prepareNames, $productAlias[$key]);
                $binds[$productAlias[$key]] = $val;
                $updateData[] = $productAlias[$key] . '="' . mysqli_real_escape_string($this->db->conn_id,$val) . '"';
                $insertData[$productAlias[$key]] = $val;
            }
            
            
        $checkIdProductVariantI18n = $this->db->where('id',$variantModel->id)->where('locale',$this->languages)->get('shop_product_variants_i18n')->row()->id;
        if($checkIdProductVariantI18n){
            $this->db->query('UPDATE shop_product_variants_i18n SET ' . implode(',', $updateData) . ' WHERE `locale`= ? AND `id` = ?', array($this->languages, $variantModel->id));
        }else{
            $insertData['locale'] = $this->languages;
            $insertData['id'] = $variantModel->id;
            $this->db->insert('shop_product_variants_i18n',$insertData);
        }
        /* END product variant i18n insert query block */

        return $variantModel->id;
    }

    /**
     * Run Product Insert Query
     * @param array $arg Processed arguments list
     * @return bool
     * @author Kaero
     * @access private
     * @copyright ImageCMS (c) 2012, Kaero <dev
     */
    private function runProductInsertQuery($arg) {
        if ($arg['name'] == ''){
            \import_export\classes\Logger::create()
                    ->set('Колонка имени товара пустая. NUM - '.$arg['num'].' insert. - IMPORT');
            return;
        }

        if ($arg['cat'] == ''){
            \import_export\classes\Logger::create()
                    ->set('Колонка категории товара пустая. NUM - '.$arg['num'].' insert. - IMPORT');
            return;
        }

        $this->load->helper('string');

        $result = $this->db
                ->where('name', $arg['name'])
                ->get('shop_products_i18n')
                ->row();

        if ($arg['act'] == null)
            $arg['act'] = 1;

        if ($result) {
            $this->updateSProductsCategories($arg, $result->id);
            $varId = $this->runProductVariantInsertQuery($arg, $result->id);
            return array(
                'ProductId' => $result->id,
                'variantId' => $varId);
        }

        /* START product insert query block */
        $prepareNames = $binds = array();
        $productAlias = array(
            'act' => 'active',
            'CategoryId' => 'category_id',
            'oldprc' => 'old_price',
            'hit' => 'hit',
            'hot' => 'hot',
            'action' => 'action',
            'BrandId' => 'brand_id',
            'relp' => 'related_products',
            'mimg' => 'mainImage');

        foreach ($arg as $key => $val)
            if (isset($productAlias[$key])) {
                array_push($prepareNames, $productAlias[$key]);
                $binds[$productAlias[$key]] = $val;
            }

        $prepareNames = array_merge($prepareNames, array('created', 'updated', 'url'));

        $binds = array_merge($binds, array(
            'created' => date('U'),
            'updated' => date('U'),
            'url' => 'temp'));

        $this->db->query('INSERT INTO shop_products (' . implode(',', $prepareNames) . ') VALUES (' . substr(str_repeat('?,', count($prepareNames)), 0, -1) . ')', $binds);
        $productId = $this->db->insert_id();

        $this->db->query('UPDATE shop_products SET `url`= ? WHERE `id`= ?', array($this->urlCheck($arg['url'], $productId, $arg['name']), $productId));
        
        // Удаляет редирект товара если таков имеется.
        $translitName = translit_url(trim($arg['name']));        
        $this->db->where('trash_url', 'shop/product/' . $translitName)->delete('trash');
        
        /* END product insert query block */

        if ($arg['imgs'] != '')
            $arg['imgs'] = $this->runAditionalImages($arg, $productId);

        /* START product i18n insert query block */
        $prepareNames = $binds = array();

        $productAlias = array(
            'name' => 'name',
            'shdesc' => 'short_description',
            'desc' => 'full_description',
            'mett' => 'meta_title',
            'metd' => 'meta_description',
            'metk' => 'meta_keywords');

        foreach ($arg as $key => $val)
            if (isset($productAlias[$key])) {
                array_push($prepareNames, $productAlias[$key]);
                $binds[$productAlias[$key]] = $val;
            }
        $prepareNames = array_merge($prepareNames, array('locale', 'id'));

        $binds = array_merge($binds, array(
            'locale' => $this->languages,
            'id' => $productId));

        $this->db->query('INSERT INTO shop_products_i18n (' . implode(',', $prepareNames) . ') VALUES (' . substr(str_repeat('?,', count($prepareNames)), 0, -1) . ')', $binds);
        /* END product i18n insert query block */

        $this->updateSProductsCategories($arg, $productId);
        $varId = $this->runProductVariantInsertQuery($arg, $productId);

        return array(
            'ProductId' => $productId,
            'variantId' => $varId);
    }

    /**
     * Run Product Variant Insert Query
     * @param array $arg Processed arguments list
     * @param int $productId Product Id for alias
     * @return bool
     * @access private
     * @author Kaero
     * @copyright ImageCMS (c) 2012, Kaero <dev
     */
    private function runProductVariantInsertQuery(&$arg, &$productId) {
        if (isset($arg['prc'])) {
            $arg['prc'] = str_replace(',', '.', $arg['prc']);
        } else {
            $arg['prc'] = 0;
        }

        $arg['stk'] = isset($arg['stk']) ? $arg['stk'] : 0;

        /* START product variant insert query block */
        $prepareNames = $binds = array();
        $productAlias = array(
            'stk' => 'stock',
            'prc' => 'price',
            'num' => 'number');

        foreach ($arg as $key => $val)
            if (isset($productAlias[$key])) {
                array_push($prepareNames, $productAlias[$key]);
                $binds[$productAlias[$key]] = $val;
            }

        $cur = $this->db->select('id')
                        ->get_where('shop_currencies', array('id' => $arg['cur']))
                        ->row()->id;

        if ($cur == null)
            $cur = $this->mainCur['id'];

        $prepareNames = array_merge($prepareNames, array('product_id', 'currency', 'price_in_main', 'position'));
        $binds = array_merge($binds, array(
            'product_id' => $productId,
            'currency' => $cur,
            'price_in_main' => $arg['prc'], 0));
        $this->db->query('INSERT INTO shop_product_variants (' . implode(',', $prepareNames) . ')
            VALUES (' . substr(str_repeat('?,', count($prepareNames)), 0, -1) . ')', $binds);
        $productVariantId = $this->db->insert_id();
        /* END product variant insert query block */

        /* START product variant i18n insert query block */
        $prepareNames = $binds = array();
        $productAlias = (isset($arg['var'])) ? array('var' => 'name') : array('name' => 'name');
        foreach ($arg as $key => $val)
            if (isset($productAlias[$key])) {
                array_push($prepareNames, $productAlias[$key]);
                $binds[$productAlias[$key]] = $val;
            }

        $prepareNames = array_merge($prepareNames, array('id', 'locale'));
        $binds = array_merge($binds, array(
            'id' => $productVariantId,
            'locale' => $this->languages));
        $this->db->query('INSERT INTO shop_product_variants_i18n (' . implode(',', $prepareNames) . ')
            VALUES (' . substr(str_repeat('?,', count($prepareNames)), 0, -1) . ')', $binds);
        /* END product variant i18n insert query block */

        return $productVariantId;
    }

    /**
     * Update Shop Products Categories
     * @param array $arg Processed arguments list
     * @param int $productId Product Id for alias
     * @return bool
     * @author Kaero
     * @copyright ImageCMS (c) 2012, Kaero <dev
     */
    private function updateSProductsCategories(&$arg, $productId) {
        $this->db->delete('shop_product_categories', array('product_id' => $productId));
        foreach ($arg['CategoryIds'] as $categoryId) {
            try {
                $this->db->insert('shop_product_categories', array(
                    'product_id' => $productId,
                    'category_id' => $categoryId));
            } catch (Exception $exc) {
                echo $exc->getTraceAsString();
            }
        }
    }

    /**
     * Process Brands
     * @param int $key
     * @param array $node
     * @return type
     * @author Kaero
     * @copyright ImageCMS (c) 2012, Kaero <dev
     */
    protected function processBrands() {
        $this->load->helper('translit');
        foreach (BaseImport ::create()->content as $key => $node) {
            if (isset($node['brd']) && !empty($node['brd'])) {
                $result = $this->db->query("
                SELECT SBrands.id as BrandId
                FROM `shop_brands` as SBrands
                LEFT OUTER JOIN `shop_brands_i18n` AS SBrandsI18n ON SBrandsI18n.id = SBrands.id
                WHERE SBrandsI18n.name = ? AND locale = ?
                LIMIT 1", array($node['brd'], $this->languages))->row();
                if (!($result instanceof \stdClass)) {
                    $this->db->insert('shop_brands', array('url' => translit_url($node['brd'])));
                    $brandId = $this->db->insert_id();
                    foreach ($this->allLanguages as $val){
                        $this->db->insert('shop_brands_i18n', array('name' => $node['brd'], 'locale' => $val, 'id' => $brandId));
                    }
                    BaseImport::create()->content[$key]['BrandId'] = $brandId;
                } else {
                    BaseImport::create()->content[$key]['BrandId'] = $result->BrandId;
                }
            }
        }
    }

    /**
     * ProductsImport Singleton
     * @return ProductsImport
     * @access public
     * @author Kaero
     * @copyright ImageCMS (c) 2012, Kaero <dev
     */
    public static function create() {
        (null !== self::$_instance) OR self::$_instance = new self();
        return self::$_instance;
    }

    /**
     * If the file is in the origin folder, it is copied to the origin and entered 
     * into the db. If the file is not in a folder, but the pace is already in 
     * the original folder, just entered into the database.
     * @param array $result
     */
    private function runCopyImages($result) {
        foreach ((array) $result as $key => $item) {
            if (preg_match("/http\:\/\//i", $item['vimg'])) {
                $filename = $this->saveImgByUrl($item['vimg'], 'origin');
                if ($filename) {
                    copy($this->imagetemppathOrigin . $filename, $this->imageOriginPath . $filename);
                    $this->db->set('mainImage', $filename);
                    $this->db->where('id', $item['variantId']);
                    $this->db->update('shop_product_variants');
                }
            } else {
                if (($item['vimg'] != '') && (file_exists($this->imagetemppathOrigin . $item['vimg']))) {
                    copy($this->imagetemppathOrigin . $item['vimg'], $this->imageOriginPath . $item['vimg']);
                    $this->db->set('mainImage', $item['vimg']);
                    $this->db->where('id', $item['variantId']);
                    $this->db->update('shop_product_variants');
                } elseif (($item['vimg'] != '') && (file_exists($this->imageOriginPath . $item['vimg']))) {
                    $this->db->set('mainImage', $item['vimg']);
                    $this->db->where('id', $item['variantId']);
                    $this->db->update('shop_product_variants');
                }
            }
        }
    }

    /**
     * Save the picture on coal in the original folder or the origin/additional
     * @param str $param url
     * @param str $type (origin|additional)
     * @return boolean|string Name of file OR False
     * @access private
     */
    private function saveImgByUrl($param, $type = false) {
        if (!$type) {
            \import_export\classes\Logger::create()
                    ->set('$type is false. saveImgByUrl() ProductsImport.php. - IMPORT');
            return FALSE;
        }
        $path = ($type && $type == 'origin') ? './uploads/origin/' : './uploads/origin/additional/';
        $name = explode('/', $param);
        $sitename = $name[2];
        $name = explode('.', end($name));
        $name = urldecode($name[0]);
        $goodName = $sitename . '_' . $name;

        $paramTemp = explode('?', $param);
        if(is_array($paramTemp)){
            $param = $paramTemp[0];
        }else{
            $param = $param;
        }
        $format = end(explode('.', $param));
        $format = strtolower($format);
        switch ($format) {
            case 'jpg':
            case 'jpeg':
            case 'png':
            case 'gif': $flag = TRUE;
                break;
            default: $flag = FALSE;
                \import_export\classes\Logger::create()
                        ->set('The link does not lead to the image or images in the correct format ProductsImport.php. - IMPORT');
                break;
        }
        if (!file_exists($path . $goodName . '.' . $format)) {
            if ($flag) {
                $url = $param;
                $timeoutlimit = '5';
                ini_set('default_socket_timeout', $timeoutlimit);
                $fp = fopen($url, "r");
                $res = fread($fp, 500);
                fclose($fp);
                if (strlen($res) > 0) {
                    $s = file_get_contents($param);
                    file_put_contents($path . $goodName . '.' . $format, $s);
                } else {
                    \import_export\classes\Logger::create()
                            ->set('Server with a picture does not answer ' . $timeoutlimit . ' sec. ProductsImport.php. - IMPORT');
                }
                return $goodName . '.' . $format;
            }
            return FALSE;
        } else {
            return $goodName . '.' . $format;
        }
        return FALSE;
    }

    /**
     * Does not allow duplicate url
     * @param string $url
     * @param int $id
     * @param string $name
     * @return string
     */
    function urlCheck($url, $id = '', $name = '') {

        if ($url == '') {
            return translit_url(trim($name));
        } else {
            $url = translit_url($url);
        }
        // Check if Url is aviable.
        $urlCheck = $this->db
                ->select('url,id')
                ->where('url ', $url)
                ->where('`id` !=' . $id)
                ->get('shop_products')
                ->row();

        if ($urlCheck->id != $id) {
            return $url;
        } else {
            return $id . '_' . random_string('alnum', 8);
        }
    }

    /**
     * If the file is in the folder origin/additional, then copied to the original and 
     * entered into the db. If the file does not exist in the folder origin/additional
     * but already exists in the original, just entered into the database
     * @param array $arg
     * @param int $id
     */
    function runAditionalImages($arg, $id) {
        $this->db->delete('shop_product_images', array('product_id' => $id));

        $arg['imgs'] = explode('|', $arg['imgs']);
        
        if ($arg['imgs'] != array()) {
            foreach ((array) $arg['imgs'] as $key => $img) {
                $this->db->set('product_id', $id);
                $img = trim($img);

                if (preg_match("/http\:\/\//i", $img)) {
                    $filename = $this->saveImgByUrl($img, 'additional');
                    if ($filename) {
                        copy($this->imagetemppathAdd . $filename, $this->imageAddPath . $filename);
                        $this->db->set('image_name', $filename);
                        $this->db->set('position', $key);
                        $this->db->insert('shop_product_images');
                    }
                } else {
                    if (file_exists($this->imagetemppathAdd . $img)) {
                        /* If the photo is in the orogin folder */
                        copy($this->imagetemppathAdd . $img, $this->imageAddPath . $img);
                        $this->db->set('image_name', $img);
                        $this->db->set('position', $key);
                    } elseif (file_exists($this->imageAddPath . $img)) {
                        /* If the photo is not in the orogin folder, but there is $this->imageAddPath */
                        $this->db->set('image_name', $img);
                        $this->db->set('position', $key);
                    }
                    $this->db->insert('shop_product_images');
                }
            }
        }
    }

}
