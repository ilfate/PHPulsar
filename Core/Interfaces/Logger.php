<?php
/**
 * ILFATE PHP ENGINE
 * @autor Ilya Rubinchik ilfate@gmail.com
 * 2014
 */

namespace Core\Interfaces;

/**
 * Logger
 *
 * @author ilfate
 */
interface Logger {
    public function addQuery();

    public function getLog();

    public function start($query);

    public function finish();
}