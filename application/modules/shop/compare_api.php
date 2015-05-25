<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Compare Controller
 *
 * @uses ShopController
 * @package Shop
 * @version 0.1
 * @copyright 2010 Siteimage
 * @author <dev
 */
class Compare_api extends ShopController {

    public $forCompareIds = array();

    public function __construct() {
        parent::__construct();
    }

    /**
     * Load categories
     * @return type array
     */
    protected function _loadCategorys() {
        $ids = SProductsQuery::create()
                ->select('CategoryId')
                ->distinct()
                ->findPks($this->_getData())
                ->toArray();

        return SCategoryQuery::create()
                        ->filterById($ids)
                        ->find()
                        ->toArray();
    }

    /**
     * Add product to compare
     * @param int $productId
     */
    public function add($productId = null) {
        $response = array('success' => true, 'errors' => false);

        $model = SProductsQuery::create()
                ->findPk($productId);
        if ($model !== null) {
            $data = $this->_getData();

            if (!is_array($data))
                $data = array();

            if (!in_array($model->getId(), $data)) {
                $data[] = $model->getId();
                $this->session->set_userdata('shopForCompare', $data);
            }
        }
        else
            $response = array('success' => FALSE, 'errors' => 'not_valid_product');

        echo json_encode($response);
    }

    /**
     * Remove product from compare
     * @param int $productId
     */
    public function remove($productId = null) {
        $data = $this->_getData();
        $response = array('success' => true, 'errors' => false);

        if (is_array($data)) {
            $key = array_search($productId, $data);

            if ($key !== false)
                unset($data[$key]);

            $this->session->set_userdata('shopForCompare', $data);
        }
        else
            $response = array('success' => FALSE, 'errors' => 'not_valid_product');

        echo json_encode($response);
    }

    /**
     * Select products
     * @return type
     */
    protected function _loadProducts() {
        return SProductsQuery::create()
                        ->findPks($this->_getData());
    }

    /**
     * Get data from session
     * @return type
     */
    protected function _getData() {
        return $this->session->userdata('shopForCompare');
    }

    /**
     *
     * @return Json
     */
    public function calculate() {
        $ind = $this->input->post('ind');
        $val = $this->input->post('val');
        $rows = array_count_values($ind);
        foreach ($rows as $key => $value) {
            foreach ($ind as $k => $v) {
                if ($key == $v) {
                    $result[$key][] = $val[$k];
                }
            }
        }
        foreach ($result as $key => $value) {
            if (count(array_count_values($value)) == 1) {
                $fordelete[] = $key;
            }
        }
        if (count($fordelete) > 0) {
            //echo json_encode(array("dr" => $fordelete));

            foreach ($fordelete as $k => $v) {
                $string .= '[data-row="' . $v . '"]';
                if ($k < (count($fordelete) - 1)) {
                    $string .= " , ";
                }
            }
            $result = true;
        } else {
            $result = false;
            $string = false;
        }
        echo json_encode(array('result' => $result, 'selector' => $string));
    }

    public function sync() {
        echo json_encode($this->_getData());
    }

}

/* End of file compare.php */


