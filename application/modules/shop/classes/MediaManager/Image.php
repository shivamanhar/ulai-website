<?php

/**
 * Image manipulation
 * @author Igor R.
 * @copyright ImageCMS (c) 2013, Igor R. <dev
 */

namespace MediaManager;

(defined('BASEPATH')) OR exit('No direct script access allowed');

class Image extends BaseImageClass {

    protected static $_instance;
    private $imageSizesSettings;
    private $imageQuality = 99;
    private $mainSize;
    private $watermark_active;
    private $allSettings;
    private $fontPath;
    private $defaultFontPath = './uploads/defaultFont.ttf';
    public $uploadProductsPath;
    

    public function __construct() {
        parent::__construct();
        $this->load->library('image_lib');

        $this->uploadProductsPath = \ShopCore::$imagesUploadPath . 'products/';
        //Images settings
        $this->imageSizesSettings = $this->getImageSettings();
        $this->imageQuality = \ShopCore::app()->SSettings->imagesQuality;
        $this->mainSize = \ShopCore::app()->SSettings->imagesMainSize;

        //Watermark settings
        $this->watermark_active = \ShopCore::app()->SSettings->watermark_active;
        $this->watermarkFullPath = \ShopCore::app()->SSettings->watermark_watermark_image;

        //Get all settings
        $this->allSettings = \ShopCore::app()->SSettings;

        //check font path
        if (file_exists($this->allSettings->watermark_watermark_font_path)) {
            $this->fontPath = $this->allSettings->watermark_watermark_font_path;
        } else {
            $this->fontPath = false;
        }
        ini_set('max_execution_time', 90000000);
        set_time_limit(900000);
    }

    /**
     *
     * @return Image
     */
    public static function create() {
        (null !== self::$_instance) OR self::$_instance = new self();
        return self::$_instance;
    }

    /**
     * Resize images by product variant id
     * @param int|array $id
     */
    public function resizeById($id) {
        if ($id == null)
            return $this;

        $res = $this->db->where_in('id', $id)
                ->get('shop_product_variants')
                ->result_array();

        //make watermark for every type of images
        $this->checkWatermarks();
        $this->checkImagesFolders();

        foreach ($res as $product) {
            $this->makeResizeAndWatermark($product['mainImage']);
        }

        return $this;
    }

    /**
     * Resize additional images by product id or variant id
     * @param type $id product or variant id
     * @param type $isVarId define product or variant id
     */
    public function resizeByIdAdditional($id, $isVarId = FALSE) {
        if ($id == null)
            return $this;
        if ($isVarId) {
            $res = $this->db
                    ->select('*, shop_products.id as sproduct_id')
                    ->join('shop_products', 'shop_product_images.product_id=shop_products.id')
                    ->join('shop_product_variants', 'shop_product_variants.product_id=shop_products.id')
                    ->where_in('shop_product_variants.id', $id)
                    ->get('shop_product_images')
                    ->result_array();
        } else {
            $res = $this->db->where_in('product_id', $id)
                    ->get('shop_product_images')
                    ->result_array();
        }

        foreach ($res as $product) {
            $this->makeResizeAndWatermarkAdditional($product['image_name']);
        }

        return $this;
    }

    /**
     * Resize additional images by image name
     * @param type $id product or variant id
     * @param type $isVarId define product or variant id
     */
    public function resizeByNameAdditional($names) {
        if ($names == null)
            return $this;

        foreach ($names as $name) {
            $this->makeResizeAndWatermarkAdditional($name);
        }

        return $this;
    }

    /**
     * Resize images by product variant images name
     * @param str|array $names
     */
    public function resizeByName($names) {
        if ($names == null)
            return $this;

        $res = $this->db
                ->where_in('mainImage', $names)
                ->get('shop_product_variants')
                ->result_array();

        //make watermark for every type of images
        $this->checkWatermarks();
        $this->checkImagesFolders();

        foreach ($res as $product) {
            $this->makeResizeAndWatermark($product['mainImage']);
        }

        return $this;
    }

    /**
     * Resize all products images
     */
    public function resizeAll() {
        //make watermark for every type of images
        $this->checkWatermarks();

        $this->checkImagesFolders();

        //get all images from database
        $result = $this->db->select('id, mainImage')->get('shop_product_variants')->result_array();

        foreach ($result as $value) {
            if ($value['mainImage'] != NULL) {
                $this->makeResizeAndWatermark($value['mainImage']);
            }
        }

        return $this;
    }

    /**
     * Make resize and watermark for Image by filename
     *
     * @param type $imageName
     * @param type $mainSize
     * @param type $quality
     * @param type $watermark
     */
    public function makeResizeAndWatermark($imageName) {
        $mainSize = $this->mainSize;

        foreach ($this->imageSizesSettings as $s) {
            if ($mainSize == 'auto') {
                $mainSize = $this->autoMasterDim($s['width'], $s['height']);
            }
            /* Check is image smaller than sizes in settings */
            $imageSizes = $this->getImageSize($this->uploadProductsPath . 'origin/' . $imageName);
            if ($s['width'] > $imageSizes['width'] && $s['height'] > $imageSizes['height']) {
                $s['width'] = $imageSizes['width'];
                $s['height'] = $imageSizes['height'];
            }

            $this->image_lib->clear();
            $config = array();

            $config['source_image'] = $this->uploadProductsPath . 'origin/' . $imageName;
            $config['width'] = $s['width'];
            $config['height'] = $s['height'];
            $config['new_image'] = $this->uploadProductsPath . $s['name'] . '/' . $imageName;
            $config['quality'] = $this->imageQuality;
            $config['master_dim'] = $mainSize;
            $this->image_lib->initialize($config);
            $this->image_lib->resize();

            //If watermark is active
            if ($this->watermark_active) {
                $this->applyWatermark($imageName, $s['name']);
            }
        }
    }

    /**
     *
     * @param string $imageName
     */
    public function makeResizeAndWatermarkAdditional($imageName) {
        $mainSize = $this->mainSize;
        if ($mainSize == 'auto') {
            $mainSize = $this->autoMasterDim(\ShopCore::app()->SSettings->additionalImageWidth, \ShopCore::app()->SSettings->additionalImageWidth);
        }

        $s['width'] = \ShopCore::app()->SSettings->additionalImageWidth;
        $s['height'] = \ShopCore::app()->SSettings->additionalImageHeight;

        /* Check is image smaller than sizes in settings */
        $imageSizes = $this->getImageSize($this->uploadProductsPath . 'origin/additional/' . $imageName);
        if (\ShopCore::app()->SSettings->additionalImageWidth > $imageSizes['width'] || \ShopCore::app()->SSettings->additionalImageHeight > $imageSizes['height']) {
            $s['width'] = $imageSizes['width'];
            $s['height'] = $imageSizes['height'];
        }


        $this->image_lib->clear();
        $config = array();

        $config['source_image'] = $this->uploadProductsPath . 'origin/additional/' . $imageName;
        $config['width'] = $s['width'];
        $config['height'] = $s['height'];
        $config['new_image'] = $this->uploadProductsPath . 'additional/' . $imageName;
        $config['quality'] = $this->imageQuality;
        $config['master_dim'] = $mainSize;
        $this->image_lib->initialize($config);
        $this->image_lib->resize();

        $this->image_lib->clear();
        $config = array();
        
        /* Копирует фото и налаживает вотермарк (если налаживать на thumb, то не ведно изза малого размера)*/
        copy($this->uploadProductsPath . 'origin/additional/' . $imageName, $this->uploadProductsPath . 'additional/' . 'copyNew_'.$imageName);
        if ($this->watermark_active) {
            $this->applyWatermark('copyNew_'.$imageName, 'additional');
        }        
        
        $config['source_image'] = $this->uploadProductsPath . 'additional/' . 'copyNew_'.$imageName;
        $config['width'] = \ShopCore::app()->SSettings->thumbImageWidth;
        $config['height'] = \ShopCore::app()->SSettings->thumbImageWidth;
        $config['new_image'] = $this->uploadProductsPath . 'additional/thumb_' . $imageName;
        $config['quality'] = $this->imageQuality;
        $config['master_dim'] = $mainSize;
        $this->image_lib->initialize($config);
        $this->image_lib->resize();
        
        unlink($this->uploadProductsPath . 'additional/' . 'copyNew_'.$imageName);
        if ($this->watermark_active) {
            $this->applyWatermark($imageName, 'additional');
        }
    }

    /**
     * Check if watermarks exists and make if not exists
     */
    public function checkWatermarks() {
        //Check if folder for watermarks exists
        if (!is_dir($this->uploadProductsPath . 'watermarks/')) {
            mkdir($this->uploadProductsPath . 'watermarks/');
            chmod($this->uploadProductsPath . 'watermarks/', 0777);
        }

        $watermarkInterest = \ShopCore::app()->SSettings->watermark_watermark_interest;
        $watermarks = $this->imageSizesSettings;

        $watermarks['additional'] = array('name' => 'additional',
            'width' => \ShopCore::app()->SSettings->additionalImageWidth,
            'height' => \ShopCore::app()->SSettings->additionalImageWidth,
        );

        foreach ($watermarks as $s) {
            //Clear library and config array
            $this->image_lib->clear();
            $config = array();

            $config['source_image'] = '.' . \ShopCore::app()->SSettings->watermark_watermark_image;
            $config['width'] = $s['width'] / 100 * $watermarkInterest;
            $config['height'] = $s['height'] / 100 * $watermarkInterest;
            $config['new_image'] = $this->uploadProductsPath . 'watermarks/' . $s['name'] . '.png';

            $this->image_lib->initialize($config);
            $this->image_lib->resize();
        }
    }

    /*
     * Apply watermark to image
     */

    public function applyWatermark($imageName = '', $watermarkType = '') {

        $this->image_lib->clear();
        $config = array();
        $config['image_library'] = 'gd2';
        $config['source_image'] = $this->uploadProductsPath . $watermarkType . '/' . $imageName;
        $config['wm_vrt_alignment'] = $this->allSettings->watermark_wm_vrt_alignment;
        $config['wm_hor_alignment'] = $this->allSettings->watermark_wm_hor_alignment;
        $config['wm_padding'] = $this->allSettings->watermark_watermark_padding;
        $config['wm_x_transp'] = 1;
        $config['wm_y_transp'] = 1;

        //If watermark is image
        if ($this->allSettings->watermark_watermark_type == 'overlay') {
            $config['wm_type'] = 'overlay';
            $config['wm_opacity'] = $this->allSettings->watermark_watermark_image_opacity;
            $config['wm_overlay_path'] = $this->uploadProductsPath . 'watermarks/' . $watermarkType . '.png';
        } else {
            //if watermark is text
            if ($this->allSettings->watermark_watermark_text == '')
                return FALSE;

            $config['wm_text'] = $this->allSettings->watermark_watermark_text;
            $config['wm_type'] = 'text';
            if ($this->fontPath) {
                $config['wm_font_path'] = $this->fontPath;
            }else{
                $config['wm_font_path'] = $this->defaultFontPath;
            }
            $config['wm_font_size'] = $this->allSettings->watermark_watermark_font_size;
            $config['wm_font_color'] = $this->allSettings->watermark_watermark_color;
        }

        $this->image_lib->clear();
        $this->image_lib->initialize($config);
        $this->image_lib->watermark();
    }

    /*
     * Check if exists all folders for images. Create them if not exists and chmod 0777
     */

    public function checkImagesFolders() {
        $folders = $this->imageSizesSettings;
        $folders['additional'] = array('name' => 'additional',
            'width' => \ShopCore::app()->SSettings->additionalImageWidth,
            'height' => \ShopCore::app()->SSettings->additionalImageWidth,
        );
        foreach ($folders as $folder) {
            if (!is_dir($this->uploadProductsPath . $folder['name'] . '/')) {
                mkdir($this->uploadProductsPath . $folder['name'] . '/');
                chmod($this->uploadProductsPath . $folder['name'] . '/', 0777);
            }
        }
    }

    /**
     * Check origin folder
     */
    public function checkOriginFolder() {
        if (!is_dir($this->uploadProductsPath . 'origin/')) {
            if (!is_dir($this->uploadProductsPath)) {
                mkdir($this->uploadProductsPath);
                chmod($this->uploadProductsPath, 0777);
            }
            mkdir($this->uploadProductsPath . 'origin/');
            chmod($this->uploadProductsPath . 'origin/', 0777);
        }
        if (!is_dir($this->uploadProductsPath . 'origin/additional')) {
            mkdir($this->uploadProductsPath . 'origin/additional');
            chmod($this->uploadProductsPath, 0777);
        }
    }

    /*
     * Get from settings info about image sizes
     */

    public function getImageSettings() {
        return unserialize(\ShopCore::app()->SSettings->imageSizesBlock);
    }

    /*
     * Get from settings info about images variants
     */

    public function getImageVarintsNames() {
        $array = $this->getImageSettings();
        //Array with image variants
        $result = array();
        foreach ($array as $value) {
            $result[] .= strtolower($value['name']);
        }
        return $result;
    }

    /*
     * Get current image sizes
     */

    public function getImageSize($file_path) {
        if (function_exists('getimagesize') && file_exists($file_path)) {
            $image = @getimagesize($file_path);

            $size = array(
                'width' => $image[0],
                'height' => $image[1],
            );
            return $size;
        }
        return false;
    }

    /*
     *
     */

    public function autoMasterDim($width = null, $height = null) {
        if ($width > $height) {
            return 'height';
        } else {
            return 'width';
        }
    }

    /**
     * Prepare array of all path for product variant image
     * @param type $imageName
     */
    public function deleteAllProductImages($imageName) {

        //delete origin image
        $this->deleteImagebyFullPath($this->uploadProductsPath . 'origin/' . $imageName);
        //delete others images
        foreach ($this->imageSizesSettings as $s) {
            $this->deleteImagebyFullPath($this->uploadProductsPath . $s['name'] . '/' . $imageName);
        }
    }

    /**
     *
     * @param type $imageName image name
     */
    public function deleteAllProductAdditionalImages($imageName) {
        $this->deleteImagebyFullPath($this->uploadProductsPath . 'origin/additional/' . $imageName);
        $this->deleteImagebyFullPath($this->uploadProductsPath . 'additional/' . $imageName);
        $this->deleteImagebyFullPath($this->uploadProductsPath . 'additional/thumb_' . $imageName);
    }

    /**
     * Delete image by path
     * @param string $path
     */
    public function deleteImagebyFullPath($path) {
        if (file_exists($path)) {
            @unlink($path);
        }
    }

    /**
     *
     * @param type $ids array of product id's
     */
    public function deleteImagebyProductId($ids) {
        if ($ids == null) {
            return;
        }

        $res = $this->db->where_in('product_id', (array) $ids)
                ->get('shop_product_variants')
                ->result_array();

        foreach ($res as $r) {
            $this->deleteAllProductImages($r['mainImage']);
        }

        $this->deleteAdditionalImagebyProductId($ids);

        return $this;
    }

    /**
     *
     * @param type $ids array of product id's
     */
    public function deleteAdditionalImagebyProductId($ids) {
        if ($ids == null) {
            return;
        }
        $res = $this->db->where_in('product_id', (array) $ids)
                ->get('shop_product_images')
                ->result_array();

        foreach ($res as $r) {
            $this->deleteAllProductAdditionalImages($r['image_name']);
        }

        return $this;
    }

    /**
     *
     * @param type $ids array of category id's
     */
    public function deleteImagebyCategoryId($ids) {
        if ($ids == null) {
            return;
        }

        $res = $this->db
                ->select('*, shop_products.id as product_id')
                ->join('shop_product_variants', 'shop_product_variants.product_id=shop_products.id')
                ->where_in('category_id', $ids)
                ->get('shop_products')
                ->result_array();

        foreach ($res as $r) {
            $this->deleteAllProductImages($r[mainImage]);
            $this->deleteAdditionalImagebyProductId($r[product_id]);
        }
    }

    /**
     * Load image
     * 
     * @param int $varId
     * @param string $image
     * @return string
     * @throws \Exception
     */
    public function loadImage($varId, $image) {
        $mime = getimagesize($image);
        $info = pathinfo($image);

        if (!file_put_contents('./uploads/shop/products/origin/' . $info['basename'], file_get_contents($image))) {
            throw new \Exception(lang('Image wasnt loaded'));
        }

        $model = \SProductVariantsQuery::create()->filterById($varId)->findOne();
        if ($model) {
            $model->setMainimage($info['basename']);
            $model->save();
        } else {
            throw new \Exception(lang('Wrong variant id'));
        }

        return $info['basename'];
    }

    /**
     * Load additional image
     * 
     * @param int $prodId
     * @param string $image
     * @return string
     * @throws \Exception
     */
    public function loadAdditionalImage($prodId, $image) {
        $mime = getimagesize($image);
        $info = pathinfo($image);

        if (file_put_contents('./uploads/shop/products/origin/additional/' . $info['basename'], file_get_contents($image))) {
            throw new \Exception(lang('Image wasnt loaded'));
        }

        $model = new \SProductImages;
        if ($model) {
            $model->setProductId($prodId);
            $model->setImageName($info['basename']);
            $model->save();
        } else {
            throw new \Exception(lang('Wrong variant id'));
        }

        return $info['basename'];
    }

}
