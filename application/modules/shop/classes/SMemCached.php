<?php
/**
 * SMemCached - Cache shop pages
 */
 
class SMemCached {

    private $expire;
    private $memcache;
    private $ismemcache = false;
    private $settings;

    public function __construct(){
        $this->loadSettings();
        if ($this->settings['MEMCACHE_ON'] && $this->settings['CACHE_DRIVER'] == 'memcached'){
            $mc = new Memcache;
            
            if ($mc->pconnect($this->settings['MEMCACHE_HOSTNAME'], $this->settings['MEMCACHE_PORT'])) {
                $this->memcache = $mc;
                $this->ismemcache = true;
            }
        }
        
        $files = glob('system/cache/MemCached_' . 'cache.*');
        
        if ($files) {
            foreach ($files as $file) {
                $time = substr(strrchr($file, '.'), 1);
                
                if ($time < time())
                    if (file_exists($file))
                        @unlink($file);
            }
        }
    }
    
    public function get($key) {
        if (($this->settings['CACHE_DRIVER'] == 'memcached') && $this->ismemcache) {
            return($this->memcache->get($this->settings['MEMCACHE_NAMESPACE'] . $key, 0));
        } else {
            $files = glob('system/cache/MemCached_' . 'cache.' . $key . '.*');

            if ($files) {
                foreach ($files as $file) {
                    $cache = '';
                    $handle = fopen($file, 'r');

                    if ($handle) {
                        $cache = fread($handle, filesize($file));
                        fclose($handle);
                    }

                    return unserialize($cache);
                }
            }
        }
    }

    public function set($key, $value){
        if (($this->settings['CACHE_DRIVER'] == 'memcached') && $this->ismemcache) {
            $this->memcache->set($this->settings['MEMCACHE_NAMESPACE'] . $key, $value, MEMCACHE_COMPRESSED, $this->settings['CACHE_EXPIRES']);
        } else {
            $this->delete($key);
            $file = 'system/cache/MemCached_' . 'cache.' . $key . '.' . (time() + $this->settings['CACHE_EXPIRES']);
            $handle = fopen($file, 'w');
            fwrite($handle, serialize($value));
            fclose($handle);
        }
    }

    public function delete($key){
        if (($this->settings['CACHE_DRIVER'] == 'memcached') && $this->ismemcache)
            $this->memcache->delete($this->settings['MEMCACHE_NAMESPACE'] . $key, 0);
        
        else {
            $files = glob('system/cache/MemCached_' . 'cache.' . $key . '.*');
            
            if ($files){
                foreach ($files as $file){
                    if (file_exists($file)){
                        @unlink($file);
                        clearstatcache();
                    }
                }
            }
        }
    }
    
    public function loadSettings(){
        $model = ShopSettingsQuery::create()
                ->filterByName('MemcachedSettings')
                ->findOne();
        
        if (sizeof($model) > 0) {
            $this->settings = unserialize($model->getValue());
        } else {
            $this->settings['MEMCACHE_ON'] = FALSE;
            $this->settings['CACHE_DRIVER'] = 'memcached';
            $this->settings['MEMCACHE_HOSTNAME'] = 'localhost';
            $this->settings['MEMCACHE_PORT'] = '11211';
            $this->settings['MEMCACHE_NAMESPACE'] = 'imagecms_shop';
            $this->settings['CACHE_EXPIRES'] = '3600';

            $model = new ShopSettings();
            $model->setName('MemcachedSettings');
            $model->setValue(serialize($this->settings));
            $model->save();
        }

        return $this->settings;
    }
}