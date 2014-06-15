<?php
/**
 * ILFATE PHP ENGINE
 * @autor Ilya Rubinchik ilfate@gmail.com
 * 2012
 */

namespace App\Controller;

use App\Controller;
use App\Message;
use App\Model\User;
use App\Request;
use App\Runtime;
use App\Service;
use App\Validator;

/**
 * Description of Auth
 *
 * @author ilfate
 */
class Auth extends Controller
{
    /** @var User  */
    protected $userModel;

    /** Constructor */
    public function __construct()
    {
        parent::__construct();
        $this->userModel = User::getInstance();
    }

    /**
     *
     * @return array
     */
    public function logInForm()
    {
        return array(
            'mode' => Request::EXECUTE_MODE_HTTP,
            'tpl'  => 'Auth/loginForm.tpl',
            ''
        );
    }

    /**
     *
     * @return array
     */
    public function signUpForm()
    {
        return array(
            'mode' => Request::EXECUTE_MODE_HTTP,
            'tpl'  => 'Auth/signUpForm.tpl',
            ''
        );
    }

    /**
     * Submition of the registration form
     *
     * @return array
     */
    public function signUp()
    {
        if (!Validator::validateForm(
            array(
                'email' => array('notEmpty', array('minLength', 3), 'email', 'userEmailUnique'),
                'pass'  => array('notEmpty', array('equalField', 'pass2'), array('minLength', 6)),
                'name'  => array('notEmpty', array('minLength', 4), array('maxLength', 16), 'userNameUnique'),
            )
        )
        ) {
            return Validator::getFormErrorAnswer();
        }

        $post = Service::getRequest()->getPost();
        $user = $this->userModel->createUserWithEmail($post['email'], $post['pass'], $post['name']);
        self::auth($user);
        Message::add('Welcome!!');
        return array(
            'sucsess' => true,
            'actions' => array('Action.refresh'),
        );
    }

    /**
     * @return array
     */
    public function signIn()
    {
        $config = array(
            'email' => array(array('authEmailAndPassword', 'password')),
        );
        if (!Validator::validateForm($config)) {
            return Validator::getFormErrorAnswer();
        }
        $post = Service::getRequest()->getPost();
        $user = $this->userModel->getUserByEmailAndPassword($post['email'], $post['password']);
        self::auth($user);
        Message::add('Hi!!!');
        return array(
            'sucsess' => true,
            'actions' => array('Action.redirect'),
            'args'    => array('/')
        );
    }

    public function logOut()
    {
        Service::getRequest()->setSession(\App\FrontController\Auth::SESSION_AUTH_KEY, null);
        Runtime::setCookie(\App\FrontController\Auth::COOKIE_AUTH_KEY, null, null);
        return array(
            'sucsess' => true,
            'actions' => array('Action.redirect'),
            'args'    => array('/')
        );
    }

    private static function auth(User $user)
    {
        Service::getRequest()->setSession(
            \App\FrontController\Auth::SESSION_AUTH_KEY,
            array('id' => $user->id, 'time' => time())
        );
        Runtime::setCookie(
            \App\FrontController\Auth::COOKIE_AUTH_KEY,
            $user->cookie,
            \App\FrontController\Auth::COOKIE_AUTH_KEY_EXPIRES
        );
    }

    public function needRegistration()
    {
        return array();
    }
}
