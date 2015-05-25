<?php

namespace translator\classes;

(defined('BASEPATH')) OR exit('No direct script access allowed');

class PoFileSearch {

    /**
     * PoFileSearch instance
     * @var PoFileSearch object
     */
    private static $instance;

    /**
     * File path
     * @var type 
     */
    private $filePath;

    /**
     * Errors array
     * @var type 
     */
    private $errors = array();

    /**
     * File data 
     * @var type 
     */
    private $data;
    private $searchString;
    private $searchStringMinLength = 2;
    private $searchedPaths;
    private $searchResult;
    private $searchType = NULL;
    private $languages;
    private $poFileManager;

    private function __construct() {
        $this->searchedPaths = array(
            'modules' => DOCUMENT_ROOT . '/application/modules',
            'main' => DOCUMENT_ROOT . '/application/language',
            'templates' => TEMPLATES_PATH
        );

        $this->languages = \CI::$APP->db->get('languages')->result_array();
        $this->poFileManager = new PoFileManager();
    }

    /**
     * Get PoFileSearch instance
     * @return PoFileSearch
     */
    public static function getInstatce() {
        if (null === self::$instance)
            return self::$instance = new self();
        else
            return self::$instance;
    }

    private function setSearchString($searchString) {
        $searchString = trim($searchString);
        if (mb_strlen($searchString) >= $this->searchStringMinLength) {
            $this->searchString = $searchString;
        } else {
            throw new \Exception(lang('Search string can not be smaller then 2 symbols.', 'translator'));
        }
    }

    private function setSearchType($searchType) {
        $this->searchType = $searchType ? $searchType : 'all';
    }

    public function getSearchString() {
        return $this->searchString;
    }

    public function run($searchString, $searchType) {
        try {
            $this->setSearchString($searchString);
            $this->setSearchType($searchType);
            $this->search();
            $this->setData($this->searchResult);
            return TRUE;
        } catch (\Exception $exc) {
            $this->setError($exc->getMessage());
            return FALSE;
        }
    }

    private function search() {
        foreach ($this->searchedPaths as $entity_type => $path) {
            $this->scanSearchDir($entity_type, $path);
        }

        return $this->searchResult;
    }

    private function scanSearchDir($entity_type, $path) {
        foreach (new \DirectoryIterator($path) as $entity) {

            $entity_name = $entity->getFilename();
            if (!$entity->isDot() && $entity->isDir() && $entity_name[0] != '.') {

                foreach ($this->languages as $language) {
                    $po_file = $this->poFileManager->toArray($entity_name, $entity_type, $language['locale']);

                    foreach ($po_file['po_array'] as $origin => $data) {
                        $this->searchLang($origin, $data, $entity_type, $entity_name, $language);
                    }
                }
            }
        }
    }

    private function searchLang($origin, $data, $entity_type, $entity_name, $language) {
        switch ($this->searchType) {
            case 'all':
                if (strstr($origin, $this->searchString) || strstr($data['translation'], $this->searchString)) {
                    $data['origin'] = $origin;
                    $this->searchResult[$entity_type][$entity_name][$language['locale']][] = $data;
                }
                break;
            case 'origin':
                if (strstr($origin, $this->searchString)) {
                    $data['origin'] = $origin;
                    $this->searchResult[$entity_type][$entity_name][$language['locale']][] = $data;
                }
                break;
            case 'translation':
                if (strstr($data['translation'], $this->searchString)) {
                    $data['origin'] = $origin;
                    $this->searchResult[$entity_type][$entity_name][$language['locale']][] = $data;
                }
                break;
        }
    }

    /**
     * Set error
     * @param string $error - error text
     */
    private function setError($error) {
        $this->errors = $error;
    }

    /**
     * Get errors
     * @return type
     */
    public function getErrors() {
        return $this->errors;
    }

    /**
     * Set file data
     * @param string $data - file data
     */
    private function setData($data) {
        $this->data = $data;
    }

    /**
     * Get file data
     * @return string
     */
    public function getData() {
        return $this->data;
    }

}

?>