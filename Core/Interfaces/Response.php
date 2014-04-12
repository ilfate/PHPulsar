<?php
/**
 * ILFATE PHP ENGINE
 * @autor Ilya Rubinchik ilfate@gmail.com
 * 2012
 */

namespace Core\Interfaces;

/**
 * Description of Response
 *
 * @author ilfate
 */
interface Response
{
    public function __construct($result, View $view = null);

    public function getContent();

    public function setHeaders();
}
