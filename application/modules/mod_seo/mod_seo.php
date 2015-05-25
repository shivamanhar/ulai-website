<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * 
 * @property Smartseo_model $seoexpert_model
 * @property Seoexpert_model_products $seoexpert_model_products
 * @author <dev 
 * @copyright ImageCMS (c) 2014
 */
class Mod_seo extends \MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('seoexpert_model');
        $this->load->model('seoexpert_model_products');
        $this->load->helper('translit');

        $lang = new MY_Lang();
        $lang->load('mod_seo');
    }

    public function index() {
        
    }

    public function autoload() {
        // Shop
        \CMSFactory\Events::create()->onSearchPageLoad()->setListener('_buildSearchMeta');
        \CMSFactory\Events::create()->onBrandPageLoad()->setListener('_buildBrandMeta');
        \CMSFactory\Events::create()->onProductPageLoad()->setListener('_buildProductsMeta');
        \CMSFactory\Events::create()->onCategoryPageLoad()->setListener('_buildCategoryMeta');

        // Core
//        \CMSFactory\Events::create()->on('Core:_mainPage')->setListener('_test');
//        \CMSFactory\Events::create()->on('Core:_displayPage')->setListener('_buildPageMeta');
//        \CMSFactory\Events::create()->on('Core:_displayCategory')->setListener('_test');
    }

    /**
     * Buld Meta tags for Shop Product
     * @param array $arg
     * @return boolean
     */
    public function _buildProductsMeta($arg) {

        $model = $arg['model'];
        $local = \MY_Controller::getCurrentLocale();

        $obj = new Mod_seo();



        // Get categories ids which has unique settings
        $uniqueCategories = \ShopCore::$ci->seoexpert_model_products->getCategoriesArray();

        // Check is common category or uniq
        if (in_array($model->getCategoryId(), $uniqueCategories)) {
            $settings = ShopCore::$ci->seoexpert_model_products->getProductCategory($model->getCategoryId(), $local);
            $settings = $settings['settings'];
        } else {
            $settings = ShopCore::$ci->seoexpert_model->getSettings($local);
        }

        // Is active
        if ($settings['useProductPattern'] != 1) {
            return FALSE;
        }

        // Use for Empty meta
            if ($settings['useBrandPatternForEmptyMeta'] == 1 && trim($model->getMetaTitle()) != '') {
                $template = trim($model->getMetaTitle());
            } else {
                $template = $settings['productTemplate'];
            }

            if ($settings['useBrandPatternForEmptyMeta'] == 1 && trim($model->getMetaDescription()) != '') {
                $templateDesc = trim($model->getMetaDescription());
            } else {
                $templateDesc = $settings['productTemplateDesc'];
            }

            if ($settings['useBrandPatternForEmptyMeta'] == 1 && trim($model->getMetaKeywords()) != '') {
                $templateKey = trim($model->getMetaKeywords());
            } else {
                $templateKey = $settings['productTemplateKey'];
            }        


        if ($model->getBrand()) {
            $brand = $model->getBrand()->getName();
        } else {
            $brand = '';
        }
        $descCount = $settings['productTemplateDescCount'];


        // Replace variables for title
        $template = (strstr($template, '%ID%')) ? str_replace('%ID%', $model->getId(), $template) : $template;
        $template = (strstr($template, '%name%')) ? str_replace('%name%', trim(str_replace(array('Дизайн интернет-магазина', 'Дизайн інтернет-магазину', 'Design online store'), '', $model->getName())), $template) : $template;
        // Product name translit
        $template = (strstr($template, '%name[t]%')) ? str_replace('%name[t]%', translit(trim(str_replace(array('Дизайн интернет-магазина', 'Дизайн інтернет-магазину', 'Design online store'), '', $model->getName()))), $template) : $template;

        $template = (strstr($template, '%category%')) ? str_replace('%category%', $model->getMainCategory()->getName(), $template) : $template;
        // category name translit
        $template = (strstr($template, '%category[t]%')) ? str_replace('%category[t]%', translit($model->getMainCategory()->getName()), $template) : $template;

        // the cases of words
        $template = (strstr($template, '%category[1]%')) ? str_replace('%category[1]%', $obj->inflect($model->getMainCategory()->getName(), 1), $template) : $template;
        $template = (strstr($template, '%category[2]%')) ? str_replace('%category[2]%', $obj->inflect($model->getMainCategory()->getName(), 2), $template) : $template;
        $template = (strstr($template, '%category[3]%')) ? str_replace('%category[3]%', $obj->inflect($model->getMainCategory()->getName(), 3), $template) : $template;
        $template = (strstr($template, '%category[4]%')) ? str_replace('%category[4]%', $obj->inflect($model->getMainCategory()->getName(), 4), $template) : $template;
        $template = (strstr($template, '%category[5]%')) ? str_replace('%category[5]%', $obj->inflect($model->getMainCategory()->getName(), 5), $template) : $template;
        $template = (strstr($template, '%category[6]%')) ? str_replace('%category[6]%', $obj->inflect($model->getMainCategory()->getName(), 6), $template) : $template;

        // the cases of words and translit
        $template = (strstr($template, '%category[1][t]%') || strstr($template, '%category[t][1]%')) ? str_replace(array('%category[1][t]%', '%category[t][1]%'), translit($obj->inflect($model->getMainCategory()->getName(), 1)), $template) : $template;
        $template = (strstr($template, '%category[2][t]%') || strstr($template, '%category[t][2]%')) ? str_replace(array('%category[2][t]%', '%category[t][2]%'), translit($obj->inflect($model->getMainCategory()->getName(), 2)), $template) : $template;
        $template = (strstr($template, '%category[3][t]%') || strstr($template, '%category[t][3]%')) ? str_replace(array('%category[3][t]%', '%category[t][3]%'), translit($obj->inflect($model->getMainCategory()->getName(), 3)), $template) : $template;
        $template = (strstr($template, '%category[4][t]%') || strstr($template, '%category[t][4]%')) ? str_replace(array('%category[4][t]%', '%category[t][4]%'), translit($obj->inflect($model->getMainCategory()->getName(), 4)), $template) : $template;
        $template = (strstr($template, '%category[5][t]%') || strstr($template, '%category[t][5]%')) ? str_replace(array('%category[5][t]%', '%category[t][5]%'), translit($obj->inflect($model->getMainCategory()->getName(), 5)), $template) : $template;
        $template = (strstr($template, '%category[6][t]%') || strstr($template, '%category[t][6]%')) ? str_replace(array('%category[6][t]%', '%category[t][6]%'), translit($obj->inflect($model->getMainCategory()->getName(), 6)), $template) : $template;


        $template = (strstr($template, '%brand%')) ? str_replace('%brand%', $brand, $template) : $template;
        $template = (strstr($template, '%brand[t]%')) ? str_replace('%brand[t]%', translit($brand), $template) : $template;

        $template = (strstr($template, '%price%')) ? str_replace('%price%', $model->firstVariant->toCurrency(), $template) : $template;
        $template = (strstr($template, '%CS%')) ? str_replace('%CS%', ShopCore::app()->SCurrencyHelper->getSymbol(), $template) : $template;

        // Replace variables for description
        $templateDesc = (strstr($templateDesc, '%ID%')) ? str_replace('%ID%', $model->getId(), $templateDesc) : $templateDesc;
        $templateDesc = (strstr($templateDesc, '%name%')) ? str_replace('%name%', $model->getName(), $templateDesc) : $templateDesc;
        $templateDesc = (strstr($templateDesc, '%name[t]%')) ? str_replace('%name[t]%', translit($model->getName()), $templateDesc) : $templateDesc;

        $templateDesc = (strstr($templateDesc, '%category%')) ? str_replace('%category%', $model->getMainCategory()->getName(), $templateDesc) : $templateDesc;
        $templateDesc = (strstr($templateDesc, '%brand%')) ? str_replace('%brand%', $brand, $templateDesc) : $templateDesc;
        $templateDesc = (strstr($templateDesc, '%brand[t]%')) ? str_replace('%brand[t]%', translit($brand), $templateDesc) : $templateDesc;

        $templateDesc = (strstr($templateDesc, '%desc%')) ? str_replace('%desc%', substr(strip_tags($model->getFullDescription()), 0, intval($descCount)), $templateDesc) : $templateDesc;
        $templateDesc = (strstr($templateDesc, '%price%')) ? str_replace('%price%', $model->firstVariant->toCurrency(), $templateDesc) : $templateDesc;
        $templateDesc = (strstr($templateDesc, '%CS%')) ? str_replace('%CS%', ShopCore::app()->SCurrencyHelper->getSymbol(), $templateDesc) : $templateDesc;

        // the cases of words
        $template = (strstr($template, '%name[1]%') || strstr($template, '%name[t][1]%') || strstr($template, '%name[1][t]%')) ? str_replace(array('%name[1]%', '%name[t][1]%', '%name[1][t]%'), array($obj->inflect($model->getName(), 1), translit($obj->inflect($model->getName(), 1)), translit($obj->inflect($model->getName(), 1))), $template) : $template;
        $template = (strstr($template, '%name[2]%') || strstr($template, '%name[t][2]%') || strstr($template, '%name[2][t]%')) ? str_replace(array('%name[2]%', '%name[t][2]%', '%name[2][t]%'), array($obj->inflect($model->getName(), 2), translit($obj->inflect($model->getName(), 2)), translit($obj->inflect($model->getName(), 2))), $template) : $template;
        $template = (strstr($template, '%name[3]%') || strstr($template, '%name[t][3]%') || strstr($template, '%name[3][t]%')) ? str_replace(array('%name[3]%', '%name[t][3]%', '%name[3][t]%'), array($obj->inflect($model->getName(), 3), translit($obj->inflect($model->getName(), 3)), translit($obj->inflect($model->getName(), 3))), $template) : $template;
        $template = (strstr($template, '%name[4]%') || strstr($template, '%name[t][4]%') || strstr($template, '%name[4][t]%')) ? str_replace(array('%name[4]%', '%name[t][4]%', '%name[4][t]%'), array($obj->inflect($model->getName(), 4), translit($obj->inflect($model->getName(), 4)), translit($obj->inflect($model->getName(), 4))), $template) : $template;
        $template = (strstr($template, '%name[5]%') || strstr($template, '%name[t][5]%') || strstr($template, '%name[5][t]%')) ? str_replace(array('%name[5]%', '%name[t][5]%', '%name[5][t]%'), array($obj->inflect($model->getName(), 5), translit($obj->inflect($model->getName(), 5)), translit($obj->inflect($model->getName(), 5))), $template) : $template;
        $template = (strstr($template, '%name[6]%') || strstr($template, '%name[t][6]%') || strstr($template, '%name[6][t]%')) ? str_replace(array('%name[6]%', '%name[t][6]%', '%name[6][t]%'), array($obj->inflect($model->getName(), 6), translit($obj->inflect($model->getName(), 6)), translit($obj->inflect($model->getName(), 6))), $template) : $template;

        // category name translit
        $templateDesc = (strstr($templateDesc, '%category[t]%')) ? str_replace('%category[t]%', translit($model->getMainCategory()->getName()), $templateDesc) : $templateDesc;

        // the cases of words
        $templateDesc = (strstr($templateDesc, '%category[1]%')) ? str_replace('%category[1]%', $obj->inflect($model->getMainCategory()->getName(), 1), $templateDesc) : $templateDesc;
        $templateDesc = (strstr($templateDesc, '%category[2]%')) ? str_replace('%category[2]%', $obj->inflect($model->getMainCategory()->getName(), 2), $templateDesc) : $templateDesc;
        $templateDesc = (strstr($templateDesc, '%category[3]%')) ? str_replace('%category[3]%', $obj->inflect($model->getMainCategory()->getName(), 3), $templateDesc) : $templateDesc;
        $templateDesc = (strstr($templateDesc, '%category[4]%')) ? str_replace('%category[4]%', $obj->inflect($model->getMainCategory()->getName(), 4), $templateDesc) : $templateDesc;
        $templateDesc = (strstr($templateDesc, '%category[5]%')) ? str_replace('%category[5]%', $obj->inflect($model->getMainCategory()->getName(), 5), $templateDesc) : $templateDesc;
        $templateDesc = (strstr($templateDesc, '%category[6]%')) ? str_replace('%category[6]%', $obj->inflect($model->getMainCategory()->getName(), 6), $templateDesc) : $templateDesc;

        // the cases of words and translit
        $templateDesc = (strstr($templateDesc, '%category[1][t]%') || strstr($templateDesc, '%category[t][1]%')) ? str_replace(array('%category[1][t]%', '%category[t][1]%'), translit($obj->inflect($model->getMainCategory()->getName(), 1)), $templateDesc) : $templateDesc;
        $templateDesc = (strstr($templateDesc, '%category[2][t]%') || strstr($templateDesc, '%category[t][2]%')) ? str_replace(array('%category[2][t]%', '%category[t][2]%'), translit($obj->inflect($model->getMainCategory()->getName(), 2)), $templateDesc) : $templateDesc;
        $templateDesc = (strstr($templateDesc, '%category[3][t]%') || strstr($templateDesc, '%category[t][3]%')) ? str_replace(array('%category[3][t]%', '%category[t][3]%'), translit($obj->inflect($model->getMainCategory()->getName(), 3)), $templateDesc) : $templateDesc;
        $templateDesc = (strstr($templateDesc, '%category[4][t]%') || strstr($templateDesc, '%category[t][4]%')) ? str_replace(array('%category[4][t]%', '%category[t][4]%'), translit($obj->inflect($model->getMainCategory()->getName(), 4)), $templateDesc) : $templateDesc;
        $templateDesc = (strstr($templateDesc, '%category[5][t]%') || strstr($templateDesc, '%category[t][5]%')) ? str_replace(array('%category[5][t]%', '%category[t][5]%'), translit($obj->inflect($model->getMainCategory()->getName(), 5)), $templateDesc) : $templateDesc;
        $templateDesc = (strstr($templateDesc, '%category[6][t]%') || strstr($templateDesc, '%category[t][6]%')) ? str_replace(array('%category[6][t]%', '%category[t][6]%'), translit($obj->inflect($model->getMainCategory()->getName(), 6)), $templateDesc) : $templateDesc;

        // Replace variables for key
        $templateKey = (strstr($templateKey, '%name%')) ? str_replace('%name%', $model->getName(), $templateKey) : $templateKey;
        $templateKey = (strstr($templateKey, '%category%')) ? str_replace('%category%', $model->getMainCategory()->getName(), $templateKey) : $templateKey;
        $templateKey = (strstr($templateKey, '%brand%')) ? str_replace('%brand%', $brand, $templateKey) : $templateKey;

        //Replace product properties by  property ID
        if (strstr($templateKey, '%p_') || strstr($templateDesc, '%p_') || strstr($template, '%p_')) {
            $productProperties = $model->getSProductPropertiesDatas();
            foreach ($productProperties as $key => $value) {
                $template = str_replace('%p_' . $value->getPropertyId() . '%', $value->getValue(), $template);
                $templateDesc = str_replace('%p_' . $value->getPropertyId() . '%', $value->getValue(), $templateDesc);
                $templateKey = str_replace('%p_' . $value->getPropertyId() . '%', $value->getValue(), $templateKey);
            }
        }

        //Set meta tags
        self::setMetaTags($template, $templateKey, mb_substr($templateDesc, 0), $descCount);
    }

    /**
     * Build Meta for Shop Category
     * @param array $arg
     * @return boolean
     */
    public function _buildCategoryMeta($arg) {

        $local = MY_Controller::getCurrentLocale();
        $model = $arg['category'];
        $settings = ShopCore::$ci->seoexpert_model->getSettings($local);

        $pageNumber = (int) \CMSFactory\assetManager::create()->getData('page_number');

        $obj = new Mod_seo();

        if ($model->getParentId()) {
            if ($settings['usesubcategoryPattern'] != 1) {
                return FALSE;
            }

            if ($settings['useBrandPatternForEmptyMeta'] == 1 && trim($model->getMetaTitle()) != '') {
                $template = trim($model->getMetaTitle());
            } else {
                $template = $settings['subcategoryTemplate'];
            }

            if ($settings['useBrandPatternForEmptyMeta'] == 1 && trim($model->getMetaDescription()) != '') {
                $templateDesc = trim($model->getMetaDescription());
            } else {
                $templateDesc = $settings['subcategoryTemplateDesc'];
            }

            if ($settings['useBrandPatternForEmptyMeta'] == 1 && trim($model->getMetaKeywords()) != '') {
                $templateKey = trim($model->getMetaKeywords());
            } else {
                $templateKey = $settings['subcategoryTemplateKey'];
            }

            $descCount = $settings['subcategoryTemplateDescCount'];
            $brandsCount = $settings['subcategoryTemplateBrandsCount'];
            $pagePattern = $settings['subcategoryTemplatePaginationTemplate'];
            $pagePattern = str_replace('%number%', $pageNumber, $pagePattern);
        } else {
            if ($settings['useCategoryPattern'] != 1) {
                return FALSE;
            }

            if ($settings['useBrandPatternForEmptyMeta'] == 1 && trim($model->getMetaTitle()) != '') {
                $template = trim($model->getMetaTitle());
            } else {
                $template = $settings['categoryTemplate'];
            }

            if ($settings['useBrandPatternForEmptyMeta'] == 1 && trim($model->getMetaDescription()) != '') {
                $templateDesc = trim($model->getMetaDescription());
            } else {
                $templateDesc = $settings['categoryTemplateDesc'];
            }

            if ($settings['useBrandPatternForEmptyMeta'] == 1 && trim($model->getMetaKeywords()) != '') {
                $templateKey = trim($model->getMetaKeywords());
            } else {
                $templateKey = $settings['categoryTemplateKey'];
            }

            $descCount = $settings['categoryTemplateDescCount'];
            $brandsCount = $settings['categoryTemplateBrandsCount'];
            $pagePattern = $settings['categoryTemplatePaginationTemplate'];
            $pagePattern = str_replace('%number%', $pageNumber, $pagePattern);
        }

        if (!$pagePattern || $pageNumber <= 1) {
            $pagePattern = "";
        }

        //Replace title variables
        //Replace title variables
        $template = (strstr($template, '%ID%')) ? str_replace('%ID%', $model->getId(), $template) : $template;
        $template = (strstr($template, '%name%')) ? str_replace('%name%', $model->getName(), $template) : $template;
        $template = (strstr($template, '%desc%')) ? str_replace('%desc%', substr(strip_tags($model->getDescription()), 0, intval($descCount)), $template) : $template;
        $template = (strstr($template, '%H1%')) ? str_replace('%H1%', $model->getH1(), $template) : $template;
        $template = (strstr($template, '%pagenumber%')) ? str_replace('%pagenumber%', $pagePattern, $template) : $template;

        // category name translit
        $template = (strstr($template, '%name[t]%')) ? str_replace('%name[t]%', translit($model->getName()), $template) : $template;

        // the cases of words
        $template = (strstr($template, '%name[1]%')) ? str_replace('%name[1]%', $obj->inflect($model->getName(), 1), $template) : $template;
        $template = (strstr($template, '%name[2]%')) ? str_replace('%name[2]%', $obj->inflect($model->getName(), 2), $template) : $template;
        $template = (strstr($template, '%name[3]%')) ? str_replace('%name[3]%', $obj->inflect($model->getName(), 3), $template) : $template;
        $template = (strstr($template, '%name[4]%')) ? str_replace('%name[4]%', $obj->inflect($model->getName(), 4), $template) : $template;
        $template = (strstr($template, '%name[5]%')) ? str_replace('%name[5]%', $obj->inflect($model->getName(), 5), $template) : $template;
        $template = (strstr($template, '%name[6]%')) ? str_replace('%name[6]%', $obj->inflect($model->getName(), 6), $template) : $template;

        // the cases of words and translit
        $template = (strstr($template, '%name[1][t]%') || strstr($template, '%name[t][1]%')) ? str_replace(array('%name[1][t]%', '%name[t][1]%'), translit($obj->inflect($model->getName(), 1)), $template) : $template;
        $template = (strstr($template, '%name[2][t]%') || strstr($template, '%name[t][2]%')) ? str_replace(array('%name[2][t]%', '%name[t][2]%'), translit($obj->inflect($model->getName(), 2)), $template) : $template;
        $template = (strstr($template, '%name[3][t]%') || strstr($template, '%name[t][3]%')) ? str_replace(array('%name[3][t]%', '%name[t][3]%'), translit($obj->inflect($model->getName(), 3)), $template) : $template;
        $template = (strstr($template, '%name[4][t]%') || strstr($template, '%name[t][4]%')) ? str_replace(array('%name[4][t]%', '%name[t][4]%'), translit($obj->inflect($model->getName(), 4)), $template) : $template;
        $template = (strstr($template, '%name[5][t]%') || strstr($template, '%name[t][5]%')) ? str_replace(array('%name[5][t]%', '%name[t][5]%'), translit($obj->inflect($model->getName(), 5)), $template) : $template;
        $template = (strstr($template, '%name[6][t]%') || strstr($template, '%name[t][6]%')) ? str_replace(array('%name[6][t]%', '%name[t][6]%'), translit($obj->inflect($model->getName(), 6)), $template) : $template;

        //Replace description variables
        $templateDesc = (strstr($templateDesc, '%ID%')) ? str_replace('%ID%', $model->getId(), $templateDesc) : $templateDesc;
        $templateDesc = (strstr($templateDesc, '%name%')) ? str_replace('%name%', $model->getName(), $templateDesc) : $templateDesc;
        $templateDesc = (strstr($templateDesc, '%desc%')) ? str_replace('%desc%', mb_substr(strip_tags($model->getDescription()), 0, intval($descCount)), $templateDesc) : $templateDesc;
        $templateDesc = (strstr($templateDesc, '%H1%')) ? str_replace('%H1%', $model->getH1(), $templateDesc) : $templateDesc;
        $templateDesc = (strstr($templateDesc, '%pagenumber%')) ? str_replace('%pagenumber%', $pagePattern, $templateDesc) : $templateDesc;

        // category name translit
        $templateDesc = (strstr($templateDesc, '%name[t]%')) ? str_replace('%name[t]%', translit($model->getName()), $templateDesc) : $templateDesc;

        // the cases of words
        $templateDesc = (strstr($templateDesc, '%name[1]%')) ? str_replace('%name[1]%', $obj->inflect($model->getName(), 1), $templateDesc) : $templateDesc;
        $templateDesc = (strstr($templateDesc, '%name[2]%')) ? str_replace('%name[2]%', $obj->inflect($model->getName(), 2), $templateDesc) : $templateDesc;
        $templateDesc = (strstr($templateDesc, '%name[3]%')) ? str_replace('%name[3]%', $obj->inflect($model->getName(), 3), $templateDesc) : $templateDesc;
        $templateDesc = (strstr($templateDesc, '%name[4]%')) ? str_replace('%name[4]%', $obj->inflect($model->getName(), 4), $templateDesc) : $templateDesc;
        $templateDesc = (strstr($templateDesc, '%name[5]%')) ? str_replace('%name[5]%', $obj->inflect($model->getName(), 5), $templateDesc) : $templateDesc;
        $templateDesc = (strstr($templateDesc, '%name[6]%')) ? str_replace('%name[6]%', $obj->inflect($model->getName(), 6), $templateDesc) : $templateDesc;

        // the cases of words and translit
        $templateDesc = (strstr($templateDesc, '%name[1][t]%') || strstr($templateDesc, '%name[t][1]%')) ? str_replace(array('%name[1][t]%', '%name[t][1]%'), translit($obj->inflect($model->getName(), 1)), $templateDesc) : $templateDesc;
        $templateDesc = (strstr($templateDesc, '%name[2][t]%') || strstr($templateDesc, '%name[t][2]%')) ? str_replace(array('%name[2][t]%', '%name[t][2]%'), translit($obj->inflect($model->getName(), 2)), $templateDesc) : $templateDesc;
        $templateDesc = (strstr($templateDesc, '%name[3][t]%') || strstr($templateDesc, '%name[t][3]%')) ? str_replace(array('%name[3][t]%', '%name[t][3]%'), translit($obj->inflect($model->getName(), 3)), $templateDesc) : $templateDesc;
        $templateDesc = (strstr($templateDesc, '%name[4][t]%') || strstr($templateDesc, '%name[t][4]%')) ? str_replace(array('%name[4][t]%', '%name[t][4]%'), translit($obj->inflect($model->getName(), 4)), $templateDesc) : $templateDesc;
        $templateDesc = (strstr($templateDesc, '%name[5][t]%') || strstr($templateDesc, '%name[t][5]%')) ? str_replace(array('%name[5][t]%', '%name[t][5]%'), translit($obj->inflect($model->getName(), 5)), $templateDesc) : $templateDesc;
        $templateDesc = (strstr($templateDesc, '%name[6][t]%') || strstr($templateDesc, '%name[t][6]%')) ? str_replace(array('%name[6][t]%', '%name[t][6]%'), translit($obj->inflect($model->getName(), 6)), $templateDesc) : $templateDesc;

        ////Replace keywords variables
        $templateKey = (strstr($templateKey, '%ID%')) ? str_replace('%ID%', $model->getId(), $templateKey) : $templateKey;
        $templateKey = (strstr($templateKey, '%name%')) ? str_replace('%name%', $model->getName(), $templateKey) : $templateKey;
        $templateKey = (strstr($templateKey, '%desc%')) ? str_replace('%desc%', substr(strip_tags($model->getDescription()), 0, intval($descCount)), $templateKey) : $templateKey;
        $templateKey = (strstr($templateKey, '%H1%')) ? str_replace('%H1%', $model->getH1(), $templateKey) : $templateKey;
        $templateKey = (strstr($templateKey, '%pagenumber%')) ? str_replace('%pagenumber%', $pagePattern, $templateKey) : $templateKey;

        if (strstr($template, '%brands%') || strstr($templateDesc, '%brands%') || strstr($templateKey, '%brands%')) {
            // Prepare brands for meta
            $brands = ShopCore::$ci->seoexpert_model->getTopBrandsInCategory($model->getId(), $brandsCount);

            $brandsString = "";
            foreach ($brands as $key => $value) {
                $brandsString[] = $value['name'];
            }
            $brandsString = implode(', ', $brandsString);

            $template = str_replace('%brands%', $brandsString, $template);
            $templateDesc = str_replace('%brands%', $brandsString, $templateDesc);
            $templateKey = str_replace('%brands%', $brandsString, $templateKey);
        }

        // Set meta tags
        self::setMetaTags($template, $templateKey, mb_substr($templateDesc, 0));
    }

    /**
     * Build Meta for Shop Brand
     * @param array $arg
     * @return boolean
     */
    public function _buildBrandMeta($arg) {
        /**
         * Let's do the harlem shake!!!
         */
        if (++ShopCore::$ci->mod_seo->storage > 2) {
            return FALSE;
        }

        $pageNumber = (int) \CMSFactory\assetManager::create()->getData('page_number');

        $local = MY_Controller::getCurrentLocale();
        $model = $arg['model'];
        $settings = ShopCore::$ci->seoexpert_model->getSettings($local);
        $baseSetting = ShopCore::$ci->seoexpert_model->getBaseSettings(ShopCore::$ci->config->item('cur_lang'));
//         ["create_keywords"]=> string(5) "empty" ["create_description"]=> string(4) "auto"
        if ($settings['useBrandPattern'] != 1) {
            return FALSE;
        }

        if ($settings['useBrandPatternForEmptyMeta'] == 1 && trim($model->getMetaTitle()) != '') {
            $template = trim($model->getMetaTitle());
        } else {
            $template = $settings['brandTemplate'];
        }

        if ($settings['useBrandPatternForEmptyMeta'] == 1 && trim($model->getMetaDescription()) != '') {
            $templateDesc = trim($model->getMetaDescription());
        } else {
            $templateDesc = $settings['brandTemplateDesc'];
        }

        if ($settings['useBrandPatternForEmptyMeta'] == 1 && trim($model->getMetaKeywords()) != '') {
            $templateKey = trim($model->getMetaKeywords());
        } else {
            $templateKey = $settings['brandTemplateKey'];
        }
        
        $descCount = $settings['brandTemplateDescCount'];
        $pagePattern = $settings['brandPaginationTemplate'];
        $pagePattern = str_replace('%number%', $pageNumber, $pagePattern);


        if (!$pagePattern || $pageNumber <= 1) {
            $pagePattern = "";
        }

        $template = str_replace('%ID%', $model->getId(), $template);
        $template = str_replace('%name%', $model->getName(), $template);
        $template = str_replace('%name[t]%', translit($model->getName()), $template);
        $template = str_replace('%desc%', mb_substr(strip_tags($model->getDescription()), 0, intval($descCount)), $template);
        $template = str_replace('%pagenumber%', $pagePattern, $template);

        $templateDesc = str_replace('%ID%', $model->getId(), $templateDesc);
        $templateDesc = str_replace('%name%', $model->getName(), $templateDesc);
        $templateDesc = str_replace('%name[t]%', translit($model->getName()), $templateDesc);
        $templateDesc = str_replace('%desc%', mb_substr(strip_tags($model->getDescription()), 0, intval($descCount)), $templateDesc);
        $templateDesc = str_replace('%pagenumber%', $pagePattern, $templateDesc);

        $templateKey = str_replace('%name%', $model->getName(), $templateKey);
        $templateKey = str_replace('%name[t]%', translit($model->getName()), $templateKey);
        $templateKey = str_replace('%pagenumber%', $pagePattern, $templateKey);

        self::setMetaTags($template, $templateKey, mb_substr($templateDesc, 0));
    }

    public function _buildSearchMeta($arg) {
        /**
         * Let's do the harlem shake!!!
         */
        if (++ShopCore::$ci->mod_seo->storage > 2) {
            return FALSE;
        }

        $local = MY_Controller::getCurrentLocale();
        $settings = ShopCore::$ci->seoexpert_model->getSettings($local);

        if ($settings['useSearchPattern'] != 1) {
            return FALSE;
        }

        $template = $settings['searchTemplate'];
        $templateDesc = $settings['searchTemplateDesc'];
        $templateKey = $settings['searchTemplateKey'];

        self::setMetaTags($template, $templateKey, mb_substr($templateDesc, 0));
    }

    /**
     * Inflect words
     * @param string $what
     * @param int $inflection_id (1-6) - the cases of words
     * @return string
     */
    private function inflect($what, $inflection_id) {
        $resInflected = $this->db
                ->where('original', $what)
                ->where('inflection_id', $inflection_id)
                ->get('mod_seo_inflect')
                ->row_array();

        $foundRes = FALSE;
        if ($resInflected) {
            $inflected = $resInflected['inflected'];
        } else {
            $parser = xml_parser_create();
            $data = @file_get_contents('http://export.yandex.ru/inflect.xml?name=' . urlencode($what));
            if ($data) {
                xml_parse_into_struct($parser, $data, $structure);

                if ($structure) {
                    foreach ($structure as $key) {

                        if (!isset($key['tag']) || !isset($key['value']))
                            continue;
                        elseif ($key['tag'] == 'INFLECTION') {


                            if ($key['attributes']['CASE'] == $inflection_id) {
                                $foundRes = TRUE;

                                $inflected = $key['value'];
                                $dataArray = array(
                                    'original' => $what,
                                    'inflection_id' => $inflection_id,
                                    'inflected' => $inflected,
                                );

                                $res_inflected = $this->db
                                        ->insert('mod_seo_inflect', $dataArray);
                            }
                        }
                    }


                    if ($foundRes !== TRUE) {
                        for ($i = 2; $i <= 6; $i++) {
                            $dataArray = array(
                                'original' => $what,
                                'inflection_id' => $i,
                                'inflected' => $what,
                            );

                            $this->db
                                    ->insert('mod_seo_inflect', $dataArray);
                        }
                    }
                }
            }
            xml_parser_free($parser);
        }
        if ($inflected == "")
            $inflected = $what;

        return $inflected;
    }

    private static function setMetaTags($template, $templateKey, $templateDesc) {
        //clean up unused properties
        $template = preg_replace('/%.*%/', '', $template);
        $templateKey = preg_replace('/%.*%/', '', $templateKey);
        $templateDesc = preg_replace('/%.*%/', '', $templateDesc);

        $template = str_replace('&nbsp;', ' ', $template);
        $templateKey = str_replace('&nbsp;', ' ', $templateKey);
        $templateDesc = str_replace('&nbsp;', ' ', $templateDesc);

        ShopCore::$ci->core->set_meta_tags($template, $templateKey, mb_substr($templateDesc, 0));
    }

    public function _install() {
        ShopCore::$ci->seoexpert_model->install();
    }

    public function _deinstall() {
        ShopCore::$ci->seoexpert_model->deinstall();
    }

}

/* End of file mod_smart_seo.php */
