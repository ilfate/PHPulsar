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
  const PASS_SALT = 'adg34gwe34hb';
  
  public static $table_name = 'users';
 
  
  
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
    $id = self::insert($user);
    Logger::dump($id, 'output');
  }
  
  public static function encodePassword($password)
  {
    return sha1($password . self::PASS_SALT);
  }
  
  public static function genCookie()
  {
    return md5(time() + mt_rand(10000,99999));
  }
}

