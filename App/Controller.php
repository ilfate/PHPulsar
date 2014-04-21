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
    public static $layout = array('html.tpl', 'head.tpl', 'layout.tpl');

}
