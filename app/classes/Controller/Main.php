<?php
/**
 * ILFATE PHP ENGINE
 * @autor Ilya Rubinchik ilfate@gmail.com
 * 2012
 */

/**
 * Description of Main
 *
 * @author ilfate
 */
class Controller_Main extends Controller {
  //put your code here
  
  /**
   * 
   * @return type 
   */
  public function index() 
  {
    self::cache('aaa', 'bbb', 'ccc');
    
        //Model_User::createUserWithEmail('email', 'pass', '$name');
	    
    return array();
  }
  
  /**
   * 
   * @return type 
   */
  public function aboutMe() 
  {
      
    return array(
      'mode' => Request::EXECUTE_MODE_HTTP,
      'tpl' => 'Main/aboutMe.tpl'
    );
  }
  
  /**
   * @cache 10 tag tag2aw[1] tags t2[2][0]
   * @return type 
   */
  public static function _cache() {
    Logger::dump('_cache method. no chache<br>');
    return array();
  }
  
  public function mysql()
  {
    $user = Model_User::getByPK(3);
    //Logger::dump($user->name);
    $user->name = 'masha_' . mt_rand(1000, 9999);
    $user->save();
    //$user2 = new Model_User(array('id' => 6, 'name' => 'ilfate', 'email' => mt_rand(1000, 9999).'@mail.com'));
    //$user2->save();
    $users = Model_User::getValue('email',' id > ?', array(3));
    Logger::dump($users);
//    foreach ($users as $id => $user)
//    {
//      dump('id = '. $id .' name ='.$user->name .' email = '. $user->email.'<br>');
//    }
    return array(
      'tpl' => 'Main/index.tpl'
    );
  }
  
  /**
   * 
   * @return type 
   */
  public function _page()
  {
    return array(
      'tpl' => 'Main/index.tpl'
    );
  }
  
  /**
   * @cache 15
   * @return type 
   */
  public function _Menu() 
  {
    Logger::dump('menu no cahche');
    return array();
  }
  
  public function flush()
  {
  Cache::flush();
  Helper::redirect('Main', 'index');
  }
}

?>
