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
    /** @var \App\Logger */
    protected $log;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->log = \App\Logger::getInstance();
    }

    /**
     *
     * @return array
     */
    public function index()
    {
        $queryes = $this->log->sql_getLog();
        $variables = $this->log->getDump();
        return array(
            'queryes'   => $queryes,
            'variables' => is_array($variables) ? $variables : array()
        );
    }

}
