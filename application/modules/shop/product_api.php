<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Shop Product Controller
 * @package Shop
 * @copyright 2013 ImageCMS
 * @author <dev
 * @property model SProducts
 */
class Product_api extends ShopController {

    public function __construct() {
        parent::__construct();
    }

    /**
     * render product properties
     * @return type
     */
    public function renderProperties() {
        
        $product_id = $this->input->post('product_id');

        $product = SProductsQuery::create()->joinWithI18n(MY_Controller::getCurrentLocale())->findPk($product_id);
        $properties = $product->getProductProperties('showOnProductPage');
        if ($properties) {
            $result = "<table><tbody>";
            foreach ($properties as $key => $value) {
                $result .= '<tr>';
                $result .= '<th>' . $key . '</th>';
                $result .= '<td>' . implode(', ', $value) . '</td>';
                $result .= '</tr>';
            }
            $result .= "</tbody></table>";
            return $result;
        } else {
            return FALSE;
        }
    }

    /**
     * render product full description
     * @return type
     */
    public function renderFullDescription() {
        $product_id = $this->input->post('product_id');
        $product = SProductsQuery::create()->joinWithI18n(MY_Controller::getCurrentLocale())->findPk($product_id);
        $description = $product->getFullDescription();

        if ($description)
            return $description;
        else
            return FALSE;
    }

    /**
     * get product accessories
     * @return type
     */
    public function getAccessories() {
        $product_id = $this->input->post('product_id');
        $data = $this->input->post('arrayVars');
        $tpl = $this->input->post('tpl') ? $this->input->post('tpl') : 'one_product_item';

        $product = SProductsQuery::create()->joinWithI18n(MY_Controller::getCurrentLocale())->findPk($product_id);

        $accessories = $product->getRelatedProductsModels();
        $CI = &get_instance();
        $accessories = getOPI($accessories, $data, $tpl);
        echo $accessories;
    }

}

/** End of file application/modules/shop/product.php  */