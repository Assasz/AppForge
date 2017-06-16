<?php
namespace App;
use App\Session;

class Validator
{
  public static function validateName($name)
  {
    $regex = '/[\^<,"@\/\{\}\(\)\0123456789\*\$%\?=>:\|;#]+/i';
    $rules = array(
      strlen($name)>0,
      strlen($name)<=100,
      !preg_match($regex, $name)
    );

    return self::validate($rules);
  }

  public static function validateEmail($email)
  {
    $rules = array(
      filter_var($email, FILTER_VALIDATE_EMAIL)
    );

    return self::validate($rules);
  }

  public static function validateMessage($message)
  {
    $rules = array(
      strlen($message)>0
    );

    return self::validate($rules);
  }

  public static function validateCaptcha($captcha)
  {
    $rules = array(
      $captcha == Session::get('captcha')
    );

    return self::validate($rules);
  }

  public static function validateAttachment($attachment)
  {
    $rules = array(
      $attachment['size'] <= 10485760
    );

    return self::validate($rules);
  }

  public static function validateAjaxRequest()
  {
    $rules = array(
      hash_equals(Session::get('token'), $_POST['token']),
      isset($_SERVER['HTTP_X_REQUESTED_WITH']),
      isset($_SERVER['HTTP_REFERER']),
      $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest',
      $_SERVER['HTTP_REFERER'] == 'http://localhost/bootstrap/contact'
    );

    return self::validate($rules);
  }

  public static function validate($rules)
  {
    foreach ($rules as $rule)
    {
        if(!$rule) return false;
    }

    return true;
  }
}
?>
