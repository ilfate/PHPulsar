<?php
/**
 * ILFATE PHP ENGINE
 * @autor Ilya Rubinchik ilfate@gmail.com
 * 2012
 */

namespace Core\Response;

use Core\Exception\ResponseHttpError;
use Core\Interfaces\View;
use Core\Response;

/**
 * Description of CoreResponse_Http
 *
 *
 * @author ilfate
 */
class Ajax extends Response
{
    /**
     *
     * @var View
     */
    private $view;

    /**
     *
     * @var array
     */
    private $result;

    /**
     *
     * @param array                 $result
     * @param \Core\Interfaces\View $view
     *
     * @throws \Core\Exception\ResponseHttpError
     */
    public function __construct($result, View $view = null)
    {
        if (!is_array($result)) {
            throw new ResponseHttpError('Returned content of type Array expected');
        }

        $this->result = $result;
    }

    /**
     * returns content
     */
    public function getContent()
    {
        return json_encode($this->result);
    }
}
