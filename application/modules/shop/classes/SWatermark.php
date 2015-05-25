<?php

use Propel\Runtime\ActiveQuery\Criteria;

/**
 * SSettings - Manager shop settings
 * Run with command:   ShopCore::app()->SWatermark->updateWatermarks();
 */
class SWatermark {

    public $settings = array();
    protected $imageQuality = 99;
    protected $allowedImageExtensions = array('jpg', 'png', 'gif', 'jpeg');

    public function __construct() {
        // Load image sizes.
        $this->imageSizes['mainImageWidth'] = ShopCore::app()->SSettings->mainImageWidth;
        $this->imageSizes['mainImageHeight'] = ShopCore::app()->SSettings->mainImageHeight;
        $this->imageSizes['smallImageWidth'] = ShopCore::app()->SSettings->smallImageWidth;
        $this->imageSizes['smallImageHeight'] = ShopCore::app()->SSettings->smallImageHeight;
        $this->imageSizes['mainModImageWidth'] = ShopCore::app()->SSettings->mainModImageWidth;
        $this->imageSizes['mainModImageHeight'] = ShopCore::app()->SSettings->mainModImageHeight;
        $this->imageSizes['smallModImageWidth'] = ShopCore::app()->SSettings->smallModImageWidth;
        $this->imageSizes['smallModImageHeight'] = ShopCore::app()->SSettings->smallModImageHeight;
        $this->imageSizes['maxImageWidth'] = ShopCore::app()->SSettings->addImageWidth;
        $this->imageSizes['maxImageHeight'] = ShopCore::app()->SSettings->addImageHeight;

        $this->imageSizes['smallAddImageWidth'] = ShopCore::app()->SSettings->smallAddImageWidth;
        $this->imageSizes['smallAddImageHeight'] = ShopCore::app()->SSettings->smallAddImageHeight;

        $this->watermark_active = ShopCore::app()->SSettings->watermark_active;

        ini_set('max_execution_time', 90000000);
        set_time_limit(900000);
    }

    /**
     * Update watermarks for all product pictures 
     */
    public function updateWatermarks($from1C = false, $ids = 0) {

        $CI = & get_instance();
        if ($from1C)
            $this->from1C = true;
        $productImageName['main'] = 'main';
        $productImageName['mainMod'] = 'mainMod';
        $productImageName['small'] = 'small';
        $productImageName['smallMod'] = 'smallMod';


        // select products variants
        if ($ids == 0)
            $variantsQuery = $CI->db->get('shop_product_variants');
        else
            $variantsQuery = $CI->db->where_in('product_id', $ids)->get('shop_product_variants');
        // foreach products variants

        foreach ($variantsQuery->result() as $productRow) {
            // resize & update images
            $this->resize_variants_images($productRow->mainImage, $productRow->smallImage);
        }

        // select id's of all products
        $CI->db->select('id, external_id');

        if ($ids == 0)
            $productsQuery = $CI->db->get('shop_products');
        else
            $productsQuery = $CI->db->where_in('id', $ids)->get('shop_products');

        // foreach products
        foreach ($productsQuery->result() as $productRow) {
            // resize & update images
            $this->resize_images($productRow->id, $productImageName, $productRow->external_id);
        }
    }

    /**
     * Resize image
     * @var string $file_path
     */
    private function resize_variants_images($mainImage, $smallImage) {
        $CI = & get_instance();
        $CI->load->library('image_lib');

        $pathMainImage = ShopCore::$imagesUploadPath . 'origin/' . $mainImage;
        $pathSmallImage = ShopCore::$imagesUploadPath . 'origin/' . $smallImage;

        $config['create_thumb'] = FALSE;
        $config['maintain_ratio'] = TRUE;
        $config['image_library'] = 'gd2';
        $config['master_dim'] = 'width';

        if (file_exists($pathMainImage) && $mainImage != null) {
            $imageSizes = $this->getImageSize($pathMainImage);

            if (file_exists(ShopCore::$imagesUploadPath . $mainImage))
                @unlink(ShopCore::$imagesUploadPath . $mainImage);
            // resize image if not fit site sizes
            if ($imageSizes['width'] >= $this->imageSizes['mainImageWidth'] || $imageSizes['height'] >= $this->imageSizes['mainImageHeight']) {

                $config['source_image'] = $pathMainImage;
                $config['width'] = $this->imageSizes['mainImageWidth'];
                $config['height'] = $this->imageSizes['mainImageHeight'];
                $config['new_image'] = ShopCore::$imagesUploadPath . $mainImage;
                $config['quality'] = $this->imageQuality;

                $CI->image_lib->initialize($config);
                $CI->image_lib->resize();
            }
            // else copy original
            else {
                copy($pathMainImage, ShopCore::$imagesUploadPath . $mainImage);
            }

            if (file_exists($pathSmallImage) && $smallImage != null) {
                $imageSizes = $this->getImageSize($pathSmallImage);

                if (file_exists(ShopCore::$imagesUploadPath . $pathSmallImage))
                    @unlink(ShopCore::$imagesUploadPath . $pathSmallImage);
                // resize image if not fit site sizes
                if ($imageSizes['width'] >= $this->imageSizes['smallImageWidth'] || $imageSizes['height'] >= $this->imageSizes['smallImageHeight']) {

                    $config['source_image'] = $pathSmallImage;
                    $config['width'] = $this->imageSizes['smallImageWidth'];
                    $config['height'] = $this->imageSizes['smallImageHeight'];
                    $config['new_image'] = ShopCore::$imagesUploadPath . $smallImage;
                    $config['quality'] = $this->imageQuality;

                    $CI->image_lib->initialize($config);
                    $CI->image_lib->resize();
                }
                // else copy original
                else {
                    copy($pathSmallImage, ShopCore::$imagesUploadPath . $smallImage);
                }

                // draw watermarks
                if ($this->watermark_active) {
                    $this->draw_watermark(ShopCore::$imagesUploadPath . $mainImage, array('main' => 'main'));
                    $this->draw_watermark(ShopCore::$imagesUploadPath . $smallImage, array('smallMod' => 'smallMod'));
                }
            }
        }
    }

    /**
     * Resize image
     * @var string $file_path
     */
    private function resize_images($product_id, $format, $external_id = false) {
        $CI = & get_instance();
        $CI->load->library('image_lib');

        $shopPath = getModulePath('shop');
        if ($this->from1C) {

            $fileName = $shopPath . 'cmlTemp/images/' . $external_id . '.jpg';

            if (!file_exists($fileName))
                $fileName = $shopPath . 'cmlTemp/images/' . $external_id . '.jpeg';

            copy($fileName, 'uploads/shop/origin/' . $product_id . '_main_origin.jpg');
        } else
            $fileName = ShopCore::$imagesUploadPath . 'origin/' . $product_id . '_main_origin.jpg';

        if (file_exists($fileName)) {
            $imageSizes = $this->getImageSize($fileName);

            foreach ($format as $productImageKey => $productImageValue) {

                if (file_exists(ShopCore::$imagesUploadPath . $product_id . '_' . $productImageKey . '.jpg'))
                    unlink(ShopCore::$imagesUploadPath . $product_id . '_' . $productImageKey . '.jpg');

                // resize image if not fit site sizes
                if ($imageSizes['width'] >= $this->imageSizes[$productImageKey . 'ImageWidth'] || $imageSizes['height'] >= $this->imageSizes[$productImageKey . 'ImageHeight']) {

                    $config['image_library'] = 'gd2';
                    $config['master_dim'] = 'width';
                    $config['source_image'] = $fileName;
                    $config['create_thumb'] = FALSE;
                    $config['maintain_ratio'] = TRUE;
                    $config['width'] = $this->imageSizes[$productImageKey . 'ImageWidth'];
                    $config['height'] = $this->imageSizes[$productImageKey . 'ImageHeight'];
                    $config['new_image'] = ShopCore::$imagesUploadPath . $product_id . '_' . $productImageKey . '.jpg';
                    $config['quality'] = $this->imageQuality;

                    $CI->image_lib->initialize($config);
                    $CI->image_lib->resize();

                    //echo 'resized: '.ShopCore::$imagesUploadPath.$product_id . '_'.$productImageKey.'.jpg'.' from '.$imageSizes['width'].' x '.$imageSizes['height'].' to '.$this->imageSizes[$productImageKey.'ImageWidth'].' x '.$this->imageSizes[$productImageKey.'ImageHeight'].'<br>';
                }
                // else copy original
                else
                    copy($fileName, ShopCore::$imagesUploadPath . $product_id . '_' . $productImageKey . '.jpg');

                // draw watermarks
                if ($this->watermark_active)
                    $this->draw_watermark(ShopCore::$imagesUploadPath . $product_id . '_' . $productImageKey . '.jpg', array($productImageKey => $productImageKey));
            }
        }
    }

    /**
     * Draw watermark
     * @var string $file_path
     */
    public function draw_watermark($fullPath, $format, $imgS = Null) {
        $CI = & get_instance();
        $CI->load->library('image_lib');
        $logo = './uploads/watermark/';

        $settings = &ShopCore::app()->SSettings;

        if (!$settings->watermark_active)
            return;
        foreach ($format as $form) {

            $config = array();
            $config['image_library'] = 'gd2';
            $config['source_image'] = '.' . $settings->watermark_watermark_image;
            $config['create_thumb'] = FALSE;
            $config['maintain_ratio'] = TRUE;

            switch ($form) {
                case 'mainMod':

                    $config['width'] = $this->imageSizes['mainModImageWidth'] / 100 * $settings->watermark_watermark_interest;
                    $config['height'] = $this->imageSizes['mainModImageHeight'] / 100 * $settings->watermark_watermark_interest;
                    $config['new_image'] = $logo . 'mainModImageWidth.png';
                    $var = $logo . 'mainModImageWidth.png';

                    break;
                case 'main':
                    if ($imgS != Null) {
                        $config['width'] = $imgS['width'] / 100 * $settings->watermark_watermark_interest;
                        $config['height'] = $imgS['height'] / 100 * $settings->watermark_watermark_interest;
                    } else {
                        $config['width'] = $this->imageSizes['mainImageWidth'] / 100 * $settings->watermark_watermark_interest;
                        $config['height'] = $this->imageSizes['mainImageHeight'] / 100 * $settings->watermark_watermark_interest;
                    }
                    $config['new_image'] = $logo . 'mainImageWidth.png';
                    $var = $logo . 'mainImageWidth.png';


                    break;
                case 'small':
                    if ($imgS != Null) {
                        $config['width'] = $imgS['width'] / 100 * $settings->watermark_watermark_interest;
                        $config['height'] = $imgS['height'] / 100 * $settings->watermark_watermark_interest;
                    } else {
                        $config['width'] = $this->imageSizes['smallImageWidth'] / 100 * $settings->watermark_watermark_interest;
                        $config['height'] = $this->imageSizes['smallImageHeight'] / 100 * $settings->watermark_watermark_interest;
                    }
                    $config['new_image'] = $logo . 'smallImageWidth.png';
                    $var = $logo . 'smallImageWidth.png';

                    break;
                case 'smallMod':
                    $config['width'] = $this->imageSizes['smallModImageWidth'] / 100 * $settings->watermark_watermark_interest;
                    $config['height'] = $this->imageSizes['smallModImageHeight'] / 100 * $settings->watermark_watermark_interest;
                    $config['new_image'] = $logo . 'smallModImageWidth.png';
                    $var = $logo . 'smallModImageWidth.png';

                    break;
                case 'thumb':
                    $config['width'] = $this->imageSizes['smallImageWidth'] / 100 * $settings->watermark_watermark_interest;
                    $config['height'] = $this->imageSizes['smallImageHeight'] / 100 * $settings->watermark_watermark_interest;
                    $config['new_image'] = $logo . 'smallImageWidth.png';
                    $var = $logo . 'smallImageWidth.png';

                    break;
                case 'createThumb':
                    $config['width'] = $this->imageSizes['smallAddImageWidth'] / 100 * $settings->watermark_watermark_interest;
                    $config['height'] = $this->imageSizes['smallAddImageHeight'] / 100 * $settings->watermark_watermark_interest;
                    $config['new_image'] = $logo . 'smallAddImageWidth.png';
                    $var = $logo . 'smallAddImageWidth.png';

                    break;
                case 'additionalImage':
                    if ($imgS != Null) {
                        $config['width'] = $imgS['width'] / 100 * $settings->watermark_watermark_interest;
                        $config['height'] = $imgS['height'] / 100 * $settings->watermark_watermark_interest;
                    } else {
                        $config['width'] = $this->imageSizes['maxImageWidth'] / 100 * $settings->watermark_watermark_interest;
                        $config['height'] = $this->imageSizes['maxImageHeight'] / 100 * $settings->watermark_watermark_interest;
                    }

                    $config['new_image'] = $logo . 'maxImageWidth.png';
                    $var = $logo . 'maxImageWidth.png';

                    break;
                case 'variantSmall':
                    $config['width'] = $this->imageSizes['smallImageWidth'] / 100 * $settings->watermark_watermark_interest;
                    $config['height'] = $this->imageSizes['smallImageHeight'] / 100 * $settings->watermark_watermark_interest;
                    $config['new_image'] = $logo . 'variantSmall.png';
                    $var = $logo . 'variantSmall.png';
                    break;
            }
            $CI->image_lib->initialize($config);
            $CI->image_lib->resize();

            if (!$settings->watermark_active)
                return;

            if ($settings->watermark_watermark_font_path == '') {
                $settings->watermark_watermark_font_path = './system/fonts/1.ttf';
            }

            $config = array();
            $config['source_image'] = $fullPath;
            $config['wm_vrt_alignment'] = $settings->watermark_wm_vrt_alignment;
            $config['wm_hor_alignment'] = $settings->watermark_wm_hor_alignment;
            $config['wm_padding'] = $settings->watermark_watermark_padding;

            if ($settings->watermark_watermark_type == 'overlay') {
                $config['wm_type'] = 'overlay';
                $config['wm_opacity'] = $settings->watermark_watermark_image_opacity;
                $config['wm_overlay_path'] = $var;
            } else {
                if ($settings->watermark_watermark_text == '')
                    return FALSE;
                $config['wm_text'] = $settings->watermark_watermark_text;
                $config['wm_type'] = 'text';
                $config['wm_font_path'] = $settings->watermark_watermark_font_path;
                $config['wm_font_size'] = $settings->watermark_watermark_font_size;
                $config['wm_font_color'] = $settings->watermark_watermark_color;
            }
            $CI->image_lib->clear();
            $CI->image_lib->initialize($config);
            $CI->image_lib->watermark();
        }
    }

    /**
     * Get image width and height.
     *
     * @param string $file_path Full path to image
     * @access protected
     * @return mixed
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

    /**
     * Resize and save additional images.
     *
     * @param integer $productId Product Id
     * @access public
     */
    public function saveAdditionalImages(SProducts $model) {
        $settings = &ShopCore::app()->SSettings->watermark_active;
        // Check if we have to delete some images

        $CI = & get_instance();
        $CI->load->library('image_lib');

        $productId = $model->getId();
        $imgs = SProductImagesQuery::create()->filterByProductId($productId)->orderByPosition(Criteria::DESC)->findOne();
//        if ($imgs)
//            $i = intval($imgs->getPosition()) + 1;
//        else
        $i = 0;
        foreach ($_FILES as $key => $file) {
            if (strstr($key, 'additionalImage_') && $this->_isAllowedExtension($file['name'])) {
                copy($file['tmp_name'], ShopCore::$imagesUploadPath . 'origin/' . $productId . "_$i.jpg");
                $i = substr($key, 16, strlen($key) - 16);
                $fileName = ShopCore::$imagesUploadPath . $productId . "_$i.jpg";
                $thumbPath = ShopCore::$imagesUploadPath . 'additionalImageThumbs/' . $productId . "_$i.jpg";

                $imgSizes = ShopCore::app()->SWatermark->getImageSize($file['tmp_name']);

                if ($imgSizes['width'] >= $this->imageSizes['maxImageWidth'] OR $imgSizes['height'] >= $this->imageSizes['maxImageHeight']) {
                    $CI->image_lib->clear();
                    $config['image_library'] = 'gd2';
                    $config['source_image'] = $file['tmp_name'];
                    $config['create_thumb'] = false;
                    $config['maintain_ratio'] = true;
                    $config['width'] = $this->imageSizes['maxImageWidth'];
                    $config['height'] = $this->imageSizes['maxImageHeight'];
                    $config['new_image'] = $fileName;
                    $config['quality'] = $this->imageQuality;

                    $CI->image_lib->initialize($config);
                    $CI->image_lib->resize();
                } else {
                    copy($file['tmp_name'], $fileName);
                }

                // Create thumb
                $CI->image_lib->clear();
                $config['image_library'] = 'gd2';
                $config['source_image'] = $fileName;
                $config['create_thumb'] = false;
                $config['maintain_ratio'] = true;
                $config['width'] = $this->imageSizes['smallAddImageWidth'];
                $config['height'] = $this->imageSizes['smallAddImageHeight'];
                $config['new_image'] = $thumbPath;
                $config['quality'] = $this->imageQuality;
                $CI->image_lib->initialize($config);
                $CI->image_lib->resize();

                // Draw watermark
                $imageSizes = ShopCore::app()->SWatermark->getImageSize($fileName);
                if ($settings == 1) {
                    ShopCore::app()->SWatermark->draw_watermark($fileName, array('additionalImage' => 'additionalImage'), $imageSizes);
                }
                SProductImagesQuery::create()
                        ->filterByProductId($model->getId())
                        ->filterByImageName($productId . "_$i.jpg")
                        ->delete();

                $newImage = new SProductImages;
                $newImage->setImageName($productId . "_$i.jpg");
                $newImage->setPosition($i);
                $model->addSProductImages($newImage);
            }

            $i++;
        }

        return $model;
    }

    public function _isAllowedExtension($fileName) {
        $parts = explode('.', $fileName);
        $ext = strtolower(end($parts));

        if (in_array($ext, $this->allowedImageExtensions))
            return true;
        else
            return false;
    }

    public function processImage($pid, $fileName, $cfgVar, $fileSuffix, $isUpload = false) {
        //saving origin main image

        $CI = & get_instance();
        $CI->load->library('image_lib');

        if ($isUpload) {
            if (file_exists(ShopCore::$imagesUploadPath . 'origin/' . $pid . '_' . $fileSuffix . '_origin.jpg'))
                unlink(ShopCore::$imagesUploadPath . 'origin/' . $pid . '_' . $fileSuffix . '_origin.jpg');

            if ($cfgVar == 'mainImage')
                copy($fileName, ShopCore::$imagesUploadPath . 'origin/' . $pid . '_' . $fileSuffix . '_origin.jpg');
        }

        if (file_exists(ShopCore::$imagesUploadPath . $pid . '_' . $fileSuffix . '.jpg'))
            unlink(ShopCore::$imagesUploadPath . $pid . '_' . $fileSuffix . '.jpg');


        $imageSizes = ShopCore::app()->SWatermark->getImageSize($fileName);
        $settings = &ShopCore::app()->SSettings->watermark_active;
        if ($imageSizes['width'] >= $this->imageSizes[$cfgVar . 'Width'] OR $imageSizes['height'] >= $this->imageSizes[$cfgVar . 'Height']) {
            $CI->image_lib->clear();
            $config['image_library'] = 'gd2';
            $config['source_image'] = $fileName;
            $config['create_thumb'] = FALSE;
            $config['maintain_ratio'] = TRUE;
            $config['width'] = $this->imageSizes[$cfgVar . 'Width'];
            $config['height'] = $this->imageSizes[$cfgVar . 'Height'];
            $config['new_image'] = ShopCore::$imagesUploadPath . $pid . '_' . $fileSuffix . '.jpg';
            $config['quality'] = $this->imageQuality;

            $CI->image_lib->initialize($config);
            $CI->image_lib->resize();

            if ($settings == 1) {

                $this->draw_watermark(ShopCore::$imagesUploadPath . $pid . '_' . $fileSuffix . '.jpg', array($fileSuffix => $fileSuffix));
            }
        } else {
            copy($fileName, ShopCore::$imagesUploadPath . $pid . '_' . $fileSuffix . '.jpg');
            if ($settings == 1) {
                $this->draw_watermark(ShopCore::$imagesUploadPath . $pid . '_' . $fileSuffix . '.jpg', array($fileSuffix => $fileSuffix), $imageSizes);
            }
        }
    }

    public function process_variant_image(SProductVariants $productVariant, $variant, $productId, $variantId, $origin = null) {

        $CI = & get_instance();
        $CI->load->library('image_lib');
        if ($variant['MainImageForDel'] == 1 && $variant['mainPhoto']['tmp_name'] == '') {
            $productVariant->setMainimage('');
            if (file_exists("uploads/shop/" . $productId . "_vM" . $variantId . ".jpg")) {
                unlink("uploads/shop/" . $productId . "_vM" . $variantId . ".jpg");
                @unlink(ShopCore::$imagesUploadPath . 'origin/' . $productId . "_vM" . $variantId . '.jpg');
            }
        } else {
            if (ShopCore::app()->SWatermark->_isAllowedExtension($variant['mainPhoto']['name'])) {

                $fileName = ShopCore::$imagesUploadPath . $productId . "_vM$variantId.jpg";
                $imgSizes = ShopCore::app()->SWatermark->getImageSize($variant['mainPhoto']['tmp_name']);

                if ($imgSizes['width'] >= $this->imageSizes['maxImageWidth'] OR $imgSizes['height'] >= $this->imageSizes['maxImageHeight']) {
                    $CI->image_lib->clear();
                    $config['image_library'] = 'gd2';
                    $config['source_image'] = $variant['mainPhoto']['tmp_name'];
                    $config['create_thumb'] = false;
                    $config['maintain_ratio'] = true;
                    $config['width'] = $this->imageSizes['maxImageWidth'];
                    $config['height'] = $this->imageSizes['maxImageHeight'];
                    $config['new_image'] = $fileName;
                    $config['quality'] = $this->imageQuality;

                    $CI->image_lib->initialize($config);
                    $imageSizesS = ShopCore::app()->SWatermark->getImageSize($fileName);

                    $mainImageResized = true;
                    copy($variant['mainPhoto']['tmp_name'], $fileName);

                    //Copy to origin folder
                    if ($variant['origin_main'] == 1) {
                        copy($variant['mainPhoto']['tmp_name'], ShopCore::$imagesUploadPath . 'origin/' . $productId . "_vM" . $variantId . '.jpg');
                    }
                    //Draw watermark if active
                    if ($this->watermark_active == 1) {
                        $this->draw_watermark($fileName, array('additionalImage' => 'additionalImage'), $imageSizesS);
                    }
                    // Resize image
                    if ($CI->image_lib->resize()) {
                        $mainImageResized = true;
                    }
                    //Set smallImage and MainImage for first variant  
                    if ($variant['origin_main'] != 1) {
                        $productVariant->setMainimage($productId . "_main.jpg");
                    } else {
                        $productVariant->setMainimage($productId . "_vM$variantId.jpg");
                    }
                } else {
                    $mainImageResized = true;
                    if ($variant['origin_main'] != 1) {
                        $productVariant->setMainimage($productId . "_main.jpg");
                    } else {
                        $productVariant->setMainimage($productId . "_vM$variantId.jpg");
                    }
                    copy($variant['mainPhoto']['tmp_name'], $fileName);
                    $imageSizesvM = $this->getImageSize($fileName);
                    if ($this->watermark_active == 1) {
                        $this->draw_watermark($fileName, array('additionalImage' => 'additionalImage'), $imageSizesvM);
                    }

                    if (empty($variant['smallPhoto']['tmp_name']) && $mainImageResized === true)
                        $smallImageSource = $fileName;
                    elseif (!empty($variant['smallPhoto']['tmp_name']) && ShopCore::app()->SWatermark->_isAllowedExtension($variant['smallPhoto']['name']) === true)
                        $smallImageSource = $variant['smallPhoto']['tmp_name'];
                    else
                        $smallImageSource = false;

                    if ($smallImageSource != false) {
                        $fileName = ShopCore::$imagesUploadPath . $productId . "_vS$variantId.jpg";

                        if (file_exists($fileName))
                            unlink($fileName);

                        $CI->image_lib->clear();
                        $config['image_library'] = 'gd2';
                        $config['source_image'] = $smallImageSource;
                        $config['create_thumb'] = false;
                        $config['maintain_ratio'] = true;
                        $config['width'] = $this->imageSizes['smallImageWidth'];
                        $config['height'] = $this->imageSizes['smallImageHeight'];
                        $config['new_image'] = $fileName;
                        $config['quality'] = $this->imageQuality;

                        $CI->image_lib->initialize($config);
                        $CI->image_lib->resize();

                        if ($variant['origin_small'] != 1) {
                            $productVariant->setSmallimage($productId . "_small.jpg");
                        } else {
                            $productVariant->setSmallimage($productId . "_vS$variantId.jpg");
                        }
                    }
                }
            }
        }
        if ($variant['SmallImageForDel'] == 1 && $variant['smallPhoto']['tmp_name'] == '') {
            $productVariant->setSmallimage('');
            if (file_exists("uploads/shop/" . $productId . "_vS" . $variantId . ".jpg")) {
                unlink("uploads/shop/" . $productId . "_vS" . $variantId . ".jpg");
                @unlink(ShopCore::$imagesUploadPath . 'origin/' . $productId . "_vS" . $variantId . '.jpg');
            }
        } else {
            if (empty($variant['smallPhoto']['tmp_name']) && $mainImageResized === true && !file_exists("uploads/shop/" . $productId . "_vM$variantId.jpg"))
                $smallImageSource = $fileName;

            elseif (!empty($variant['smallPhoto']['tmp_name']) && ShopCore::app()->SWatermark->_isAllowedExtension($variant['smallPhoto']['name']) === true) {
                if ($variant['origin_small'] == 1) {
                    copy($variant['smallPhoto']['tmp_name'], ShopCore::$imagesUploadPath . 'origin/' . $productId . "_vS" . $variantId . '.jpg');
                }
                $smallImageSource = $variant['smallPhoto']['tmp_name'];
            } else
                $smallImageSource = false;

            if ($smallImageSource != false) {
                $fileName = ShopCore::$imagesUploadPath . $productId . "_vS$variantId.jpg";

                if (file_exists($fileName))
                    unlink($fileName);

                $CI->image_lib->clear();
                $config['image_library'] = 'gd2';
                $config['source_image'] = $smallImageSource;
                $config['create_thumb'] = false;
                $config['maintain_ratio'] = true;
                $config['width'] = $this->imageSizes['smallImageWidth'];
                $config['height'] = $this->imageSizes['smallImageHeight'];
                $config['new_image'] = $fileName;
                $config['quality'] = $this->imageQuality;

                $CI->image_lib->initialize($config);
                $CI->image_lib->resize();

                if ($this->watermark_active == 1) {
                    $this->draw_watermark($fileName, array('small' => 'small'));
                }
                if ($variant['origin_small'] != 1) {
                    $productVariant->setSmallimage($productId . "_small.jpg");
                } else {
                    $productVariant->setSmallimage($productId . "_vS$variantId.jpg");
                }
            }
        }

        return $productVariant;
    }

}
