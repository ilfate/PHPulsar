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
  public static $table_name = 'users';
  /**
   * @cache 5
   * @return string 
   */
  public function _load($id)
  {
    dump('no cache');
    $user = self::getByPK($id);
    return $user;
  }
}

?>
