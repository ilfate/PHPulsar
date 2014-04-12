<?php
/**
 * ILFATE PHP ENGINE
 * @autor Ilya Rubinchik ilfate@gmail.com
 * 2012
 */

namespace Core\Interfaces;

/**
 * Description of Service
 *
 * @author ilfate
 */
interface FrontController
{
    public static function preExecute();

    public static function postExecute();

}

