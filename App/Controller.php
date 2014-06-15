<?php
/**
 * ILFATE PHP ENGINE
 * @autor Ilya Rubinchik ilfate@gmail.com
 * 2012
 */

namespace App;

use Core\CachingClass;

/**
 * Controller class
 *
 * @author ilfate
 */
class Controller extends CachingClass
{
    /**
     * The list of layouts. Executed in backward direction
     *
     * @var array
     */
    public static $layout = array('html.tpl', 'head.tpl', 'layout.tpl');

    /** @var Cache */
    protected $cache;

    /** @var Logger */
    protected $log;

    /** Constructor */
    public function __construct()
    {
        $this->cache = Cache::getInstance();
        $this->log   = Logger::getInstance();
    }

}
