<?php
namespace App;

class Router
{
  private static $site;

  public static function init()
  {
    self::$site = $_GET['site'] ?? 'home';
    $file = 'inc/'.self::$site.'.php';

    if(file_exists($file))
    {
      require_once 'inc/header.php';
      require_once $file;
      require_once 'inc/footer.php';
    }
    else if(self::$site == 'mailer')
    {
      $mailer = new Mailer();
      $mailer->send();
    }
    else
    {
      require_once 'inc/error.php';
    }
  }

  public static function getTitle()
  {
    return "Company - ".ucfirst(self::$site);
  }
}
?>
