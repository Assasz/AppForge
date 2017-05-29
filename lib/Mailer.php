<?php
namespace App;

class Mailer
{
  private $message;
  private $config;

  public function __construct($config)
  {
    $this->config = $config;
  }

  private function validate($data)
  {
    $regex = '/^[\p{Latin}\s]+$/u';
    $cond1 = strlen($data['name'])>100;
    $cond2 = !preg_match($regex, $data['name']);
    $cond3 = str_word_count($data['name'])!=2;
    $cond4 = !filter_var($data['email'], FILTER_VALIDATE_EMAIL);
    $cond5 = strlen($data['message'])<1;
    $cond6 = $data['attachment']['size']!=0;
    $cond7 = $data['attachment']['size']>10485760;
    $cond8 = $data['captcha'] != Session::get('captcha');

    return ($cond1 || $cond2 || $cond3 || $cond4 || $cond5 || ($cond6 && $cond7) || $cond8) ? false : true;
  }

  public function setMessage($data)
  {
    if($this->validate($data))
    {
      $this->message = \Swift_Message::newInstance()
      ->setSubject($this->config['subject'])
      ->setFrom(array($data['email'] => $data['name']))
      ->setTo(array($this->config['email'] => $this->config['name']))
      ->setBody($data['message']."<br><br>E-mail address: ".$data['email'], 'text/html');

      if($data['attachment']['size'] != 0)
      {
        $this->message->attach(\Swift_Attachment::fromPath($data['attachment']['tmp_name'])
        ->setFilename($data['attachment']['name']));
      }
    }
    else
    {
      throw new \Exception("Make sure you provided everything correctly");
    }
  }

  public function send()
  {
    $transport = \Swift_SmtpTransport::newInstance($this->config['server'], $this->config['port'], $this->config['auth'])
    ->setUsername($this->config['username'])
    ->setPassword($this->config['password']);

    $mailer = \Swift_Mailer::newInstance($transport);

    if($mailer->send($this->message))
    {
      echo 'Thank you for message!';
    }
    else
    {
      throw new \Exception("Sending message failed");
    }
  }
}
?>
