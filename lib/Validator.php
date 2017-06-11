<?php
namespace App;

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
