<?php
/**
 * ILFATE PHP ENGINE
 * @autor Ilya Rubinchik ilfate@gmail.com
 * 2012
 */

namespace App\Controller;

use App\Controller;

/**
 * Description of Main
 *
 * @author ilfate
 */
class Logger extends Controller
{
    /**
     *
     * @return array
     */
    public function index()
    {
        $queryes   = \App\Logger::sql_getLog();
        $variables = \App\Logger::getDump();
        return array(
            'queryes'   => $queryes,
            'variables' => is_array($variables) ? $variables : array()
        );
    }

}
