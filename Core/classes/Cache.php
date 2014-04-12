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
class Cache
{

    const MEMCACHED = 'memcached';
    const MEMCACHE  = 'memcache';

    /** @var \Memcached */
    private static $cache;

    private static $local;

    protected static $preffix;

    public static function __staticConstruct()
    {
        self::init();
    }

    public static function init()
    {
        $cache   = self::getMemCache();
        $servers = self::getServers();
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
    protected static function getMemCache()
    {
        if (self::$cache !== null) {
            return self::$cache;
        } else {
            $extension = self::MEMCACHED;
            if (!extension_loaded($extension)) {
                throw new CacheError('Cache requires PHP ' . $extension . ' extension to be loaded');
            }
            self::$cache = new \Memcached();
            self::$cache->setOption(\Memcached::OPT_COMPRESSION, false);
            self::$cache->setOption(\Memcached::OPT_LIBKETAMA_COMPATIBLE, true);

            return self::$cache;
        }
    }

    private static function getServers()
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
    protected static function processKey($key)
    {
        if (empty(self::$preffix)) {
            $config        = Service::getConfig();
            self::$preffix = $config->get('cache_preffix') ? : $config->get('site_url');
        }
        if (strstr($key, self::$preffix) == $key) {
            return $key;
        }
        return self::$preffix . '_' . $key;
    }

    /**
     *
     * @param String $key
     *
     * @return mixed
     */
    public static function get($key)
    {
        $key = self::processKey($key);
        if (!isset(self::$local[$key])) {
            self::$local[$key] = self::$cache->get($key);
        }
        return self::$local[$key];
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
    public static function set($key, $value, $expire = 0, array $tags = null)
    {
        $key = self::processKey($key);
        if ($expire > 0) {
            $expire += time();
        } else {
            $expire = 0;
        }
        if ($tags) {
            $need_to_set = array();
            foreach ($tags as $tag) {
                // Try to append keys if tag exists
                $tag = self::processKey($tag);
                if (!self::$cache->append("__tag__" . $tag, "||" . $key)) {
                    $need_to_set["__tag__" . $tag] = $key;
                }
            }
            if (!empty($need_to_set)) {
                // Creating tags that are not exists
                self::$cache->setMulti($need_to_set);
            }
        }

        self::$local[$key] = $value;

        return self::$cache->set($key, $value, $expire);
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
    public static function add($key, $value, $expire, array $tags = null)
    {
        $key = self::processKey($key);
        if ($expire > 0) {
            $expire += time();
        } else {
            $expire = 0;
        }

        if ($tags) {
            $need_to_set = array();
            foreach ($tags as $tag) {
                // Try to append keys if tag exists
                $tag = self::processKey($tag);
                if (!self::$cache->append("__tag__" . $tag, "||" . $key)) {
                    $need_to_set["__tag__" . $tag] = $key;
                }
            }
            if (!empty($need_to_set)) {
                // Creating tags that are not exists
                self::$cache->setMulti($need_to_set);
            }
        }

        if (!isset(self::$local[$key])) {
            self::$local[$key] = $value;
        }
        return self::$cache->add($key, $value, $expire);
    }

    /**
     *
     * @param String $key
     *
     * @return Boolean
     */
    public static function delete($key)
    {
        $key = self::processKey($key);
        if (isset(self::$local[$key])) {
            unset(self::$local[$key]);
        }
        return self::$cache->delete($key, 0);
    }

    /**
     * Delete all keys that are marked with tag
     *
     * @param string $tag Tag
     *
     * @return boolean
     */
    public static function deleteTag($tag)
    {
        $tag  = self::processKey($tag);
        $keys = self::$cache->get("__tag__" . $tag);
        if ($keys) {
            $keys = explode("||", $keys);
            foreach ($keys as $key) {
                self::delete($key);
            }
            self::delete("__tag__" . $tag);
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
    public static function flush()
    {
        self::$local = array();
        return self::$cache->flush();
    }
}
