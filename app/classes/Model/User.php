<?php
/**
 * ILFATE PHP ENGINE
 * @autor Ilya Rubinchik ilfate@gmail.com
 * 2012
 */

/*
CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `email` varchar(60) DEFAULT '',
  `password` varchar(120) DEFAULT '',
  `cookie` varchar(60) DEFAULT '',
  `id_social` int(11) UNSIGNED DEFAULT 0,
  `last_visit` int(11) UNSIGNED NOT NULL,
  `registation_time` int(11) UNSIGNED NOT NULL,
  `new_messages` int(11) UNSIGNED default 0,
  PRIMARY KEY (`id`),
  KEY `idx_name` (`name`),
  KEY `idx_email` (`email`),
  KEY `idx_cookie` (`cookie`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8
*/



/**
 * model class 
 *
 * @author ilfate
 */
class Model_User extends Model
{
  const PASS_SALT = 'adG34gWe34hb';
  const PASS_SALT_PRE = 'cXs3';
  
  public static $table_name = 'users';
 
  
  /**
   * creates user by listed params
   * 
   * @param String $email
   * @param String $password
   * @param String $name
   */
  public static function createUserWithEmail($email, $password, $name)
  {
    $user = array(
      'name'              => $name,
      'email'             => $email,
      'password'          => self::encodePassword($password),
      'last_visit'        => time(),
      'registation_time'  => time(),
      'cookie'            => self::genCookie()
    );
    $user['id'] = self::insert($user);
    return new Model_User($user);
  }
  
  /**
   * ecode password to keep it in database
   * 
   * @param type $password
   * @return type
   */
  public static function encodePassword($password)
  {
    return sha1(self::PASS_SALT_PRE . $password . self::PASS_SALT);
  }
  
  /**
   * generate Cookie
   * 
   * @return string
   */
  public static function genCookie()
  {
    return md5(time() + mt_rand(10000,99999));
  }
  
  /**
   * Finds user by email and pass. no magic here. =)
   * 
   * @cache 3000
   * @param String $email
   * @param String $password
   * @return Model_User 
   */
  public static function _getUserByEmailAndPassword($email, $password)
  {
    $pass = self::encodePassword($password);
    return self::getRecord(array('email' => $email, 'password' => $pass));
  }
  
  /**
   * Checks is email exists in table
   *
   * @param String $email
   * @return Boolean 
   */
  public static function isEmailExists($email)
  {
	$list = self::getFields(array('id'), array('email' => $email));
	return !!$list;
  }
  
  /**
   * Checks is name exists in table
   *
   * @param String $name
   * @return Boolean 
   */
  public static function isNameExists($name)
  {
	$list = self::getFields(array('id'), array('name' => $name));
	return !!$list;
  }
}

