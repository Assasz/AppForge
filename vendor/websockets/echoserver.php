<?php
  require_once "websockets.php";

  class EchoServer extends WebSocketServer
  {
    protected function process($user, $message)
    {
      $exploded_message = explode(" ", $message);
      $data=file_get_contents("data.json", true);
      $json=json_decode($data, true);

      $reply="Sorry, I don't understand :(";

      foreach ($json as $key)
      {
        if(self::matchPattern($exploded_message, $key['pattern']))
        {
          $reply=$key['reply'];
        }
      }

      $this->send($user, $reply);
      echo "Requested resource : " . $user->requestedResource . "n";
    }

    protected function connected ($user)
    {
        $welcome_message = 'Welcome on our website! I\'m here to help you!';
        $this->send($user, $welcome_message);
    }

    protected function closed ($user)
    {
        echo "User closed connectionn";
    }

    private static function matchPattern($exploded_message, $pattern)
    {
      $cleared_message = array();
      $regex = '/[^A-Za-z0-9\-]/';

      foreach ($exploded_message as $value)
      {
        $value = preg_replace($regex, '', mb_strtolower($value));
        array_push($cleared_message, $value);
      }

      if(count(array_intersect($cleared_message, $pattern))>0)
      {
        return true;
      }
      return false;
    }
  }

  $server = new EchoServer('localhost', 8888 );
  $server->run();
 ?>
