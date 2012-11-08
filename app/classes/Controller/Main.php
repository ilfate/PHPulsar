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
	public static function _index() {
        self::cache('aaa', 'bbb', 'ccc');
		return array();
	}
	
  /**
   * @cache 10 tag tag2aw[1] tags t2[2][0]
   * @return type 
   */
	public static function _cache() {
    dump('_cache method. no chache<br>');
		return array();
	}
  
  
  /**
   * 
   * @return type 
   */
  public static function _page()
  {
    return array(
      'tpl' => 'Main/index.tpl'
    );
  }
  
  /**
   * @cache 15
   * @return type 
   */
  public static function _Menu() 
  {
    dump('menu no cahche');
    return array();
  }
  
  public static function flush()
  {
	Cache::flush();
	Helper::redirect(array('Main', 'index'));
  }
}

?>
