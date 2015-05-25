<?php

namespace MediaManager;

abstract class BaseImageClass extends \ShopController{
    
   
    
    abstract public function resizeAll();

    abstract public function resizeById($arg);
    
    abstract public function resizeByIdAdditional($arg);

    abstract public function makeResizeAndWatermark($name);
    
    abstract public function makeResizeAndWatermarkAdditional($imageName);
    
    abstract public function checkWatermarks();
    
    abstract public function applyWatermark($imageName, $watermarkType);
    
    abstract public function checkOriginFolder();
    
    abstract public function checkImagesFolders();

    abstract public function getImageSettings();
    
    abstract public function getImageVarintsNames();

    abstract public function getImageSize($file_path);
    
    abstract public function autoMasterDim($width, $height);
    
    abstract public function deleteImagebyFullPath($path);
    
    abstract public function deleteAllProductImages($imageName);
}