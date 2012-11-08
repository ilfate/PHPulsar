<?php
/**
 * ILFATE PHP ENGINE
 * @autor Ilya Rubinchik ilfate@gmail.com
 * 2012
 */

/**
 * model class 
 *
 * @author ilfate
 */
class Model_User extends Model
{
  
  /**
   * @cache 5
   * @return string 
   */
  public function _load()
  {
    dump('no cache');
    return 'aaasd';
  }
}

?>
