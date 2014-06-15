<?php
/**
 * ILFATE PHP ENGINE
 * @autor Ilya Rubinchik ilfate@gmail.com
 * 2012
 */

namespace App\Controller;
use App\Cache;
use App\Controller;
use App\Helper;
use App\Logger;
use App\Model\User;
use App\Request;

/**
 * Description of Main
 *
 * @author ilfate
 */
class Main extends Controller
{
    /**
     *
     * @return array
     */
    public function index()
    {
        self::cache('aaa', 'bbb', 'ccc');

        //Model_User::createUserWithEmail('email', 'pass', '$name');

        return array();
    }

    /**
     *
     * @return array
     */
    public function aboutMe()
    {

        return array(
            'mode' => Request::EXECUTE_MODE_HTTP,
            'tpl'  => 'Main/aboutMe.tpl'
        );
    }

    /**
     * @cache 10 tag tag2aw
     * @return array tags t2[2][0]
     */
    public function _cache()
    {
        $this->log->dump('_cache method. no chache<br>');
        return array(
            'tpl' => 'Main/index.tpl'
        );
    }

    public function mysql()
    {
        $userModel = User::getInstance();
        $user       = $userModel->getByPK(3);
        $user->name = 'masha_' . mt_rand(1000, 9999);
        $user->save();
        $users = $userModel->getValue('email', ' id > ?', array(3));
        $this->log->dump($users);
        return array(
            'tpl' => 'Main/index.tpl'
        );
    }

    /**
     *
     * @return array
     */
    public function _page()
    {
        return array(
            'tpl' => 'Main/index.tpl'
        );
    }

    /**
     * @cache 15
     * @return array
     */
    public function _Menu()
    {
        $this->log->dump('menu no cahche');
        return array();
    }

    public function flush()
    {
        $this->cache->flush();
        Helper::redirect('Main', 'index');
    }
}