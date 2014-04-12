<?php
/**
 * ILFATE PHP ENGINE
 * @autor Ilya Rubinchik ilfate@gmail.com
 * 2012
 */

namespace Core\Response;

use Core\Exception\ResponseHttpError;
use Core\Response;
use Core\View;

/**
 * Description of CoreResponse_Http
 *
 *
 * @author ilfate
 */
class HttpAjax extends Response
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
     * @var string
     */
    private $content;

    /**
     *
     * @param array      $result
     * @param \Core\View $view
     *
     * @throws ResponseHttpError
     */
    public function __construct($result, View $view = null)
    {
        if (!is_array($result)) {
            throw new ResponseHttpError('Returned content of type Array expected');
        }
        $this->view   = $view;
        $this->result = $result;
    }

    /**
     * returns content
     */
    public function getContent()
    {
        if (!$this->content) {
            $tpl           = isset($this->result['tpl']) ? $this->result['tpl'] : '';
            $this->content = $this->view->render($tpl, $this->result, array());
        }
        return $this->content;
    }
}

