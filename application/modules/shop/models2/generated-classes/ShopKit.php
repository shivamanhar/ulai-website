<?php 

 use Base\ShopKit as BaseShopKit;
 
 use Propel\Runtime\ActiveQuery\Criteria;

/**
 * Skeleton subclass for representing a row from the 'shop_kit' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    propel.generator.Shop
 */
class ShopKit extends BaseShopKit {

    /**
     * return all attributes
     * @return array
     */
    public function attributeLabels() {
        return array(
            'Id' => ShopCore::t('ID'),
            'Active' => ShopCore::t('Активный'),
            'Name' => ShopCore::t('Название'),
            'Position' => ShopCore::t('Позиция'),
            'MainProduct' => ShopCore::t('Главный товар'),
            'MainProductId' => ShopCore::t('Главный товар'),
            'AttachedProductsIds' => ShopCore::t('Связанные товары'),
//            'Discount' => lang('Attached products'),
        );
    }

    private $price = 0;
    private $allPrice = 0;

    /**
     * Validation rules
     * @return array
     */
    public function rules() {
        return array(
            array(
                'field' => 'Active',
                'label' => $this->getLabel('Name'),
                'rules' => 'is_natural',
            ),
            array(
                'field' => 'Position',
                'label' => $this->getLabel('Position'),
                'rules' => 'is_natural',
            ),
            array(
                'field' => 'MainProductId',
                'label' => $this->getLabel('MainProductId'),
                'rules' => 'is_natural|required',
            ),
            array(
                'field' => 'AttachedProductsIds',
                'label' => $this->getLabel('AttachedProductsIds'),
                'rules' => 'required',
            ),
//            array(
//                'field' => 'Discounts[]',
//                'label' => lang('Attached products'),
//                'rules' => 'is_natural|required|less_than[101]',
//            ),
        );
    }

    private $arrayForCart = array('id' => array(), 'name' => array(), 'price' => array());

    /**
     * Return The atached to a kit SProducts objects
     * 
     * @param	string $modelAlias The alias of a model in the query
     * @param	Criteria $criteria Optional Criteria to build the query from
     * @return	SProducts|void
     */
    public function getAtachedProducts($criteria = null, $con = null) {
        $criteria = ShopKitProductQuery::create($criteria, $con)
                ->select(array('ProductId'));
        $pIds = $this->getShopKitProducts($criteria, $con)->toArray();

        if (!empty($pIds))
            return SProductsQuery::create()->findPks($pIds);
    }

    /**
     * Return main product SProducts object
     * 
     * @param	PropelPDO Optional Connection object.
     * @return	SProducts - main product of the kit. 
     */
    public function getMainProduct(PropelPDO $con = null) {
        return $this->getSProducts($con);
    }

    public function getShopKitProducts($criteria = null) {
        $criteria = $criteria === null ? ShopKitProductQuery::create()->orderByProductId(Criteria::ASC) : $criteria;

        $product = parent::getShopKitProducts($criteria);
        $this->arrayForCart = array('id' => array(), 'name' => array(), 'price' => array());

        foreach ($product as $kitProduct) {
            if (gettype($kitProduct) !== 'string') {
                $productPrice = $this->getSProducts();

                array_push($this->arrayForCart['name'], $kitProduct->getSProducts()->getName());
                array_push($this->arrayForCart['id'], (int) $kitProduct->getSProducts()->getId());
                
                $kitProduct->getSProducts()->getProductVariants(null,null,'kit');
                if ($kitProduct->getSProducts()->hasDiscounts())   
                    $beforePrice = $kitProduct->getSProducts()->getFirstVariant('kit')->getVirtual('origPrice');
                else
                    $beforePrice = $kitProduct->getSProducts()->getFirstVariant('kit')->getPrice();
                
                //$beforePrice = $kitProduct->getSProducts()->getFirstVariant('kit')->getPrice();

                $kitProduct->setVirtualColumn('beforePrice', $this->moneyFormat($beforePrice));
                $this->price = $beforePrice - ($beforePrice / 100 * $kitProduct->getDiscount());
                $kitProduct->setVirtualColumn('discountProductPrice', $this->moneyFormat($this->price));
                array_push($this->arrayForCart['price'], (float) $this->moneyFormat($this->price));
            }
        }
        return $product;
    }

    /**
     * Get summary price of kit without discounts
     * @return float
     */
    public function getAllPriceBefore() {
        $allPrice = $this->getCalculatePrice('all');
        $formatAllPrice = $allPrice + $this->getMainProductPrice();
        return $this->moneyFormat($formatAllPrice);
    }

    /**
     * Get summary price of kit with discounts
     * @return float
     */
    public function getTotalPrice($CS = null) {
        $price = $this->getMainProductPrice($CS);
        foreach ($this->getShopKitProducts() as $kit)
            $price += $kit->getKitNewPrice($CS);
        
        return $this->moneyFormat($price);
        
    }
    public function getTotalPriceOld($CS = null) {
        $price = $this->getMainProductPrice($CS);
        foreach ($this->getShopKitProducts() as $kit)
            $price += $kit->getKitProductPrice($CS);
        
        return $this->moneyFormat($price);
        
    }
    

    public function getCalculatePrice($type = NULL) {

        $this->allPrice = 0;

        foreach ($this->getShopKitProducts() as $kitProduct) {

            $productPrice = $kitProduct->getSProducts();
            
            $productPrice->getProductVariants(null,null,'kit');
            if ($productPrice->hasDiscounts())   
                $price = $productPrice->getFirstVariant('kit')->getVirtual('origPrice');
            else
                $price = $productPrice->getFirstVariant('kit')->getPrice();

           // $price = $productPrice->getFirstVariant('kit')->getPrice();

            if ($type === 'discount') {
                $this->price = $price - ($price / 100 * $kitProduct->getDiscount());
                $this->allPrice += $this->price;
            } elseif ($type === 'all') {

                $this->price = $price;
                $this->allPrice += $this->price;
            }
        }

        return $this->allPrice;
    }

    /**
     * return price of main product in kit
     * @return float
     */
    public function getMainProductPrice($CS = null) {
        $this->getMainProduct()->getProductVariants(null,null,'kit');
        if ($this->getMainProduct()->hasDiscounts())   
             $price = $this->getMainProduct()->getFirstVariant('kit')->getVirtual('origPrice');
        else
            $price = $this->getMainProduct()->getFirstVariant('kit')->getPrice();
        return \Currency\Currency::create()->convert($price, $CS);
    }

    public function moneyFormat($price) {
        $format = number_format($price, ShopCore::app()->SSettings->pricePrecision, '.', '');
        return $format;
    }

    public function countProducts() {
        return $this->getShopKitProducts()->count() - 1;
    }

    public function getNamesCart() {
        
        $names = array();
        $names[] = $this->getSProducts()->getName();
        foreach ($this->getShopKitProducts() as $kit)
            $names[] =  $kit->getSProducts()->getName();
        return $names;
        
    }

    public function getProductIdCart() {
        
        $ids = array();
        
        $ids[] = $this->getSProducts()->getid();
        foreach ($this->getShopKitProducts() as $kit)
            $ids[] = $kit->getSProducts()->getId();
        
        return $ids;

//        $this->arrayForCart['id'][] = (int) $this->getMainProduct()->getId();
//        return $this->arrayForCart['id'];
    }

    public function getPriceCart($CS) {
        $this->getMainProduct()->getProductVariants(null,null,'kit');
        $arr_price = array();
        $arr_price[] = floatval($this->getMainProductPrice($CS));
        foreach ($this->getShopKitProducts() as $kit)
            $arr_price[] += $this->moneyFormat($kit->getKitNewPrice($CS));
        
        return $arr_price;
        
    }
    public function getOrigPriceCart($CS) {
        $this->getMainProduct()->getProductVariants(null,null,'kit');
        $arr_price = array();
        $arr_price[] = floatval($this->getMainProductPrice($CS));
        foreach ($this->getShopKitProducts() as $kit)
            $arr_price[] += $this->moneyFormat($kit->getKitProductPrice($CS));
        
        return $arr_price;
        
    }
    
    
    public function getUrls(){
        $urls = array();
        
        $urls[] = shop_url('product/' . $this->getSProducts()->getUrl());
        foreach ($this->getShopKitProducts() as $kit)
            $urls[] = shop_url('product/' . $kit->getSProducts()->getUrl());
        
        return $urls;
            
    }
    
    public function getImgs(){
        $imgs = array();
        
        $imgs[] = $this->getSProducts()->firstVariant->getSmallPhoto();
        foreach ($this->getShopKitProducts() as $kit)
            $imgs[] =  $kit->getSProducts()->firstVariant->getSmallPhoto();
        
        return $imgs;
            
    }
    
    
    public function getKitStatus(){
        
        $item = $this->getSProducts();
        $arr[] = json_encode(promoLabelBtn($item->getAction(), $item->getHot(), $item->getHit(), 0));
        foreach ($this->getShopKitProducts() as $item)
            $arr[] = json_encode(promoLabelBtn($item->getSProducts()->getAction(), $item->getSProducts()->getHot(), $item->getSProducts()->getHit(), $item->getDiscount()));
        
        return $arr;
        
    }
    
    /***
     * 
     * Нові методи.
     */
}