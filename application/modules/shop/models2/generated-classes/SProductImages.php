<?php 

 use Base\SProductImages as BaseSProductImages;



/**
 * Skeleton subclass for representing a row from the 'shop_product_images' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    propel.generator.Shop
 */
class SProductImages extends BaseSProductImages {

    /**
     * @return string
     */
    public function getUrl()
    {
        return '/uploads/shop/products/additional/' . $this->getImageName();
    }

    /**
     * @return string relative path to image thumb
     */
    public function getThumbUrl()
    {
        $filePath = '/uploads/shop/products/additional/thumb_' . $this->getImageName();
        // Fix for older versions
        if(file_exists('.'.$filePath))
            return $filePath;
        else
            return '/uploads/shop/'.$this->getImageName();
    }

    /**
     * Delete files
     * @return bool
     */
    public function postDelete()
    {
        // Delete additional image
        if (file_exists(ShopCore::$imagesUploadPath.$this->getImageName()))
            @unlink(ShopCore::$imagesUploadPath.$this->getImageName());

        // Delete additional image thumb
        if (file_exists(ShopCore::$imagesUploadPath.'additionalImageThumbs/'.$this->getImageName()))
            @unlink(ShopCore::$imagesUploadPath.'additionalImageThumbs/'.$this->getImageName());

        return true;
    }

} // SProductImages
