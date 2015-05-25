<?php

/**
 * require_once APPPATH . 'libraries' . DIRECTORY_SEPARATOR . 'ClassLoader.php';
 * ClassLoader::getInstance()
 *     ->registerNamespacedPath(APPPATH)
 *     ->registerNamespacedPath(APPPATH . 'modules');
 * 
 * @author ailok <m.kecha
 *
 */
class ClassLoader {

    const EXT = '.php';

    private static $instance;
    private $namespacedPaths = [];
    private $classesPaths = [];

    private function __construct() {
        (version_compare(PHP_VERSION, '5.3.0') >= 0) OR die('Namespaces requires PHP 5.3 or higher');
        spl_autoload_register([$this, 'autoload'], false);
    }

    private function __clone() {
        
    }

    /**
     * 
     * @return ClassLoader
     */
    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    private function checkPathExists($path) {
        if (!is_dir($path)) {
            throw new \Exception('Error registering [' . $path . '] - folder do not exist');
        }
    }

    public function registerNamespacedPath($path) {
        $this->checkPathExists($path);
        if (!in_array($path, $this->namespacedPaths)) {
            $this->namespacedPaths[] = $path;
        }
        return $this;
    }

    public function registerClassesPath($path) {
        $this->checkPathExists($path);
        if (!in_array($path, $this->classesPaths)) {
            $this->classesPaths[] = $path;
        }
        return $this;
    }

    public function autoload($className) {
        $className = ltrim($className, '\\');
        if (strpos($className, '\\') > 0) {
            $this->loadNamespacedClass($className);
        } else {
            $this->loadClass($className);
        }
    }

    private function loadNamespacedClass($className) {
        $namespacedClassPath = str_replace('\\', DIRECTORY_SEPARATOR, $className);
        for ($i = 0; $i < count($this->namespacedPaths); $i++) {
            $classPath = rtrim($this->namespacedPaths[$i], DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $namespacedClassPath . self::EXT;
            if (file_exists($classPath)) {
                require_once $classPath;
                return;
            }
        }
    }

    private function loadClass($className) {
        for ($i = 0; $i < count($this->classesPaths); $i++) {
            $classPath = rtrim($this->classesPaths[$i], DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $className . self::EXT;
            if (file_exists($classPath)) {
                require_once $classPath;
                return;
            }
        }
    }

}
