<?php
namespace App;

class Router
{
  private static $site;

  public static function init()
  {
    self::$site = $_GET['site'] ?? 'home';
    $file = 'inc/'.self::$site.'.php';

    if(self::$site == 'mailer')
    {
      require_once "inc/mailer.php";
    }
    else if(file_exists($file))
    {
      require_once 'inc/header.php';
      require_once $file;
      require_once 'inc/footer.php';
    }
    else
    {
      require_once 'inc/error.php';
    }
  }

  public static function getTitle()
  {
    return "AppForge - ".ucfirst(self::$site);
  }
}
?>
