<?php
/**
 * ILFATE PHP ENGINE
 * @autor Ilya Rubinchik ilfate@gmail.com
 * 2012
 */

namespace Core;

use Core\Exception\CacheError;

/**
 * Cache class
 *
 * @author ilfate
 */
class Cache extends AbstractFactory
{

    const MEMCACHED = 'memcached';
    const MEMCACHE  = 'memcache';

    /** @var \Memcached */
    private $cache;

    private $local;

    protected $preffix;

    public function __construct()
    {
        $cache   = $this->getMemCache();
        $servers = $this->getServers();
        if (!$servers) {
            $cache->addServer('localhost', 11211);
        }
    }

    /**
     * Here we creates Memcache obj ans sets some params
     *
     * @throws CacheError if extension isn't loaded
     * @return \Memcached the memcache instance
     */
    protected function getMemCache()
    {
        if ($this->cache !== null) {
            return $this->cache;
        } else {
            $extension = self::MEMCACHED;
            if (!extension_loaded($extension)) {
                phpinfo();
                die;
                throw new CacheError('Cache requires PHP ' . $extension . ' extension to be loaded');
            }
            $this->cache = new \Memcached();
            $this->cache->setOption(\Memcached::OPT_COMPRESSION, false);
            $this->cache->setOption(\Memcached::OPT_LIBKETAMA_COMPATIBLE, true);

            return $this->cache;
        }
    }

    private function getServers()
    {
        return null;
    }

    /**
     * This adds preffix if it needs to.
     *
     * @param String $key
     *
     * @return string
     */
    protected function processKey($key)
    {
        if (empty($this->preffix)) {
            $config        = Service::getConfig();
            $this->preffix = $config->get('cache_preffix') ? : $config->get('site_url');
        }
        if (strstr($key, $this->preffix) == $key) {
            return $key;
        }
        return $this->preffix . '_' . $key;
    }

    /**
     *
     * @param String $key
     *
     * @return mixed
     */
    public function get($key)
    {
        $key = $this->processKey($key);
        if (!isset($this->local[$key])) {
            $this->local[$key] = $this->cache->get($key);
        }
        return $this->local[$key];
    }

    /**
     *
     * @param String $key
     * @param mixed  $value
     * @param int    $expire
     * @param array  $tags
     *
     * @return Boolean
     */
    public function set($key, $value, $expire = 0, array $tags = null)
    {
        $key = $this->processKey($key);
        if ($expire > 0) {
            $expire += time();
        } else {
            $expire = 0;
        }
        if ($tags) {
            $need_to_set = array();
            foreach ($tags as $tag) {
                // Try to append keys if tag exists
                $tag = $this->processKey($tag);
                if (!$this->cache->append("__tag__" . $tag, "||" . $key)) {
                    $need_to_set["__tag__" . $tag] = $key;
                }
            }
            if (!empty($need_to_set)) {
                // Creating tags that are not exists
                $this->cache->setMulti($need_to_set);
            }
        }

        $this->local[$key] = $value;

        return $this->cache->set($key, $value, $expire);
    }

    /**
     *
     * @param String  $key
     * @param mixed   $value
     * @param integer $expire
     * @param array   $tags
     *
     * @return Boolean
     */
    public function add($key, $value, $expire, array $tags = null)
    {
        $key = $this->processKey($key);
        if ($expire > 0) {
            $expire += time();
        } else {
            $expire = 0;
        }

        if ($tags) {
            $need_to_set = array();
            foreach ($tags as $tag) {
                // Try to append keys if tag exists
                $tag = $this->processKey($tag);
                if (!$this->cache->append("__tag__" . $tag, "||" . $key)) {
                    $need_to_set["__tag__" . $tag] = $key;
                }
            }
            if (!empty($need_to_set)) {
                // Creating tags that are not exists
                $this->cache->setMulti($need_to_set);
            }
        }

        if (!isset($this->local[$key])) {
            $this->local[$key] = $value;
        }
        return $this->cache->add($key, $value, $expire);
    }

    /**
     *
     * @param String $key
     *
     * @return Boolean
     */
    public function delete($key)
    {
        $key = $this->processKey($key);
        if (isset($this->local[$key])) {
            unset($this->local[$key]);
        }
        return $this->cache->delete($key, 0);
    }

    /**
     * Delete all keys that are marked with tag
     *
     * @param string $tag Tag
     *
     * @return boolean
     */
    public function deleteTag($tag)
    {
        $tag  = $this->processKey($tag);
        $keys = $this->cache->get("__tag__" . $tag);
        if ($keys) {
            $keys = explode("||", $keys);
            foreach ($keys as $key) {
                $this->delete($key);
            }
            $this->delete("__tag__" . $tag);
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

    /**
     * Flushes all cache
     * @return mixed
     */
    public function flush()
    {
        $this->local = array();
        return $this->cache->flush();
    }
}
