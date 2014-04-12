<?php
/**
 * ILFATE PHP ENGINE
 * @autor Ilya Rubinchik ilfate@gmail.com
 * 2012
 */

namespace Core\Response;

use Core\Exception\ResponseHttpError;
use Core\Interfaces\View;
use Core\Request;
use Core\Response;
use Core\Service;

/**
 * Description of CoreResponse_Http
 *
 *
 * @author ilfate
 */
class Http extends Response
{
    /**
     *
     * @var View
     */
    private $view;

    /**
     * @var array
     */
    private $result;

    /**
     * @var string
     */
    private $content;

    /**
     * @var string
     */
    private $layout = array();

    /**
     * @param array                 $result
     * @param \Core\Interfaces\View $view
     *
     * @throws ResponseHttpError
     */
    public function __construct($result, View $view = null)
    {
        if (!is_array($result)) {
            throw new ResponseHttpError('Returned content of type Array expected');
        }

        if (!$view) {
            throw new ResponseHttpError('ResponseHttp needs View to build response');
        }
        $this->view = $view;
        if (!isset($result['tpl'])) {
            $result['tpl'] = $this->getTemplateByRoute();
        }

        if (!isset($result['layout'])) {
            if (Service::getRequest()->getExecutingMode() == Request::EXECUTE_MODE_HTTP) {
                $result['layout'] = Service::getRouting()->getDefaultLayout();
            } else {
                $result['layout'] = array();
            }
        }

        $this->layout = $result['layout'];
        unset($result['layout']);
        $this->result = $result;

    }

    /**
     * If no template specified response will set default template for this action
     *
     * @return string
     */
    private function getTemplateByRoute()
    {
        $routing = Service::getRouting();
        return $routing->getClass() . '/' . $routing->getMethod() . '.' . \Core\View\Http::TEMPLATE_FILE_EXTENSION;
    }

    /**
     * returns content
     */
    public function getContent()
    {
        if (!$this->content) {
            $tpl           = isset($this->result['tpl']) ? $this->result['tpl'] : '';
            $this->content = $this->view->render($tpl, $this->result, $this->layout);
        }
        return $this->content;
    }
}
