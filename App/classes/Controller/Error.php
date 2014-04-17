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
class Error extends Controller
{
    /**
     *
     * @return array
     */
    public function index()
    {
        return array(
            'error_num' => 404,
            'tpl'       => 'Error/errorPage.tpl'
        );
    }

    /**
     * @return array
     */
    public function page404()
    {
        return array(
            'error_num' => 404,
            'tpl'       => 'Error/errorPage.tpl'
        );
    }

    /**
     * @return array
     */
    public function page500()
    {
        return array(
            'error_num' => 500,
            'tpl'       => 'Error/errorPage.tpl'
        );
    }

}