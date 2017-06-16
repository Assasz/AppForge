<?php
namespace App;
use App\Validator;

class Mailer
{
  private $message;
  private $config;

  public function __construct($config)
  {
    $this->config = $config;
  }

  private function isValid($data)
  {
    $rules = array(
      Validator::validateName($data['name']), Validator::validateEmail($data['email']), Validator::validateMessage($data['message']), Validator::validateAttachment($data['attachment']),
      Validator::validateCaptcha($data['captcha'])
    );

    return Validator::validate($rules);
  }

  public function setMessage($data)
  {
    if($this->isValid($data))
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
