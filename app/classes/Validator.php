<?php
/**
 * ILFATE PHP ENGINE
 * @autor Ilya Rubinchik ilfate@gmail.com
 * 2012
 */

/**
 * Validator class 
 *
 * @author ilfate
 */
class Validator
{
  
  private static $errors = array();
  private static $formErrors = array();
  
  private static $error_names = array(
    'email'                   => 'Not valid email',
    'notEmpty'                => 'Field must not be empty',
    'minLength'               => 'Field must contain at least %s letters',
    'maxLength'               => 'Field must contain not more then %s letters',
    'isNumeric'               => 'Field must be numeric',
    'equalField'              => 'Field is not equal to %s field',
    'userEmailUnique'         => 'User with this email is already exists',
    'userNameUnique'          => 'This user name has been taken. Sorry.',
    'authEmailAndPassword'    => 'Email or password are wrong.',
  );
  
  private static $form;
  
  public static function email($value)
  {
    return (empty($value) || preg_match("![a-z0-9._%-]+@[a-z0-9.-]+\.[a-z]{2,4}!i", $value));
  }
  public static function notEmpty($value)
  {
    return !empty($value);
  }
  public static function minLength($value, $param) 
  {
    return (empty($value) || mb_strlen($value, "UTF-8") >= $param);
  }
  public static function maxLength($value, $param) 
  {
    return (empty($value) || mb_strlen($value, "UTF-8") < $param);
  }
  public static function isNumeric($value) 
  {
    return (empty($value) || is_numeric($value));
  }
  public static function equalField($value, $param) 
  {
    return (empty($value) || (isset(self::$form[$param]) && $value == self::$form[$param]));
  }
  public static function userEmailUnique($value)
  {
    return (empty($value) || !Model_User::isEmailExists($value));
  }
  public static function userNameUnique($value)
  {
    return (empty($value) || !Model_User::isNameExists($value));
  }
  public static function authEmailAndPassword($value, $param) 
  {
    if(isset(self::$form[$param])) 
    {
      return Model_User::getUserByEmailAndPassword($value, self::$form[$param]);
    } 
    return false;
  }
  
  /**
   *
   * @param type $value
   * @param array $filters
   * @return boolean 
   */
  public static function validate($value, array $filters)
  {
    foreach ($filters as $filter)
    {
      if(!is_array($filter))
      {
        $param = null;
      } else {
        list($filter, $param) = $filter;
      }
      if(method_exists('Validator', $filter))
      {
        if(!Validator::$filter($value, $param))
        {
          self::addError($filter, $param);
          return false;
        }
      }
    }
    return true;
  }
  
  private static function addError($filter, $param)
  {
	if(isset(self::$error_names[$filter]))
	{
      self::$errors[] = $param ? sprintf(self::$error_names[$filter], $param) : self::$error_names[$filter];
	} else {
	  self::$errors[] = 'Error occurred in form. Please try to fix data.'; 
	}
  }
  
  public static function getLastError()
  {
    return array_pop(self::$errors);
  }
  
  
  public static function validateForm(array $config, array $form = null)
  {
    if(!$form) $form = Request::getPost();
	self::$form = $form;
    foreach ($config as $field_name => $filters)
    {
      if(!isset(self::$form[$field_name]))
      {
        self::$formErrors[] = array('field' => $field_name, 'error' => 'Field not found');
        return false;
      }
      if(!self::validate(self::$form[$field_name], $filters))
      {
        self::$formErrors[] = array('field' => $field_name, 'error' => self::getLastError());
        return false;
      }
    }
    return true;
  }
  
  public static function getFormErrorAnswer()
  {
    $error = array_pop(self::$formErrors);
    return array(
      'sucsses' => false, 
      'actions'  => array('Form.error'),
      'args' => array(array(  
        'field' => $error['field'], 'error' => $error['error']
      ))
    );
  }
 
}

?>
