<?php

namespace MediaManager;

/**
 * Class for searching images at google
 *
 * @author nikolia27 (15-08-2013)
 *
 *
 *
 */
class GetImages {

    /**
     * Saves what types of images you can download
     * @var array
     */
    private $allowedMimeTypes = array(
        'image/jpeg',
        'image/png'
    );

    /**
     *
     * @var GetImages
     */
    private static $instance = NULL;

    /**
     * Unchanged part of url
     * @var string
     */
    private $baseUrl = "http://ajax.googleapis.com/ajax/services/search/images?v=1.0&as_filetype=jpg";

    /**
     * Param that can be
     * @var array
     */
    private $params = array(
        'upload_dir' => './uploads/shop/products/origin/',
        'imgsz' => 'large',
    );

    /**
     *
     * @param array $params
     */
    private function __construct($params) {
        if (is_array($params)) {
            foreach ($params as $key => $value) {
                if (key_exists($key, $this->params))
                    $this->params[$key] = $value;
            }
        }
    }

    private function __clone() {
        
    }

    /**
     * Creating an instance
     * @param array $params (optional)
     * @return GetImages
     */
    public static function create($params = NULL) {
        // create an instance if is not created or params are presents
        if (is_null(self::$instance) || !is_null($params)) {
            self::$instance = new GetImages($params);
        }
        return self::$instance;
    }

    public function searchImages($q, $start = 1) {
        if (!is_int($start) || !is_string($q))
            return FALSE;
        $q_ = urlencode($q);
        $url = $this->baseUrl
                . "&imgsz=" . $this->params['imgsz']
                . "&q=" . $q_
                . "&start=" . $start
                . "&rsz=8";
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_NOBODY, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $res = curl_exec($curl);
        curl_close($curl);
        $res = json_decode($res);
        $images = array();
        foreach ($res->responseData->results as $oneImageData) {
            $images[$oneImageData->imageId] = $oneImageData->url;
        }
        $images = $this->checkImages($images);
        return $images;
    }

    private function checkImages($imagesUrlArray) {
        foreach ($imagesUrlArray as $id => $url) {
            if (FALSE !== $this->getImage($url, 1)) {
                $imagesUrlArray[$id] = $url;
            } else {
                unset($imagesUrlArray[$id]);
            }
            //$this->offsetProgress();
        }
        //unlink($this->getProgressFileName());
        return $imagesUrlArray;
    }

    /**
     * Збереження прогресу перевірки зображень в файлі
     * @param int $count
     * @return boolean 
     */
    private function offsetProgress() {
        $fileName = $this->getProgressFileName();
        $currentProgress = $this->getProgress();
        return write_file($fileName, ++$currentProgress);
    }

    /**
     * 
     */
    public function getProgress() {
        $fileName = $this->getProgressFileName();

        if (!file_exists($fileName))
            return 0;

        if (FALSE === $progressData = file_get_contents($fileName))
            return 0;

        if (!is_numeric($progressData))
            return 0;

        return (int) $progressData;
    }

    /**
     * 
     * @return type
     */
    private function getProgressFileName() {
        $ci = & get_instance();
        $userId = $ci->dx_auth->get_user_id();
        return "uploads/g_img_pr_{$userId}.txt";
    }

    /**
     * Saves the image from url to specified folder (uploads/shop/products/origin/ by default)
     * @param string $url
     * @return string|bool filename on success or FALSE
     */
    public function saveImage($url) {
        if (FALSE != $image = $this->getImage($url)) {
            $CI = &get_instance();
            $CI->load->helper('translit');
            $ext = substr($url, strrpos($url, '.') + 1); // Формат
            $name = substr(basename($url), 0, strrpos(basename($url), '.')); // имя
            $imgName = translit_url($name);
            $imgName = $imgName.'.'.$ext;
            
            $CI->load->helper('file_helper');
            $writeStatus = write_file($this->params['upload_dir'] . $imgName, $image);
            return $writeStatus === FALSE ? FALSE : urldecode($imgName);
        }
        return FALSE;
    }
    
    /**
     * Returns the image contents or FALSE
     * @param string $url
     * @return boolean||string
     */
    public function getImage($url, $nobody = 0) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_NOBODY, $nobody);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, 2);
        $res = curl_exec($curl);
        $mimeType = curl_getinfo($curl, CURLINFO_CONTENT_TYPE);

        curl_close($curl);
        foreach ($this->allowedMimeTypes as $mimeType_) {
            if ($mimeType == $mimeType_) {

                return $res;
            }
        }

        return FALSE;
    }

    /**
     * Getting data form google api
     * @return type
     */
    public function getData($url) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_NOBODY, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $res = curl_exec($curl);
        curl_close($curl);
        $res = json_decode($res);
        $imagesData = array();
        foreach ($res->responseData->results as $oneImageData) {
            $imagesData[] = (array) $oneImageData;
        }
        return $imagesData;
    }

}

?>
