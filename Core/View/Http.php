<?php
/**
 * ILFATE PHP ENGINE
 * @autor Ilya Rubinchik ilfate@gmail.com
 * 2012
 */

namespace Core\View;

use Core\Exception\ViewHttpError;
use Core\View;

/**
 * Description of CoreView_Http
 *
 *
 * @author ilfate
 */
class Http extends View
{

    const TEMPLATE_FILE_EXTENSION = 'tpl';
    const TEMPLATE_PATH           = 'App/view/';

    private static $global_values = array();

    private $checked_files = array();

    public function __construct()
    {

    }

    /**
     * Renders a themplate
     *
     * @param       $render__template
     * @param array $render__values
     * @param array $render__layout
     *
     * @return string
     */
    public function render($render__template, $render__values = array(), array $render__layout = array())
    {
        $render__merged_values = array_merge(self::$global_values, $render__values);
        $render__file          = ILFATE_PATH . self::TEMPLATE_PATH . $render__template;

        $this->checkFile($render__file);

        extract($render__merged_values);
        ob_start();

        require $render__file;

        $html = ob_get_clean();

        if (!$render__layout) {
            return $html;
        } else {
            $layout_template           = array_pop($render__layout);
            $render__values['content'] = $html;
            return $this->render($layout_template, $render__values, $render__layout);
        }
    }

    /**
     * checks is file ok
     *
     * @param String $file
     *
     * @throws ViewHttpError
     */
    private function checkFile($file)
    {
        if (!isset($this->checked_files[$file])) {
            if (!file_exists($file)) {
                throw new ViewHttpError('Can`t locate template file at ' . $file);
            }
            $this->checked_files[$file] = true;
        }
    }

    /**
     * Alternative name for render
     *
     * @param string       $template
     * @param array|string $values
     *
     * @return string
     */
    public function inc($template, $values = array())
    {
        return $this->render($template, $values);
    }

    public static function setGlobal($name, $value)
    {
        self::$global_values[$name] = $value;
    }
}
