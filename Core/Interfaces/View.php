<?php
/**
 * ILFATE PHP ENGINE
 * @autor Ilya Rubinchik ilfate@gmail.com
 * 2012
 */

namespace Core\Interfaces;

/**
 * Description of View
 *
 * @author ilfate
 */
interface View
{

    // render some data
    public function render($template, $values, array $layout);

}

?>
