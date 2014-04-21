<?php
/**
 * ILFATE PHP ENGINE
 * @autor Ilya Rubinchik ilfate@gmail.com
 * 2012
 */

namespace Core;

/**
 * Helper class
 *
 * @author ilfate
 */
class Helper
{

    /**
     * Creates new core execution ( like open link with anther link )
     * And return result of this execution
     * instead of url we use here direct class and method names
     * it is just simplier and faster coz we dont need to use Routing
     *
     * @param string $class  Class name that we want to execute
     * @param string $method Method name that we want to excute
     * @param array  $get    Array with all get params that we want to pass to
     *                       that script. It will have its own GET array
     * @param array  $post   Array with all post params that we want to pass to
     *                       that script. It will have its own POST array
     *
     * @return string
     */
    public static function exe($class, $method, $get = null, $post = null)
    {
        return Core::subExecute($class, $method, $get, $post);
    }

    /**
     * This function returns html div with loading div that will be showed while
     * ajax content of $class $mathod will be loading.
     * After loading that content will be placed in that div instead of Gif
     *
     * @param string $class
     * @param string $method
     * @param string $get
     *
     * @return string
     */
    public static function exeAjax($class, $method, $get = null)
    {
        $div_id = 'ajax_load_' . mt_rand(1000, 9999);
        $url    = self::url($class, $method, $get);
        Js::add(Js::C_ONAFTERLOAD, 'Ajax.html("' . $url . '", "#' . $div_id . '")');
        return '<div class="ajax_load" id="' . $div_id . '"><div class="loader"></div></div>';
    }

    /**
     * Generates url using Roution to create url from path
     *
     * @param String $class
     * @param String $method
     * @param array  $get
     *
     * @return String
     */
    public static function url($class = null, $method = null, array $get = null)
    {
        if (!$class) {
            $class = Routing::DEFAULT_CLASS;
        }
        if (!$method) {
            $method = Routing::DEFAULT_METHOD;
        }
        $url = Service::getRouting()->getUrl($class, $method);
        if ($get) {
            $url .= (strpos($url, '?') === false) ? '?' : '&';
            $url .= http_build_query($get);
        }
        return $url;
    }

    /**
     * Generates url using Roution to create url from path
     *
     * @param String $class
     * @param String $method
     * @param array  $get
     *
     * @return String
     */
    public static function urlAjax($class = null, $method = null, array $get = null)
    {
        $get = array_merge((array) $get, array(Request::PARAM_AJAX => 'true'));
        return self::url($class, $method, $get);
    }

    /**
     * Redirects to some route
     *
     * @param string $class
     * @param string $method
     * @param array  $get
     */
    public static function redirect($class = null, $method = null, array $get = null)
    {
        $url = Helper::url($class, $method, $get);
        header('Location: ' . $url);
    }

    /**
     * Returns text by key name
     *
     * @param $key
     *
     * @return string
     */
    public static function lang($key)
    {
        return Service::getLanguage()->get($key);
    }

}
