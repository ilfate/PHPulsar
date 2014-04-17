<?php
/**
 * ILFATE PHP ENGINE
 * @autor Ilya Rubinchik ilfate@gmail.com
 * 2012
 */

namespace App\FrontController;

use App\Helper;
use App\Model\User;
use App\Service;
use Core\Interfaces\FrontController;

/**
 * Description of Service_Auth
 *
 *
 * @author ilfate
 */
class Auth implements FrontController
{
    const SESSION_AUTH_KEY         = 'user_auth';
    const SESSION_AUTH_KEY_EXPIRES = 3600;

    const COOKIE_AUTH_KEY         = 'user_auth';
    const COOKIE_AUTH_KEY_EXPIRES = 0;

    const ALL_METHODS_ARE_PUBLIC = true;

    const PRIORITY = 5;

    /**
     *
     * @var User
     */
    private static $current_user;

    /**
     * List of public routs
     * Class is Key
     * Methods are elements of the array
     *
     * @var array
     */
    private static $public_controllers = array(
        'Main'      => array('index', 'mysql', 'aboutMe', 'cache'),
        'MainPages' => self::ALL_METHODS_ARE_PUBLIC,
        'Error'     => self::ALL_METHODS_ARE_PUBLIC,
        'Auth'      => self::ALL_METHODS_ARE_PUBLIC,
        'Cv'        => self::ALL_METHODS_ARE_PUBLIC,
        'RobotRock' => self::ALL_METHODS_ARE_PUBLIC,
        'Game_Main' => array('index'),
    );

    public static function preExecute()
    {
        // try auth via session
        $request = Service::getRequest();
        if ($session = $request->getSession(self::SESSION_AUTH_KEY)) {
            // if session exists
            if (time() < ($session['time'] + self::SESSION_AUTH_KEY_EXPIRES)) {
                // if seesion if not expired
                $user = User::getByPK($session['id']);
                if ($user) {
                    self::$current_user = $user;
                }
            }
        }
        if (empty(self::$current_user) && $cookie = $request->getCookie(self::COOKIE_AUTH_KEY)) {
            // try auth via cookie
            $user = User::getRecord(array('cookie' => $cookie));
            if ($user) {
                self::$current_user = $user;
            }
        }

        if (empty(self::$current_user)) {
            // it is guest here
            if (!self::isRoutePublic()) {
                Helper::redirect('Auth', 'needRegistration', array('access_restricted' => true));
            }
        }
    }

    public static function postExecute()
    {
    }

    private static function isRoutePublic()
    {
        $class = Service::getRouting()->getClass();
        if (isset(self::$public_controllers[$class])) {
            // ok class is public
            if (self::$public_controllers[$class] === self::ALL_METHODS_ARE_PUBLIC) {
                return true;
            } else {
                $method = Service::getRouting()->getMethod();
                if (in_array($method, self::$public_controllers[$class])) {
                    return true;
                }
            }
        }
        return false;
    }

    private static function saveSession($id_user)
    {
        $session = array(
            'id'   => $id_user,
            'time' => time()
        );
        Service::getRequest()->setSession(self::SESSION_AUTH_KEY, $session);
    }

    public static function isAuth()
    {
        return self::$current_user ? true : false;
    }

    public static function getUser()
    {
        return self::$current_user;
    }

}
