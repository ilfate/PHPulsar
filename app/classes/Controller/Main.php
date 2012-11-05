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
   * @cache 10 tag tag2aw[1] tags
   * @return type 
   */
	public static function _index() {
    dump('index no chache');
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
}

?>
